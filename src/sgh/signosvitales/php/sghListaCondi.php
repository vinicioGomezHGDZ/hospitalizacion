<?php
// retornma un json 

include_once("../../../../php/class_consulta.php");

$Con=New Consulta();
$error="error";
$data = json_decode(file_get_contents("php://input"));

$Regd=$Con->Get_Consulta("sgh_mei_condipac JOIN sga_adm_cama  as ca on cam_id_fk=ca.cam_id_pk 
	join sga_adm_tipocama as cama on tca_habi_fk= cama.tca_id_pk where hce_id_fk='".$data->idhc."' order by cdp_fecha desc",
			"tca_descripcion,cdp_fecha,cam_codigo,cdp_condic,cdp_fpalta,cdp_fopera,cdp_fuoper,cdp_id_med","","","",5);
				if (count($Regd)==0) 
				{

				echo json_encode(array('error' =>$error, )); 

				}else{
				echo json_encode($Regd); 
				} 
?>