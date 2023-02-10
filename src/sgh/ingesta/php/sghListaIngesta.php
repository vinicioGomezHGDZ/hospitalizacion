<?php
// retornma un json 
date_default_timezone_set('America/Guayaquil');
include_once("../../../../php/class_consulta.php");

$Con=New Consulta();

$error="error";
$data = json_decode(file_get_contents("php://input"));


		    $Regd=$Con->Get_Consulta("sgh_mei_ingrelimi
			JOIN sga_adm_cama  as ca on cam_id_fk=ca.cam_id_pk
	    	JOIN sgu_usu_usuario as us on usu_id_fk = us.usu_id_pk
	    	JOIN sga_adm_profesional as pr on us.pro_id_fk = pr.pro_id_pk
			JOIN sga_adm_persona as pe  on pr.per_id_fk= pe.per_id_pk
			JOIN sga_adm_profesion as pro on pr.prf_id_fk = pro.prf_id_pk
      		join sga_adm_tipocama as tp on ca.tca_habi_fk= tp.tca_id_pk where hce_id_fk='".$data->idhc."'
			order by cie_fecha desc",
			"cie_fecha,per_nombres,per_apellidopaterno,per_apellidomaterno,prf_descripcion,tp.tca_descripcion,cam_codigo","","","",6);
    
	     //print_r($Regd);
	   
				if (count($Regd)==0) 
				{

				echo json_encode(array('error' =>$error, )); 

				}else{
				echo json_encode($Regd); 
				} 
?>