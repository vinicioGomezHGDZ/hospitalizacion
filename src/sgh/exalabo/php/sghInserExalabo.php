<?php

// incluir conección de base de datos 
    require_once("../../../../php/conexion.php");
	$conn=new Conectar();	
	
	$data = json_decode(file_get_contents("php://input"));

	//declaracion de bariables
	//print_r($data);
	$exalb=$data->exalb;

	$cat_id_fk=$data->fk;
	$exa_estado= 'true' ;


	
	try{
    //Importo conexion de archivo debido a que mensaje de respuesta no devuelve con metodo de conexion

 	 $consulta = $conn->prepare('SELECT sgh_examenlabo_ingresar_pa(?,?,?,?)');
     
      $consulta->bindParam(1, $cat_id_fk, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $exalb->{'exa_descrip'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $exa_estado, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $exalb->{'exa_tipo'}, PDO::PARAM_STR, 4000);
 
    $consulta->execute();
      
      $dat=$consulta->fetch (PDO::FETCH_ASSOC);
      $consulta->closeCursor();
     
 		}
 	catch(PDOException $Exception){
		      $mensaje= $Exception;
		}
		
	$res = json_encode( $dat );	

echo $res
?>