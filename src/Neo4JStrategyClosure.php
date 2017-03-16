<?php
use GraphAware\Neo4j\Client\Client;
class Neo4JStrategyClosure
{
    private $closure;

    public function __construct(callable $closure) {
        $this->closure = $closure;
    }

    public function run(Client $client, $data) {
        $stack = ($this->closure)($client, $data);
        if ($stack) {
            return $client->runStack($stack);
        }

        return null;
    }
}