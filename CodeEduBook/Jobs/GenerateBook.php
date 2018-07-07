<?php

namespace CodeEduBook\Jobs;

use CodeEduBook\Models\Livro;
use CodeEduBook\Pub\BookExport;
use CodeEduUser\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;

class GenerateBook implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, Queueable;
    /**
     * @var Livro
     */
    private $livro;
    /**
     * @var User
     */
    private $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, Livro $livro)
    {
        //
        $this->livro = $livro;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(BookExport $bookExport)
    {
        $bookExport->export($this->livro);
        $easyBookCmd = "easybook/book publish --no-interaction --dir={$this->livro->disk} {$this->livro->id}";
        exec("php ".base_path("$easyBookCmd print"));
        exec("php ".base_path("$easyBookCmd kindle"));
        exec("php ".base_path("$easyBookCmd ebook"));
        $bookExport->compress($this->livro);
        /*throw new \Exception("Job falhou!!!");
        $this->fail($exeception);
        throw $exeception;*/
    }
}
