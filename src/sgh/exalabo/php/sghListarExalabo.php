<?php  
// incluir conección de base de datos 
include_once("../../../../php/class_consulta.php");
$Con=New Consulta();

$data = json_decode(file_get_contents("php://input"));
      
        $Regd=$Con->Get_Consulta("sgh_sol_ex as ex 
  		join sgh_sol_cat as ca on cat_id_fk = ca.cat_id_pk 
  		and ex.exa_estado= true","*","","","",5);
    
 			if (count($Regd)==0) 
				{

				echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));

				}else{
				echo json_encode($Regd); 
				} 
?>