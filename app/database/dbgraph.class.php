<?php

require_once 'vendor/autoload.php';

use Neoxygen\NeoClient\ClientBuilder;

class DBGraph
{
    private static $db = null;

    private function __construct() { }
    private function __clone() { }

    public static function getConnection() 
    {
        if (DBGraph::$db === null) {
            try {
                DBGraph::$db = ClientBuilder::create()
                    ->addConnection('default', 'http', '31.147.200.154', 7474, true, 'neo4j', 'nbp')
                    ->setAutoFormatResponse(true)
                    ->build();
            } catch (Exception $e) {
                exit('Neo4j Connection Error: ' . $e->getMessage());
            }
        }
        return DBGraph::$db;
    }
}

?>