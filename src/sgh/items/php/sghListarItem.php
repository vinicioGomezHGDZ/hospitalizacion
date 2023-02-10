<?php  
// incluir conección de base de datos 

include_once("../../../../php/class_consulta.php");

// returnt json 
header('Content-Type: application/json; charset=UTF-8');
		
         $Con=New Consulta();
      
        $Regd=$Con->Get_Consulta("sgh_mei_problemas pro 
		join sgh_mei_puntos as pun on pun_id_fk=pun.pun_id
		where pro.prb_estado= TRUE","*","","","",5);
    	//print_r($Regd); 
 		echo json_encode($Regd);
 		
 //Database::get_json_rows( $Regd);""
?>