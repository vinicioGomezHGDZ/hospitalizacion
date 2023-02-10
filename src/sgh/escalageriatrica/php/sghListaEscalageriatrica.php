<?php
// retornma un json 

include_once("../../../../php/class_consulta.php");
$Con=New Consulta();

$data = json_decode(file_get_contents("php://input"));
//print_r($data);
$error="error";
switch ($data->op) {
	//listar adulto mayor tabla
	case '1':
				$Regd=$Con->Get_Consulta("sgh_mei_escgeria  
				 JOIN sgu_usu_usuario as us on usu_id_fk = us.usu_id_pk
				JOIN sga_adm_profesional as pr on us.pro_id_fk=pro_id_pk
				JOIN sga_adm_persona as pe  on pr.per_id_fk= pe.per_id_pk
				JOIN sga_adm_profesion as pro on pr.prf_id_fk = pro.prf_id_pk
				where hce_id_fk='".$data->idhc ."'order by esg_fecha desc","pe.per_nombres,per_apellidopaterno, pr.pro_codigomsp,pro.prf_descripcion,esg_id_pk,esg_fecha","","","",5);
				if (count($Regd)==0) 
				{

				echo json_encode(array('error' =>$error, )); 

				}else{
				echo json_encode($Regd); 
				}
				break;
	// listar adulto mayor datos visualisar editar.	
	case '2':
				$Regd=$Con->Get_Consulta("sgh_mei_escgeria","*","","esg_id_pk",$data->codigo,2);
				if (count($Regd)==0) 
				{

				echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));

				}else{
				echo json_encode($Regd); 
				}
    break;
    // listar datos de items para visualizar editar
    case '3':
    	//print_r($data);
				$Regd=$Con->Get_Consulta(" sgh_mei_escalpro
					join sgh_mei_respuesta as res on pat_id_fk=res.pat_id_pk where pat_punto='".$data->punt."' AND esg_id_fk=".$data->codigo."ORDER BY pat_item","pat_id_pk,pat_result,pat_item,pat_punto","","","",5);
				if (count($Regd)==0) 
				{

				echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));

				}else{
				echo json_encode($Regd); 
				}
    break;
	case '4':
	// cargar ultima id de escala geriatrica para nuevo registro
		$Regd=$Con->Get_Consulta("sgh_mei_escgeria  where hce_id_fk='".$data->idhc ."' ORDER BY esg_id_pk DESC LIMIT 1","*","","","",5);
				if (count($Regd)==0) 
				{

				echo json_encode(array('error' =>$error, )); 

				}else{
				echo json_encode($Regd); 
				}
				break;
    break;
    default:
     # code...
	break;
}		
				     
?>
