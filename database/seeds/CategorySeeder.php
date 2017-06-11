<?php

use App\Models\Product;
use App\Models\Category;
use App\Models\Accessory;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createBracelets();
        $this->createCalendars();
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

        $bracelet->pricings()->create(['min_quantity' => 50, 'max_quantity' => 99, 'unit_price' => 130]);
        $bracelet->pricings()->create(['min_quantity' => 100, 'max_quantity' => 199, 'unit_price' => 90]);
        $bracelet->pricings()->create(['min_quantity' => 200, 'max_quantity' => 299, 'unit_price' => 85]);
        $bracelet->pricings()->create(['min_quantity' => 300, 'max_quantity' => 499, 'unit_price' => 80]);
        $bracelet->pricings()->create(['min_quantity' => 500, 'max_quantity' => 999, 'unit_price' => 62]);
        $bracelet->pricings()->create(['min_quantity' => 1000, 'max_quantity' => 2999, 'unit_price' => 48]);
        $bracelet->pricings()->create(['min_quantity' => 3000, 'max_quantity' => 4999, 'unit_price' => 36]);
        $bracelet->pricings()->create(['min_quantity' => 5000, 'max_quantity' => 7999, 'unit_price' => 28]);
        $bracelet->pricings()->create(['min_quantity' => 8000, 'max_quantity' => 11999, 'unit_price' => 20]);
        $bracelet->pricings()->create(['min_quantity' => 12000, 'max_quantity' => 15999, 'unit_price' => 18]);
        $bracelet->pricings()->create(['min_quantity' => 16000, 'max_quantity' => 20000, 'unit_price' => 17]);

        $bracelet->enable();
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

        $calendar->pricings()->create(['min_quantity' => 5, 'max_quantity' => 9, 'unit_price' => 2600]);
        $calendar->pricings()->create(['min_quantity' => 10, 'max_quantity' => 19, 'unit_price' => 1800]);
        $calendar->pricings()->create(['min_quantity' => 20, 'max_quantity' => 49, 'unit_price' => 1700]);
        $calendar->pricings()->create(['min_quantity' => 50, 'max_quantity' => 99, 'unit_price' => 1600]);
        $calendar->pricings()->create(['min_quantity' => 100, 'max_quantity' => 199, 'unit_price' => 1240]);
        $calendar->pricings()->create(['min_quantity' => 200, 'max_quantity' => 499, 'unit_price' => 960]);
        $calendar->pricings()->create(['min_quantity' => 500, 'max_quantity' => 999, 'unit_price' => 720]);
        $calendar->pricings()->create(['min_quantity' => 1000, 'max_quantity' => 10000, 'unit_price' => 560]);

        $calendar->enable();
    }
}
