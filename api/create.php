<?php 

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Contro-Allow-Headers, Authorization, X-Requested-With");

    require_once '../config/config.php';
    require_once '../Lib/BaseDatos.php';
    require_once '../Services/PacienteService.php';

    use Services\PacienteService;

    $service = new PacienteService();
    
    $data = json_decode(file_get_contents("php://input"));
    if(!empty($data->nombre)&&!empty($data->apellidos)&&!empty($data->correo)&&!empty($data->password)){
        if($service->insert($data->nombre,$data->apellidos,$data->correo,$data->password)){
            http_response_code(201);
            echo json_encode(array("message"=>"Creado con exito"));
        }else{
            http_response_code(503);
            echo json_encode(array("message"=>"No se ha creado"));
        }
    }else{
        http_response_code(404);
        echo json_encode(array("message"=>"No se ha creado. Faltan datos"));
    }
?>