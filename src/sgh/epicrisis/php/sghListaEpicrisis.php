<?php
date_default_timezone_set('America/Guayaquil');
include_once("../../../../php/class_consulta.php");
$Con=New Consulta();
$data = json_decode(file_get_contents("php://input"));
$error="error";
switch ($data->op) {
	case '1':
		$Regd=$Con->Get_Consulta("sgh_mei_epicrisis where hce_id_fk='".$data->idhc."'order by epi_fecha desc","*","","","",5);
		if (count($Regd)==0) 
		  {
			echo json_encode(array('error' =>$error, )); 
     	  }else
     	  {	echo json_encode($Regd);}

	break;
		
	case '2':
		# CARGA TOSAS LAS EPICRISIS
		$Regd=$Con->Get_Consulta("sgh_mei_epicrisis","*","","epi_id_pk",$data->codigo,2);
		if (count($Regd)==0) 
		  {
			echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));
     	  }else
     	  {	echo json_encode($Regd); }		
    break;

 	case '3':
 	# CARGAR DIAGNOSTICOS
 	   $Regd=$Con->Get_Consulta(" sgh_mei_dei join sgh_mei_diagnos as d on dia_id_fk=d.dia_id_pk JOIN sgh_mei_codigocie10 as c10  on d.c10_id_fk=c10.c10_id_pk where dia_tipo='".$data->tipo."'and epi_id_fk='$data->codigo'  order by dei_id_pk","c10.c10_nombre,c10_codigo,dia_resp,dia_tipo,dia_id_pk,c10.c10_id_pk","","","",5);
				if (count($Regd)==0) 
				{

                    echo json_encode(array('error' =>$error, ));

                }else{
				echo json_encode($Regd); 
				}
 	break;

 	case '4':
 	# CARGAR MEDICO

 		 $Regd=$Con->Get_Consulta(" sgh_mei_med as me
     	join sgh_mei_epicrisis as epi on me.epi_id_fk=epi_id_pk
      join sga_adm_especialidad_profesional as esp on me.pro_id_pk=esp.pro_id_fk
      join sga_adm_profesional pr on esp.pro_id_fk = pr.pro_id_pk
      join sga_adm_especialidad es on esp.esp_id_fk = es.esp_id_pk
      JOIN sga_adm_persona as pe on pe.per_id_pk=pr.per_id_fk","per_apellidomaterno,per_apellidopaterno,per_nombres,esp_descripcion,pro_codigomsp,med_period,pr.pro_id_pk as pro_id_pk, med_id_pk","","epi_id_pk",$data->codigo,2);
         //print_r($Regd);
                if (count($Regd)==0) 
                {

                echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));

                }else{
                echo json_encode($Regd); 
                }
 		break;
 	case '5':
 	# CARGAR DATOS DE EDICÓN
//        usu_id_fk='".$data->usu."'
	    $mensaje=0;
		$Regd=$Con->Get_Consulta("sgh_mei_epicrisis","*","","epi_fecha>='".$data->cen_fecha."' and epi_id_pk",$data->codigo,2);
		if (count($Regd)==0) 
		  {
			echo json_encode(array($mensaje));
     	  }else
     	  {	echo json_encode($Regd); }		
    break;

    case '6':
    # code... CARGARGAR DIAS DE ESTADIA
    $Regd=$Con->Get_Consulta("sgh_mei_censo as c
				JOIN sga_adm_historiaclinica as h on c.hce_id_fk=h.hce_id_pk
				join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
				join sga_adm_persona as pe on p.per_id_fk=pe.per_id_pk where cen_id_pk='".$data->idce."'","cen_id_pk,cen_fecha,per_nombres,per_apellidopaterno,per_apellidomaterno,(current_date - cen_fecha ) as dia","","","",5);
		if (count($Regd)==0) 
		  {
			echo json_encode(array('error' =>$error, )); 
     	  }else
     	  {	echo json_encode($Regd);
     	  }

    break;
    case '7':
        $Regd=$Con->Get_Consulta("sga_adm_admision  where hce_id_fk='".$data->hcl ."' AND adm_fechaingreso='".$data->fecha."'","adm_id_pk","","","",5);
        if (count($Regd)==0)
        {
            echo json_encode(array('error'=> $error));
        }else{	echo json_encode($Regd);}
        break;
    case '8':
        $Regd=$Con->Get_Consulta("sgh_mei_epicrisis  where hce_id_fk ='".$data->hcl ."' AND epi_fecha>'".$data->fecha."'","epi_fecha","","","",5);
        if (count($Regd)==0)
        {
            echo json_encode(array('error'=> $error));
        }else{	echo json_encode($Regd);}
        break;

    case '9':
        $Regd=$Con->Get_Consulta("sga_adm_admision  where hce_id_fk='".$data->hcl ."' AND adm_fechadealta='".$data->fecha."'","adm_id_pk,adm_fechadealta","","","",5);
        if (count($Regd)==0)
        {
            echo json_encode(array('error'=> $error));
        }else{	echo json_encode($Regd);}
        break;

    case '10':
        # CARGAR DATOS DE EDICÓN cuando paciente ya haya sido dado de alta

        $mensaje=0;
        $Regd=$Con->Get_Consulta("sgh_mei_epicrisis","*","","epi_id_pk",$data->codigo,2);
        if (count($Regd)==0)
        {
            echo json_encode(array($mensaje));
        }else
        {	echo json_encode($Regd); }
        break;

 	default:
	# code...
	break;
   }						     
?>
