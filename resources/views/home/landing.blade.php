<div class="container-fluid Landing">
    <div class="row">
        <div class="col-sm-1 text-center"></div>
        <div class="col-sm-4 text-center">
            <img src="/images/matex_name.png" alt="matex" class="Landing__logo">
            <h3 class="Landing__body">Lorem ipsum dolor sit amet, consectetur adipisicing elit</h3>
        </div>
        <div class="col-sm-6">
            <img src="{{ URL::to("images/home/puls.png") }}" alt="pulsera" class="img-responsive center-block Landing__image" onmousedown="return false">
        </div>
        <div class="col-sm-1 text-center"></div>
    </div>
    <div class="row">
        <div class="col-xs-12 text-center Landing__design">
            <a href="{{ route('designs.create', ['1'] ) }}" class="Button--design">Design your own</a>
        </div>
    </div>
</div>
