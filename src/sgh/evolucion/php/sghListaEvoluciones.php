<?php
// retornma un json 
date_default_timezone_set('America/Guayaquil');
include_once("../../../../php/class_consulta.php");

$Con=New Consulta();

	$data = json_decode(file_get_contents("php://input"));
	$error="error";
switch ($data->op) {
	case '1':
		 $Regd=$Con->Get_Consulta("sgh_mei_evolucion ev
			JOIN sgu_usu_usuario as us on usu_id_fk = us.usu_id_pk
            JOIN sga_adm_profesional as pr on us.pro_id_fk=pro_id_pk
			JOIN sga_adm_persona as pe  on pr.per_id_fk= pe.per_id_pk
			JOIN sga_adm_profesion as pro on pr.prf_id_fk = pro.prf_id_pk where hce_id_fk='".$data->idhc."'
			order by eyp_fechas desc,eyp_hora desc",
			"eyp_revisa,eyp_estares,eyp_revisaresidente,eyp_fechas,eyp_asunto,ev.eyp_nodevu,ev.eyp_prescr,pe.per_nombres,per_apellidopaterno, pr.pro_codigomsp,pe.per_numeroidentificacion,pro.prf_descripcion,eyp_hora,eyp_id_pk,hce_id_fk,eyp_estado,usu_id_fk","","","",5);
    
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
     	  $Regd=$Con->Get_Consulta("sgh_mei_evolucion",
			"*","","usu_id_fk='".$data->usu."' and eyp_fechas=current_date and eyp_id_pk ",$data->codigo,2);

				if (count($Regd)==0) 
				{
				echo json_encode(array($mensaje));

				}else{
				echo json_encode($Regd); 
				} 		
	break;

    case '3':
        $Regd=$Con->Get_Consulta("sgh_mei_evolucion","*","","eyp_id_pk ",$data->codigo,2);
        if (count($Regd)==0)
        {
            echo json_encode(array($mensaje));
        }else{
            echo json_encode($Regd);
        }
    break;

    case '4':
        $Regd=$Con->Get_Consulta("sgu_usu_usuario as us
            JOIN sga_adm_profesional as pr on us.pro_id_fk=pro_id_pk
			JOIN sga_adm_persona as pe  on pr.per_id_fk= pe.per_id_pk
			JOIN sga_adm_profesion as pro on pr.prf_id_fk = pro.prf_id_pk","pe.per_nombres || ' ' || per_apellidopaterno || ' ' || per_apellidomaterno  as medico,pro_codigomsp,pro_codigosenescyt,pe.per_numeroidentificacion","","usu_id_pk ",$data->codigo,2);
        if (count($Regd)==0)
        {
            echo json_encode(array($mensaje));
        }else{
            echo json_encode($Regd);
        }
    break;

    case '5':
        $Regd=$Con->Get_Consulta("sgh_mei_evolucion","*","","eyp_id_pk ",$data->codigo,2);
        if (count($Regd)==0)
        {
            echo json_encode(array($mensaje));
        }else{
            echo json_encode($Regd);
        }
        break;

    default:
		# code...
		break;
}
		  
?>