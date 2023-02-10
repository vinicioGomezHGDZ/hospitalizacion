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
$fecha=$_GET['f'];
// CONSULTAS DE REPORRTE
	# CARGAR DATOS DE ENCABEZADO. array 0
		$per=$Con->Get_Consulta("sgh_mei_downto ep
		join sga_adm_historiaclinica as h on ep.hce_id_fk=h.hce_id_pk
		join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
		join sga_adm_persona as  per on p.per_id_fk=per.per_id_pk
    join sga_adm_cama as ca on ep.cam_id_fk=ca.cam_id_pk
    join sga_adm_tipocama as ser on ca.tca_serv_fk=ser.tca_id_pk","per_nombres || '' ||per_apellidopaterno ||' '|| per_apellidomaterno  as persona, cam_codigo as cama , tca_descripcion as servicio,per_numeroidentificacion","","hce_id_fk",$hce_id_pk,2);
	# CARGAR DATOS DE caidas. array 0
$prc=$ConAC->Get_Consulta("sgh_mei_downto ","*","","dsd_fehca>='".$fecha."' and hce_id_fk",$hce_id_pk,2);
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
	    	<td align="center"> <b>Estrategia de Prevencion de caídas</b><td/>
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
				<font size="4"><b>Servicio : </b>'.($per[0]["servicio"] ?? '') .'</font>
			</td>
			<td  width="50%">
				<font size="4"><b>Cama : </b> '.($per[0]["cama"] ?? '') .'</font>
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
			   <H4>ESCALA DE DOWNTON (Paciente Adulto)<H4>
			</td>
		</tr>
	</table><br>
	<table width="100%" border="1" cellspacing="0" cellpadding="2" align="center">
	    <tr>
	        <td colspan="19" align="center">
	          <font size=3>  VARIABLES </font>
	        </td>
	        <td align="center" colspan="2">
	           <font size=3> INGRESO HOSPITALIZACIÓN </font>
	        </td>
	    </tr>
	    <tr>
	        <td colspan="2" align="center">
	          <font size="2">Caídas Previas</font>
	        </td>
	        <td colspan="7" align="center">
	          <font size="2">Uso de medicamentos</font>
	        </td>
	        <td colspan="4" align="center">
	          <font size="2">Déficit Sensorial</font>
	        </td>
	        <td colspan="2" align="center">
	          <font size="2">Estado Mental</font>
	        </td>
	        <td colspan="4" align="center">
	              <font size="2">Deambulación</font>
	        </td>
	        <td align="center" rowspan="2">
	              <font size="2">Putaje <br> Obtenido</font>
	        </td>
	         <td align="center" rowspan="2">
	              <font size="2">Fecha</font>
	        </td>
	    </tr>
	    <tr>
	        <td align="center">
	          <font size="2" >No</font>
	        </td>
	        <td align="center">
	          <font size="2" >Si</font>
	        </td>
	        <td align="center">
	          <font size="2" >Ninguno</font>
	        </td>
	        <td align="center">
	          <font size="2" >Tranquilizantes - sedantes</font>
	        </td>
	        <td align="center">
	             <font size="2">Diuréticos</font>
	        </td>
	        <td align="center">
	          <font size="2" >Hipontesores(no diuréticos)</font>
	        </td>
	        <td align="center">
	             <font size="2" >Anti parkinsonianos</font>
	        </td>
	          <td align="center">
	             <font size="2" >Antidepresivo</font>
	        </td>
	         <td align="center">
	          <font size="2" >Otros medicamentos</font>
	        </td>
	        <td align="center">
	          <font size="2" >Ninguno</font>
	        </td>
	        <td align="center">
	          <font size="2" >Alteraciones visuales</font>
	        </td>
	        <td align="center">
	          <font size="2" >Alteraciones auditivas</font>
	        </td>
	        <td align="center">
	             <font size="2" >Extremidades</font>
	        </td>
	        	        <td align="center">
	          <font size="2" >Orientado</font>
	        </td>
	           <td align="center">
	             <font size="2" >Confuso</font>
	        </td>
	        <td align="center">
	          <font size="2" >Normal</font>
	        </td>
	       <td align="center">
	          <font size="2" >Segura con ayuda</font>
	        </td>   
	        <td align="center">
	          <font size="2" >Insegura con ayuda</font>
	        </td>   
	        <td align="center">
	          <font size="2" >No deambula</font>
	        </td>  
	    </tr>
	    ';
		for ($i=0; $i <count($prc) ; $i++) {

		 $html.=' 
    <tr> 
		 <td  class="width-20-pct"><font SIZE=1>'.($prc[$i]["dsd_no"] ?? '') .'</font><center>
    	 <td  class="width-20-pct"><font SIZE=1>'.($prc[$i]["dsd_si"] ?? '') .'</font><center>
    	
        <td  class="width-20-pct"><font SIZE=1>'.($prc[$i]["dsd_ninguna"] ?? '') .'</font><center>
    
        <td  class="width-20-pct"><font SIZE=1>'.($prc[$i]["dsd_tranqu"] ?? '') .'</font><center>
    		
        <td  class="width-20-pct"><font SIZE=1>'.($prc[$i]["dsd_diuret"] ?? '') .'</font><center>
    	
        <td  class="width-20-pct"><font SIZE=1>'.($prc[$i]["dsd_hipote"] ?? '') .'</font><center>
    
        <td  class="width-20-pct"><font SIZE=1>'.($prc[$i]["dsd_antpar"] ?? '') .'</font><center>    	
        <td  class="width-20-pct"><font SIZE=1>'.($prc[$i]["dsd_antide"] ?? '') .'</font><center>
    
        <td  class="width-20-pct"><font SIZE=1>'.($prc[$i]["dsd_otrmed"] ?? '') .'</font><center>
    
        <td  class="width-20-pct"><font SIZE=1>'.($prc[$i]["dsd_ningun"] ?? '') .'</font><center>
    	
        <td  class="width-20-pct"><font SIZE=1>'.($prc[$i]["dsd_altvis"] ?? '') .'</font><center>
    	
        <td  class="width-20-pct"><font SIZE=1>'.($prc[$i]["dsd_altaud"] ?? '') .'</font><center>
    	
        <td  class="width-20-pct"><font SIZE=1>'.($prc[$i]["dsd_extrem"] ?? '') .'</font><center>
    	
        <td  class="width-20-pct"><font SIZE=1>'.($prc[$i]["dsd_orient"] ?? '') .'</font><center>
    	
        <td  class="width-20-pct"><font SIZE=1>'.($prc[$i]["dsd_confus"] ?? '') .'</font><center>

        <td  class="width-20-pct"><font SIZE=1>'.($prc[$i]["dsd_normal"] ?? '') .'</font><center>

        <td  class="width-20-pct"><font SIZE=1>'.($prc[$i]["dsd_segayu"] ?? '') .'</font><center>

        <td  class="width-20-pct"><font SIZE=1>'.($prc[$i]["dsd_insayu"] ?? '') .'</font><center>
         <td  class="width-20-pct"><font SIZE=1>'.($prc[$i]["dsd_nodeam"] ?? '') .'</font><center>
             ';
		    	$total=
						$prc[$i]["dsd_no"]+
						$prc[$i]["dsd_si"]+
						$prc[$i]["dsd_ninguna"]+
						$prc[$i]["dsd_tranqu"]+
						$prc[$i]["dsd_diuret"]+
						$prc[$i]["dsd_hipote"]+
						$prc[$i]["dsd_antpar"]+
						$prc[$i]["dsd_antide"]+
						$prc[$i]["dsd_otrmed"]+
						$prc[$i]["dsd_ningun"]+
						$prc[$i]["dsd_altvis"]+
						$prc[$i]["dsd_altaud"]+
						$prc[$i]["dsd_extrem"]+
						$prc[$i]["dsd_orient"]+
						$prc[$i]["dsd_confus"]+
						$prc[$i]["dsd_normal"]+
						$prc[$i]["dsd_segayu"]+
						$prc[$i]["dsd_insayu"]+
						$prc[$i]["dsd_nodeam"]
						
						;

		 $html.='
        <th  class="width-20-pct"><font SIZE=2>'.$total.'</font><center></th>
        <td class="width-20-pct" align="center"><font size=2>'.($prc[$i]["dsd_matano"] ?? '') .' <br> '.($prc[$i]["dsd_fehca"] ?? '') .'</font></td>
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
$mpdf->Output('PREVENCION DE CAIDAS.pdf','I');
?>