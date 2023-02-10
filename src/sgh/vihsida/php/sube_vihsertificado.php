<?php
include_once("../../../../php/class_consulta.php");
$Con= New Consulta();
$Regd=$Con->Get_Consulta("sgh_sol_vih","*","","","",5);

$file = $_FILES["file"]["name"];
if ($file==="")
{
	echo "Daos vacios";
}
else{
$numer=count($Regd);

$file2="CONSENTIMIENTO_".$numer.".pdf";

$extension = explode(".",$file); 
$num = count($extension)-1;

//print_r($extension);
if ($extension [$num] == "pdf")
{
	if(!is_dir("/opt/lampp/htdocs/archivos/sgh/vihsida/consentimientos/"))
	mkdir("/opt/lampp/htdocs/archivos/sgh/vihsida/consentimientos/", 0777);
	if($file && copy($_FILES["file"]["tmp_name"], "/opt/lampp/htdocs/archivos/sgh/vihsida/consentimientos/".$file2))
	{
		echo "";
	}
	else {echo "error";}
}
else{echo "Solo Archivos pdf";}
}
?>