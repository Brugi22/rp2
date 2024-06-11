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
                    ->addConnection('default', 'http', '31.147.200.189', 7474, true, 'neo4j', 'nbp')
                    ->setAutoFormatResponse(true)
                    ->build();
            } catch (Exception $e) {
                exit('Neo4j Connection Error: ' . $e->getMessage());
            }
        }
        return DBGraph::$db;
    }
}

// Extracting user data from the provided PHP code
$users = [
    [1,'dina_sabol08', 'dina.sabol28@gmail.com', 'Abcde12345..', 'Dina', 'Sabol'],
    [2,'lucfuc34', 'lucija.lesjak@gmail.com', 'AbrakaDabra', 'Lucija', 'Lesjak'],
    [3,'matkicslatkic', 'matkosimic33@gmail.com', 'AbPll,.65', 'Matko', 'Šimić'],
    [4,'brunobanani', 'silajb@gmail.com', 'erfTvc76.', 'Bruno', 'Silaj'],
    [5,'luka103', 'tomic.luka103@gmail.com', 'Diwq.,a34', 'Luka', 'Tomić'],
    [6,'llisjak', 'llisjak34@gmail.com', 'kuzG6FIU', 'Laura', 'Lisjak'],
    [7,'cvjetuljak', 'ines.blaskovic8@gmail.com', 'drfFPOE64', 'Ines', 'Blašković'],
    [8,'ella_pčela', 'ela.pcela342@gmail.com', 'sdgfrsd442.', 'Ela', 'Zrinski'],
    [9,'marac.komarac', 'marko23@gmail.com', 'POJre534', 'Marko', 'Siladi'],
    [10,'leomessi23', 'habijancek@gmail.com', 'A539zGRESOIH', 'Leon', 'Habijan'],
    [11,'andi.paler', 'andi.paler@gmail.com', 's45t!=sfse', 'Andreja', 'Paler'],
    [12,'matekova', 'kovacic_mateo@gmail.com', 'aegrdfn43W487', 'Mateo', 'Kovačić'],
    [13,'izakovaaa', 'izabela_lunilou@gmail.com', 'sf435.,jnf', 'Izabela', 'Kovačević'],
    [14,'sveti.petar', 'sikpero@gmail.com', 'sg54.,edgt', 'Pero', 'Sikirić'],
    [15,'lana18', 'lana188@gmail.com', 'Sfdte3546.', 'Lana', 'Biželj'],
    [16,'drogica_nogica', 'dinodvornik@gmail.com', 'dsgpgiser345', 'Dino', 'Dvornik'],
    [17,'liftuša', 'jelemarin.@gmail.com', 'Swef542e5..', 'Jelena', 'Marinović'],
    [18,'dorica505', 'dorapredojevic@gmail.com', 'Abcdesrga.', 'Dora', 'Predojević'],
    [19,'augusta_xvi', 'pamela_xvi@gmail.com', 'srt45shrtd', 'Pamela', 'Augustinović'],
    [20,'rent4style', 'rent4style@gmail.com', 'Abgsd4525tg', 'Matea', 'Miljan']
];

// Inserting user data into Neo4j graph database
$dbGraph = DBGraph::getConnection();

foreach ($users as $user) {
    $query = 'CREATE (u:User {id: $id, username: $username, email: $email, password: $password, firstName: $firstName, lastName: $lastName})';
    
    $params = [
        'id' => $user[0],
        'username' => $user[1],
        'email' => $user[2],
        'password' => $user[3],
        'firstName' => $user[4],
        'lastName' => $user[5]
    ];

    try {
        $dbGraph->sendCypherQuery($query, $params);
        echo "Inserted user: {$user[1]} <br>";
    } catch (Exception $e) {
        echo 'Error inserting user: ' . $e->getMessage() . '<br>';
    }
}
?>
