<?php
namespace bt\taoNeo4J;
class Neo4JStrategyBuilder
{
    /**
     * @return Neo4JStrategyInterface
     */
    public static function create() {
        return new Neo4JStrategy();
    }
}