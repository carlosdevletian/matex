<?php

namespace App\Models;

use Image;
use App\Models\Traits\HasItems;
use Illuminate\Database\Eloquent\Model;

class Accessory extends Model
{
    use HasItems;

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function imagePath()
    {
        return asset('accessories/'.$this->image_name);
    }

    public function isActive()
    {
        return (bool) $this->is_active;
    }

    public function addImage($file, $name)
    {
        $image = Image::make($file)->resize(null, 1080, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $directory = storage_path('app/public/accessories/');
        is_dir($directory) ?: mkdir($directory, 0777, true);

        $file_name = str_slug($name) . '-' . time() . '.' . $file->extension();
        $path = $directory . $file_name;

        $image->save($path, 85);

        $this->image_name = $file_name;
    }
}
