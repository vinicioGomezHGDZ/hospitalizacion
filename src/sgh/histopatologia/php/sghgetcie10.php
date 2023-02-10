<?php
// retornma un json 

header('content-type: application/json;');		
$codigo=htmlentities($_GET['c']);

include_once("../../../../php/class_consulta.php");

$Con=New Consulta();


        $Regd=$Con->Get_Consulta("sgh_mei_codigocie10 where c10_codigo='".$codigo."'","*","","","",5);
     //print_r($Regd);
       
                if (count($Regd)==0) 
                {
                 echo json_encode("null");	
                }else
                {
                echo json_encode($Regd); 
                } 
?>