     <?php
date_default_timezone_set('America/Guayaquil');

   // incluir conección de base de datos 
    require_once("../../../../php/conexion.php");
	$conn=new Conectar();	
	
	$data = json_decode(file_get_contents("php://input"));

	//declaracion de bariables
  $datos =$data->tra;
  $null=null;
  	
	switch ($data->op) {
    case '1':
    try{
    //INGRESA DATO
    
      $consulta = $conn->prepare('SELECT sgh_traslado_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?)');

      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $data->eti, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $datos->{'tpa_diagno'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos->{'tpa_situas'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $datos->{'tpa_antece'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos->{'tpa_evalua'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $datos->{'tpa_recome'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $datos->{'tpa_punori'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $datos->{'tpa_puntra'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12, $datos->{'tpa_id_pk'}, PDO::PARAM_STR, 4000);
            
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
     $consulta = $conn->prepare('SELECT sgh_traslado_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?)');

      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $datos->{'tpa_diagno'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos->{'tpa_situas'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $datos->{'tpa_antece'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos->{'tpa_evalua'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $datos->{'tpa_recome'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $datos->{'tpa_punori'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $datos->{'tpa_puntra'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12, $datos->{'tpa_id_pk'}, PDO::PARAM_STR, 4000);

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