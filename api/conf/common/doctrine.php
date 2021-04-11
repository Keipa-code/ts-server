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
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;
use App\Manage\Command\Entity\Subscriber;

return [
    EntityManagerInterface::class => function (ContainerInterface $container) {
        /**
         * @psalm-suppress MixedArrayAccess
         * @psalm-var array{
         *     entity_path:array,
         *     dev_mode:bool,
         *     proxy_dir:string,
         *     cache:?string,
         *     event_subscribers:string[],
         *     connection:array<string, mixed>,
         *     types:array<string,class-string<Doctrine\DBAL\Types\Type>>
         * } $settings
         */
        $settings = $container->get('doctrine');

        $config = Setup::createAnnotationMetadataConfiguration(
            $settings['entity_path'],
            $settings['dev_mode'],
            $settings['proxy_dir'],
            $settings['cache'] ? new FilesystemCache($settings['cache']) : new ArrayCache(),
            false
        );

        $config->setNamingStrategy(new UnderscoreNamingStrategy());

        foreach ($settings['types'] as $name => $class) {
            if (!Type::hasType($name)) {
                Type::addType($name, $class);
            }
        }

        //$config->setDefaultQueryHint(Query::HINT_CUSTOM_OUTPUT_WALKER,'\App\Data\Doctrine\IlikeWalker');
        $eventManager = new EventManager();

        foreach ($settings['event_subscribers'] as $name) {
            /** @var EventSubscriber $eventSubscriber */
            $eventSubscriber = $container->get($name);
            $eventManager->addEventSubscriber($eventSubscriber);
        }

        return EntityManager::create($settings['connection'], $config, $eventManager);
    },
    'doctrine' => [
        'entity_path' => [
            __DIR__ . '/../../src/Manage/Command/Entity',
            __DIR__ . '/../../src/Auth/Entity'
        ],
        'dev_mode' => true,
        'proxy_dir' => __DIR__ . '/../../var/cache/proxies',
        'cache' => null,
        'event_subscribers' => [
            \App\Data\Doctrine\FixDefaultSchemaSubscriber::class,
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
            Subscriber\IdType::NAME => Subscriber\IdType::class,
            Subscriber\SubscriberTypeType::NAME => Subscriber\SubscriberTypeType::class,

        ]
    ]
];
