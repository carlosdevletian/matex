<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addresses = collect();

        if(auth()->check()) {
            $addresses = Address::where('user_id', auth()->user()->id)->get();
        }

        return response()->json(['addresses' => $addresses], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $newAddress = request()->address;
        if(auth()->check()) {
            $newAddress['user_id'] = auth()->user()->id;
            $address = Address::create($newAddress);
            return response()->json(['address_id' => $address->id], 200);
        }
        $newAddress['email'] = request()->email;
        $address = Address::create($newAddress);
        return response()->json(['address' => $address], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $address = Address::findOrFail($id);
        $data = request()->address;
        $data['email'] = request()->email ?: null;
        $address->update($data);

        return response()->json([], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
