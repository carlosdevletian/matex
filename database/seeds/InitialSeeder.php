<?php

use App\Models\User;
use App\Models\Design;
use App\Models\Product;
use App\Models\Category;
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

        $category = factory(Category::class)->create(['name' => 'Bracelets']);
        
        $design = factory(Design::class)->create(['image_name' => 'test_filename.jpg']);
        
        $product = factory(Product::class)->create(['name' => 'Small', 'category_id' => $category->id]);
        $product2 = factory(Product::class)->create(['name' => 'Medium', 'category_id' => $category->id]);
        $product3 = factory(Product::class)->create(['name' => 'Large', 'category_id' => $category->id]);
    }
}
