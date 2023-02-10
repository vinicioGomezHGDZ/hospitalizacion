<?php  
// incluir conección de base de datos 
// retornma un json 
include_once("../../../../php/class_consulta.php");
$Con=New Consulta();
$data = json_decode(file_get_contents("php://input"));
$error="error";
switch ($data->op) {
	
	case '1':
		# cargar cama
				$Regd=$Con->Get_Consulta(" sga_adm_tipocama where tca_id_pk ='".$data->codigo."'","tca_id_pk,tca_descripcion","","","",5);
				
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