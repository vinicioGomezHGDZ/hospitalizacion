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
        $datos =$data->lab;
        ///guarda solicitud de lavoratorio
        try{

            $consulta = $conn->prepare('SELECT sgh_solilaboratorio_ingreso_pa(?,?,?,?,?,?,?,?,?,?)');
            $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
            $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
            $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
            $consulta->bindParam(4, $data->cama, PDO::PARAM_STR, 4000);
            $consulta->bindParam(5, $data->eti, PDO::PARAM_STR, 4000);
            $consulta->bindParam(6, $datos->{'lab_priori'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(7, $datos->{'lab_fecmu'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(8, $result, PDO::PARAM_STR, 4000);
            $consulta->bindParam(9, $null, PDO::PARAM_STR, 4000);
            $consulta->bindParam(10, $null, PDO::PARAM_STR, 4000);
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
  foreach ($data->lab as $clave => $valor) {
      $consulta = $conn->prepare('SELECT sgh_solilaboratorio_ingreso_pa(?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $valor, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $null, PDO::PARAM_STR, 4000);
      $consulta->execute();
  }  
break;
case 3:
 # guardar archivo de resultado de laboratorio 
$file2="RESULTADO_N_".$data->id.".pdf";
  try{
      $consulta = $conn->prepare('SELECT sgh_solilaboratorio_ingreso_pa(?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $data->cama, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $data->eti, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos->{'lab_priori'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $datos->{'lab_fecmu'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $file2, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $data->id, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $null, PDO::PARAM_STR, 4000);
      $consulta->execute();
      $dat=$consulta->fetch (PDO::FETCH_ASSOC);
      $consulta->closeCursor();
     }
   catch(PDOException $Exception) { $dat= $Exception; }       
      $res = json_encode($dat); 
      echo $res;
break;
    default:
    # code...
     break;
}


?>