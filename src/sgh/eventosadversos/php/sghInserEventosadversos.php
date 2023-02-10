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
    
      $consulta = $conn->prepare('SELECT sgh_eventosadversos_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');

      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $data->ser, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $data->eti, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos->{'fed_relacon'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $datos->{'fed_prodale'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos->{'fed_ocasio'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $datos->{'fed_desles'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $datos->{'fed_medado'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $datos->{'fed_tipcla'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12, $datos->{'acp_accion'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(13, $datos->{'acp_ncorre'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(14, $datos->{'acp_npreve'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(15, $datos->{'acp_acp_tipo'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(16, $datos->{'acp_felim'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(17, $datos->{'acp_por'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(18, $datos->{'acp_fefire'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(19, $datos->{'acp_descrip'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(20, $datos->{'acp_hallas'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(21, $datos->{'acp_accorr'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(22, $datos->{'acp_medica'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(23, $datos->{'acp_acfuef'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(24, $datos->{'acp_feacor'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(25, $datos->{'acp_nuacap'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(26, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(27, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(28, $datos->{'fed_fecha'}, PDO::PARAM_STR, 4000);

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
      $consulta = $conn->prepare('SELECT sgh_eventosadversos_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');

      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $data->ser, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $data->eti, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos->{'fed_relacon'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $datos->{'fed_prodale'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos->{'fed_ocasio'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $datos->{'fed_desles'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $datos->{'fed_medado'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $datos->{'fed_tipcla'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12, $datos->{'acp_accion'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(13, $datos->{'acp_ncorre'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(14, $datos->{'acp_npreve'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(15, $datos->{'acp_acp_tipo'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(16, $datos->{'acp_felim'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(17, $datos->{'acp_por'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(18, $datos->{'acp_fefire'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(19, $datos->{'acp_descrip'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(20, $datos->{'acp_hallas'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(21, $datos->{'acp_accorr'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(22, $datos->{'acp_medica'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(23, $datos->{'acp_acfuef'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(24, $datos->{'acp_feacor'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(25, $datos->{'acp_nuacap'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(26, $datos->{'fed_id_pk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(27, $datos->{'acp_id_pk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(28, $null, PDO::PARAM_STR, 4000);

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