<?php
require_once("../../../../php/conexion.php");
	$conn=new Conectar();	
	
	$data = json_decode(file_get_contents("php://input"));
switch ($data->op) {
 case '1':
	try{
      	
  	  $consulta = $conn->prepare('SELECT sgh_censopaciente_ingreso_pa(?,?,?,?)');
      $consulta->bindParam(1, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->hce, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->cam, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $data->est, PDO::PARAM_STR, 4000);

        $consulta->execute();
      $dat=$consulta->fetch (PDO::FETCH_ASSOC);
      $consulta->closeCursor();
 		}
     	catch(PDOException $Exception){$dat= $Exception;}
    	$res = json_encode($dat);
        echo $res;
 break;
 case '2':
     $datos=$data->hist;
     $oph=1;

     try{

         $consulta = $conn->prepare('SELECT sgh_historiaclinica_ingreso_pa(?,?,?,?,?,?,?,?)');
         $consulta->bindParam(1, $data->oph, PDO::PARAM_STR, 4000);
         $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
         $consulta->bindParam(3, $datos->{'sex_id_fk'}, PDO::PARAM_STR, 4000);
         $consulta->bindParam(4, $datos->{'per_numeroidentificacion'}, PDO::PARAM_STR, 4000);
         $consulta->bindParam(5, $datos->{'per_apellidopaterno'}, PDO::PARAM_STR, 4000);
         $consulta->bindParam(6, $datos->{'per_apellidomaterno'}, PDO::PARAM_STR, 4000);
         $consulta->bindParam(7, $datos->{'per_nombres'}, PDO::PARAM_STR, 4000);
         $consulta->bindParam(8, $datos->{'per_fechanacimiento'}, PDO::PARAM_STR, 4000);
         $consulta->execute();
         $dat=$consulta->fetch (PDO::FETCH_ASSOC);
         $consulta->closeCursor();
     }
     catch(PDOException $Exception){$dat= $Exception;}
     $res = json_encode($dat);
     echo $res;

 break;
    default:
        # code...
        break;
}

?>