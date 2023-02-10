<?php

  // incluir conección de base de datos 
    require_once("../../../../php/conexion.php");
	$conn=new Conectar();	
	
	$data = json_decode(file_get_contents("php://input"));

	//declaracion de bariables
	$proble=$data->proble;

	$pun_id_fk=$data->fk;
	$prb_Item= $proble->{'prb_proble'};
	$peb_stado= 'true' ;
	
	try{
    //Importo conexion de archivo debido a que mensaje de respuesta no devuelve con metodo de conexion

 	 $consulta = $conn->prepare('SELECT sgh_item_ingresar_pa(?,?,?)');
     
      $consulta->bindParam(1, $pun_id_fk, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $prb_Item, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $peb_stado, PDO::PARAM_STR, 4000);
      
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