<?php  
date_default_timezone_set('America/Guayaquil');	
include_once("../../../../php/class_consulta.php");
$Con=New Consulta();
$data = json_decode(file_get_contents("php://input"));
	$error="error";
	$true=true;
switch ($data->op) {
	case '1':
		# code...
			$Regd=$Con->Get_Consulta("sga_adm_historiaclinica as h
							join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
							join sga_adm_persona as  per on p.per_id_fk=per.per_id_pk
							left join sga_adm_parroquia as pa on per.par_id_fk=pa.par_id_pk
							left join sga_adm_canton as ca on pa.can_id_fk=ca.can_id_pk
							left join sga_adm_provincia as pro on ca.prv_id_fk=pro.prv_id_pk
							left join sga_adm_pais as pais on pro.pai_id_fk = pais.pai_id_pk
							join sgh_mei_censo as cen on cen.hce_id_fk= h.hce_id_pk
							join sga_adm_cama as c on  cen.cam_id_fk = c.cam_id_pk
							JOIN sga_adm_tipocama as tc on c.tca_serv_fk=tc.tca_id_pk
						    join sga_adm_tipocama as pi on tca_piso_fk=pi.tca_id_pk
						    left JOIN sga_adm_sexo as se on se.sex_id_pk=per.sex_id_fk where hce_id_pk ='".$data->codigo."'ORDER BY cen_id_pk DESC",
						   "cen_id_pk,per_apellidopaterno,per_numeroidentificacion,per_apellidomaterno,per_nombres,per_fechanacimiento,per_numeroidentificacion,prv_descripcion,can_descripcion,par_descripcion,per_direccionprincipal,hce_numerohc,per_lugardenacimiento,tc.tca_descripcion,pi.tca_descripcion as piso,cam_codigo,per_telefonocelular as tel_numero,pai_descripcion,date_part('year',age(per_fechanacimiento)) || ' AÑOS '||date_part('mons',age(per_fechanacimiento)) ||' MESES '|| date_part('days',age(per_fechanacimiento)) || ' DÍAS' as Edad ,sex_codigo as per_sexo","",
						   "","",5);

	      if (count($Regd)==0) 
		  {
		   	echo json_encode(array('error'=> $error));
		  }
		  else
		  {
			echo json_encode($Regd); 
		  } 
		break;
	case '2':
	# code...
	$Regd=$Con->Get_Consulta("sga_adm_camaestado","*","","ces_visible","true",2);

	      if (count($Regd)==0) 
		  {
		   	echo json_encode(array('error'=> $error));
		  }
		  else
		  {
			echo json_encode($Regd); 
		  } 
	break;	
	case '3':
	# code...
	//print_r($data);
	$Regd=$Con->Get_Consulta("sgh_mei_epicrisis","epi_fecha","","epi_estado=true and epi_fecha >= '".$data->fecha."' and hce_id_fk",$data->hcl,2);

	      if (count($Regd)==0) 
		  {
		   	echo json_encode(array('error'=> $error));
		  }
		  else
		  {
			echo json_encode($Regd); 
		  }
	break;
    case '4':
        # cargar cama
        $Regd=$Con->Get_Consulta("sga_adm_cama as c
				JOIN sga_adm_tipocama as tc on c.tca_serv_fk=tc.tca_id_pk
			    join sga_adm_tipocama as pi on tca_piso_fk=pi.tca_id_pk
			    join sga_adm_tipocama as ha on tca_habi_fk=ha.tca_id_pk
			    join sga_adm_camaestado as ec on c.ces_id_fk=ec.ces_id_pk where ces_descripcion='DESOCUPADA'",
            "cam_id_pk,cam_codigo,tc.tca_descripcion as servicio,ha.tca_descripcion as habitacion ,pi.tca_descripcion as piso,ces_descripcion","","","",5);

        if (count($Regd)==0)
        {
            echo json_encode(array('error' =>$error, ));

        }else{
            echo json_encode($Regd);
        }
        break;

    case '5':
        # code...

        $Regd=$Con->Get_Consulta("sga_adm_cama as c
				JOIN sga_adm_tipocama as tc on c.tca_serv_fk=tc.tca_id_pk
			    join sga_adm_tipocama as pi on tca_piso_fk=pi.tca_id_pk
			    join sga_adm_tipocama as ha on tca_habi_fk=ha.tca_id_pk
			    join sga_adm_camaestado as ec on c.ces_id_fk=ec.ces_id_pk where cam_visible = true and ces_descripcion='DESOCUPADA' AND tc.tca_descripcion ='".$data->serv."'",
            "cam_id_pk,cam_codigo,tc.tca_descripcion as servicio,ha.tca_descripcion as habitacion ,pi.tca_descripcion as piso,ces_descripcion ","","","",5);

        if (count($Regd)==0)
        {
            echo json_encode(array('error'=> $error));
        }
        else
        {
            echo json_encode($Regd);
        }
        break;


    default:
		# code...
		break;
}


?>
