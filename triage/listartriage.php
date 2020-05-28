<?php

header("Access-Control-Allow-Origin: *");
require '../connectdb.php';
error_reporting(E_ERROR);
$triages = [];
$id_doctor = $_GET["id"];

$id = strval($id_doctor);
$sql = "select t.id as 'id',CONCAT(d.primer_nombre,' ',d.primer_apellido) as 'nombre_doctor',CONCAT(p.primer_nombre,' ',p.primer_apellido) as 'nombre_paciente' , t.motivo_consulta as 'motivo_consulta' , t.diagnostico as 'diagnostico' , t.medicamento as 'medicamento', t.resultado_cov as 'resultado_cov' from triage t inner join paciente p on p.id = t.id_paciente inner join doctor d on d.id = t.id_doctor where d.id = t.id_doctor and p.id = t.id_paciente and t.eliminado is null and t.id_doctor=".$id." ORDER BY t.id DESC";

if($result = mysqli_query($con,$sql)){
    $id = 0;
    while($row = mysqli_fetch_assoc($result)){
        $triages[$id]['id'] = $row['id'];
        $triages[$id]['id_paciente'] = $row['nombre_paciente'];
        $triages[$id]['id_doctor'] = $row['nombre_doctor'];
        $triages[$id]['motivo_consulta'] = $row['motivo_consulta'];
        $triages[$id]['diagnostico'] = $row['diagnostico'];
        $triages[$id]['medicamento'] = $row['medicamento'];
        $triages[$id]['resultado_cov'] = $row['resultado_cov'];
        $id++;
    }
    header('Content-type: application/json');
    echo json_encode($triages);

}else{
     header('HTTP/1.1 400 Hubo un problema, verifique la tabla paciente');
            exit(0);
}

?>