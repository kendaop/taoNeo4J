<?php
use \GraphAware\Neo4j\Client\Client;

class Neo4JStrategy implements Neo4JStrategyInterface
{

    /**
     * @var Neo4JStrategyClosure[]
     */
    private $closures;
    /**
     * @return Neo4JStrategyClosure[]
     */
    public function getClosures()
    {
        return $this->closures;
    }

    /**
     * @param callable $closure
     * @return Neo4JStrategyInterface
     */
    public function add(callable $closure)
    {
        $this->closures[] = new Neo4JStrategyClosure($closure);
        return $this;
    }
}