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
