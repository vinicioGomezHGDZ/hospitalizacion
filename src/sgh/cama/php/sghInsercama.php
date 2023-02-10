<?php
require_once("../../../../php/conexion.php");
	$conn=new Conectar();	
	$data = json_decode(file_get_contents("php://input"));
	$cama=$data->tpc;
	//declaracion de bariables
    $null=null;
switch ($data->op) {
    case '1':
        try{

            $consulta = $conn->prepare('SELECT sgh_cama_ingresar_pa(?,?,?,?,?,?,?,?,?,?)');
            $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
            $consulta->bindParam(2, $cama->{'cam_id_pk'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(3, $cama->{'tca_serv_fk'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(4, $cama->{'tca_piso_fk'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(5, $cama->{'tca_habi_fk'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(6, $cama->{'cam_codigo'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(7, $cama->{'cam_descripcion'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(8, $cama->{'tca_visible'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(9, $cama->{'ces_id_fk'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(10, $data->usu, PDO::PARAM_STR, 4000);

            $consulta->execute();

            $dat=$consulta->fetch (PDO::FETCH_ASSOC);
            $consulta->closeCursor();

        }
        catch(PDOException $Exception){
            $dat= $Exception;
        }

        $res = json_encode($dat);

        echo $res;
break;
    case '2':
        print_r($cama);

        if ($cama->{'tca_visible'} === 1 ) {$estado=ture;} else{$estado=false;}
        try{

            $consulta = $conn->prepare('SELECT sgh_cama_ingresar_pa(?,?,?,?,?,?,?,?,?,?)');
            $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
            $consulta->bindParam(2, $cama->{'cam_id_pk'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(3, $null , PDO::PARAM_STR, 4000);
            $consulta->bindParam(4, $null , PDO::PARAM_STR, 4000);
            $consulta->bindParam(5, $null , PDO::PARAM_STR, 4000);
            $consulta->bindParam(6, $null , PDO::PARAM_STR, 4000);
            $consulta->bindParam(7, $null , PDO::PARAM_STR, 4000);
            $consulta->bindParam(8, $cama->{'tca_visible'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(9, $null, PDO::PARAM_STR, 4000);
            $consulta->bindParam(10, $data->usu, PDO::PARAM_STR, 4000);

            $consulta->execute();

            $dat=$consulta->fetch (PDO::FETCH_ASSOC);
            $consulta->closeCursor();

        }
        catch(PDOException $Exception){
            $dat= $Exception;
        }

        $res = json_encode($dat);

        echo $res;
       break;

        default:
        # code...
        break;
}

?>