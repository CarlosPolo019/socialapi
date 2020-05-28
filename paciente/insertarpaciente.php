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
    $eps = $request["eps"];
        // verifica que no esten vacio los campos
        // 

     if(!validate_phone_number($telefono)){
            header('HTTP/1.1 400 Numero invalido');
            exit(0);
        }
   

    if(!empty($primer_nombre) && !empty($primer_apellido) && !empty($direccion) && !empty($telefono) && !empty($eps)){
        // Prepare an insert statement
        $sql = "INSERT INTO paciente(primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,direccion,telefono,eps,nombre_acom,telefono_acom,creado_por,actualizado_por)
VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($con, $sql)){
            // asignar parametros
           
            mysqli_stmt_bind_param($stmt, "sssssssssii",$param_primer_apellido,$param_segundo_apellido,$param_primer_nombre, $param_segundo_nombre,$param_direccion,$param_telefono,$param_eps,$param_nombre_acom,$param_telefono_acom,$param_creado_por,$param_actualizado_por);
            
            //asignar valor a los parametros

     $param_primer_nombre = $primer_nombre;
     $param_segundo_nombre =  $segundo_nombre;
     $param_primer_apellido = $primer_apellido ;
     $param_segundo_apellido = $segundo_apellido;
     $param_direccion = $direccion;
     $param_telefono = $telefono;
     $param_eps = $eps;
     $param_nombre_acom = $nombre_acom;
     $param_telefono_acom = $telefono_acom;
     $param_creado_por = 1;
     $param_actualizado_por= 1;       

      class Result {}

    $response = new Result();
            // ejecutar sentencia
            if(mysqli_stmt_execute($stmt)){
                
    http_response_code(200);
    $response->resultado = 'OK';
    $response->mensaje = 'Paciente creado Correctamente ';

    header('Content-Type: application/json');
    echo json_encode($response);  

            }else{

   header('HTTP/1.1 400 No se pudo crear el paciente');
            exit(0);
            }

        }
         // cerrar sentencia 
         mysqli_stmt_close($stmt);
         
        
    }else{

        header('HTTP/1.1 400 Verifique los datos ingresados');
            exit(0);

    }
    
    // cerrar la conexion
    mysqli_close($con);


}else{
    echo "no fue posible realizar la creacion";
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

