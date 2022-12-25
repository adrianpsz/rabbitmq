<?php

namespace rabbitmq\Services\BasicExample;

use PhpAmqpLib\Message\AMQPMessage;
use rabbitmq\Amqp\Models\Exchange;
use rabbitmq\Amqp\Models\Queue;
use rabbitmq\Amqp\Services\IConsumerService;
use rabbitmq\Utils\Log;

class BasicConsumer02Service implements IConsumerService
{
    /**
     * @return Exchange
     */
    public function getExchange(): Exchange
    {
        return Exchange::direct('basic', [
            Queue::basic('basic.queue2', 'basic.queue2'),
        ]);
    }

    /**
     * @param AMQPMessage $msg
     * @param Log $log
     *
     * @return void
     */
    public function consume(AMQPMessage $msg, Log $log): void
    {
        $body = $msg->getBody();

        $log->output($body, $msg->getExchange(), $msg->getRoutingKey());

        $msg->ack();
    }
}
