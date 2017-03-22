<?php

namespace App\Http\Controllers;

use Image;
use Storage;
use App\Models\Design;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        if(admin()){
            return view('categories.admin-index', compact('categories'));
        }

        if($categories->count() == 1){
            $category = $categories->first()->slug_name;

            return redirect()->route('designs.create', compact('category'));
        }

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validate(request(), [
            'name' => 'required',
            'cropw' => 'required|integer',
            'croph' => 'required|integer',
            'cropx' => 'required|integer',
            'cropy' => 'required|integer',
            'file' => 'required|image|max:10000'
        ]);

        $file = request()->file;

        $image = Image::make($file)->resize(null, 1080, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $directory = storage_path('app/public/categories/');
        is_dir($directory) ?: mkdir($directory, 0777, true);

        $file_name = md5(uniqid($image->basename)) . '.' . $file->extension();
        $path = $directory . $file_name;

        $image->save($path, 85);

        $category = Category::create(['name' => request()->name, 
                          'crop_width' => request()->cropw, 
                          'crop_height' => request()->croph, 
                          'crop_x_position' => request()->cropx, 
                          'crop_y_position' => request()->cropy,
                          'image_name' => $file_name]);

        return redirect()->route('categories.edit', ['category' => $category->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Category $category)
    {
        $this->validate(request(), [
            'name' => 'required',
            'cropw' => 'required|integer',
            'croph' => 'required|integer',
            'cropx' => 'required|integer',
            'cropy' => 'required|integer',
            'file' => 'sometimes|required|image|max:10000'
        ]);

        // Meter todo esto en una clase? $file_name = new ImageSaver(request()->file)->save() ?
        if(request()->hasFile('file')){
            $file = request()->file;

            $image = Image::make($file)->resize(null, 1080, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $directory = storage_path('app/public/categories/');
            is_dir($directory) ?: mkdir($directory, 0777, true);

            $file_name = md5(uniqid($image->basename)) . '.' . $file->extension();
            $path = $directory . $file_name;

            $image->save($path, 85);

            Storage::delete('/public/categories/' . $category->image_name);

            $category->image_name = $file_name;
        }

        $category->update(['name' => request()->name, 
                          'crop_width' => request()->cropw, 
                          'crop_height' => request()->croph, 
                          'crop_x_position' => request()->cropx, 
                          'crop_y_position' => request()->cropy]);

        $modifier = 1;

        foreach (request()->products as $key => $product) {
            if(! empty($product)){
                $originalProduct = Product::find(request()->ids[$key]);
                
                if(empty($originalProduct)){
                    Product::create(['name' => $product, 
                                    'category_id' => $category->id, 
                                    'display_position' => $key + $modifier]);
                }else{
                    $originalProduct->update(['name' => $product, 
                                             'display_position' => $key + $modifier]);
                }
            }else {
                $modifier--;
            }
        }

        flash()->success('Success','Changes Made');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
