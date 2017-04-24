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
use App\Filters\OrderFilters;
use App\Events\OrderStatusChanged;
use Illuminate\Support\Facades\File;

class OrderController extends Controller
{
    public function index(OrderFilters $filters)
    {
        if(admin()){
            $statuses = Status::all();
            $orders = Order::latest()->filter($filters)->paginate(10);

            return view('orders.admin-index', compact('orders', 'statuses'));
        }
        $orders = Order::with('items')
                        ->where('user_id', auth()->id())
                        ->latest()
                        ->filter($filters)
                        ->paginate(2);

        return view('orders.index', compact('orders'));
    }

    public function show($referenceNumber)
    {
        if(admin()){
            $statuses = Status::all();
        }

        $order = Order::with(['items.design' => function($query){
                $query->withTrashed()->addSelect(['id', 'image_name', 'created_at']);
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
        $category = Category::where('slug_name', $categorySlug)->firstOrFail();
        if(! $design->exists && ! session('design')) {
            return redirect()->route('home');
        }
        if($design->exists && ! $design->ownedByUser()){
            return redirect()->route('dashboard');
        }
        if(! $category->isActive()) {
            return redirect()->route('home');
        }

        $products = Product::activeFrom($category->id);
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
            'categoryId' => $category->id
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
