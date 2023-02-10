<?php
// retornma un json 

include_once("../../../../php/class_consulta.php");

$Con=New Consulta();
$error="error";
$data = json_decode(file_get_contents("php://input"));
switch ($data->op) {
    case '1':
		   $Regd=$Con->Get_Consulta("sgh_mei_anexos where hce_id_fk='".$data->idhc."' ORDER BY fecha DESC","*","","","",5);
				if (count($Regd)==0)
				{

				echo json_encode(array('error'=> $error));

				}else{
				echo json_encode($Regd); 
				}
        break;
    case '2':
        $Regd=$Con->Get_Consulta("sgh_mei_anexos where fecha >='".$data->fi."' and fecha <='".$data->fe."' and hce_id_fk='".$data->idhc."'","*","","","",5);
        if (count($Regd)==0)
        {

            echo json_encode(array('error'=> $error));

        }else{
            echo json_encode($Regd);
        }
        break;
    default:
        # code...
        break;
}
?>