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
    $fecha_nacimiento = $request["fecha_nacimiento"];
    $tipo_sangre = $request["tipo_sangre"];
    $id_hospital = intval($request["id_hospital"]);
    $experiencia = $request["experiencia"];
    $correo = $request["correo"];


    if(!checkemail($correo)){
header('HTTP/1.1 400 Correo invalido');
            exit(0);
        }

        if(!validate_phone_number($telefono)){
            header('HTTP/1.1 400 Numero invalido');
            exit(0);
        }
   
        // verifica que no esten vacio los campos
    if(!empty($primer_nombre) && !empty($primer_apellido) && !empty($direccion) && !empty($telefono) && !empty($tipo_sangre)){
      
   if($statement = $con->prepare("CALL crear_doctor(?, ?, ? ,? ,? , ? , ?, ?, ? ,? ,? ,? ,?)")){

  $statement->bind_param("ssssissssssss",$param_primer_nombre,$param_segundo_nombre,$param_primer_apellido, $param_segundo_apellido,$param_id_hospital,$param_direccion,$param_telefono,$param_tipo_sangre,$param_experiencia,$param_fecha_nacimiento,$param_correo,$param_rol,$param_user_id);

  $param_primer_nombre = $primer_nombre;
     $param_segundo_nombre =  $segundo_nombre;
     $param_primer_apellido = $primer_apellido ;
     $param_segundo_apellido = $segundo_apellido;
     $param_direccion = $direccion;
     $param_telefono = $telefono;
     $param_id_hospital = $id_hospital;
     $param_experiencia = $experiencia;
     $param_tipo_sangre = $tipo_sangre;
     $param_fecha_nacimiento = $fecha_nacimiento;
     $param_correo = $correo;
     $param_rol = "doctor";
     $param_user_id = "1";

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


      /*  $sql = "INSERT INTO doctor(primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,direccion,telefono,fecha_nacimiento,tipo_sangre,experiencia,id_hospital,creado_por,actualizado_por)
VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";*/
        
    
       /* if($stmt = mysqli_prepare($con, $sql)){
            // asignar parametros
           
           /* mysqli_stmt_bind_param($stmt, "sssssssssii",$param_primer_apellido,$param_segundo_apellido,$param_primer_nombre, $param_segundo_nombre,$param_direccion,$param_telefono,$param_fecha_nacimiento,$param_tipo_sangre,$param_experiencia,$param_id_hospital,$param_creado_por);
            
            //asignar valor a los parametros

     $param_primer_nombre = $primer_nombre;
     $param_segundo_nombre =  $segundo_nombre;
     $param_primer_apellido = $primer_apellido ;
     $param_segundo_apellido = $segundo_apellido;
     $param_direccion = $direccion;
     $param_telefono = $telefono;
     $param_id_hospital = $id_hospital;
     $param_experiencia = $experiencia;
     $param_tipo_sangre = $tipo_sangre;
     $param_fecha_nacimiento = $fecha_nacimiento;
     $param_creado_por = 1;
*/

     /* class Result {}

    $response = new Result();
            // ejecutar sentencia
            if(mysqli_stmt_execute($stmt)){
                
            
       
                http_response_code(200);
                //echo json_encode($tabResultat);

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
         
     */
    }else{

        header('HTTP/1.1 400 Verifique los datos ingresados');
            exit(0);

    }
   
}else{
    echo "no fue posible realizar la creacion";
}


function checkemail($str) {
         return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
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

