<?php

declare(strict_types=1);

namespace rabbitmq\Amqp\Models;

use PhpAmqpLib\Exchange\AMQPExchangeType;

class Exchange
{
    /**
     * @param string $exchange
     * @param string $type
     * @param array $queues
     * @param bool $passive
     * @param bool $durable
     * @param bool $auto_delete
     * @param bool $internal
     * @param bool $nowait
     * @param array $arguments
     * @param $ticket
     */
    public function __construct(
        protected string $exchange,
        protected string $type,
        protected array  $queues = [],
        protected bool   $passive = false,
        protected bool   $durable = true,
        protected bool   $auto_delete = false,
        protected bool   $internal = false,
        protected bool   $nowait = false,
        protected array  $arguments = array(),
        protected        $ticket = null
    )
    {
    }

    /**
     * @param string $exchange
     * @param array $queues
     *
     * @return static
     */
    public static function direct(string $exchange, array $queues = []): static
    {
        return new static($exchange, AMQPExchangeType::DIRECT, $queues);
    }

    /**
     * @param string $exchange
     * @param array $queues
     *
     * @return static
     */
    public static function fanout(string $exchange, array $queues = []): static
    {
        return new static($exchange, AMQPExchangeType::FANOUT, $queues);
    }

    /**
     * @param string $exchange
     * @param array $queues
     *
     * @return static
     */
    public static function topic(string $exchange, array $queues = []): static
    {
        return new static($exchange, AMQPExchangeType::TOPIC, $queues);
    }

    /**
     * @return string
     */
    public function getExchange(): string
    {
        return $this->exchange;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getQueues(): array
    {
        return $this->queues;
    }

    /**
     * @return bool
     */
    public function isPassive(): bool
    {
        return $this->passive;
    }

    /**
     * @return bool
     */
    public function isDurable(): bool
    {
        return $this->durable;
    }

    /**
     * @return bool
     */
    public function isAutoDelete(): bool
    {
        return $this->auto_delete;
    }

    /**
     * @return bool
     */
    public function isInternal(): bool
    {
        return $this->internal;
    }

    /**
     * @return bool
     */
    public function isNowait(): bool
    {
        return $this->nowait;
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @return null
     */
    public function getTicket()
    {
        return $this->ticket;
    }
}
