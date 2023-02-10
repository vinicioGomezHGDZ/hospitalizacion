     <?php
date_default_timezone_set('America/Guayaquil');

   // incluir conección de base de datos 
    require_once("../../../../php/conexion.php");
	$conn=new Conectar();	
	
	$data = json_decode(file_get_contents("php://input"));
 // print_r($data);
	//declaracion de bariables
  $datos =$data->pdc;
  $null=null;
  	
	switch ($data->op) {
    
    case '1':
   
    try{
    //INGRESA DATO
      $consulta = $conn->prepare('SELECT sgh_prevencioncaidas_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $data->cam, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $datos->{'rcp_matano'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos->{'rcp_renaci'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $datos->{'rcp_lacmen'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos->{'rcp_lacmay'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $datos->{'rcp_escola'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $datos->{'rcp_si'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $datos->{'rcp_no'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12, $datos->{'rcp_hipera'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(13, $datos->{'rcp_proneu'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(14, $datos->{'rcp_sincon'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(15, $datos->{'rcp_daorce'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(16, $datos->{'rcp_otros'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(17, $datos->{'rcp_sinant'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(18, $datos->{'rcp_sicoco'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(19, $datos->{'rcp_nococo'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(20, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(21, $datos->{'rcp_preescola'}, PDO::PARAM_STR, 4000);

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
        $consulta = $conn->prepare('SELECT sgh_prevencioncaidas_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $data->cam, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $datos->{'rcp_matano'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos->{'rcp_renaci'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $datos->{'rcp_lacmen'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos->{'rcp_lacmay'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $datos->{'rcp_escola'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $datos->{'rcp_si'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $datos->{'rcp_no'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12, $datos->{'rcp_hipera'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(13, $datos->{'rcp_proneu'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(14, $datos->{'rcp_sincon'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(15, $datos->{'rcp_daorce'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(16, $datos->{'rcp_otros'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(17, $datos->{'rcp_sinant'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(18, $datos->{'rcp_sicoco'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(19, $datos->{'rcp_nococo'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(20, $datos->{'rcp_id_pk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(21, $datos->{'rcp_preescola'}, PDO::PARAM_STR, 4000);

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