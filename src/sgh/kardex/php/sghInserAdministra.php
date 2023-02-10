<?php
    require_once("../../../../php/conexion.php");
	$conn=new Conectar();	

	$data = json_decode(file_get_contents("php://input"));


switch ($data->op) {
case '1':
    $null=null;
    $adm =$data->adm;
  foreach($adm as $clave=> $valor) {
             try {
                 //Importo conexion de archivo debido a que mensaje de respuesta no devuelve con metodo de conexion

                 $consulta = $conn->prepare('SELECT sgh_administracion_ingreso_pa (?,?,?,?,?,?,?)');
                 $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(2, $data->fk, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(3, $data->usu, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(4, $valor, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(5, $null, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(6, $null, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(7, $data->fecha, PDO::PARAM_STR, 4000);
                 $consulta->execute();

                 $dat = $consulta->fetch(PDO::FETCH_ASSOC);
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

    try {
        //Importo conexion de archivo debido a que mensaje de respuesta no devuelve con metodo de conexion

        $consulta = $conn->prepare('SELECT sgh_administracion_ingreso_pa (?,?,?,?,?,?,?)');
        $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
        $consulta->bindParam(2, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(3, $data->usu, PDO::PARAM_STR, 4000);
        $consulta->bindParam(4, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(5, $data->hda_obcerv, PDO::PARAM_STR, 4000);
        $consulta->bindParam(6, $data->id, PDO::PARAM_STR, 4000);
        $consulta->bindParam(7, $null, PDO::PARAM_STR, 4000);
        $consulta->execute();


        $dat = $consulta->fetch(PDO::FETCH_ASSOC);
        $consulta->closeCursor();

    }
    catch(PDOException $Exception){
        $dat= $Exception;
    }
$res = json_encode($dat);
echo $res;
break;

    case '3':

        $null=null;
        try {
            //Importo conexion de archivo debido a que mensaje de respuesta no devuelve con metodo de conexion

            $consulta = $conn->prepare('SELECT sgh_administracion_ingreso_pa (?,?,?,?,?,?,?)');
            $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
            $consulta->bindParam(2, $null, PDO::PARAM_STR, 4000);
            $consulta->bindParam(3, $data->usu, PDO::PARAM_STR, 4000);
            $consulta->bindParam(4, $null, PDO::PARAM_STR, 4000);
            $consulta->bindParam(5, $data->hda_obcerv, PDO::PARAM_STR, 4000);
            $consulta->bindParam(6, $data->id, PDO::PARAM_STR, 4000);
            $consulta->bindParam(7, $null, PDO::PARAM_STR, 4000);
            $consulta->execute();


            $dat = $consulta->fetch(PDO::FETCH_ASSOC);
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