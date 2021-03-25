<?php

declare(strict_types=1);

use App\Flusher;
use App\Manage\Command\Entity\Subscriber\SubscriberRepository;

require __DIR__ . '/../vendor/autoload.php';

$subData = ['private' => [
    'firstname' => '',
    'surname' => '',
    'patronymic' => '',
]
];
