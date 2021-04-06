<?php

declare(strict_types=1);

use App\Flusher;
use App\Manage\Command\AddSubscriber\Request\Handler;
use App\Manage\Command\Entity\Subscriber\SubscriberRepository;
use libphonenumber\PhoneNumberUtil;
use Psalm\PhpUnitPlugin\Plugin;

require __DIR__ . '/../vendor/autoload.php';

$var1 = ['1' => '123'];
$var2 = '';

$var = ($var1['1'] == '123' ? '321' : '123');

    echo $var;
