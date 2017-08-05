<?php

namespace App\Services;

use TomLingham\Searchy\SearchDrivers\BaseSearchDriver;

class SearchInStringMatcher extends BaseSearchDriver
{
    /**
     * @var array
     */
    protected $matchers = [
        \TomLingham\Searchy\Matchers\InStringMatcher::class => 100,
    ];
}
