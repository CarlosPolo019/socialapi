<?php

header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

require '../connectdb.php';

$pacientes = [];
$id_doctor = $_GET["id"];

$id = strval($id_doctor);
$sql = "select d.*, u.email from doctor d inner join usuario u on d.usuario_id = u.id where d.usuario_id = u.id and d.id=".$id;

if($result = mysqli_query($con,$sql)){
    

    //obtiene y verifica que exista al menos 1 registro
    if(mysqli_num_rows($result) == 1){
        //recorre el resultado y lo convierte en un array
        $row = mysqli_fetch_array($result);
        
        // Retrieve individual field value
    $primer_nombre = $row["primer_nombre"];
    $segundo_nombre = $row["segundo_nombre"];
    $primer_apellido = $row["primer_apellido"];
    $segundo_apellido = $row["segundo_apellido"];
    $direccion = $row["direccion"];
    $telefono = $row["telefono"];
    $fecha_nacimiento = $row["fecha_nacimiento"];
    $tipo_sangre = $row["tipo_sangre"];
    $id_hospital = $row["id_hospital"];
    $experiencia = $row["experiencia"];
    $correo = $row["email"];

        class Result {}

        $response = new Result();
        $response->id = $id;
        $response->primer_nombre = $primer_nombre;
        $response->segundo_nombre = $segundo_nombre;
        $response->direccion =  $direccion;
        $response->primer_apellido = $primer_apellido;
        $response->segundo_apellido = $segundo_apellido;
        $response->telefono = $telefono;
        $response->tipo_sangre = $tipo_sangre;
        $response->id_hospital = $id_hospital;
        $response->experiencia = $experiencia;
        $response->fecha_nacimiento = $fecha_nacimiento;
        $response->correo = $correo;

        header('Content-Type: application/json');
        echo json_encode($response);   


    } else{
             header('HTTP/1.1 400 no existe ningun registro');
            exit(0);
    }

}else{
         header('HTTP/1.1 400 No se pudo consultar el paciente');
            exit(0);
}
?>