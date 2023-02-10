     <?php
date_default_timezone_set('America/Guayaquil');

   // incluir conección de base de datos 
    require_once("../../../../php/conexion.php");
	$conn=new Conectar();	
	
	$data = json_decode(file_get_contents("php://input"));

	//declaracion de bariables
  $datos =$data->scd;
  $null=null;
  	
	switch ($data->op) {
    case '1':
    //print_r($data);
    try{
    //INGRESA DATO
    
      $consulta = $conn->prepare('SELECT sgh_dawnes_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?)');

      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $datos->{'scd_sibila'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $datos->{'scd_tiraje'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos->{'scd_frespi'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $datos->{'scd_frecar'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos->{'scd_ventil'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $datos->{'scd_cianos'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $datos->{'scd_total'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $null, PDO::PARAM_STR, 4000);
            
      $consulta->execute();
      
      $dat=$consulta->fetch (PDO::FETCH_ASSOC);
      $consulta->closeCursor();
     
    }
    catch(PDOException $Exception){
          $dat= $Exception;
    }
    
     $res = json_encode($dat); 

      echo $res;
  
      break;

    case '2':
      try{
    //EDITA DATOS DE EVOLUCION 
       $consulta = $conn->prepare('SELECT sgh_dawnes_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?)');

      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $datos->{'scd_sibila'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $datos->{'scd_tiraje'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos->{'scd_frespi'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $datos->{'scd_frecar'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos->{'scd_ventil'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $datos->{'scd_cianos'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $datos->{'scd_total'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $datos->{'scd_id_pk'}, PDO::PARAM_STR, 4000);

      $consulta->execute();
      
      $dat=$consulta->fetch (PDO::FETCH_ASSOC);
      $consulta->closeCursor();
     
    }
     catch(PDOException $Exception){
          $dat= $Exception;
    }
     $res = json_encode($dat); 
      echo $res;

    break;
    default:
      # code...
      break;
  }
	
?>