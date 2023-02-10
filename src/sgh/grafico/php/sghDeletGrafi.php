<?php

	require_once("../../../../php/conexion.php");
	
	$data = json_decode(file_get_contents("php://input"));
	
	//print_r($data);
	
 	$gra_estado=false;
 	$gra_id_pk= $data->id;
	$gra_nombre= "eliminado";

	$op="2";
	$conn=new Conectar();

	try{
	    //Importo conexion de archivo debido a que mensaje de respuesta no devuelve con metodo de conexion
      $consulta = $conn->prepare('SELECT sgh_graf_edita_pa(?,?,?,?)');
      
      $consulta->bindParam(1, $op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $gra_id_pk, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $gra_nombre, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $gra_estado, PDO::PARAM_STR, 4000);
     
          $echo= $consulta->execute();

	 $dat=$consulta->fetch (PDO::FETCH_ASSOC);
      $consulta->closeCursor();
     
 		}
 	catch(PDOException $Exception){
		      $mensaje= $Exception;
		}
		
	$res = json_encode( $dat );	

echo $res;
?>