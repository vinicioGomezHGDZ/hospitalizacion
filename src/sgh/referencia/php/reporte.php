<?php
include_once('../../../../class/tcpdf/tcpdf.php');
include_once("../../../../class/PHPJasperXML.inc.php");
include_once("../../../../class/PHPJasperXMLSubReport.inc.php");
//include_once ('setting.php');
$parametro=$_GET['h'];
$file=$_GET['f'];
$pgport=5433;
//print_r($parametro);
$xml = simplexml_load_file("../../reportes/".$file.".jrxml");
$PHPJasperXML = new PHPJasperXML();
$PHPJasperXML->debugsql=false;

$PHPJasperXML->arrayParameter=array("ref_id_pk"=>$parametro);

$PHPJasperXML->xml_dismantle($xml);
$PHPJasperXML->load_xml_string($xml);
$PHPJasperXML->connect("172.20.19.177","rafael.real","r.f2017","sgh_database", "psql");
$PHPJasperXML->transferDBtoArray("172.20.19.177","rafael.real","r.f2017","sgh_database", "psql");
$PHPJasperXML->outpage("I",$file.$parametro.".pdf");

?>