     <?php

   // incluir conección de base de datos 
  require_once("../../../../php/conexion.php");
	$conn=new Conectar();	
	include_once("../../../../php/class_consulta.php");
  $Con= New Consulta();

	$data = json_decode(file_get_contents("php://input"));
	//declaracion de bariables
 ///print_r($data);
	  $hce_id_fk=$data->hcl ;
  	$usu_id_fk=$data->usu ;

 $Regd=$Con->Get_Consulta("sgh_mei_concentimiento","*","","","",5);
 $numer=count($Regd);
 $aer_archi="CONSENTIMIENTO_".$numer.".pdf";

	try{
    //Importo conexion de archivo debido a que mensaje de respuesta no devuelve con metodo de conexion

 	 $consulta = $conn->prepare('SELECT sgh_concentimiento_ingresa_pa(?,?,?)');
     
      $consulta->bindParam(1, $hce_id_fk, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $usu_id_fk, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $aer_archi, PDO::PARAM_STR, 4000);
      
      $consulta->execute();
      
      $dat=$consulta->fetch (PDO::FETCH_ASSOC);
      $consulta->closeCursor();
     
    }
  catch(PDOException $Exception){
          $dat= $Exception;
    }
    
  $res = json_encode($dat); 
echo $res;
?>