<?php
// retornma un json 
date_default_timezone_set('America/Guayaquil');
include_once("../../../../php/class_consulta.php");

$Con=New Consulta();

$data = json_decode(file_get_contents("php://input"));
$error="error";
switch ($data->op) {
	case '1':
	     $Regd=$Con->Get_Consulta("sgh_mei_sivitdia  where svd_opingreso=true and hce_id_fk='".$data->idhc."' order by svd_fecha desc","*","","","",5);
	     //echo $Regd;
				if (count($Regd)==0) 
				{

				echo json_encode(array('error' =>$error, )); 

				}else{
				echo json_encode($Regd); 
				} 

		break;
	case '2':

		$mensaje=0;
		$Regd=$Con->Get_Consulta("sgh_mei_sivitdia","*","","svd_id_pk",$data->codigo,2);
	    
				if (count($Regd)==0) 
				{

				echo json_encode(array($mensaje));

				}else{
				echo json_encode($Regd); 
				} 
			
		break;
		case '3':
    $mensaje=0;
    $Regd=$Con->Get_Consulta("sgh_mei_sivitdia","*","","svd_id_pk",$data->codigo,2);
    //print_r($Regd);
    if (count($Regd)==0)
    {

        echo json_encode(array($mensaje));

    }else{
        echo json_encode($Regd);
    }

    break;
    case '4':

        $Regd=$Con->Get_Consulta("sgh_mei_sivitdia where svd_opingreso=false and hce_id_fk='".$data->idhc."' order by svd_fecha desc","*","","","",5);
        //print_r($Regd);
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