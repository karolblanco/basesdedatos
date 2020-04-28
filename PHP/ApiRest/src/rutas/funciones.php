<?php

//Metodo para buscar las apikeys
function busqueda_apikey($value='apikey'){
  $sql = "SELECT id_key FROM apikey WHERE id_key = '$value'";
  try {
  $db = new db();
  $db = $db-> conectDB();
  $resultado = $db->query($sql);
  if ($resultado -> rowcount() > 0) {
    echo "encontró la apikey";
      return 1;
  }else{
    echo "apikey no se encuentra en la base de datos";
    return 0;
  }
  $resultado = null;
  $db= null;
  } catch (\Exception $e) {
      echo '{"error" :{"text":'.$e->getMessage().'}';
  }


}
