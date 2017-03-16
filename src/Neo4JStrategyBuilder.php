<?php
class Neo4JStrategyBuilder
{
    /**
     * @return Neo4JStrategy
     */
    public static function create() {
        return new Neo4JStrategy();
    }
}