<?php

use App\Models\Role;
use App\Models\User;
use App\Models\Design;
use App\Models\Status;
use App\Models\Address;
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
        $adminRole = Role::create(['name' => 'admin']);

        $admin = User::create(['name' => 'Alejandro', 'email' => 'alkv93@gmail.com', 'password' => bcrypt('123123'), 'role_id' => $adminRole->id]);

        $address = factory(Address::class)->states('with-user')->create(['user_id' => $admin->id]);

        $category = factory(Category::class)->create([
            'name' => 'Bracelets', 
            'crop_width' => 1077, 
            'crop_height' => 42, 
            'crop_x_position' => 61, 
            'crop_y_position' => 279,
            'image_name' => 'bracelet_image.png']);

        // $category = factory(Category::class)->create([
        //     'name' => 'Calendars',
        //     'image_name' => 'calendar_image.png']);

        factory(Status::class)->create(['name' => 'Payment Pending', 'color' => 'red']);
        factory(Status::class)->create(['name' => 'Payment Approved', 'color' => 'blue']);
        factory(Status::class)->create(['name' => 'Shipping', 'color' => 'yellow']);
        factory(Status::class)->create(['name' => 'Shipped', 'color' => 'orange']);
        factory(Status::class)->create(['name' => 'Delivered', 'color' => 'green']);
        factory(Status::class)->create(['name' => 'Canceled', 'color' => 'black']);

        $design = factory(Design::class)->create(['image_name' => 'test_filename.jpg']);
        
        $product = factory(Product::class)->create(['name' => 'Small', 'category_id' => $category->id, 'display_position' => 1]);
        $product2 = factory(Product::class)->create(['name' => 'Medium', 'category_id' => $category->id, 'display_position' => 2]);
        $product3 = factory(Product::class)->create(['name' => 'Large', 'category_id' => $category->id, 'display_position' => 3]);
        $product4 = factory(Product::class)->create(['name' => 'X-Large', 'category_id' => $category->id, 'display_position' => 4]);
        $product5 = factory(Product::class)->create(['name' => 'XX-Large', 'category_id' => $category->id, 'display_position' => 5]);
    }
}
