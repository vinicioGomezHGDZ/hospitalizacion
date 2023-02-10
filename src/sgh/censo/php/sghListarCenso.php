<?php
// incluir conección de base de datos 
// retornma un json 
include_once("../../../../php/class_consulta.php");
$Con = New Consulta();
$data = json_decode(file_get_contents("php://input"));
$error = "error";
switch ($data->op) {
    case '1':
        # cargar pacientes con historia clínica...
        $Regd = $Con->Get_Consulta("sga_adm_historiaclinica his
	 	join sga_adm_paciente as p on his.pac_id_fk=p.pac_id_pk
	 	join sga_adm_persona as pe on p.per_id_fk=pe.per_id_pk  
	 	left JOIN sga_adm_sexo  as sex on pe.sex_id_fk=sex.sex_id_pk
	 	where hce_fallecido <> true ", "(per_apellidopaterno ||' '|| coalesce(per_apellidomaterno || ' ','') || per_nombres) as persona, per_numeroidentificacion,hce_numerohc,hce_id_pk,sex_codigo as per_sexo,date_part('year',age(per_fechanacimiento)) as Edad", "", "", "", 5);
        if (count($Regd) == 0) {
            echo json_encode(array('error' => $error,));
        } else {
            echo json_encode($Regd);
        }
        break;
    case '2':
        # code...
        $Regd = $Con->Get_Consulta("sga_adm_historiaclinica as h
				join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
				join sga_adm_persona as pe on p.per_id_fk=pe.per_id_pk
				JOIN sga_adm_sexo  as sex on pe.sex_id_fk=sex.sex_id_pk
				",
            "per_numeroidentificacion, (per_apellidopaterno ||' '|| coalesce(per_apellidomaterno || ' ','') || per_nombres) as persona,hce_id_pk,hce_numerohc,sex_codigo as per_sexo,date_part('year',age(per_fechanacimiento)) as Edad
", "", "hce_id_pk", $data->codigo, 2);

        if (count($Regd) == 0) {
            echo json_encode(array('error' => $error,));

        } else {
            echo json_encode($Regd);
        }
        break;
    case '3':
        # cargar cama
        $Regd = $Con->Get_Consulta("sga_adm_cama as c
				JOIN sga_adm_tipocama as tc on c.tca_serv_fk=tc.tca_id_pk
			    join sga_adm_tipocama as pi on tca_piso_fk=pi.tca_id_pk
			    join sga_adm_tipocama as ha on tca_habi_fk=ha.tca_id_pk
			    join sga_adm_camaestado as ec on c.ces_id_fk=ec.ces_id_pk where cam_visible = true and ces_descripcion='DESOCUPADA' AND tc.tca_descripcion ='" . $data->serv . "' ORDER BY ha.tca_descripcion",
            "cam_id_pk,cam_codigo,tc.tca_descripcion as servicio,ha.tca_descripcion as habitacion ,pi.tca_descripcion as piso,ces_descripcion ", "", "", "", 5);

        if (count($Regd) == 0) {
            echo json_encode(array('error' => $error,));

        } else {
            echo json_encode($Regd);
        }
        break;
    case '4':
        # code...
        $Regd = $Con->Get_Consulta("sga_adm_cama as c
				JOIN sga_adm_tipocama as tc on c.tca_serv_fk=tc.tca_id_pk
			    join sga_adm_tipocama as pi on tca_piso_fk=pi.tca_id_pk
			    join sga_adm_tipocama as ha on tca_habi_fk=ha.tca_id_pk
			    join sga_adm_camaestado as ec on c.ces_id_fk=ec.ces_id_pk",
            "ces_id_pk,cam_id_pk,cam_codigo,tc.tca_descripcion as servicio,ha.tca_descripcion as habitacion ,pi.tca_descripcion as piso,ces_descripcion", "", "cam_id_pk", $data->codigo, 2);

        if (count($Regd) == 0) {
            echo json_encode(array('error' => $error,));

        } else {
            echo json_encode($Regd);
        }

        break;
    case '5':
        # validar que paciente no se repita
        $Regd = $Con->Get_Consulta("sgh_mei_censo", "hce_id_fk,cen_tipo,cen_visible", "", "cen_visible=TRUE and hce_id_fk", $data->codigo, 2);

        if (count($Regd) === 0) {
            echo json_encode(array('status' => 'success','message'=>'No existe paciente en hospitalización'));
            //echo json_encode(array('error' => $error,));

        } else {
            echo json_encode(array('status' => 'warning','message'=>'Existe paciente en hospitalización'));
            //echo json_encode($Regd);
        }
        break;

    case '6';
        $Regd = $Con->Get_Consulta("sga_adm_sexo", "sex_id_pk,sex_codigo,sex_descripcion", "", "", "", 5);
        if (count($Regd) == 0) {
            echo json_encode(array('error' => $error,));
        } else {
            echo json_encode($Regd);
        }

        break;
    case '7':
        # code...
        $Regd = $Con->Get_Consulta("sga_adm_historiaclinica as h
				join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
				join sga_adm_persona as pe on p.per_id_fk=pe.per_id_pk where per_nombres='" . $data->nombre . "' AND per_apellidopaterno='" . $data->apaterno . "' AND per_apellidomaterno ='" . $data->amaterno . "'
				",
            "(per_nombres||' '||per_apellidopaterno ||' '|| per_apellidomaterno ) as persona,per_numeroidentificacion
					", "", "", "", 5);

        if (count($Regd) == 0) {
            echo json_encode(array('error' => $error,));

        } else {
            echo json_encode($Regd);
        }
        break;
        case '8':
        # code...
        $Regd = $Con->Get_Consulta("sga_adm_tipoidentificacion where tid_visible=true", "tid_id_pk,tid_descripcion", "", "","", 5);

        if (count($Regd) == 0) {
            echo json_encode(array('error' => $error,));

        } else {
            echo json_encode($Regd);
        }
        break;
    default:
        # code...
        break;

}


?>
