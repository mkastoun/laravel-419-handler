<?php

return [
    'redirect_on_web' => '/',
    'flash_message' => 'Your session has expired. Please try again.',
    'auto_refresh_on_back' => true,
    'json_response' => [
        'message' => 'Session expired. Please try again.',
        'status' => 419,
    ],
];