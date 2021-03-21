<?php

declare(strict_types=1);

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;

return [
    EntityManagerInterface::class => function (ContainerInterface $container) {
    /**
     * @var array $settings
     * @psalm-suppress MixedArrayAccess
     */
        $settings = $container->get('doctrine');
    /**
     * @var array<array-key, mixed> $settings['meta']['entity_path']
     * @var bool $settings['meta']['auto_generate_proxies']
     * @var null|string $settings['meta']['proxy_dir']
     * @var Doctrine\Common\Cache\Cache|null $settings['meta']['cache']
     * @psalm-suppress MixedArrayAccess
     */
        $config = Setup::createAnnotationMetadataConfiguration(
            $settings['meta']['entity_path'],
            $settings['meta']['auto_generate_proxies'],
            $settings['meta']['proxy_dir'],
            $settings['meta']['cache'],
            false
        );
    /**
     * @var Doctrine\DBAL\Connection|array<string, mixed> $settings['connection']
     * @psalm-suppress MixedArrayAccess
     */
        return EntityManager::create($settings['connection'], $config);
    },
    'doctrine' => [
        'meta' => [
            'entity_path' => [__DIR__ . '/../../src/'],
            'auto_generate_proxies' => true,
            'proxy_dir' => __DIR__ . '/../../var/cache/proxies',
            'cache' => null,
        ],
        /*// if true, metadata caching is forcefully disabled
        'dev_mode' => true,

        // path where the compiled metadata info will be cached
        // make sure the path exists and it is writable
        'cache_dir' => APP_ROOT . '/../var/cache/doctrine',

        // you should add any other path containing annotated entity classes
        'metadata_dirs' => [APP_ROOT . '/src/Entity'],
        */
        'connection' => [
            'driver' => 'pdo_pgsql',
            'host' => 'postgres',
            'dbname' => 'test',
            'port' => '54321',
            'user' => 'admin',
            'password' => '123456',
            'charset' => 'utf-8'
        ]
    ]
];
