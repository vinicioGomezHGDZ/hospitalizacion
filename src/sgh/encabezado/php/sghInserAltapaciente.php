     <?php

   // incluir conección de base de datos 
  require_once("../../../../php/conexion.php");
	$conn=new Conectar();	
	include_once("../../../../php/class_consulta.php");
  $Con=New Consulta();

	$data = json_decode(file_get_contents("php://input"));
  $null=null;
  $ces_id_fk=1;
switch ($data->op) {
// alta de paciente.
    case 1:
   $datos =$data->alta;
   // GUARDA EGRESO
  try{

      $consulta = $conn->prepare('SELECT sgh_altapaciente_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $data->cam, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $datos->{'cen_tipo'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos->{'cen_def_48'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $datos->{'cen_def48'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos->{'cen_visible'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $data->cen, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10,$datos->{'ces_id_fk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11,$null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12,$null, PDO::PARAM_STR, 4000);

      $consulta->execute();
      $dat=$consulta->fetch (PDO::FETCH_ASSOC);
      $consulta->closeCursor();
     
    }
  catch(PDOException $Exception){
          $dat= $Exception;
    }       
$res = json_encode($dat); 
echo $res;
// GUARDA ESTADO DE PACIENTE 
  $opc=2;
      $consulta = $conn->prepare('SELECT sgh_altapaciente_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $opc, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $data->cam, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $datos->{'cen_tipo'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos->{'cen_def_48'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $datos->{'cen_def48'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos->{'cen_visible'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $data->cen, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10,$datos->{'ces_id_fk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11,$null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12,$null, PDO::PARAM_STR, 4000);
    $consulta->execute();
      $dat=$consulta->fetch (PDO::FETCH_ASSOC);
      $consulta->closeCursor();
     

// GUARDA EL ESTADO EN QUE QUEDA CAMA
$opca=3;

      $consulta = $conn->prepare('SELECT sgh_altapaciente_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $opca, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $data->cam, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $datos->{'cen_tipo'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos->{'cen_def_48'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $datos->{'cen_def48'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos->{'cen_visible'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $data->cen, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $datos->{'ces_id_fk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11,$null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12,$null, PDO::PARAM_STR, 4000);

    $consulta->execute();
      $dat=$consulta->fetch (PDO::FETCH_ASSOC);
      $consulta->closeCursor();

   break;


#/ transferencia
case 2:
       // print_r($data);
        $datos =$data->alta;
    // GUARDA EGRESO
        $opal=1;
        $cen_ingreso_tras="trans";
        try{

            $consulta = $conn->prepare('SELECT sgh_altapaciente_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?)');
            $consulta->bindParam(1, $opal, PDO::PARAM_STR, 4000);
            $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
            $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
            $consulta->bindParam(4, $data->cam, PDO::PARAM_STR, 4000);
            $consulta->bindParam(5, $datos->{'cen_tipo'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(6, $datos->{'cen_def_48'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(7, $datos->{'cen_def48'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(8, $datos->{'cen_visible'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(9, $data->cen, PDO::PARAM_STR, 4000);
            $consulta->bindParam(10, $datos->{'ces_id_fk'}, PDO::PARAM_STR, 4000);
            $consulta->bindParam(11, $null, PDO::PARAM_STR, 4000);
            $consulta->bindParam(12, $cen_ingreso_tras, PDO::PARAM_STR, 4000);
            $consulta->execute();
            $dat=$consulta->fetch (PDO::FETCH_ASSOC);
            $consulta->closeCursor();

        }
        catch(PDOException $Exception){
            $dat= $Exception;
        }
       // $res = json_encode($dat);
     //   echo $res;
    // GUARDA ESTADO DE PACIENTE
        $opc=2;
        $consulta = $conn->prepare('SELECT sgh_altapaciente_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?)');
        $consulta->bindParam(1, $opc, PDO::PARAM_STR, 4000);
        $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
        $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
        $consulta->bindParam(4, $data->cam, PDO::PARAM_STR, 4000);
        $consulta->bindParam(5, $datos->{'cen_tipo'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(6, $datos->{'cen_def_48'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(7, $datos->{'cen_def48'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(8, $datos->{'cen_visible'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(9, $data->cen, PDO::PARAM_STR, 4000);
        $consulta->bindParam(10, $datos->{'ces_id_fk'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(11, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(12, $cen_ingreso_tras, PDO::PARAM_STR, 4000);

    $consulta->execute();
        $dat=$consulta->fetch (PDO::FETCH_ASSOC);
        $consulta->closeCursor();
   // GUARDA EL ESTADO EN QUE QUEDA CAMA
        $opca=3;
        $consulta = $conn->prepare('SELECT sgh_altapaciente_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?)');
        $consulta->bindParam(1, $opca, PDO::PARAM_STR, 4000);
        $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
        $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
        $consulta->bindParam(4, $data->cam, PDO::PARAM_STR, 4000);
        $consulta->bindParam(5, $datos->{'cen_tipo'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(6, $datos->{'cen_def_48'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(7, $datos->{'cen_def48'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(8, $datos->{'cen_visible'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(9, $data->cen, PDO::PARAM_STR, 4000);
        $consulta->bindParam(10, $datos->{'ces_id_fk'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(11, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(12, $cen_ingreso_tras, PDO::PARAM_STR, 4000);

    $consulta->execute();
        $dat=$consulta->fetch (PDO::FETCH_ASSOC);
        $consulta->closeCursor();

    // GUARDAR A DONDE CE TRANSFIRIO PACIENTE
        $optra=4;
        $tipo="INGRESO";

    try
    {
    $consulta = $conn->prepare('SELECT sgh_altapaciente_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?)');
    $consulta->bindParam(1, $optra, PDO::PARAM_STR, 4000);
    $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
    $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
    $consulta->bindParam(4, $datos->{'cam_id_pk'}, PDO::PARAM_STR, 4000);
    $consulta->bindParam(5, $tipo, PDO::PARAM_STR, 4000);
    $consulta->bindParam(6, $datos->{'cen_def_48'}, PDO::PARAM_STR, 4000);
    $consulta->bindParam(7, $datos->{'cen_def48'}, PDO::PARAM_STR, 4000);
    $consulta->bindParam(8, $datos->{'cen_visible'}, PDO::PARAM_STR, 4000);
    $consulta->bindParam(9, $data->cen, PDO::PARAM_STR, 4000);
    $consulta->bindParam(10,$ces_id_fk, PDO::PARAM_STR, 4000);
    $consulta->bindParam(11,$data->fecha, PDO::PARAM_STR, 4000);
     $consulta->bindParam(12, $cen_ingreso_tras, PDO::PARAM_STR, 4000);
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

////
case 3:

             $datos =$data->alta;

    // GUARDA EL ESTADO EN QUE QUEDA CAMA
             $opca=3;
             $consulta = $conn->prepare('SELECT sgh_altapaciente_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?)');
             $consulta->bindParam(1, $opca, PDO::PARAM_STR, 4000);
             $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
             $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
             $consulta->bindParam(4, $data->cam, PDO::PARAM_STR, 4000);
             $consulta->bindParam(5, $datos->{'cen_tipo'}, PDO::PARAM_STR, 4000);
             $consulta->bindParam(6, $datos->{'cen_def_48'}, PDO::PARAM_STR, 4000);
             $consulta->bindParam(7, $datos->{'cen_def48'}, PDO::PARAM_STR, 4000);
             $consulta->bindParam(8, $datos->{'cen_visible'}, PDO::PARAM_STR, 4000);
             $consulta->bindParam(9, $data->cen, PDO::PARAM_STR, 4000);
             $consulta->bindParam(10, $datos->{'ces_id_fk'}, PDO::PARAM_STR, 4000);
             $consulta->bindParam(11, $null, PDO::PARAM_STR, 4000);
             $consulta->bindParam(12, $null, PDO::PARAM_STR, 4000);

             $consulta->execute();
             $dat=$consulta->fetch (PDO::FETCH_ASSOC);
             $consulta->closeCursor();

  // GUARDAR A DONDE SELE CAMBIA EL PACIENTE  PACIENTE
             $optra=5;
             try
             {
                 $consulta = $conn->prepare('SELECT sgh_altapaciente_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?)');
                 $consulta->bindParam(1, $optra, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(4, $datos->{'cam_id_pk'}, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(5, $null, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(6, $datos->{'cen_def_48'}, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(7, $datos->{'cen_def48'}, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(8, $datos->{'cen_visible'}, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(9, $data->cen, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(10,$ces_id_fk, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(11,$null, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(12,$null, PDO::PARAM_STR, 4000);
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

         Default:
    # code...
  break;
}

?>