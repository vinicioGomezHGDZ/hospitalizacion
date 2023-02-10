<?php
// retornma un json 
date_default_timezone_set('America/Guayaquil');
include_once("../../../../php/class_consulta.php");

$Con=New Consulta();
$data = json_decode(file_get_contents("php://input"));
$error="error";
switch ($data->op) {
	case '1':
		 $Regd=$Con->Get_Consulta("sgh_mei_soliaccion as sa
		 join sgh_mei_eventosadver as ead on sa.fed_id_fk = ead.fed_id_pk where hce_id_fk='".$data->idhc."'order by fed_fecha desc","*","","","",5);
	      //print_r($Regd);
				if (count($Regd)==0) 
				{
				echo json_encode(array('error' =>$error, )); 
				}else{
				echo json_encode($Regd); 
				} 
	break;
	case '2':
	    $mensaje=0;
	   //print_r($data);
		 $Regd=$Con->Get_Consulta("sgh_mei_soliaccion as sa
		 join sgh_mei_eventosadver as ead on sa.fed_id_fk = ead.fed_id_pk",
			"*","","usu_id_fk='".$data->usu."' and fed_fecha=current_date and fed_id_fk",$data->codigo,2);
				if (count($Regd)==0) 
				{
				echo json_encode(array($mensaje));
				}else{
				echo json_encode($Regd); 
				} 		
				break;
	case '3':
	    //print_r($data);
		 $Regd=$Con->Get_Consulta("sgh_mei_soliaccion as sa
		 join sgh_mei_eventosadver as ead on sa.fed_id_fk = ead.fed_id_pk",
			"*","","fed_id_fk",$data->codigo,2);
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