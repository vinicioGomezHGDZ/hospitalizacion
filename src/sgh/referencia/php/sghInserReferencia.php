<?php
  // incluir conección de base de datos 
  require_once("../../../../php/conexion.php");
	$conn=new Conectar();	
	include_once("../../../../php/class_consulta.php");
  $Con=New Consulta();

	$data = json_decode(file_get_contents("php://input"));
  $null=null;
switch ($data->op)
{
  case 1:
    $datos =$data->ref;

    // Guarda Referencia  
    try{

        $consulta = $conn->prepare('SELECT sgh_referencia_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
        $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
        $consulta->bindParam(2, $data->ins_or_fk, PDO::PARAM_STR, 4000);
        $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
        $consulta->bindParam(4, $data->ins_de_fk, PDO::PARAM_STR, 4000);
        $consulta->bindParam(5, $data->usu, PDO::PARAM_STR, 4000);
        $consulta->bindParam(6, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(7, $datos->{'ref_motivo'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(8, $datos->{'ref_servi'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(9, $datos->{'ref_espec'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(10, $datos->{'ref_rescuad'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(11, $datos->{'ref_halrel'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(12, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(13, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(14, $datos->{'ref_medico'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(15, $datos->{'ref_codmsp'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(16, $datos->{'ref_tipo'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(17, $datos->{'ref_archivo'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(18, $datos->{'ref_justif'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(19, $datos->{'c10_id_fk'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(20, $datos->{'dia_resp'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(21, $datos->{'dia_id_pk'}, PDO::PARAM_STR, 4000);
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
      /// guarda cie 10 
      $cie10=$data->c10;
      for ($i=0; $i < sizeof($cie10); $i++) { 
        try{
           
            $consulta = $conn->prepare('SELECT sgh_referencia_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
            $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
            $consulta->bindParam(2, $null, PDO::PARAM_STR, 4000);
            $consulta->bindParam(3, $null, 4000);
            $consulta->bindParam(4, $null, PDO::PARAM_STR, 4000);
            $consulta->bindParam(5, $data->usu, PDO::PARAM_STR, 4000);
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
            $consulta->bindParam(19, $cie10[$i]->{'c10_id_pk'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(20, $cie10[$i]->{'dia_resp'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(21, $null, PDO::PARAM_STR, 4000);
            $consulta->bindParam(22, $null, PDO::PARAM_STR, 4000);
            $consulta->execute();
            
            $dat=$consulta->fetch (PDO::FETCH_ASSOC);
            $consulta->closeCursor();
          }
            catch(PDOException $Exception){
                $dat= $Exception;
              }
      }            
      $res = json_encode($dat); 
      echo $res;
  break;
  case 3:
    // Editar Referencia
      $datos =$data->ref;
    try{

        $consulta = $conn->prepare('SELECT sgh_referencia_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
        $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
        $consulta->bindParam(2, $data->ins_or_fk, PDO::PARAM_STR, 4000);
        $consulta->bindParam(3, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(4, $data->ins_de_fk, PDO::PARAM_STR, 4000);
        $consulta->bindParam(5, $data->usu, PDO::PARAM_STR, 4000);
        $consulta->bindParam(6, $datos->{'ref_id_pk'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(7, $datos->{'ref_motivo'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(8, $datos->{'ref_servi'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(9, $datos->{'ref_espec'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(10, $datos->{'ref_rescuad'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(11, $datos->{'ref_halrel'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(12, $datos->{'ref_trarea'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(13, $datos->{'ref_trarec'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(14, $datos->{'ref_medico'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(15, $datos->{'ref_codmsp'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(16, $datos->{'ref_tipo'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(17, $datos->{'ref_archivo'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(18, $datos->{'ref_justif'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(19, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(20, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(21, $null, PDO::PARAM_STR, 4000);
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
  case 4:
    // Editar diagnostico
    $cie10=$data->c10;
    for ($i=0; $i < sizeof($cie10); $i++) { 
        try{
            $consulta = $conn->prepare('SELECT sgh_referencia_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
            $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
            $consulta->bindParam(2, $null, PDO::PARAM_STR, 4000);
            $consulta->bindParam(3, $null, 4000);
            $consulta->bindParam(4, $null, PDO::PARAM_STR, 4000);
            $consulta->bindParam(5, $data->usu, PDO::PARAM_STR, 4000);
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
            $consulta->bindParam(19, $cie10[$i]->{'c10_id_pk'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(20, $cie10[$i]->{'dia_resp'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(21, $cie10[$i]->{'dia_id_pk'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(22, $null, PDO::PARAM_STR, 4000);
            $consulta->execute();
            
            $dat=$consulta->fetch (PDO::FETCH_ASSOC);
            $consulta->closeCursor();
          }
            catch(PDOException $Exception){ $dat= $Exception; }
      }        
      $res = json_encode($dat); 
      echo $res;
  break;
  case 5:
    # Nuevo Diagnostico cie 10 
    print_r($data);
        try{
            $consulta = $conn->prepare('SELECT sgh_referencia_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
            $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
            $consulta->bindParam(2, $null, PDO::PARAM_STR, 4000);
            $consulta->bindParam(3, $null, 4000);
            $consulta->bindParam(4, $null, PDO::PARAM_STR, 4000);
            $consulta->bindParam(5, $data->usu, PDO::PARAM_STR, 4000);
            $consulta->bindParam(6, $data->ref_id_pk, PDO::PARAM_STR, 4000);
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
            $consulta->bindParam(19, $data->c10_id_pk, PDO::PARAM_STR, 4000);
            $consulta->bindParam(20, $data->dia_resp, PDO::PARAM_STR, 4000);
            $consulta->bindParam(21, $null, PDO::PARAM_STR, 4000);
            $consulta->bindParam(22, $null, PDO::PARAM_STR, 4000);
            $consulta->execute();
            
            $dat=$consulta->fetch (PDO::FETCH_ASSOC);
            $consulta->closeCursor();
          }
            catch(PDOException $Exception){ $dat= $Exception; }
                
      $res = json_encode($dat); 
      echo $res;
  break;
  case 6:
   # guarda contra referenci 
    $datos =$data->ref;
    // print_r($data);
    try{
      $opc=1;
        $consulta = $conn->prepare('SELECT sgh_referencia_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
        $consulta->bindParam(1, $opc, PDO::PARAM_STR, 4000);
        $consulta->bindParam(2, $data->ins_or_fk, PDO::PARAM_STR, 4000);
        $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
        $consulta->bindParam(4, $data->ins_de_fk, PDO::PARAM_STR, 4000);
        $consulta->bindParam(5, $data->usu, PDO::PARAM_STR, 4000);
        $consulta->bindParam(6, $datos->{'ref_id_pk'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(7, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(8, $datos->{'ref_servi'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(9, $datos->{'ref_espec'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(10, $datos->{'ref_rescuad'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(11, $datos->{'ref_halrel'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(12, $datos->{'ref_trarea'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(13, $datos->{'ref_trarec'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(14, $datos->{'ref_medico'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(15, $datos->{'ref_codmsp'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(16, $datos->{'ref_tipo'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(17, $datos->{'ref_archivo'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(18, $datos->{'ref_justif'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(19, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(20, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(21, $null, PDO::PARAM_STR, 4000);
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
  default:
    # code...
  break;
}


?>