<?php  
// incluir conección de base de datos 

include_once("../../../../php/class_consulta.php");

// returnt json 
header('Content-Type: application/json; charset=UTF-8');
		
         $Con=New Consulta();
      
        $Regd=$Con->Get_Consulta("sgh_ped_ngrafico where gra_estado= true","*","","","",5);
    	//print_r($Regd); 
 		echo json_encode($Regd);
 		
 //Database::get_json_rows( $Regd);""
?>