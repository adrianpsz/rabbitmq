<?php

declare(strict_types=1);

namespace rabbitmq\Amqp\Services;

use Generator;
use rabbitmq\Amqp\Models\Exchange;

interface IPublisherService
{
    /**
     * @return Exchange
     */
    public function getExchange(): Exchange;

    /**
     * @return Generator
     */
    public function getData(): Generator;

    /**
     * @return array
     */
    public function getMessageProperties(): array;
}
