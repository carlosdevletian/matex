<?php

namespace App\Http\Controllers;

use App\Models\Design;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Design $design = null)
    {
        if(! empty($design->id) && ! $design->ownedByUser()){
            return redirect()->route('dashboard');
        }

        $categories = Category::all();

        if(admin()){
            return view('categories.admin-index', compact('categories'));
        }

        if($categories->count() == 1){
            $category = $categories->first()->slug_name;

            if(empty($design->id)){
                return redirect()->route('designs.create', compact('category'));
            }

            return redirect()->route('orders.create', compact('category', 'design'));
        }

        return view('categories.index', ['categories' => $categories, 'design' => $design->id]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
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
