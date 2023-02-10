<?php

   // incluir conección de base de datos 
    require_once("../../../../php/conexion.php");
	$conn=new Conectar();	
	
	$data = json_decode(file_get_contents("php://input"));

	//declaracion de bariables
	$pun_descrip= $data->{'pun_descrip'};
	$pun_form= $data->{'pun_form'};
	$pun_stado= 'true' ;


	
	try{
    //Importo conexion de archivo debido a que mensaje de respuesta no devuelve con metodo de conexion

 	 $consulta = $conn->prepare('SELECT sgh_punto_ingreso_pa(?,?,?)');
     
      $consulta->bindParam(1, $pun_descrip, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $pun_form, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $pun_stado, PDO::PARAM_STR, 4000);
      
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