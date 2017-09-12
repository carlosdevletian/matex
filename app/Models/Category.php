<?php

namespace App\Models;

use Image;
use App\Events\ProductsToggled;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'crop_width', 'crop_height', 'crop_x_position', 'crop_y_position', 'image_name', 'is_active', 'disclaimer'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('accessoryCount', function($builder) {
            $builder->withCount('accessories');
        });
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower( str_singular($value) );
        $this->attributes['slug_name'] = str_slug($value);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function designs()
    {
        return $this->hasMany(Design::class);
    }

    public function accessories()
    {
        return $this->hasMany(Accessory::class);
    }

    public function pricings()
    {
        return $this->hasMany(CategoryPricing::class);
    }

    public function activeAccessories()
    {
        return $this->accessories()->where('is_active', true);
    }

    public function updateProducts($request)
    {
        $products = collect($request)->transpose()->map(function ($productData, $key){
            if($productData[0] && $product = Product::find($productData[0])) {
                return $product->updateFromRequest($productData, $key);
            }
            return Product::newProduct($productData, $this->id, $key);
        });
        if($this->countActive($products) == 0) $this->disable();
        return $products;
    }

    public function imagePath()
    {
        return asset('categories/'.$this->image_name);
    }

    public function isActive()
    {
        return $this->is_active && $this->activeProducts()->count() > 0;
    }

    public function enable()
    {
        $this->update(['is_active' => true]);
        $this->products->each->enable();
    }

    public function disable()
    {
        $this->update(['is_active' => false]);
        $this->products->each->disable();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1)
                    ->whereHas('products', function($q){
                        $q->active();
                    });
    }

    public function scopeInactive($query)
    {
        return $query->whereDoesntHave('products', function($q) {
                        $q->active();
                    })->orWhere('is_active', 0);
    }

    public function activeProducts()
    {
         return $this->products()->active();
    }

    public function pricingsInPesos()
    {
        $rate = CurrencyRate::where('currency_code', 'COP')->firstOrFail();

        return $this->pricings->map(function($pricing) use ($rate) {
            $pricing->unit_price = $pricing->toRate($rate);
            return $pricing;
        });
    }

    public function addImage($file, $name)
    {
        $image = Image::make($file)->resize(null, 1080, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $directory = storage_path('app/public/categories/');
        is_dir($directory) ?: mkdir($directory, 0777, true);

        $file_name = str_slug($name) . '-' . time() . '.' . $file->extension();
        $path = $directory . $file_name;

        $image->save($path, 85);

        $this->image_name = $file_name;
    }

    private function countActive($products)
    {
        $countedProducts = collect();
        foreach ($products as $product) {
            if($product && $product->is_active) {
                $countedProducts[] = $product;
            }
        }
        return $countedProducts->count();
    }

    public function template()
    {
        return URL::to("images/design_templates/" . $this->template_name);
    }
}
