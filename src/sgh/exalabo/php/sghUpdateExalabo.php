<?php
	
	require_once("../../../../php/conexion.php");
	
	$data = json_decode(file_get_contents("php://input"));
	
 	$exalb=$data->exalb;//cargo el aray de items a guardar	
	
 	$exa_estado=true;
 	$op="1";
	$conn=new Conectar();
	try{
    //Importo conexion de archivo debido a que mensaje de respuesta no devuelve con metodo de conexion
      $consulta = $conn->prepare('SELECT sgh_examenlabo_edita_pa(?,?,?,?,?,?)');
      
      $consulta->bindParam(1, $op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->id, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->fk, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $exalb->{'exa_descrip'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $exa_estado, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $exalb->{'exa_tipo'}, PDO::PARAM_STR, 4000);
   
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
