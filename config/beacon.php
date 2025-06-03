<?php

use Outerweb\Beacon\Enums\BeaconEventType;
use Outerweb\Beacon\Http\Controllers\BeaconApiController;
use Outerweb\Beacon\Http\Middleware\BlockBotsMiddleware;
use Outerweb\Beacon\Models\BeaconEvent;

return [
    /**
     * The enums used in this package. You can
     * override them with your own classes
     * if you need to customize them
     */
    'enums' => [
        'event_type' => BeaconEventType::class,
    ],

    /**
     * The models used in this package. You can
     * override them with your own classes
     * if you need to customize them
     */
    'models' => [
        'event' => BeaconEvent::class,
    ],

    /**
     * The middleware used in this package. You
     * can override it with your own class
     * if you need to customize it
     */
    'middleware' => [
        'api' => ['api', BlockBotsMiddleware::class],
    ],

    /**
     * The controllers used in this package. You
     * can override it with your own class
     * if you need to customize it
     */
    'controllers' => [
        'api' => BeaconApiController::class,
    ],
];
