<?php
// retornma un json 

include_once("../../../../php/class_consulta.php");
$Con=New Consulta();

$data = json_decode(file_get_contents("php://input"));
$error="error";
switch ($data->op) {
	
case '1':
	// cargar datos de bacteriologia //
	$Regd=$Con->Get_Consulta("sgh_sol_bacteriologico as bac
	JOIN sga_adm_historiaclinica as hcl on hce_id_fk= hcl.hce_id_pk
	JOIN sga_adm_paciente as pa on hcl.pac_id_fk = pa.pac_id_pk
	JOIN sga_adm_persona as per on pa.per_id_fk=per.per_id_pk
	join sgh_mei_censo as cen on cen.hce_id_fk=hcl.hce_id_pk
	JOIN sga_adm_cama as  cam on cen.cam_id_fk=cam.cam_id_pk
	join sga_adm_tipocama as sala on cam.tca_habi_fk=sala.tca_id_pk
	join sga_adm_tipocama as serv on cam.tca_serv_fk=serv.tca_id_pk
	where bac_result='null' and cen.cen_visible=true order by bac_id_pk desc","bac.bac_fecha,per_nombres,per_apellidopaterno,per_apellidomaterno,serv.tca_descripcion as servicio,sala.tca_descripcion,cam_codigo,bac_id_pk","","","",5);
				if (count($Regd)==0) 
				{

				echo json_encode(array('error' => $error,));

				}else{
				echo json_encode($Regd); 
				}
break;
case '2':
  // cargar datos de servico vaqginal 
	$Regd=$Con->Get_Consulta("sgh_sol_cervicov as bac
	JOIN sga_adm_historiaclinica as hcl on hce_id_fk= hcl.hce_id_pk
	JOIN sga_adm_paciente as pa on hcl.pac_id_fk = pa.pac_id_pk
	JOIN sga_adm_persona as per on pa.per_id_fk=per.per_id_pk
	join sgh_mei_censo as cen on cen.hce_id_fk=hcl.hce_id_pk
	JOIN sga_adm_cama as  cam on cen.cam_id_fk=cam.cam_id_pk
	join sga_adm_tipocama as sala on cam.tca_habi_fk=sala.tca_id_pk
	join sga_adm_tipocama as serv on cam.tca_serv_fk=serv.tca_id_pk
	where ccv_result='null' and cen.cen_visible=true order by ccv_id_pk desc  ","bac.ccv_fetomu,per_nombres,per_apellidopaterno,per_apellidomaterno,serv.tca_descripcion as servicio,sala.tca_descripcion,cam_codigo,ccv_id_pk","","","",5);
				if (count($Regd)==0) 
				{

				echo json_encode(array('error' => $error,));

				}else{
				echo json_encode($Regd); 
				}
break;
case '3':
    // cargar datos de histopatologia
	$Regd=$Con->Get_Consulta("sgh_sol_histopa as bac
	JOIN sga_adm_historiaclinica as hcl on hce_id_fk= hcl.hce_id_pk
	JOIN sga_adm_paciente as pa on hcl.pac_id_fk = pa.pac_id_pk
	JOIN sga_adm_persona as per on pa.per_id_fk=per.per_id_pk
	join sgh_mei_censo as cen on cen.hce_id_fk=hcl.hce_id_pk
	JOIN sga_adm_cama as  cam on cen.cam_id_fk=cam.cam_id_pk
	join sga_adm_tipocama as sala on cam.tca_habi_fk=sala.tca_id_pk
	join sga_adm_tipocama as serv on cam.tca_serv_fk=serv.tca_id_pk
	where his_resul='null' and cen.cen_visible=true order by his_id_pk desc","his_id_pk,bac.his_fecha,per_nombres,per_apellidopaterno,per_apellidomaterno,serv.tca_descripcion as servicio,sala.tca_descripcion,cam_codigo,his_priori","","","",5);
				if (count($Regd)==0) 
				{

				echo json_encode(array('error' => $error,));

				}else{
				echo json_encode($Regd); 
				}
break;
case '4':
  	// cargar datos de imagenologia
    $Regd=$Con->Get_Consulta("sgh_sol_imagenolo as bac
	JOIN sga_adm_historiaclinica as hcl on hce_id_fk= hcl.hce_id_pk
	JOIN sga_adm_paciente as pa on hcl.pac_id_fk = pa.pac_id_pk
	JOIN sga_adm_persona as per on pa.per_id_fk=per.per_id_pk
	join sgh_mei_censo as cen on cen.hce_id_fk=hcl.hce_id_pk
	JOIN sga_adm_cama as  cam on cen.cam_id_fk=cam.cam_id_pk
	join sga_adm_tipocama as sala on cam.tca_habi_fk=sala.tca_id_pk
	join sga_adm_tipocama as serv on cam.tca_serv_fk=serv.tca_id_pk
	where ima_result='null' and cen.cen_visible=true ","*","","","",5);
	if (count($Regd)==0) 
	{
		echo json_encode(array('error' => $error,));
	}else{
	echo json_encode($Regd); 
				}
break;
case '5':
	// cargar datos de microbiologia
 	$Regd=$Con->Get_Consulta("sgh_sol_microbiologico as bac
	JOIN sga_adm_historiaclinica as hcl on hce_id_fk= hcl.hce_id_pk
	JOIN sga_adm_paciente as pa on hcl.pac_id_fk = pa.pac_id_pk
	JOIN sga_adm_persona as per on pa.per_id_fk=per.per_id_pk
	join sgh_mei_censo as cen on cen.hce_id_fk=hcl.hce_id_pk
	JOIN sga_adm_cama as  cam on cen.cam_id_fk=cam.cam_id_pk
	join sga_adm_tipocama as sala on cam.tca_habi_fk=sala.tca_id_pk
	join sga_adm_tipocama as serv on cam.tca_serv_fk=serv.tca_id_pk
	where mic_result='null' and cen.cen_visible=true order by mic_if_pk desc","mic_if_pk,bac.mic_fecha,per_nombres,per_apellidopaterno,per_apellidomaterno,serv.tca_descripcion as servicio,sala.tca_descripcion,cam_codigo","","","",5);
				if (count($Regd)==0) 
				{

				echo json_encode(array('error' => $error,));

				}else{
				echo json_encode($Regd); 
				}
 break;
case '6':
 	// cargar datos de via/sida
	   $Regd=$Con->Get_Consulta("sgh_sol_vih as bac
	JOIN sga_adm_historiaclinica as hcl on hce_id_fk= hcl.hce_id_pk
	JOIN sga_adm_paciente as pa on hcl.pac_id_fk = pa.pac_id_pk
	JOIN sga_adm_persona as per on pa.per_id_fk=per.per_id_pk
	join sgh_mei_censo as cen on cen.hce_id_fk=hcl.hce_id_pk
	JOIN sga_adm_cama as  cam on cen.cam_id_fk=cam.cam_id_pk
	join sga_adm_tipocama as sala on cam.tca_habi_fk=sala.tca_id_pk
	join sga_adm_tipocama as serv on cam.tca_serv_fk=serv.tca_id_pk
	where vih_result='null' and cen.cen_visible=true order by vih_id_pk desc","vih_id_pk,bac.vih_fecha,per_nombres,per_apellidopaterno,per_apellidomaterno,serv.tca_descripcion as servicio,sala.tca_descripcion,cam_codigo,vih_motivo,vih_otros,vih_conce","","","",5);
				if (count($Regd)==0) 
				{

				echo json_encode(array('error' => $error,));

				}else{
				echo json_encode($Regd); 
				}

 		# code...
break;
case '7':
 	 // CARGAR DATOS DE LABORATORIO
 	   $Regd=$Con->Get_Consulta("sgh_sol_lab as bac
				JOIN sga_adm_historiaclinica as hcl on hce_id_fk= hcl.hce_id_pk
				JOIN sga_adm_paciente as pa on hcl.pac_id_fk = pa.pac_id_pk
				JOIN sga_adm_persona as per on pa.per_id_fk=per.per_id_pk
				join sgh_mei_censo as cen on cen.hce_id_fk=hcl.hce_id_pk
				JOIN sga_adm_cama as  cam on cen.cam_id_fk=cam.cam_id_pk
				join sga_adm_tipocama as sala on cam.tca_habi_fk=sala.tca_id_pk
				join sga_adm_tipocama as serv on cam.tca_serv_fk=serv.tca_id_pk
				where lab_resut='null' and cen.cen_visible=true order by lab_id_pk desc","lab_id_pk,lab_priori,lab_id_pk,bac.lab_fecmu,per_nombres,per_apellidopaterno,per_apellidomaterno,serv.tca_descripcion as servicio,sala.tca_descripcion,cam_codigo","","","",5);
				if (count($Regd)==0) 
				{

				echo json_encode(array('error' => $error,));

				}else{
				echo json_encode($Regd); 
				}
 			# code...
break;

case '8':
 // cargar datos de laboratorio con sus prioridades 
 	  $Regd=$Con->Get_Consulta("sgh_sol_lab as bac
				JOIN sga_adm_historiaclinica as hcl on hce_id_fk= hcl.hce_id_pk
				JOIN sga_adm_paciente as pa on hcl.pac_id_fk = pa.pac_id_pk
				JOIN sga_adm_persona as per on pa.per_id_fk=per.per_id_pk
				join sgh_mei_censo as cen on cen.hce_id_fk=hcl.hce_id_pk
				JOIN sga_adm_cama as  cam on cen.cam_id_fk=cam.cam_id_pk
				join sga_adm_tipocama as sala on cam.tca_habi_fk=sala.tca_id_pk
				join sga_adm_tipocama as serv on cam.tca_serv_fk=serv.tca_id_pk
				where lab_resut='null' and cen.cen_visible=true and lab_priori='".$data->prio."' order by lab_id_pk desc","lab_priori,lab_id_pk,bac.lab_fecmu,per_nombres,per_apellidopaterno,per_apellidomaterno,serv.tca_descripcion as servicio,sala.tca_descripcion,cam_codigo","","","",5);
				if (count($Regd)==0) 
				{

				echo json_encode(array('error' => $error,));

				}else{
				echo json_encode($Regd); 
				}
 			# code...
break;
case '9':
    // cargar datos de histopatologia
	$Regd=$Con->Get_Consulta("sgh_sol_histopa as bac
	JOIN sga_adm_historiaclinica as hcl on hce_id_fk= hcl.hce_id_pk
	JOIN sga_adm_paciente as pa on hcl.pac_id_fk = pa.pac_id_pk
	JOIN sga_adm_persona as per on pa.per_id_fk=per.per_id_pk
	join sgh_mei_censo as cen on cen.hce_id_fk=hcl.hce_id_pk
	JOIN sga_adm_cama as  cam on cen.cam_id_fk=cam.cam_id_pk
	join sga_adm_tipocama as sala on cam.tca_habi_fk=sala.tca_id_pk
	join sga_adm_tipocama as serv on cam.tca_serv_fk=serv.tca_id_pk
	where his_resul='null' and his_priori ='".$data->prio."' and cen.cen_visible=true order by his_id_pk desc","his_id_pk,bac.his_fecha,per_nombres,per_apellidopaterno,per_apellidomaterno,serv.tca_descripcion as servicio,sala.tca_descripcion,cam_codigo,his_priori","","","",5);
				if (count($Regd)==0) 
				{

				echo json_encode(array('error' => $error,));

				}else{
				echo json_encode($Regd); 
				}
break;
default:
# code...
break;
		}		
				     
?>
