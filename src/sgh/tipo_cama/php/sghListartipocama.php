<?php  
// incluir conección de base de datos 
// retornma un json 
include_once("../../../../php/class_consulta.php");
$Con=New Consulta();
$data = json_decode(file_get_contents("php://input"));

$error="error";
switch ($data->op) {
    case '1':
        $Regd=$Con->Get_Consulta("sga_adm_tipocama tcp
join sga_adm_tipocama tcs on tcp.tca_codigoprincipal=tcs.tca_id_pk","tcs.tca_descripcion as pertenese,tcp.tca_id_pk,tcp.tca_descripcion,tcp.tca_visible,tcp.tca_tipo","","","",5);
        if (count($Regd)==0)
        {
            echo json_encode(array('error' =>$error, ));
        }else
            {
            echo json_encode($Regd);
           }
        break;
    case '2':
        $Regd=$Con->Get_Consulta("sga_adm_tipocama","tca_id_pk,tca_descripcion as servicio,tca_tipo","","tca_tipo",$data->fil,2);
        if (count($Regd)==0)
        {
            echo json_encode(array('error' =>$error, ));
        }else
        {
            echo json_encode($Regd);
        }
    break;
    case '3':
        $Regd=$Con->Get_Consulta("sga_adm_tipocama as pis
join sga_adm_tipocama as ser on pis.tca_codigoprincipal=ser.tca_id_pk","pis.tca_id_pk as tca_id_pk,pis.tca_descripcion as piso ,ser.tca_descripcion as servicio,pis.tca_tipo","","pis.tca_tipo",$data->fil,2);
        if (count($Regd)==0)
        {
            echo json_encode(array('error' =>$error, ));
        }else
        {
            echo json_encode($Regd);
        }
        break;
    case '4':
        $Regd=$Con->Get_Consulta("sga_adm_tipocama","*","","tca_id_pk",$data->codigo,2);
        if (count($Regd)==0)
        {
            echo json_encode(array('error' =>$error, ));
        }else
        {
            echo json_encode($Regd);
        }
        break;
    default:
        # code...
        break;
}
?>