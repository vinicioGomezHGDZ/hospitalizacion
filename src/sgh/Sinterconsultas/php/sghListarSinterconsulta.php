<?php
// retornma un json 

include_once("../../../../php/class_consulta.php");
$Con=New Consulta();

$data = json_decode(file_get_contents("php://input"));
$error="error";
switch ($data->op) {
	
case '1':
	// cargar datos de bacteriologia //
	$Regd=$Con->Get_Consulta("sgh_mei_intercsol as int
							jOIN sgh_mei_motdes as mo on mo.int_id_fk= int.int_id_pk
							join sga_adm_historiaclinica hc on int.hce_id_fk=hc.hce_id_pk
              JOIN sga_adm_paciente as pa on pac_id_fk=pa.pac_id_pk
							JOIN sga_adm_persona as pe on pa.per_id_fk=pe.per_id_pk
              JOIN sga_adm_cama as  cam on mo.cam_id_fk=cam.cam_id_pk
	join sga_adm_tipocama as sala on cam.tca_piso_fk=sala.tca_id_pk
	join sga_adm_tipocama as serv on cam.tca_serv_fk=serv.tca_id_pk
		join sgh_mei_censo as cen on cen.hce_id_fk = int.hce_id_fk
   where int.int_id_fk is null and cen_tipo='INGRESO' AND cen_visible='TRUE'","mds_medico,serv.tca_descripcion as servicio,sala.tca_descripcion,cam_codigo,int.int_cuclia,mds_sersol,mds_grabed,int.int_fecha,int.int_id_fk,int.int_id_pk,int.hce_id_fk,(left(per_nombres, position(' ' IN per_nombres) - 1) || ' ' || per_apellidopaterno)  as paceinte","","","",5);
				if (count($Regd)==0) 
				{

				echo json_encode(array('error' => $error,));

				}else{
				echo json_encode($Regd); 
				}
break;
case '2':
	# code...
	$Regd=$Con->Get_Consulta("sgh_mei_intercsol as int
							jOIN sgh_mei_motdes as mo on mo.int_id_fk= int.int_id_pk
							join sga_adm_historiaclinica hc on int.hce_id_fk=hc.hce_id_pk
              JOIN sga_adm_paciente as pa on pac_id_fk=pa.pac_id_pk
							JOIN sga_adm_persona as pe on pa.per_id_fk=pe.per_id_pk
              JOIN sga_adm_cama as  cam on mo.cam_id_fk=cam.cam_id_pk
	join sga_adm_tipocama as sala on cam.tca_piso_fk=sala.tca_id_pk
	join sga_adm_tipocama as serv on cam.tca_serv_fk=serv.tca_id_pk
			join sgh_mei_censo as cen on cen.hce_id_fk = int.hce_id_fk
   ","serv.tca_descripcion as servicio,sala.tca_descripcion,cam_codigo,int.int_cuclia,mds_sersol,mds_grabed,int.int_fecha,int.int_id_fk,int.int_id_pk,int.hce_id_fk","","int.int_id_fk is null and cen_tipo='INGRESO' AND cen_visible='TRUE' and serv.tca_descripcion='".$data->ser."' and mds_grabed",$data->gra,2);
				if (count($Regd)==0) 
				{

				echo json_encode(array('error' => $error,));

				}else{
				echo json_encode($Regd); 
				}
	break;
	case '3':
	# code...
	$Regd=$Con->Get_Consulta("sgh_mei_intercsol as int
							jOIN sgh_mei_motdes as mo on mo.int_id_fk= int.int_id_pk
							join sga_adm_historiaclinica hc on int.hce_id_fk=hc.hce_id_pk
              JOIN sga_adm_paciente as pa on pac_id_fk=pa.pac_id_pk
							JOIN sga_adm_persona as pe on pa.per_id_fk=pe.per_id_pk
              JOIN sga_adm_cama as  cam on mo.cam_id_fk=cam.cam_id_pk
	join sga_adm_tipocama as sala on cam.tca_piso_fk=sala.tca_id_pk
	join sga_adm_tipocama as serv on cam.tca_serv_fk=serv.tca_id_pk
		join sgh_mei_censo as cen on cen.hce_id_fk = int.hce_id_fk
   ","serv.tca_descripcion as servicio,sala.tca_descripcion,cam_codigo,int.int_cuclia,mds_sersol,mds_grabed,int.int_fecha,int.int_id_fk,int.int_id_pk,int.hce_id_fk","","int.int_id_fk is null and cen_tipo='INGRESO' AND cen_visible='TRUE' and serv.tca_descripcion",$data->ser,2);
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
