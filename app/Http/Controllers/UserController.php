<?php

namespace App\Http\Controllers;

use Gate;
use Hash;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->hasRole('admin')){
            $users = User::all();

            return view('users.index', compact('users'));
        }
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = auth()->user();

        if (Gate::allows('user', $user)) {
            return view('users.edit', compact('user'));
        }

        abort(403, 'Unauthorized action.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $user)
    {
        $user = auth()->user();

        if (Gate::allows('user', $user)) {
            $this->validate(request(), [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $user->id,
                'previous_password' => 'required_with:password',
                'password' => 'nullable|min:6|confirmed',
            ]);

            if(request()->has('previous_password') && ! Hash::check(request()->previous_password, $user->password)){
                return redirect()->back()->withErrors(['previous_password' => 'Your old password does not match']);
            }

            if(request()->has('password')){
                $user->password = bcrypt(request()->password);
            }

            $user->update(request()->except(['password']));

            return redirect()->route('dashboard');
        }

        abort(403, 'Unauthorized action.');
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
