<?php

namespace App\Http\Controllers;

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
        $categories = Category::active()->get();

        if(admin()){
            $activeCategories = $categories;
            $inactiveCategories = Category::inactive()->get();
            return view('categories.admin-index', compact('activeCategories', 'inactiveCategories'));
        }

        if($categories->count() == 0) {
            return redirect()->route('home');
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

        $category = new Category();

        $category->addImage(request()->file, request()->name);
        
        $category->name = request()->name; 
        $category->crop_width = request()->cropw; 
        $category->crop_height = request()->croph; 
        $category->crop_x_position = request()->cropx; 
        $category->crop_y_position = request()->cropy;

        $category->save();

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

        if(request()->hasFile('file')){
            $oldImage = $category->image_name;
            $category->addImage(request()->file, request()->name);
            Storage::delete('/public/categories/' . $oldImage);
        }

        $category->update([
            'name' => request()->name, 
            'crop_width' => request()->cropw, 
            'crop_height' => request()->croph, 
            'crop_x_position' => request()->cropx, 
            'crop_y_position' => request()->cropy
        ]);

        $category->updateProducts(request('products'));

        flash()->success('Success!','Changes Made');
        return redirect()->back();
    }

    public function disable(Category $category)
    {
        $category->disable();
    }

    public function enable(Category $category)
    {
        $category->enable();
    }
}
