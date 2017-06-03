<?php

namespace App\Http\Controllers;

use Storage;
use App\Models\Category;
use App\Models\Accessory;
use Illuminate\Http\Request;

class AccessoryController extends Controller
{
    public function enable(Accessory $accessory)
    {
        return $accessory->enable();
    }

    public function disable(Accessory $accessory)
    {
        return $accessory->disable();
    }

    public function index(Category $category)
    {
        $accessories = Accessory::where('category_id', $category->id)->get();
        $activeAccessories = $accessories->where('is_active', true);
        $inactiveAccessories = $accessories->where('is_active', false);

        return view('accessories.index', compact('category', 'activeAccessories', 'inactiveAccessories'));
    }

    public function create(Category $category)
    {
        return view('accessories.create', compact('category'));
    }

    public function store(Category $category)
    {
        $this->validate(request(), [
            'file' => 'required|image|max:10000',
            'name' => 'required',
            'price' => 'required|integer'
        ]);

        $accessory = new Accessory();
        $accessory->category_id = $category->id;
        $accessory->name = request()->name;
        $accessory->price = request()->price;
        $accessory->addImage(request()->file, request()->name);
        if(request()->active == true) $accessory->is_active = true;
        $accessory->save();

        flash()->success('Success!','Changes Made');
        return redirect()->route('accessories.index', compact('category'));
    }

    public function edit(Accessory $accessory) 
    {
        return view('accessories.edit', compact('accessory'));
    }

    public function update(Accessory $accessory)
    {
        $this->validate(request(), [
            'file' => 'sometimes|required|image|max:10000',
            'name' => 'required',
            'price' => 'required|integer'
        ]);

        if(request()->hasFile('file')){
            $oldImage = $accessory->image_name;
            $accessory->addImage(request()->file, request()->name);
            Storage::delete('/public/accessories/' . $oldImage);
        }

        if(request()->active == true) {
            $accessory->is_active = true;
        }else {
            $accessory->is_active = false;
        }
        
        $accessory->update([
            'name' => request()->name,
            'price' => request()->price
        ]);

        flash()->success('Success!','Changes Made');

        return redirect()->route('accessories.index', ['category' => $accessory->category_id]);
    }
}
