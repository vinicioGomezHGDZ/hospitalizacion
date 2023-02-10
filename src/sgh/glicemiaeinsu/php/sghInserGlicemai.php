
  <?php
   require_once("../../../../php/conexion.php");
	$conn=new Conectar();	
	
	$data = json_decode(file_get_contents("php://input"));
  $gli =$data->gli;
  $null=null;
switch ($data->op) {
  case '1':
    # Guardar datos
  try{
   $consulta = $conn->prepare('SELECT sgh_glicemia_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->cam, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $gli->{'hgi_fecha'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $gli->{'hgi_glicem'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $gli->{'hgi_esquem'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $gli->{'hgi_espaco'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $gli->{'hgi_totadm'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $gli->{'hgi_obcerv'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $null, PDO::PARAM_STR, 4000);
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
    # editar datos
 try{
      $consulta = $conn->prepare('SELECT sgh_glicemia_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->cam, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $gli->{'hgi_fecha'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $gli->{'hgi_glicem'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $gli->{'hgi_esquem'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $gli->{'hgi_espaco'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $gli->{'hgi_totadm'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $gli->{'hgi_obcerv'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $gli->{'hgi_id_pk'}, PDO::PARAM_STR, 4000);
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