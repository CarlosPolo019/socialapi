<?php  

header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
require '../connectdb.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
   
    $contents = file_get_contents("php://input");   
    $request = json_decode($contents,true);  
   
    $id_paciente = intval($request["id_paciente"]);
    $motivo_consulta = $request["motivo_consulta"];
    $resultado_cov = $request["resultado_cov"];
    $diagnostico = $request["diagnostico"];
    $medicamento = $request["medicamento"];
    $id_doctor = intval($request["id_doctor"]);
   
        // verifica que no esten vacio los campos
    if(!empty($id_paciente) && !empty($motivo_consulta) && !empty($resultado_cov) && !empty($id_doctor)){
      
 

$sql = "INSERT INTO triage(id_paciente,motivo_consulta,resultado_cov,diagnostico,medicamento,id_doctor,creado_por,actualizado_por)
VALUES(?,?,?,?,?,?,?,?)";
        
if($stmt = mysqli_prepare($con, $sql)){
            // asignar parametros
           
     mysqli_stmt_bind_param($stmt, "issssiii",$param_id_paciente,$param_motivo_consulta,$param_resultado_cov, $param_diagnostico,$param_medicamento,$param_id_doctor,$param_creado_por,$param_actualizado_por);
            
            //asignar valor a los parametros

   $param_id_paciente = $id_paciente;
   $param_motivo_consulta = $motivo_consulta;
   $param_resultado_cov = $resultado_cov;
$param_diagnostico = $diagnostico;
    $param_medicamento = $medicamento;
    $param_id_doctor = $id_doctor;
    $param_creado_por = $id_doctor;
    $param_actualizado_por = $id_doctor; 

    class Result {}

    $response = new Result();
            // ejecutar sentencia
            if(mysqli_stmt_execute($stmt)){
                
        
                http_response_code(200);
                //echo json_encode($tabResultat);
    $response->resultado = 'OK';
    $response->mensaje = 'Registro creado Correctamente ';

    header('Content-Type: application/json');
     echo json_encode($response);  

            }else{

   header('HTTP/1.1 400 No se pudo crear el registro');
            exit(0);
            }

        }
         // cerrar sentencia 
         mysqli_stmt_close($stmt);
         
    
    }else{

        header('HTTP/1.1 400 Verifique los datos ingresados');
            exit(0);

    }
   
}else{
    echo "no fue posible realizar la creacion";
}


?>

