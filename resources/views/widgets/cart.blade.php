<div class="col-xs-12 Card Card--dashboard--half-size pd-btm-50">
    <img class="Icon img img-responsive" src="{{ URL::to('images/cart.png') }}" alt="cart">
    <p class="Card__title">Shopping Cart</p>
    <p class="Card__body">You have {{ auth()->user()->cart->availableItems()->count() }} {{ str_plural('item', auth()->user()->cart->availableItems()->count()) }} in your cart</p>
    <a href="{{ route('carts.show') }}" class="Button--card stick-to-bottom">GO TO CART</a>
</div>