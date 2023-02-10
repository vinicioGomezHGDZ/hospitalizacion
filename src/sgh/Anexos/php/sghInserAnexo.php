     <?php

   // incluir conección de base de datos 
  require_once("../../../../php/conexion.php");
	$conn=new Conectar();	
	include_once("../../../../php/class_consulta.php");
    $Con= New Consulta();
	$data = json_decode(file_get_contents("php://input"));
	//declaracion de bariables
 $Regd=$Con->Get_Consulta("sgh_mei_anexos","*","","","",5);
 $numer=count($Regd);

 $aer_archi="ARCHIVO_ADJUNTO_".$numer.".$data->ext";
 $null=null;

 switch ($data->op)
  {
      case 1:

                try{
                //Importo conexion de archivo debido a que mensaje de respuesta no devuelve con metodo de conexion

                 $consulta = $conn->prepare('SELECT sgh_anexos_ingresa_pa(?,?,?,?,?)');
                  $consulta->bindParam(1, $data->hcl, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(2, $data->usu , PDO::PARAM_STR, 4000);
                  $consulta->bindParam(3, $aer_archi, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(4, $null, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(5, $data->op, PDO::PARAM_STR, 4000);

                  $consulta->execute();

                  $dat=$consulta->fetch (PDO::FETCH_ASSOC);
                  $consulta->closeCursor();

                }catch(PDOException $Exception){$dat= $Exception;}
              $res = json_encode($dat);
              echo $res;
      break;
      case 2:

                try{
                //Importo conexion de archivo debido a que mensaje de respuesta no devuelve con metodo de conexion

                 $consulta = $conn->prepare('SELECT sgh_anexos_ingresa_pa(?,?,?,?,?)');
                  $consulta->bindParam(1, $data->hcl, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(2, $data->usu , PDO::PARAM_STR, 4000);
                  $consulta->bindParam(3, $aer_archi, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(4, $data->fecha, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(5, $data->op, PDO::PARAM_STR, 4000);

                  $consulta->execute();

                  $dat=$consulta->fetch (PDO::FETCH_ASSOC);
                  $consulta->closeCursor();

                }catch(PDOException $Exception){$dat= $Exception;}
              $res = json_encode($dat);
              echo $res;
      break;
      default:
             # code...
      break;
     }
?>