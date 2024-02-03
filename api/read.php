<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Max-Age: 3600");
    header("Content-Type: application/json; charset=UTF-8");

    require_once '../config/config.php';
    require_once '../Lib/BaseDatos.php';
    require_once '../Models/Paciente.php';

    use Models\Paciente;

    $patient = new Paciente();
    $pacientes = $patient->getAll();
    $patientsCount = $patient->filasAfectadas();

    if($patientsCount > 0){
        $PacienteArr = array();
        $PacienteArr["status_header"] = "HTTP/1.1 200 OK";
        $PacienteArr["numberPatients"] = $patientsCount;
        $PacienteArr["patients"]=array();
        foreach ($pacientes as $fila){
            array_push($PacienteArr["patients"], $fila);
        }
        http_response_code(202);
        echo json_encode($PacienteArr);
    }else{
        http_response_code(404);
        echo json_encode(array("message"=>"No hay pacientes"));
    }


?>