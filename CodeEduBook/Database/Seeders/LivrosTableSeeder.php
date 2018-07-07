<?php

use Illuminate\Database\Seeder;
use CodeEduBook\Models\Livro;

class LivrosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categorias = \CodeEduBook\Models\Categoria::all();
        $livroUpload = app(\CodeEduBook\Pub\BookCoverUpload::class);
        $livros = factory(Livro::class, 20)
            ->create()
            ->each(function($livro) use($categorias,$livroUpload) {
                $categoriasRandom = $categorias->random(4);
                $livro->categorias()->sync($categoriasRandom->pluck('id')->all());
                $thumbFileName = "l".rand(1,5).".png";
                $thumbFile = new \Illuminate\Http\UploadedFile(
                    storage_path("app/files/faker/thumbs/$thumbFileName"),$thumbFileName
                );
                $livroUpload->upload($livro,$thumbFile);
            });

        \File::copyDirectory(storage_path('app/livros/template'),storage_path('app/template'));
        \File::deleteDirectory(storage_path('app/livros'));
        \File::copyDirectory(storage_path('app/template'),storage_path('app/livros/template'));
        \File::deleteDirectory(storage_path('app/template'));

        $livros->slice(0,5)->each(function ($livro){
            \Notification::shouldReceive('send')->never();
            $job = (new \CodeEduBook\Jobs\GenerateBook($livro->author,$livro))->onConnection('sync');
            dispatch($job);
        });

    }
}
