<?php
// retornma un json 

include_once("../../../../php/class_consulta.php");
$Con=New Consulta();

$data = json_decode(file_get_contents("php://input"));
$error="error";
switch ($data->op) {
    case '1':
		  	   $Regd=$Con->Get_Consulta("sgh_mei_censo as c
				JOIN sga_adm_historiaclinica as h on c.hce_id_fk=h.hce_id_pk
				join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
				join sga_adm_persona as pe on p.per_id_fk=pe.per_id_pk
				join sga_adm_cama as ca on c.cam_id_fk=ca.cam_id_pk
				JOIN sga_adm_tipocama as tc on ca.tca_serv_fk=tc.tca_id_pk 
				JOIN sga_adm_tipocama as pi on ca.tca_piso_fk=pi.tca_id_pk
				where cen_tipo='INGRESO' AND cen_visible='TRUE' and tc.tca_descripcion='".$data->opcarga."' ORDER BY pi.tca_descripcion DESC, cam_codigo::int ASC",
				"per_numeroidentificacion,cen_fecha,cen_id_pk,lpad(cam_codigo::text,3,'000') cam_codigo,per_apellidopaterno ||' '|| coalesce(per_apellidomaterno || ' ','') || per_nombres paciente,
				hce_id_pk,cam_id_pk,tc.tca_descripcion,tc.tca_id_pk,hce_numerohc,cen_tipo,cen_visible,
                pi.tca_descripcion as piso,(select count(*) from sgh_mei_evolucion evo where (eyp_estado = false) and evo.hce_id_fk = h.hce_id_pk AND (evo.eyp_fechas >= c.cen_fecha)) cambios,
                case  when coalesce(date_part('year',age(per_fechanacimiento)),0) <> 0
                    then date_part('year',age(per_fechanacimiento)) || ' año(s)'
                when coalesce(date_part('year',age(per_fechanacimiento)),0) = 0 and coalesce(date_part('mons',age(per_fechanacimiento)),0) <> 0
                    then date_part('mons',age(per_fechanacimiento)) || ' mes(es)'
                when coalesce(date_part('year',age(per_fechanacimiento)),0) = 0 and coalesce(date_part('mons',age(per_fechanacimiento)),0) = 0
                    then  date_part('days',age(per_fechanacimiento)) || ' día(s)'
                end as Edad","",
               "","",5);
				
				if (count($Regd)==0) 
				{
			     echo json_encode(array('error' =>$error, )); 

				}else{
				echo json_encode($Regd); 
				}
	break;
	case '2':
		  	   $Regd=$Con->Get_Consulta("sgh_mei_evolucion where hce_id_fk='$data->hcl' and eyp_fechas >='$data->fecha' and eyp_estado=FALSE",
                   "eyp_estado","",
               "","",5);

				if (count($Regd)==0)
				{
			     echo json_encode(array('error' =>$error, ));

				}else{
				echo json_encode($Regd);
				}
	break;

default:
# code...
break;
}
?>