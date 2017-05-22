<?php

use App\Models\Role;
use App\Models\User;
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
        $userRole = Role::create(['name' => 'user']);
        $ownerRole = Role::create(['name' => 'owner']);

        $admin = User::create(['name' => 'Admin', 'email' => 'admin@gmail.com', 'password' => bcrypt('123123'), 'role_id' => $adminRole->id]);
        $owner = User::create(['name' => 'Owner', 'email' => 'owner@gmail.com', 'password' => bcrypt('123123'), 'role_id' => $ownerRole->id]);
        $user = User::create(['name' => 'User', 'email' => 'user@gmail.com', 'password' => bcrypt('123123'), 'role_id' => $userRole->id]);

        $address = factory(Address::class)->states('with-user')->create(['user_id' => $user->id]);

        $bracelet = factory(Category::class)->create([
            'name' => 'bracelet', 
            'crop_width' => 1077, 
            'crop_height' => 42, 
            'crop_x_position' => 61, 
            'crop_y_position' => 279,
            'image_name' => 'bracelet_image.png',
            'template_name' => 'bracelet.png'
        ]);

        $calendar = factory(Category::class)->create([
            'name' => 'calendar', 
            'crop_width' => 283, 
            'crop_height' => 510, 
            'crop_x_position' => 458, 
            'crop_y_position' => 64,
            'image_name' => 'calendar.png',
            'template_name' => 'calendar.png'
        ]);

        factory(Status::class)->create(['name' => 'Payment Pending', 'color' => 'red']);
        factory(Status::class)->create(['name' => 'Payment Approved', 'color' => 'blue']);
        factory(Status::class)->create(['name' => 'Manufacturing', 'color' => 'yellow']);
        factory(Status::class)->create(['name' => 'Shipped', 'color' => 'orange']);
        factory(Status::class)->create(['name' => 'Delivered', 'color' => 'green']);
        factory(Status::class)->create(['name' => 'Canceled', 'color' => 'black']);
        
        $product = factory(Product::class)->create(['name' => 'small', 'category_id' => $calendar->id, 'display_position' => 1]);
        $product2 = factory(Product::class)->create(['name' => 'medium', 'category_id' => $calendar->id, 'display_position' => 2]);
        
        $product = factory(Product::class)->create(['name' => 'small', 'category_id' => $bracelet->id, 'display_position' => 1]);
        $product2 = factory(Product::class)->create(['name' => 'medium', 'category_id' => $bracelet->id, 'display_position' => 2]);
        $product3 = factory(Product::class)->create(['name' => 'large', 'category_id' => $bracelet->id, 'display_position' => 3]);
        $product4 = factory(Product::class)->create(['name' => 'x-large', 'category_id' => $bracelet->id, 'display_position' => 4]);
        $product5 = factory(Product::class)->create(['name' => 'xx-Large', 'category_id' => $bracelet->id, 'display_position' => 5]);
    }
}
