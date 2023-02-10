<?php  

include_once("../../../../php/class_consulta.php");

header('Content-Type: application/json; charset=UTF-8');
		
         $Con=New Consulta();
      
        $Regd=$Con->Get_Consulta("sgh_mei_puntos where pun_estado=true ","*","","","",5);
 		echo json_encode($Regd);
 		
?>