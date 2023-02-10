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
    //print_r($data);
    try{
    //INGRESA DATO
    
      $consulta = $conn->prepare('SELECT sgh_downton_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');

      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $data->cam, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $datos->{'dsd_matano'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos->{'dsd_no'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $datos->{'dsd_si'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos->{'dsd_ninguna'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $datos->{'dsd_tranqu'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $datos->{'dsd_diuret'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $datos->{'dsd_hipote'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12, $datos->{'dsd_antpar'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(13, $datos->{'dsd_antide'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(14, $datos->{'dsd_otrmed'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(15, $datos->{'dsd_ningun'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(16, $datos->{'dsd_altvis'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(17, $datos->{'dsd_altaud'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(18, $datos->{'dsd_extrem'}, PDO::PARAM_STR, 4000); 
      $consulta->bindParam(19, $datos->{'dsd_orient'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(20, $datos->{'dsd_confus'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(21, $datos->{'dsd_normal'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(22, $datos->{'dsd_segayu'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(23, $datos->{'dsd_insayu'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(24, $datos->{'dsd_nodeam'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(25, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(26, $datos->{'dsd_fecha'}, PDO::PARAM_STR, 4000);

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
        $consulta = $conn->prepare('SELECT sgh_downton_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');

      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $data->cam, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $datos->{'dsd_matano'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos->{'dsd_no'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $datos->{'dsd_si'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos->{'dsd_ninguna'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $datos->{'dsd_tranqu'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $datos->{'dsd_diuret'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $datos->{'dsd_hipote'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12, $datos->{'dsd_antpar'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(13, $datos->{'dsd_antide'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(14, $datos->{'dsd_otrmed'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(15, $datos->{'dsd_ningun'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(16, $datos->{'dsd_altvis'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(17, $datos->{'dsd_altaud'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(18, $datos->{'dsd_extrem'}, PDO::PARAM_STR, 4000); 
      $consulta->bindParam(19, $datos->{'dsd_orient'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(20, $datos->{'dsd_confus'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(21, $datos->{'dsd_normal'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(22, $datos->{'dsd_segayu'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(23, $datos->{'dsd_insayu'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(24, $datos->{'dsd_nodeam'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(25, $datos->{'dow_id_pk'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(26, $datos->{'dsd_fecha'}, PDO::PARAM_STR, 4000);


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