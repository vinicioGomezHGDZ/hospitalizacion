<?php
// retornma un json 
date_default_timezone_set('America/Guayaquil');
include_once("../../../../php/class_consulta.php");

$Con=New Consulta();

	$data = json_decode(file_get_contents("php://input"));
$error="error";
switch ($data->op) {
	case '1':
		 $Regd=$Con->Get_Consulta("sgh_mei_dietas_detalle
                                 where hce_id_fk='".$data->idhc."'order by did_fecha desc","did_fecha","","","",6);
	     //print_r($Regd);
				if (count($Regd)==0)
				{
				echo json_encode(array('error' => $error,));
				}else{
				echo json_encode($Regd);
				}
	break;

	case '2':

      $Regd=$Con->Get_Consulta("sgh_mei_dietas_detalle
                join sgh_mei_dieta d on die_id_fk=d.die_id_pk where hce_id_fk='".$data->idhc."' and did_fecha='".$data->fe."' ORDER BY die_orden","did_res,d.die_descrip,did_obce,did_id_pk","","","",5);
        //print_r($Regd);
        if (count($Regd)==0)
        {
            echo json_encode(array('error' => $error,));
        }else{
            echo json_encode($Regd);
        }
       break;

    case '3':
        $Regd=$Con->Get_Consulta("sgh_mei_dieta where die_estado=true order by die_orden","*","","","",5);
        if (count($Regd)==0)
        {
            echo json_encode(array('error' => $error,));
        }else{
            echo json_encode($Regd);
        }
    break;
    default:
		# code...
		break;
}
		  
?>