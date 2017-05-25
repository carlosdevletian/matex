<?php

namespace App\Models;

use Image;
use App\Models\Category;
use App\Models\Traits\Filterable;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Design extends Model
{
    use SoftDeletes, Filterable;
 
    protected $fillable = [
        'image_name', 'price', 'user_id', 'email', 'views', 'crop_width', 'crop_height', 'crop_x_position', 'crop_y_position', 'category_id', 'comment', 'is_predesigned'
    ];

    protected $dates = ['deleted_at'];

    protected $with = ['category'];

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

    public static function boot()
    {
        parent::boot();    
    
        // When a design is soft-deleted, its items in cart are deleted
        static::deleted(function($design) {
            $design->itemsInCart()->delete();
        });
    } 

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function scopePreexisting($query)
    {
        return $query->where('is_predesigned', true);
    }

    public function scopeCategoryActive($query)
    {
        return $query->whereHas('category', function($q){ 
                    $q->active();
                });
    }

    public static function selectForShop($take = 5)
    {
        $results = collect();
        foreach(Category::active()->get() as $category) {
            $designs = self::preexisting()
                        ->where('category_id', $category->id)
                        ->take($take)
                        ->get();
            if($designs->count() > 0) {
                $results[$category->name] = $designs;
            }
        }
        return $results;
    }

    public function makeImage($category, $predesigned = false)
    {
        $this->assignFilePath();

        if($predesigned) {
            Image::make(request()->file)->save($this->filepath);
        }else {
            $encoded = substr(request()->base64_image, strpos(request()->base64_image, ",")+1);
            Image::make($encoded)->crop($category->crop_width, $category->crop_height, $category->crop_x_position, $category->crop_y_position)->save($this->filepath);
        }


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
        return (! empty($this->user) && auth()->check() && $this->user_id == auth()->id());
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public static function fromCategory($userId, $categoryId)
    {
        return self::with('category')
            ->where('user_id', $userId)
            ->where('category_id', $categoryId)
            ->get();
    }

    public function changeNameAndMove($user)
    {
        $oldDirectory = $this->directory . '/' . $this->image_name;
        
        if(File::exists($oldDirectory)) {
            $position = strpos($this->image_name, '-');
            $this->image_name = $user->id . substr($this->image_name, $position);
            $this->save();

            File::move($oldDirectory, $this->directory . '/' . $this->image_name);
        }
    }

    public function itemsInCart()
    {
        return $this->items()->whereNotNull('cart_id');
    }

    public function getImagePath()
    {
        return "{$this->directory}/{$this->image_name}";
    }
}
