<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//zdobadz ca쿮 info z bazy

$app->get('/api/data', function(Request $request, Response $response){
  $sql = "SELECT * FROM data";
  
  try{
    //zdobacz  info z bazy
    $db = new db();
    //polacz sie z baza
    $db = $db->connect();
    
    $stmt = $db->query($sql);
    $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    echo json_encode($customers);
  }
  catch(PDOException $e){
    echo '{"error": {"text": '.$e->getMessage().'}';
  }
});
// zdobacz jeden wynik
$app->get('/api/data/{id}', function(Request $request, Response $response){
  $id = $request->getAttribute('id');
  
  $sql = "SELECT * FROM data WHERE id = $id";
  
  try{
    //zdobacz ca쿮 info z bazy
    $db = new db();
    //polacz sie z baza
    $db = $db->connect();
    
    $stmt = $db->query($sql);
    $customer = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    echo json_encode($customer);
  }
  catch(PDOException $e){
    echo '{"error": {"text": '.$e->getMessage().'}';
  }
});

// dodaj rekord do bazy
$app->post('/api/data/add', function(Request $request, Response $response){
    $date = $request->getParam('date');
    $id_station = $request->getParam('id_station');
    $soft_ver = $request->getParam('soft_ver');
    $id_conf = $request->getParam('id_conf');
    $d1 = $request->getParam('d1');
    $d2 = $request->getParam('d2');
    $d3 = $request->getParam('d3');
    $d4 = $request->getParam('d4');
  
  $sql = "INSERT INTO data (date,id_station,soft_ver,id_conf,d1,d2,d3,d4) VALUES
    (:date,:id_station,:soft_ver,:id_conf,:d1,:d2,:d3,:d4)";
  
  try{
    //zdobacz ca쿮 info z bazy
    $db = new db();
    //polacz sie z baza
    $db = $db->connect();
    
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':date',                         $date);
    $stmt->bindParam(':id_station',                   $id_station);
    $stmt->bindParam(':soft_ver',                     $soft_ver);
    $stmt->bindParam(':id_conf',                      $id_conf);
    $stmt->bindParam(':d1',                           $d1);
    $stmt->bindParam(':d2',                           $d2);
    $stmt->bindParam(':d3',                           $d3);
    $stmt->bindParam(':d4',                           $d4);
    $stmt->execute();
    echo '{"notice": {"text": "Record Added"}';
  }
  catch(PDOException $e){
    echo '{"error": {"text": '.$e->getMessage().'}';
  }
});

// update rekordu do bazy
$app->put('/api/data/update/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    $date = $request->getParam('date');
    $id_station = $request->getParam('id_station');
    $soft_ver = $request->getParam('soft_ver');
    $id_conf = $request->getParam('id_conf');
    $d1 = $request->getParam('d1');
    $d2 = $request->getParam('d2');
    $d3 = $request->getParam('d3');
    $d4 = $request->getParam('d4');
  
   $sql = "UPDATE data SET
				id_station  = :id_station, 
        date        = :date,  
        soft_ver = :soft_ver, 
        id_conf = :id_conf, 
        d1 = :d1, 
        d2 = :d2, 
        d3 = :d3, 
        d4 = :d4
			WHERE id = $id";
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id_station',             $id_station);
        $stmt->bindParam(':date',                   $date);
        $stmt->bindParam(':soft_ver',               $soft_ver);
        $stmt->bindParam(':id_conf',                $id_conf);
        $stmt->bindParam(':d1',                     $d1);
        $stmt->bindParam(':d2',                     $d2);
        $stmt->bindParam(':d3',                     $d3);
        $stmt->bindParam(':d4',                     $d4);
        $stmt->execute();
        echo '{"notice": {"text": "Record Updated"}';
  }
  catch(PDOException $e){
    echo '{"error": {"text": '.$e->getMessage().'}';
  }
});

// zdobacz jedna stacje
$app->get('/api/data/station/{id_station}', function(Request $request, Response $response){
  $id_station = $request->getAttribute('id_station');
  
  $sql = "SELECT * FROM data WHERE id_station = $id_station";
  
  try{
    //zdobacz ca쿮 info z bazy
    $db = new db();
    //polacz sie z baza
    $db = $db->connect();
    
    $stmt = $db->query($sql);
    $customer = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    echo json_encode($customer);
  }
  catch(PDOException $e){
    echo '{"error": {"text": '.$e->getMessage().'}';
  }
});