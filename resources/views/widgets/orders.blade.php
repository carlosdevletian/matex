<div class="col-xs-12 Card position-relative pd-btm-50">
    <h3 class="color-secondary">Active orders</h3>
    @if($orders->count() > 0)
        <order-list :orders="{{ $orders }}"></order-list>
        <a href="{{ route('orders.index') }}" class="Button--secondary stick-to-bottom color-white">See previous orders</a>
    @else
        <p>No active orders at the moment.</p>
    @endif
</div>
