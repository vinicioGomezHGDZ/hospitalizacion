<?php  

include_once("../../../../php/class_consulta.php");
$Con=New Consulta();

$data = json_decode(file_get_contents("php://input"));
//print_r($data);

switch ($data->op) {
	case '1':
				$Regd=$Con->Get_Consulta("sgh_sol_ex where exa_estado= true and cat_id_fk='".$data->cat."'","*","","","",5);
				if (count($Regd)==0) 
				{

				echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));

				}else{
				echo json_encode($Regd); 
				}
				break;
		
	case '2':
				$Regd=$Con->Get_Consulta("sgh_mei_anamnesis","*","","ana_id_pk",$data->codigo,2);
				if (count($Regd)==0) 
				{

				echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));

				}else{
				echo json_encode($Regd); 
				}
    break;
    
			default:
				# code...
				break;
		}		
				     
?>