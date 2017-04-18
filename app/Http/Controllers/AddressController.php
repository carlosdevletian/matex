<?php

namespace App\Http\Controllers;

use Gate;
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
        $addresses = Address::where('user_id', auth()->id())->orderBy('created_at', 'desc');

        if (request()->wantsJson()){
            $addresses = $addresses->get();
            return response()->json(['addresses' => $addresses], 200);
        }
        $addresses = $addresses->simplePaginate(4);
        return view('addresses.index', compact('addresses'));
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
    public function edit(Address $address)
    {
        if (Gate::allows('owner', $address)) {
            return view('addresses.edit', compact('address'));
        }

        abort(403, 'Unauthorized action.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Address $address)
    {
        if (Gate::allows('owner', $address)) {
            $this->validate(request(), [
                'name' => 'required',
                'street' => 'required',
                'city' => 'required',
                'state' => 'required',
                'zip' => 'required|digits:5',
                'country' => 'required',
                'phone_number' => 'required',
                'comment' => 'nullable'
            ]);

            $address->update(request()->all());
            flash()->success('Success!', 'Changes made');
            return back();
        }

        abort(403, 'Unauthorized action.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        if (Gate::allows('owner', $address)) {
            $address->delete();

            return redirect()->route('addresses.index');
        }

        abort(403, 'Unauthorized action.');
    }
}
