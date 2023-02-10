<?php
include_once("../../../../php/class_consulta.php");
$Con= New Consulta();
$Regd=$Con->Get_Consulta("sgh_mei_concentimiento","*","","","",5);

$file = $_FILES["file"]["name"];

$numer=count($Regd);
//echo ($numer);
$file2="CONSENTIMIENTO_".$numer.".pdf";

$extension = explode(".",$file); 
$num = count($extension)-1;

//print_r($extension);
if ($extension [$num] == "pdf")
{
    if(!is_dir("/sgh_2tb/sgh")) mkdir("/sgh_2tb/sgh", 0777);

    if(!is_dir("/sgh_2tb/sgh/concentimiento"))
	mkdir("/sgh_2tb/sgh/concentimiento", 0777);
	if($file && copy($_FILES["file"]["tmp_name"], "/sgh_2tb/sgh/concentimiento/".$file2))
	{
		echo "";
	}
	else {echo "error";}
}
else{echo "Solo Archivos pdf";}

?>