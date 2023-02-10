<?php
require_once("../../../../php/conexion.php");
	$conn=new Conectar();	
	
	$data = json_decode(file_get_contents("php://input"));
	$c10=$data->c10;
	//declaracion de bariables
	$c10_id_fk= $data->fk['0'];
	//print_r($c10_id_fk);
	$c10_codigo= $c10->{'c10_codigo'};
	//print_r($c10_codigo);
	$c10_nombre= $c10->{'c10_nombre'};
	$c10_stado= 'true' ;
	
	try{
      	
  	  $consulta = $conn->prepare('SELECT sgh_cie10_ingresar_pa(?,?,?,?)');
      $consulta->bindParam(1, $c10_id_fk, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $c10_codigo, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $c10_nombre, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $c10_stado, PDO::PARAM_STR, 4000);
      
      $consulta->execute();
      
      $dat=$consulta->fetch (PDO::FETCH_ASSOC);
      $consulta->closeCursor();
     
 		}
 	catch(PDOException $Exception){
		      $dat= $Exception;
		}
		
	$res = json_encode($dat);	

echo $res;

?>