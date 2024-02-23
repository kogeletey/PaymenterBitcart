<?php

use Illuminate\Support\Facades\Route;

Route::post('/bitcart/webhook', [App\Extensions\Gateways\BitCart\BitCart::class, 'webhook']);
