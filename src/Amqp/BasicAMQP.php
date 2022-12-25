<?php

declare(strict_types=1);

namespace rabbitmq\Amqp;

use Exception;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use rabbitmq\Amqp\Models\Exchange;
use rabbitmq\Amqp\Models\Queue;
use rabbitmq\Utils\Env;

class BasicAMQP
{
    protected readonly AMQPChannel $channel;

    /**
     * @param AMQPStreamConnection $connection
     * @param Exchange $exchange
     */
    protected function __construct(protected readonly AMQPStreamConnection $connection,
                                   protected readonly Exchange $exchange)
    {
        $this->channel = $this->connection->channel();

        $this->channel->exchange_declare($this->exchange->getExchange(),
            $this->exchange->getType(),
            $this->exchange->isPassive(),
            $this->exchange->isDurable(),
            $this->exchange->isAutoDelete(),
            $this->exchange->isInternal(),
            $this->exchange->isNowait(),
            $this->exchange->getArguments(),
            $this->exchange->getTicket()
        );

        /** @var Queue $queue */
        foreach ($this->exchange->getQueues() as $queue) {
            $this->channel->queue_declare($queue->getName(),
                $queue->isPassive(),
                $queue->isDurable(),
                $queue->isExclusive(),
                $queue->isAutoDelete()
            );

            $this->channel->queue_bind(
                $queue->getName(),
                $this->exchange->getExchange(),
                $queue->getRouterKey()
            );
        }
    }

    public static function fromEnv(Env $env): AMQPStreamConnection
    {
        return new AMQPStreamConnection(
            $env->get('RABBITMQ_HOST'),
            $env->get('RABBITMQ_PORT'),
            $env->get('RABBITMQ_USER'),
            $env->get('RABBITMQ_PASSWORD'),
            $env->get('RABBITMQ_VHOST')
        );
    }

    /**
     * @return AMQPChannel
     */
    public function getChannel(): AMQPChannel
    {
        return $this->channel;
    }

    /**
     * @return Exchange
     */
    public function getExchange(): Exchange
    {
        return $this->exchange;
    }

    /**
     * @throws Exception
     */
    public function close(): void
    {
        $this->channel->close();
        $this->connection->close();
    }
}
