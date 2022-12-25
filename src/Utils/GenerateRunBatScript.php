<?php

declare(strict_types=1);

namespace rabbitmq\Utils;

class GenerateRunBatScript
{
    const SCRIPT_NAME = 'run.bat';

    protected array $data;

    /**
     * @param string $outputPath
     */
    public function __construct(
        protected string $publisherScriptName,
        protected string $consumerScriptName,
        protected string $outputPath
    )
    {
    }

    /**
     * @param string $outputPath
     *
     * @return static
     */
    public static function create(string $outputPath): static
    {
        return new GenerateRunBatScript(
            'publisher.php',
            'consumer.php',
            $outputPath
        );
    }

    /**
     * @param string $name
     * @param array $data
     *
     * @return $this
     */
    public function appendPublisher(string $name, array $data): static
    {
        $this->data[$name] = array_merge([
            'script' => $this->publisherScriptName,
        ], $data);

        return $this;
    }

    /**
     * @param string $name
     * @param array $data
     *
     * @return $this
     */
    public function appendConsumer(string $name, array $data): static
    {
        $this->data[$name] = array_merge([
            'script' => $this->consumerScriptName,
        ], $data);

        return $this;
    }

    /**
     * @return void
     */
    public function generate(): void
    {
        $output = '';
        foreach ($this->data as $name => $config) {
            $output .= ':: ' . $name . PHP_EOL;

            for ($i = 1; $i <= $config['count']; $i++) {
                $index = sprintf('%03d', $i);

                $output .= sprintf('start "%s" %s %s %s' . PHP_EOL,
                    $name . ' ' . $index,
                    'php ' . $config['script'],
                    $name . '_' . $index,
                    $config['class']
                );
            }
            $output .= PHP_EOL;
        }

        file_put_contents($this->outputPath
            . DIRECTORY_SEPARATOR
            . self::SCRIPT_NAME,
            $output
        );
    }
}
