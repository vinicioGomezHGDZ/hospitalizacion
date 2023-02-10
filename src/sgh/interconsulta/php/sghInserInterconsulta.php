     <?php

   // incluir conección de base de datos 
  require_once("../../../../php/conexion.php");
   include_once("../../../../php/class_consulta.php");
   $Con=New Consulta();
	$conn=new Conectar();	

	$data = json_decode(file_get_contents("php://input"));
  $null=null; 
  
 switch ($data->op)
 {
  case 1:
  $datos =$data->int;
  $op=3;
    ///guarda interconsulta solicitud


  try{

      $consulta = $conn->prepare('SELECT sgh_interconsulta_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $data->cam, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $datos->{'med_id_fk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos->{'mds_grabed'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $datos->{'mds_sersol'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos->{'int_id_fk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $datos->{'int_cuclia'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $datos->{'int_resexa'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $datos->{'int_planes'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(13, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(14, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(15, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(16, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(17, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(18, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(19, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(20, $datos->{'mds_medico'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(21, $null, PDO::PARAM_STR, 4000);


      $consulta->execute();

     // $dat=$consulta->fetch (PDO::FETCH_ASSOC);
     //// $consulta->closeCursor();
     
    }

  catch(PDOException $Exception){
          $dat= $Exception;
    }       
   // $res = json_encode($dat); 
    //echo $res;

    //////// guardar motivo y destino
    try{

      $consulta = $conn->prepare('SELECT sgh_interconsulta_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $data->cam, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $datos->{'med_id_fk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos->{'mds_grabed'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $datos->{'mds_sersol'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos->{'int_id_fk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $datos->{'int_cuclia'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $datos->{'int_resexa'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $datos->{'int_planes'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(13, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(14, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(15, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(16, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(17, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(18, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(19, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(20, $datos->{'mds_medico'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(21, $null, PDO::PARAM_STR, 4000);


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
  //$datos =$data->int;
  $cie10=$data->c10;
  for ($i=0; $i < sizeof($cie10); $i++) { 
  try{
      
      $consulta = $conn->prepare('SELECT sgh_interconsulta_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->usu, 4000);
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
      $consulta->bindParam(16, $cie10[$i]->{'c10_id_pk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(17, $cie10[$i]->{'dia_resp'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(18, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(19, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(20, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(21, $null, PDO::PARAM_STR, 4000);
      
      $consulta->execute();
      
      //$dat=$consulta->fetch (PDO::FETCH_ASSOC);
      //$consulta->closeCursor();
     
    }
      catch(PDOException $Exception){
          $dat= $Exception;
        }   
    }     
    //$res = json_encode($dat); 
   // echo $res;
  
   break;
case '3':
  echo("Entro al 3");
   $opi=1;
   $opinforme=8;
    $datos =$data->int;
    if ($data->archivo==="si")
    {
        $Regd=$Con->Get_Consulta("sgh_mei_intercsol","int_id_pk","","","",5);
          $num=count($Regd);
        $aer_archi="INTERCONSULTA_".$num.".pdf";
    }
    else
    {
        $aer_archi=null;
    }
    try{

      $consulta = $conn->prepare('SELECT sgh_interconsulta_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $opi, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $data->id, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12, $datos->{'int_cucint'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(13, $datos->{'int_plandia'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(14, $datos->{'int_pltrap'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(15, $datos->{'int_recrcl'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(16, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(17, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(18, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(19, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(20, $datos->{'mds_medico'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(21, $aer_archi, PDO::PARAM_STR, 4000);


        $consulta->execute();
      $dat=$consulta->fetch (PDO::FETCH_ASSOC);
      $consulta->closeCursor();
     
    }
  catch(PDOException $Exception){
          $dat= $Exception;
    }       
    $res = json_encode($dat); 
    echo $res;

   try{
       $consulta = $conn->prepare('SELECT sgh_interconsulta_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
       $consulta->bindParam(1, $opinforme, PDO::PARAM_STR, 4000);
       $consulta->bindParam(2, $data->hcl, PDO::PARAM_STR, 4000);
       $consulta->bindParam(3, $data->usu, PDO::PARAM_STR, 4000);
       $consulta->bindParam(4, $null, PDO::PARAM_STR, 4000);
       $consulta->bindParam(5, $null, PDO::PARAM_STR, 4000);
       $consulta->bindParam(6, $null, PDO::PARAM_STR, 4000);
       $consulta->bindParam(7, $null, PDO::PARAM_STR, 4000);
       $consulta->bindParam(8, $data->id, PDO::PARAM_STR, 4000);
       $consulta->bindParam(9, $null, PDO::PARAM_STR, 4000);
       $consulta->bindParam(10, $null, PDO::PARAM_STR, 4000);
       $consulta->bindParam(11, $null, PDO::PARAM_STR, 4000);
       $consulta->bindParam(12, $datos->{'int_cucint'}, PDO::PARAM_STR, 4000);
       $consulta->bindParam(13, $datos->{'int_plandia'}, PDO::PARAM_STR, 4000);
       $consulta->bindParam(14, $datos->{'int_pltrap'}, PDO::PARAM_STR, 4000);
       $consulta->bindParam(15, $datos->{'int_recrcl'}, PDO::PARAM_STR, 4000);
       $consulta->bindParam(16, $null, PDO::PARAM_STR, 4000);
       $consulta->bindParam(17, $null, PDO::PARAM_STR, 4000);
       $consulta->bindParam(18, $null, PDO::PARAM_STR, 4000);
       $consulta->bindParam(19, $null, PDO::PARAM_STR, 4000);
       $consulta->bindParam(20, $datos->{'mds_medico'}, PDO::PARAM_STR, 4000);
       $consulta->bindParam(21, $null, PDO::PARAM_STR, 4000);

       $consulta->execute();
       $dat=$consulta->fetch (PDO::FETCH_ASSOC);
       $consulta->closeCursor();
    }
       catch(PDOException $Exception){
               $dat= $Exception;
           }
     break;

/// edicion de datos
  case 4:
  $datos =$data->int;
  $op=5;
    ///guarda interconsulta solicitud
  try{

      $consulta = $conn->prepare('SELECT sgh_interconsulta_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $data->cam, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $datos->{'med_id_fk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos->{'mds_grabed'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $datos->{'mds_sersol'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos->{'int_id_pk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $datos->{'int_cuclia'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $datos->{'int_resexa'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $datos->{'int_planes'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(13, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(14, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(15, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(16, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(17, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(18, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(19, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(20, $datos->{'mds_medico'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(21, $null, PDO::PARAM_STR, 4000);


      $consulta->execute();

     // $dat=$consulta->fetch (PDO::FETCH_ASSOC);
     //// $consulta->closeCursor();
     
    }

  catch(PDOException $Exception){
          $dat= $Exception;
    }       
   // $res = json_encode($dat); 
    //echo $res;

    //////// guardar motivo y destino
    try{

      $consulta = $conn->prepare('SELECT sgh_interconsulta_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $data->cam, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $datos->{'med_id_fk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos->{'mds_grabed'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $datos->{'mds_sersol'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos->{'int_id_pk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $datos->{'int_cuclia'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $datos->{'int_resexa'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $datos->{'int_planes'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(13, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(14, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(15, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(16, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(17, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(18, $datos->{'mds_id_pk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(19, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(20, $datos->{'mds_medico'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(21, $null, PDO::PARAM_STR, 4000);

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
   # code...
    $opi=4;
    $datos =$data->int;
    try{
      $consulta = $conn->prepare('SELECT sgh_interconsulta_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $opi, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos->{'int_id_pk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12, $datos->{'int_cucint'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(13, $datos->{'int_plandia'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(14, $datos->{'int_pltrap'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(15, $datos->{'int_recrcl'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(16, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(17, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(18, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(19, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(20, $datos->{'mds_medico'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(21, $null, PDO::PARAM_STR, 4000);


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

 case 6:
     $cie10=$data->c10;
     $datos =$data->int;
  for ($i=0; $i < sizeof($cie10); $i++) { 
  try{
     
      $consulta = $conn->prepare('SELECT sgh_interconsulta_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->usu, 4000);
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
      $consulta->bindParam(16, $cie10[$i]->{'c10_id_pk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(17, $cie10[$i]->{'dia_resp'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(18, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(19, $cie10[$i]->{'dia_id_pk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(20, $datos->{'mds_medico'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(21, $null, PDO::PARAM_STR, 4000);
      $consulta->execute();


      $dat=$consulta->fetch (PDO::FETCH_ASSOC);
      $consulta->closeCursor();
     
    }
      catch(PDOException $Exception){
          $dat= $Exception;
        }   
    }

   //  $res = json_encode($dat); // echo $res;
  
   break;
   case '7':
        # code...
    try{
     
      $consulta = $conn->prepare('SELECT sgh_interconsulta_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->usu, 4000);
      $consulta->bindParam(4, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $data->int_id_pk, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(13, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(14, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(15, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(16, $data->c10_id_pk, PDO::PARAM_STR, 4000);
      $consulta->bindParam(17, $data->dia_resp, PDO::PARAM_STR, 4000);
      $consulta->bindParam(18, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(19, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(20, $datos->{'mds_medico'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(21, $null, PDO::PARAM_STR, 4000);

      $consulta->execute();
      
      $dat=$consulta->fetch (PDO::FETCH_ASSOC);
      $consulta->closeCursor();
     
    }
      catch(PDOException $Exception){
          $dat= $Exception;
        }   
   // $res = json_encode($dat); 
    //echo $res;
   break;   

    default:
    # code...
     break;
}


?>