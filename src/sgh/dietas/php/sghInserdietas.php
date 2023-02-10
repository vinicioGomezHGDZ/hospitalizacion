     <?php
date_default_timezone_set('America/Guayaquil');

   // incluir conección de base de datos 
    require_once("../../../../php/conexion.php");
	$conn=new Conectar();	
	
	$data = json_decode(file_get_contents("php://input"));

	//declaracion de bariables
     $datos =$data->die;

  $null=null;
  	
	switch ($data->op) {
    case '1':
    //print_r($data);
    try{
    //INGRESA DATO

        for ($i=0; $i < sizeof($datos); $i++) {
      $consulta = $conn->prepare('SELECT sgh_dieta_detalle_ingreso_pa(?,?,?,?,?,?,?,?)');

      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $data->cam, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $datos[$i]->{'die_id_fk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos[$i]->{'did_obce'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos[$i]->{'did_res'}, PDO::PARAM_STR, 4000);

      $consulta->execute();
      }
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
          for ($i=0; $i < sizeof($datos); $i++) {
      $consulta = $conn->prepare('SELECT sgh_dieta_detalle_ingreso_pa(?,?,?,?,?,?,?,?)');

      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->hhcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $data->cam, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $datos[$i]->{'die_id_fk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos[$i]->{'did_obce'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $datos[$i]->{'did_id_pk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos[$i]->{'did_res'}, PDO::PARAM_STR, 4000);

      $consulta->execute();
          }
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