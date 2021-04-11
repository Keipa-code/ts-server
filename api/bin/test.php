<?php

declare(strict_types=1);

use App\Flusher;
use App\Manage\Command\AddSubscriber\Request\Handler;
use App\Manage\Command\Entity\Subscriber\SubscriberRepository;
use Faker\Factory;
use libphonenumber\PhoneNumberUtil;
use Psalm\PhpUnitPlugin\Plugin;

require __DIR__ . '/../vendor/autoload.php';

$faker = Factory::create('ru_RU');

echo $faker->buildingNumber;
