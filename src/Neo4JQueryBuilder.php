<?php
namespace bt\taoNeo4J;
class Neo4JQueryBuilder
{
    public static function insertNode($data) {
        $query = "CREATE (item:RDF_NODE {properties})";
        $params = ['properties' => $data];

        return [$query, $params];
    }

    public static function find($id) {
        $query = 'MATCH (item:RDF_NODE) WHERE item.id = $id RETURN item';
        $params = ['id' => $id];

        return [$query, $params];
    }

    public static function createRelationship($subject, $object, $relationship) {
        $query = 'MATCH (a:RDF_NODE), (b:RDF_NODE) WHERE a.id = $subject AND b.id = $object CREATE (a)-[r:RELATES_TO {relationship}]->(b) RETURN r';
        $params = ['subject' => $subject, 'object' => $object, 'relationship' => $relationship];

        return [$query, $params];
    }
}