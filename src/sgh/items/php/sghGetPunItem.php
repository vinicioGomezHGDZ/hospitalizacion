<?php
// retornma un json 
header('content-type: application/json;');

include_once("../../../../php/class_consulta.php");

$Con=New Consulta();

		$Regd=$Con->Get_Consulta("sgh_mei_puntos","*","","pun_estado",'true',2);
		
		 //print_r($Regd);  
				if (count($Regd)==0) 
				{

				echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));

				}else{
				echo json_encode($Regd); 
				}

  
?>