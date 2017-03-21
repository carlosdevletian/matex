<?php

namespace App\Models;

use Image;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    protected $fillable = [
        'image_name', 'price', 'user_id', 'email', 'views', 'crop_width', 'crop_height', 'crop_x_position', 'crop_y_position'
    ];

    protected $directory;

    protected $temporaryDirectory;

    public $filepath;

    protected $clientId;

    public function __construct(array $attributes = [])  {
        parent::__construct($attributes); // Eloquent

        $this->directory = storage_path('app/designs');
        is_dir($this->directory) ?: mkdir($this->directory, 0777, true);

        $this->temporaryDirectory = storage_path('app/public/designs');
        is_dir($this->temporaryDirectory) ?: mkdir($this->temporaryDirectory, 0777, true);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function makeImage($category)
    {
        $this->assignFilePath();

        $encoded = substr(request()->base64_image, strpos(request()->base64_image, ",")+1);

        Image::make($encoded)->crop($category->crop_width, $category->crop_height, $category->crop_x_position, $category->crop_y_position)->save($this->filepath);

        return $this->image_name;
    }

    protected function assignFilePath()
    {
        $this->filepath = $this->assignDirectory() . '/' . $this->assignImageName();
    }

    protected function assignDirectory()
    {
        if(auth()->check()){
            $this->clientId = auth()->user()->id;
            $this->user_id = $this->clientId;
            return $this->directory;
        }

        $this->clientId = 0;
        return $this->temporaryDirectory;
    }

    protected function assignImageName()
    {
        return $this->image_name = $this->clientId . '-' . date("YmdHis") . '-' . request()->category_id . '.png';
    }

    public function move()
    {
        if(File::exists($this->temporaryDirectory . '/' . $this->image_name)) {
            File::move($this->temporaryDirectory . '/' . $this->image_name, $this->directory . '/' . $this->changeImageName());
        }
    }

    public function changeImageName()
    {
        if(! auth()->check()){
            return $this->image_name;
        }

        $position = strpos($this->image_name, '-');
        $this->image_name = auth()->user()->id . substr($this->image_name, $position);
        $this->user_id = auth()->user()->id;
        $this->save();
        return $this->image_name;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ownedByUser()
    {
        return (! empty($this->user) && auth()->check() && $this->user->id == auth()->id());
    }
}
