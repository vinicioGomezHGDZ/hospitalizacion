<?php
require_once("../../../../php/conexion.php");
	
	$data = json_decode(file_get_contents("php://input"));
	
  	$cat_id_pk=$data->id;
	$cat_descrip= "eliminar";
	$cat_estado=false;
	$op="2";

	//print_r($ccl_estado);
	
	$conn=new Conectar();
	
	try{
    //Importo conexion de archivo debido a que mensaje de respuesta no devuelve con metodo de conexion
      $consulta = $conn->prepare('SELECT sgh_categorialabo_edita_pa(?,?,?,?)');
     
      $consulta->bindParam(1, $op, PDO::PARAM_STR, 4000);	 
      $consulta->bindParam(2, $cat_id_pk, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $cat_descrip, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $cat_estado, PDO::PARAM_STR, 4000);

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