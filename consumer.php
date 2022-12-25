<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Message\AMQPMessage;
use rabbitmq\Amqp\BasicAMQP;
use rabbitmq\Amqp\BasicConsumer;
use rabbitmq\Amqp\Services\IConsumerService;
use rabbitmq\Utils\Env;
use rabbitmq\Utils\Log;


if ($argc != 3 || !class_exists($argv[2])) {
    exit('php consumer.php consumerName IConsumerService');
}

$env = Env::load();
/** @var IConsumerService $consumerService */
$consumerService = new $argv[2];
$consumerLog = new Log($argv[1]);

try {
    //
    // prepare connection and consumer
    //
    $connection = BasicAMQP::fromEnv($env);
    $consumer = BasicConsumer::from($connection, $consumerService->getExchange());
    $consumerLog->output('ready...');

    //
    // consume
    //
    $consumer->consume(function (AMQPMessage $msg) use ($consumerService, $consumerLog) {
        $consumerService->consume($msg, $consumerLog);
    });

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



