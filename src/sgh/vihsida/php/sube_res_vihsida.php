<?php
$file = $_FILES["file"]["name"];
$codigo=$_POST["codigo"];

$file2="RESULTADO_N_".$codigo.".pdf";

$extension = explode(".",$file); 

$num = count($extension)-1;

if ($extension [$num] == "pdf")
{
	if(!is_dir("/sgh_2tb/sgh/vihsida/resultados"))
	mkdir("/sgh_2tb/sgh/vihsida/resultados", 0777);

	if(copy($_FILES["file"]["tmp_name"], "/sgh_2tb/sgh/vihsida/resultados/".$file2))
	{
		echo "";
	}
	else {echo "Tamaño de archivo demaciado Grande";}
}
else{echo "Solo Archivos pdf";}

?>