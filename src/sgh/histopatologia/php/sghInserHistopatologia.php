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
  $datos =$data->mic;
  ///guarda histopatologico

  try{


      $consulta = $conn->prepare('SELECT sgh_histopatologia_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $data->cama, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $data->eti, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos->{'his_priori'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos->{'his_histop'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $datos->{'his_citolo'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $datos->{'his_descri'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $datos->{'his_rescli'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12, $datos->{'his_muestr'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(13, $datos->{'his_trqrec'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(14, $datos->{'his_endoce'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(15, $datos->{'his_exocer'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(16, $datos->{'his_parvag'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(17, $datos->{'his_unesco'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(18, $datos->{'his_muncer'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(19, $datos->{'his_otrmat'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(20, $datos->{'his_orainy'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(21, $datos->{'his_diu'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(22, $datos->{'his_ligadu'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(23, $datos->{'his_otrant'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(24, $datos->{'his_terhor'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(25, $datos->{'his_menarq'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(26, $datos->{'his_menopa'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(27, $datos->{'his_inrese'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(28, $datos->{'his_gestac'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(29, $datos->{'his_partos'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(30, $datos->{'his_aborto'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(31, $datos->{'his_cesare'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(32, $datos->{'his_ultmes'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(33, $datos->{'his_ultpar'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(34, $datos->{'his_ultcit'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(35, $result, PDO::PARAM_STR, 4000);
      $consulta->bindParam(36, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(37, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(38, $null, PDO::PARAM_STR, 4000);

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
    for ($i=0; $i < sizeof($cie10); $i++) {
        try{
     
     $consulta = $conn->prepare('SELECT sgh_histopatologia_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
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
      $consulta->bindParam(24, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(25, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(26, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(27, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(28, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(29, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(30, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(31, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(32, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(33, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(34, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(35, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(36, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(37, $cie10[$i]->{'dia_resp'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(38, $cie10[$i]->{'c10_id_pk'}, PDO::PARAM_STR, 4000);
      $consulta->execute();
      
      $dat=$consulta->fetch (PDO::FETCH_ASSOC);
      $consulta->closeCursor();
     
    }
      catch(PDOException $Exception){$dat= $Exception;}
    }
    $res = json_encode($dat); 
    echo $res;

   break;

case 3:
    # code...
  $result="RESULTADO_N_".$data->id.".pdf";
  try{
      $consulta = $conn->prepare('SELECT sgh_histopatologia_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
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
      $consulta->bindParam(21, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(22, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(23, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(24, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(25, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(26, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(27, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(28, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(29, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(30, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(31, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(32, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(33, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(34, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(35, $result, PDO::PARAM_STR, 4000);
      $consulta->bindParam(36, $data->id, PDO::PARAM_STR, 4000);
      $consulta->bindParam(37, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(38, $null, PDO::PARAM_STR, 4000);

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