<?php
// retornma un json 

include_once("../../../../php/class_consulta.php");
$Con=New Consulta();

$data = json_decode(file_get_contents("php://input"));
//print_r($data);
$error="error";
switch ($data->op) {
	case '1':
				$Regd=$Con->Get_Consulta("sgh_sol_cervicov  where hce_id_fk='".$data->idhc."' order by ccv_fetomu desc","*","","","",5);
				if (count($Regd)==0) 
				{

				echo json_encode(array('error'=> $error,));

				}else{
				echo json_encode($Regd); 
				}
				break;
		
	case '2':
		$Regd=$Con->Get_Consulta("sgh_sol_cervicov  where ccv_id_pk='".$data->codigo."'","*","","","",5);
				if (count($Regd)==0) 
				{

				echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));

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
