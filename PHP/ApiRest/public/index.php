<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require '../vendor/autoload.php';
require '../src/config/db.php';
$app = new \Slim\App;
//ruta hotel
require '../src/rutas/hotel.php';
//ruta usuario
require '../src/rutas/usuario.php';
$app->run();
