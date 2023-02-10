     <?php
date_default_timezone_set('America/Guayaquil');

   // incluir conección de base de datos 
    require_once("../../../../php/conexion.php");
	$conn=new Conectar();	
	
	$data = json_decode(file_get_contents("php://input"));

	//declaracion de bariables

  $null=null;	
	switch ($data->op) {
    case '1':
        $evo =$data->evo;
       $time = time();
       $date=date("H:i:s", $time);
    try{
  //INGRESA DATO
      $consulta = $conn->prepare('SELECT sgh_mei_evolucion_ingresar_pa(?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->asu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $evo->{'eyp_evolucion'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $evo->{'eyp_prescripciones'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $date, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $data->resp, PDO::PARAM_STR, 4000);
      
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
        $evo =$data->evo;
      try{

    //EDITA DATOS DE EVOLUCION 
       $consulta = $conn->prepare('SELECT sgh_mei_evolucion_ingresar_pa(?,?,?,?,?,?,?,?,?)');
     
      $consulta->bindParam(1, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->asu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $evo->{'eyp_evolucion'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $evo->{'eyp_prescripciones'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $evo->{'eyp_id_pk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $data->resp, PDO::PARAM_STR, 4000);
      
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
        case '3':

            try{
                //EDITA DATOS DE EVOLUCION
                $consulta = $conn->prepare('SELECT sgh_mei_evolucion_ingresar_pa(?,?,?,?,?,?,?,?,?)');

                $consulta->bindParam(1, $null, PDO::PARAM_STR, 4000);
                $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
                $consulta->bindParam(3, $null, PDO::PARAM_STR, 4000);
                $consulta->bindParam(4, $data->respon, PDO::PARAM_STR, 4000);
                $consulta->bindParam(5, $null, PDO::PARAM_STR, 4000);
                $consulta->bindParam(6, $data->op, PDO::PARAM_STR, 4000);
                $consulta->bindParam(7, $data->codig, PDO::PARAM_STR, 4000);
                $consulta->bindParam(8, $null, PDO::PARAM_STR, 4000);
                $consulta->bindParam(9, $data->resp, PDO::PARAM_STR, 4000);

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

        case '4':
            try{
                //EDITA DATOS DE EVOLUCION
                $consulta = $conn->prepare('SELECT sgh_mei_evolucion_ingresar_pa(?,?,?,?,?,?,?,?,?)');

                $consulta->bindParam(1, $null, PDO::PARAM_STR, 4000);
                $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
                $consulta->bindParam(3, $null, PDO::PARAM_STR, 4000);
                $consulta->bindParam(4, $data->respon, PDO::PARAM_STR, 4000);
                $consulta->bindParam(5, $null, PDO::PARAM_STR, 4000);
                $consulta->bindParam(6, $data->op, PDO::PARAM_STR, 4000);
                $consulta->bindParam(7, $data->codig, PDO::PARAM_STR, 4000);
                $consulta->bindParam(8, $null, PDO::PARAM_STR, 4000);
                $consulta->bindParam(9, $data->resp, PDO::PARAM_STR, 4000);

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