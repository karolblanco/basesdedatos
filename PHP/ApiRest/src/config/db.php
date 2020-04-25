<?php
/**
 *
 */
class db{
  private $dbHost = 'localhost';
  private $dbUser = 'root';
  private $dbPass = '123123';
  private $dbName = 'laboratoriobd';
  //connection
  public function conectDB(){
    $mysqlConnect = "mysql:host=$this->dbHost;port=33065;dbname=$this->dbName";
    $dbConnecion = new PDO($mysqlConnect, $this->dbUser, $this->dbPass);
    $dbConnecion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbConnecion;

  }
}
