     <?php

   // incluir conección de base de datos 
  require_once("../../../../php/conexion.php");
	$conn=new Conectar();	
	include_once("../../../../php/class_consulta.php");
  $Con=New Consulta();

	$data = json_decode(file_get_contents("php://input"));
  $null=null; 
  $result="null";
 switch ($data->op)
 {
  case 1:
  # guarda datos de microbiologico
  $datos =$data->mic;
  try{

      $consulta = $conn->prepare('SELECT sgh_microbiologico_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $data->cama, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $datos->{'mic_cultde'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos->{'mic_sosdia'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $datos->{'mic_antcli'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos->{'mic_daepre'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $datos->{'mic_otrlab'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $datos->{'mic_proinv'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $datos->{'mic_infecc'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12, $datos->{'mic_antibi'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(13, $datos->{'mic_intran'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(14, $datos->{'mic_cuales'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(15, $datos->{'mic_comimu'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(16, $datos->{'mic_caul'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(17, $datos->{'mic_urocul'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(18, $datos->{'mic_obcerb'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(19, $result, PDO::PARAM_STR, 4000);
      $consulta->bindParam(20, $null, PDO::PARAM_STR, 4000);

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
case 2:
 $result="RESULTADO_N_".$data->id.".pdf";    
  try{

      $consulta = $conn->prepare('SELECT sgh_microbiologico_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(13, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(14, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(15, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(16, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(17, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(18, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(19, $result, PDO::PARAM_STR, 4000);
      $consulta->bindParam(20, $data->id, PDO::PARAM_STR, 4000);
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