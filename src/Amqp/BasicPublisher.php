<?php

declare(strict_types=1);

namespace rabbitmq\Amqp;

use Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use rabbitmq\Amqp\Models\Exchange;

class BasicPublisher extends BasicAMQP
{
    protected static ?BasicPublisher $instance = null;

    /**
     * @param AMQPStreamConnection $connection
     * @param Exchange $exchange
     *
     * @return static
     */
    public static function to(AMQPStreamConnection $connection, Exchange $exchange): static
    {
        if (is_null(static::$instance)) {
            static::$instance = new BasicPublisher($connection, $exchange);
        }

        return static::$instance;
    }

    /**
     * @param AMQPStreamConnection $connection
     * @param Exchange $exchange
     */
    protected function __construct(AMQPStreamConnection $connection, Exchange $exchange)
    {
        parent::__construct($connection, $exchange);
    }

    /**
     * @param AMQPMessage $msg
     * @param string $routerKey
     *
     * @return $this
     */
    public function publish(AMQPMessage $msg, string $routerKey): BasicPublisher
    {
        $this->channel->basic_publish($msg, $this->exchange->getExchange(), $routerKey);

        return $this;
    }
}
