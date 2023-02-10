<?php
require_once '../../../../vendor/autoload.php';
include_once("../../../../php/class_consulta.php");
use Mpdf\Mpdf;
$mpdf = new mPDF(['debug' => true,'mode'=>'utf-8','format'=>'A4']);
$Conbra=New Consulta();
$entidad=$Conbra->entidad;
$hce_id_fk=$_GET['h'];
$fi=$_GET['fi'];
$fa=$_GET['fa'];
$brander=$Conbra->Get_Consulta("sgh_mei_branden where bra_fecha >='$fi' and bra_fecha<='$fa' and  hce_id_fk='".$hce_id_fk."' ORDER BY bra_fecha DESC","bra_id_pk,bra_fecha","","","",5);

// CONSULTAS DE REPORRTE
# CARGAR DATOS DE ENCABEZADO. array 0


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
			 

			}
	</style>

	</head>

	<body>
	';
for ($r=0; $r <count($brander) ; $r++) {
    $Con='Con'.$r;
    $ConAC='ConAC'.$r;

    $$Con=New Consulta();
    $$ConAC=New Consulta();

    $bra_id_pk=$brander[$r]["bra_id_pk"];

   $per=$$Con->Get_Consulta("sgh_mei_branden ep
		join sga_adm_historiaclinica as h on ep.hce_id_fk=h.hce_id_pk
		join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
		join sga_adm_persona as  per on p.per_id_fk=per.per_id_pk
    join sga_adm_cama as ca on ep.cam_id_fk=ca.cam_id_pk
    join sga_adm_tipocama as ser on ca.tca_serv_fk=ser.tca_id_pk","bra_id_pk,per_nombres || '' ||per_apellidopaterno ||' '|| per_apellidomaterno  as persona, cam_codigo as cama , tca_descripcion as servicio,per_numeroidentificacion","","bra_id_pk",$bra_id_pk,2);
# CARGAR DATOS DE ENCABEZADO. array 0
    $bra=$$ConAC->Get_Consulta("sgh_mei_branden","*","","bra_id_pk",$bra_id_pk,2);

$html.='
<!-- diseño encabezado pie de pagina -->		

<!-- primera hoja  -->
	<table width="100%" border="1" cellspacing="0" cellpadding="2">
	    <tr>

		    <td width="50%" rowspan="2"  align="center" >
			<IMG SRC="../../../../img/msp.jpg" WIDTH="150" HEIGHT="50">
		    </td>
		    <td width="10%" align="center">Código</td>
		    <td width="25%" style="text-align: center;"></td>
	    </tr>
	    <tr>
	    <td width="10%" align="center">Versión</td>
		    <td width="20%" ></td>
	    </tr>
	    <tr>
	    	<td align="center"> <b>Prevención Ulceras por Presión</b><td/>
	        <td width="10%" align="center">Fecha</td>
		    <td width="20%" style="text-align: center; ">'.($bra[0]["bra_fecha"] ?? '') .'</td>
	    </tr>
	    
	    </table>
<br><br>
	<table width="100%">	
		<tr>	
			<td  width="50%">
				<font size="4"><b>Servicio : </b>'.($per[0]["servicio"] ?? '') .'</font>
			</td>
			<td  width="50%">
				<font size="4"><b>Cama : </b>'.($per[0]["cama"] ?? '') .'</font>
			</td>		
		</tr>
		<tr>	
			<td  width="50%">
				<font size="4"><b> Nombre y Apellido : </b>'.($per[0]["persona"] ?? '') .'</font>
			</td>
			<td  width="50%">
				<font size="4"><b>Historia Clìnica : </b>'.($per[0]["per_numeroidentificacion"] ?? '') .' </font>
			</td>		
		</tr>
		
	</table><br>
	<table width="100%">
		<tr>
			<td>
			   <H4>ESCALA DE BRANDEN MODIFICADA<H4>

			</td>
		</tr>
	</table><br>
	<table border="1" cellspacing="0" cellpadding="2"  width="100%">
		<tr>
			<th>VALOR</th>
			<th>PERCEPCION SENSORIAL</th>
			<th>EXPOSICION A LA HUMEDAD</th>
			<th>ACTIVIDAD</th>
			<th>MOVILIDAD</th>
			<th>NUTRICIÓN</th>
			<th>RIESGO DE LESION CUTANEA</th>

		</tr>
		<tr>
			<th>1</th>
			<td>Completamente <br> Límitado</td>
			<td>Constantemente <br> Húmeda</td>
			<td>Encamado</td>
			<td>Completamente <br> Móvil</td>
			<td>Muy Pobre</td>
			<td>Problema</td>
			
		</tr>
		<tr>
			<th>2</th>
			<td>Muy Límitado</td>
			<td>Húmedo con frecuencia</td>
			<td>En sila</td>
			<td>Muy Limitada</td>
			<td>Probablemente Inadecuada</td>
			<td>Problema potencial</td>
		</tr>
		<tr>
			<th>3</th>
			<td>Ligeramente Límitado</td>
			<td>Ocosionalmente Húmeda</td>
			<td>Deambula Ocosionalmente</td>
			<td>Ligeramente Limitada</td>
			<td>Adecuada</td>
			<td>No existe Problema Aparente</td>
		</tr>
		<tr>
			<th>4</th>
			<td>Sin Límitado</td>
			<td>Raramente Húmeda</td>
			<td>Deambula Frecuentemente</td>
			<td>Sin Limitaciones</td>
			<td>Excelente</td>
			<td></td>
		</tr>
		<tr>
			<th>CALIFICACIÓN</th>
			<th>'.($bra[0]["bra_percen"] ?? '') .' </th>
			<th> '.($bra[0]["bra_exphum"] ?? '') .'</th>
			<th>'.($bra[0]["bra_activi"] ?? '') .' </th>
			<th>'.($bra[0]["bra_movili"] ?? '') .' </th>
			<th>'.($bra[0]["bra_nutric"] ?? '') .' </th>
			<th>'.($bra[0]["bra_rilecu"] ?? '') .' </th>
		</tr>
	</table>
	<table>
	<tr><td>
		<b></b>	
	</td></tr>
	</table><br>
	  <table border="1" cellspacing="0" cellpadding="2">
                    <tr>
                        <td><b>Calificación de Riesgo </b></td>
                        <td>
                         <center>
                         <b>'.($bra[0]["bra_califi"] ?? '') .'</b>
                        </center>
                        </td>
                    </tr>
                    <tr>
                        <td>PUNTUACIÓN DE 13 </td>
                        <td>RIESGO ALTO</td>
                    </tr>
                    <tr>
                        <td>PUNTUACIÓN DE 13 a 15 </td>
                        <td>RIESGO MEDIO</td>
                    </tr>
                    <tr>
                        <td>PUNTUACIÓN MAYOR A 16</td>
                        <td>RIESGO BAJO</td>
                    </tr>
                </table>
                	<br>
      <table>
      		<tr> <td><font size="2" >
 		             Fuente: Manual Técnico de seguridad de paciente,  MSP, 2017 <br>
                    Elaborado por : Comite tecnico de seguridad de paciente  <br>
 	            </font> 
 	        </td>
			</tr>
      </table>
     ';}
$html.='
	</body> 
	</html>

';
// CREACIÓN DE PDF
//$mpdf= new mPDF('c','A4-L','','arial');
$mpdf->writeHTML($html);
$mpdf->Output('Escala de branden modificada.pdf','I');
?>