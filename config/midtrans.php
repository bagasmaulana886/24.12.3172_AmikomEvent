<?php

return [
    'server_key' => trim(env('MIDTRANS_SERVER_KEY', '')),
    'client_key' => trim(env('MIDTRANS_CLIENT_KEY', '')),
    'is_production' => filter_var(env('MIDTRANS_IS_PRODUCTION', false), FILTER_VALIDATE_BOOLEAN),
];
