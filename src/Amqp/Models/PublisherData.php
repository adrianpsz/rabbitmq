<?php

declare(strict_types=1);

namespace rabbitmq\Amqp\Models;

class PublisherData
{

    /**
     * @param string $routerKey
     * @param mixed $data
     */
    public function __construct(
        protected string $routerKey,
        protected mixed  $data
    )
    {
    }

    /**
     * @return string
     */
    public function getRouterKey(): string
    {
        return $this->routerKey;
    }

    /**
     * @return mixed
     */
    public function getData(): mixed
    {
        return $this->data;
    }


}
