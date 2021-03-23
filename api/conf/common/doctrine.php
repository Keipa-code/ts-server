<?php

declare(strict_types=1);

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\Common\EventManager;
use Doctrine\Common\EventSubscriber;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
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
         * @var array<array-key, mixed> $settings ['meta']['entity_path']
         * @var bool $settings ['meta']['dev_mode']
         * @var null|string $settings ['meta']['proxy_dir']
         * @var Doctrine\Common\Cache\Cache|null $settings ['meta']['cache']
         * @psalm-suppress MixedArrayAccess
         */
        $config = Setup::createAnnotationMetadataConfiguration(
            $settings['meta']['entity_path'],
            $settings['meta']['dev_mode'],
            $settings['meta']['proxy_dir'],
            $settings['meta']['cache'] ? new FilesystemCache($settings['meta']['cache']) : new ArrayCache(),
            false
        );

        $config->setNamingStrategy(new UnderscoreNamingStrategy());

        foreach ($settings['types'] as $name => $class) {
            if (!Type::hasType($name)){
                Type::addType($name, $class);
            }
        }

        $eventManager = new EventManager();

        foreach ($settings['meta']['event_subscribers'] as $name){
            /** @var EventSubscriber $eventSubscribers */
            $eventSubscribers = $container->get($name);
            $eventManager->addEventSubscriber($eventSubscribers);
        }

        /**
         * @var Doctrine\DBAL\Connection|array<string, mixed> $settings ['connection']
         * @psalm-suppress MixedArrayAccess
         */
        return EntityManager::create($settings['connection'], $config, $eventManager);
    },
    'doctrine' => [
        'meta' => [
            'entity_path' => [__DIR__ . '/../../src/Manage/Command/Entity', __DIR__ . '/../../src/Manage/Admin/Entity'],
            'dev_mode' => true,
            'proxy_dir' => __DIR__ . '/../../var/cache/proxies',
            'cache' => null,
            'event_subscribers' => [
                \App\Data\Doctrine\FixDefaultSchemaSubscriber::class,
            ]
        ],

        'connection' => [
            'driver' => 'pdo_pgsql',
            'host' => 'postgres',
            'dbname' => 'phonedir',
            'port' => '5432',
            'user' => 'admin',
            'password' => '123456',
            'charset' => 'utf-8'
        ],
        'types' => [
            App\Manage\Command\Entity\Subscriber\IdType::NAME => App\Manage\Command\Entity\Subscriber\IdType::class,
            App\Manage\Command\Entity\Subscriber\PhoneNumberType::NAME => App\Manage\Command\Entity\Subscriber\PhoneNumberType::class,
            App\Manage\Command\Entity\Subscriber\SubscriberTypeType::NAME => App\Manage\Command\Entity\Subscriber\SubscriberTypeType::class
        ]
    ]
];
