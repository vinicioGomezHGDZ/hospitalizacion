<?php
// retornma un json 
include_once("../../../../php/class_consulta.php");
$Con=New Consulta();
$data = json_decode(file_get_contents("php://input"));
	
		$Regd=$Con->Get_Consulta("sgh_sol_cat","*","","cat_id_pk",$data->codigo,2);
	 	if (count($Regd)==0) 
				{

				echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));

				}else{
				echo json_encode($Regd); 
				} 
?>