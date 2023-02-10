<?php
// retornma un json 

include_once("../../../../php/class_consulta.php");
$Con = New Consulta();

$data = json_decode(file_get_contents("php://input"));
$error = "error";
$Regd = $Con->Get_Consulta(" sgh_mei_censo cen
        		join sga_adm_historiaclinica h on cen.hce_id_fk=h.hce_id_pk
				join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
				join sga_adm_persona as pe on p.per_id_fk=pe.per_id_pk",
    "(per_apellidopaterno ||' '|| coalesce(per_apellidomaterno ||' ','') || per_nombres ) as persona,per_numeroidentificacion,hce_numerohc,hce_observacion,hce_id_pk", "", "", "", 6);

if (count($Regd) == 0) {
    echo json_encode(array('error' => $error,));

} else {
    echo json_encode($Regd);
}
?>