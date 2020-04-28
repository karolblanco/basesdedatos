<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
$app = new \slim\App;
include 'funciones.php';
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
//Funcionalidad: hotel nuevo
$app->post('/api/hotel/nuevo/{apikey}', function(Request $request, Response $response){
$name = $request ->getParam('name');
$address = $request ->getParam('address');
$state = $request ->getParam('state');
$phone= $request ->getParam('phone');
$fax= $request ->getParam('fax');
$email= $request ->getParam('email');
$website= $request ->getParam('website');
$type = $request ->getParam('type');
$rooms= $request ->getParam('rooms');
$apikey= $request ->getAttribute('apikey');

$consulta = "SELECT * FROM hotel";

try {
  $db = new db();
  $db = $db-> conectDB();

  $resultadoid = $db->query($consulta);
  $generado = $resultadoid -> rowcount() ;
  $id = $generado+"1";
  $db=null;
  $resultadoid=null;

} catch (PDOEXCEPTION $e) {
  echo '{"error id" :{"text":'.$e->getMessage().'}';
}


if (busqueda_apikey($apikey) == 1) {
  if (strlen($phone) == 0) {

     //si no está el phone es porque solo va a incluir:
     //nombre, la dirección, el tipo de hotel, el número de habitaciones y el estado
    $sql = "INSERT INTO hotel (id, name, address, state, type, rooms) VALUES
    (:id, :name, :addresss, :type, :rooms, :state)";
    try {
      $db1 = new db();
      $db1 = $db1-> conectDB();
    $resultado = $db1->prepare($sql);
    $resultado ->bindParam(':id', $id);
    $resultado ->bindParam(':name', $name);
    $resultado ->bindParam(':address', $address);
    $resultado ->bindParam(':state', $state);
    $resultado ->bindParam(':type', $type);
    $resultado ->bindParam(':rooms', $rooms);

    $resultado -> execute();
    echo json_encode("hotel agregado ") ;
      $resultado = null;
      $db1= null;

    } catch (PDOEXCEPTION $e) {
      echo '{"error1" :{"text":'.$e->getMessage().'}';
    }

  }else{

    $sql = "INSERT INTO hotel(id, name, address, state, phone, fax, email, website, type, rooms) VALUES
    (:id, :name, :addresss, :state, :phone, :fax, :email, :website, :type, :rooms)";

    try {
      $db = new db();
      $db = $db-> conectDB();
        $resultado = $db->prepare($sql);
        $resultado ->bindParam(':id', $id);
        $resultado ->bindParam(':name', $name);
        $resultado ->bindParam(':address', $address);
        $resultado ->bindParam(':state', $state);
        $resultado ->bindParam(':phone', $phone);
        $resultado ->bindParam(':fax', $fax);
        $resultado ->bindParam(':email', $email);
        $resultado ->bindParam(':website', $website);
        $resultado ->bindParam(':type', $type);
        $resultado ->bindParam(':rooms', $rooms);

    $resultado -> execute();

    echo json_encode("hotel agregado ") ;

      $resultado = null;
      $db= null;

    } catch (PDOEXCEPTION $e) {
      echo '{"error2" :{"text":'.$e->getMessage().'}';
    }
  }
}


});


//update hotel
$app->put('/api/hotel/actualizar/{apikey}/{id}', function(Request $request, Response $response){
$apikey= $request ->getAttribute('apikey');
$id= $request ->getAttribute('id');
$phone= $request ->getParam('phone');
$email= $request ->getParam('email');
$website= $request ->getParam('website');
$type = $request ->getParam('type');
$rooms= $request ->getParam('rooms');

$sql = "UPDATE hotel SET
phone = :phone,
email = :email,
website = :website,
type = :type,
rooms = :rooms
WHERE id = '$id'";


if (busqueda_apikey($apikey) == 1) {
$busqueda = "SELECT * FROM hotel WHERE id = '$id'";
try {
  $db1 = new db();
  $db1 = $db1-> conectDB();
  $confirmacion = $db1->query($busqueda);
  if ($confirmacion -> rowcount() > 0) {
    try {
      $db = new db();
      $db = $db-> conectDB();
      $resultado = $db->prepare($sql);
      $resultado ->bindParam(':phone', $phone);
      $resultado ->bindParam(':email', $email);
      $resultado ->bindParam(':website', $website);
      $resultado ->bindParam(':type', $type);
      $resultado ->bindParam(':rooms', $rooms);
    $resultado -> execute();
    echo json_encode("1: hotel actualizado") ;

      $resultado = null;
      $db= null;

    } catch (PDOEXCEPTION $e) {
      echo '{"0" :{"text":'.$e->getMessage().'}';
    }
  }else{
  echo json_encode("0: hotel no actualizado, id no registrado en la base de datos ") ;
  }

  $confirmacion = null;
  $db1= null;


} catch (PDOEXCEPTION $e) {
  echo '{"error" :{"text":'.$e->getMessage().'}';
}
}

});

//delete para MODIFICAR usuario
$app->delete('/api/hotel/delete/{apikey}/{id}', function(Request $request, Response $response){
$apikey= $request ->getAttribute('apikey');
$id= $request ->getAttribute('id');
$sql = "DELETE from hotel WHERE id = '$id'";

if (busqueda_apikey($apikey) == 1) {
  try {
    $db = new db();
    $db = $db-> conectDB();
    $resultado = $db->prepare($sql);
    $resultado -> execute();

    if ($resultado ->rowCount() >0) {
      echo json_encode("1: hotel eliminado") ;

    }else {
      echo "No hay hoteles con este ID";
    }
    $resultado = null;
    $db= null;

  } catch (PDOEXCEPTION $e) {
    echo '{"0" :{"text":'.$e->getMessage().'}';
  }
}



});
