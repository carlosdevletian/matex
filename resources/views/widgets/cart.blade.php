<div class="col-xs-12 Card">
    <p>You have {{ auth()->user()->cart->items->count() }} items in your cart</p>
    <a href="{{ route('carts.show') }}">Go to cart</a>
</div>