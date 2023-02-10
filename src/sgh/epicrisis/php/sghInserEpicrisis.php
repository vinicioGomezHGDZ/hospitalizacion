     <?php

   // incluir conección de base de datos 
  require_once("../../../../php/conexion.php");
	$conn=new Conectar();	
	include_once("../../../../php/class_consulta.php");
  $Con=New Consulta();

	$data = json_decode(file_get_contents("php://input"));
  
  $null=null; 
  if ($data->op === 2){
  $op1=4;
  }else{$op1=1;}

switch ($data->op) {
  case 1:
      // guarda epicrisis
 $datos =$data->res;
  try{

      $consulta = $conn->prepare('SELECT sgh_epicrisis_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $datos->{'epi_recucl'}, PDO::PARAM_STR, 30000);
      $consulta->bindParam(5, $datos->{'epi_reevco'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos->{'epi_harexa'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $datos->{'epi_rtrprt'}, PDO::PARAM_STR, 30000);
      $consulta->bindParam(8, $datos->{'epi_condic'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $datos->{'epi_altdef'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $datos->{'epi_altran'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $datos->{'epi_asinto'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12, $datos->{'epi_dislev'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(13, $datos->{'epi_dismod'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(14, $datos->{'epi_disgra'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(15, $datos->{'epi_retaut'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(16, $datos->{'epi_retnau'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(17, $datos->{'epi_dme48h'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(18, $datos->{'epi_dma48h'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(19, $datos->{'epi_diaest'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(20, $datos->{'epi_diadin'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(21, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(22, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(23, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(24, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(25, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(26, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(27, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(28, $data->codigo, PDO::PARAM_STR, 4000);
      $consulta->bindParam(29, $datos->{'epi_respon'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(30, $datos->{'epi_rescmsp'}, PDO::PARAM_STR, 4000);

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
  // guarda diagnosticos
  $cie10=$data->c10;
   for ($i=0; $i < sizeof($cie10); $i++) { 
    try{

      $consulta = $conn->prepare('SELECT sgh_epicrisis_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
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
      $consulta->bindParam(24, $cie10[$i]->{'c10_id_pk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(25, $cie10[$i]->{'dia_resp'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(26, $data->tip, PDO::PARAM_STR, 4000);
      $consulta->bindParam(27, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(28, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(29, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(30, $null, PDO::PARAM_STR, 4000);
      $consulta->execute();
    }
      catch(PDOException $Exception){
          $dat= $Exception;
        }
  }      
   break;

  case 3:
    // guarda medico //////////
        $med=$data->med;
        for ($i=0; $i < sizeof($med); $i++) {
    try{

      $consulta = $conn->prepare('SELECT sgh_epicrisis_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
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
      $consulta->bindParam(22, $med[$i]->{'pro_id_pk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(23, $med[$i]->{'med_period'}, PDO::PARAM_STR, 4000);

      $consulta->bindParam(24, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(25, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(26, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(27, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(28, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(29, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(30, $null, PDO::PARAM_STR, 4000);
      $consulta->execute();
        $dat=$consulta->fetch (PDO::FETCH_ASSOC);
        $consulta->closeCursor();
    }
      catch(PDOException $Exception){
          $dat= $Exception;
    }
  }
    break;

  case 4:
   # editar epicrisis
  $datos =$data->res;

  try{

      $consulta = $conn->prepare('SELECT sgh_epicrisis_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $datos->{'epi_recucl'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $datos->{'epi_reevco'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos->{'epi_harexa'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $datos->{'epi_rtrprt'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos->{'epi_condic'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $datos->{'epi_altdef'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $datos->{'epi_altran'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $datos->{'epi_asinto'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12, $datos->{'epi_dislev'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(13, $datos->{'epi_dismod'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(14, $datos->{'epi_disgra'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(15, $datos->{'epi_retaut'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(16, $datos->{'epi_retnau'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(17, $datos->{'epi_dme48h'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(18, $datos->{'epi_dma48h'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(19, $datos->{'epi_diaest'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(20, $datos->{'epi_diadin'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(21, $datos->{'epi_id_pk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(22, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(23, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(24, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(25, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(26, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(27, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(28, $data->codigo, PDO::PARAM_STR, 4000);
      $consulta->bindParam(29, $datos->{'epi_respon'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(30, $datos->{'epi_rescmsp'}, PDO::PARAM_STR, 4000);
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
  case 5:
    # editar cie 10

   $cie10=$data->c10;

   for ($i=0; $i < sizeof($cie10); $i++) { 
    try{

      $consulta = $conn->prepare('SELECT sgh_epicrisis_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
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
      $consulta->bindParam(24, $cie10[$i]->{'c10_id_pk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(25, $cie10[$i]->{'dia_resp'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(26, $data->tip, PDO::PARAM_STR, 4000);
      $consulta->bindParam(27, $cie10[$i]->{'dia_id_pk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(28, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(29, $datos->{'epi_respon'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(30, $datos->{'epi_rescmsp'}, PDO::PARAM_STR, 4000);
      $consulta->execute();
    }
      catch(PDOException $Exception){
          $dat= $Exception;
        }
  }      
  break;
  case 6:
     # agregar c10 en edicion
   try{

      $consulta = $conn->prepare('SELECT sgh_epicrisis_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
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
      $consulta->bindParam(21, $data->int_id_pk, PDO::PARAM_STR, 4000);
      $consulta->bindParam(22, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(23, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(24, $data->c10_id_pk, PDO::PARAM_STR, 4000);
      $consulta->bindParam(25, $data->dia_resp, PDO::PARAM_STR, 4000);
      $consulta->bindParam(26, $data->tip, PDO::PARAM_STR, 4000);
      $consulta->bindParam(27, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(28, $null, PDO::PARAM_STR, 4000);
       $consulta->bindParam(29, $datos->{'epi_respon'}, PDO::PARAM_STR, 4000);
       $consulta->bindParam(30, $datos->{'epi_rescmsp'}, PDO::PARAM_STR, 4000);
      $consulta->execute();
    }
      catch(PDOException $Exception){
          $dat= $Exception;
        }
  break; 
  
  case 7:
     # editar medico
   //print_r($data);
     $med=$data->med; 
    for ($i=0; $i < sizeof($med); $i++) {     
    try{
      $consulta = $conn->prepare('SELECT sgh_epicrisis_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
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
      $consulta->bindParam(22, $med[$i]->{'pro_id_pk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(23, $med[$i]->{'med_period'}, PDO::PARAM_STR, 4000);

      $consulta->bindParam(24, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(25, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(26, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(27, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(28, $med[$i]->{'med_id_pk'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(29, $datos->{'epi_respon'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(30, $datos->{'epi_rescmsp'}, PDO::PARAM_STR, 4000);

      $consulta->execute();
    
    }
      catch(PDOException $Exception){
          $dat= $Exception;
    }
  }    
     break;
  case 8:

  # nuevo medico en  edicion
    try{
      $consulta = $conn->prepare('SELECT sgh_epicrisis_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
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
      $consulta->bindParam(21, $data->int_id_pk, PDO::PARAM_STR, 4000);
      $consulta->bindParam(22, $data->pro_id_pk, PDO::PARAM_STR, 4000);
      $consulta->bindParam(23, $data->med_period, PDO::PARAM_STR, 4000);
      $consulta->bindParam(24, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(25, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(26, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(27, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(28, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(29, $datos->{'epi_respon'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(30, $datos->{'epi_rescmsp'}, PDO::PARAM_STR, 4000);

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
    case 9:
        # editar epicrisis caundo paciente haya sido dado de alta
        $datos =$data->res;

        try{

            $consulta = $conn->prepare('SELECT sgh_epicrisis_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
            $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
            $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
            $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
            $consulta->bindParam(4, $datos->{'epi_recucl'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(5, $datos->{'epi_reevco'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(6, $datos->{'epi_harexa'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(7, $datos->{'epi_rtrprt'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(8, $datos->{'epi_condic'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(9, $datos->{'epi_altdef'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(10, $datos->{'epi_altran'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(11, $datos->{'epi_asinto'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(12, $datos->{'epi_dislev'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(13, $datos->{'epi_dismod'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(14, $datos->{'epi_disgra'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(15, $datos->{'epi_retaut'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(16, $datos->{'epi_retnau'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(17, $datos->{'epi_dme48h'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(18, $datos->{'epi_dma48h'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(19, $datos->{'epi_diaest'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(20, $datos->{'epi_diadin'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(21, $datos->{'epi_id_pk'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(22, $null, PDO::PARAM_STR, 4000);
            $consulta->bindParam(23, $null, PDO::PARAM_STR, 4000);
            $consulta->bindParam(24, $null, PDO::PARAM_STR, 4000);
            $consulta->bindParam(25, $null, PDO::PARAM_STR, 4000);
            $consulta->bindParam(26, $null, PDO::PARAM_STR, 4000);
            $consulta->bindParam(27, $null, PDO::PARAM_STR, 4000);
            $consulta->bindParam(28, $null, PDO::PARAM_STR, 4000);
            $consulta->bindParam(29, $datos->{'epi_respon'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(30, $datos->{'epi_rescmsp'}, PDO::PARAM_STR, 4000);
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


// para guardar verificacion de medico tratante

   case 10:
        # editar epicrisis caundo paciente haya sido dado de alta
      
        try{

            $consulta = $conn->prepare('SELECT sgh_epicrisis_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
            $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
            $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
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
            $consulta->bindParam(21, $data->codigo, PDO::PARAM_STR, 4000);
            $consulta->bindParam(22, $null, PDO::PARAM_STR, 4000);
            $consulta->bindParam(23, $null, PDO::PARAM_STR, 4000);
            $consulta->bindParam(24, $null, PDO::PARAM_STR, 4000);
            $consulta->bindParam(25, $null, PDO::PARAM_STR, 4000);
            $consulta->bindParam(26, $null, PDO::PARAM_STR, 4000);
            $consulta->bindParam(27, $null, PDO::PARAM_STR, 4000);
            $consulta->bindParam(28, $null, PDO::PARAM_STR, 4000);
            $consulta->bindParam(29, $data->respon, PDO::PARAM_STR, 4000);
            $consulta->bindParam(30, $data->msp, PDO::PARAM_STR, 4000);
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