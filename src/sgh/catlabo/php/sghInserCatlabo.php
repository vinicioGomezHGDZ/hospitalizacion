<?php

   // incluir conección de base de datos 
    require_once("../../../../php/conexion.php");
	$conn=new Conectar();	
	
	$data = json_decode(file_get_contents("php://input"));

	//declaracion de bariables
	$cat_estado= 'true' ;
	try{
    //Importo conexion de archivo debido a que mensaje de respuesta no devuelve con metodo de conexion

 	 $consulta = $conn->prepare('SELECT sgh_categorialabo_ingrso_pa(?,?)');
     
      $consulta->bindParam(1, $data->{'cat_descrip'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $cat_estado, PDO::PARAM_STR, 4000);
      
       
      $consulta->execute();
      
      $dat=$consulta->fetch (PDO::FETCH_ASSOC);
      $consulta->closeCursor();
     
 		}
 	catch(PDOException $Exception){
		      $dat= $Exception;
		}
		
	$res = json_encode( $dat );	

echo $res;

			
?>