<?php  
// incluir conección de base de datos 
// retornma un json 
include_once("../../../../php/class_consulta.php");
$Con=New Consulta();
$data = json_decode(file_get_contents("php://input"));

        $Con=New Consulta();
        $Regd=$Con->Get_Consulta("sgh_mei_codigocie10 order by c10_codigo","c10_codigo,c10_nombre,c10_id_pk,c10_id_fk,c10_estado,
		case when fecha_creacion is not null then
		fecha_creacion->>'usu_login'
		else fecha_modificacion->>'usu_login' end fecha_registro_usuario,
		case when fecha_creacion is not null then
		to_char((fecha_creacion->>'fecha')::TIMESTAMP,'DD-MM-YYYY HH24:MM')
		else to_char((fecha_modificacion->>'fecha')::TIMESTAMP,'DD-MM-YYYY HH24:MM') end fecha_registro","","","",5);
    		if (count($Regd)==0) 
				{

				echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));

				}else{
				echo json_encode($Regd); 
				} 
?>