<?php

namespace App\Http\Controllers\Auth;

use App\Models\Design;
use App\Models\Category;
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
        if(session()->has('design') && session()->has('category_id')) {
            $categorySlug = Category::findOrFail(session('category_id'))->slug_name;
            $design = Design::create([
                'image_name' => session('design'), 
                'comment' => session('design_comment'), 
                'views' => session('fpd-views'), 
                'category_id' => session('category_id')
            ]);
            $design->move();
            session([
                'design' => $design->id
            ]);
            session()->forget(['category_id', 'fpd-views', 'design_comment']);
            return route('orders.create', ['category' => $categorySlug]);
        }
        return route('dashboard');
    }
}
