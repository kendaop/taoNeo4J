<?php
use GraphAware\Neo4j\Client\Client;

class Neo4JQueryRunner
{
    public static function insertRecord(Client $client, $modelId, $subject, $object, $predicate, $language, $author, $epoch) {
        $strategy = Neo4JStrategyBuilder::create()->add(function(Client $client, $data) {
            $stack = $client->stack();
            call_user_func_array([$stack, 'push'], Neo4JQueryBuilder::insert($data));
            return $stack;
        });
    }

    public static function run(Client $client, $data, Neo4JStrategyInterface $strategy) {
        foreach ($strategy->getClosures() as $closure) {
            $data = $closure->run($data, $client);
        }

        return $data;
    }
}