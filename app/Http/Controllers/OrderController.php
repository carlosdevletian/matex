<?php

namespace App\Http\Controllers;

use Gate;
use App\Models\Item;
use App\Models\Order;
use App\Models\Status;
use App\Models\Design;
use App\Models\Address;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Filters\OrderFilters;
use App\Models\RegisterToken;
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

    public function show($referenceNumber, RegisterToken $token = null)
    {
        if(admin()){
            $statuses = Status::all();
        }

        $order = Order::show($referenceNumber);

        if($order->belongsToUser()){
            if (Gate::allows('owner', $order)) {
                return view('orders.show', compact('order', 'statuses'));
            }else {
                abort(403, 'Unauthorized action.');
            }
        }

        if($token && ($token->email == $order->email || admin())) {
            return view('orders.show', compact('order', 'statuses', 'token'));
        }

        abort(403, 'Unauthorized action');
    }

    public function create($categorySlug, Design $design = null)
    {
        $category = Category::where('slug_name', $categorySlug)->firstOrFail();
        if($redirect = $this->isUnauthorized($design, $category)) return $redirect;

        if($design->exists && $design->is_predesigned) {
            $predesigned = "/1";
        }else {
            $predesigned = "";
        }

        $categoryPricings = [
            $category->name => $category->pricingsInPesos()->sortBy('min_quantity')->values()
        ];

        if(auth()->check()) {
            $design = $design->exists ? $design : Design::findOrFail(session('design'));

            return view('orders.create', [
                'products' => Product::activeFrom($category->id),
                'addresses' => Address::where('user_id', auth()->user()->id)->get(),
                'design' => $design->id,
                'design_image' => $design->image_name,
                'predesigned' => $predesigned,
                'categoryPricings' => $categoryPricings
            ]);
        }

        $orderDesign = $design->exists ? $design->id : session('design');
        $design_image = $design->exists ? $design->image_name : session('design');

        return view('orders.create', [
            'products' => Product::activeFrom($category->id),
            'addresses' => collect(),
            'design' => $design,
            'design_image' => $design_image,
            'categoryId' => $category->id,
            'predesigned' => $predesigned,
            'categoryPricings' => $categoryPricings
        ]);
    }

    public function update(Order $order)
    {
        $this->validate(request(), [
            'status_id' => 'required',
            'shipping.shipping_company' => 'required_with:shipping.tracking_number,shipping.tracking_url',
            'shipping.tracking_number' => 'required_with:shipping.shipping_company,shipping.tracking_url',
            'shipping.tracking_url' => 'required_with:shipping.shipping_company,shipping.tracking_number',
        ]);

        $status = Status::findOrFail(request()->status_id);

        $order->update([
           'status_id' => $status->id,
           'responsible_id' => auth()->id(),
           'shipping_company' => request('shipping.shipping_company') ?: null,
           'tracking_number' => request('shipping.tracking_number') ?: null,
           'tracking_url' => request('shipping.tracking_url') ?: null
        ]);

        event(new OrderStatusChanged($order, request('comment')));

        flash()->success('Success','Status changed successfully');

        return redirect()->back();
    }

    private function isUnauthorized($design, $category)
    {
        if(!$design->is_predesigned){
            if(! $design->exists && ! session('design')) return redirect()->route('home');
            if($design->exists && ! $design->ownedByUser())return redirect()->route('dashboard');
        }
        if(! $category->isActive()) return redirect()->route('home');

        return;
    }
}
