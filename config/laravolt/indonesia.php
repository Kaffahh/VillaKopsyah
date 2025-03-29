<?php

return [
    'table_prefix' => '',
    'table_names' => [
        'provinces' => 'provinces',
        'regencies' => 'cities',
        'districts' => 'districts',
        'villages' => 'villages',
    ],
    'route' => [
        'enabled' => false,
        'middleware' => ['web', 'auth'],
        'prefix' => 'indonesia',
    ],
    'view' => [
        'layout' => 'ui::layouts.app',
    ],
    'menu' => [
        'enabled' => false,
    ],
];
