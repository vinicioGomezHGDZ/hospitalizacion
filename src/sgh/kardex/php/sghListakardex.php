<?php
// retornma un json 
date_default_timezone_set('America/Guayaquil');

include_once("../../../../php/class_consulta.php");

$Con=New Consulta();

$data = json_decode(file_get_contents("php://input"));
//print_r($data);
$error="error";
switch ($data->op) {
	case '1':
		   $Regd=$Con->Get_Consulta("sgh_mei_kardex  where hce_id_fk ='".$data->hcl." 'order by kar_id_pk DESC",
			"*","","","",5);
    
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
		   $Regd=$Con->Get_Consulta("sgh_mei_kardex where hce_id_fk ='".$data->hcl."' and kar_fecha >='".$data->fecha."'",
			"*","","","",5);
    
				if (count($Regd)==0) 
				{

				echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));

				}else{
				echo json_encode($Regd); 
				} 
	break;
    case '3':
        $Regd=$Con->Get_Consulta("sgh_mei_kardex where kar_id_pk ='".$data->codigo."'","*","","","",5);
        if (count($Regd)==0)
        {
            echo json_encode(array('error'=> true,));

        }else{
            echo json_encode($Regd);
        }
        break;

		default:
			# code...
			break;
	}
?>