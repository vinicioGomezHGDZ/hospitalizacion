<?php
require_once("../../../../js/lib/mpdf60/mpdf.php");
include_once("../../../../php/class_consulta.php");
$Con=New Consulta();
$Cond=New Consulta();
$ConDE=New Consulta();
$ConMT=New Consulta();
$Consv=New Consulta();
$Coni=New Consulta();
$hce_id_pk=$_GET['h'];$fecha=$_GET['f'];
// CONSULTAS DE REPORRTE
# CARGAR DATOS DE ENCABEZADO. array 0
		$per=$Con->Get_Consulta("sgh_ped_dawnes ep
		join sga_adm_historiaclinica as h on ep.hce_id_fk=h.hce_id_pk
		join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
		join sga_adm_persona as  per on p.per_id_fk=per.per_id_pk
		JOIN sga_adm_sexo as se on se.sex_id_pk=per.sex_id_fk","per_nombres,(per_apellidopaterno ||' '|| per_apellidomaterno ) as apellido,
			date_part('year',age(per_fechanacimiento)) || ' Años '||date_part('mons',age(per_fechanacimiento)) ||' Meses '|| date_part('days',age(per_fechanacimiento)) || ' Días' as Edad,hce_numerohc,sex_codigo as per_sexo, per_numeroidentificacion","","hce_id_fk",$hce_id_pk,2);
			
	# CARGAR DIAGNOSTICO EGRESO 
$daw=$Cond->Get_Consulta("sgh_ped_dawnes where scd_fecha>='".$fecha."' and hce_id_fk='".$hce_id_pk."' ORDER BY scd_id_pk DESC","*","","","",5);
//$mpdf->useOddEven = 1;
// HTML DE REPORTE 

	# code...

$html.= '

	<html>

	<head>

	<style>
			.th{
				   background: #99e6ff;
				   color: #000000;
				}

			@page {
			  margin:5mm 5mm 5mm 5mm ; 
				
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
	<htmlpagefooter name="myFooter1" style="display:none">
			
		<table width="100%">

	    <tr>

	    <td width="33%"><font size=1></font></td>

	    <td width="33%" align="center" style="font-weight: bold; font-style: italic;"></td>

	    <td width="33%" style="text-align: right; "><font size=3></font></td>

	    </tr></table>

	</htmlpagefooter>


<div class="noheader"><br>

<!-- datos paciente -->	
<table border="1" width="100%" cellspacing="0" cellpadding="2"> 
	           <tr>
	              <th width="125" class="th"><center><font size=1>ESTABLECIMIENTO<font></th>
	              <th width="150" class="th"><center><font size=1>NOMBRE<font></center></th>
	              <th width="150" class="th"><center><font size=1>APELLIDO<font></center></th>
	              <th width="30" class="th"><center><font size=1>SEXO(M-F)<font></center><div>
	              <th width="50" class="th"><center><font size=1>EDAD <font></center></th>
	              <th width="125" class="th"><center><font size=1>N° HISTORIA CLÍNICA <font></center></th>
	              
	              </div>
	               
	               </th>           
	              </font>
	              </tr>
	            </center>
	            <tr>
	              <td><center><font size=1>HOSPITAL GENERAL SANTO DOMINGO</font></center></td>
	              <td><center><font size=1>'.$per[0][per_nombres] .' </font></center></td>
	              <td><center><font size=1>' .$per[0][apellido].'</font></center></td>
	              <td><center><font size=1>'.$per[0][per_sexo].'</font></center></td>
	              <td><center><font size=1>'.$per[0][edad].'</font></center></td>
	              <td><center><font size=1>'.$per[0][per_numeroidentificacion].'</font></center></td>   
	            </tr>  
</table>
<table><tr><td></td></tr></table>
<!-- primera hoja  -->	
<table border="1" width="100%" cellspacing="0" cellpadding="2">
	<tr>
		<td colspan="7">
			<center><h5>SCORE DOWNES</h5></center>
		</td>	
	</tr>
	<tr>
		<td colspan="7">
		<table width="100%">
			<tr>
				<th class="th"><font size=2>Puntos</font></th>
				<th class="th"><font size=2>Sibilancias</font></th>
				<th class="th"><font size=2>Tiraje</font></th>
				<th class="th"><font size=2>FR</font></th>
				<th class="th"><font size=2>FC</font></th>
				<th class="th"><font size=2>Ventilación</font></th>
				<th class="th"><font size=2>Cianosis</font></th>
			</tr>
			<tr>
				<td class="th"><font size=3>0</font></td>
				<td class="th"><font size=3>No </font></td>
				<td class="th"><font size=3>No</font></td>
				<td class="th"><font size=3>< 30</font></td>
				<td class="th"><font size=3>< 120</font></td>
				<td class="th"><font size=3>Buena. Simétrica</font></td>
				<td class="th"><font size=3>No</font></td>
			</tr>
			<tr>
				<td class="th"><font size=3>1</font></td>
				<td class="th"><font size=3>Final espiración </font></td>
				<td class="th"><font size=3>Subcostal. Intercostal</font></td>
				<td class="th"><font size=3>31 - 45</font></td>
				<td class="th"><font size=3> >120 </font></td>
				<td class="th"><font size=3>Regular. Simétrica</font></td>
				<td class="th"><font size=3>Sí</font></td>
			</tr>
			<tr>
				<td class="th"><font size=3>2</font></td>
				<td class="th"><font size=3>Toda espiración</font></td>
				<td class="th"><font size=3>+ Supraclavicula <br> + Aleteo nosal</font></td>
				<td class="th"><font size=3>46 - 60</font></td>
				<td class="th"><font size=3></font></td>
				<td class="th"><font size=3>Muy disminuida</font></td>
				<td class="th"><font size=3></font></td>
			</tr>
			<tr>
				<td class="th"><font size=3>3</font></td>
				<td class="th"><font size=3>+ Inspiración</font></td>
				<td class="th"><font size=3>+ Todo lo anterior <br> + Suprasternal</font></td>
				<td class="th"><font size=3></font></td>
				<td class="th"><font size=3></font></td>
				<td class="th"><font size=3>Tórax silente</font></td>
				<td class="th"><font size=3></font></td>
			</tr>

		</table>
		</td>
	</tr>
	</table>
	<table border="1" width="100%" cellspacing="0" cellpadding="2">
	<tr>
				<th><font size=3>Fecha</font></th>
				<th><font size=3>Sibilancias</font></th>
				<th><font size=3>Tiraje</font></th>
				<th><font size=3>F Respiratoria</font></th>
				<th><font size=3>F Cardiaca</font></th>
				<th><font size=3>Ventilación</font></th>
				<th><font size=3>Cianosis</font></th>
				<th><font size=3>Total</font></th>

	</tr>';
	for ($i=0; $i <sizeof($daw) ; $i++) { 
		$html.='
			<tr>
				<td><font size=3><center>'.$daw[$i][scd_fecha].'</center></font></td>
				<td><font size=3><center>'.$daw[$i][scd_sibila].'</center></font></td>
				<td><font size=3><center>'.$daw[$i][scd_tiraje].'  </center></font></td>
				<td><font size=3><center>'.$daw[$i][scd_frespi].'  </center></font></td>
				<td><font size=3><center>'.$daw[$i][scd_frecar].'  </center></font></td>
				<td><font size=3><center>'.$daw[$i][scd_ventil].'  </center></font></td>
				<td><font size=3><center>'.$daw[$i][scd_cianos].'  </center></font></td>
				<td><font size=3><center>'.$daw[$i][scd_total].' </center></font></td>
			</tr>
		';
	}

	$html.='	

</table>

</div>
	</body>
	</html>
';

// CREACIÓN DE PDF 
$mpdf= new mPDF('c','A4');
$mpdf->writeHTML($html);
$mpdf->Output('Score Downes.pdf ','I');

?>