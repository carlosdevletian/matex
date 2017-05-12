<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admins.index', [
                    'admins' => User::withTrashed()->haveRole('admin')->get()
                ]);
    }

    public function destroy(User $user)
    {
        if (! $user->hasRole('admin')) return back();
        $user->delete();
        flash()->success('Success!', 'The admin was deleted');
        return back();
    }
}
