<?php

header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

require '../connectdb.php';

$pacientes = [];
$id_doctor = intval($_GET["id"]);
$id_usuario = intval($_GET["usuario_id"]);

     // verifica que no esten vacio los campos
if(!empty($id_doctor) && !empty($id_usuario)){
      
   if($statement = $con->prepare("CALL eliminar_doctor(?, ?)")){

  $statement->bind_param("ii",$param_id_usuario,$param_id_doctor);

    $param_id_usuario = $id_usuario;
    $param_id_doctor =  $id_doctor;
    $statement->execute();
    $statement->bind_result($exito, $mensaje);

    /* obtener valores */
    $statement->fetch();

class Result {}

    $response = new Result();

if($exito == 1){

    http_response_code(200);

    $response->resultado = 'OK';
    $response->mensaje = $mensaje;

    header('Content-Type: application/json');
     echo json_encode($response);  

    }else{

   header('HTTP/1.1 400 Error al crear el doctor');
            exit(0);
    }

 /* cerrar la sentencia */
    $statement->close();

   }



}else{
     header('HTTP/1.1 400 No se pudo eliminar el doctor');
            exit(0);
        }

?>