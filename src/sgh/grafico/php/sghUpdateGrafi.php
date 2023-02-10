<?php

	require_once("../../../../php/conexion.php");
	
	$data = json_decode(file_get_contents("php://input"));
	
	//print_r($data);
	
 	$gra_estado=true;
 	$grafi=$data->grafi;

	$op="1";
	$conn=new Conectar();

	try{
	    //Importo conexion de archivo debido a que mensaje de respuesta no devuelve con metodo de conexion
      $consulta = $conn->prepare('SELECT sgh_graf_edita_pa(?,?,?,?)');
      
      $consulta->bindParam(1, $op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->id, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $grafi->{'gra_nombre'}, PDO::PARAM_STR, 4000);
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
