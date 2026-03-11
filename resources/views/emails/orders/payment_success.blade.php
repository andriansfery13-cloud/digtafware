@component('mail::message')
# Payment Successful!

Hi {{ $order->user->name }},

Great news! We've received your payment for order **#{{ $order->order_number }}**. Your files and license keys are now
available for download.

**Order Total:** Rp {{ number_format($order->total, 0, ',', '.') }}

@component('mail::button', ['url' => route('dashboard.downloads')])
Access Your Downloads
@endcomponent

An invoice for your purchase is also available in your dashboard.

Thanks for choosing us,<br>
{{ config('app.name') }}
@endcomponent