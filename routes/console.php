<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('app:cancel-old-orders', function () {
    $this->call('app:cancel-old-orders');
})->purpose('Cancel pending orders that are older than 4 hours');

// Schedule the command to run hourly
\Illuminate\Support\Facades\Schedule::command('app:cancel-old-orders')->hourly();
