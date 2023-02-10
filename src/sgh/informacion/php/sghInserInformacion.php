     <?php

   // incluir conección de base de datos 
    require_once("../../../../php/conexion.php");
	$conn=new Conectar();	
	
	$data = json_decode(file_get_contents("php://input"));
   $inf =$data->inf;
switch ($data->op) {
  case '1':
    # code...
  try{
    //Importo conexion de archivo debido a que mensaje de respuesta no devuelve con metodo de conexion

   $consulta = $conn->prepare('SELECT sgh_informacion_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $inf->{'inp_cuides'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $inf->{'inp_aseo'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $inf->{'inp_reposo'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $inf->{'inp_alimen'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $inf->{'inp_ldhace'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $inf->{'inp_indica'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $inf->{'inp_fpcita'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $inf->{'inp_llamar'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12, $inf->{'inp_id_pk'}, PDO::PARAM_STR, 4000);
      
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
    # code...
   try{
    //Importo conexion de archivo debido a que mensaje de respuesta no devuelve con metodo de conexion
    $consulta = $conn->prepare('SELECT sgh_informacion_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $inf->{'inp_cuides'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $inf->{'inp_aseo'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $inf->{'inp_reposo'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $inf->{'inp_alimen'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $inf->{'inp_ldhace'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $inf->{'inp_indica'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $inf->{'inp_fpcita'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $inf->{'inp_llamar'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12, $inf->{'inp_id_pk'}, PDO::PARAM_STR, 4000);
      
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