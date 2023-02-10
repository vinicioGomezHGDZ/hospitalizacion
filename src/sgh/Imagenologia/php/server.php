<?php
include_once("../../../../php/class_consulta.php");
$Con= New Consulta();
$Regd=$Con->Get_Consulta("sgh_sol_vih","*","","","",5);
$hola="holalaalala";
$file = $_FILES["file"]["name"];
if ($file==="")
{
	echo "Daos vacios";
}
else{
$numer=count($Regd);

$file2="Archivo".$numer.".pdf";

$extension = explode(".",$file); 
$num = count($extension)-1;

//print_r($extension);
if ($extension [$num] == "pdf")
{

	if(!is_dir("../Concentimientos/"))
	mkdir("../Concentimientos/", 0777);	
	if($file && copy($_FILES["file"]["tmp_name"], "../Concentimientos/".$file2))
	{
		echo "";
	}
	else {echo "error";}
}
else{echo "Solo Archivos pdf";}
}
?>