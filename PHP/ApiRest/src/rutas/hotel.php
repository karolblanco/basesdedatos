<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
$app = new \slim\App;

//get hotel por estado
$app->get('/api/hotel/state/{state_hotel}', function(Request $request, Response $response){
$statehotel = $request->getAttribute('state_hotel');
$sql = "SELECT * FROM hotel WHERE state_hotel = '$statehotel'";
try {
  $db = new db();
  $db = $db-> conectDB();
  $resultado = $db->query($sql);
  if ($resultado -> rowcount() > 0) {
    $hotel = $resultado->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($hotel);
  }else{
    echo json_encode("no existen hoteles de ese estado en la base de datos ") ;
  }
  $resultado = null;
  $db= null;
} catch (PDOEXCEPTION $e) {
  echo '{"error" :{"text":'.$e->getMessage().'}';
}

});


//get hotel por nombre
$app->get('/api/hotel/name/{name_hotel}', function(Request $request, Response $response){
$namehotel = $request->getAttribute('name_hotel');
$sql = "SELECT * FROM hotel WHERE  name_hotel = '$namehotel'";
try {
  $db = new db();
  $db = $db-> conectDB();
  $resultado = $db->query($sql);
  if ($resultado -> rowcount() > 0) {
    $hotel = $resultado->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($hotel);
  }else{
    echo json_encode("no existen hoteles en la base de datos que contengan ese nombre ") ;
  }
  $resultado = null;
  $db= null;
} catch (PDOEXCEPTION $e) {
  echo '{"error" :{"text":'.$e->getMessage().'}';
}

});

//get hotel por tipo
$app->get('/api/hotel/type/{type_hotel}', function(Request $request, Response $response){
$typehotel = $request->getAttribute('type_hotel');
$sql = "SELECT * FROM hotel WHERE  type_hotel = '$typehotel'";
try {
  $db = new db();
  $db = $db-> conectDB();
  $resultado = $db->query($sql);
  if ($resultado -> rowcount() > 0) {
    $hotel = $resultado->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($hotel);
  }else{
    echo json_encode("no existen ese tipo de hoteles en la base de datos  ") ;
  }
  $resultado = null;
  $db= null;
} catch (PDOEXCEPTION $e) {
  echo '{"error" :{"text":'.$e->getMessage().'}';
}

});
//get hotel por tamaño
$app->get('/api/hotel/size/{rooms_hotel}', function(Request $request, Response $response){
$tamaños = $request->getAttribute('rooms_hotel');
  switch ($tamaños) {
    case 'small':
    $sql = "SELECT * FROM hotel WHERE rooms_hotel <= 50";
    try {
      $db = new db();
      $db = $db-> conectDB();
      $resultado = $db->query($sql);
      if ($resultado -> rowcount() > 0) {
        $hotel = $resultado->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($hotel);
      }else{
        echo json_encode("no existen hoteles en la base de datos con tamaño small") ;
      }
      $resultado = null;
      $db= null;
    } catch (PDOEXCEPTION $e) {
      echo '{"error" :{"text":'.$e->getMessage().'}';
    }
      break;

    case 'medium':
    $sql = "SELECT * FROM hotel WHERE rooms_hotel >= 51 AND rooms_hotel <= 100";
    try {
      $db = new db();
      $db = $db-> conectDB();
      $resultado = $db->query($sql);
      if ($resultado -> rowcount() > 0) {
        $hotel = $resultado->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($hotel);
      }else{
        echo json_encode("no existen hoteles en la base de datos con tamaño medium") ;
      }
      $resultado = null;
      $db= null;
    } catch (PDOEXCEPTION $e) {
      echo '{"error" :{"text":'.$e->getMessage().'}';
    }
      break;

      case 'large':
      $sql = "SELECT * FROM hotel WHERE rooms_hotel > 100";
      try {
        $db = new db();
        $db = $db-> conectDB();
        $resultado = $db->query($sql);
        if ($resultado -> rowcount() > 0) {
          $hotel = $resultado->fetchAll(PDO::FETCH_OBJ);
          echo json_encode($hotel);
        }else{
          echo json_encode("no existen hoteles en la base de datos con tamaño large") ;
        }
        $resultado = null;
        $db= null;
      } catch (PDOEXCEPTION $e) {
        echo '{"error" :{"text":'.$e->getMessage().'}';
      }
        break;

  }

});
