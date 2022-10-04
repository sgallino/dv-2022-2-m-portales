<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuarios')->insert([
            [
                'usuario_id' => 1,
                'email' => 'sara@za.com',
                // El método Hash::make() es el equivalente en Laravel a la función password_hash() de php.
                // Los hashes que genera son 100% compatibles con los generados por dicha función.
                'password' => Hash::make('asdasd'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
