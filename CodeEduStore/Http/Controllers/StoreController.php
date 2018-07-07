<?php

namespace CodeEduStore\Http\Controllers;

use CodeEduStore\Repositories\CategoriaRepository;
use CodeEduStore\Repositories\OrderRepository;
use CodeEduStore\Repositories\ProdutoRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class StoreController extends Controller
{
    /**
     * @var ProdutoRepository
     */
    private $produtoRepository;
    /**
     * @var CategoriaRepository
     */
    private $categoriaRepository;
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    public function __construct (ProdutoRepository $produtoRepository, CategoriaRepository $categoriaRepository, OrderRepository $orderRepository)
    {

        $this->produtoRepository = $produtoRepository;
        $this->categoriaRepository = $categoriaRepository;
        $this->orderRepository = $orderRepository;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $produtos = $this->produtoRepository->home();
        return view('codeedustore::store.home', compact('produtos'));
    }

    public function categoria($id){
        $categoria = $this->categoriaRepository->find($id);
        $produtos = $this->produtoRepository->findByCategoria($id);
        return view('codeedustore::store.categoria', compact('produtos', 'categoria'));
    }

    public function search(request $request){
        $search = $request->get('search');
        $produtos = $this->produtoRepository->like($search);
        return view('codeedustore::store.search', compact('produtos'));
    }

    public function showProduto($slug){
        $produto = $this->produtoRepository->findBySlug($slug);
        return view('codeedustore::store.show-produto', compact('produto'));
    }

    public function checkout($id){
        $produto = $this->produtoRepository->find($id);
        return view('codeedustore::store.checkout', compact('produto'));
    }

    public function process(Request $request, $id){
        $productStore = $this->produtoRepository->makeProductStore($id);
        $user = $request->user();
        $token = $request->get('stripeToken');
        try{
            $order = $this->orderRepository->process($token,$user,$productStore);
            $status = true;
        }catch(Card $exception){
            $status = false;
        }

        return view('codeedustore::store.process', compact('order','status'));

    }

    public function orders(){

        $user = \Auth::user()->id;

        if($user == 1) {
            $orders = $this->orderRepository->all();
        } else {
            $orders = $this->orderRepository->findWhere(['user_id' => $user]);
        }

        return view('codeedustore::store.orders', compact('orders'));
    }
}
