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
	 // cargar datos de tabla
				$Regd=$Con->Get_Consulta("sgh_mei_referencia as r
				join sga_adm_establecimiento as es on r.ins_de_fk =es.eta_id_pk
				join sga_adm_institucion as ins on es.ins_id_fk=ins.ins_id_pk where hce_id_fk='".$data->idhc."' and ref_id_fk IS NULL order by ref_fecha desc","*","","","",5);
				if (count($Regd)==0) 
				{

				echo json_encode(array('error' =>$error, )); 

				}else{
				echo json_encode($Regd); 
				}
				break;
		
	case '2':
	 // cargar datos genral edicion
				$Regd=$Con->Get_Consulta("sgh_mei_referencia as r
  INNER JOIN sga_adm_establecimiento establecimiento ON establecimiento.eta_id_pk =r.ins_de_fk
  INNER JOIN sga_adm_institucion institucion ON institucion.ins_id_pk = establecimiento.ins_id_fk
  INNER JOIN sga_adm_tipologiainstitucion tipoins ON tipoins.tin_id_pk = establecimiento.tin_id_fk
  INNER JOIN sga_adm_parroquia parroquia ON parroquia.par_id_pk = establecimiento.par_id_fk
  INNER JOIN sga_adm_canton canton ON canton.can_id_pk = parroquia.can_id_fk
  INNER JOIN sga_adm_zona distrito ON distrito.zon_id_pk = canton.zon_id_fk
  INNER JOIN sga_adm_provincia provincia ON provincia.prv_id_pk = canton.prv_id_fk","*","","ref_id_pk",$data->codigo,2);
				if (count($Regd)==0) 
				{
				echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));
				}else{
				echo json_encode($Regd); 
				}
    break;
    case '3':
    // cargar datos de origen de institucion
				$Regd=$Con->Get_Consulta(" sga_adm_establecimiento establecimiento 
  INNER JOIN sga_adm_institucion institucion ON institucion.ins_id_pk = establecimiento.ins_id_fk
  INNER JOIN sga_adm_tipologiainstitucion tipoins ON tipoins.tin_id_pk = establecimiento.tin_id_fk
  INNER JOIN sga_adm_parroquia parroquia ON parroquia.par_id_pk = establecimiento.par_id_fk
  INNER JOIN sga_adm_canton canton ON canton.can_id_pk = parroquia.can_id_fk
  INNER JOIN sga_adm_zona distrito ON distrito.zon_id_pk = canton.zon_id_fk
  INNER JOIN sga_adm_provincia provincia ON provincia.prv_id_pk = canton.prv_id_fk"," eta_descripcion,
  ins_abreviacion as ins_descripcion,
  tin_abreviacion as tin_descripcion,
  prv_codigo || zon_descripcion nin_descripcion","","eta_id_pk",$data->codigo, 2);
		if (count($Regd)==0) 
		{
		echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));
		}else{
		echo json_encode($Regd); 
		}
    break;
    
    case '4':
    // cargar datos de entidad del sistema
     $Regd=$Con->Get_Consulta("sga_adm_establecimiento as es join sga_adm_institucion as ins on es.ins_id_fk=ins.ins_id_pk","eta_id_pk,eta_descripcion, ins_abreviacion as ins_descripcion","","eta_id_pk",$data->inst,2);
				if (count($Regd)==0) 
				{

				echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));

				}else{
				echo json_encode($Regd); 
				}
    	break;
    case '5':
	 // cargar institucion destino 
				$Regd=$Con->Get_Consulta("sga_adm_establecimiento as es 
     join sga_adm_institucion as ins on es.ins_id_fk=ins.ins_id_pk where ins_visible=true ","ins_id_pk, ins_abreviacion as ins_descripcion","","","",6);
				if (count($Regd)==0) 
				{

				echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));

				}else{
				echo json_encode($Regd); 
				}
    break;
 	case '6':
 	 // cargar datos de cie 10 	
  	    $Regd=$Con->Get_Consulta("sgh_mei_drd
			JOIN sgh_mei_diagnos as d on dia_id_fk=d.dia_id_pk
			JOIN sgh_mei_codigocie10 as c10  on d.c10_id_fk=c10.c10_id_pk","*","","ref_id_fk",$data->codigo,2);
				if (count($Regd)==0) 
				{

				echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));

				}else{
				echo json_encode($Regd); 
				}
 	break;
 	case '7':
 	  # cargar datos de edición de informe
 		 	 $time = time();
		 	 $date=date("Y-m-d ", $time);
		     $mensaje=0;
 			  $Regd=$Con->Get_Consulta("sgh_mei_referencia as r
				join sga_adm_establecimiento as es on r.ins_de_fk=es.eta_id_pk
				join sga_adm_institucion as ins on es.ins_id_fk=ins.ins_id_pk",
				 "*","","usu_id_fk='".$data->usu."' and ref_fecha='".$date."' and ref_id_pk",$data->codigo,2);
				if (count($Regd)==0) 
				{
				echo json_encode($mensaje);
				}else{
				echo json_encode($Regd); 
				}
 				break;	
	case '8':
	  # verificación si existe contra referencia
	    $Regd=$Con->Get_Consulta("sgh_mei_referencia","*","","ref_id_fk",$data->codigo,2);
				if (count($Regd)==0) 
				{
				
				echo json_encode(array('error' =>$error, )); 

				}else{
				echo json_encode($Regd); 
				}
		break;
	case '9':
 	  # cargar datos de edición de contrareferencia
 		 	 $time = time();
		 	 $date=date("Y-m-d ", $time);
		     $mensaje=0;
 			  $Regd=$Con->Get_Consulta("sgh_mei_referencia as r
				join sga_adm_establecimiento as es on r.ins_de_fk=es.eta_id_pk
				join sga_adm_institucion as ins on es.ins_id_fk=ins.ins_id_pk",
				 "*","","usu_id_fk='".$data->usu."' and ref_fecha='".$date."' and ref_id_fk",$data->codigo,2);
				if (count($Regd)==0) 
				{
				echo json_encode($mensaje);
				}else{
				echo json_encode($Regd); 
				}
 	break;
 	case '10':
 	# cargar datos de contra referencia para visualizar
$Regd=$Con->Get_Consulta("sgh_mei_referencia as r
  INNER JOIN sga_adm_establecimiento establecimiento ON establecimiento.eta_id_pk =  r.ins_de_fk
  INNER JOIN sga_adm_institucion institucion ON institucion.ins_id_pk = establecimiento.ins_id_fk
  INNER JOIN sga_adm_tipologiainstitucion tipoins ON tipoins.tin_id_pk = establecimiento.tin_id_fk
  INNER JOIN sga_adm_parroquia parroquia ON parroquia.par_id_pk = establecimiento.par_id_fk
  INNER JOIN sga_adm_canton canton ON canton.can_id_pk = parroquia.can_id_fk
  INNER JOIN sga_adm_zona distrito ON distrito.zon_id_pk = canton.zon_id_fk
  INNER JOIN sga_adm_provincia provincia ON provincia.prv_id_pk = canton.prv_id_fk",
				 "ref_id_pk,
				 ref_tipo,
				ref_codmsp,
				ref_espec,
				ref_fecha,
				ref_halrel,
				ref_justif,
				ref_medico,
				ref_motivo,
				ref_rescuad,
				ref_servi,
				ref_tipo,
				ref_trarea,
				ref_trarec,
				ins_abreviacion,
				tin_abreviacion, ins_de_fk,ins_or_fk,eta_descripcion, prv_codigo || zon_descripcion nin_descripcion","","ref_id_fk",$data->codigo,2);
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
