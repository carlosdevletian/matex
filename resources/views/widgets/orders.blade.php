<div class="col-xs-12 Card Card--dashboard position-relative pd-btm-50">
    <img class="Icon img img-responsive" src="{{ URL::to('images/order.png') }}" alt="orders">
    <p class="Card__title">Orders</p>
    @if($orders->count() > 0)
        <order-list :orders="{{ $orders }}"></order-list>
        @if(auth()->user()->hasRole('admin'))
            <a href="{{ route('orders.index', ['client' => $profileUser->email]) }}" class="Button--secondary stick-to-bottom color-white">See all orders</a>
        @else
            <a href="{{ route('orders.index') }}" class="Button--card stick-to-bottom">ALL ORDERS</a>
        @endif
    @else
        <p>No active orders at the moment.</p>
    @endif
</div>
