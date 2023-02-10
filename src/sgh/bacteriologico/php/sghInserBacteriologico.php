     <?php

   // incluir conección de base de datos 
  require_once("../../../../php/conexion.php");
	$conn=new Conectar();	
	include_once("../../../../php/class_consulta.php");
  $Con=New Consulta();

	$data = json_decode(file_get_contents("php://input"));
  $null=null;
  $resullt="null";
  $ide=1;
 switch ($data->op)
 {
  case 1:
    $datos =$data->bac;
    try{

        $consulta = $conn->prepare('SELECT sgh_bacteriologico_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
        $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
        $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
        $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
        $consulta->bindParam(4, $data->eti, PDO::PARAM_STR, 4000);
        $consulta->bindParam(5, $datos->{'bac_bk'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(6, $datos->{'bac_cultivo'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(7, $datos->{'bac_ada'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(8, $datos->{'bac_psd'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(9, $datos->{'bac_diag'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(10, $datos->{'bac_control'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(11, $datos->{'bac_mes'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(12, $datos->{'bac_esqtra'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(13, $datos->{'bac_esputo'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(14, $datos->{'bac_otrom'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(15, $datos->{'bac_abando'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(16, $datos->{'bac_recupe'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(17, $datos->{'bac_fracas'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(18, $datos->{'bac_recaid'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(19, $datos->{'bac_sr_bk'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(20, $datos->{'bac_tb_dr'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(21, $datos->{'bac_pvv'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(22, $datos->{'bac_diabetes'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(23, $datos->{'bac_otroe'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(24, $datos->{'bac_emdesa'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(25, $datos->{'bac_ppl'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(26, $datos->{'bac_tbdr'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(27, $resullt, PDO::PARAM_STR, 4000);
        $consulta->bindParam(28, $null, PDO::PARAM_STR, 4000);



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
$resullt="RESULTADO_N_".$data->id.".pdf";
  try{

        $consulta = $conn->prepare('SELECT sgh_bacteriologico_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
        $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
        $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
        $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
        $consulta->bindParam(4, $data->eti, PDO::PARAM_STR, 4000);
        $consulta->bindParam(5, $datos->{'bac_bk'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(6, $datos->{'bac_cultivo'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(7, $datos->{'bac_ada'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(8, $datos->{'bac_psd'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(9, $datos->{'bac_diag'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(10, $datos->{'bac_control'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(11, $datos->{'bac_mes'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(12, $datos->{'bac_esqtra'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(13, $datos->{'bac_esputo'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(14, $datos->{'bac_otrom'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(15, $datos->{'bac_abando'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(16, $datos->{'bac_recupe'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(17, $datos->{'bac_fracas'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(18, $datos->{'bac_recaid'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(19, $datos->{'bac_sr_bk'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(20, $datos->{'bac_tb_dr'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(21, $datos->{'bac_pvv'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(22, $datos->{'bac_diabetes'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(23, $datos->{'bac_otroe'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(24, $datos->{'bac_emdesa'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(25, $datos->{'bac_ppl'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(26, $datos->{'bac_tbdr'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(27, $resullt, PDO::PARAM_STR, 4000);
        $consulta->bindParam(28, $data->id, PDO::PARAM_STR, 4000);



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