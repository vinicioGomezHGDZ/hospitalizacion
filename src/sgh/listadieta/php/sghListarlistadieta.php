<?php  
// incluir conección de base de datos 
// retornma un json 
include_once("../../../../php/class_consulta.php");
$Con=New Consulta();
$data = json_decode(file_get_contents("php://input"));
$error="error";
$Con=New Consulta();
 
switch ($data->op) {
	case '1':
		# code...
	 		$Regd=$Con->Get_Consulta("sgh_mei_dieta ORDER BY die_orden","*","","","",5);
    		if (count($Regd)==0) 
				{

					echo json_encode(array('error' =>$error, )); 

				}else{
				echo json_encode($Regd); 
				} 
		break;
	case '2':
		# code...
	 		$Regd=$Con->Get_Consulta("sgh_mei_dieta ","*","","die_id_pk",$data->codigo,2);
    		if (count($Regd)==0) 
				{

					echo json_encode(array('error' =>$error, )); 

				}else{
				echo json_encode($Regd); 
				} 
		break;
	default:
		# code...
		break;
}

?>