<div class="col-xs-12 Card" style="height: 40vh">
    <h3>Shopping cart</h3>
    <p>You have {{ auth()->user()->cart->items->count() }} items in your cart</p>
    <a href="{{ route('carts.show') }}" class="Button--primary stick-to-bottom">Go to cart</a>
</div>