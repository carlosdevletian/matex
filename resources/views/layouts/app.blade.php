<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1,shrink-to-fit=no">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

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

        <link href="https://fonts.googleapis.com/css?family=Amiko|Baloo" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ URL::to('css/app.css') }}" rel="stylesheet">

        <!-- Scripts -->
        <script>
            var Matex = {
                csrfToken: "{{ csrf_token() }}",
                // stripeKey: "{{ config('services.stripe.key') }}",
            }
        </script>

        @stack('styles')
    </head>
    <body>
        <div id="app">
            <!-- <div v-bind:class="{ Blur: modalActive }"> -->
                <header>
                    @include('layouts.header')
                </header>

                @yield('content')

                <footer>
                    @include('layouts.footer')
                </footer>
            <!-- </div> -->

            @include('components.modals')

            <!-- Scripts -->
            <script src="{{ URL::to('js/app.js') }}"></script>

            @include('layouts.flash')

            @stack('scripts')
        </div>
    </body>
</html>
