<nav class="navbar navbar-default navbar-fixed-top {{ auth()->check() ? '' : 'navbar-primary' }} {{ Route::currentRouteName() == 'home' && !auth()->check() ? 'navbar-home' : '' }} {{ Route::currentRouteName() == 'about' && !auth()->check() ? 'navbar-about' : ''}}">
	<div class="container">
		<div class="navbar-header">
			<button id="header-button" type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
                @if(Route::currentRouteName() == 'home' || Route::currentRouteName() == 'about')
                    <span class="icon-bar" style="background-color: white"></span>
                    <span class="icon-bar" style="background-color: white"></span>
                    <span class="icon-bar" style="background-color: white"></span>
                @else
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                @endif
			</button>
			<a  href="{{ route('home') }}">
				<img class="navbar-logo" src="{{ URL::to('images/matex.png') }}" alt="logo" height="28" onmousedown="return false"/>
			</a>
		</div>
		<div id="navbar" class="collapse navbar-collapse navbar-home">
			<ul class="nav navbar-nav {{ Route::currentRouteName() == 'home' && !auth()->check() ? 'navbar-home' : '' }} {{ Route::currentRouteName() == 'about' && !auth()->check() ? 'navbar-about' : ''}}">
				<li><a href="{{ route('about') }}">About</a></li>
                @if(admin())
                    <li><a href="{{ route('categories.index') }}">Categories</a></li>
                @else
                    <li><a href="{{ route('categories.index') }}">Design your own</a></li>
                    <li><a href="{{ route('shop.index') }}">Shop</a></li>
                @endif
                @unless(admin())
                    <li><a @click="openContactModal()" role="button">Contact Us</a></li>
                    <li><a href="{{ route('faq') }}">FAQ</a></li>
                @endunless
			</ul>
            <ul class="nav navbar-nav navbar-right {{ Route::currentRouteName() == 'home' && !auth()->check() ? 'navbar-home' : '' }} {{ Route::currentRouteName() == 'about' && !auth()->check() ? 'navbar-about' : '' }}">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    <li><a href="{{ url('/register') }}">Register</a></li>
                @else
                    @unless(admin())
                        <li @mouseover="showCartPreview = true" @mouseleave="showCartPreview = false">
                            <a href="{{ route('carts.show') }}">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                            </a>
                            <div class="hidden-xs" v-show="showCartPreview"
                                v-cloak 
                                style="position: absolute; top: 45px; right: 24%; z-index: 2">
                                    @include('carts.preview')
                            </div>
                        </li>
                    @endunless
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            @unless(admin())
                                <li><a href="{{ route('addresses.index') }}">Addresses</a></li>
                            @endunless
                            <li>
                                <a href="{{ route('users.edit', ['user' => auth()->user()->email]) }}">Edit Profile</a>
                            </li>
                            <li>
                                <a href="{{ url('/logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
		</div>
	</div>
    @if(auth()->check())
        <div class="container-fluid navbar-secondary">
            <div class="row">
                <a href="{{ route('dashboard') }}" class="navbar-secondary-link">
                    <div class="col-xs-4 col-sm-2 col-sm-offset-3 navbar-secondary-button navbar-secondary-button-left navbar-secondary-padding {{ Route::currentRouteName() == 'dashboard' ? 'navbar-secondary-active' : ''}}">
                        My Account
                    </div>
                </a>
                <a href="{{ route('orders.index') }}" class="navbar-secondary-link">
                    <div class="col-xs-4 col-sm-2 navbar-secondary-button navbar-secondary-padding {{ Route::currentRouteName() == 'orders.index' ? 'navbar-secondary-active' : ''}}">
                        Orders
                    </div>
                </a>
                @if (admin())
                    <a href="{{ route('users.index') }}" class="navbar-secondary-link">
                        <div class="col-xs-4 col-sm-2 navbar-secondary-button navbar-secondary-padding {{ Route::currentRouteName() == 'users.index' ? 'navbar-secondary-active' : ''}}">
                            Clients
                        </div>
                    </a>
                @else
                    <a href="{{ route('designs.index') }}" class="navbar-secondary-link">
                        <div class="col-xs-4 col-sm-2 navbar-secondary-button navbar-secondary-padding {{ Route::currentRouteName() == 'designs.index' ? 'navbar-secondary-active' : ''}}">
                            Designs
                        </div>
                    </a>
                @endif
            </div>
        </div>
    @endif
</nav>
@if(auth()->check())
    <div class="navbar-secondary-body"></div>
@endif
