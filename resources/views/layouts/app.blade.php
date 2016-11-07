<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1,shrink-to-fit=no">

        <!-- SEO -->
        {{-- <meta name="description" content="Guava - Diseño y desarrollo de páginas y aplicaciones web. Creamos experiencias inolvidables que se adaptan a tus necesidades.">
        <meta name="keywords" content="Guava, Desarrollo, Pagina, Paginas, Aplicacion, Web, Internet, Diseno, Grafico, Contratar, Servicio, Caracas, Venezuela">
        <meta name="author" content="Guava">
        <meta property="og:title" content="Guava - Diseño y desarrollo de páginas y aplicaciones web." />
		<meta property="og:description" content="Creamos experiencias inolvidables que se adaptan a tus necesidades." />
		<meta property="og:url" content="http://www.guavadevelopment.com/" />
		<meta property="og:image" content="http://www.guavadevelopment.com/images/share.png" />
		<meta property="og:type" content="website" />
		<meta property="og:site_name" content="Guava" />
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@guavadev" />
        <meta name="twitter:creator" content="@guavadev" /> --}}

        <!-- Chrome Bar Color -->
    	<meta name="theme-color" content="#FFFFFF" />

        <title>@yield('title')</title>

        <!-- Styles -->
        <link href="{{ URL::to('css/app.css') }}" rel="stylesheet">

        @stack('styles')
    </head>
    <body>
        <header>
            @include('layouts.header')
        </header>

        @yield('content')

        <footer>
            @include('layouts.footer')
        </footer>

        <!-- Scripts -->
        <script src="{{ URL::to('js/app.js') }}"></script>

        @stack('unique_scripts')
    </body>
</html>
