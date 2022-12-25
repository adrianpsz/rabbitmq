<?php

declare(strict_types=1);

use rabbitmq\Services\BasicExample\BasicConsumer01Service;
use rabbitmq\Services\BasicExample\BasicConsumer02Service;
use rabbitmq\Services\BasicExample\BasicPublisherService;
use rabbitmq\Utils\GenerateRunBatScript;

require_once __DIR__ . '/vendor/autoload.php';

GenerateRunBatScript::create(__DIR__)
    ->appendConsumer('consumer01', [
        'class' => BasicConsumer01Service::class,
        'count' => 2,
    ])
    ->appendConsumer('consumer02', [
        'class' => BasicConsumer02Service::class,
        'count' => 1,
    ])
    ->appendPublisher('publisher01', [
        'class' => BasicPublisherService::class,
        'count' => 1,
    ])
    ->generate();
