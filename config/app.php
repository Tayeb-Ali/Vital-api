<?php


$classes = [

    'locale' => env('APP_LOCALE', 'en'),
    'App' => Illuminate\Support\Facades\App::class,
    'Bus' => Illuminate\Support\Facades\Bus::class,
    'Hash' => Illuminate\Support\Facades\Hash::class,
    'Request' => Illuminate\Support\Facades\Request::class,
];

foreach ($classes as $alias => $class) {
    if (! class_exists($alias)) {
        class_alias($class, $alias);
    }
}
