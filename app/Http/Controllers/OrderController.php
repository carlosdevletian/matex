<?php

namespace App\Http\Controllers;

use Gate;
use App\Models\Item;
use App\Models\Order;
use App\Models\Design;
use App\Models\Address;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class OrderController extends Controller
{
    public function index()
    {
        if(admin()){
            $orders = Order::all();

            return view('orders.admin-index', compact('orders'));
        }

        $orders = auth()->user()->orders->sortByDesc('created_at');

        return view('orders.index', compact('orders'));
    }

    public function show($referenceNumber)
    {
        $order = Order::with(['items.design' => function($query){
                $query->addSelect(['id', 'image_name', 'created_at']);
            },'items.product' => function($query) {
                $query->addSelect(['id', 'name', 'category_id']);
            },'items.product.category' => function($query) {
                $query->addSelect(['id', 'name']);
            }, 'status'])
            ->where('reference_number', $referenceNumber)->firstOrFail();

        if($order->belongsToUser()){
            if (Gate::allows('owner', $order)) {
                return view('orders.show', compact('order'));
            }else {
                abort(403, 'Unauthorized action.');
            }
        }

        return view('orders.show', compact('order'));
    }

    public function create($categorySlug, Design $design = null)
    {
        if(! empty($design->id) && ! $design->ownedByUser()){
            return redirect()->route('dashboard');
        }

        $categoryId = Category::where('slug_name', $categorySlug)->firstOrFail()->id;
        $products = Product::where('category_id', $categoryId)->get();
        if(auth()->check()) {
            $addresses = Address::where('user_id', auth()->user()->id)->get();
            $design = $design->id != null ? $design : Design::findOrFail(session('design'));

            return view('orders.create', ['products' => $products, 'addresses' => $addresses, 'design' => $design->id, 'design_image' => $design->image_name]);
        }
        $addresses = collect();

        return view('orders.create', ['products' => $products, 'addresses' => $addresses, 'design' => session('design'), 'design_image' => session('design')]);
    }
}
