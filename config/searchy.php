<?php

return [

    'default' => 'fuzzy',

    'fieldName' => 'relevance',

    'drivers' => [

        'matching' => [
            'class' => '\App\Services\SearchExactMatcher',
        ],

        'admin_article' => [
            'class' => '\App\Services\SearchInStringMatcher',
        ],

        'en' => [
            'class' => 'TomLingham\Searchy\SearchDrivers\FuzzySearchDriver',
        ],

        'zh' => [
            'class' => 'TomLingham\Searchy\SearchDrivers\FuzzySearchUnicodeDriver',
        ],

        'simple' => [
            'class' => 'TomLingham\Searchy\SearchDrivers\SimpleSearchDriver',
        ],

        'levenshtein' => [
            'class' => 'TomLingham\Searchy\SearchDrivers\LevenshteinSearchDriver',
        ],

    ],

];
