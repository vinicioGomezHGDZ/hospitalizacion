<?php
// retornma un json 

include_once("../../../../php/class_consulta.php");
$Con=New Consulta();

$data = json_decode(file_get_contents("php://input"));
//print_r($data);
$error="error";
switch ($data->op) {
	case '1':
				$Regd=$Con->Get_Consulta("sgh_sol_vih  where hce_id_fk='".$data->idhc."' order by vih_fecha desc","*","","","",5);
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
