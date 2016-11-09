<?php

use App\User;
use App\Product;
use Illuminate\Database\Seeder;

class InitialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create(['name' => 'Alejandro', 'email' => 'alkv93@gmail.com', 'password' => bcrypt('123123')]);

        $product = Product::create(['title' => 'Producto de prueba', 'description' => 'Este es un producto de prueba para comprobar que funciona el modulo de productos']);
    }
}
