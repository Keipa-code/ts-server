<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;

require __DIR__ . '/../vendor/autoload.php';
/** @var ContainerInterface $container */
$container = require __DIR__ . '/../conf/container.php';
$cli = new Application('Console');
$cli->run();
