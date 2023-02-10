<?php
// retornma un json 
date_default_timezone_set('America/Guayaquil');
include_once("../../../../php/class_consulta.php");

$Con=New Consulta();

	$data = json_decode(file_get_contents("php://input"));
 $mensaje=0;
 $error="error";
switch ($data->op) {
	case '1':
		 $Regd=$Con->Get_Consulta("sgh_mei_reoncimedi where hce_id_fk='".$data->idhc."'order by frm_fecha desc","*","","","",5);
	     //print_r($Regd);
				if (count($Regd)==0) 
				{
				echo json_encode(array('error' =>$error, )); 
				}else{
				echo json_encode($Regd); 
				} 
	break;
/////////// cargar datos de edición general

	case '2':

	   //print_r($data);
		 $Regd=$Con->Get_Consulta("sgh_mei_reoncimedi",
			"*","","frm_fecha >='".$data->fecha."' and frm_id_pk",$data->codigo,2);
				if (count($Regd)==0) 
				{
				echo json_encode(array($mensaje));
				}else{
				echo json_encode($Regd); 
				} 		
				break;
	case '3':
		$Regd=$Con->Get_Consulta("sgh_mei_medirec",
			"*","","frm_id_fk",$data->codigo,2);
				if (count($Regd)==0) 
				{
				echo json_encode(array($mensaje));
				}else{
				echo json_encode($Regd); 
				} 		

		# code...
	break;
	case '4':
		$Regd=$Con->Get_Consulta("sgh_mei_medihospit",
			"*","","frm_id_fk",$data->codigo,2);
				if (count($Regd)==0) 
				{
				echo json_encode(array($mensaje));
				}else{
				echo json_encode($Regd); 
				} 		
		# code...
	break;	
	case '5':
		$Regd=$Con->Get_Consulta("sgh_mei_medicialta",
			"*","","frm_id_fk",$data->codigo,2);
				if (count($Regd)==0) 
				{
				echo json_encode(array($mensaje));
				}else{
				echo json_encode($Regd); 
				} 		
		# code...
	break;
// cargar datos de visualizacion de datos 
	case '6':
	    $time = time();
	 	$date=date("Y-m-d ", $time);
	   
     //print_r($data);
		 $Regd=$Con->Get_Consulta("sgh_mei_reoncimedi",
			"*","","frm_id_pk",$data->codigo,2);
				if (count($Regd)==0) 
				{
				echo json_encode(array($mensaje));
				}else{
				echo json_encode($Regd); 
				} 		
				break;
/// cargar de datos para edicion por unidad			
	case '7':
		$Regd=$Con->Get_Consulta("sgh_mei_medirec",
			"*","","mum_id_pk",$data->codigo,2);
				if (count($Regd)==0) 
				{
				echo json_encode(array($mensaje));
				}else{
				echo json_encode($Regd); 
				} 		

	break;
	case '8':
		$Regd=$Con->Get_Consulta("sgh_mei_medihospit",
			"*","","mph_id_pk",$data->codigo,2);
				if (count($Regd)==0) 
				{
				echo json_encode(array($mensaje));
				}else{
				echo json_encode($Regd); 
				} 		
		# code...
	break;	
	case '9':
		$Regd=$Con->Get_Consulta("sgh_mei_medicialta",
			"*","","mpa_id_pk",$data->codigo,2);
				if (count($Regd)==0) 
				{
				echo json_encode(array($mensaje));
				}else{
				echo json_encode($Regd); 
				} 		
		# code...
	break;

	default:
		# code...
		break;
}
		  
?>