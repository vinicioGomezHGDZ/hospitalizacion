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
  // guarda servico vaginal
    $datos =$data->cev;
    try{

      $consulta = $conn->prepare('SELECT sgh_cervicovaginal_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $data->eti, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $datos->{'ccv_feulme'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos->{'ccv_embara'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $datos->{'ccv_lactan'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos->{'ccv_planif'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $datos->{'ccv_numpar'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $datos->{'ccv_numabo'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $datos->{'ccv_inisex'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12, $datos->{'ccv_cacute'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(13, $datos->{'ccv_coniza'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(14, $datos->{'ccv_hister'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(15, $datos->{'ccv_radiot'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(16, $datos->{'ccv_citolo'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(17, $datos->{'ccv_cuatas'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(18, $datos->{'ccv_hacuti'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(19, $datos->{'ccv_anio'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(20, $datos->{'ccv_meses'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(21, $result, PDO::PARAM_STR, 4000);
      $consulta->bindParam(22, $null, PDO::PARAM_STR, 4000);


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
 # guarda resultados 
$result="RESULTADO_N_".$data->id.".pdf";
    try{

      $consulta = $conn->prepare('SELECT sgh_cervicovaginal_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
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
      $consulta->bindParam(19, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(20, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(21, $result, PDO::PARAM_STR, 4000);
      $consulta->bindParam(22, $data->id, PDO::PARAM_STR, 4000);


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