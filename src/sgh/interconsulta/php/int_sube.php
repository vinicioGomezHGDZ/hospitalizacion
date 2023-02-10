<?php
include_once("../../../../php/class_consulta.php");
$Con= New Consulta();
$Regd=$Con->Get_Consulta("sgh_mei_intercsol","int_id_pk","","","",5);

$file = $_FILES["file"]["name"];

$numer=count($Regd);
//echo ($numer);
$file2="INTERCONSULTA_".$numer.".pdf";

$extension = explode(".",$file); 
$num = count($extension)-1;

//print_r($extension);
if ($extension [$num] == "pdf")
{
	if(!is_dir("/sgh_2tb/sgh")) mkdir("/sgh_2tb/sgh", 0777);
	if(!is_dir("/sgh_2tb/sgh/interconsultas")) mkdir("/sgh_2tb/sgh/interconsultas", 0777);
	//if(!is_dir("archivos/interconsultas")) mkdir("archivos/interconsultas", 0777);

	if($file && copy($_FILES["file"]["tmp_name"], "/sgh_2tb/sgh/interconsultas/".$file2))
	{
		echo "Guardado";
	}
	else {echo "error";}
}
else{echo "Solo Archivos pdf";}

?>