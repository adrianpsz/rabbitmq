<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Message\AMQPMessage;
use rabbitmq\Amqp\BasicAMQP;
use rabbitmq\Amqp\BasicPublisher;
use rabbitmq\Amqp\Models\PublisherData;
use rabbitmq\Amqp\Services\IPublisherService;
use rabbitmq\Utils\Env;
use rabbitmq\Utils\Log;

if ($argc != 3 || !class_exists($argv[2])) {
    exit('php publisher.php publisherName IPublisherService');
}

$env = Env::load();

/** @var IPublisherService $publisherService */
$publisherService = new $argv[2];
$consumerLog = new Log($argv[1]);

try {
    //
    // prepare connection and publisher
    //
    $connection = BasicAMQP::fromEnv($env);
    $publisher = BasicPublisher::to($connection, $publisherService->getExchange());
    $consumerLog->output('start...');

    //
    // main publisher loop
    //
    /** @var PublisherData $data */
    foreach ($publisherService->getData() as $data) {
        $consumerLog->output(
            'send: ' . $data->getData(),
            $publisher->getExchange()->getExchange(),
            $data->getRouterKey()
        );

        $publisher->publish(new AMQPMessage(
            $data->getData(),
            $publisherService->getMessageProperties()
        ), $data->getRouterKey());
    }

    system('pause');
} catch (Exception $e) {
    echo sprintf("Exception: %s:%d - %s" . PHP_EOL,
        $e->getFile(),
        $e->getLine(),
        $e->getMessage()
    );
} finally {
    if (isset($connection))
        $connection->close();
}



