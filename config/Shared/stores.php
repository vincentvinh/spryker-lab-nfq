<?php

$stores = [];

if (!empty(getenv('SPRYKER_ACTIVE_STORES'))) {
    $activeStores = array_map('trim', explode(',', getenv('SPRYKER_ACTIVE_STORES')));

    $template = [
        // different contexts
        'contexts' => [
            // shared settings for all contexts
            '*' => [
                'timezone' => 'Europe/Berlin',
                'dateFormat' => [
                    // short date (01.02.12)
                    'short' => 'd/m/Y',
                    // medium Date (01. Feb 2012)
                    'medium' => 'd. M Y',
                    // date formatted as described in RFC 2822
                    'rfc' => 'r',
                    'datetime' => 'Y-m-d H:i:s',
                ],
            ],
            // settings for contexts (overwrite shared)
            'yves' => [],
            'zed' => [
                'dateFormat' => [
                    // short date (2012-12-28)
                    'short' => 'Y-m-d',
                ],
            ],
        ],
        'locales' => [
            // first entry is default
            'en' => 'en_US',
            'de' => 'de_DE',
        ],
        // first entry is default
        'countries' => ['DE', 'AT', 'NO', 'CH', 'ES', 'GB'],
        // internal and shop
        'currencyIsoCode' => 'EUR',
        'currencyIsoCodes' => ['EUR', 'CHF'],
        'queuePools' => [
            'synchronizationPool' => [],
        ],
        'storesWithSharedPersistence' => [],
    ];

    foreach ($activeStores as $store) {
        $stores[$store] = $template;
        $stores[$store]['storesWithSharedPersistence'] = array_diff($activeStores, [$store]);
        $stores[$store]['queuePools']['synchronizationPool'] = array_map(static function ($store) {
            return $store . '-connection';
        }, $activeStores);
    }

    return $stores;
}

$stores['DE'] = [
    // different contexts
    'contexts' => [
        // shared settings for all contexts
        '*' => [
            'timezone' => 'Europe/Berlin',
            'dateFormat' => [
                // short date (01.02.12)
                'short' => 'd/m/Y',
                // medium Date (01. Feb 2012)
                'medium' => 'd. M Y',
                // date formatted as described in RFC 2822
                'rfc' => 'r',
                'datetime' => 'Y-m-d H:i:s',
            ],
        ],
        // settings for contexts (overwrite shared)
        'yves' => [],
        'zed' => [
            'dateFormat' => [
                // short date (2012-12-28)
                'short' => 'Y-m-d',
            ],
        ],
    ],
    'locales' => [
        // first entry is default
        'en' => 'en_US',
        'de' => 'de_DE',
    ],
    // first entry is default
    'countries' => ['DE', 'AT', 'NO', 'CH', 'ES', 'GB'],
    // internal and shop
    'currencyIsoCode' => 'EUR',
    'currencyIsoCodes' => ['EUR', 'CHF'],
    'queuePools' => [
        'synchronizationPool' => [
            'VN-connection',
            'DE-connection',
        ],
    ],
    'storesWithSharedPersistence' => ['VN'],
];

$stores['VN'] = [
    'contexts' => [
        // shared settings for all contexts
        '*' => [
            'timezone' => 'ASIA/HO_CHI_MINH',
            'dateFormat' => [
                // short date (01.02.12)
                'short' => 'd/m/Y',
                // medium Date (01. Feb 2012)
                'medium' => 'd. M Y',
                // date formatted as described in RFC 2822
                'rfc' => 'r',
                'datetime' => 'Y-m-d H:i:s',
            ],
        ],
        // settings for contexts (overwrite shared)
        'yves' => [],
        'zed' => [
            'dateFormat' => [
                // short date (2012-12-28)
                'short' => 'Y-m-d',
            ],
        ],
    ],
    'countries' => ['VN'],
    // internal and shop
    'currencyIsoCode' => 'VND',
    'currencyIsoCodes' => ['VND', 'USD'],
    'locales' => [
        // first entry is default
        'vi' => 'vi_VN',
        'en' => 'en_US',
    ],
        'storesWithSharedPersistence' => ['DE'],
    ] + $stores['DE'];

return $stores;
