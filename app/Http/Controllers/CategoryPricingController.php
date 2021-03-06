<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\CategoryPricing as Pricing;

class CategoryPricingController extends Controller
{

    public function index($categoryId)
    {
        $category = Category::findOrFail($categoryId);

        return view('pricings.index', [
            'category' => $category,
            'pricings' => $category->pricings->sortBy('min_quantity')
        ]);
    }
    
    public function store($categoryId, Request $request)
    {
        $this->validator($request->all())->validate();
        
        $category = Category::findOrFail($categoryId);

        Pricing::addToCategory($category, [
            'category_id' => $categoryId,
            'min_quantity' => $request['min_quantity'],
            'unit_price' => $request['unit_price'],
        ]);
        // Redirect
    }

    public function update(Request $request)
    {
        Pricing::validateUnitPrice($request['pricings']);
        
        foreach ($request['pricings'] as $pricingId => $pricingData) {
            $this->validator($pricingData)->validate();
            Pricing::findOrFail($pricingId)->update($pricingData);
        }

        return redirect()->back();
    }

    public function destroy($pricingId)
    {
        Pricing::findOrFail($pricingId)->delete();
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'min_quantity' => "required|integer",
            'unit_price' => 'required|integer'
        ], [
            'unit_price.integer' => 'The unit price must be a valid number'
        ]);
    }
}
