<?php  

header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

require '../connectdb.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
   
    $contents = file_get_contents("php://input");   
    $request = json_decode($contents,true);  
    $direccion = $request["direccion"];
    $telefono = $request["telefono"];
    $id_hospital = intval($request["id_hospital"]);
    $experiencia = $request["experiencia"];
    $id = intval($request["id"]);


     if(!validate_phone_number($telefono)){
            header('HTTP/1.1 400 Numero invalido');
            exit(0);
        }

    // verifica que no esten vacio los campos
     if(!empty($direccion) && !empty($telefono) && !empty($id_hospital) && !empty($experiencia) && !empty($id)){
        // Prepare an insert statement
        $sql = "UPDATE doctor SET direccion=?,telefono=?,id_hospital=?,experiencia=?,actualizado_por=? where id=?";
        
        if($stmt = mysqli_prepare($con, $sql)){
            // asignar parametros
            mysqli_stmt_bind_param($stmt, "ssisii", $param_direccion,$param_telefono,$param_id_hospital,$param_experiencia,$param_actualizado_por,$param_id);
            
            //asignar valor a los parametro
     $param_direccion = $direccion;
     $param_telefono = $telefono;
     $param_id_hospital = $id_hospital;
     $param_experiencia = $experiencia;
     $param_actualizado_por= 2;    
     $param_id = $id;   
            

    class Result {}

    $response = new Result();

            // ejecutar sentencia
            if(mysqli_stmt_execute($stmt)){
                
                http_response_code(200);

                 $response->resultado = 'OK';
                 $response->mensaje = 'Doctor Modificado';
                  header('Content-Type: application/json');
    echo json_encode($response);      

            } else{
            header('HTTP/1.1 400 No se pudo modificar el Doctor');
            exit(0);
            }

   
           
        }
         // cerrar sentencia 
         mysqli_stmt_close($stmt);
    }else{
         header('HTTP/1.1 400 No pueden quedar campos vacios');
            exit(0);
    }
    
    // cerrar la conexion
    mysqli_close($con);

}else{
    echo "no fue posible realizar la edicion";
}

function validate_phone_number($phone){
     // Allow +, - and . in phone number
     $filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
    $phone_to_check = str_replace("-", "", $filtered_phone_number);
     // Check the lenght of number
     // This can be customized if you want phone number from a specific country
     if (strlen($phone_to_check) < 10 || strlen($phone_to_check) > 14) {
        return false;
     } else {
       return true;
     }

 }



?>

