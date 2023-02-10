<?php
// retornma un json 
date_default_timezone_set('America/Guayaquil');
include_once("../../../../php/class_consulta.php");

$Con=New Consulta();
$data = json_decode(file_get_contents("php://input"));
$error="error";
switch ($data->op) {
	case '1':
		# carga datos de tabla...
		 $Regd=$Con->Get_Consulta("sgh_mei_inforalpaci  where hce_id_fk='".$data->idhc."' order by inp_fecha desc","*","","","",5);
    
	     //print_r($Regd);
	   
				if (count($Regd)==0) 
				{

				echo json_encode(array('error' =>$error, )); 

				}else{
				echo json_encode($Regd); 
				} 
		break;
	case '2':
		# carga datos para edición...

	    $mensaje=0;
	   //print_r($data);
		 $Regd=$Con->Get_Consulta("sgh_mei_inforalpaci",
			"*","","usu_id_fk='".$data->usu."' and inp_fecha=current_date and inp_id_pk",$data->codigo,2);
				if (count($Regd)==0) 
				{
				echo json_encode(array($mensaje));
				}else{
				echo json_encode($Regd); 
				} 		
				break;
	case '3':
		# cargar datos para ver datos e imprimir
		 $Regd=$Con->Get_Consulta("sgh_mei_inforalpaci JOIN sgu_usu_usuario as us on usu_id_fk = us.usu_id_pk
			JOIN sga_adm_profesional as pr on us.pro_id_fk = pr.pro_id_pk
			JOIN sga_adm_persona as pe  on pr.per_id_fk= pe.per_id_pk
			JOIN sga_adm_profesion as pro on pr.prf_id_fk = pro.prf_id_pk",
			"*","","inp_id_pk",$data->codigo,2);
				if (count($Regd)==0) 
				{
				echo json_encode(array($mensaje));
				}else{
				echo json_encode($Regd); 
				} 		
				break;
	default:
		# code...
		break;
}
		  
?>