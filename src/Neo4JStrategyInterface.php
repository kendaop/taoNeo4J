<?php
interface Neo4JStrategyInterface
{
    /**
     * @return Closure
     */
    public function getClosures();
}