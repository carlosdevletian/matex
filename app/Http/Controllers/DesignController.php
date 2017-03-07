<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Design;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DesignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($categorySlug)
    {
        $category = Category::where('slug_name', $categorySlug)->firstOrFail();

        return view('designs.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $design = new Design();
        $category = Category::findOrFail(request()->category_id);
        $filename = $design->makeImage($category);

        if(auth()->check()){
            $design->views = request()->views;
            $design->save();
            session(['design' => $design->id,]);
        }else{
            session(['design' => $filename, 'fpd-views' => request()->views]);
        }
        session(['category_id' => request()->category_id]);


        return response()->json([
            'message' => 'Image successfully generated',
            'category_slug_name' => $category->slug_name
        ],200);
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
    public function edit($id)
    {
        //
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
