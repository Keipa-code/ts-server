<?php

declare(strict_types=1);

use App\Console\FixturesLoadCommand;
use Doctrine\Migrations;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\Command\SchemaTool;
use Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand;
use Psr\Container\ContainerInterface;

return [
    FixturesLoadCommand::class => static function (ContainerInterface $container) {
        $config = $container->get('settings')['console'];
        $em = $container->get(EntityManagerInterface::class);

        return new FixturesLoadCommand(
            $em,
            $config['fixture_paths']
        );
    },

    'settings' => [
        'console' => [
            'commands' => [
                FixturesLoadCommand::class,

                ValidateSchemaCommand::class,
                SchemaTool\DropCommand::class,
                SchemaTool\CreateCommand::class,

                Migrations\Tools\Console\Command\ExecuteCommand::class,
                Migrations\Tools\Console\Command\MigrateCommand::class,
                Migrations\Tools\Console\Command\LatestCommand::class,
                Migrations\Tools\Console\Command\ListCommand::class,
                Migrations\Tools\Console\Command\StatusCommand::class,
                Migrations\Tools\Console\Command\UpToDateCommand::class,
                Migrations\Tools\Console\Command\DiffCommand::class,
                Migrations\Tools\Console\Command\GenerateCommand::class,
            ],
            'fixture_paths' => [
                __DIR__.'/../../src/Manage/Fixture',
            ]
        ],
    ],
];