<?php

namespace rabbitmq\Services\BasicExample;

use Generator;
use rabbitmq\Amqp\Models\Exchange;
use rabbitmq\Amqp\Models\PublisherData;
use rabbitmq\Amqp\Models\Queue;
use rabbitmq\Amqp\Services\IPublisherService;

class BasicPublisherService implements IPublisherService
{
    /**
     * @return Exchange
     */
    public function getExchange(): Exchange
    {
        return Exchange::direct('basic', [
            Queue::basic('basic.queue1', 'basic.queue1'),
            Queue::basic('basic.queue2', 'basic.queue2'),
        ]);
    }

    /**
     * @return Generator
     */
    public function getData(): Generator
    {
        yield new PublisherData('basic.queue1', 1);
        yield new PublisherData('basic.queue1', 2);
        yield new PublisherData('basic.queue1', 3);
        yield new PublisherData('basic.queue1', 4);
        yield new PublisherData('basic.queue1', 5);
        yield new PublisherData('basic.queue1', 6);
        yield new PublisherData('basic.queue1', 7);
        yield new PublisherData('basic.queue1', 8);
        yield new PublisherData('basic.queue1', 9);
        yield new PublisherData('basic.queue2', 10);
    }

    /**
     * @return string[]
     */
    public function getMessageProperties(): array
    {
        return [
            'content_type' => 'text/plain',
        ];
    }
}
