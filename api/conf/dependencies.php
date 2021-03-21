<?php

declare(strict_types=1);

$files = glob(__DIR__ . '/common/*.php');

//glob(__DIR__ . '/' . (getenv('APP_ENV') ?: 'prod') . '/*.php') ?: []

$configs = array_map(
    static function (string $file) {
        /**
         * @var array
         * @noinspection PhpIncludeInspection
         * @psalm-suppress UnresolvableInclude
         */
        return require $file;
    },
    $files
);

return array_merge_recursive(...$configs);
