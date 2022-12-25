<?php

declare(strict_types=1);

namespace rabbitmq\Amqp;

use ErrorException;
use Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use rabbitmq\Amqp\Models\Exchange;
use rabbitmq\Amqp\Models\Queue;

class BasicConsumer extends BasicAMQP
{
    protected static ?BasicConsumer $instance = null;

    /**
     * @param AMQPStreamConnection $connection
     * @param Exchange $exchange
     */
    protected function __construct(AMQPStreamConnection $connection, Exchange $exchange)
    {
        parent::__construct($connection, $exchange);
    }

    /**
     * @param AMQPStreamConnection $connection
     * @param Exchange $exchange
     *
     * @return static
     */
    public static function from(AMQPStreamConnection $connection, Exchange $exchange): static
    {
        if (is_null(static::$instance)) {
            static::$instance = new BasicConsumer($connection, $exchange);
        }

        return static::$instance;
    }

    /**
     * @param callable $function
     *
     * @return void
     * @throws ErrorException
     */
    public function consume(callable $function): void
    {
        /** @var Queue $queue */
        foreach ($this->exchange->getQueues() as $queue) {
            $this->channel->basic_consume($queue->getName(), callback: $function);
        }

        $this->channel->consume();
    }
}
