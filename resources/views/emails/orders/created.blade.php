@component('mail::message')
# Order Confirmation - {{ $order->order_number }}

Hi {{ $order->user->name }},

Thank you for your order! We've received it and are waiting for payment confirmation.

**Order Details:**
- Date: {{ $order->created_at->format('M d, Y') }}
- Total: Rp {{ number_format($order->total, 0, ',', '.') }}

@component('mail::table')
| Item | Price |
| :--------- | :------------ |
@foreach($order->items as $item)
    | {{ $item->product->title }} | Rp {{ number_format($item->price, 0, ',', '.') }} |
@endforeach
@endcomponent

@if($order->payment_method == 'manual')
    Please complete your payment via Bank Transfer and upload the proof of payment on your dashboard.
@endif

@component('mail::button', ['url' => route('dashboard.orders.show', $order->id)])
View Order Status
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent