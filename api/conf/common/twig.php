<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Slim\Flash\Messages;
use Slim\Views\Twig;

return [
    'view' => function (ContainerInterface $container): Twig {
        /** @var array $settings */
        $settings = $container->get('views');
        /**
         * @var  array<array-key, string>|string $settings['template_path']
         * @var array<string, mixed> $settings['twig']
         * @psalm-suppress MixedArrayAccess
         */
        $twig = Twig::create($settings['template_path'], $settings['twig']);

        $environment = $twig->getEnvironment();
        $environment->addGlobal('flash', $container->get(Messages::class));
        $environment->addFunction(new \Twig\TwigFunction('json_decode', function ($data) use ($container) {
            return json_decode($data);
        }));

        return $twig;
    },

    'views' => [
        'template_path' => __DIR__ . '/../../tmpl/',
        'twig' => [
            'cache' => false,
            'auto_reload' => true,
        ],
    ],
];
