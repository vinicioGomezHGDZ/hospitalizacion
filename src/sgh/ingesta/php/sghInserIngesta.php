     <?php
     date_default_timezone_set('America/Guayaquil');
   // incluir conección de base de datos 
    require_once("../../../../php/conexion.php");
	$conn=new Conectar();	
	
	$data = json_decode(file_get_contents("php://input"));

	//declaracion de bariables

  $ing =$data->ing;
  $null=null;
  //print_r($data);
switch ($data->op) {
    # guardar CONTROL DE INGESTA Y ELIMINACIÓN
case '1':
  $aing=$data->aing;
for ($i=0; $i <count($aing) ; $i++) { 
  # code...
      $contrtol="INGESTA";
      $tipo="ORAL";
        try{
            //Importo conexion de archivo debido a que mensaje de respuesta no devuelve con metodo de conexion

              $consulta = $conn->prepare('SELECT sgh_controlingesta_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?)');
              $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
              $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
              $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
              $consulta->bindParam(4, $data->cama, PDO::PARAM_STR, 4000);
              $consulta->bindParam(5, $ing->{'cie_turno'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(6, $contrtol, PDO::PARAM_STR, 4000);
              $consulta->bindParam(7, $tipo, PDO::PARAM_STR, 4000);
              $consulta->bindParam(8, $aing[$i]->{'cie_hora'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(9, $aing[$i]->{'cie_clase'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(10, $aing[$i]->{'cie_cantcc'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(11, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(12, $ing->{'cie_fecha'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(13, $null, PDO::PARAM_STR, 4000);

              $consulta->execute();


           $contrtol="INGESTA";
           $tipo="PARENTAL";
       
              $consulta = $conn->prepare('SELECT sgh_controlingesta_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?)');
              $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
              $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
              $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
              $consulta->bindParam(4, $data->cama, PDO::PARAM_STR, 4000);
              $consulta->bindParam(5, $ing->{'cie_turno'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(6, $contrtol, PDO::PARAM_STR, 4000);
              $consulta->bindParam(7, $tipo, PDO::PARAM_STR, 4000);
              $consulta->bindParam(8, $aing[$i]->{'cie_hora'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(9, $aing[$i]->{'cie_clasep'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(10, $aing[$i]->{'cie_cantccp'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(11, $aing[$i]->{'cie_canabs'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(12, $ing->{'cie_fecha'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(13, $null, PDO::PARAM_STR, 4000);

              $consulta->execute();
            
           $contrtol="ELIMINACIÓN";
           $tipo="ORINA"; 
       
              $consulta = $conn->prepare('SELECT sgh_controlingesta_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?)');
              $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
              $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
              $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
              $consulta->bindParam(4, $data->cama, PDO::PARAM_STR, 4000);
              $consulta->bindParam(5, $ing->{'cie_turno'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(6, $contrtol, PDO::PARAM_STR, 4000);
              $consulta->bindParam(7, $tipo, PDO::PARAM_STR, 4000);
              $consulta->bindParam(8, $aing[$i]->{'cie_hora'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(9, $aing[$i]->{'cie_comoobtuvo'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(10, $aing[$i]->{'cie_cantcco'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(11, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(12,  $ing->{'cie_fecha'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(13, $null, PDO::PARAM_STR, 4000);

              $consulta->execute();
            
           $contrtol="ELIMINACIÓN";
           $tipo="OTROS"; 
        

              $consulta = $conn->prepare('SELECT sgh_controlingesta_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?)');
              $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
              $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
              $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
              $consulta->bindParam(4, $data->cama, PDO::PARAM_STR, 4000);
              $consulta->bindParam(5, $ing->{'cie_turno'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(6, $contrtol, PDO::PARAM_STR, 4000);
              $consulta->bindParam(7, $tipo, PDO::PARAM_STR, 4000);
              $consulta->bindParam(8, $aing[$i]->{'cie_hora'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(9, $aing[$i]->{'cie_origen'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(10, $aing[$i]->{'cie_cantccot'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(11, $null, PDO::PARAM_STR, 4000);
              $consulta->bindParam(12, $ing->{'cie_fecha'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(13, $null, PDO::PARAM_STR, 4000);

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
case '2':
      $null=null;
         try{
        $consulta = $conn->prepare('SELECT sgh_controlingesta_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?)');
              $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
              $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
              $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
              $consulta->bindParam(4, $data->cama, PDO::PARAM_STR, 4000);
              $consulta->bindParam(5, $ing->{'cie_turno'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(6, $contrtol, PDO::PARAM_STR, 4000);
              $consulta->bindParam(7, $tipo, PDO::PARAM_STR, 4000);
              $consulta->bindParam(8, $ing->{'cie_hora'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(9, $ing->{'cie_clase'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(10, $ing->{'cie_cantcc'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(11, $ing->{'cie_canabs'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(12, $ing->{'cie_fecha'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(13, $ing->{'cie_id_pk'}, PDO::PARAM_STR, 4000);
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