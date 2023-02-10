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

 /* $Regd=$Con->Get_Consulta("sgh_sol_vih","*","","","",5);
 $numer=count($Regd);
 $respuesta="Archivo".$numer.".pdf";  
 */
  $datos =$data->ima;
  //
  ///guarda anamnesis
  try{


      $consulta = $conn->prepare('SELECT sgh_imagenologia_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $data->cama, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $data->eti, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos->{'ima_priori'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $datos->{'ima_fecmu'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos->{'ima_radior'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $datos->{'ima_tomogr'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $datos->{'ima_resona'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $datos->{'ima_ecogra'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12, $datos->{'ima_proced'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(13, $datos->{'ima_mamoga'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(14, $datos->{'ima_otros'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(15, $datos->{'ima_descri'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(16, $datos->{'ima_puemov'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(17, $datos->{'ima_pureve'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(18, $datos->{'ima_meprex'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(19, $datos->{'ima_toraca'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(20, $datos->{'ima_motsol'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(21, $datos->{'ima_rescli'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(22, $result, PDO::PARAM_STR, 4000);
      $consulta->bindParam(23, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(24, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(25, $null, PDO::PARAM_STR, 4000);

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
     $cie10=$data->c10;
  try{
     
       $consulta = $conn->prepare('SELECT sgh_imagenologia_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $null, 4000);
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
      $consulta->bindParam(21, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(22, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(23, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(24, $data->resp, PDO::PARAM_STR, 4000);
      $consulta->bindParam(25, $cie10[0]->{'c10_id_pk'}, PDO::PARAM_STR, 4000);
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