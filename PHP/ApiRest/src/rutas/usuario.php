<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
$app = new \slim\App;

//POST para crear usuarios
//getparam recuperamos los campos que van a enviarnos desde el json
$app->post('/api/usuario/nuevo', function(Request $request, Response $response){
$nombre = $request ->getParam('nombre');
$apellidos = $request ->getParam('apellidos');
$email = $request ->getParam('email');
$password = $request ->getParam('password');
$direccion = $request ->getParam('direccion');

$consulta = "SELECT * FROM usuario";

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

$sql = "INSERT INTO usuario (nombre, apellidos, email, password, direccion, id) VALUES
(:nombre, :apellidos, :email, :password, :direccion, :id)";
try {
  $db = new db();
  $db = $db-> conectDB();
  $resultado = $db->prepare($sql);
$resultado ->bindParam(':nombre', $nombre);
$resultado ->bindParam(':apellidos', $apellidos);
$resultado ->bindParam(':email', $email);
$resultado ->bindParam(':password', $password);
$resultado ->bindParam(':direccion', $direccion);
$resultado ->bindParam(':id', $id);

$resultado -> execute();
echo json_encode("cliente agregado ") ;

  $resultado = null;
  $db= null;

} catch (PDOEXCEPTION $e) {
  echo '{"error" :{"text":'.$e->getMessage().'}';
}

});

//metodo para saber si un usuario se encuentra en la base de datos dado un id, password y $direccion

//PUT para MODIFICAR usuario
$app->put('/api/usuario/actualizar/{id}/{password}/{direccion}', function(Request $request, Response $response){
$id= $request ->getAttribute('id');
$password = $request ->getAttribute('password');
$direccion = $request ->getAttribute('direccion');
$nombre = $request ->getParam('nombre');
$apellidos = $request ->getParam('apellidos');
$email = $request ->getParam('email');
$passwordcambio = $request ->getParam('password');
$direccioncambio = $request ->getParam('direccion');

$sql = "UPDATE usuario SET
nombre = :nombre,
apellidos = :apellidos,
email = :email,
password = :password,
direccion = :direccion
WHERE id = '$id' AND password='$password' AND direccion='$direccion'";

$busqueda = "SELECT * FROM usuario WHERE id = '$id'
AND password='$password' AND direccion='$direccion'";
try {
  $db1 = new db();
  $db1 = $db1-> conectDB();
  $confirmacion = $db1->query($busqueda);
  if ($confirmacion -> rowcount() > 0) {
    try {
      $db = new db();
      $db = $db-> conectDB();
      $resultado = $db->prepare($sql);
    $resultado ->bindParam(':nombre', $nombre);
    $resultado ->bindParam(':apellidos', $apellidos);
    $resultado ->bindParam(':email', $email);
    $resultado ->bindParam(':password', $passwordcambio);
    $resultado ->bindParam(':direccion', $direccioncambio);
    $resultado -> execute();
    echo json_encode("1: cliente actualizado ") ;

      $resultado = null;
      $db= null;

    } catch (PDOEXCEPTION $e) {
      echo '{"0" :{"text":'.$e->getMessage().'}';
    }
  }else{
  echo json_encode("0: cliente no actualizado, parametros incorrectos ") ;
  }

  $confirmacion = null;
  $db1= null;


} catch (PDOEXCEPTION $e) {
  echo '{"error" :{"text":'.$e->getMessage().'}';
}

});
