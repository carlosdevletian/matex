@component('mail::message')
# A new order has been placed.

<h2 style="color: #0000aa; text-align: center">
     Order # {{ $order->reference_number }}
</h2>
<div style="text-align: center">
@if($user = $order->user)
{{ $user->email }} <br>
{{ $user->name }} <br>
{{ $user->business or '' }}
@else
{{ $order->email }} <br>
{{ $order->address->name }}
@endif
</div>
<br>
The order contains the following items:

@component('mail::promotion')

@foreach($items as $design => $itemCollection)
<div class="table">
    <tr style="text-align: right">
        <td rowspan="{{ $itemCollection->count() + 1 }}"><img src="{{ route('image_path', ['image' => $itemCollection->first()->design->image_name, 'forOrder' => 1]) }}" style="width: 30px; height: 30px;"></td>
    </tr>
@foreach($itemCollection as $item)
    <tr>
        <td></td>
        <td style="text-align: center">{{ $item->quantity }} {{ $item->product->name }} {{ $item->design->category->name }}</td>
        <!-- <td style="text-align: center">${{ $item->present()->unit_price }}</td> -->
        <!-- <td style="text-align: right">${{ $item->present()->total_price }}</td> -->
    </tr>
@endforeach
@if($itemCollection->first()->design->comment)
    <tr>
        <td colspan="3" style="text-align: center; border: 1px solid grey; font-style: italic">
            "{{ $itemCollection->first()->design->comment }}"
        </td>
    </tr>
@endif
@unless($loop->last)
    <tr>
        <td style="border-bottom: 1px solid lightgrey"></td>
        <td style="border-bottom: 1px solid lightgrey"></td>
        <td style="border-bottom: 1px solid lightgrey"></td>
    </tr>
@endunless
</div>
@endforeach
@endcomponent

@component('mail::button', ["url" => $orderUrl])
View order
@endcomponent

### The designs for the order are attached.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
