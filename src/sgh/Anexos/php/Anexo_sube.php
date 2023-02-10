<?php
include_once("../../../../php/class_consulta.php");
$Con= New Consulta();
$Regd=$Con->Get_Consulta("sgh_mei_anexos","*","","","",5);
$file = $_FILES["file"]["name"];
$numer=count($Regd);
$extension = explode(".",$file);
$num = count($extension)-1;

if(!is_dir("/sgh_2tb/sgh")) mkdir("/sgh_2tb/sgh", 0777);

if(!is_dir("/sgh_2tb/sgh/anexos"))mkdir("/sgh_2tb/sgh/anexos", 0777);

//print_r($extension);
if ($extension [$num] == "pdf")
{
    $file2="ARCHIVO_ADJUNTO_".$numer.".pdf";
    if($file && copy($_FILES["file"]["tmp_name"], "/sgh_2tb/sgh/anexos/".$file2))
	{
		echo "pdf";
	}
	else {echo "error";}
}
elseif ($extension [$num] == "png")
{
    $file2="ARCHIVO_ADJUNTO_".$numer.".png";
    if($file && copy($_FILES["file"]["tmp_name"], "/sgh_2tb/sgh/anexos/".$file2))
    {
        echo "png";
    }
    else {echo "error";}
}
elseif ($extension [$num] == "jpg")
{
    $file2="ARCHIVO_ADJUNTO_".$numer.".jpg";
    if($file && copy($_FILES["file"]["tmp_name"], "/sgh_2tb/sgh/anexos/".$file2))
    {
        echo "jpg";
    }
    else {echo "error";}
}
elseif ($extension [$num] == "gif")
{
    $file2="ARCHIVO_ADJUNTO_".$numer.".gif";
    if($file && copy($_FILES["file"]["tmp_name"], "/sgh_2tb/sgh/anexos/".$file2))
    {
        echo "gif";
    }
    else {echo "error";}
}
else

{echo "Solo Archivos pdf, png, jpg, gif";}

?>