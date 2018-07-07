<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(\CodeEduUser\Models\User::class,1)->create([
            'email' => 'marciojsb@editora.com.br'
        ]);

        factory(\CodeEduUser\Models\User::class,1)->create([
            'email' => 'admin@editora.com.br'
        ]);

        factory(\CodeEduUser\Models\User::class,1)->create([
            'email' => 'user@editora.com.br'
        ]);

    }
}