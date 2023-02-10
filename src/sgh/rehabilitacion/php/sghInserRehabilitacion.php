     <?php
header('content-type: application/json;');  
   // incluir conección de base de datos 
  require_once("../../../../php/conexion.php");
	$conn=new Conectar();
  
  $data = json_decode(file_get_contents("php://input"));

   $null=null;
   switch ($data->op) {
     
     case '1':
       # code...
      $reha =$data->reha;
      try{
         $consulta = $conn->prepare('SELECT sgh_reahbilitacion_ingreso_pa(?,?,?,?,?,?,?,?)');
            $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
            $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
            $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
            $consulta->bindParam(4, $reha->{'mfr_diagno'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(5, $reha->{'mfr_horari'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(6, $reha->{'mfr_turnmt'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(7, $reha->{'mer_terapi'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(8, $reha->{'mfr_di_pk'}, PDO::PARAM_STR, 4000);
          
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
      # guarda edicion de datos
    $reha =$data->reha;
      try{
         $consulta = $conn->prepare('SELECT sgh_reahbilitacion_ingreso_pa(?,?,?,?,?,?)');
     
            $consulta = $conn->prepare('SELECT sgh_reahbilitacion_ingreso_pa(?,?,?,?,?,?,?,?)');
            $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
            $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
            $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
            $consulta->bindParam(4, $reha->{'mfr_diagno'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(5, $reha->{'mfr_horari'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(6, $reha->{'mfr_turnmt'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(7, $reha->{'mer_terapi'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(8, $reha->{'mfr_di_pk'}, PDO::PARAM_STR, 4000);
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

     case '3':
       # code...
            $anio=date("Y");  // devuelve "cde";
            $mes=date("m");  // devuelve "cde";
            $dia=date("j");  // devuelve "cde";
            
            try{
             //Importo conexion de archivo debido a que mensaje de respuesta no devuelve con metodo de conexion
                $consulta = $conn->prepare('SELECT sgh_horario_ingreso_pa(?,?,?,?)');
                
                $consulta->bindParam(1, $data->id, PDO::PARAM_STR, 4000);
                $consulta->bindParam(2, $anio, PDO::PARAM_STR, 4000);
                $consulta->bindParam(3, $mes, PDO::PARAM_STR, 4000);
                $consulta->bindParam(4, $dia, PDO::PARAM_STR, 4000);
               
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