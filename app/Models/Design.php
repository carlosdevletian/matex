<?php

namespace App\Models;

use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    protected $fillable = [
        'image_name', 'price', 'user_id', 'email'
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function move($userId = '')
    {
        if(File::exists(storage_path('app/public/designs/' . $this->image_name))) {
            $directory = storage_path('app/designs');
            if (! is_dir($directory) ) {
                mkdir($directory, 0777, true);
            }
            File::move(storage_path('app/public/designs/' . $this->image_name), $directory . '/' . $this->changeImageName($userId));
        }
    }

    public function changeImageName($userId)
    {
        if(! $userId){
            return $this->image_name;
        }

        $pos = strpos($this->image_name, '-');
        $this->image_name = $userId . substr($this->image_name, $pos);
        $this->save();
        return $this->image_name;
    }
}
