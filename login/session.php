<?php

header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

require '../connectdb.php';


if($_SERVER["REQUEST_METHOD"] == "POST"){

 $contents = file_get_contents("php://input");   
    $request = json_decode($contents,true);  

$email = $request["email"];
$contraseña = $request["password"];

$sql = "select d.*, u.email from doctor d inner join usuario u on d.usuario_id = u.id where d.usuario_id = u.id and u.email = '".$email."' and u.contrasena = '".$contraseña."'";

if($result = mysqli_query($con,$sql)){
    

    //obtiene y verifica que exista al menos 1 registro
    if(mysqli_num_rows($result) == 1){
        //recorre el resultado y lo convierte en un array
        $row = mysqli_fetch_array($result);
        
        // Retrieve individual field value

         $nombre = $row["primer_nombre"]." ".$row["primer_apellido"];

        class Result {}

        $response = new Result();
        $response->id = $row["id"];
        $response->nombre = $nombre;
        

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

}else{

    header('HTTP/1.1 400 Peticion no permitida');
            exit(0);

}
?>