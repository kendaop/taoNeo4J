<?php
class Neo4JQueryBuilder
{
    public static function insertNode($data) {
        $query = "CREATE (item {properties})";
        $params = ['properties' => $data];

        return [$query, $params];
    }

    public static function find($id) {
        $query = 'MATCH (item) WHERE item.id = $id RETURN item';
        $params = ['id' => $id];

        return [$query, $params];
    }

    public static function findRelationship($subject, $object, $relationship) {
        $query = 'MATCH (subject {subject})-[r:RELATES_TO {relationship}]->(object {object}) RETURN properties(r) ';
        $params = ['subject' => [$subject], 'object' => [$object], 'relationship' => $relationship];
        return [$query, $params];
    }
}