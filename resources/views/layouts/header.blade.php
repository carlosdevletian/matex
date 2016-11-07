<nav class="navbar navbar-default navbar-static-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a  href="{{ route('home') }}">
				<img class="navbar-logo" src="{{ URL::to("images/logo-xs.png") }}" alt="logo" height="28" onmousedown="return false"/>
			</a>
		</div>
		<div id="navbar" class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li><a href="{{ route('home') }}">About</a></li>
				<li><a href="{{ route('home') }}">Contact</a></li>
			</ul>
		</div>
	</div>
</nav>
