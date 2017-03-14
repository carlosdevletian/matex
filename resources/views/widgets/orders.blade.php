<div class="col-xs-12 Card" style="height: 40vh">
    <h3 class="color-secondary">Active orders</h3>
    @foreach($orders as $order)
            <div class="row">
                <div class="col-xs-12">
                    <a href="{{ route('orders.show', ['order' => $order->reference_number]) }}" style="color: inherit">
                        <div class="Card Card--half-pd">
                            <p style="display: inline-block;">Order #{{ $order->reference_number }}</p>
                            <div style="display: inline-block; width: 10px; height: 10px; border-radius: 100%; background-color: {{ $order->status->color }}"></div>
                            <p class="mg-0" style="display:inline-block;">{{ $order->status->name }}</p>
                        </div>
                    </a>
                </div>
            </div>
    @endforeach
    <a href="{{ route('orders.index') }}" class="Button--secondary stick-to-bottom">See previous orders</a>
</div>
