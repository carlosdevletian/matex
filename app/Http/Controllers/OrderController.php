<?php

namespace App\Http\Controllers;

use Gate;
use App\Models\Item;
use App\Models\Order;
use App\Models\Design;
use App\Models\Status;
use App\Models\Address;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Events\OrderStatusChanged;
use Illuminate\Support\Facades\File;

class OrderController extends Controller
{
    public function index()
    {
        if(admin()){
            $statuses = Status::all();
            
            if(request()->has('status')){
                $filter = Status::findOrFail(request()->status);
                $orders = Order::where('status_id', $filter->id)->get();
            }else{
                $orders = Order::all();
            }

            return view('orders.admin-index', compact('orders', 'statuses', 'filter'));
        }

        $orders = auth()->user()->orders->sortByDesc('created_at');

        return view('orders.index', compact('orders'));
    }

    public function show($referenceNumber)
    {
        if(admin()){
            $statuses = Status::all();
        }

        $order = Order::with(['items.design' => function($query){
                $query->withTrashed()->addSelect(['id', 'image_name', 'created_at']);
            },'items.product' => function($query) {
                $query->addSelect(['id', 'name', 'category_id']);
            },'items.product.category' => function($query) {
                $query->addSelect(['id', 'name']);
            }, 'status'])
            ->where('reference_number', $referenceNumber)->firstOrFail();

        if($order->belongsToUser()){
            if (Gate::allows('owner', $order)) {
                return view('orders.show', compact('order', 'statuses'));
            }else {
                abort(403, 'Unauthorized action.');
            }
        }

        return view('orders.show', compact('order', 'statuses'));
    }

    public function create($categorySlug, Design $design = null)
    {
        if(! $design->exists && ! session('design')) {
            return redirect()->route('home');
        }
        if($design->exists && ! $design->ownedByUser()){
            return redirect()->route('dashboard');
        }

        $categoryId = Category::where('slug_name', $categorySlug)->firstOrFail()->id;
        $products = Product::activeFrom($categoryId);
        if(auth()->check()) {
            $addresses = Address::where('user_id', auth()->user()->id)->get();
            $design = $design->exists ? $design : Design::findOrFail(session('design'));

            return view('orders.create', [
                'products' => $products, 
                'addresses' => $addresses, 
                'design' => $design->id, 
                'design_image' => $design->image_name
            ]);
        }
        $addresses = collect();

        return view('orders.create', [
            'products' => $products, 
            'addresses' => $addresses, 
            'design' => session('design'), 
            'design_image' => session('design'), 
            'categoryId' => $categoryId
        ]);
    }

    public function update(Order $order)
    {
        $status = Status::findOrFail(request()->status);

        if($order->status_id != $status->id){
            $order->update(['status_id' => $status->id]);
            
            if(request()->has('comment')){
                event(new OrderStatusChanged($order, request()->comment));
            }else{
                event(new OrderStatusChanged($order));
            }
            
            flash()->success('Success','Status changed successfully');
        }else {
            flash()->error('Error','The status of the order did not change');
        }

        return redirect()->back();
    }
}
