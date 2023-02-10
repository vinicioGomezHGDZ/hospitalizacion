<?php

// incluir conección de base de datos 
    require_once("../../../../php/conexion.php");
	$conn=new Conectar();	
	
	$data = json_decode(file_get_contents("php://input"));

	//declaracion de bariables
	$cita=$data->cita;
	try{
    //Importo conexion de archivo debido a que mensaje de respuesta no devuelve con metodo de conexion

 	 $consulta = $conn->prepare('SELECT sgh_citamedica_pa(?,?,?,?,?,?,?)');
     
      $consulta->bindParam(1, $cita->{'esp_id_fk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $cita->{'cit_fechaproxima'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $cita->{'cit_observacion'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $cita->{'cte_id_fk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $cita->{'cti_id_fk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $data->usu, PDO::PARAM_STR, 4000);

    $consulta->execute();
      
      $dat=$consulta->fetch (PDO::FETCH_ASSOC);
      $consulta->closeCursor();
     
 		}
 	catch(PDOException $Exception){
		      $dat= $Exception;
		}
		
	$res = json_encode( $dat );	

echo $res
?>