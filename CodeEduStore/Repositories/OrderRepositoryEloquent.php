<?php

namespace CodeEduStore\Repositories;

use CodeEduStore\Events\OrderPostProcessEvent;
use CodeEduStore\Models\Order;
use CodeEduStore\Models\ProductStore;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Stripe\Invoice;

/**
 * Class OrderRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OrderRepositoryEloquent extends BaseRepository implements OrderRepository
{
    public function model ()
    {
        return Order::class;
    }

    public function boot ()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function process($token,$user,ProductStore $productStore){

        $this->createCustomer($token,$user);

        /** @var Invoice $invoice */
        $invoice = $user->invoiceFor(
            "{$productStore->getId()} {$productStore->getName()}",
            $productStore->getPrice()*100
        );

        $order = $this->create([
            'date_launch' => (new \DateTime())->format('Y-m-d'),
            'price' => $productStore->getPrice(),
            'user_id' => $user->id,
            'invoice_id' => $invoice->id
        ]);

        $order->orderable()->associate($productStore->getProductOriginal());
        $order->save();
        event(new OrderPostProcessEvent($order));
        return $order;

    }
    
    protected function createCustomer($token,$user){
        
        if(!$user->stripe_id){
            $user->createAsStripeCustomer($token);
        }
        
        $user->updateCard($token);
        
    }

}
