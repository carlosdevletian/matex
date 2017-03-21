<div class="col-xs-12 Card pd-btm-50">
    <img class="Icon img img-responsive" src="{{ URL::to('images/cart.png') }}" alt="cart">
    <h3 class="color-primary">Shopping cart</h3>
    <p>You have {{ auth()->user()->cart->items->count() }} items in your cart</p>
    <a href="{{ route('carts.show') }}" class="Button--primary stick-to-bottom color-white">Go to cart</a>
</div>