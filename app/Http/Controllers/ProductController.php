<?php

namespace App\Http\Controllers;

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
			'description' => 'required'
		]);

		//Para poder guardar un objeto de esta forma los atributos se deben poner como fillables en el modelo
		$product = Product::create(['title' => $request['title'], 'description' => $request['description']]);

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
			'description' => 'required'
		]);

		//Para poder updatear un objeto de esta forma los atributos se deben poner como fillables en el modelo
		$product->update(['title' => $request['title'], 'description' => $request['description']]);

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
}
