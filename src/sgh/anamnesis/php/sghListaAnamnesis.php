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
	/// cargar datos tabla 
				$Regd=$Con->Get_Consulta("sgh_mei_anamnesis  
				JOIN sgu_usu_usuario as us on usu_id_fk = us.usu_id_pk
				JOIN sga_adm_profesional as pr on us.pro_id_fk=pro_id_pk
				JOIN sga_adm_persona as pe  on pr.per_id_fk= pe.per_id_pk
				JOIN sga_adm_profesion as pro on pr.prf_id_fk = pro.prf_id_pk
				where ana_motivo is not null and hce_id_fk='".$data->idhc."'	order by ana_fecha desc","usu_id_fk,ana_id_pk,ana_fecha,ana_hora,ana_motivo,pe.per_nombres,per_apellidopaterno, pr.pro_codigomsp,pro.prf_descripcion","","","",5);
				if (count($Regd)==0) 
				{

				echo json_encode(array('error' => $error,));

				}else{
				echo json_encode($Regd); 
				}
				break;

		
	case '2':
	// cargar anamnesis edicion
				$Regd=$Con->Get_Consulta("sgh_mei_anamnesis","*","","ana_id_pk",$data->codigo,2);
				if (count($Regd)==0) 
				{

				echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));

				}else{
				echo json_encode($Regd); 
				}
    break;
    case '3':

    		// respuestas de anamnesis 
				$Regd=$Con->Get_Consulta("sgh_mei_anapro JOIN sgh_mei_respuesta as res on pat_id_fk= res.pat_id_pk where ana_id_fk=".$data->codigo."ORDER BY pat_item","pat_id_pk,pat_result,pat_item,pat_punto","","","",5);
				if (count($Regd)==0) 
				{

				echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));

				}else{
				echo json_encode($Regd); 
				}
        
    break;
    case '4':
    // cargar signos vitales
     $Regd=$Con->Get_Consulta("sgh_mei_sivanam as  sva
	  jOIN sgh_mei_signosvi as sv on sva.siv_id= sv.siv_id_pk
	  JOIN sgh_mei_anamnesis as ana on sva.ana_id_fk= ana.ana_id_pk","ana_desrev,ana_aborto,ana_antfam,ana_biopsia,ana_cesarea,ana_ciclos,ana_colcop,ana_desant,ana_desrev,ana_enfpra,ana_exafis,ana_fecha,ana_fuc,ana_fum,ana_fup,ana_gesta,ana_hijosv,ana_id_pk,ana_mamogr,ana_menarq,ana_menopa,ana_mepfam,ana_motivo,ana_paros,ana_plantr,ana_terhor,ana_vidasex,siv_id_pk,siv_frecar,siv_freres,siv_percef,siv_peso,siv_prarta,siv_talla,siv_temper,siv_tempvo","","ana_id_fk",$data->codigo,2);
				if (count($Regd)==0) 
				{

				echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));

				}else{
				echo json_encode($Regd); 
				}
    	break;
 	case '5':
 	# carar dianostico
 	   $Regd=$Con->Get_Consulta("sgh_mei_danamdiag join sgh_mei_diagnos as d on dia_id_fk=d.dia_id_pk
 	    JOIN sgh_mei_codigocie10 as c10 on d.c10_id_fk=c10.c10_id_pk where ana_id_fk='".$data->codigo."'","c10_id_pk,c10.c10_nombre,c10_codigo,dia_resp,dia_id_pk,dad_id_pk","","","",6);
				if (count($Regd)==0) 
				{

                    echo json_encode(array('error' => $error,));

				}else{
				echo json_encode($Regd); 
				}
 	break;
 	case '6':
	// cargar anamnesis antecedentes personales , y familiares 
        $Regd=$Con->Get_Consulta("sgh_mei_anamnesis where hce_id_fk='".$data->idhc."' ORDER BY ana_id_pk DESC LIMIT 2 ","ana_id_pk,ana_menarq,ana_menopa,ana_ciclos,ana_vidasex,ana_gesta,ana_paros,ana_aborto,ana_cesarea,ana_hijosv,ana_fum,ana_fup,ana_fuc,ana_biopsia,ana_mepfam,ana_terhor,ana_colcop,ana_mamogr,ana_desant,ana_antfam","","","",5);
        if (count($Regd)==0)
        {

            echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));

        }else{
            echo json_encode($Regd);
        }
	break;

	case '7':
	# datos edicion 
           $mensaje=0;

	      $Regd=$Con->Get_Consulta("sgh_mei_sivanam as  sva
		  jOIN sgh_mei_signosvi as sv on sva.siv_id= sv.siv_id_pk
		  JOIN sgh_mei_anamnesis as ana on sva.ana_id_fk= ana.ana_id_pk","ana_aborto,ana_antfam,ana_biopsia,ana_cesarea,ana_ciclos,ana_colcop,ana_desant,ana_desrev,ana_enfpra,ana_exafis,ana_fecha,ana_fuc,ana_fum,ana_fup,ana_gesta,ana_hijosv,ana_id_pk,ana_mamogr,ana_menarq,ana_menopa,ana_mepfam,ana_motivo,ana_paros,ana_plantr,ana_terhor,ana_vidasex,siv_id_pk,siv_frecar,siv_freres,siv_percef,siv_peso,siv_prarta,siv_talla,siv_temper,siv_tempvo","","ana_fecha>='".$data->fecha."' and ana_id_fk",$data->codigo,2);
					if (count($Regd)==0) 
				{
				echo json_encode($mensaje);
				}else{
				echo json_encode($Regd); 
				}
	break;

	case '8':
		# activar botones 
	$Regd=$Con->Get_Consulta("sgh_mei_anamnesis  where ana_fecha >= '".$data->fecha ."' and hce_id_fk='".$data->idhc."' order by ana_fecha desc","ana_fecha, ana_id_pk","","","",5);
				if (count($Regd)==0) 
				{

				echo json_encode(array('error' => $error,));

				}else{
				echo json_encode($Regd); 
				}
				break;
	break;
	case '9':
		# activar botones 
	$Regd=$Con->Get_Consulta("sgh_mei_anamnesis  where ana_fecha >= '".$data->fecha ."' and hce_id_fk='".$data->idhc."' and ana_motivo is null order by ana_fecha desc","ana_fecha, ana_id_pk,ana_motivo","","","",5);
				if (count($Regd)==0) 
				{

				echo json_encode(array('error' => $error,));

				}else{
				echo json_encode($Regd); 
				}
				break;
	break;

    case '10':
        # datos edicion
        $mensaje=0;

        $Regd=$Con->Get_Consulta("sgh_mei_sivanam as  sva
		  jOIN sgh_mei_signosvi as sv on sva.siv_id= sv.siv_id_pk
		  JOIN sgh_mei_anamnesis as ana on sva.ana_id_fk= ana.ana_id_pk","ana_aborto,ana_antfam,ana_biopsia,ana_cesarea,ana_ciclos,ana_colcop,ana_desant,ana_desrev,ana_enfpra,ana_exafis,ana_fecha,ana_fuc,ana_fum,ana_fup,ana_gesta,ana_hijosv,ana_id_pk,ana_mamogr,ana_menarq,ana_menopa,ana_mepfam,ana_motivo,ana_paros,ana_plantr,ana_terhor,ana_vidasex,siv_id_pk,siv_frecar,siv_freres,siv_percef,siv_peso,siv_prarta,siv_talla,siv_temper,siv_tempvo","","ana_id_fk",$data->codigo,2);
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
