<?php
require_once '../../../../vendor/autoload.php';
include_once("../../../../php/class_consulta.php");
use Mpdf\Mpdf;
$mpdf = new mPDF(['debug' => true,'mode'=>'utf-8','format'=>'A4']);
$Con=New Consulta();
$ConDI=New Consulta();
$ConDE=New Consulta();
$ConMT=New Consulta();
$hce_id_pk=$_GET['h'];
$fi=$_GET['fi'];
$fa=$_GET['fa'];
// CONSULTAS DE REPORRTE
	# CARGAR DATOS DE ENCABEZADO. array 0
		$per=$Con->Get_Consulta("sgh_mei_sivitdia ep
		join sga_adm_historiaclinica as h on ep.hce_id_fk=h.hce_id_pk
		join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
		join sga_adm_persona as  per on p.per_id_fk=per.per_id_pk
		JOIN sga_adm_sexo as se on se.sex_id_pk=per.sex_id_fk","per_nombres,(per_apellidopaterno ||' '|| per_apellidomaterno ) as apellido,
			date_part('year',age(per_fechanacimiento)) as Edad,per_numeroidentificacion,sex_codigo as per_sexo","","hce_id_fk",$hce_id_pk,2);
			//print_r($per);	


		$siv=$ConMT->Get_Consulta("sgh_mei_sivitdia
join sgu_usu_usuario us on usu_id_fk=usu_id_pk
join sga_adm_profesional pr on us.pro_id_fk=pro_id_pk
join sga_adm_persona per on pr.per_id_fk=per.per_id_pk where  svd_fecha >='$fi' and svd_fecha <='$fa' and hce_id_fk='".$hce_id_pk."' order by svd_fecha desc","svd_fecha,svd_hora,svd_diante,svd_pulso,svd_tempe,svd_freres,svd_presis,svd_predia,svd_satoxi,svd_parent,svd_viaora,svd_toteli,svd_orina,svd_drenaj,svd_otros,svd_toting,
 CASE WHEN svd_aseo=true then 'X' end aseo,
 CASE WHEN svd_banio=true then 'X' end baño
,svd_peso,svd_dieadm,svd_numcom,svd_numicc,svd_numdep,svd_actfis,
CASE WHEN svd_camson=true then 'X' end sonda,svd_recvia,
per_nombres || ' ' || per_apellidopaterno || ' ' || per_apellidomaterno as resposable","","","",5);

$sivg=$ConDI->Get_Consulta("sgh_mei_sivitdia
join sgu_usu_usuario us on usu_id_fk=usu_id_pk
join sga_adm_profesional pr on us.pro_id_fk=pro_id_pk
join sga_adm_persona per on pr.per_id_fk=per.per_id_pk where svd_fecha >='$fi' and svd_fecha <='$fa' and svd_dieadm is not null AND hce_id_fk='".$hce_id_pk."' order by svd_fecha desc","svd_fecha,svd_hora,svd_diante,svd_pulso,svd_tempe,svd_freres,svd_presis,svd_predia,svd_satoxi,svd_parent,svd_viaora,svd_toteli,svd_orina,svd_drenaj,svd_otros,svd_toting,
 CASE WHEN svd_aseo=true then 'X' end aseo,
 CASE WHEN svd_banio=true then 'X' end baño
,svd_peso,svd_dieadm,svd_numcom,svd_numicc,svd_numdep,svd_actfis,
CASE WHEN svd_camson=true then 'X' end sonda,svd_recvia,
per_nombres || ' ' || per_apellidopaterno || ' ' || per_apellidomaterno as resposable","","","",5);

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
				margin:30mm 5mm 13mm 5mm ; 
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
	<!-- datos paciente -->	
	<table width="100%" >
	    <tr>

	    <td width="33%"><span style="font-weight: bold; font-style: italic;">
	    
	    <IMG SRC="../../../../img/msp.jpg" WIDTH="110" HEIGHT="30">

	    </span></td>

	    <td width="10%" align="center" style="font-weight: bold; font-style: italic;"></td>

	    <td width="80%" style="text-align: right;"><h4>'.$Con->entidad.'</h4></td>

	    </tr>
	</table>	
	<table border="1" width="100%" cellspacing="0" cellpadding="2" > 
	           <tr>
	              <td class="th" width="150"><center><font size="2">ESTABLECIMIENTO</font></td>
	              <td class="th" width="150"><center><font size="2">NOMBRE</font></center></td>
	              <td class="th" width="150"><center><font size="2">APELLIDO</font></center></td>
	              <td class="th" width="30"><center><font size="2">SEXO(M-F)</font></center></td>
	              <td class="th" width="30"><center><font size="2">EDAD </font></center></td>
	              <td class="th" width="150"><center><font size="2">N° HISTORIA CLÍNICA </font></center></td>
	              </tr>
	            </center>
	            <tr>
	              <td><center><font size="1">'.$Con->entidad.'</font></center></td>
	              <td><center><font size="1">'.($per[0]["per_nombres"] ?? '') .'</font></center></td>
	              <td><center><font size="1">'.($per[0]["apellido"] ?? '') .'</font></center></td>
	              <td><center><font size="1">'.($per[0]["per_sexo"] ?? '') .'</font></center></td>
	              <td><center><font size="1">'.($per[0]["edad"] ?? '') .'</font></center></td>
	              <td><center><font size="1">'.($per[0]["per_numeroidentificacion"] ?? '') .'</font></center></td>   
	            </tr>  
	</table>
	</htmlpageheader>

	<htmlpagefooter name="myFooter1" style="display:none">

		<table width="100%">
			    <tr>
			    <td width="33%"> <br><br><br><br><font size="1">SNS-MSP / HCU-form.020 / 2008</font></td>

			    <td width="33%" align="center"></td>

			    <td width="33%" style="text-align: right;">
				<br><br><br><br><font size="3">
			    SIGNOS VITALES</font></td>

			    </tr>
	    </table>
	</htmlpagefooter>
<!-- primera hoja  -->	
	
	<table border=1 cellspacing="0" cellpadding="2" width="100%">
		<tr>
			<td class="th" colspan=9>
			1 SIGNOS VITALES
			</td>
		</tr>
		<tr>
			<th class="" width=30><font size="1">FECHA </font> </th>
			<th class="" width=30><font size="1">DÍA DE INTERNCACIÓN </font> </th>
			<th class="" width=30><font size="1">PULSO </font> </th>
			<th class="" width=30><font size="1">TEMPERATURA  </font></th>
			<th class="" width=30><font size="1">F, RESPIRATORIA X min </font> </th>
			<th class="" width=30><font size="1">PRESIÓN SITÓLICA   </font></th>
			<th class="" width=30><font size="1">PRESIÓN DIASTÓLICA  </font></th>
			<th class="" width=30><font size="1">SATURACIÓNDE O2  </font> </th>
			<th class="" width=20><font size="1">RESPONSABLE</font> </th>
		</tr>';
		for ($i=0; $i <count($siv) ; $i++) { 
			$html.='
			<tr>
			<td align="center"><font size="1">'.($siv[$i]["svd_fecha"] ?? '').' <br> '.substr($siv[$i]["svd_hora"],0,8).'</font> </td>
			<td align="center"><font size="1">'.($siv[$i]["svd_diante"] ?? '') .'</font> </td>
			<td align="center"><font size="1">'.($siv[$i]["svd_pulso"] ?? '') .'</font> </td>
			<td align="center"><font size="1">'.($siv[$i]["svd_tempe"] ?? '') .'</font> </td>
			<td align="center"><font size="1">'.($siv[$i]["svd_freres"] ?? '') .'</font> </td>
			<td align="center"><font size="1">'.($siv[$i]["svd_presis"] ?? '') .'</font> </td>
			<td align="center"><font size="1">'.($siv[$i]["svd_predia"] ?? '') .'</font> </td>
			<td align="center"><font size="1">'.($siv[$i]["svd_satoxi"] ?? '') .'</font> </td>
			<td align="center"><font size="1">'.($siv[$i]["resposable"] ?? '') .'</font> </td>
			</tr>
			';
		}
			

		$html.='
	</table>
	<table><tr><td></td></tr></table>

	<table border=1 cellspacing="0" cellpadding="2" width="100%">
		<tr>
			<td class="th" colspan=2>
			2 BALANCE HÍDRICO 
			</td>
		</tr>

		<tr>
			<th class=""><font size="1">INGRESOS CC</font></th>
			<th class=""><font size="1">ELIMINCACIÓN CC  </font></th>
		</tr>
			<tr>
			<td class="">
				<table width="100%" border=1 cellspacing="0" cellpadding="2">
					<tr>
						<th  width=30>
							<font size="1">FECHA</font>
						</th>
						<th width=30>
							<font size="1">DÍA DE INTERNCACIÓN</font>
						</th>
						<th  width=30>
							<font size="1">PARENTAL</font>
						</th>
						<th  width=30>
							<font size="1">VÍA ORAL</font>
						</th>
						<th width=20>
							<font size="1">TATAL</font>
						</th>
						<th class="" width=20><font size="1">RESPONSABLE</font> </th>
					</tr>
					';
						for ($i=0; $i <count($sivg) ; $i++) { 
			$html.='
			<tr>
			<td align="center"><font size="1">'.($sivg[$i]["svd_fecha"].' <br> '.$sivg[$i]["svd_hora"] ?? '') .'</font> </td>
			<td align="center"><font size="1">'.($sivg[$i]["svd_diante"] ?? '') .'</font> </td>
			<td align="center"><font size="1">'.($sivg[$i]["svd_parent"] ?? '') .'</font> </td>
			<td align="center"><font size="1">'.($sivg[$i]["svd_viaora"] ?? '') .'</font> </td>
			<td align="center"><font size="1">'.($sivg[$i]["svd_toting"] ?? '') .'</font> </td>
			<td align="center"><font size="1">'.($sivg[$i]["resposable"] ?? '') .'</font> </td>
			</tr>
			';
		}
		$html.='
	
				</table>	
			</td>
			<td class="">
				<table width="100%" border=1 cellspacing="0" cellpadding="2">
					<tr>
						<th>
							<font size="1">FECHA</font>
						</th>
						<th width=30>
							<font size="1">DÍA DE INTERNCACIÓN</font>
						</th>
						<th>
							<font size="1">ORINA</font>
						</th>
						<th>
							<font size="1">DRENAJE</font>
						</th>
						<th>
							<font size="1">OTROS</font>
						</th>
						<th>
							<font size="1">TOTAL</font>
						</th>
						<th class="" width=20><font size="1">RESPONSABLE</font> </th>
					</tr>	
						';
					for ($i=0; $i <count($sivg) ; $i++) { 
						$html.='
						<tr>
						<td align="center"><font size="1">'.($sivg[$i]["svd_fecha"] ?? '').' <br> '.substr($siv[$i]["svd_hora"],0,8).'</font> </td>
						<td align="center"><font size="1">'.($sivg[$i]["svd_diante"] ?? '') .'</font> </td>
						<td align="center"><font size="1">'.($sivg[$i]["svd_orina"] ?? '') .'</font> </td>
						<td align="center"><font size="1">'.($sivg[$i]["svd_drenaj"] ?? '') .'</font> </td>
						<td align="center"><font size="1">'.($sivg[$i]["svd_otros"] ?? '') .'</font> </td>
						<td align="center"><font size="1">'.($sivg[$i]["svd_toteli"] ?? '') .'</font> </td>
						<td align="center"><font size="1">'.($sivg[$i]["resposable"] ?? '') .'</font> </td>
						</tr>
						';
					}
					$html.='
				</table>	

			</td>
		</tr>		
	</table>
	<table><tr><td></td></tr></table>

		<table border=1 cellspacing="0" cellpadding="2" width="100%">
		<tr>
			<td class="th" colspan=13>
			3 MEDICIONES Y ACTIVIDADES
			</td>
		</tr>
			<tr>
						<th>
							<font size="1">FECHA</font>
						</th>
						<th width=30>
							<font size="1">DÍA DE INTERNCACIÓN</font>
						</th>
						<th>
							<font size="1">ASEO</font>
						</th>
						<th>
							<font size="1">BAÑO</font>
						</th>
						<th>
							<font size="1">PESO kg</font>
						</th>
			
			
						<th>
							<font size="1">DIETA ADMINISTRADA</font>
						</th>
						<th>
							<font size="1">NUMERO DE COMIDAS</font>
						</th>
						<th>
							<font size="1">NUMERO MICCIONES </font>
						</th>
						<th>
							<font size="1">NUMERO DE DEPOSICIONES</font>
						</th>
						<th>
							<font size="1">ACTIVIDAD FÍSICA</font>
						</th>
						<th>
							<font size="1">CAMBIO DE SONDA</font>
						</th>
						<th>
							<font size="1">RECANALIZACIÓN VÍA</font>
						</th>
						<th>
							<font size="1">RESPONSABLE</font>
						</th>	
			</tr>
				';
					for ($i=0; $i <count($sivg) ; $i++) { 
						$html.='
						<tr>
						<td align="center"><font size="1">'.($sivg[$i]["svd_fecha"] ?? '').' <br> '.substr($siv[$i]["svd_hora"],0,8).'</font> </td>
						<td align="center"><font size="1">'.($sivg[$i]["svd_diante"] ?? '') .'</font> </td>
						<td align="center"><font size="1">'.($sivg[$i]["aseo"] ?? '') .'</font> </td>
						<td align="center"><font size="1">'.($sivg[$i]["baño"] ?? '') .'</font> </td>
						<td align="center"><font size="1">'.($sivg[$i]["svd_peso"] ?? '') .'</font> </td>
						<td align="center"><font size="1">'.($sivg[$i]["svd_dieadm"] ?? '') .'</font> </td>
						<td align="center"><font size="1">'.($sivg[$i]["svd_numcom"] ?? '') .'</font> </td>
						<td align="center"><font size="1">'.($sivg[$i]["svd_numicc"] ?? '') .'</font> </td>
						<td align="center"><font size="1">'.($sivg[$i]["svd_numdep"] ?? '') .'</font> </td>
						<td align="center"><font size="1">'.($sivg[$i]["svd_actfis"] ?? '') .'</font> </td>
						<td align="center"><font size="1">'.($sivg[$i]["svd_camson"] ?? '') .'</font> </td>
						<td align="center"><font size="1">'.($sivg[$i]["svd_recvia"] ?? '') .'</font> </td>
						<td align="center"><font size="1">'.($sivg[$i]["resposable"] ?? '') .'</font> </td>
						</tr>
						';
					}
					$html.='	
				
	</table>

</body>
		
';

// CREACIÓN DE PDF 
//$mpdf= new mPDF('c','A4','','arial');
$mpdf->writeHTML($html);
$mpdf->Output('Signos vitales.pdf','I');
?>