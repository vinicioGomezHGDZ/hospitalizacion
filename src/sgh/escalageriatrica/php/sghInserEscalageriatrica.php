     <?php

   // incluir conección de base de datos 
  require_once("../../../../php/conexion.php");
	$conn=new Conectar();	
	include_once("../../../../php/class_consulta.php");
  $Con=New Consulta();
 
	$data = json_decode(file_get_contents("php://input"));
  $null=null; 
  
   //print_r($data);
  switch ($data->op)
 {
  case 1:
  $datos=$data->esg;
  //  print_r($data);
 ///guarda adsulto mayor

 try{

      $consulta = $conn->prepare('SELECT sgh_escalageriatrica_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $datos->{'esg_sabfec'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $datos->{'esg_apnobj'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos->{'esg_renual'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $datos->{'esg_tompap'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos->{'esg_repser'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $datos->{'esg_copdib'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $datos->{'esg_viveco'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $datos->{'esg_reconso'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12, $datos->{'esg_apreso'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(13, $null  , PDO::PARAM_STR, 4000);
      $consulta->bindParam(14, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(15, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(16, $null, PDO::PARAM_STR, 4000);
    
      $consulta->execute();

      $dat=$consulta->fetch (PDO::FETCH_ASSOC);
      $consulta->closeCursor();
     
    }

  catch(PDOException $Exception){
          $dat= $Exception;
    }       
    $res = json_encode($dat); 
    echo $res;
    
    /// guarda respuestas de los items 

    break;

case 2:
//  print_r($data);
  $items = json_decode(json_encode($data->items),true);

 foreach ($items as $clave => $valor) {
    $respuesta=$valor;
    $item=$clave;

   // echo $respuesta;
      $consulta = $conn->prepare('SELECT sgh_escalageriatrica_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $null , PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $null , PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $null , PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $null , PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $null , PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $null  , PDO::PARAM_STR, 4000);
      $consulta->bindParam(12, $null  , PDO::PARAM_STR, 4000);
      $consulta->bindParam(13, $null  , PDO::PARAM_STR, 4000);
      $consulta->bindParam(14, $respuesta, PDO::PARAM_STR, 4000);
      $consulta->bindParam(15, $item, PDO::PARAM_STR, 4000);
      $consulta->bindParam(16, $data->pun, PDO::PARAM_STR, 4000);
      $consulta->execute();
      
   }
   
   break;
    default:
    # code...
     break;
}


?>