<?php
require_once("../../../../php/conexion.php");
require_once '../../../../vendor/autoload.php';
include_once("../../../../php/class_consulta.php");
use Mpdf\Mpdf;
$mpdf = new mPDF(['debug' => true,'mode'=>'utf-8','format'=>'A4']);

$Con=New Consulta();
$inp_id_pk=$_GET['c'];
// CONSULTAS DE REPORRTE
	# CARGAR DATOS DE ENCABEZADO. array 0
    $bdd= new Conectar();

    $sql=$bdd->prepare("select json_agg(t) from (select (pe.per_nombres ||' '||pe.per_apellidopaterno || ' ' ||pe.per_apellidomaterno) AS informante,
  (peh.per_nombres ||' '||peh.per_apellidopaterno || ' ' ||peh.per_apellidomaterno) AS paciente
  ,inp_id_pk,inp_cuides,  regexp_replace(inp_aseo,'\n',' <br>','g') inp_aseo,  regexp_replace(inp_reposo,'\n',' <br>','g') inp_reposo,  regexp_replace(inp_alimen,'\n',' <br>','g') inp_alimen,  regexp_replace(inp_ldhace,'\n',' <br>','g') inp_ldhace,  regexp_replace(inp_indica,'\n',' <br>','g') inp_indica,to_char(inp_fpcita,'dd-MM-YYYY') as inp_fpcita,inp_llamar,inp_fecha
from sgh_mei_inforalpaci inf
     		 join sga_adm_historiaclinica as his on inf.hce_id_fk=his.hce_id_pk
      		JOIN sga_adm_paciente as pas  on his.pac_id_fk= pas.pac_id_pk
      		JOIN sga_adm_persona as peh  on pas.per_id_fk= peh.per_id_pk
      		JOIN sgu_usu_usuario as us on inf.usu_id_fk = us.usu_id_pk
			JOIN sga_adm_profesional as pr on us.pro_id_fk = pr.pro_id_pk
			JOIN sga_adm_persona as pe  on pr.per_id_fk= pe.per_id_pk
			JOIN sga_adm_profesion as pro on pr.prf_id_fk = pro.prf_id_pk where inp_id_pk = '".$inp_id_pk."')t"); 

$sql->execute();
$row=$sql->fetchAll (PDO::FETCH_ASSOC);
$per=json_decode($row[0]["json_agg"],true);
    /*$per=$Con->Get_Consulta("sgh_mei_inforalpaci inf
     		 join sga_adm_historiaclinica as his on inf.hce_id_fk=his.hce_id_pk
      		JOIN sga_adm_paciente as pas  on his.pac_id_fk= pas.pac_id_pk
      		JOIN sga_adm_persona as peh  on pas.per_id_fk= peh.per_id_pk
      		JOIN sgu_usu_usuario as us on inf.usu_id_fk = us.usu_id_pk
			JOIN sga_adm_profesional as pr on us.pro_id_fk = pr.pro_id_pk
			JOIN sga_adm_persona as pe  on pr.per_id_fk= pe.per_id_pk
			JOIN sga_adm_profesion as pro on pr.prf_id_fk = pro.prf_id_pk","(pe.per_nombres ||' '||pe.per_apellidopaterno || ' ' ||pe.per_apellidomaterno) AS informante,
  (peh.per_nombres ||' '||peh.per_apellidopaterno || ' ' ||peh.per_apellidomaterno) AS paciente
  ,inp_id_pk,inp_cuides,  regexp_replace(inp_aseo,'\n','<br>','g'),  regexp_replace(inp_reposo,'\n','<br>','g'),  regexp_replace(inp_alimen,'\n','<br>','g'),  regexp_replace(inp_ldhace,'\n','<br>','g'),  regexp_replace(inp_indica,'\n','<br>','g'),to_char(inp_fpcita,'dd-MM-YYYY') as inp_fpcita,inp_llamar,inp_fecha","","inp_id_pk",$inp_id_pk,2);
		*/
	
//$mpdf->useOddEven = 1;
// HTML DE REPORTE 

$html = '

	<html>

	<head>

	<style>
			.th{
				   background: #99e6ff;
				   color: #000000;
				}

			@page {

			  size: auto;

			  odd-header-name: html_myHeader1;

			  even-header-name: html_myHeader2;

			  odd-footer-name: html_myFooter1;

			  even-footer-name: html_myFooter2;

			}

			@page chapter2 {

			    odd-header-name: html_Chapter2HeaderOdd;

			    even-header-name: html_Chapter2HeaderEven;

			    odd-footer-name: html_Chapter2FooterOdd;

			    even-footer-name: html_Chapter2FooterEven;

			}

			@page noheader {

			    odd-header-name: _blank;

			    even-header-name: _blank;

			    odd-footer-name: _blank;

			    even-footer-name: _blank;

			}

			div.chapter2 {

			    page-break-before: right;

			    page: chapter2;

			}

			div.noheader {

			    page-break-before: right;

			    page: noheader;

			}

	</style>

	</head>

	<body>
<!-- diseño encabezado pie de pagina -->		
	<htmlpageheader name="myHeader1" style="display:none">

		<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt;
	    color: #000000; font-weight: bold; font-style: italic;">
	    <tr>

	    <td width="33%"><span style="font-weight: bold; font-style: italic;">
	    
	    <IMG SRC="../../../../img/msp.jpg" WIDTH="110" HEIGHT="30">

	    </span></td>

	    <td width="5%" align="center" style="font-weight: bold; font-style: italic;"></td>

	    <td width="60%" style="text-align: right; "><h3>'.$Con->entidad.'</h3></td>

	    </tr></table>

	</htmlpageheader>

	<htmlpagefooter name="myFooter1" >

		<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt;

	    color: #000000; font-weight: bold; font-style: italic;">
	    <tr>

	    <td width="30%"><span style="font-weight: bold; font-style: italic;"></td>

	    <td width="30%" align="center" style="font-weight: bold; font-style: italic;"></td>

	    <td width="40%" >FIRMA Y SELLO DE QUÍN INFORMA</td>

	    </tr></table>
	</htmlpagefooter>

<div class="noheader"><br>
<!-- primera hoja  -->
<br>
	<table width="100%">
		<tr>
			<td>
			<H3><center>FORMULARIO DE INFORMACIÓN AL PACIENTE </center><H3> 
			<td>			
		</tr>
	</table>
	<br>
	<table width="100%">
		
		<tr>	
			<td width="30%">
				<h4>Nombre del informante :</h4> 
			<td>	
			<td width="70%">
				<font size="3">'.($per[0]["informante"] ?? '').'</font>
			<td>	
		</tr>
		<tr>	
			<td width="30%">
				<h4> Nombre del Paciente :</h4> 
			<td>	
			<td width="70%">
				<font size="3">'.($per[0]["paciente"] ?? '').'</font>
			<td>	
		</tr>
	</table>
	<br>
	<table width="100%">
		<tr>
		<td width="33%"><span style="font-weight: bold; font-style: italic;"><H4><b>CUIDADOS ESPECIALES:</b><h4></span></td>
		</tr>
		<tr>
			<td height="100" VALIGN="TOP">
			   <font size="3">'.($per[0]["inp_cuides"] ?? '').'</font>
			</td>
		</tr>
	</table><br>
	<table  width="100%">
		<tr>
			<td width="33%"><span style="font-weight: bold; font-style: italic;"><H4><b>ASEO : </b><h4></span></td>
		</tr>
		<tr>
			<td height="100" VALIGN="TOP">
				 <font size="3">'.($per[0]["inp_aseo"] ?? '').'</font>
			</td>
		</tr>
	</table><br>
	<table width="100%">
		<tr>
	     <td width="33%" ><span style="font-weight: bold; font-style: italic;"><H4><b>REPOSO : </b><h4></span></td>
			h4></td>	
		</tr>
		<tr>
			<td height="100" VALIGN="TOP">
				 <font size="3">'.($per[0]["inp_reposo"] ?? '').'</font>
			</td>
				
		</tr>
	</table>
    <table width="100%">
		<tr>
	     <td width="33%" ><span style="font-weight: bold; font-style: italic;"><H4><b>ALIMENTACIÓN : </b><h4></span></td>
			h4></td>	
		</tr>
		<tr>
			<td height="100" VALIGN="TOP">
			 <font size="3">'.($per[0]["inp_alimen"] ?? '').'</font>
			</td>
				
		</tr>
	</table>
	<table width="100%">
		<tr>
	     <td width="33%" ><span style="font-weight: bold; font-style: italic;"><H4><b>LO QUE DEBE HACER :</b><h4></span></td>
			h4></td>	
		</tr>
		<tr>
			<td height="100" VALIGN="TOP">
			 <font size="3">'.($per[0]["inp_ldhace"] ?? '').'</font>
			</td>
				
		</tr>
	</table>
	<table width="100%">
		<tr>
	     <td width="33%" ><span style="font-weight: bold; font-style: italic;"><H4><b>COMO DEBEN TOMAR SUS MEDICAMENTOS :</b><h4></span></td>
			h4></td>	
		</tr>
		<tr>
			<td height="100" VALIGN="TOP">
			 <font size="3">'.($per[0]["inp_indica"] ?? '').'</font>
			</td>
				
		</tr>
	</table>
	</div>
	<table width="100%">
		
	<tr>	
		<td width="60%" ><span style="font-weight: bold; font-style: italic;"><H4><b>FECHA DE CITA MÉDICA :</b><h4></span></td>
		<td width="40%" > <font size="3">'.($per[0]["inp_fpcita"] ?? '').'</font></td>	
	</tr>
	<tr>	
		<td width="60%" ><span style="font-weight: bold; font-style: italic;"><H4><b>AQUIÉN LLAMAR EN CASO DE NECESIDAD : </b><h4></span></td>
		<td width="40%" > <font size="3">'.($per[0]["inp_llamar"] ?? '').'911</font></td>
	</tr>
</table>
	
	
	</body> 
	</html>
';
// CREACIÓN DE PDF 
//$mpdf= new mPDF('c','A4','10.5','arial');
$mpdf->writeHTML($html);
$mpdf->Output('INFORMACION AL PACIENTE.pdf','I');
?>