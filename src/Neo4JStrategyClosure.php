<?php
class Neo4JStrategyClosure
{
    private $closure;

    public function __construct(callable $closure) {
        $this->closure = $closure;
    }

    public function run($client, $data) {
        $stack = $this->closure($client, $data);
        return $client->runStack($stack);
    }
}