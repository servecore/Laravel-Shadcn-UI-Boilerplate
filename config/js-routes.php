<?php

// Named routes exposed to the frontend via the app-config JSON script tag.
// Add new entity routes here — no Blade changes required.
return [
    'users' => [
        'index' => 'users.index',
        'store' => 'users.store',
    ],
];
