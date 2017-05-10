<?php

namespace App\Http\Controllers;

use App\Models\Design;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($categoryId)
    {
        return Product::where('category_id', $categoryId)->get();
    }
}
