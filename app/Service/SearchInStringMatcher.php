<?php

namespace App\Service;

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
