<?php

declare(strict_types=1);

namespace rabbitmq\Utils;

use Exception;

class Env
{
    const ENV_FILE_NAME = '.env';

    protected static ?Env $instance = null;
    protected array $env = [];

    /**
     * @return Env
     */
    public static function load(): Env
    {
        if (is_null(self::$instance)) {
            self::$instance = new Env();
        }

        return self::$instance;
    }

    /**
     *
     * @throws Exception
     */
    private function __construct()
    {
        if (!file_exists(self::ENV_FILE_NAME))
            throw new Exception(self::ENV_FILE_NAME . ' not found!');

        $file = fopen('.env', 'r');

        while (($line = fgets($file, 1000))) {
            if (strlen(trim($line)) > 0) {
                $l = explode('=', $line);
                $this->env[trim($l[0])] = trim($l[1]);
            }
        }
    }

    /**
     * @throws Exception
     */
    public function get(string $key): string
    {
        if (array_key_exists($key, $this->env)) {
            return $this->env[$key];
        }

        throw new Exception("There is no key '${$key}' in .env file.");
    }
}
