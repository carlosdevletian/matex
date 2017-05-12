@extends('layouts.app')

@section('title')
    Matex - About Us
@endsection

@section('content')
<div style="margin-top: -50px;"></div>

<div class="About">
    <div class="container">
        <div class="row">
            <h1 class="col-sm-10 About__title">We Strive to Make Quality Products</h1>
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
                    <td class="About__time__cell">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Necessitatibus accusantium ex repellendus fugiat</td>
                </tr>
                <tr>
                    <td class="About__time__cell">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Necessitatibus accusantium ex repellendus fugiat</td>
                    <td class="About__time__cell--line"><img src="/images/about/about_circle.png" class="img-responsive About__time__image--circle"></td>
                    <td class="About__time__cell"><img src="/images/about/about_assist.png" class="img-responsive About__time__image"></td>
                </tr>
                <tr>
                    <td class="About__time__cell"><img src="/images/about/about_factory.png" class="img-responsive About__time__image"></td>
                    <td class="About__time__cell--line"><img src="/images/about/about_circle.png" class="img-responsive About__time__image--circle"></td>
                    <td class="About__time__cell">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Necessitatibus accusantium ex repellendus fugiat</td>
                </tr>
                <tr>
                    <td class="About__time__cell">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Necessitatibus accusantium ex repellendus fugiat</td>
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
                Lorem ipsum dolor sit amet, consectetur adipisicing
            </h1>
            <img src="/images/about/about_world.png" class="img-responsive" style="max-width: 350px; margin: 0 auto; background-color: white; border-radius: 100%"> 
        </div>
    </div>
</div>
@endsection
