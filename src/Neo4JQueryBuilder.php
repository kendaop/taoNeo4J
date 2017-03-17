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

    public static function deletePredicates($subject, $writableModels) {
        $query = 'MATCH (:RDF_NODE {id: $subject})->[r:RELATES_TO]->(:RDF_NODE) WHERE r.modelid IN {writableModels} DELETE r';
        $params = ['subject' => $subject, 'writableModels' => $writableModels];

        return [$query, $params];
    }

    public static function deletePredicateReferences($object, $writableModels) {
        $query = 'MATCH (:RDF_NODE)->[r:RELATES_TO]->(:RDF_NODE {id: $object}) WHERE r.modelid IN {writableModels} DELETE r';
        $params = ['object' => $object, 'writableModels' => $writableModels];

        return [$query, $params];
    }

//    public static function findRelated($subject, $predicate, $otherProps = [], $orderBy = null) {
//        $objectProps = [];
//        $otherSubjectProps = [];
//        $otherPredicateProps = [];
//        if (array_key_exists('predicate', $otherProps)) {
//            $otherPredicateProps = $otherProps['predicate'];
//        }
//
//        if (array_key_exists('subject', $otherProps)) {
//            $otherSubjectProps = $otherProps['subject'];
//        }
//
//        if (array_key_exists('object', $otherProps)) {
//            $objectProps = $otherProps['object'];
//        }
//        $subjectProps = static::properties(array_merge(['id' => $subject], $otherSubjectProps), 'subject');
//        $predicateProps = static::properties(array_merge(['id' => $predicate], $otherPredicateProps), 'predicate');
//        $objectProps = static::properties($objectProps, 'object');
//
//        $query = 'MATCH (a:RDF_NODE'.$subjectProps[0].')-[r:RELATES_TO'.$predicateProps[0].']->(n:RDF_NODE'.$objectProps[0].') RETURN n';
//        if ($orderBy) {
//            $query += ' ORDER BY ' . $orderBy;
//        }
//        $params = array_merge($subjectProps[1], $predicateProps[1], $objectProps[1]);
//        return [$query, $params];
//    }
//
//    protected static function properties($props, $prefix) {
//        if (empty($props)) {
//            return ['', []];
//        }
//        $prefixedProps = [];
//        foreach ($props as $key => $value) {
//            $prefixedProps[$prefix . '_' . $key] = $value;
//        }
//
//        return [' {' .implode(', ', array_map(function($keyName) use ($prefix) {
//            return $keyName .': $'. $prefix .'_'. $keyName;
//        }, array_keys($props))) . '}', $prefixedProps];
//    }
}