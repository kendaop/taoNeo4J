<?php
namespace bt\taoNeo4J;
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
        })->add(function (Client $client, $data) use ($subject, $object, $predicate, $modelId, $language, $author, $epoch) {
            $stack = $client->stack();

            // create a relationship between subject and object
            static::pushStack($stack, Neo4JQueryBuilder::createRelationship($subject, $object, [
                'modelid' => $modelId,
                'l_language' => $language,
                'author' => $author,
                'epoch' => $epoch,
                'id' => $predicate
            ]));

            return $stack;
        });

        return static::run($client, [], $strategy);
    }

    public static function delete(ClientInterface $client, $resourceUri, $writableModels, $deleteReferences = false) {

        $strategy = Neo4JStrategyBuilder::create()->add(function(Client $client, $data) use ($resourceUri, $writableModels)  {
            $stack = $client->stack();

            static::pushStack($stack, Neo4JQueryBuilder::deletePredicates($resourceUri, $writableModels));
        });

        $result = static::run($client, $resourceUri, $strategy);

        if ($deleteReferences) {
            return static::deleteReferences($client, $resourceUri, $writableModels);
        }

        return $result;
    }

    protected static function deleteReferences(ClientInterface $client, $resourceUri, $writableModels) {
        $strategy = Neo4JStrategyBuilder::create()->add(function(Client $client, $data) use ($resourceUri, $writableModels)  {
            $stack = $client->stack();

            static::pushStack($stack, Neo4JQueryBuilder::deletePredicateReferences($resourceUri, $writableModels));
        });

        return static::run($client, $resourceUri, $strategy);
    }

//    public static function getTypes(ClientInterface $client, $resourceUri) {
//        $strategy = Neo4JStrategyBuilder::create()->add(function(Client $client, $resourceUri)  {
//            $stack = $client->stack();
//
//            static::pushStack($stack, Neo4JQueryBuilder::findRelated($resourceUri, "http://www.w3.org/1999/02/22-rdf-syntax-ns#type"));
//        });
//
//        return static::run($client, $resourceUri, $strategy);
//    }
//
//    public static function getPropertyValues(ClientInterface $client, $resourceUri, $propertyUri, $options = []) {
//        $props = [];
//        if (isset($options['lg'])) {
//            $props = [
//                'predicate' => [
//                    'l_language' => $options['lg']
//                ]
//            ];
//        }
//
//        $strategy = Neo4JStrategyBuilder::create()->add(function(Client $client, $resourceUri, $propertyUri, $props)  {
//            $stack = $client->stack();
//
//            //static::pushStack($stack, Neo4JQueryBuilder::findRelated($resourceUri, $propertyUri, $props, ));
//        });
//    }

    public static function run(ClientInterface $client, $data, Neo4JStrategyInterface $strategy) {
        foreach ($strategy->getClosures() as $closure) {
            $data = $closure->run($client, $data);
        }

        return $data;
    }
}