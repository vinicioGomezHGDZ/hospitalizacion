<?php
// retornma un json 
date_default_timezone_set('America/Guayaquil');
include_once("../../../../php/class_consulta.php");
$Con=New Consulta();
$data = json_decode(file_get_contents("php://input"));
$mensaje="null";

        $Regd=$Con->Get_Consulta("sgh_mei_codigocie10 where c10_codigo='".$data->codigo."'","*","","","",5);
     //print_r($Regd);
       
                if (count($Regd)==0) 
                {
                    echo json_encode(array($mensaje));
                }else
                {
                echo json_encode($Regd); 
                } 
?>