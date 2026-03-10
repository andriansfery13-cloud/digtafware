@component('mail::message')
# Product Update Available: {{ $product->title }}

Hi {{ $user->name }},

Good news! A new version of **{{ $product->title }}** is now available.

**What's New in v{{ $product->version }}:**
{{ $changelog->content }}

@component('mail::button', ['url' => route('dashboard.downloads')])
Download Latest Version
@endcomponent

You can always download the latest files from your dashboard.

Thanks,<br>
{{ config('app.name') }}
@endcomponent