<?php

use CodeEduBook\Models\Livro;
use CodeEduBook\Models\Capitulo;
use Illuminate\Database\Seeder;

class CapitulosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $livros = Livro::all();
        foreach ($livros as $livro){
            factory(Capitulo::class, 5)->make()->each(function ($capitulo) use($livro){
                $capitulo-livro_id = $livro->id;
                $capitulo->save();
            });
        }
    }
}
