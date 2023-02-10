<?php
require_once '../../../../vendor/autoload.php';
include_once("../../../../php/class_consulta.php");
use Mpdf\Mpdf;
$mpdf = new mPDF(['debug' => true,'mode'=>'utf-8','format'=>'A4']);
$Conin=New Consulta();
$hce_id_pk=$_GET['h'];
$fi=$_GET['fi'];
$fa=$_GET['fa'];
$infor = $Conin->Get_Consulta("sgh_mei_inforalpaci where inp_fecha >='$fi' and inp_fecha <='$fa' and hce_id_fk='".$hce_id_pk."' ORDER BY inp_fecha DESC","inp_id_pk,inp_fecha ", "", "", "", 5);

// CONSULTAS DE REPORRTE

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
               margin:8mm ;
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
	<htmlpagefooter name="Chapter2FooterOdd" style="display:none">

		<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt;

	    color: #000000; font-weight: bold; font-style: italic;">
	    <tr>

	    <td width="30%"><span style="font-weight: bold; font-style: italic;"></td>

	    <td width="30%" align="center" style="font-weight: bold; font-style: italic;"></td>

	    <td width="40%" style="text-align: right; ">FIRMA Y SELLO DE QUÍN INFORMA</td>

	    </tr></table>
	</htmlpagefooter>
';
for ($r=0; $r <count($infor) ; $r++) {
    $inp_id_pk = $infor[$r][inp_id_pk];
    $Con = 'Con' . $r;
    $$Con = New Consulta();

    # CARGAR DATOS DE ENCABEZADO. array 0
    $per = $$Con->Get_Consulta("sgh_mei_inforalpaci inf
     		 join sga_adm_historiaclinica as his on inf.hce_id_fk=his.hce_id_pk
      		JOIN sga_adm_paciente as pas  on his.pac_id_fk= pas.pac_id_pk
      		JOIN sga_adm_persona as peh  on pas.per_id_fk= peh.per_id_pk
      		JOIN sgu_usu_usuario as us on inf.usu_id_fk = us.usu_id_pk
			JOIN sga_adm_profesional as pr on us.pro_id_fk = pr.pro_id_pk
			JOIN sga_adm_persona as pe  on pr.per_id_fk= pe.per_id_pk
			JOIN sga_adm_profesion as pro on pr.prf_id_fk = pro.prf_id_pk", "(pe.per_apellidopaterno || coalesce(pe.per_apellidomaterno ||' ','')  || pe.per_nombres) AS informante,
  (peh.per_apellidopaterno || coalesce(peh.per_apellidomaterno ||' ','') || peh.per_nombres ) AS paciente
  ,inp_id_pk,inp_cuides,  regexp_replace(inp_aseo,'\n','<br>','g'),  regexp_replace(inp_reposo,'\n','<br>','g'),  regexp_replace(inp_alimen,'\n','<br>','g'),  regexp_replace(inp_ldhace,'\n','<br>','g'),  regexp_replace(inp_indica,'\n','<br>','g'),to_char(inp_fpcita,'dd-MM-YYYY') as inp_fpcita,inp_llamar,inp_fecha", "", "inp_id_pk", $inp_id_pk, 2);


    $html .= '
<div class="chapter2">

	<table width="100%">
		<tr>
			<th>
			   <H3><center>FORMULARIO DE INFORMACIÓN AL PACIENTE </center><H3> 
			<th>
		</tr>
		<tr>	
			<td>
				<h4>Nombre del informante :</h4> 
				<font size="3">'.($per[0]["informante"] ?? '') . '</font>
				<h4> Nombre del Paciente :</h4> 
				<font size="3">'.($per[0]["paciente"] ?? '') . '</font>
			<td>		
		</tr>
	</table>
	
	<table width="100%">
		<tr>
		<td width="33%"><span style="font-weight: bold; font-style: italic;"><H4><b>CUIDADOS ESPECIALES:</b><h4></span></td>
		</tr>
		<tr>
			<td height="100" VALIGN="TOP">
			   <font size="3">'.($per[0]["inp_cuides"] ?? '') . '</font>
			</td>
		</tr>
	</table><br>
	<table  width="100%">
		<tr>
			<td width="33%"><span style="font-weight: bold; font-style: italic;"><H4><b>ASEO : </b><h4></span></td>
		</tr>
		<tr>
			<td height="100" VALIGN="TOP">
				 <font size="3">'.($per[0]["inp_aseo"] ?? '') . '</font>
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
				 <font size="3">'.($per[0]["inp_reposo"] ?? '') . '</font>
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
			 <font size="3">'.($per[0]["inp_alimen"] ?? '') . '</font>
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
			 <font size="3">'.($per[0]["inp_ldhace"] ?? '') . '</font>
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
			 <font size="3">'.($per[0]["inp_indica"] ?? '') . '</font>
			</td>
				
		</tr>
	</table>
	</div>
<table width="100%">
		<tr>
	     <td width="50%" ><span style="font-weight: bold; font-style: italic;"><H4><b>FECHA DE CITA MÉDICA :</b><h4></span></td>
		
		</td>	
		 <td width="50%" > <font size="3">'.($per[0]["inp_fpcita"] ?? '') . '</font></td>
			
		</td>	
		</tr>
		<tr>
			<td width="50%" ><span style="font-weight: bold; font-style: italic;"><H4><b>AQUIÉN LLAMAR EN CASO DE NECESIDAD : </b><h4></span></td>
		
		</td>	
		 <td width="50%" > <font size="3">'.($per[0]["inp_llamar"] ?? '') . '911</font></td>
			
		</td>	
				
		</tr>
	</table>
	';
}
$hml.='
}
	</body> 
	</html>
';
// CREACIÓN DE PDF 
//$mpdf= new mPDF('c','A4','','arial');
$mpdf->writeHTML($html);
$mpdf->Output('INFORMACION AL PACIENTE','I');
?>