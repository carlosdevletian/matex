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
    public function create(Category $category)
    {
        return view('designs.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $directory = storage_path('app/designs');
        if (! is_dir($directory) ) {
            mkdir($directory, 0777, true);
        }
        $encoded = substr($request->base64_image, strpos($request->base64_image, ",")+1);

        $user = 0;
        if (auth()->check()) {
            $user = auth()->user()->id;
        }

        $filename = $user . '-' . date("YmdHis") . '-' . $request->category_id . '.png';
        $filepath = $directory . '/' . $filename;

        Image::make($encoded)->crop(1077, 43, 61, 279)->save($filepath);

        if(! File::exists($filepath)) {
            return response()->json([
                'message' => 'Error'
            ],500);
        } 

        $design = Design::create([
            'image_name' => $filename,
            'price' => 0
            // Falta agregar el comentario introducido por el usuario
        ]);
    
        return response()->json([
            'message' => 'Image successfully generated',
            'design_id' => $design->id,
            'category_id' => $request->category_id
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
