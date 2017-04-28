@component('mail::message')

<h1 style="text-align: center;">Your Matex order has been updated:</h1>
<h1 style="text-align: center; font-style: italic">"{{ $order->status->name }}"</h1>

@if($comment)
<p style="text-align: center; font-style: italic">"{{ $comment }}"</p>
@endif

@if($order->shipping_company)
@component('mail::promotion')
<h3>Shipping details</h3>
<p style="text-align: left">Shipping company: UPS</p>
<p style="text-align: left">Tracking Number: ishdf249fhfjsdfn48932f4fnf</p>
<p style="margin: 0; padding: 0;">
    <a href="www.ups.com/epajoe/tracking_number=ishdf249fhfjsdfn48932f4fnf" 
        class="matex-link">
        Track your package
    </a>
</p>
@endcomponent
@endif

<p style="margin: 0; padding: 0;">
    <a href="{{ route('orders.show', $order) }}" class="matex-link">
        Order # {{ $order->reference_number }}
    </a>
</p>
@component('mail::promotion')
@foreach($items as $design => $itemCollection)
<div class="table">
    <tr style="text-align: center">
        <td rowspan="{{ $itemCollection->count() + 1 }}"><img src="{{ route('image_path', ['image' => $itemCollection->first()->design->image_name, 'forOrder' => 1]) }}" style="width: 30px; height: 30px;"></td>
    </tr>
    @foreach($itemCollection as $item)
    <tr>
        <td style="text-align: center">{{ $item->quantity }} {{ $item->product->name }} {{ $item->design->category->name }}</td>
        <!-- <td style="text-align: center">${{ $item->present()->unit_price }}</td> -->
        <td style="text-align: right">${{ $item->present()->total_price }}</td>
    </tr>
    @endforeach
@unless($loop->last)
    <tr>
        <td style="border-bottom: 1px solid lightgrey"></td>
        <td style="border-bottom: 1px solid lightgrey"></td>
        <td style="border-bottom: 1px solid lightgrey"></td>
    </tr>
@endunless
</div>
@endforeach
<tr>
    <td style="border-bottom: 1px solid lightgrey"></td>
    <td style="border-bottom: 1px solid lightgrey"></td>
    <td style="border-bottom: 1px solid lightgrey"></td>
</tr>
<div class="table">
   <!--  <tr>
        <td style="text-align: left">Subtotal</td>
        <td></td>
        <td style="text-align: right">${{ $order->present()->subtotal }}</td>
    </tr>
    <tr>
        <td style="text-align: left">Tax</td>
        <td></td>
        <td style="text-align: right">${{ $order->present()->tax }}</td>
    </tr>
    <tr>
        <td style="text-align: left">Shipping</td>
        <td></td>
        <td style="text-align: right">${{ $order->present()->shipping }}</td>
    </tr> -->
    <tr>
        <td style="text-align: left">Total</td>
        <td></td>
        <td style="text-align: right">${{ $order->present()->total }}</td>
    </tr>
</div>
@endcomponent

@if(! empty($token))
## We noticed you don't have an account with us
@component('mail::button', ["url" => "/register/token/{$token}"])
Create an account
@endcomponent
@endif

@component('mail::button', ["url" => $orderUrl])
Go to order
@endcomponent

<h3 style="text-align: center">If you have any questions, you can <a class="matex-link" href={{ 'mailto:' . config('mail.customer-support.address') }}>contact us!</a></h3>

<p style="text-align: center">Thanks, <br><strong>{{ config('app.name') }}</strong></p>

@endcomponent