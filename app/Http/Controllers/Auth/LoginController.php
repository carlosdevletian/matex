<?php

namespace App\Http\Controllers\Auth;

use App\Models\Design;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    protected function redirectTo()
    {
        if(session()->has('design_id') && session()->has('category_id')) {
            $categoryId = session('category_id');
            $design = Design::findOrFail(session('design_id'));
            $design->move(auth()->user()->id);
            session()->forget(['design_id', 'category_id']);
            return route('order.create', ['category' => $categoryId, 'design' => $design->id]);
        }
        return route('dashboard');
    }
}
