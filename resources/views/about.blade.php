@extends('layouts.app')

@section('title')
    Matex - About Us
@endsection

@section('content')
<div style="margin-top: -50px;"></div>

<div class="About">
    <div class="container">
        <div class="row">
            <h1 class="col-sm-10 About__title">
                We strive to make quality products
            </h1>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2 About__quote neg-marg-top">our process...</div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <table class="About__time">
                <tr>
                    <td class="About__time__cell"><img src="/images/about/about_design.png" class="img-responsive About__time__image"></td>
                    <td class="About__time__cell--line"><img src="/images/about/about_circle.png" class="img-responsive About__time__image--circle"></td>
                    <td class="About__time__cell">
                        It all starts with you! <br>Design your ideal product or choose from beautiful existing templates. Make sure to check out our <a href="{{ route('faq') }}">design guidelines</a>.
                    </td>
                </tr>
                <tr>
                    <td class="About__time__cell">
                        Our professional team will look over your design and make sure it's perfect. Don't worry, if we see something out of place we'll get in touch right away.
                    </td>
                    <td class="About__time__cell--line"><img src="/images/about/about_circle.png" class="img-responsive About__time__image--circle"></td>
                    <td class="About__time__cell"><img src="/images/about/about_assist.png" class="img-responsive About__time__image"></td>
                </tr>
                <tr>
                    <td class="About__time__cell"><img src="/images/about/about_factory.png" class="img-responsive About__time__image"></td>
                    <td class="About__time__cell--line"><img src="/images/about/about_circle.png" class="img-responsive About__time__image--circle"></td>
                    <td class="About__time__cell">
                        Our state of the art looms will weave your dream designs.
                    </td>
                </tr>
                <tr>
                    <td class="About__time__cell">
                        A red package full of fun will arrive to your door.
                    </td>
                    <td class="About__time__cell--line"><img src="/images/about/about_circle.png" class="img-responsive About__time__image--circle"></td>
                    <td class="About__time__cell"><img src="/images/about/about_shipping.png" class="img-responsive About__time__image"></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2 About__quote" style="border-color: #0000AA; color: #0000AA;">our background...</div>
    </div>
</div>
<div class="About--background neg-marg-top">
    <div class="container" style="">
        <div class="row">
            <h1 class="col-sm-12 About__title About__title--secondary" style="color: #0000AA">
                Weaving is our thing
            </h1>
            <h3 class="text-center">
                Labels, calendars, ribbons, and much more. 
                We have been weaving quality narrow fabrics in Latin America for industrial corporations for over three decades.
            </h3>
            <img src="/images/about/about_world.png" class="img-responsive" style="max-width: 350px; margin: 0 auto; background-color: white; border-radius: 100%"> 
        </div>
    </div>
</div>
@endsection
