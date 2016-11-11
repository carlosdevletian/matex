<?php

namespace App\Http\Controllers;

use Image;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Solo pueden modificar productos los usuarios
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'DESC')->simplePaginate(10);
		return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
			'title' => 'required|max:120',
			'description' => 'required',
            'file' => 'file|max:10000|mimes:gif,jpg,jpeg,png'
		]);

        if ($request->hasFile('file')) {
            $path = $this->storeImage($request->file);
        } else {
            $path = null;
        }

		//Para poder guardar un objeto de esta forma los atributos se deben poner como fillables en el modelo
		$product = Product::create(['title' => $request['title'], 'description' => $request['description'], 'file' => $path]);

        flash()->success('Listo', 'El producto ha sido creado');

        return redirect()->route('products.show', compact('product'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {
		return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit($product)
    {
		return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $product)
    {
        $this->validate($request,[
			'title' => 'required|max:120',
			'description' => 'required',
            'file' => 'file|max:10000|mimes:gif,jpg,jpeg,png'
		]);

        if ($request->hasFile('file')) {
            $path = $this->storeImage($request->file);
        } else {
            if($request->has('remove-cover')){
                $path = null;
            }else {
                $path = $product->file;
            }
        }

		//Para poder updatear un objeto de esta forma los atributos se deben poner como fillables en el modelo
		$product->update(['title' => $request['title'], 'description' => $request['description'], 'file' => $path]);

        flash()->success('Listo', 'El producto ha sido actualizado');

        return redirect()->route('products.show', compact('product'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($product)
    {
        if($product->delete()){
            flash()->success('Listo', 'El producto ha sido eliminado');

            return redirect()->action('ProductController@index');
        }

        flash()->success('Error', 'El producto no pudo ser eliminado. Por favor intente nuevamente');

        return back();
    }

    /**
     * Store an image from a request.
     *
     * @return String $path
     */
    public function storeImage($file)
    {
        //Create Image from Request and resizing to a height of 1080
        $image = Image::make($file)->resize(null, 1080, function ($constraint) {
    		$constraint->aspectRatio();
    		$constraint->upsize();
    	});

        //Create unique path to image
        $directory = 'images/products/';
        $file_name = md5($image) . '.' . $file->extension();
        $path = $directory . $file_name;

        //Make sure directory exists
        if (!is_dir('images/products/'))
        {
            mkdir('images/products/', 0777, true);
        }

        //Save image (Move if its a gif because intervention does not support it)
        if($file->extension() == 'gif'){
            $file->move($directory, $file_name);
        } else {
            //85 represents the image quality (from 100 being best to 0)
            $image->save($path, 85);
        }

        return $path;
    }
}
