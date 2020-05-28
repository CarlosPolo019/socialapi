<?php

/*
Desarrollado Por: Luis Reales
Fecha: Mayo 16/2020

*/

//DB credenciales
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','mysql');
define('DB_NAME','angularwebdb');


function connect_db(){

    $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  
    if(mysqli_connect_errno($connect)){
        die("Fallo la conexion a la bd angularwebdb".mysqli_connect_errno());
    }

    return $connect;

}
$con = connect_db();

?>