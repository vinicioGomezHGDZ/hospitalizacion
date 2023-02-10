<?php
require_once("../../../../js/lib/mpdf60/mpdf.php");
include_once("../../../../php/class_consulta.php");
$Con=New Consulta();
$Conbac=New Consulta();
$Consrv=New Consulta();
$Conhis=New Consulta();
$Convih=New Consulta();
$Conmic=New Consulta();
$hce_id_pk=$_GET['h'];
// CONSULTAS DE REPORRTE
	# CARGAR DATOS DE ENCABEZADO. array 0
	$Lab=$Con->Get_Consulta("sgh_sol_lab WHERE hce_id_fk='".$hce_id_pk."' ORDER BY lab_fecmu DESC","lab_fecmu,lab_resut","","","",5);
			//print_r($per);	
    $bac=$Conbac->Get_Consulta("sgh_sol_bacteriologico WHERE hce_id_fk='".$hce_id_pk."' ORDER BY bac_fecha DESC","bac_fecha,bac_result","","","",5);
    $serv=$Consrv->Get_Consulta("sgh_sol_cervicov WHERE hce_id_fk='".$hce_id_pk."' ORDER BY ccv_fetomu DESC","ccv_fetomu,ccv_result","","","",5);
    $hist=$Conhis->Get_Consulta("sgh_sol_histopa WHERE hce_id_fk='".$hce_id_pk."' ORDER BY his_fecha DESC","his_fecha,his_resul","","","",5);
    $vih=$Convih->Get_Consulta("sgh_sol_vih WHERE hce_id_fk='".$hce_id_pk."' ORDER BY vih_fecha DESC","vih_fecha,vih_result,vih_conce","","","",5);
    $mic=$Conmic->Get_Consulta("sgh_sol_microbiologico WHERE hce_id_fk='".$hce_id_pk."' ORDER BY mic_fecha DESC","mic_fecha,mic_result","","","",5);


//$mpdf->useOddEven = 1;
// HTML DE REPORTE 

$html2='

<html>
<head>
	<style>
			.th{
				   background: #99e6ff;
				   color: #000000;
				}

			@page {
			  size: auto;
               margin:5mm 5mm 5mm 5mm ; 
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
    <table width="100%" >
	    <tr>

	    <td width="33%"><span style="font-weight: bold; font-style: italic;">
	    
	    <IMG SRC="../../../../img/msp.jpg" WIDTH=110 HEIGHT=30>

	    </span></td>

	    <td width="33%" align="center" style="font-weight: bold; font-style: italic;"></td>

	    <td width="40%" style="text-align: right;"><h4>HOSPITAL GENERAL SANTODOMINGO</h4></td>

	    </tr>
	</table>	
	
	<table  width="100%">
		<tr>
			<th class="th" colspan="6">
			 Exámenes de laboratorio subidas
			</th>
        </tr>
        <tr>
		    <td valign="top"> 
		        <table>
		            <tr>
		                <th align="center" colspan="2">
		                  <font size="3">LABORATORIO CLÍNICO</font> 
		                </th>
		            </tr>
		            <tr>
		                <td class="" width=30><font size=3>Fecha </font> </td>
			            <td class="" width=30><font size=3>Archivo</font> </td>
		            </tr>';
                    for ($i=0; $i <count($Lab) ; $i++) {
                    $html2.='
                        <tr>
                    <td><font size=3>'.$Lab[$i]["lab_fecmu"].'</font> </td>
                    <td>
                          <a href="/archivos/sgh/laboratorio/'.$Lab[$i]["lab_resut"].'" target="_blank">
                             <img  class="puntero" src="../../../../img/pdfico.png" width="20" height="20">
                           </a>
                    </td>
                    </tr>';
                    }
                    $html2.='
		         </table>
		    </td>
		    
		    <td valign="top"> 
		        <table>
		            <tr>
		                <th align="center" colspan="2">
		                  <font size="3">BACTERIOLÓGICO DE TUBERCULOSIS</font> 
		                </th>
		            </tr>
		            <tr>
		                <td class="" width=30><font size=3>Fecha </font> </td>
			            <td class="" width=30><font size=3>Archivo</font> </td>
		            </tr>';
                    for ($i=0; $i <count($bac) ; $i++) {
                    $html2.='
                        <tr>
                    <td><font size=3>'.$bac[$i]["bac_fecha"].'</font> </td>
                    <td>
                          <a href="/archivos/sgh/laboratorio/'.$bac[$i]["bac_result"].'" target="_blank">
                             <img  class="puntero" src="../../../../img/pdfico.png" width="20" height="20">
                           </a>
                    </td>
                    </tr>';
                    }
                    $html2.='
		         </table>
		    </td>

            <td valign="top"> 
		        <table>
		            <tr>
		                <th align="center" colspan="2">
		                  <font size="3">CITOLOGÍA CERVICO VAGINAL</font> 
		                </th>
		            </tr>
		            <tr>
		                <td class="" width=30><font size=3>Fecha </font> </td>
			            <td class="" width=30><font size=3>Archivo</font> </td>
		            </tr>';
                    for ($i=0; $i <count($serv) ; $i++) {
                    $html2.='
                        <tr>
                    <td><font size=3>'.$serv[$i]["ccv_fetomu"].'</font> </td>
                    <td>
                          <a href="/archivos/sgh/laboratorio/'.$serv[$i]["ccv_result"].'" target="_blank">
                             <img  class="puntero" src="../../../../img/pdfico.png" width="20" height="20">
                           </a>
                    </td>
                    </tr>';
                    }
                    $html2.='
		         </table>
		    </td>
		    
		    <td valign="top"> 
		        <table>
		            <tr>
		                <th align="center" colspan="2">
		                  <font size="3">HISTOPATOLOGÍA</font> 
		                </th>
		            </tr>
		            <tr>
		                <td class="" width=30><font size=3>Fecha </font> </td>
			            <td class="" width=30><font size=3>Archivo</font> </td>
		            </tr>';
                    for ($i=0; $i <count($hist) ; $i++) {
                    $html2.='
                        <tr>
                    <td><font size=3>'.$hist[$i]["his_fecha"].'</font> </td>
                    <td>
                          <a href="/archivos/sgh/laboratorio/'.$hist[$i]["his_resul"].'" target="_blank">
                             <img  class="puntero" src="../../../../img/pdfico.png" width="20" height="20">
                           </a>
                    </td>
                    </tr>';
                    }
                    $html2.='
		         </table>
		    </td>
		    
		    <td valign="top"> 
		        <table>
		            <tr>
		                <th align="center" colspan="2">
		                  <font size="3">VIH/SIDA</font> 
		                </th>
		            </tr>
		            <tr>
		                <td class="" width=30><font size=3>Fecha </font> </td>
			            <td class="" width=30><font size=3>Archivo</font> </td>
		            </tr>';
                    for ($i=0; $i <count($vih) ; $i++) {
                    $html2.='
                        <tr>
                    <td><font size=3>'.$vih[$i]["vih_fecha"].'</font> </td>
                    <td>
                          <a href="/archivos/sgh/laboratorio/'.$vih[$i]["vih_result"].'" target="_blank">
                             <img  class="puntero" src="../../../../img/pdfico.png" width="20" height="20">
                           </a>
                    </td>
                    </tr>';
                    }
                    $html2.='
		         </table>
		    </td>
		    
		     <td valign="top"> 
		        <table>
		            <tr>
		                <th align="center" colspan="2">
		                  <font size="3">MICROBIOLÓGICO</font> 
		                </th>
		            </tr>
		            <tr>
		                <td class="" width=30><font size=3>Fecha </font> </td>
			            <td class="" width=30><font size=3>Archivo</font> </td>
		            </tr>';
                    for ($i=0; $i <count($mic) ; $i++) {
                    $html2.='
                        <tr>
                    <td><font size=3>'.$mic[$i]["mic_fecha"].'</font> </td>
                    <td>
                          <a href="/archivos/sgh/laboratorio/'.$mic[$i]["mic_result"].'" target="_blank">
                             <img  class="puntero" src="../../../../img/pdfico.png" width="20" height="20">
                           </a>
                    </td>
                    </tr>';
                    }
                    $html2.='
		         </table>
		    </td>
    </tr>	            
	</table>
	
</html>
';

// CREACIÓN DE PDF 
$mpdf= new mPDF('c','A4-L','','arial');
$mpdf->writeHTML($html2);
$mpdf->Output('Examenes.pdf','I');
?>