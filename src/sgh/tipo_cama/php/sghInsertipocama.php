<?php
require_once("../../../../php/conexion.php");
	$conn=new Conectar();	
	$data = json_decode(file_get_contents("php://input"));
	$tpcama=$data->tpc;
	//declaracion de bariables
    $null=null;
switch ($data->op) {
    case '1':
        try{

            $consulta = $conn->prepare('SELECT sgh_tipocama_ingresar_pa(?,?,?,?,?,?,?)');
            $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
            $consulta->bindParam(2, $tpcama->{'tca_id_pk'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(3, $tpcama->{'tca_codigoprincipal'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(4, $tpcama->{'tca_descripcion'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(5, $null, PDO::PARAM_STR, 4000);
            $consulta->bindParam(6, $tpcama->{'tca_tipo'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(7, $data->usu, PDO::PARAM_STR, 4000);

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
        print_r($data);
        try{

            $consulta = $conn->prepare('SELECT sgh_tipocama_ingresar_pa(?,?,?,?,?,?,?)');
            $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
            $consulta->bindParam(2, $tpcama->{'tca_id_pk'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(3, $null, PDO::PARAM_STR, 4000);
            $consulta->bindParam(4, $null, PDO::PARAM_STR, 4000);
            $consulta->bindParam(5, $tpcama->{'tca_visible'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(6, $null, PDO::PARAM_STR, 4000);
            $consulta->bindParam(7, $data->usu, PDO::PARAM_STR, 4000);

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