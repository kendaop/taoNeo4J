<?php
namespace bt\taoNeo4J;
use GraphAware\Bolt\Result\Result;
use GraphAware\Neo4j\Client\Client;
use GraphAware\Neo4j\Client\ClientInterface;
use \GraphAware\Neo4j\Client\StackInterface;
use GraphAware\Common\Result\ResultCollection;

class Neo4JQueryRunner
{
    protected static function pushStack(StackInterface $stack, $params) {
        return call_user_func_array([$stack, 'push'], $params);
    }

    public static function insertRecord(ClientInterface $client, $modelId, $subject, $object, $predicate, $language, $author, $epoch) {
        $strategy = Neo4JStrategyBuilder::create()->add(function(Client $client, $data) use ($subject) {
            $stack = $client->stack();
            // see if the Subject node exists
            static::pushStack($stack, Neo4JQueryBuilder::find($subject));
            return $stack;
        })->add(function (Client $client, ResultCollection $data) use ($subject, $object) {
            $stack = $client->stack();

            // if the subject node doesn't exist, insert it
            if (!($data->results()[0]->size())) {
                static::pushStack($stack, Neo4JQueryBuilder::insertNode(['id' => $subject]));
            }

            // see if the object node exists
            static::pushStack($stack, Neo4JQueryBuilder::find($object));
            return $stack;
        })->add(function (Client $client, ResultCollection $data) use ($subject, $object, $predicate) {
            $stack = $client->stack();

            // if the object node doesn't exist, insert it
            if (!($data->results()[0]->size())) {
                static::pushStack($stack, Neo4JQueryBuilder::insertNode(['id' => $object]));

                return $stack;
            }

            return null;
        })->add(function (Client $client, $data) use ($subject, $object, $modelId, $language, $author, $epoch) {
            $stack = $client->stack();

            // create a relationship between subject and object
            static::pushStack($stack, Neo4JQueryBuilder::createRelationship($subject, $object, [
                'modelid' => $modelId,
                'l_language' => $language,
                'author' => $author,
                'epoch' => $epoch
            ]));

            return $stack;
        });

        return static::run($client, [], $strategy);
    }

    public static function run(Client $client, $data, Neo4JStrategyInterface $strategy) {
        foreach ($strategy->getClosures() as $closure) {
            $data = $closure->run($client, $data);
        }

        return $data;
    }
}