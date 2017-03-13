<div class="col-xs-12 Card">
    @foreach($orders as $order)
            <div class="row">
                <div class="col-xs-12">
                    <a href="{{ route('orders.show', ['order' => $order->reference_number]) }}">
                        <div class="Card Card--half-pd">
                            <p style="display: inline-block;">Order #{{ $order->reference_number }}</p>
                            <div style="display: inline-block; width: 10px; height: 10px; border-radius: 100%; background-color: {{ $order->status->color }}"></div>
                            <p class="mg-0" style="display:inline-block;">{{ $order->status->name }}</p>
                        </div>
                    </a>
                </div>
            </div>
    @endforeach
    <a href="{{ route('orders.index') }}">See previous orders</a>
</div>
