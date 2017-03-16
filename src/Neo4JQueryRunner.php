<?php
use GraphAware\Neo4j\Client\Client;

class Neo4JQueryRunner
{
    public static function run(Client $client, $data, Neo4JStrategyInterface $strategy) {
        foreach ($strategy->getClosures() as $closure) {
            $data = $closure($data, $client);
        }

        return $data;
    }
}