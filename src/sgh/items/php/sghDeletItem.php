<?php

	require_once("../../../../php/conexion.php");
	
	$data = json_decode(file_get_contents("php://input"));
	//print_r($data);
	$item_id_fk=1;
 	$item_estado=false;
	$item_id_pk= $data->id;
	$item_problema="Eliminando";
	$op="2";
	$conn=new Conectar();
	try{
		
    //Importo conexion de archivo debido a que mensaje de respuesta no devuelve con metodo de conexion
      $consulta = $conn->prepare('SELECT sgh_item_edita_pa(?,?,?,?,?)');
      
      $consulta->bindParam(1, $op, PDO::PARAM_STR, 4000); 
      $consulta->bindParam(2, $item_id_pk, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $item_id_fk, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $item_problema, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $item_estado, PDO::PARAM_STR, 4000);
         $echo= $consulta->execute();

	 $dat=$consulta->fetch (PDO::FETCH_ASSOC);
     $consulta->closeCursor();    
 	}
 	catch(PDOException $Exception){
		      $dat= $Exception;
	}
		
	$res = json_encode( $dat );	

echo $res;
?>
