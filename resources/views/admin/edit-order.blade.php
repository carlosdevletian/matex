<div class="Card position-relative pd-btm-50">
    <h3>Update order</h3>
    <form method="POST" action="{{ route('orders.update', $order) }}">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT">
        <div class="row">
            <div class="col-xs-6">
                <div class="Card">
                    <h5><strong>Status</strong></h5>
                    <div style="display: inline-block; width: 10px; height: 10px; border-radius: 100%; background-color: {{ $order->status->color }}"></div>
                    <div class="Form__select">
                        <select name="status_id">
                            @foreach($statuses as $status)
                                @if($order->status->id == $status->id)
                                    <option value="{{ $status->id }}" selected>{{ $status->name }}</option>
                                @else
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-xs-6">
                <div class="Card">
                    <h5><strong>Additional Information</strong></h5>
                    <input id="comment"
                        type="text"
                        name="comment"
                        class="Form"
                        placeholder="Add a comment"
                        value="{{ old('comment') }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="Card">
                    <h5><strong>Shipping Details</strong></h5>
                    @if($errors->get('shipping.*'))
                        <div class="alert alert-danger text-center">
                            All fields related to the order's shipping information must be present
                        </div>
                    @endif
                    <input type="text" 
                        class="Form {{ $errors->get('shipping.*') ? 'Form--error' : '' }}" 
                        placeholder="Shipping company, e.g: UPS"
                        value="{{ $order->shipping_company ?: old('shipping.shipping_company') }}"
                        name="shipping[shipping_company]">
                    <input type="text" 
                        class="Form {{ $errors->get('shipping.*') ? 'Form--error' : '' }}" 
                        placeholder="Order's tracking number"
                        value="{{ $order->tracking_number ?: old('shipping.tracking_number') }}"
                        name="shipping[tracking_number]">
                    <input type="text" 
                        class="Form {{ $errors->get('shipping.*') ? 'Form--error' : '' }}" 
                        placeholder="Tracking url, e.g: https://wwwapps.ups.com/WebTracking/track?track=yes&trackNums=1Z8E37090205741541"
                        value="{{ $order->tracking_url ?: old('shipping.tracking_url') }}"
                        name="shipping[tracking_url]">
                </div>
            </div>
        </div>
        <button class="Button Button--primary stick-to-bottom color-white">Update</button>
    </form>
</div>