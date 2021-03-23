<?php

declare(strict_types=1);

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;

require __DIR__ . '/../vendor/autoload.php';

/** @var ContainerInterface $container */
$container = require __DIR__ . '/../conf/container.php';

$cli = new Application('Console');

$commands = $container->get('settings')['console']['commands'];


$entityManager = $container->get(EntityManagerInterface::class);
$cli->getHelperSet()->set(new EntityManagerHelper($entityManager), 'em');


foreach ($commands as $name){
    $command = $container->get($name);
    $cli->add($command);
}

$cli->run();
