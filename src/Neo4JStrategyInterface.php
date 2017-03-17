<?php
namespace bt\taoNeo4J;
interface Neo4JStrategyInterface
{
    /**
     * @return Neo4JStrategyClosure[]
     */
    public function getClosures();

    /**
     * @param callable $closure
     * @return Neo4JStrategyInterface
     */
    public function add(callable $closure);
}