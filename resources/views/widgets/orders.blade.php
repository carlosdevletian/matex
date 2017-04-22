<div class="col-xs-12 Card Card--dashboard position-relative pd-btm-50">
    <p class="Card__title">Orders</p>
    @if($orders->count() > 0)
        <order-list :orders="{{ $orders }}"></order-list>
        @if(auth()->user()->hasRole('admin'))
            <a href="{{ route('orders.index', ['client' => $profileUser->email]) }}" class="Button--card stick-to-bottom">ALL ORDERS</a>
        @else
            <a href="{{ route('orders.index') }}" class="Button--card stick-to-bottom">ALL ORDERS</a>
        @endif
    @else
        @if(auth()->user()->hasRole('admin'))
            <p>This user has no orders.</p>
        @else
            <p>No active orders at the moment.</p>
        @endif
    @endif
</div>
