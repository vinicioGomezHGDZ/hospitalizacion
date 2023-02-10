<?php  
// incluir conección de base de datos 
include_once("../../../../php/class_consulta.php");
$Con=New Consulta();

$data = json_decode(file_get_contents("php://input"));
      

switch ($data->op){
case '1':
    $Regd=$Con->Get_Consulta("sga_adm_especialidad_profesional
join sga_adm_especialidad es on esp_id_fk=es.esp_id_pk
join sga_adm_profesional pr on pro_id_fk=pr.pro_id_pk
join sga_adm_persona per on pr.per_id_fk = per.per_id_pk"," esp_descripcion,epr_id_pk, per_nombres || ' ' || per_apellidopaterno as profecional ","","","",5);

    if (count($Regd)==0)
    {

        echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));

    }else{
        echo json_encode($Regd);
    }
	break;


default:
break;
		}
?>