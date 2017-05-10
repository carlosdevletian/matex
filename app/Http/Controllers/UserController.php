<?php

namespace App\Http\Controllers;

use Gate;
use Hash;
use App\Models\Role;
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
        $admin = Role::findByName('admin');
        $owner = Role::findByName('owner');
        $users = User::where('role_id', '!=', $admin->id)
                        ->where('role_id', '!=', $owner->id)
                        ->get();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|exists:roles,id'
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role
        ]);
        flash()->success('Success!', 'The new user was created');
        return redirect()->back();
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

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $user = auth()->user();

        $this->validate(request(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'previous_password' => 'required_with:password',
            'password' => 'nullable|min:6|confirmed',
            'password_confirmation' => 'required_with:password',
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

    public function adminComment(User $user)
    {
        $user->update(['admin_comment' => request('admin_comment')]);
        flash()->success('Success!', 'Note added');
        return back();
    }
}
