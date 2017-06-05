<?php

namespace App\Service;

use TomLingham\Searchy\SearchDrivers\BaseSearchDriver;

class SearchExactMatcher extends BaseSearchDriver
{
    /**
     * @var array
     */
    protected $matchers = [
        \TomLingham\Searchy\Matchers\ExactMatcher::class => 100,
    ];
}
