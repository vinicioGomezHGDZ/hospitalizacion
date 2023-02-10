<?php
require_once("../../../../js/lib/mpdf-6.1.3/mpdf.php");
include_once("../../../../php/class_consulta.php");
$Contr=New Consulta();
$hce_id_fk=$_GET['h'];
//$mpdf->useOddEven = 1;
$tras=$Contr->Get_Consulta("sgh_mei_tpansfe where hce_id_fk='".$hce_id_fk."' ORDER BY tpa_fecha DESC ","tpa_id_pk,tpa_fecha ","","","",5);

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
			  margin: 7mm 7mm 7mm 7mm ; 
			  
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
';
for ($r=0; $r <count($tras) ; $r++) {
    $Con='Con'.$r;
    $$Con=New Consulta();

    $tpa_id_pk=$tras[$r]["tpa_id_pk"];

// CONSULTAS DE REPORRTE
    # CARGAR DATOS DE ENCABEZADO. array 0
    $per=$$Con->Get_Consulta("sgh_mei_tpansfe ep
		join sga_adm_historiaclinica as h on ep.hce_id_fk=h.hce_id_pk
		join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
		join sga_adm_persona as  pas on p.per_id_fk=pas.per_id_pk
    join sgu_usu_usuario as usu on ep.usu_id_fk=usu_id_pk
    JOIN sga_adm_profesional as pro on usu.pro_id_fk=pro_id_pk
    join sga_adm_persona as profe on pro.per_id_fk=profe.per_id_pk","pas.per_nombres || ' '||pas.per_apellidopaterno ||' '|| coalesce(pas.per_apellidomaterno,'')  as paciente,
  date_part('year',age(pas.per_fechanacimiento)) || ' Años '||date_part('mons',age(pas.per_fechanacimiento)) ||' Meses '|| date_part('days',age(pas.per_fechanacimiento)) || ' Días' as Edad,pas.per_numeroidentificacion
  ,ep.tpa_diagno,tpa_situas,tpa_antece,tpa_evalua,tpa_recome,tpa_punori,tpa_puntra,
   profe.per_nombres || ' '||profe.per_apellidopaterno ||' '|| coalesce(profe.per_apellidomaterno,'')  as profecional,tpa_fecha","","tpa_id_pk",$tpa_id_pk,2);

    $html.='

<htmlpageheader name="myHeader1" style="display:none">

		

	</htmlpageheader>

<htmlpagefooter name="Chapter2FooterOdd" style="display:none">
	<table>
		<tr>
			<td>
			<font size="2" >
 		
 		</font>	
			</td>
		</tr>
		<tr>
			<td>
			</td>
		</tr>
		<tr>
		 <td width="100%" style="text-align: justify; ">
		
		</td></tr>
 	</table>
	</htmlpagefooter>
	
<div class="chapter2"><table width="100%" border="1" cellspacing="0" cellpadding="2">
	    <tr>

		    <td width="50%" rowspan="2"  align="center" >
			    <IMG SRC="../../../../img/logo.png" WIDTH=150 HEIGHT=50>
		    </td>
		    <td width="10%" align="center">Código</td>
		    <td width="25%" style="text-align: center; ">Anexo 1 PSQ 721.001-REA-A</td>
	    </tr>
	    <tr>
	    <td width="10%" align="center">Versión</td>
		    <td width="20%" style="text-align: center; ">0</td>
	    </tr>
	    <tr>
	    	<td align="center"> <b>Tansferencia de información de clientes en puntos de transición.</b><td/>
	        <td width="10%" align="center">Fecha</td>
		    <td width="20%" style="text-align: center; ">'.$per[0]["tpa_fecha"].' </td>
	    </tr>
	    
	    </table>
	    <br><br><br><br>
<!-- primera hoja  -->

	<table width="100%">
		<tr>
			<th>
			   <H4><center>FORMULARIO DE TRANSFERENCIA DE PACIENTE EN PUNTOS DE <br>TRANSICIÓN - TÉCNICA SAER</center><H4>

			<th>
		</tr>
	</table>
	<table width="100%">	
		<tr>	
			<td  width="50%">
				<font size="4"><b>Institución: </b>Hospital General Santo Dominog</font>
			</td>
			<td  width="50%">
				<font size="4"><b>Unidad : </b></font>
			</td>		
		</tr>
		<tr>	
			<td  width="50%">
				<font size="4"><b> Paciente : </b>'.$per[0]["paciente"].'</font>
			</td>
			<td  width="50%">
				<font size="4"><b>Edad :  </b>'.$per[0]["edad"].'
			</td>		
		</tr>

		<tr>	
			<td width="50%">
				<font size="4"><b>Diagnóstico: </b>'.$per[0]["tpa_diagno"].'</font>
			</td>
			<td width="50%">
				<font size="4"><b>H. Clinica : </b>'.$per[0]["per_numeroidentificacion"].'</font>
			</td>	
		</tr>
	</table>
	<br>
	<table border="1" width="100%" cellspacing="0" cellpadding="2">
		<tr>
			<td width="350" HEIGHT="50">
			<font size=4 >TECNICA SAER</font>
			</td>
			<td colspan=2>
			<font size=4>ANALISIS</font>
			</td>
		</tr>
		<tr>
			<td HEIGHT="70"><font size=3><b> (S) Situacióon</b><br>Que ocurre en ese momento ? </font></td>
			<td colspan=2><font size=2>'.$per[0]["tpa_situas"].'</font></td>
		</tr>
		<tr>
			<td HEIGHT="70"><font size=3><b> (A) Antecedentes </b><br>Que circunstancias llevaron a esta situación ?</font></td>
			<td colspan=2><font size=2>'.$per[0]["tpa_antece"].'</font></td>
		</tr>
		<tr>
			<td HEIGHT="70"><font size=3><b> (E) Evaluación </b><br>Que piensa que pueda ocurrir</font></td>
			<td colspan=2><font size=2>'.$per[0]["tpa_evalua"].'</font></td>
		</tr>
		<tr>
			<td HEIGHT="70"><font size=3><b> (R) Recomendación </b><br>Que debemos hacer para corregir</font></td>
			<td colspan=2><font size=2>'.$per[0]["tpa_recome"].'</font></td>
		</tr>
		<tr>
			<td colspan="3" HEIGHT="30">

			</td>
		</tr>
		</table>
		<table border="1" width="100%" cellspacing="0" cellpadding="2">
		<tr>
			<td>Responsables</td> <td>Punto de origen-hora</td> <td>Punto de transición-hora</td>
		</tr>
		<tr>
			<td><font size=2>'.$per[0]["profecional"].'</font> </td> 
			<td><font size=2>'.$per[0]["tpa_punori"].'</font></td> 
			<td><font size=2>'.$per[0]["tpa_puntra"].'</font></td>
		</tr>
	</table>
	<br><br>
	<br><br>
	<br><br>
	 <font size="2" >
 		             Fuente: Manual Técnico de seguridad de paciente,  MSP, 2017 <br>
                    Elaborado por : Comite tecnico de seguridad de paciente  <br>
 	</font>  
</div>
';
}
$html.='
	</body> 
	</html>

';
// CREACIÓN DE PDF 
$mpdf= new mPDF('c','A4','','arial');
$mpdf->writeHTML($html);
$mpdf->Output('Transferencia de Paciente.pdf','I');
?>