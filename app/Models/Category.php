<?php

namespace App\Models;

use Image;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'crop_width', 'crop_height', 'crop_x_position', 'crop_y_position', 'image_name', 'is_active'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
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

    public function imagePath()
    {
        return asset('categories/'.$this->image_name);
    }

    public function enable()
    {
        $this->update(['is_active' => true]);

        foreach ($this->products as $product) {
            $product->enable();
        }
    }

    public function disable()
    {
        $this->update(['is_active' => false]);

        foreach ($this->products as $product) {
            $product->disable();
        }
    }

    /**
     * Scope a query to only include active categories.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    /**
     * Scope a query to only include inactive categories.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', 0);
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
}
