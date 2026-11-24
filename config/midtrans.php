<?php

return [
    'server_key' => env('MIDTRANS_SERVER_KEY', env('KEY_MIDTRANS_SERVER_KEY', 'SB-Mid-server-tB5KOqdg89GtP3Cs~EcidkVy')),
    'client_key' => env('MIDTRANS_CLIENT_KEY', env('KEY_MIDTRANS_CLIENT_KEY', 'SB-Mid-client-tB5KOqdg89GtP3Cs~EcidkVy')),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized' => env('MIDTRANS_IS_SANITIZED', true),
    'is_3ds' => env('MIDTRANS_IS_3DS', true),
];
