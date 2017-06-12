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
            'pricings' => $category->pricings
        ]);
    }
    
    public function store($categoryId, Request $request)
    {
        $this->validator($request->all())->validate();
        
        $category = Category::findOrFail($categoryId);

        $category->pricings()->create([
            'min_quantity' => $request['min_quantity'],
            'max_quantity' => $request['max_quantity'],
            'unit_price' => $request['unit_price'],
        ]);

        // Redirect
    }

    public function update(Request $request)
    {
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
            'min_quantity' => "required|integer|less_than:max_quantity",
            'max_quantity' => 'required|integer',
            'unit_price' => 'required|integer'
        ]);
    }
}
