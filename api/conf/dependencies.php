<?php

declare(strict_types=1);

use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;

$files = glob(__DIR__ . '/common/*.php');

//glob(__DIR__ . '/' . (getenv('APP_ENV') ?: 'prod') . '/*.php') ?: []

$aggregator = new ConfigAggregator([
    new PhpFileProvider(__DIR__ . '/common/*.php')
]);

return $aggregator->getMergedConfig();
