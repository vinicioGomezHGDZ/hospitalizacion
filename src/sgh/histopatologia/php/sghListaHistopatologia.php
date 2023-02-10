<?php
// retornma un json 

include_once("../../../../php/class_consulta.php");
$Con=New Consulta();

$data = json_decode(file_get_contents("php://input"));
//print_r($data);
$error="error";
switch ($data->op) {
	case '1':
				$Regd=$Con->Get_Consulta("sgh_sol_histopa  where hce_id_fk='".$data->idhc."' order by his_fecha desc","*","","","",5);
				if (count($Regd)==0) 
				{
				echo json_encode(array('error' =>$error, )); 
				}else{
				echo json_encode($Regd); 
				}
				break;
	case '2':
		# code...

	    $Regd=$Con->Get_Consulta("sgh_sol_histopa  where his_id_pk='".$data->codigo."' order by his_fecha desc","*","","","",5);
				if (count($Regd)==0) 
				{

				echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));

				}else{
				echo json_encode($Regd); 
				}
				break;
		break;
	
    case '3':
				$Regd=$Con->Get_Consulta("sgh_sol_diaghistopa as dh
								join sgh_mei_diagnos as dia on dh.dia_id_fk = dia.dia_id_pk 
								JOIN sgh_mei_codigocie10 as c10 on dia.c10_id_fk = c10.c10_id_pk
								where his_id_pk=".$data->codigo."","*","","","",5);
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
