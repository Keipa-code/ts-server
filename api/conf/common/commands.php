<?php

declare(strict_types=1);

use Doctrine\ORM\Tools\Console\Command\SchemaTool;
use Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand;

return [
    'settings' => [
        'console' => [
            'commands' => [
                ValidateSchemaCommand::class,
                SchemaTool\DropCommand::class,
                SchemaTool\CreateCommand::class
            ],
        ],
    ],
];