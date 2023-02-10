<?php

	require_once("../../../../php/conexion.php");
	$conn=new Conectar();
		
	$data = json_decode(file_get_contents("php://input"));
	
	//print_r($data);
	
	$punto=$data->getpun;
 	$pun_estado=true;
	
	$op="1";
	try{
	 //Importo conexion de archivo debido a que mensaje de respuesta no devuelve con metodo de conexion
      $consulta = $conn->prepare('SELECT sgh_punt_edita_pa(?,?,?,?,?)');
      
      $consulta->bindParam(1, $op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->id, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $punto->{'pun_descrip'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $punto->{'pun_form'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $pun_estado, PDO::PARAM_STR, 4000);
      
     $consulta->execute();
	
	 $dat=$consulta->fetch (PDO::FETCH_ASSOC);
     $consulta->closeCursor();
     
 		}
 	catch(PDOException $Exception){
		      $mensaje= $Exception;
		}
		
	$res = json_encode( $dat );	

echo $res;
	
?>
