<?php

use App\Models\Role;
use App\Models\User;
use App\Models\Status;
use App\Models\Address;
use App\Models\Product;
use App\Models\Category;
use App\Models\Accessory;
use Illuminate\Database\Seeder;
use App\Models\CurrencyRate as Rate;

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

        factory(Status::class)->create(['name' => 'Payment Pending', 'color' => 'red']);
        factory(Status::class)->create(['name' => 'Payment Approved', 'color' => 'blue']);
        factory(Status::class)->create(['name' => 'Manufacturing', 'color' => 'yellow']);
        factory(Status::class)->create(['name' => 'Shipped', 'color' => 'orange']);
        factory(Status::class)->create(['name' => 'Delivered', 'color' => 'green']);
        factory(Status::class)->create(['name' => 'Canceled', 'color' => 'black']);

        factory(Rate::class)->create(['currency_code' => 'COP', 'to_dollar' => 3000]);

        $this->createBracelets();
        $this->createCalendars();
        $this->createBusinessCards();
    }

    private function createBracelets()
    {
        $bracelet = factory(Category::class)->create([
            'name' => 'bracelet',
            'crop_width' => 1077,
            'crop_height' => 42,
            'crop_x_position' => 61,
            'crop_y_position' => 279,
            'image_name' => 'bracelet_image.png',
            'template_name' => 'bracelet.png'
        ]);

        factory(Accessory::class)->create(['name' => 'ribbon', 'category_id' => $bracelet->id, 'image_name' => 'epa', 'is_active' => true]);
        factory(Accessory::class)->create(['name' => 'hook', 'category_id' => $bracelet->id, 'image_name' => 'epa', 'is_active' => true]);

        factory(Product::class)->create(['name' => 'small', 'category_id' => $bracelet->id, 'display_position' => 1]);
        factory(Product::class)->create(['name' => 'medium', 'category_id' => $bracelet->id, 'display_position' => 2]);
        factory(Product::class)->create(['name' => 'large', 'category_id' => $bracelet->id, 'display_position' => 3]);
        factory(Product::class)->create(['name' => 'x-large', 'category_id' => $bracelet->id, 'display_position' => 4]);
        factory(Product::class)->create(['name' => 'xx-Large', 'category_id' => $bracelet->id, 'display_position' => 5]);

        $bracelet->pricings()->create(['min_quantity' => 50, 'unit_price' => 130]);
        $bracelet->pricings()->create(['min_quantity' => 100, 'unit_price' => 90]);
        $bracelet->pricings()->create(['min_quantity' => 200, 'unit_price' => 85]);
        $bracelet->pricings()->create(['min_quantity' => 300, 'unit_price' => 80]);
        $bracelet->pricings()->create(['min_quantity' => 500, 'unit_price' => 62]);
        $bracelet->pricings()->create(['min_quantity' => 1000, 'unit_price' => 48]);
        $bracelet->pricings()->create(['min_quantity' => 3000, 'unit_price' => 36]);
        $bracelet->pricings()->create(['min_quantity' => 5000, 'unit_price' => 28]);
        $bracelet->pricings()->create(['min_quantity' => 8000, 'unit_price' => 20]);
        $bracelet->pricings()->create(['min_quantity' => 12000, 'unit_price' => 18]);
        $bracelet->pricings()->create(['min_quantity' => 16000, 'unit_price' => 17]);

        $bracelet->enable();
    }

    private function createBusinessCards()
    {
        $businessCard = factory(Category::class)->create([
            'name' => 'business card',
            'crop_width' => 360,
            'crop_height' => 200,
            'crop_x_position' => 420,
            'crop_y_position' => 199,
            'image_name' => 'business_card_image.png',
            'template_name' => 'business-card.png'
        ]);

        factory(Product::class)->create(['name' => 'small', 'category_id' => $businessCard->id, 'display_position' => 1]);
        factory(Product::class)->create(['name' => 'medium', 'category_id' => $businessCard->id, 'display_position' => 2]);

        $businessCard->pricings()->create(['min_quantity' => 50, 'unit_price' => 130]);
        $businessCard->pricings()->create(['min_quantity' => 100, 'unit_price' => 90]);
        $businessCard->pricings()->create(['min_quantity' => 200, 'unit_price' => 85]);
        $businessCard->pricings()->create(['min_quantity' => 300, 'unit_price' => 80]);
        $businessCard->pricings()->create(['min_quantity' => 500, 'unit_price' => 62]);
        $businessCard->pricings()->create(['min_quantity' => 1000, 'unit_price' => 48]);

        $businessCard->enable();
    }

    private function createCalendars()
    {
        $calendar = factory(Category::class)->create([
            'name' => 'calendar',
            'crop_width' => 283,
            'crop_height' => 510,
            'crop_x_position' => 458,
            'crop_y_position' => 64,
            'image_name' => 'calendar.png',
            'template_name' => 'calendar.png'
        ]);

        factory(Accessory::class)->create(['name' => 'hook', 'category_id' => $calendar->id, 'image_name' => 'epa', 'is_active' => true]);
        factory(Accessory::class)->create(['name' => 'thing', 'category_id' => $calendar->id, 'image_name' => 'epa', 'is_active' => true]);

        factory(Product::class)->create(['name' => 'small', 'category_id' => $calendar->id, 'display_position' => 1]);
        factory(Product::class)->create(['name' => 'medium', 'category_id' => $calendar->id, 'display_position' => 2]);

        $calendar->pricings()->create(['min_quantity' => 5, 'unit_price' => 2600]);
        $calendar->pricings()->create(['min_quantity' => 10, 'unit_price' => 1800]);
        $calendar->pricings()->create(['min_quantity' => 20, 'unit_price' => 1700]);
        $calendar->pricings()->create(['min_quantity' => 50, 'unit_price' => 1600]);
        $calendar->pricings()->create(['min_quantity' => 100, 'unit_price' => 1240]);
        $calendar->pricings()->create(['min_quantity' => 200, 'unit_price' => 960]);
        $calendar->pricings()->create(['min_quantity' => 500, 'unit_price' => 720]);
        $calendar->pricings()->create(['min_quantity' => 1000, 'unit_price' => 560]);

        $calendar->enable();
    }
}
