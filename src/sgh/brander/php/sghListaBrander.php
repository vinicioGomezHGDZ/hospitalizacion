<?php
// retornma un json 
date_default_timezone_set('America/Guayaquil');
include_once("../../../../php/class_consulta.php");

$Con=New Consulta();

	$data = json_decode(file_get_contents("php://input"));
$error="error";
switch ($data->op) {
	case '1':
		 $Regd=$Con->Get_Consulta("sgh_mei_branden where hce_id_fk='".$data->idhc."'order by bra_fecha desc","*","","","",5);
	     //print_r($Regd);
				if (count($Regd)==0) 
				{
				echo json_encode(array('error' => $error,));
				}else{
				echo json_encode($Regd); 
				} 
	break;
	case '2':

	    $mensaje=0;
	   //print_r($data);
		 $Regd=$Con->Get_Consulta("sgh_mei_branden",
			"*","","usu_id_fk='".$data->usu."' and  bra_fecha=current_date and bra_id_pk",$data->codigo,2);
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