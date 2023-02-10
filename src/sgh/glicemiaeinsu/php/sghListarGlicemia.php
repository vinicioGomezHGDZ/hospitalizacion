<?php  
date_default_timezone_set('America/Guayaquil');
include_once("../../../../php/class_consulta.php");
$Con=New Consulta();
// returnt json 

$data = json_decode(file_get_contents("php://input"));
$error="error";
switch ($data->op) {
	case '1':
		# code...
	$Regd=$Con->Get_Consulta("sgh_mei_glicemia JOIN sga_adm_cama as cam on cam_id_fk=cam.cam_id_pk JOIN 						   sga_adm_tipocama as tc  on cam.tca_piso_fk=tc.tca_id_pk  where hce_id_fk='".$data->idhc."' ORDER BY hgi_dia DESC, hgi_fecha DESC",
						   "hgi_dia,hgi_fecha,cam_codigo,tca_descripcion,hgi_glicem,hgi_esquem,hgi_espaco,hgi_totadm,hgi_obcerv,hgi_id_pk","",
						   "","",5);

      if (count($Regd)==0) 
	  {
	   
		echo json_encode(array('error' =>$error, )); 
	  }
	  else
	  {
		echo json_encode($Regd); 
	  } 

		break;
	case '2':
		# code...

	    $mensaje=0;
		$Regd=$Con->Get_Consulta("sgh_mei_glicemia","*","","usu_id_fk='".$data->usu."' and hgi_dia=current_date and hgi_id_pk",$data->codigo,2);

      if (count($Regd)==0) 
	  {
	   	echo json_encode(0);

	  }
	  else
	  {
		echo json_encode($Regd); 
	  } 
		break;
	default:
		# code...
		break;
}

 ?>