<div class="col-xs-12 Card Card--dashboard--half-size pd-btm-50">
    <img class="Icon img img-responsive" src="{{ URL::to('images/address.png') }}" alt="address">
    <p class="Card__title">Addresses</p>
    <p class="Card__body">You have {{ auth()->user()->addresses()->count() }} {{ str_plural('address', auth()->user()->addresses()->count()) }}</p>
    <a href="{{ route('addresses.index') }}" class="Button--card stick-to-bottom">MANAGE</a>
</div>