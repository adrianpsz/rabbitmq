<?php

declare(strict_types=1);

namespace rabbitmq\Utils;

class Log
{
    /**
     * @param string $scriptName
     */
    public function __construct(
        protected readonly string $scriptName
    )
    {
    }

    /**
     * @param string $message
     * @param string $exchange
     * @param string $routerKey
     *
     * @return void
     */
    public function output(string $message = '', string $exchange = '',
                           string $routerKey = ''): void
    {
        echo sprintf('[%s %s e:%s rk:%s] %s' . PHP_EOL,
            date('Y-m-d H:i:s'),
            $this->scriptName,
            $exchange,
            $routerKey,
            $message
        );
    }
}
