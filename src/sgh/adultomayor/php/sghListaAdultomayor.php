<?php
// retornma un json 
date_default_timezone_set('America/Guayaquil');
include_once("../../../../php/class_consulta.php");
$Con=New Consulta();

$data = json_decode(file_get_contents("php://input"));
//print_r($data);
$error="error";
switch ($data->op) {
	//listar adulto mayor tabla
	case '1':
				$Regd=$Con->Get_Consulta("sgh_mei_adulto 
				 JOIN sgu_usu_usuario as us on usu_id_fk = us.usu_id_pk
				JOIN sga_adm_profesional as pr on us.pro_id_fk=pro_id_pk
				JOIN sga_adm_persona as pe  on pr.per_id_fk= pe.per_id_pk
				JOIN sga_adm_profesion as pro on pr.prf_id_fk = pro.prf_id_pk
				 where aam_motivo <>'NULL' and hce_id_fk='".$data->idhc ."'order by aam_fecha desc","pe.per_nombres,per_apellidopaterno, pr.pro_codigomsp,pro.prf_descripcion,aam_fecha,aam_inform,aam_motivo,aam_id_pk","","","",5);
				if (count($Regd)==0) 
				{

				echo json_encode(array('El error es' => $error,));

				}else{
				echo json_encode($Regd); 
				}
				break;
	
	// listar adulto mayor datos visualisar editar.	
	case '2':
				$Regd=$Con->Get_Consulta("sgh_mei_adulto",
				"aam_id_pk,aam_inform,aam_respon,aam_motivo,aam_enferm,aam_meqrec,aam_esgene,aam_reacsi,aam_antepe,aam_antfam,aam_exafis,aam_prudia,aam_trata,aam_fecha","","aam_id_pk",$data->codigo,2);
				if (count($Regd)==0) 
				{

				echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));

				}else{
				echo json_encode($Regd); 
				}
    break;
    // listar datos de items para visualizar editar
    case '3':
				$Regd=$Con->Get_Consulta("sgh_mei_adulpro JOIN sgh_mei_respuesta as res on pat_id_fk= res.pat_id_pk where aam_id_fk=".$data->codigo."ORDER BY pat_item","pat_id_pk,pat_result,pat_item,pat_punto","","","",5);
				if (count($Regd)==0) 
				{
			    echo json_encode(array('error' => $error,));
				}else{
				echo json_encode($Regd); 
				}
        
    break;
    // listar datos de cie 10 editar visualizar
 	case '5':
 	   $Regd=$Con->Get_Consulta("sgh_mei_diacnadul
		join sgh_mei_diagnos as d on dia_id_fk=d.dia_id_pk
		JOIN sgh_mei_codigocie10 as c10  on d.c10_id_fk=c10.c10_id_pk","c10_nombre,aam_id_fk,dia_id_pk,c10_id_pk,c10_codigo,dia_resp,dia_descrip","","aam_id_fk",$data->codigo,2);
				if (count($Regd)==0) 
				{

                 echo json_encode(array('error' => $error,));

				}else{
				echo json_encode($Regd); 
				}
 	break;
 	case '6':

	  $mensaje=0;
 	 $Regd=$Con->Get_Consulta("sgh_mei_adulto",
				"aam_id_pk,aam_inform,aam_respon,aam_motivo,aam_enferm,aam_meqrec,aam_esgene,aam_reacsi,aam_antepe,aam_antfam,aam_exafis,aam_prudia,aam_trata,aam_fecha
				","","usu_id_fk='".$data->usu."' and aam_fecha=current_date and aam_id_pk",$data->codigo,2);
				if (count($Regd)==0)
				{
				echo json_encode($mensaje);
				}else{
				echo json_encode($Regd); 
				}
 	break;
 	case '7':
 	# cargar signos vitales
 		$Regd=$Con->Get_Consulta("sgh_mei_sgvadma sv
				join sgh_mei_adulto as ad on sv.aam_id_fk = ad.aam_id_pk
				join sgh_mei_signosvi as svi on sv.siv_id_fk = svi.siv_id_pk",
				"aam_id_pk,siv_id_pk,siv_prarta,siv_prarte,siv_temper,siv_pulso,siv_freres,siv_peso,siv_talla,siv_imc,siv_percint,siv_percad,siv_perpan,siv_defvis ,siv_defaud,siv_levand,siv_peinor,siv_pemere,siv_perpes,siv_triste,siv_pubaso,siv_sacoso,siv_vivsol","","aam_id_pk",$data->codigo,2);
				if (count($Regd)==0) 
				{
				echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));
				}else{
				echo json_encode($Regd); 
				}

 	break;
case '8':
# code...
$Regd=$Con->Get_Consulta("sgh_mei_adulto  where aam_fecha >= '".$data->fecha."'and hce_id_fk='".$data->idhc ."'order by aam_fecha desc","aam_fecha,aam_id_pk","","","",5);
				if (count($Regd)==0) 
				{
				echo json_encode(array('error' => $error,));
				}else{
				echo json_encode($Regd); 
				}
				break;
break;
case '9':
# code...
$Regd=$Con->Get_Consulta("sgh_mei_adulto  where aam_fecha >= '".$data->fecha."'and hce_id_fk='".$data->idhc ."' and aam_motivo is null order by aam_fecha desc","aam_fecha,aam_id_pk","","","",5);
				if (count($Regd)==0) 
				{
				echo json_encode(array('error' => $error,));
				}else{
				echo json_encode($Regd); 
				}
				break;
break;
case '10':
	// cargar anamnesis antecedentes personales , y familiares 
				$Regd=$Con->Get_Consulta("sgh_mei_adulto where hce_id_fk='".$data->idhc."' ORDER BY aam_id_pk DESC LIMIT 2 ","aam_id_pk,aam_antepe,aam_antfam,aam_fecha","","","",5);
				if (count($Regd)==0)  
				{

				echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));

				}else{
				echo json_encode($Regd); 
				}
	break;

    case '11':

        $mensaje=0;
        $Regd=$Con->Get_Consulta("sgh_mei_adulto",
            "aam_id_pk,aam_inform,aam_respon,aam_motivo,aam_enferm,aam_meqrec,aam_esgene,aam_reacsi,aam_antepe,aam_antfam,aam_exafis,aam_prudia,aam_trata,aam_fecha
				","","aam_id_pk",$data->codigo,2);
        if (count($Regd)==0)
        {
            echo json_encode($mensaje);
        }else{
            echo json_encode($Regd);
        }
        break;

	default:
	# code...
	break;

}		
				     
?>
