<div class="container-fluid Footer">
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="Footer__title">
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('about') }}">About</a>
                <a href="{{ route('categories.index') }}">Design</a>
                <a href="{{ route('login') }}">Your Account</a>  
            </div>
            <div class="Footer__subtitle">
                <p>&copy; 2017 Matex</p>
                <p>All Rights Reserved</p>
            </div>
            <div class="Footer__social">
                <a href="https://www.instagram.com/">
                    <i class="fa fa-instagram" aria-hidden="true"></i>
                </a>
                <a href="https://www.facebook.com/">
                    <i class="fa fa-facebook-square" aria-hidden="true"></i>
                </a>
            </div>
            <div class="Footer__guava">
    			<a href="http://www.guavadevelopment.com/">
                    Made by
                    <img class="img" src="{{ URL::to("images/guava.png") }}" alt="contact" height="14" onmousedown="return false"/>
                </a>
            </div>
        </div>
    </div>
</div>
