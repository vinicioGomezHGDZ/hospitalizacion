<?php  
// incluir conección de base de datos 
// retornma un json 
include_once("../../../../php/class_consulta.php");
$Con=New Consulta();
$data = json_decode(file_get_contents("php://input"));

$error="error";
switch ($data->op) {
    case '1':
        $Regd=$Con->Get_Consulta(" sga_adm_cama as c
join sga_adm_tipocama as s on c.tca_serv_fk=s.tca_id_pk
join sga_adm_tipocama as h on c.tca_habi_fk=h.tca_id_pk
join sga_adm_tipocama as p on c.tca_piso_fk=p.tca_id_pk
join sga_adm_camaestado as ce on c.ces_id_fk=ce.ces_id_pk ORDER BY h.tca_descripcion, c.cam_codigo::int","ces_id_pk,cam_id_pk,s.tca_descripcion as servisio,h.tca_descripcion as habitacion,p.tca_descripcion as piso,cam_codigo as cama ,cam_descripcion,cam_visible,ces_descripcion as estado
","","","",5);
        if (count($Regd)==0)
        {
            echo json_encode(array('error' =>$error, ));
        }else
            {
            echo json_encode($Regd);
           }
        break;
    case '2':
        $Regd=$Con->Get_Consulta("sga_adm_tipocama","tca_id_pk,tca_descripcion as servicio,tca_tipo","","tca_visible = true and tca_tipo",$data->fil,2);
        if (count($Regd)==0)
        {
            echo json_encode(array('error' =>$error, ));
        }else
        {
            echo json_encode($Regd);
        }
    break;
    case '3':
        $Regd=$Con->Get_Consulta("sga_adm_camaestado","*","","","",5);
        if (count($Regd)==0)
        {
            echo json_encode(array('error' =>$error, ));
        }else
        {
            echo json_encode($Regd);
        }
        break;
    case '4':
        $Regd=$Con->Get_Consulta("sga_adm_tipocama","*","","tca_visible=true and tca_codigoprincipal",$data->codigo,2);
        if (count($Regd)==0)
        {
            echo json_encode(array('error' =>$error, ));
        }else
        {
            echo json_encode($Regd);
        }
        break;
    case '5':
        $Regd=$Con->Get_Consulta("sga_adm_cama","*","","cam_id_pk",$data->codigo,2);
        if (count($Regd)==0)
        {
            echo json_encode(array('error' =>$error, ));
        }else
        {
            echo json_encode($Regd);
        }
        break;
// listar pacientes de cama
    case '6':
        $Regd=$Con->Get_Consulta("sga_adm_cama as c
join sgh_mei_censo as cen on c.cam_id_pk = cen.cam_id_fk
join sga_adm_historiaclinica hc on cen.hce_id_fk = hc.hce_id_pk
join sga_adm_paciente pa on hc.pac_id_fk = pa.pac_id_pk
join sga_adm_persona per on pa.per_id_fk = per.per_id_pk","'Paciente ' || per_nombres || ' ' || per_apellidomaterno || ' ' || per_apellidopaterno || ' Cédula: ' || per_numeroidentificacion as paciente","","cen_visible =true and cam_id_pk",$data->codigo,2);
        if (count($Regd)==0)
        {
            echo json_encode(array('error' =>$error, ));
        }else
        {
            echo json_encode($Regd);
        }
        break;
    default:
        # code...
        break;
}
?>