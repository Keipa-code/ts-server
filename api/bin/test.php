<?php

declare(strict_types=1);

use App\Flusher;
use App\Manage\Command\AddSubscriber\Request\Handler;
use App\Manage\Command\Entity\Subscriber\SubscriberRepository;
use libphonenumber\PhoneNumberUtil;
use Psalm\PhpUnitPlugin\Plugin;

require __DIR__ . '/../vendor/autoload.php';

\Webmozart\Assert\Assert::uuid('00000000-0000-0000-0000-000000000001');