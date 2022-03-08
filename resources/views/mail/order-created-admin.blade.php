@component('mail::message')
# Order Created

An order has been created on Market Place Produce's online ordering platform.

## Order {{ $order->id }}

Estimated Delivery: {{ $order->deliver_at->format('m/d/Y') }}

Address: {{ $order->customer->address }}

@component('mail::table')
| Product ID | Product | Quantity |
|------------|---------|---------:|
@foreach ($order->products as $product)
| {{ $product->id }} | {{ $product->name }} | {{ $product->pivot->quantity }} |
@endforeach
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
