<?php
require_once '../../../../vendor/autoload.php';
include_once("../../../../php/class_consulta.php");
use Mpdf\Mpdf;
$mpdf = new mPDF(['debug' => true,'mode'=>'utf-8','format'=>'A4']);


$Con=New Consulta();
$ConAC=New Consulta();
$ConDE=New Consulta();
$ConMT=New Consulta();
$hce_id_pk=$_GET['h'];
$fi=$_GET['fi'];
$fa=$_GET['fa'];
$entidad=$Con->entidad;
// CONSULTAS DE REPORRTE
	# CARGAR DATOS DE ENCABEZADO. array 0
		$per=$Con->Get_Consulta("sgh_mei_wells ep
		join sga_adm_historiaclinica as h on ep.hce_id_pk=h.hce_id_pk
		join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
		join sga_adm_persona as  per on p.per_id_fk=per.per_id_pk","per_nombres || '' ||per_apellidopaterno ||' '|| per_apellidomaterno  as persona,per_numeroidentificacion
		","","ep.hce_id_pk",$hce_id_pk,2);
	# CARGAR DATOS DE caidas. array 0
$prc=$ConAC->Get_Consulta("sgh_mei_wells where wel_fecha>='$fi' and wel_fecha<='$fa' and hce_id_pk='$hce_id_pk' ORDER BY wel_fecha DESC","*","","","",5);
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
			<IMG SRC="../../../../img/msp.jpg" WIDTH="150" HEIGHT="50">
		    </td>
		    <td width="10%" align="center"></td>
		    <td width="25%" style="text-align: center;"></td>
	    </tr>
	    <tr>
	    <td width="10%" align="center">Versión</td>
		    <td width="20%" >0</td>
	    </tr>
	    <tr>
	    	<td align="center"> <b></b><td/>
	        <td width="10%" align="center">Fecha</td>
		    <td width="20%" style="text-align: center; ">'.date("d").'/'.date("m").'/'.date("Y").'</td>
	    </tr>
	    
	    </table>

	</htmlpageheader>

	<htmlpagefooter name="myFooter1" style="display:none">
		<table>
		<tr>
			<td>
			<font size="2" >
 		             Fuente: Manual Técnico de seguridad de paciente,  MSP, '.date("Y").' <br>
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
				<font size="4"><b>Institución : </b>'.$entidad.'</font>
			</td>
					
		</tr>
		<tr>	
			<td  width="50%">
				<font size="4"><b> Nombre y Apellido : </b>'.($per[0]["persona"] ?? '') .'</font>
			</td>
			<td  width="50%">
				<font size="4"><b>Historia Clìnica :  </b>'.($per[0]["per_numeroidentificacion"] ?? '') .'
			</td>		
		</tr>
		
	</table><br>
	<table width="100%">
		<tr>
			<td>
			   <H4>ESCALA DE WELLS<H4>
			</td>
		</tr>
	</table><br>
	<table width="100%" border="1" cellspacing="0" cellpadding="2" align="center">
	    <tr>
	        <td colspan="9" align="center">
	          <font size=3>  VARIABLES </font>
	        </td>
	        <td align="center" colspan="2">
	           <font size=3> INGRESO HOSPITALIZACIÓN </font>
	        </td>
	    </tr>
	    <tr>
	       Totales	
			<td>
			Neoplasia activa:	
			</td>
			<td>
			Parálisis, paresia o reciente inmovilización con yeso de Extremidad Inferior:	
			</td>
			<td>
			Estancia en cama reciente por más de 3 días reciente o cirugía mayor en las últimas 4 semanas:	
			</td>
			<td>
			Molestias a lo largo del trayecto del sistema venoso profundo:	
			</td>
			<td>
			Edema de toda la pierna:	
			</td>
			<td>
			Aumento del perímetro de la pantorrilla de más de 3 cm respecto a la pierna contralateral:	
			</td>
			<td>
			Edema con fóvea mayor en la pierna sintomática:	
			</td>
			<td>
			Venas colaterales superficiales (no varicosas):	
			</td>
			<td>
			Otro diagnóstico alternativo tanto o más probable que la TVP:	
			</td>
				        <td align="center" >
	              <font size="2">Putaje <br> Obtenido</font>
	        </td>
	         <td align="center">
	              <font size="2">Fecha</font>
	        </td>

	    </tr>
	    ';
		for ($i=0; $i <count($prc) ; $i++) {

		 $html.=' 
    <tr> 
		 <td  class="width-20-pct"><font SIZE=1>'.($prc[$i]["wel_neopla"] ?? '') .'</font><center>
    	 <td  class="width-20-pct"><font SIZE=1>'.($prc[$i]["wel_parali"] ?? '') .'</font><center>
    	
        <td  class="width-20-pct"><font SIZE=1>'.($prc[$i]["wel_estanc"] ?? '') .'</font><center>
    
        <td  class="width-20-pct"><font SIZE=1>'.($prc[$i]["wel_molest"] ?? '') .'</font><center>
    		
        <td  class="width-20-pct"><font SIZE=1>'.($prc[$i]["wel_edepie"] ?? '') .'</font><center>
    	
        <td  class="width-20-pct"><font SIZE=1>'.($prc[$i]["wel_aument"] ?? '') .'</font><center>
    
        <td  class="width-20-pct"><font SIZE=1>'.($prc[$i]["wel_edema"] ?? '') .'</font><center>
        <td  class="width-20-pct"><font SIZE=1>'.($prc[$i]["wel_venaco"] ?? '') .'</font><center>   
        <td  class="width-20-pct"><font SIZE=1>'.($prc[$i]["wel_otro"] ?? '') .'</font><center>        	
             ';
		    	$total=
					$prc[$i]["wel_neopla"]+
					$prc[$i]["wel_parali"]+
					$prc[$i]["wel_estanc"]+
					$prc[$i]["wel_molest"]+
					$Prc[$i]["wel_edepie"]+
					$prc[$i]["wel_aument"]+
					$prc[$i]["wel_edema"]+
					$prc[$i]["wel_venaco"]+
					$prc[$i]["wel_otro"]
						
						;

		 $html.='
        <th  class="width-20-pct"><font SIZE=2>'.$total.'</font><center></th>
        <td class="width-20-pct" align="center"><font size=2>'.($prc[$i]["wel_fecha"] ?? '') .'</font></td>
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
//$mpdf= new mPDF('c','A4-L','','arial');
$mpdf->writeHTML($html);
$mpdf->Output('Wells.pdf','I');
?>