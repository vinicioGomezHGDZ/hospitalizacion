<?php  
// incluir conección de base de datos 

date_default_timezone_set('America/Guayaquil');
include_once("../../../../php/class_consulta.php");
$Con=New Consulta();

$data = json_decode(file_get_contents("php://input"));
$error="error";
   $Con=New Consulta();
      
       $Regd=$Con->Get_Consulta("sga_adm_admision  where hce_id_fk='".$data->idhc."'	order by adm_id_pk desc","*","","","",5);
				if (count($Regd)==0) 
				{
				echo json_encode(array('error' => $error,));

				}else{
				echo json_encode($Regd); 
				}


 		
?>