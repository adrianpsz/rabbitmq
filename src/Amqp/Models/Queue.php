<?php

declare(strict_types=1);

namespace rabbitmq\Amqp\Models;

class Queue
{
    /**
     * @param string $name
     * @param string $routerKey
     * @param bool $passive
     * @param bool $durable
     * @param bool $exclusive
     * @param bool $auto_delete
     * @param bool $nowait
     * @param array $arguments
     * @param $ticket
     */
    public function __construct(
        protected string $name,
        protected string $routerKey,
        protected bool   $passive = false,
        protected bool   $durable = true,
        protected bool   $exclusive = false,
        protected bool   $auto_delete = true,
        protected bool   $nowait = false,
        protected array  $arguments = array(),
        protected        $ticket = null
    )
    {
    }

    /**
     * @param string $name
     * @param string $routerKey
     *
     * @return static
     */
    public static function basic(string $name, string $routerKey): static
    {
        return new static($name, $routerKey);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getRouterKey(): string
    {
        return $this->routerKey;
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
    public function isExclusive(): bool
    {
        return $this->exclusive;
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
