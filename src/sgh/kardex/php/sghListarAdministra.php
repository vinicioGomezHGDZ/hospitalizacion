<?php
// retornma un json 
header('content-type: application/json;');

$codigo=htmlentities($_GET['c']);
//echo $codigo;

include_once("../../../../php/class_consulta.php");

$Con=New Consulta();

	$Regd=$Con->Get_Consulta("sgh_mei_aministradm
JOIN sgu_usu_usuario as us on usu_id_fk = us.usu_id_pk
JOIN sga_adm_profesional as pr on us.pro_id_fk=pro_id_pk
JOIN sga_adm_persona as pe  on pr.per_id_fk= pe.per_id_pk
JOIN sga_adm_profesion as pro on pr.prf_id_fk = pro.prf_id_pk where kar_id_fk='".$codigo."' ORDER BY hda_fecha desc,hda_hora desc ","kar_id_fk,hda_id_pk,hda_fecha, hda_hora,  pe.per_nombres,per_apellidopaterno,pro.prf_descripcion,hda_obcerv,hda_estado","","","",5);

			if (count($Regd)==0) 
				{

				echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));

				}else{
				echo json_encode($Regd); 
				}
?>