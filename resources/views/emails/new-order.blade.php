@component('mail::message')
# A new order has been placed

## Order # {{ $order->reference_number }}

### The order contains the following items:

@component('mail::panel')
@foreach($items as $design => $itemCollection)
<div style="display: flex; align-items: center; justify-content: center; position: relative;">
    <div style=" width: 20%; margin-right: 15px" >
        <img src="{{ route('image_path', ['image' => $design, 'forOrder' => 1]) }}" >
    </div>
    <div>
    @foreach($itemCollection as $item)
    {{ $item->quantity }} {{ $item->product->name }} {{ $item->design->category->name }}
    <br>
    @endforeach
    </div>
</div>
@if($itemCollection->first()->design->comment)
<br>
<div style="text-align: center; background-color: white; color: grey">
{{ $itemCollection->first()->design->comment ?: ''}}
</div>
@endif
@if(!$loop->last)
<hr>
@endif
@endforeach
@endcomponent

@component('mail::button', ["url" => "/orders/{$order->reference_number}"])
View order
@endcomponent

### The designs for the order are attached.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
