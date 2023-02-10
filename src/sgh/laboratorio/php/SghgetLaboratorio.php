<?php  

include_once("../../../../php/class_consulta.php");
$Con=New Consulta();

$data = json_decode(file_get_contents("php://input"));
//print_r($data);
$error="error";
switch ($data->op) {
	case '1':
				$Regd=$Con->Get_Consulta("sgh_sol_ex where exa_estado= true and cat_id_fk='".$data->cat."'","*","","","",5);
				if (count($Regd)==0) 
				{

				echo json_encode(array('error' =>$error, )); 

				}else{
				echo json_encode($Regd); 
				}
				break;
		
	case '2':
				$Regd=$Con->Get_Consulta("sgh_sol_deexamlab
 				join sgh_sol_ex as exa on exa_id =exa.exa_id_pk
 				join sgh_sol_cat as cat on exa.cat_id_fk = cat.cat_id_pk","cat_descrip,exa_descrip","","lab_id_fk",$data->codigo,2);
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