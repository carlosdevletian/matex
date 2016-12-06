<nav class="navbar navbar-default navbar-fixed-top {{ Route::currentRouteName() == 'home' ? 'navbar-home' : '' }}">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a  href="{{ route('home') }}">
				<img class="navbar-logo" src="{{ URL::to('images/matex.png') }}" alt="logo" height="28" onmousedown="return false"/>
			</a>
		</div>
		<div id="navbar" class="collapse navbar-collapse navbar-home">
			<ul class="nav navbar-nav {{ Route::currentRouteName() == 'home' ? 'navbar-home' : '' }}">
				<li><a href="{{ route('about') }}">About</a></li>
				<li><a @click=" { openContactModal() } " role="button">Contact Us</a></li>
			</ul>
            <ul class="nav navbar-nav navbar-right {{ Route::currentRouteName() == 'home' ? 'navbar-home' : '' }}">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Login</a></li>
                @else
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ url('/register') }}">Register New User</a>
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
</nav>
