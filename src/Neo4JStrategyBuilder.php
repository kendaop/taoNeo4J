<?php
class Neo4JStrategyBuilder
{
    /**
     * @return Neo4JStrategyInterface
     */
    public static function create() {
        return new Neo4JStrategy();
    }
}