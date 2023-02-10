<?php

	 require_once("../../../../php/conexion.php");
	$conn=new Conectar();
			
	$data = json_decode(file_get_contents("php://input"));
	

  	$anio=date("Y");  // devuelve "cde";
	$mes=date("m");  // devuelve "cde";
	$dia=date("j");  // devuelve "cde";
	
	try{
	 //Importo conexion de archivo debido a que mensaje de respuesta no devuelve con metodo de conexion
      $consulta = $conn->prepare('SELECT sgh_horario_ingreso_pa(?,?,?,?)');
      
      $consulta->bindParam(1, $data->id, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $anio, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $mes, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $dia, PDO::PARAM_STR, 4000);
     
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
