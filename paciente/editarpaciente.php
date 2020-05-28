<?php  

header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

require '../connectdb.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
   
    $contents = file_get_contents("php://input");   
    $request = json_decode($contents,true);  
    $primer_nombre = $request["primer_nombre"];
    $segundo_nombre = $request["segundo_nombre"];
    $primer_apellido = $request["primer_apellido"];
    $segundo_apellido = $request["segundo_apellido"];
    $direccion = $request["direccion"];
    $telefono = $request["telefono"];
    $nombre_acom = $request["nombre_acom"];
    $telefono_acom = $request["telefono_acom"];
    $id = $request["id"];

    // verifica que no esten vacio los campos
     if(!empty($primer_nombre) && !empty($primer_apellido) && !empty($direccion) && !empty($telefono)){
        // Prepare an insert statement
        $sql = "UPDATE paciente SET primer_apellido=?,segundo_apellido=?,primer_nombre=?,segundo_nombre=?,direccion=?,telefono=?,nombre_acom= ?,telefono_acom=?,actualizado_por=? where id=?";
        
        if($stmt = mysqli_prepare($con, $sql)){
            // asignar parametros
            mysqli_stmt_bind_param($stmt, "ssssssssii", $param_primer_apellido,$param_segundo_apellido,$param_primer_nombre,$param_segundo_nombre,$param_direccion,$param_telefono,$param_nombre_acom,$param_telefono_acom,$param_actualizado_por,$param_id);
            
            //asignar valor a los parametros
    $param_primer_nombre = $primer_nombre;
     $param_segundo_nombre =  $segundo_nombre;
     $param_primer_apellido = $primer_apellido ;
     $param_segundo_apellido = $segundo_apellido;
     $param_direccion = $direccion;
     $param_telefono = $telefono;
     $param_nombre_acom = $nombre_acom;
     $param_telefono_acom = $telefono_acom;
     $param_actualizado_por= 2;    
     $param_id = $id;   
            

    class Result {}

    $response = new Result();

            // ejecutar sentencia
            if(mysqli_stmt_execute($stmt)){
                
                http_response_code(200);

                 $response->resultado = 'OK';
                 $response->mensaje = 'Paciente Modificado';
                  header('Content-Type: application/json');
    echo json_encode($response);      

            } else{
            header('HTTP/1.1 400 No se pudo modificar el paciente');
            exit(0);
            }

   
           
        }
         // cerrar sentencia 
         mysqli_stmt_close($stmt);
    }
    
    // cerrar la conexion
    mysqli_close($con);

    

    

}else{
    echo "no fue posible realizar la edicion";
}

?>

