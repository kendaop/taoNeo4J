<?php
require_once 'vendor/autoload.php';

use GraphAware\Neo4j\Client\ClientBuilder;


$client = ClientBuilder::create()
    ->addConnection('bolt', 'bolt://admin:pass@localhost:7687')
    ->build();

bt\taoNeo4J\Neo4JQueryRunner::insertRecord($client, 10, "Subject", "Object", "Predicate", "en_US", "daniel", microtime(false));