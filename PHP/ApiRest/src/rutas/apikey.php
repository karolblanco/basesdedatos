<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
$app = new \slim\App;

/*
8. Cree una nueva clave API. Este servicio espera como parámetros nombre de contacto,
empresa y correo electrónico.
El sitio generará una clave API aleatoria que los usuarios deben usar para llamar a
ciertas partes de la API. En un escenario real, Expedia no generaría claves
API para cualquier usuario sin restricciones.
 */
 $app->post('/api/apikey/nuevo', function(Request $request, Response $response){
 $nombre = $request ->getParam('nombre');
 $empresa = $request ->getParam('empresa');
 $email = $request ->getParam('email');
 $apikeygenerada = rand(1,100);
 $consulta = "SELECT * FROM apikey where id_key = '$apikeygenerada'";

 try {
   $db1 = new db();
   $db1 = $db1-> conectDB();
   $resultadoconsulta = $db1->query($consulta);
   while ($resultadoconsulta -> rowcount() > 0) {
     $apikeygenerada = rand(1,100);
   }
   $sql = "INSERT INTO apikey (nombre_key, empresa_key, email_key, id_key) VALUES
   (:nombre, :empresa, :email, :apikeygenerada)";
   try {
     $db = new db();
     $db = $db-> conectDB();
     $resultado = $db->prepare($sql);
   $resultado ->bindParam(':nombre', $nombre);
   $resultado ->bindParam(':empresa', $empresa);
   $resultado ->bindParam(':email', $email);
   $resultado ->bindParam(':apikeygenerada', $apikeygenerada);

   $resultado -> execute();
   echo json_encode("apikey: $apikeygenerada") ;

     $resultado = null;
     $db= null;

   } catch (PDOEXCEPTION $e) {
     echo '{"error" :{"text":'.$e->getMessage().'}';
   }
$resultadoconsulta= null;
$db1=null;

 } catch (PDOEXCEPTION $e) {
   echo '{"error" :{"text":'.$e->getMessage().'}';
 }



 });
