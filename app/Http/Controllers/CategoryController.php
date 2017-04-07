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

        $this->updateCategoryProducts(request('products'), $category);

        flash()->success('Success!','Changes Made');
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

    private function updateCategoryProducts($request, $category)
    {
        return collect($request)->transpose()->map(function ($productData, $key) use($category) {
            if($productData[0] && $product = Product::find($productData[0])) {
                return $this->updateProduct($product, $productData, $key);
            }
            return $this->createProduct($productData, $category->id, $key);
        });
    }

    private function createProduct ($data, $categoryId, $displayPosition) 
    {
        // validar información del producto nuevo?
        if(!$data[1] || !$data[2] || !$data[3] || !$data[4] ) {
            return;
        }
        return Product::create([
            'name' => $data[1],
            'width' => $data[2],
            'length' => $data[3],
            'is_active' => (boolean) $data[4],
            'category_id' => $categoryId,
            'display_position' => $displayPosition
        ]);
    }

    private function updateProduct ($product, $data, $displayPosition) 
    {
        // validar información de alguna forma?
        $product->update([
            'name' => $data[1],
            'width' => $data[2],
            'length' => $data[3],
            'is_active' => (boolean) $data[4],
            'display_position' => $displayPosition
        ]);
        return $product;
    }
}
