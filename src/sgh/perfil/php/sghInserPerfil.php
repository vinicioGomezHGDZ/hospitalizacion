     <?php
date_default_timezone_set('America/Guayaquil');

   // incluir conección de base de datos 
    require_once("../../../../php/conexion.php");
	$conn=new Conectar();	
	
	$data = json_decode(file_get_contents("php://input"));
  //print_r($data);
	//declaracion de bariables
  $datos =$data->tra;
  $null=null;
  	
	switch ($data->op) {
    
    case '1':
   
    try{
    //INGRESA DATO
      $consulta = $conn->prepare('SELECT sgh_wells_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $datos->{'wel_neopla'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $datos->{'wel_parali'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos->{'wel_estanc'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $datos->{'wel_molest'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos->{'wel_edepie'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $datos->{'wel_aument'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $datos->{'wel_edema'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $datos->{'wel_venaco'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12, $datos->{'wel_otro'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(13, $null, PDO::PARAM_STR, 4000);
            
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
        $consulta = $conn->prepare('SELECT sgh_wells_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $datos->{'wel_neopla'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $datos->{'wel_parali'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos->{'wel_estanc'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $datos->{'wel_molest'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos->{'wel_edepie'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $datos->{'wel_aument'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $datos->{'wel_edema'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $datos->{'wel_venaco'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12, $datos->{'wel_otro'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(13, $datos->{'wel_id_pk'}, PDO::PARAM_STR, 4000);

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