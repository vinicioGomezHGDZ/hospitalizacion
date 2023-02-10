<?php
// retornma un json 
// retornma un json 
include_once("../../../../php/class_consulta.php");
$Con=New Consulta();
$data = json_decode(file_get_contents("php://input"));

		$Regd=$Con->Get_Consulta("sgh_mei_codigocie10","*","","c10_id_pk",$data->codigo,2);
	 //print_r($Regd);
	   
				if (count($Regd)==0) 
				{

				echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));

				}else{
				echo json_encode($Regd); 
				} 
?>