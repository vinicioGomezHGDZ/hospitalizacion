<?php
require_once("../../../../php/conexion.php");
	
	$data = json_decode(file_get_contents("php://input"));
	
 	$catlb=$data->catlb;

	$cat_estado=true;
	$op="1";

	//print_r($ccl_estado);
	
	$conn=new Conectar();
	
	try{
    //Importo conexion de archivo debido a que mensaje de respuesta no devuelve con metodo de conexion
      $consulta = $conn->prepare('SELECT sgh_categorialabo_edita_pa(?,?,?,?)');
     
      $consulta->bindParam(1, $op, PDO::PARAM_STR, 4000);	 
      $consulta->bindParam(2, $data->id, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $catlb->{'cat_descrip'}, PDO::PARAM_STR, 4000);
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
