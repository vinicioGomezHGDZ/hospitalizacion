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
    
      $consulta = $conn->prepare('SELECT sgh_problemas_ingreso_pa(?,?,?,?,?,?,?,?,?,?)');

      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $datos->{'pbl_edad'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $datos->{'pbl_fecini'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos->{'pbl_fecdet'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $datos->{'pbl_antece'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos->{'pbl_actpasi'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $datos->{'pbl_sindro'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $null, PDO::PARAM_STR, 4000);
            
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
      $consulta = $conn->prepare('SELECT sgh_problemas_ingreso_pa(?,?,?,?,?,?,?,?,?,?)');

      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $datos->{'pbl_edad'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $datos->{'pbl_fecini'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos->{'pbl_fecdet'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $datos->{'pbl_antece'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos->{'pbl_actpasi'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $datos->{'pbl_sindro'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $datos->{'pbl_id_pk'}, PDO::PARAM_STR, 4000);

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