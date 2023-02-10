<?php
// retornma un json 

include_once("class_consulta.php");
require_once("conexion.php");
$conn =New Conectar();
$Con=New Consulta();

$data = json_decode(file_get_contents("php://input"));
$error="error";
switch ($data->op) {
	//consultar  usuario
	case '1':
	try{
        $user_login = $data->usu ?? "null";
        $user_password = $data->pas ?? "null";
       
        $query = $conn->prepare("select sp_sga_usuario_verificar (?,?)");
        $query->bindValue(1,$user_login,PDO::PARAM_STR);
        $query->bindValue(2,$user_password,PDO::PARAM_STR);
        $query->execute();

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        print_r($rows[0]["sp_sga_usuario_verificar"]);
    } catch(Exception $e) {
        echo json_encode(array("Estado" => 3,"Mensaje" => "Error: ". $e->getMessage()));
    }
  break;
	
	// verifica si tiene el perfil de tratante, laboratorio
	case '2':
	    $Regd=$Con->Get_Consulta("sgu_usu_usuarioperfil
	    JOIN sgu_usu_usuario usu on usu_id_fk=usu.usu_id_pk
        join sgu_usu_perfil per on pfi_id_fk=per.pfi_id_pk where usu_id_pk='".$data->usu."' and mod_id_fk=2","usu_id_pk,mod_id_fk,pfi_descripcion,pfi_id_fk","","","",5);
	if (count($Regd)==0) 
	{
		echo json_encode(array('error'=> $error));
	}else{	echo json_encode($Regd);}
break;

    case '3':
        // cargar modulo
        $Regd=$Con->Get_Consulta("sgu_usu_modulo where mod_codigo is NOT NULL","mod_descripcion,mod_id_pk","","","",5);
        if (count($Regd)==0) {echo json_encode(array('error'=> $error));}
        else{echo json_encode($Regd);}

        break;
    case '4':
        // cargar menu por servicio
        $Regd=$Con->Get_Consulta("sgu_usu_modulomenu mm
        join sgu_usu_menu men on mm.mnu_id_fk = men.mnu_id_pk
        join sgu_usu_modulo mod on mm.mod_id_fk = mod.mod_id_pk WHERE esp_id_fk=".$data->codigo." and smm_activo=true  and mnu_codigo is NULL ORDER BY mnu_orden","mod_descripcion,mod_id_pk,mnu_state,mnu_descripcion,mnu_orden,mnu_codigo,mnu_id_pk,mnu_logo,mnu_tipo","","","",5);
        if (count($Regd)==0) {echo json_encode(array('error'=> $error));}
        else{echo json_encode($Regd);}
        break;

    case '5':
        // cargar sub menu por servicio
        $Regd=$Con->Get_Consulta("sgu_usu_modulomenu mm
        join sgu_usu_menu men on mm.mnu_id_fk = men.mnu_id_pk
        join sgu_usu_modulo mod on mm.mod_id_fk = mod.mod_id_pk WHERE esp_id_fk=".$data->codigo."  and smm_activo=true and mnu_codigo is not NULL ORDER BY mnu_orden","mod_descripcion,mod_id_pk,mnu_state,mnu_descripcion,mnu_orden,mnu_codigo,mnu_id_pk,mnu_logo,mnu_tipo","","","",5);
        if (count($Regd)==0) {echo json_encode(array('error'=> $error));}
        else{echo json_encode($Regd);}
        break;

    case '6':
        // cargar menu por perfil?
        $Regd=$Con->Get_Consulta("sgu_usu_perfilmenu mm
  join sgu_usu_menu men on mm.mnu_id_fk = men.mnu_id_pk
  join sgu_usu_perfil per on mm.pfi_id_fk = per.pfi_id_pk where pfi_id_fk = ".$data->codigo." and pmu_activo=true and mnu_codigo is NULL ORDER BY mnu_orden","pfi_descripcion as mod_descripcion,pfi_id_fk as mod_id_pk,mnu_state,mnu_descripcion,mnu_orden,mnu_codigo,mnu_id_pk,mnu_logo,mnu_tipo","","","",5);
        if (count($Regd)==0) {echo json_encode(array('error'=> $error));}
        else{echo json_encode($Regd);}
        break;
    case '7':
        //cargar submenu por perfil ?
        $Regd=$Con->Get_Consulta("sgu_usu_perfilmenu mm
  join sgu_usu_menu men on mm.mnu_id_fk = men.mnu_id_pk
  join sgu_usu_perfil per on mm.pfi_id_fk = per.pfi_id_pk where pfi_id_fk = ".$data->codigo." and pmu_activo=true and mnu_codigo is not NULL ORDER BY mnu_orden","pfi_descripcion as mod_descripcion,pfi_id_fk as mod_id_pk,mnu_state,mnu_descripcion,mnu_orden,mnu_codigo,mnu_id_pk,mnu_logo,mnu_tipo","","","",5);
        if (count($Regd)==0) {echo json_encode(array('error'=> $error));}
        else{echo json_encode($Regd);}
        break;

    case '8':
        try{
            $user_login = $data->usu ?? "null";

            $query = $conn->prepare("select json_agg(r) from (
                select 
            )r");
            $query->bindValue(1,$user_login,PDO::PARAM_STR);
            $query->execute();

            $rows = $query->fetcColumn();
            $query->closeCursor();
            print_r($rows);
        } catch(Exception $e) {
            echo json_encode(array(array('error'=> $error)));
        }
        break;
    default:
	# code...
	break;
}		
				     
?>
