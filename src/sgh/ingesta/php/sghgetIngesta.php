<?php
// retornma un json 
	date_default_timezone_set('America/Guayaquil');    	
include_once("../../../../php/class_consulta.php");

$Con=New Consulta();	
	
	$data = json_decode(file_get_contents("php://input"));
 	$op=$data->OP;
    if ($op <> 5) {
    $tipo=$data->tipo;
    $fecha=$data->fecha;
    }

   	
	switch ($op) {
        case 1:
        $Regd=$Con->Get_Consulta("sgh_mei_ingrelimi where hce_id_fk='".$data->idhc."' and cie_turno= '".$tipo."' AND  cie_fecha='".$fecha."' AND cie_tipo='ORAL' order by cie_hora desc",
			"cie_hora,cie_clase,cie_cantcc,cie_canabs,cie_id_pk","","","",5);
        break;
 
        case 2:
             $Regd=$Con->Get_Consulta("sgh_mei_ingrelimi where hce_id_fk='".$data->idhc."' and cie_turno= '".$tipo."' AND  cie_fecha='".$fecha."' AND cie_tipo='PARENTAL' order by cie_hora desc",
            "cie_hora,cie_clase,cie_cantcc,cie_canabs,cie_id_pk","","","",5);
        break;
        case 3:
        $Regd=$Con->Get_Consulta("sgh_mei_ingrelimi where hce_id_fk='".$data->idhc."'and cie_turno= '".$tipo."' AND  cie_fecha='".$fecha."' AND cie_tipo='ORINA' order by cie_hora desc",
			"cie_hora,cie_clase,cie_cantcc,cie_canabs,cie_id_pk","","","",5);
        break;
        case 4:
        $Regd=$Con->Get_Consulta("sgh_mei_ingrelimi where hce_id_fk='".$data->idhc."' and cie_turno= '".$tipo."' AND  cie_fecha='".$fecha."' AND cie_tipo='OTROS' order by cie_hora desc",
			"cie_hora,cie_clase,cie_cantcc,cie_canabs,cie_id_pk","","","",5);
        break;
        case 5:
        $mensaje=0;
        $Regd=$Con->Get_Consulta("sgh_mei_ingrelimi",
            "cie_hora,cie_clase,cie_cantcc,cie_canabs,cie_id_pk,cie_turno","","cie_fecha>='".$data->cen_fecha."' and cie_id_pk",$data->codigo,2);
        break;

        default:
        //sentencias;
        break;
 }		
    	     //print_r($Regd);
				if (count($Regd)==0)
				{
				echo json_encode(array('error'=> true,'mensaje'=>'codigo no exixte'));
				}else{
				echo json_encode($Regd); 
				} 
?>