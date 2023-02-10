     <?php
date_default_timezone_set('America/Guayaquil');

   // incluir conección de base de datos 
    require_once("../../../../php/conexion.php");
	$conn=new Conectar();	
	
	$data = json_decode(file_get_contents("php://input"));
  $null=null;
switch ($data->op) {
// GUARDA FORMULARIOP DE RECONCILIACIÓN DE MEDICAMENETO
case '1':
    $datos =$data->rec;
    try{
      //INGRESA DATO
      $consulta = $conn->prepare('SELECT sgh_reconciliacion_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');

      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $data->ser, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $datos->{'frm_motate'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos->{'frm_emblac'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $datos->{'frm_peso'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos->{'frm_fueinf'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $datos->{'frm_cual'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $datos->{'frm_intqui'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $datos->{'frm_suspel'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12, $datos->{'frm_enfcro'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(13, $datos->{'frm_dondia'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(14, $datos->{'frm_habito'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(15, $datos->{'frm_faencr'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(16, $datos->{'frm_viaje'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(17, $datos->{'frm_fitote'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(18, $datos->{'frm_obmeul'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(19, $datos->{'frm_obmeho'}, PDO::PARAM_STR, 4000);
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
      $consulta->bindParam(34, $datos->{'frm_quifar'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(35, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(36, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(37, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(38, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(39, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(40, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(41, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(42, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(43, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(44, $datos->{'frm_fecha'}, PDO::PARAM_STR, 4000);

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
// GUARDA medicamentos esta recibiendo
case '2':
     $datos =$data->mer;
     // print_r($datos);
     for ($i=0; $i < sizeof($datos); $i++) { 
          try{
              $consulta = $conn->prepare('SELECT sgh_reconciliacion_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');

              $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
              $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
              $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
              $consulta->bindParam(4, $data->ser, PDO::PARAM_STR, 4000);
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
              $consulta->bindParam(20, $datos[$i]->{'mum_medica'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(21, $datos[$i]->{'mum_dosis'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(22, $datos[$i]->{'mum_frecue'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(23, $datos[$i]->{'mum_paraq'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(24, $datos[$i]->{'mum_xcuati'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(25, $datos[$i]->{'mum_comtom'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(26, $datos[$i]->{'mum_quirec'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(27, $datos[$i]->{'mum_condes'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(28, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(29, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(30, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(31, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(32, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(33, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(34, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(35, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(36, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(37, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(38, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(39, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(40, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(41, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(42, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(43, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(44, $null, PDO::PARAM_STR, 4000);

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
// guarda medicamentos durante la hospitalizacion
case '3':
     $datos =$data->meh;
      for ($i=0; $i < sizeof($datos); $i++) { 
             try{
              //INGRESA DATO
            
              $consulta = $conn->prepare('SELECT sgh_reconciliacion_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');

              $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
              $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
              $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
              $consulta->bindParam(4, $data->ser, PDO::PARAM_STR, 4000);
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
              $consulta->bindParam(28, $datos[$i]->{'mph_medica'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(29, $datos[$i]->{'mph_dosis'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(30, $datos[$i]->{'mph_frecue'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(31, $datos[$i]->{'mph_via'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(32, $datos[$i]->{'mph_discre'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(33, $datos[$i]->{'mph_meqcam'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(34, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(35, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(36, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(37, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(38, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(39, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(40, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(41, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(42, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(43, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(44, $null, PDO::PARAM_STR, 4000);

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
// guarda medicametos prescritos para el alta 
case '4':
     $datos =$data->mea;
      for ($i=0; $i < sizeof($datos); $i++) { 

             try{

                //INGRESA DATO
                $consulta = $conn->prepare('SELECT sgh_reconciliacion_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');

                $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
                $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
                $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
                $consulta->bindParam(4, $data->ser, PDO::PARAM_STR, 4000);
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
                $consulta->bindParam(35, $datos[$i]->{'mpa_medica'}, PDO::PARAM_STR, 4000);
                $consulta->bindParam(36, $datos[$i]->{'mpa_dosis'}, PDO::PARAM_STR, 4000);
                $consulta->bindParam(37, $datos[$i]->{'mpa_frecue'}, PDO::PARAM_STR, 4000);
                $consulta->bindParam(38, $datos[$i]->{'mpa_via'}, PDO::PARAM_STR, 4000);
                $consulta->bindParam(39, $datos[$i]->{'mpa_recome'}, PDO::PARAM_STR, 4000);
                $consulta->bindParam(40, $null, PDO::PARAM_STR, 4000);
                $consulta->bindParam(41, $null, PDO::PARAM_STR, 4000);
                $consulta->bindParam(42, $null, PDO::PARAM_STR, 4000);
                $consulta->bindParam(43, $null, PDO::PARAM_STR, 4000);
                $consulta->bindParam(44, $null, PDO::PARAM_STR, 4000);

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
// EDITA RECONCILIACION
case '5':
    $datos =$data->rec;
   // print_r($datos);
    try{
      $consulta = $conn->prepare('SELECT sgh_reconciliacion_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');

      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $data->ser, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $datos->{'frm_motate'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos->{'frm_emblac'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $datos->{'frm_peso'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos->{'frm_fueinf'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $datos->{'frm_cual'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $datos->{'frm_intqui'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $datos->{'frm_suspel'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12, $datos->{'frm_enfcro'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(13, $datos->{'frm_dondia'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(14, $datos->{'frm_habito'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(15, $datos->{'frm_faencr'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(16, $datos->{'frm_viaje'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(17, $datos->{'frm_fitote'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(18, $datos->{'frm_obmeul'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(19, $datos->{'frm_obmeho'}, PDO::PARAM_STR, 4000);
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
      $consulta->bindParam(34, $datos->{'frm_quifar'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(35, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(36, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(37, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(38, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(39, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(40, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(41, $datos->{'frm_id_pk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(42, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(43, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(44, $null, PDO::PARAM_STR, 4000);

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
// EDITA RECIBIDOS EN EL ÚLTIMO MES
case '6':
          try{
             //INGRESA DATO
          
              $consulta = $conn->prepare('SELECT sgh_reconciliacion_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');

              $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
              $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
              $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
              $consulta->bindParam(4, $data->ser, PDO::PARAM_STR, 4000);
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
              $consulta->bindParam(20, $data->mum_medica, PDO::PARAM_STR, 4000);
              $consulta->bindParam(21, $data->mum_dosis, PDO::PARAM_STR, 4000);
              $consulta->bindParam(22, $data->mum_frecue, PDO::PARAM_STR, 4000);
              $consulta->bindParam(23, $data->mum_paraq, PDO::PARAM_STR, 4000);
              $consulta->bindParam(24, $data->mum_xcuati, PDO::PARAM_STR, 4000);
              $consulta->bindParam(25, $data->mum_comtom, PDO::PARAM_STR, 4000);
              $consulta->bindParam(26, $data->mum_quirec, PDO::PARAM_STR, 4000);
              $consulta->bindParam(27, $data->mum_condes, PDO::PARAM_STR, 4000);
              $consulta->bindParam(28, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(29, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(30, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(31, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(32, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(33, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(34, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(35, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(36, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(37, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(38, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(39, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(40, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(41, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(42, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(43, $data->mum_id_pk, PDO::PARAM_STR, 4000);
              $consulta->bindParam(44, $null, PDO::PARAM_STR, 4000);

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
// EDITA MEDICAMENTOS RECIBIDOS EN LA HOSPITALIZACIÓN
case '7':
        try{
              //INGRESA DATO
              $consulta = $conn->prepare('SELECT sgh_reconciliacion_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');

              $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
              $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
              $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
              $consulta->bindParam(4, $data->ser, PDO::PARAM_STR, 4000);
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
              $consulta->bindParam(28, $data->mph_medica, PDO::PARAM_STR, 4000);
              $consulta->bindParam(29, $data->mph_dosis, PDO::PARAM_STR, 4000);
              $consulta->bindParam(30, $data->mph_frecue, PDO::PARAM_STR, 4000);
              $consulta->bindParam(31, $data->mph_via, PDO::PARAM_STR, 4000);
              $consulta->bindParam(32, $data->mph_discre, PDO::PARAM_STR, 4000);
              $consulta->bindParam(33, $data->mph_meqcam, PDO::PARAM_STR, 4000);
              $consulta->bindParam(34, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(35, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(36, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(37, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(38, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(39, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(40, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(41, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(42, $data->mph_id_pk, PDO::PARAM_STR, 4000);
              $consulta->bindParam(43, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(44, $null, PDO::PARAM_STR, 4000);

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
// EDITA MEDICAMENTO PRESCRITOS PARA ALTA MÉDICA 
case '8':
         try{

                //INGRESA DATO
                $consulta = $conn->prepare('SELECT sgh_reconciliacion_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');

                $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
                $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
                $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
                $consulta->bindParam(4, $data->ser, PDO::PARAM_STR, 4000);
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
                $consulta->bindParam(35, $data->mpa_medica, PDO::PARAM_STR, 4000);
                $consulta->bindParam(36, $data->mpa_dosis, PDO::PARAM_STR, 4000);
                $consulta->bindParam(37, $data->mpa_frecue, PDO::PARAM_STR, 4000);
                $consulta->bindParam(38, $data->mpa_via, PDO::PARAM_STR, 4000);
                $consulta->bindParam(39, $data->mpa_recome, PDO::PARAM_STR, 4000);
                $consulta->bindParam(40, $data->mpa_id_pk, PDO::PARAM_STR, 4000);
                $consulta->bindParam(41, $null, PDO::PARAM_STR, 4000);
                $consulta->bindParam(42, $null, PDO::PARAM_STR, 4000);
                $consulta->bindParam(43, $null, PDO::PARAM_STR, 4000);
                $consulta->bindParam(44, $null, PDO::PARAM_STR, 4000);

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

// guarda EDITA RECIBIDOS EN EL ÚLTIMO MES
case '9':
          try{
             //INGRESA DATO
          
              $consulta = $conn->prepare('SELECT sgh_reconciliacion_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');

              $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
              $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
              $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
              $consulta->bindParam(4, $data->ser, PDO::PARAM_STR, 4000);
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
              $consulta->bindParam(20, $data->mum_medica, PDO::PARAM_STR, 4000);
              $consulta->bindParam(21, $data->mum_dosis, PDO::PARAM_STR, 4000);
              $consulta->bindParam(22, $data->mum_frecue, PDO::PARAM_STR, 4000);
              $consulta->bindParam(23, $data->mum_paraq, PDO::PARAM_STR, 4000);
              $consulta->bindParam(24, $data->mum_xcuati, PDO::PARAM_STR, 4000);
              $consulta->bindParam(25, $data->mum_comtom, PDO::PARAM_STR, 4000);
              $consulta->bindParam(26, $data->mum_quirec, PDO::PARAM_STR, 4000);
              $consulta->bindParam(27, $data->mum_condes, PDO::PARAM_STR, 4000);
              $consulta->bindParam(28, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(29, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(30, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(31, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(32, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(33, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(34, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(35, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(36, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(37, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(38, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(39, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(40, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(41, $data->frm_id_pk, PDO::PARAM_STR, 4000);
              $consulta->bindParam(42, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(43, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(44, $null, PDO::PARAM_STR, 4000);

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
// guarda EDITA MEDICAMENTOS RECIBIDOS EN LA HOSPITALIZACIÓN
case '10':
        try{
              //INGRESA DATO
              $consulta = $conn->prepare('SELECT sgh_reconciliacion_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');

              $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
              $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
              $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
              $consulta->bindParam(4, $data->ser, PDO::PARAM_STR, 4000);
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
              $consulta->bindParam(28, $data->mph_medica, PDO::PARAM_STR, 4000);
              $consulta->bindParam(29, $data->mph_dosis, PDO::PARAM_STR, 4000);
              $consulta->bindParam(30, $data->mph_frecue, PDO::PARAM_STR, 4000);
              $consulta->bindParam(31, $data->mph_via, PDO::PARAM_STR, 4000);
              $consulta->bindParam(32, $data->mph_discre, PDO::PARAM_STR, 4000);
              $consulta->bindParam(33, $data->mph_meqcam, PDO::PARAM_STR, 4000);
              $consulta->bindParam(34, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(35, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(36, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(37, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(38, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(39, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(40, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(41, $data->frm_id_pk, PDO::PARAM_STR, 4000);
              $consulta->bindParam(42, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(43, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(44, $null, PDO::PARAM_STR, 4000);

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
// guarda EDITA MEDICAMENTO PRESCRITOS PARA ALTA MÉDICA 
case '11':
         try{

                //INGRESA DATO
                $consulta = $conn->prepare('SELECT sgh_reconciliacion_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');

                $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
                $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
                $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
                $consulta->bindParam(4, $data->ser, PDO::PARAM_STR, 4000);
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
                $consulta->bindParam(35, $data->mpa_medica, PDO::PARAM_STR, 4000);
                $consulta->bindParam(36, $data->mpa_dosis, PDO::PARAM_STR, 4000);
                $consulta->bindParam(37, $data->mpa_frecue, PDO::PARAM_STR, 4000);
                $consulta->bindParam(38, $data->mpa_via, PDO::PARAM_STR, 4000);
                $consulta->bindParam(39, $data->mpa_recome, PDO::PARAM_STR, 4000);
                $consulta->bindParam(40, $null, PDO::PARAM_STR, 4000);
                $consulta->bindParam(41, $data->frm_id_pk, PDO::PARAM_STR, 4000);
                $consulta->bindParam(42, $null, PDO::PARAM_STR, 4000);
                $consulta->bindParam(43, $null, PDO::PARAM_STR, 4000);
                $consulta->bindParam(44, $null, PDO::PARAM_STR, 4000);

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