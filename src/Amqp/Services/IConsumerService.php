<?php

declare(strict_types=1);

namespace rabbitmq\Amqp\Services;

use PhpAmqpLib\Message\AMQPMessage;
use rabbitmq\Amqp\Models\Exchange;
use rabbitmq\Utils\Log;

interface IConsumerService
{
    /**
     * @return Exchange
     */
    public function getExchange(): Exchange;

    /**
     * @param AMQPMessage $msg
     * @param Log $log
     *
     * @return void
     */
    public function consume(AMQPMessage $msg, Log $log): void;
}
