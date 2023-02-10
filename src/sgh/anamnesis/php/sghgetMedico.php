<?php
// retornma un json 

include_once("../../../../php/class_consulta.php");

$data = json_decode(file_get_contents("php://input"));
//rint_r($data);

$Con=New Consulta();

switch ($data->op) {
    case '1':
        $Regd=$Con->Get_Consulta("sga_adm_especialidad_profesional as esp
        join sga_adm_profesional pr on esp.pro_id_fk = pr.pro_id_pk
         join sga_adm_especialidad es on esp.esp_id_fk = es.esp_id_pk
        JOIN sga_adm_persona as pe on pe.per_id_pk=pr.per_id_fk WHERE esp_descripcion <>'NO IDENTIFICADO'","pro_id_pk,per_apellidomaterno,per_apellidopaterno,per_nombres,esp_descripcion,pro_codigomsp","","","",5);

        //print_r($Regd);

        if (count($Regd)==0)
        {

            echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));

        }else{
            echo json_encode($Regd);
        }
        break;
    case '2':
        $Regd=$Con->Get_Consulta("sga_adm_especialidad_profesional as esp
        join sga_adm_profesional pr on esp.pro_id_fk = pr.pro_id_pk
         join sga_adm_especialidad es on esp.esp_id_fk = es.esp_id_pk
        JOIN sga_adm_persona as pe on pe.per_id_pk=pr.per_id_fk","pro_id_pk,per_apellidomaterno,per_apellidopaterno,per_nombres,esp_descripcion,pro_codigomsp","","pro_id_pk",$data->codigo,2);
        //print_r($Regd);
        if (count($Regd)==0)
        {

            echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));

        }else{
            echo json_encode($Regd);
        }
        break;
}
?>