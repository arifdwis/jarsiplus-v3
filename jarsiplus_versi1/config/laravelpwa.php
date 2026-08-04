<?php

return [
    'name' => env('APP_NAME', 'My PWA App'),
    'manifest' => [
        'name' => env('APP_NAME', 'My PWA App'),
        'short_name' => env('APP_NAME', 'My PWA App'),
        'start_url' => '/',
        'background_color' => '#ffffff',
        'theme_color' => '#ffffff',
        'display' => 'standalone',
        'orientation'=> 'any',
        'status_bar'=> 'black',
        'icons' => [
            '72x72' => [
                'path' => '/images/logo-mobile/android/Icon-72.png',
                'purpose' => 'any'
            ],
            '96x96' => [
                'path' => '/images/logo-mobile/android/Icon-96.png',
                'purpose' => 'any'
            ],
            '128x128' => [
                'path' => '/images/logo-mobile/ios/Icon-128.png',
                'purpose' => 'any'
            ],
            '144x144' => [
                'path' => '/images/logo-mobile/android/Icon-144.png',
                'purpose' => 'any'
            ],
            '152x152' => [
                'path' => '/images/logo-mobile/android/Icon-152.png',
                'purpose' => 'any'
            ],
            '192x192' => [
                'path' => '/images/logo-mobile/android/Icon-192.png',
                'purpose' => 'any'
            ],
            '384x384' => [
                'path' => '/images/logo-mobile/android/Icon-384.png',
                'purpose' => 'any'
            ],
            '512x512' => [
                'path' => '/images/logo-mobile/android/Icon-512.png',
                'purpose' => 'any'
            ],
        ],
        'splash' => [
            '640x1136' => '/images/splash/splash-640x1136.png',
            '750x1334' => '/images/splash/splash-750x1334.png',
            '828x1792' => '/images/splash/splash-828x1792.png',
            '1125x2436' => '/images/splash/splash-1125x2436.png',
            '1242x2208' => '/images/splash/splash-1242x2208.png',
            '1242x2688' => '/images/splash/splash-1242x2688.png',
            '1536x2048' => '/images/splash/splash-1536x2048.png',
            '1668x2224' => '/images/splash/splash-1668x2224.png',
            '1668x2388' => '/images/splash/splash-1668x2388.png',
            '2048x2732' => '/images/splash/splash-2048x2732.png',
        ],
        'shortcuts' => [
            [
                'name' => 'Shortcut Link 1',
                'description' => 'Shortcut Link 1 Description',
                'url' => '/shortcutlink1',
                'icons' => [
                    "src" => "/images/icons/icon-72x72.png",
                    "purpose" => "any"
                ]
            ],
            [
                'name' => 'Shortcut Link 2',
                'description' => 'Shortcut Link 2 Description',
                'url' => '/shortcutlink2'
            ]
        ],
        'custom' => []
    ]
];
