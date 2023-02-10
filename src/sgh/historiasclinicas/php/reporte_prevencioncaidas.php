<?php
require_once("../../../../js/lib/mpdf-6.1.3/mpdf.php");
include_once("../../../../php/class_consulta.php");
$Con=New Consulta();
$ConAC=New Consulta();
$ConDE=New Consulta();
$ConMT=New Consulta();
$hce_id_pk=$_GET['h'];
// CONSULTAS DE REPORRTE
	# CARGAR DATOS DE ENCABEZADO. array 0
		$per=$Con->Get_Consulta("sgh_ped_caidaspa ep
		join sga_adm_historiaclinica as h on ep.hce_id_fk=h.hce_id_pk
		join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
		join sga_adm_persona as  per on p.per_id_fk=per.per_id_pk
    join sga_adm_cama as ca on ep.cam_id_fk=ca.cam_id_pk
    join sga_adm_tipocama as ser on ca.tca_serv_fk=ser.tca_id_pk","rcp_id_pk,per_nombres || '' ||per_apellidopaterno ||' '|| coalesce(per_apellidomaterno,'')  as persona, cam_codigo as cama , tca_descripcion as servicio,per_numeroidentificacion","","hce_id_pk",$hce_id_pk,2);
	# CARGAR DATOS DE caidas. array 0
$prc=$ConAC->Get_Consulta("sgh_ped_caidaspa ","*","","hce_id_fk",$hce_id_pk,2);		
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
			  margin: 33mm 7mm 15mm 7mm ; 
			    odd-header-name: html_myHeader1;

			  even-header-name: html_myHeader2;

			  odd-footer-name: html_myFooter1;

			  even-footer-name: html_myFooter2;

			}
				@page noheader {    

			    odd-header-name: _blank;

			    even-header-name: _blank;

			    odd-footer-name: _blank;

			    even-footer-name: _blank;

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

		<table width="100%" border="1" cellspacing="0" cellpadding="2">
	    <tr>

		    <td width="50%" rowspan="2"  align="center" >
			    <IMG SRC="../../../../img/logo.png" WIDTH=150 HEIGHT=50>
		    </td>
		    <td width="10%" align="center"></td>
		    <td width="25%" style="text-align: center;"></td>
	    </tr>
	    <tr>
	    <td width="10%" align="center">Versión</td>
		    <td width="20%" >0</td>
	    </tr>
	    <tr>
	    	<td align="center"> <b>Escala de valoración de riesgo de Macdems</b><td/>
	        <td width="10%" align="center">Fecha</td>
		    <td width="20%" style="text-align: center; "></td>
	    </tr>
	    
	    </table>

	</htmlpageheader>

	<htmlpagefooter name="myFooter1" style="display:none">
		<table>
		<tr>
			<td>
			<font size="2" >
 		             Fuente: Manual Técnico de seguridad de paciente,  MSP, 2017 <br>
                    Elaborado por : Comite tecnico de seguridad de paciente  <br>
 	</font> 
			</td>
		</tr>
		</table>
	</htmlpagefooter>
<!-- primera hoja  -->
<div class="header">
	<table width="100%">	
		<tr>	
			<td  width="50%">
				<font size="4"><b>Servicio : </b>'.$per[0]["servicio"].'</font>
			</td>
			<td  width="50%">
				<font size="4"><b>Cama : </b> '.$per[0]["cama"].'</font>
			</td>		
		</tr>
		<tr>	
			<td  width="50%">
				<font size="4"><b> Nombre y Apellido : </b>'.$per[0]["persona"].'</font>
			</td>
			<td  width="50%">
				<font size="4"><b>Historia Clìnica :  </b>'.$per[0]["per_numeroidentificacion"].'
			</td>		
		</tr>
		
	</table><br>
	<table width="100%">
		<tr>
			<td>
			   <H4>ESCALA DE MACDEMS<H4>
			</td>
		</tr>
	</table><br>
	<table width="100%" border="1" cellspacing="0" cellpadding="2" align="center">
	    <tr>
	        <td colspan="15" align="center">
	            VARIABLES 
	        </td>
	        <td align="center" colspan="2">
	            INGRESO HOSPITALIZACIÓN 
	        </td>
	    </tr>
	    <tr>
	        <td colspan="5" align="center">
	          <font size="2">Edad</font>
	        </td>
	        <td colspan="2" align="center">
	          <font size="2">Antecedentes de caídas previas</font>
	        </td>
	        <td colspan="6" align="center">
	          <font size="2">Antecedentes</font>
	        </td>
	        <td colspan="2" align="center">
	          <font size="2">Compromiso de conciencia</font>
	        </td>
	        
	        <td align="center" rowspan="2">
	              <font size="2">Putaje Obtenido</font>
	        </td>
	         <td align="center" rowspan="2">
	              <font size="2">Fecha</font>
	        </td>
	    </tr>
	    <tr>
	        <td align="center">
	          <font size="2" >Recién Nacido</font>
	        </td>
	        <td align="center">
	          <font size="2" >Lactante Menor</font>
	        </td>
	        <td align="center">
	          <font size="2" >Lactante Mayor</font>
	        </td>
	        <td align="center">
	          <font size="2" >Pre Escolar</font>
	        </td>
	        <td align="center">
	             <font size="2" >Escolar</font>
	        </td>
	        <td align="center">
	          <font size="2" >Si</font>
	        </td>
	        <td align="center">
	             <font size="2" >No</font>
	        </td>
	         <td align="center">
	          <font size="2" >Hiperactividad</font>
	        </td>
	        <td align="center">
	          <font size="2" >Problemas Neuromusculares</font>
	        </td>
	        <td align="center">
	          <font size="2" >Síndrome Convulsivo</font>
	        </td>
	        <td align="center">
	          <font size="2" >Daño orgánico cerebral</font>
	        </td>
	        <td align="center">
	             <font size="2" >Otros</font>
	        </td>
	        	        <td align="center">
	          <font size="2" >Sin antecedentes</font>
	        </td>
	           <td align="center">
	             <font size="2" >si</font>
	        </td>
	        <td align="center">
	          <font size="2" >no</font>
	        </td>
	    </tr>
	    ';
		for ($i=0; $i <count($prc) ; $i++) {

		 $html.=' 
    <tr> 
		 <td  class="width-20-pct"><font SIZE=1>'.$prc[$i]["rcp_renaci"].'</font><center>
    	 <td  class="width-20-pct"><font SIZE=1>'.$prc[$i]["rcp_lacmen"].'</font><center>
    	
        <td  class="width-20-pct"><font SIZE=1>'.$prc[$i]["rcp_lacmay"].'</font><center>
    
        <td  class="width-20-pct"><font SIZE=1>'.$prc[$i]["rcp_preescola"].'</font><center>
    		
        <td  class="width-20-pct"><font SIZE=1>'.$prc[$i]["rcp_escola"].'</font><center>
    	
        <td  class="width-20-pct"><font SIZE=1>'.$prc[$i]["rcp_si"].'</font><center>
    
        <td  class="width-20-pct"><font SIZE=1>'.$prc[$i]["rcp_no"].'</font><center>
    	
        <td  class="width-20-pct"><font SIZE=1>'.$prc[$i]["rcp_hipera"].'</font><center>
    
        <td  class="width-20-pct"><font SIZE=1>'.$prc[$i]["rcp_proneu"].'</font><center>
    
        <td  class="width-20-pct"><font SIZE=1>'.$prc[$i]["rcp_sincon"].'</font><center>
    	
        <td  class="width-20-pct"><font SIZE=1>'.$prc[$i]["rcp_daorce"].'</font><center>
    	
        <td  class="width-20-pct"><font SIZE=1>'.$prc[$i]["rcp_otros"].'</font><center>
    	
        <td  class="width-20-pct"><font SIZE=1>'.$prc[$i]["rcp_sinant"].'</font><center>
    	
        <td  class="width-20-pct"><font SIZE=1>'.$prc[$i]["rcp_sicoco"].'</font><center>
    	
        <td  class="width-20-pct"><font SIZE=1>'.$prc[$i]["rcp_nococo"].'</font><center>
             ';
		    	$total=
						$prc[$i]["rcp_renaci"]+
						$prc[$i]["rcp_lacmen"]+
						$prc[$i]["rcp_lacmay"]+
						$prc[$i]["rcp_preescola"]+
						$prc[$i]["rcp_escola"]+
						$prc[$i]["rcp_si"]+
						$prc[$i]["rcp_no"]+
						$prc[$i]["rcp_hipera"]+
						$prc[$i]["rcp_proneu"]+
						$prc[$i]["rcp_sincon"]+
						$prc[$i]["rcp_daorce"]+
						$prc[$i]["rcp_otros"]+
						$prc[$i]["rcp_sinant"]+
						$prc[$i]["rcp_sicoco"]+
						$prc[$i]["rcp_nococo"];

		 $html.='
        <th  class="width-20-pct"><font SIZE=2>'.$total.'</font><center></th>
        <td class="width-20-pct" align="center"><font size=2>'.$prc[$i]["rcp_matano"].' <br> '.$prc[$i]["rcp_fecha"].'</font></td>
        	';
        }
    $html.='
</tr>
</table>

</div>	
	</body> 
	</html>

';
// CREACIÓN DE PDF 
$mpdf= new mPDF('c','A4-L','','arial');
$mpdf->writeHTML($html);
$mpdf->Output('PREVENCION DE CAIDAS.pdf','I');
?>