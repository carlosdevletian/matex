<?php

namespace App\Http\Controllers;

use App\Models\Design;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopCategoryController extends Controller
{
    public function index($categorySlug)
    {
        $category = Category::where('slug_name', $categorySlug)->firstOrFail();
        return view('shop.categories.index', [
            'category' => $category,
            'designs' => Design::preexisting()->where('category_id', $category->id)->paginate(15)
        ]);
    }
}
