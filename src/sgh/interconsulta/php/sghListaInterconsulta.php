<?php
// retornma un json 
date_default_timezone_set('America/Guayaquil');
include_once("../../../../php/class_consulta.php");
$Con=New Consulta();
$Con2=New Consulta();
$data = json_decode(file_get_contents("php://input"));
//print_r($data);
$error="error";
switch ($data->op) {
	case '1':
				$Regd=$Con->Get_Consulta("sgh_mei_intercsol as int
												JOIN sgh_mei_motdes as mo on mo.int_id_fk= int.int_id_pk
 								    where hce_id_fk='".$data->idhc."' order by int_fecha desc","*","","","",5);
				if (count($Regd)==0) 
				{
				echo json_encode(array('error' =>$error, )); 
				}else{
				echo json_encode($Regd); 
				}
				break;
		
	case '2':
	// carga datos de intercosulta
			$Regd=$Con->Get_Consulta("sgh_mei_intercsol as int
											JOIN sgh_mei_motdes as mo on mo.int_id_fk= int.int_id_pk
											jOIN sga_adm_cama as ca on mo.cam_id_fk= ca.cam_id_pk
											JOIN sgh_mei_intercsol as info on info.int_id_fk=int.int_id_pk",
											"int.int_id_pk as idsol,info.int_id_pk as idinf,mds_grabed,mds_sersol,ca.cam_codigo,int.int_cuclia,int.int_resexa,int.int_planes,info.int_cucint,info.int_plandia,info.int_pltrap,info.int_recrcl,info.int_archivo","","int.int_id_pk",$data->codigo,2);
				if (count($Regd)==0) 
				{

				echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));

				}else{
				echo json_encode($Regd); 
				}
    break;

 	case '3':
 	/// cargo datos de cie 10 solicitud
 	   $Regd=$Con->Get_Consulta("sgh_mei_interdia join sgh_mei_diagnos as d on dia_id_fk=d.dia_id_pk JOIN sgh_mei_codigocie10 as c10  on d.c10_id_fk=c10.c10_id_pk","c10_id_pk,c10.c10_nombre,c10_codigo,dia_resp,dia_id_pk","","int_id_fk",$data->codigo,2);
				if (count($Regd)==0) 
				{

				echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte', 'codigo:'=>$data->codigo));

				}else{
				echo json_encode($Regd); 
				}
 	break;
 	case '4':
 	// verifica datos si el informe ya se realizo
     	$mensaje=0;
 		 $Regd=$Con->Get_Consulta("sgh_mei_intercsol","*","","int_id_fk",$data->codigo,2);
				if (count($Regd)==0) 
				{

				echo json_encode($mensaje);

				}else{
				echo json_encode($Regd); 
				}
 		break;

 	case '5':
 	// carga datos de cien10 iforme
 		$Reg=$Con2->Get_Consulta("sgh_mei_intercsol as int
								  JOIN sgh_mei_motdes as mo on mo.int_id_fk= int.int_id_pk
								  jOIN sga_adm_cama as ca on mo.cam_id_fk= ca.cam_id_pk
								  join sga_adm_profesional pr on mo.med_id_fk=pr.pro_id_pk
								  JOIN sga_adm_persona as pe on pe.per_id_pk=pr.per_id_fk
								  JOIN sgh_mei_intercsol as info on info.int_id_fk=int.int_id_pk",
								 "int.int_id_pk as idsol,info.int_id_pk as idinf","","int.int_id_pk",$data->codigo,2);
		if (count($Reg)==0) 
		{
		echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));
	    }
	    else
		{
		   $id=$Reg[0]["idinf"];
		   $Regd=$Con->Get_Consulta("sgh_mei_interdia join sgh_mei_diagnos as d on dia_id_fk=d.dia_id_pk JOIN sgh_mei_codigocie10 as c10  on d.c10_id_fk=c10.c10_id_pk","c10_id_pk,c10.c10_nombre,c10_codigo,dia_resp,dia_id_pk","","int_id_fk",$id,2);
				if (count($Regd)==0) 
				{

				echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));

				}else{
				echo json_encode($Regd); 
				}
		}
 		break;
 		case '6':
 			# cargar datos de solicitud 
			$Regd=$Con->Get_Consulta("sgh_mei_intercsol as int
										JOIN sgh_mei_motdes as mo on mo.int_id_fk= int.int_id_pk
										jOIN sga_adm_cama as ca on mo.cam_id_fk= ca.cam_id_pk
										JOIN sga_adm_tipocama as tc on ca.tca_serv_fk=tc.tca_id_pk
										join sga_adm_tipocama as pi on ca.tca_piso_fk=pi.tca_id_pk
										",
								" tc.tca_descripcion,pi.tca_descripcion as piso,mds_sersol,cam_codigo,int_cuclia,int_resexa,int_planes,mds_medico,int_archivo","","int_id_pk",$data->codigo,2);
				if (count($Regd)==0) 
				{

				echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));

				}else{
				echo json_encode($Regd); 
				}

 			break;
	
		case '7':
			# cargar datos de informe para editar

		     $mensaje=0;
			$Regd=$Con->Get_Consulta("sgh_mei_intercsol as int
										JOIN sgh_mei_motdes as mo on mo.int_id_fk= int.int_id_pk
										jOIN sga_adm_cama as ca on mo.cam_id_fk= ca.cam_id_pk
										JOIN sga_adm_tipocama as tc on ca.tca_serv_fk=tc.tca_id_pk
										join sga_adm_tipocama as pi on ca.tca_piso_fk=pi.tca_id_pk
										",
								" tc.tca_descripcion,pi.tca_descripcion as piso,mds_sersol,cam_codigo,mds_grabed,int_cuclia,int_resexa,int_planes,med_id_fk,int_id_pk,mds_id_pk,mds_medico,int_archivo","","usu_id_fk='".$data->usu."' and int_fecha=current_date and int_id_pk",$data->codigo,2);
				if (count($Regd)==0) 
				{

				echo json_encode($mensaje);

				}else{
				echo json_encode($Regd); 
				}

 			break;
 		case '8':
 			 # cargar datos de edición de informe
 		 	 $time = time();
		 	 $date=date("Y-m-d ", $time);
		     $mensaje=0;
 				 $Regd=$Con->Get_Consulta("sgh_mei_intercsol as int
  					JOIN sgh_mei_intercsol as inf on inf.int_id_fk= int.int_id_pk",
				 "inf.int_cucint,inf.int_plandia,inf.int_pltrap,inf.int_recrcl,inf.int_id_pk,inf.int_fecha,inf.int_id_fk,inf.int_archivo","","inf.usu_id_fk='".$data->usu."' and inf.int_fecha='".$date."' and inf.int_id_fk",$data->codigo,2);
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
