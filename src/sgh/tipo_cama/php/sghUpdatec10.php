<?php

	require_once("../../../../php/conexion.php");
	
	$data = json_decode(file_get_contents("php://input"));
	
	//print_r($data);
	
	$c10=$data->c10;
 	$c10_estado=true;
	$op="1";
	
	$conn=new Conectar();
	try{
    //Importo conexion de archivo debido a que mensaje de respuesta no devuelve con metodo de conexion
      $consulta = $conn->prepare('SELECT sgh_cie10_editar_pa(?,?,?,?,?,?)');
      
      $consulta->bindParam(1, $op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->id, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->fk, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $c10->{'c10_codigo'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $c10->{'c10_nombre'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $c10_estado, PDO::PARAM_STR, 4000);
      $consulta->execute();
     
      $dat=$consulta->fetch (PDO::FETCH_ASSOC);
      $consulta->closeCursor();
     
 		}

 	catch(PDOException $Exception)
 	{
		      $mensaje= $Exception;
	}
		
	$res = json_encode( $dat );	

echo $res;

?>