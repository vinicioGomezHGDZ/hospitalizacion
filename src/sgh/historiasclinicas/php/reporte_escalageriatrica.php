<?php
require_once("../../../../js/lib/mpdf-6.1.3/mpdf.php");
include_once("../../../../php/class_consulta.php");

$Conesg=New Consulta();
$hce_id_fk=$_GET['h'];
# CARGAR DATOS DE ENCABEZADO. array 0
$esge = $Conesg->Get_Consulta("sgh_mei_escgeria where hce_id_fk='".$hce_id_fk."' ORDER BY esg_fecha DESC","hce_id_fk,esg_id_pk,esg_fecha", "", "","" ,5);


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
		      margin:5mm 8mm 5mm 8mm;
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
<htmlpagefooter name="myFooter1" style="display:none">

		<table width="100%">
			    <tr>
			    <td width="33%"> <br><br><br><br><font size=1>SNS-MSP / HCU-form.005 / 2008 </font></td>

			    <td width="33%" align="center"></td>

			    <td width="33%" style="text-align: right;">
				<br><br><br><br><font size=3>
			    EVOLUCIÓN Y PRESCRIPCIONES</font></td>

			    </tr>
	    </table>
	</htmlpagefooter>
';
for ($r=0; $r <count($esge) ; $r++) {

    $esg_id_pk=$esge[$r]["esg_id_pk"];
    $Con='Con'.$r;
    $Conta='Conta'.$r;
    $Concr='Concr'.$r;
    $Conai='Conai'.$r;
    $Conab='Conab'.$r;
    $Conde='Conde'.$r;
    $Connu='Connu'.$r;

    $$Con=New Consulta();
    $$Conta=New Consulta();
    $$Concr=New Consulta();
    $$Conai=New Consulta();
    $$Conab=New Consulta();
    $$Conde=New Consulta();
    $$Connu=New Consulta();

# CARGAR DATOS DE ENCABEZADO. array 0
    $per = $$Con->Get_Consulta("sgh_mei_escgeria ep
		join sga_adm_historiaclinica as h on ep.hce_id_fk=h.hce_id_pk
		join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
		join sga_adm_persona as  per on p.per_id_fk=per.per_id_pk
       JOIN sga_adm_sexo as se on se.sex_id_pk=per.sex_id_fk", "per_nombres,(per_apellidopaterno ||' '|| coalesce(per_apellidomaterno,'') ) as apellido,
			date_part('year',age(per_fechanacimiento)) as Edad,per_numeroidentificacion,sex_codigo as per_sexo", "", "ep.hce_id_fk='".$hce_id_fk."' AND esg_id_pk", $esg_id_pk, 2);
# CARGAR DATOS DE congnitivo y resurso social
    $esg = $$Concr->Get_Consulta("sgh_mei_escgeria
join sgu_usu_usuario usu on usu_id_fk=usu.usu_id_pk
join sga_adm_profesional  pr on usu.pro_id_fk=pr.pro_id_pk
join sga_adm_persona per on pr.per_id_fk=per.per_id_pk", "esg_fecha,esg_sabfec,esg_apnobj,esg_renual,esg_tompap,esg_repser,esg_copdib,esg_viveco,esg_reconso,esg_apreso,
  per_nombres || ' ' ||per_apellidopaterno ||' '|| per_apellidomaterno responsable", "", "esg_id_pk", $esg_id_pk, 2);
# CARGAR DATOS DE tamizaje rapido
    $tami = $$Conta->Get_Consulta("sgh_mei_escalpro
					join sgh_mei_respuesta as res on pat_id_fk=res.pat_id_pk where pat_punto='TAMIZAJE' AND esg_id_fk=" . $esg_id_pk . "ORDER BY pat_item", "pat_id_pk,
  CASE WHEN pat_result='SI' THEN 'X' END as si,
  CASE WHEN pat_result='NO' THEN 'X' END as no,
  pat_item,pat_punto", "", "", "", 5);
# CARGAR DATOS DE ACTIVIDAD INSTRUMENTAL
    $aci = $$Conai->Get_Consulta("sgh_mei_escalpro
					join sgh_mei_respuesta as res on pat_id_fk=res.pat_id_pk where pat_punto='ACTIVIDADES INSTRUMENTAL' AND esg_id_fk=" . $esg_id_pk . "ORDER BY pat_item", "CASE WHEN pat_result='DEPENDIENTE' THEN 'X' END as DE,
  CASE WHEN pat_result='CON AYUDA' THEN 'X' END as CA,
  CASE WHEN pat_result='INDEPENDIENTE' THEN 'X' END as in,pat_item,
  pat_punto", "", "", "", 5);

# CARGAR DATOS DE ACTIVIDAD BÁSICA
    $acb = $$Conab->Get_Consulta("sgh_mei_escalpro
					join sgh_mei_respuesta as res on pat_id_fk=res.pat_id_pk where pat_punto='ACTIVIDADES BÁSICAS' AND esg_id_fk=" . $esg_id_pk . "ORDER BY pat_item", "CASE WHEN pat_result='DEPENDIENTE' THEN 'X' END as DE,
  CASE WHEN pat_result='CON AYUDA' THEN 'X' END as CA,
  CASE WHEN pat_result='INDEPENDIENTE' THEN 'X' END as in,pat_item,
  pat_punto", "", "", "", 5);
# CARGAR DATOS DE depresión
    $dep = $$Conde->Get_Consulta("sgh_mei_escalpro
					join sgh_mei_respuesta as res on pat_id_fk=res.pat_id_pk where pat_punto='DEPRESIÓN' AND esg_id_fk=" . $esg_id_pk . "ORDER BY pat_item", "CASE WHEN pat_result='SI' THEN 'X' END as si,
 					 CASE WHEN pat_result='NO' THEN 'X' END as no,pat_item,
  pat_punto,CASE WHEN pat_result='SI' THEN '1' END as ts", "", "", "", 5);

# CARGAR DATOS DE depresión
    $nut = $$Connu->Get_Consulta("sgh_mei_escalpro
					join sgh_mei_respuesta as res on pat_id_fk=res.pat_id_pk where pat_punto='NUTRICIONAL' AND esg_id_fk=" . $esg_id_pk . "ORDER BY pat_item", "CASE WHEN pat_result='AUSENTE' THEN 'X' END as au,
 CASE WHEN pat_result='MODERADA' THEN 'X' END as mo,
 CASE WHEN pat_result='SEVERA' THEN 'X' END as se,
  pat_result,
 CASE WHEN pat_result='VA A FUERA' THEN 'X' END as va,
 CASE WHEN pat_result='SE LEVANTA NO SALE' THEN 'X' END as sl,
 CASE WHEN pat_result='CAMA-SILLA' THEN 'X' END as cs,

 CASE WHEN pat_result='SI' THEN 'X' END as si,
 CASE WHEN pat_result='NO' THEN 'X' END as no,
  CASE WHEN pat_result='AUSENTE' THEN '3' END as tau,
 CASE WHEN pat_result='MODERADA' THEN '2' END as tmo,
 CASE WHEN pat_result='SEVERA' THEN '1' END as tse,
 CASE WHEN pat_result='VA A FUERA' THEN '3' END as tva,
 CASE WHEN pat_result='SE LEVANTA NO SALE' THEN '2' END as tsl,
 CASE WHEN pat_result='CAMA-SILLA' THEN '1' END as tcs,
 CASE WHEN pat_result='SI' THEN '1' END as tsi,
  pat_punto", "", "", "", 5);

    $html .= '
<div>
<!-- primera hoja  -->
	
	<table border="1" width="100%" cellspacing="0" cellpadding="2"> 
	           <tr>
	              <th class="" width="150"><center><h5>ESTABLECIMIENTO<h5></th>
	              <th class="" width="150"><center><h5>NOMBRE<h5></center></th>
	              <th class="" width="150"><center><h5>APELLIDO<h5></center></th>
	              <th class="" width="30"><center><h5>SEXO(M-F)<h5></center><div>
	              <th class="" width="30"><center><h5>EDAD <h5></center></th>
	              <th class="" width="150"><center><h5>N° HISTORIA CLÍNICA <h5></center></th>
	              
	              </div>
	               
	               </th>           
	              </font>
	              </tr>
	            </center>
	            <tr>
	              <td><center><font size=1>HOSPITAL GENERAL SANTO DOMINGO</font></center></td>
	              <td><center><font size=1>' . $per[0]["per_nombres"] . '</font></center></td>
	              <td><center><font size=1>' . $per[0]["apellido"] . '</font></center></td>
	              <td><center><font size=1>' . $per[0]["per_sexo"] . '</font></center></td>
	              <td><center><font size=1>' . $per[0]["edad"] . '</font></center></td>
	              <td><center><font size=1>' . $per[0]["per_numeroidentificacion"] . '</font></center></td>   
	            </tr>  
		
	</table>
	<table><tr><td></td></tr></table>
	<table border="1" width="100%" cellspacing="0" cellpadding="2">
			<tr><td><font size=2>10 ESCALAS GERIATRICAS</font></td></tr>
	</table>

	<table><tr><td></td></tr></table>
<table width="100%" cellspacing="0" cellpadding="2" border=1 >

<tr>

<td>

<table width="100%">
  <tr>
    <td VALIGN="TOP">
		<table width="100%">
		<tr>
			<td style="text-align: right;" colspan=2><font size=2>FECHA:</font>
	  	 	
	  	 	</td>
	  	 	<td>
	  	 		<table border="1" width="100%" cellspacing="0" cellpadding="2">
	  	 			<tr>
	  	 				<td>
	  	 					<font size=2><center>' . $esg[0]["esg_fecha"] . '</center></font>
	  	 				</td>	
	  	 			</tr>	
	  	 		</table>	
	  	 	</td>
	  	  </tr> 
	  	</table>
	  	<table width="100%">  	
			<tr>
				<td width="290">
					<font size=2><b>TAMIZAJE RAPIDO</b></font>
				</td>
				<th width="10">
					<font size=2>SI</font>
				</th>
				<th width="5">
					<font size=2>NO</font>
				</th>
			</tr>	
				</tr>
		</table>
		<table border="1" width="100%" cellspacing="0" cellpadding="2">
			
			<tr>
				<td><font size=1>Dificultad Visual</font></td>
				<td width="6%"><center><font size=1>' . $tami[1]["si"] . '</font></center>
				</td>
				<td width="6%"><center><font size=1>' . $tami[1]["no"] . '</font></center>
				</td>
			</tr>
			<tr>
				<td><font size=1>Dificultad Auditiva</font></td>
				<td><center><font size=1>' . $tami[0]["si"] . '</font></center>
				</td>
				<td><center><font size=1>' . $tami[0]["no"] . '</font></center>
				</td>
			</tr>
			<tr>
				<td><font size=1>Prueba de "Levantate y anda" Mayor a 15 seg</font></td>
				<td><center><font size=1>' . $tami[2]["si"] . '</font></center>
				</td>
				<td><center><font size=1>' . $tami[2]["no"] . '</font></center>
				</td>
			</tr>
			<tr>
				<td><font size=1>Perdida Involuntaria de Orina</font></td>
				<td><center><font size=1>' . $tami[4]["si"] . '</font></center>
				</td>
				<td><center><font size=1>' . $tami[4]["no"] . '</font></center>
				</td>
			</tr>
			<tr>
				<td><font size=1>Perdida de peso mayor de 4.5 kg en 6 meses</font></td>
				<td><center><font size=1>' . $tami[5]["si"] . '</font></center>
				</td>
				<td><center><font size=1>' . $tami[5]["no"] . '</font></center>
				</td>
			</tr>
			<tr>
				<td><font size=1>Perdida de memoria resiente</font></td>
				<td><center><font size=1>' . $tami[3]["si"] . '</font></center>
				</td>
				<td><center><font size=1>' . $tami[3]["no"] . '</font></center>
				</td>
			</tr>
			<tr>
				<td><font size=1>Se siente triste o deprimido</font></td>
				<td><center><font size=1>' . $tami[8]["si"] . '</font></center>
				</td>
				<td><center><font size=1>' . $tami[8]["no"] . '</font></center>
				</td>
			</tr>
			<tr>
				<td><font size=1>Puede bañarce solo</font></td>
				<td><center><font size=1>' . $tami[6]["si"] . '</font></center>
				</td>
				<td><center><font size=1>' . $tami[6]["no"] . '</font></center>
				</td>
			</tr>
			<tr>
				<td><font size=1>Sale de crompas solo</font></td>
				<td><center><font size=1>' . $tami[7]["si"] . '</font></center>
				</td>
				<td><center><font size=1>' . $tami[7]["no"] . '</font></center>
				</td>
			</tr>
	    </table>
		<table><tr><td></td></tr></table>
		<table width=100%>
		<tr>
			<td style="text-align: right;" colspan=2><font size=2>FECHA:</font>
	  	 	
	  	 	</td>
	  	 	<td>
	  	 		<table border="1" width="100%" cellspacing="0" cellpadding="2">
	  	 			<tr>
	  	 				<td>
	  	 					<font size=2><center>' . $esg[0]["esg_fecha"] . '</center></font>
	  	 				</td>	
	  	 			</tr>	
	  	 		</table>	
	  	 	</td>
	  	  </tr> 
	  	</table>
	  	<table width="100%">  	
			<tr>
				<td width="290">
					<font size=2><b>ACTIVIDADES BÁSICA</b></font>
				</td>
				<th width="10">
					<font size=2>IN</font>
				</th>
				<th width="5">
					<font size=2>CA</font>
				</th>
				<th width="5">
					<font size=2>DE</font>
				</th>
			</tr>	
				</tr>
		</table>
	     <table  border="1" width="100%" cellspacing="0" cellpadding="2">
	  	 	<tr>
				<td>
					<font size=2>Se baña solo</font>
				</td>
				<td width="20" align="center"><font size=2>' . $acb[4]["in"] . '</font></td>
				<td width="20" align="center"><font size=2>' . $acb[4]["ca"] . '</font></td>
				<td width="20" align="center"><font size=2>' . $acb[4]["de"] . '</font></td>
	  	 	</tr>
	  	 	<tr>
				<td>
					<font size=2>Se viste y desviste solo</font>
				</td>
				<td width="20" align="center"><font size=2>' . $acb[7]["in"] . '</font></td>
				<td width="20" align="center"><font size=2>' . $acb[7]["ca"] . '</font></td>
				<td width="20" align="center"><font size=2>' . $acb[7]["de"] . '</font></td>
	  	 	</tr>
	  	 	<tr>
				<td>
					<font size=2>Cuida su apariencia personal</font>
				</td>
				<td width="20" align="center"><font size=2>' . $acb[2]["in"] . '</font></td>
				<td width="20" align="center"><font size=2>' . $acb[2]["ca"] . '</font></td>
				<td width="20" align="center"><font size=2>' . $acb[2]["de"] . '</font></td>
	  	 	</tr>
	  	 	<tr>
				<td>
					<font size=2>Utiliza el inodoro</font>
				</td>
				<td width="20" align="center"><font size=2>' . $acb[6]["in"] . '</font></td>
				<td width="20" align="center"><font size=2>' . $acb[6]["ca"] . '</font></td>
				<td width="20" align="center"><font size=2>' . $acb[6]["de"] . '</font></td>
	  	 	</tr>
	  	 	<tr>
				<td>
					<font size=2>Controla esfinteres</font>
				</td>
				<td width="20" align="center"><font size=2>' . $acb[1]["in"] . '</font></td>
				<td width="20" align="center"><font size=2>' . $acb[1]["ca"] . '</font></td>
				<td width="20" align="center"><font size=2>' . $acb[1]["de"] . '</font></td>
	  	 	</tr>
	  	 	<tr>
				<td>
					<font size=2>Se traslada, Se acuesta, Se levanta </font>
				</td>
				<td width="20" align="center"><font size=2>' . $acb[5]["in"] . '</font></td>
				<td width="20" align="center"><font size=2>' . $acb[5]["ca"] . '</font></td>
				<td width="20" align="center"><font size=2>' . $acb[5]["de"] . '</font></td>
	  	 	</tr>
	  	 	<tr>
				<td>
					<font size=2>Camina </font>
				</td>
				<td width="20" align="center"><font size=2>' . $acb[0]["in"] . '</font></td>
				<td width="20" align="center"><font size=2>' . $acb[0]["ca"] . '</font></td>
				<td width="20" align="center"><font size=2>' . $acb[0]["de"] . '</font></td>
	  	 	</tr>
	  	 	<tr>
				<td>
					<font size=2>Se alimenta </font>
				</td>
				<td width="20" align="center"><font size=2>' . $acb[3]["in"] . '</font></td>
				<td width="20" align="center"><font size=2>' . $acb[3]["ca"] . '</font></td>
				<td width="20" align="center"><font size=2>' . $acb[3]["de"] . '</font></td>
	  	 	</tr>
	  	 </table>

	 <table>
	 		<tr>
	 			<td>
	 				<b>Responsable : </b><font size=2>' . $esg[0]["responsable"] . '</font> 
	 			</td>
	 		</tr>
	 </table> 
 	 <table>
	 		<tr>
	 			<td>
	 				<b>Simbología :</b> 
	 			</td>
	 		</tr>
	</table>
	<table> 		
	 		<tr>
				<td width="70">
	 			</td>
	 			<td><font size=3>
	 				<b>IN:</b> Independiente <br>
	 				<b>CA:</b> Con Ayuda <br>
	 				<b>DE:</b> Dependiente<br>

	 				<b>AU:</b>  Ausente <br>
	 				<b>MO:</b>  Moderada <br>
	 				<b>SE:</b>  Severa <br>
	 				<b>VA:</b>  Va afuera <br>
	 				<b>SL:</b>  Se levanta no sale <br>
	 				<b>CS:</b> Cama-Silla<br>
	 				</font>
	 			</td>
	 		</tr>
	 </table> 
    </td>
    <td VALIGN="TOP" >
	  <table width=100%>
		<tr>
			<td style="text-align: right;" colspan=2><font size=2>FECHA:</font>
	  	 	
	  	 	</td>
	  	 	<td>
	  	 		<table border="1" width="100%" cellspacing="0" cellpadding="2">
	  	 			<tr>
	  	 				<td>
	  	 					<font size=2><center>' . $esg[0]["esg_fecha"] . '</center></font>
	  	 				</td>	
	  	 			</tr>	
	  	 		</table>	
	  	 	</td>
	  	  </tr> 
	  	</table>
	  	<table width="100%">  	
			<tr>
				<td width="290">
					<font size=2><b>ACTIVIDAD INSTRUMENTAL</b></font>
				</td>
				<th width="10">
					<font size=2>IN</font>
				</th>
				<th width="5">
					<font size=2>CA</font>
				</th>
				<th width="5">
					<font size=2>DE</font>
				</th>
			</tr>	
				</tr>
		</table>
	  	<table  border="1" width="100%" cellspacing="0" cellpadding="2">
		
	  	 	<tr>
				<td>
					<font size=2>Usa el telefono</font>
				</td>
				<td width="20" align="center"><font size=2>' . $aci[4]["in"] . '</font></td>
				<td width="20" align="center"><font size=2>' . $aci[4]["ca"] . '</font></td>
				<td width="20" align="center"><font size=2>' . $aci[4]["de"] . '</font></td>
	  	 	</tr>
	  	 	<tr>
				<td>
					<font size=2>Usa Medios de transporte</font>
				</td>
				<td width="20" align="center"><font size=2>' . $aci[3]["in"] . '</font></td>
				<td width="20" align="center"><font size=2>' . $aci[3]["ca"] . '</font></td>
				<td width="20" align="center"><font size=2>' . $aci[3]["de"] . '</font></td>
	  	 	</tr>
	  	 	<tr>
				<td>
					<font size=2>Va de compras</font>
				</td>
				<td width="20" align="center"><font size=2>' . $aci[5]["in"] . '</font></td>
				<td width="20" align="center"><font size=2>' . $aci[5]["ca"] . '</font></td>
				<td width="20" align="center"><font size=2>' . $aci[5]["de"] . '</font></td>
	  	 	</tr>
	  	 	<tr>
				<td>
					<font size=2>Prepara la comida </font>
				</td>
				<td width="20" align="center"><font size=2>' . $aci[2]["in"] . '</font></td>
				<td width="20" align="center"><font size=2>' . $aci[2]["ca"] . '</font></td>
				<td width="20" align="center"><font size=2>' . $aci[2]["de"] . '</font></td>
	  	 	</tr>
	  	 	<tr>
				<td>
					<font size=2>Controla sus medicamentos</font>
				</td>
				<td width="20" align="center"><font size=2>' . $aci[0]["in"] . '</font></td>
				<td width="20" align="center"><font size=2>' . $aci[0]["ca"] . '</font></td>
				<td width="20" align="center"><font size=2>' . $aci[0]["de"] . '</font></td>
	  	 	</tr>
	  	 	<tr>
				<td>
					<font size=2>Maneja dinero</font>
				</td>
				<td width="20" align="center"><font size=2>' . $aci[1]["in"] . '</font></td>
				<td width="20" align="center"><font size=2>' . $aci[1]["ca"] . '</font></td>
				<td width="20" align="center"><font size=2>' . $aci[1]["de"] . '</font></td>
	  	 	</tr>
	  	 </table>

	  	<table><tr><td></td></tr></table>
	  	
	  	<table width="100%">
	  	<tr>
			<td style="text-align: right;" colspan=2><font size=2>FECHA:</font>
	  	 	
	  	 	</td>
	  	 	<td>
	  	 		<table border="1" width="100%" cellspacing="0" cellpadding="2">
	  	 			<tr>
	  	 				<td>
	  	 					<font size=2><center>' . $esg[0]["esg_fecha"] . '</center></font>
	  	 				</td>	
	  	 			</tr>	
	  	 		</table>	
	  	 	</td>
	  	  </tr>
	  	  </table>
	  	  <table> 	
	  	  <tr>
				<td>
					<font size=2>COGNITIVO</font>
				</td>
				<td><font size=2></font></td>
			
	  	   </tr>
	  	   </table>
	  	
	  	<table  border="1" width="100%" cellspacing="0" cellpadding="2">
	  	  
	  	    <tr>
				<td>
					<font size=2>Sabe la fehca: Día, Mes, Año, Semana<br>(0-4 Puntaje) </font>
				</td>
				<td width="75"><font size=2><center>' . $esg[0]["esg_sabfec"] . '</center></font></td>
	  	    </tr>
	  	    <tr>
				<td>
					<font size=2>Aprende el nombre de 3 objetos<br>(0-3 Puntaje) </font>
				</td>
				<td width="75"><font size=2><center>' . $esg[0]["esg_apnobj"] . '</center></font></td>
	  	    </tr>
	  	    <tr>
				<td>
					<font size=2>Repite numeros al reves: 1,3,5,7,9 <br>(0-3 Puntaje) </font>
				</td>
				<td width="75"><font size=2><center>' . $esg[0]["esg_renual"] . '</center></font></td>
	  	    </tr>
	  	    <tr>
				<td>
					<font size=2>Toma, dobla y coloca papel <br>(0-3 Puntaje) </font>
				</td>
				<td width="75"><font size=2><center>' . $esg[0]["esg_tompap"] . '</center></font></td>
	  	    </tr>
	  	    <tr>
				<td>
					<font size=2>Repite serie de 3 palabras<br>(0-3 Puntaje) </font>
				</td>
				<td width="75"><font size=2><center>' . $esg[0]["esg_repser"] . '</center></font></td>
	  	    </tr>
	  	    <tr>
				<td>
					<font size=2>Copia dibuja de 2 circulos<br>(0-3 Puntaje) </font>
				</td>
				<td width="75"><font size=2><center>' . $esg[0]["esg_copdib"] . '</center></font></td>
	  	    </tr>
	  	       <tr>
				<td style="text-align: right;">
					<font size=2><b>SCORE</b></font>
				</td>';
    $tcogni = $esg[0]["esg_sabfec"] +
        $esg[0]["esg_apnobj"] +
        $esg[0]["esg_renual"] +
        $esg[0]["esg_tompap"] +
        $esg[0]["esg_repser"] +
        $esg[0]["esg_copdib"];

    $html .= '
				<th width="75"><font size=2>' . $tcogni . '</font></th>
				
	  	    </tr>
	  	</table>

	  	<table><tr><td><font size=1>DETERIORO : 14-19 = AUSENTE // MENOS DE 12 = PRESENTE </font></td><tr></table>
	  	<table width="100%">
	  	<tr>
			<td style="text-align: right;" colspan=2><font size=2>FECHA:</font>
	  	 	
	  	 	</td>
	  	 	<td>
	  	 		<table border="1" width="100%" cellspacing="0" cellpadding="2">
	  	 			<tr>
	  	 				<td>
	  	 					<font size=2><center>' . $esg[0]["esg_fecha"] . '</center></font>
	  	 				</td>	
	  	 			</tr>	
	  	 		</table>	
	  	 	</td>
	  	  </tr>
	  	  </table>
	  	  <table> 	
	  	  <tr>
				<td>
					<font size=2>RECURSO SOCIAL</font>
				</td>
				<td><font size=2></font></td>
			
	  	   </tr>
	  	   </table>

	  	<table  border="1" width="100%" cellspacing="0" cellpadding="2">
	  	  	<tr>
				<td>
					<font size=2>Situación Faniliar vive con: <br> (5 Opciones)</font>
				</td>
				<td width="75"><font size=2><center>' . $esg[0]["esg_sabfec"] . '</center></font></td>
	  	    </tr>
	  	    <tr>
				<td>
					<font size=2>Relaciones y contactos sociales<br>(5 Opciones) </font>
				</td>
				<td width="75"><font size=2><center>' . $esg[0]["esg_reconso"] . '</center></font></td>
	  	    </tr>
	  	    <tr>
				<td>
					<font size=2>Apoyo de la red social <br>(5 opciones) </font>
				</td>
				<td width="75"><font size=2><center>' . $esg[0]["esg_apreso"] . '</center></font></td>
	  	    </tr>
	  	   <tr>
				<td style="text-align: right;">
					<font size=2><b>SCORE</b></font>
				</td>';
    $tres = $esg[0]["esg_sabfec"] +
        $esg[0]["esg_reconso"] +
        $esg[0]["esg_apreso"];

    $html .= '
				<th width="75"><font size=2><center>' . $tres . '</center></font></th>
				
	  	    </tr>
	  	    </table>
	  	    <table><tr><td><font size=1>RIESGO SOCIAL : 5 O MENOS = BAJO // 6-9 = ACEPTABLE // 10-15 = ALTO </font></td><tr></table>
    </td>
	<td VALIGN="TOP" >
  <table width=100%>
		<tr>
			<td style="text-align: right;" colspan=2><font size=2>FECHA:</font>
	  	 	
	  	 	</td>
	  	 	<td>
	  	 		<table border="1" width="100%" cellspacing="0" cellpadding="2">
	  	 			<tr>
	  	 				<td>
	  	 					<font size=2><center>' . $esg[0]["esg_fecha"] . '</center></font>
	  	 				</td>	
	  	 			</tr>	
	  	 		</table>	
	  	 	</td>
	  	  </tr> 
	  	</table>
	  	<table width="100%">  	
			<tr>
				<td width="290">
					<font size=2><b>DEPRESIÓN</b></font>
				</td>
				<th width="10">
					<font size=2>SI</font>
				</th>
				<th width="5">
					<font size=2>NO</font>
				</th>
			</tr>	
				</tr>
		</table>
	<table border="1" width="100%" cellspacing="0" cellpadding="2">
		<tr>
			<td><font size=1>Esta satisfecho con su vida</font></td>
			<td width="7%" align="center"><font size=1>' . $dep[3]["si"] . '</font></td>
			<td width="7%" align="center"><font size=1>' . $dep[3]["no"] . '</font></td>
		</tr>
		<tr>
			<td><font size=1>Ha dejado de hacer actividades de interes</font></td>
			<td width="7%" align="center"><font size=1>' . $dep[0]["si"] . '</font></td>
			<td width="7%" align="center"><font size=1>' . $dep[0]["no"] . '</font></td>
		</tr>
		<tr>
			<td><font size=1>Siente su vida vacíl </font></td>
			<td width="7%" align="center"><font size=1>' . $dep[14]["si"] . '</font></td>
			<td width="7%" align="center"><font size=1>' . $dep[14]["no"] . '</font></td>
		</tr>
		<tr>
			<td><font size=1>Se aburre con frecuencia</font></td>
			<td width="7%" align="center"><font size=1>' . $dep[9]["si"] . '</font></td>
			<td width="7%" align="center"><font size=1>' . $dep[9]["no"] . '</font></td>
		</tr>
		<tr>
			<td><font size=1>Esta de buen unimo la mayor parte de tiempo</font></td>
			<td width="7%" align="center"><font size=1>' . $dep[1]["si"] . '</font></td>
			<td width="7%" align="center"><font size=1>' . $dep[1]["no"] . '</font></td>
		</tr>
		<tr>
			<td><font size=1>Esta preocupado porque algo malo va a pasar</font></td>
			<td width="7%" align="center"><font size=1>' . $dep[7]["si"] . '</font></td>
			<td width="7%" align="center"><font size=1>' . $dep[7]["no"] . '</font></td>
		</tr>
		<tr>
			<td><font size=1>Se siente feliz la mayor parte del tiempo</font></td>
			<td width="7%" align="center"><font size=1>' . $dep[11]["si"] . '</font></td>
			<td width="7%" align="center"><font size=1>' . $dep[11]["no"] . '</font></td>
		</tr>
		<tr>
			<td><font size=1>Se siente amenudo desamparado</font></td>
			<td width="7%" align="center"><font size=1>' . $dep[10]["si"] . '</font></td>
			<td width="7%" align="center"><font size=1>' . $dep[10]["no"] . '</font></td>
		</tr>
		<tr>
			<td><font size=1>Prefienre estar en casa a salir a actividades nuevas </font></td>
			<td width="7%" align="center"><font size=1>' . $dep[6]["si"] . '</font></td>
			<td width="7%" align="center"><font size=1>' . $dep[6]["no"] . '</font></td>
		</tr>
		<tr>
			<td><font size=1>Tiene mas problemas de memoria que los demás </font></td>
			<td width="7%" align="center"><font size=1>' . $dep[8]["si"] . '</font></td>
			<td width="7%" align="center"><font size=1>' . $dep[8]["no"] . '</font></td>
		</tr>
		<tr>
			<td><font size=1>Cree que es maravilloso estar vivo</font></td>
			<td width="7%" align="center"><font size=1>' . $dep[2]["si"] . '</font></td>
			<td width="7%" align="center"><font size=1>' . $dep[2]["no"] . '</font></td>
		</tr>
		<tr>
			<td><font size=1>Se siente inutil</font></td>
			<td width="7%" align="center"><font size=1>' . $dep[13]["si"] . '</font></td>
			<td width="7%" align="center"><font size=1>' . $dep[13]["no"] . '</font></td>
		</tr>
		<tr>
			<td><font size=1>Se siente lleno de energía</font></td>
			<td width="7%" align="center"><font size=1>' . $dep[4]["si"] . '</font></td>
			<td width="7%" align="center"><font size=1>' . $dep[4]["no"] . '</font></td>
		</tr>
		<tr>
			<td><font size=1>Se siente sin esperanza ante la situación actual</font></td>
			<td width="7%" align="center"><font size=1>' . $dep[12]["si"] . '</font></td>
			<td width="7%" align="center"><font size=1>' . $dep[12]["no"] . '</font></td>
		</tr>
		<tr>
			<td><font size=1>Siente que la mayoria de la gente está mejor que usted</font></td>
			<td width="7%" align="center"><font size=1>' . $dep[5]["si"] . '</font></td>
			<td width="7%" align="center"><font size=1>' . $dep[5]["no"] . '</font></td>
		</tr>';
    for ($i = 0; $i < 15; $i++) {
        $todepre += $dep[$i]["ts"];
    }

    $html .= '
		<tr>
			<td style="text-align: right;"><font size=1><b>SCORE</b></font></td>
			<th colspan=2><font size=1>' . $todepre . '</font></th>
		</tr>
	</table>
	<table>
		<tr>
			<td><font size=1>EN LA ULTIMA SEMANA : 0-5 = NORMAL // 6-10 = MODERADA // 11-15 = SEVERA </font></td>
		</tr>
	</table>
	<table width="100%">
		<tr>
			<td style="text-align: right;" colspan=3><font size=2>FECHA:</font>
	  	 	
	  	 	</td>
	  	 	<td>
	  	 	<table border="1" width="100%" cellspacing="0" cellpadding="2">
	  	 		<tr><td>
	  	 		<font size=2><center>' . $esg[0]["esg_fecha"] . '</center></font>
	  	 		</td>/tr>
	  	 	</table>
	  	 	</td>
		</tr>
		</table>
		<table width="100%">
		<tr>
			<td colspan=4>
				<font size=2>NUTRICIONAL</font>
			</td>
		</tr>
	</table>

	<table border="1" width="100%" cellspacing="0" cellpadding="2">
		<tr>
			<td>
				<font size=2>Dismunución de ingesta en ultimo trimestre</font>
			</td>
			<td>
				<font size=2><b>AU : </b> ' . $nut[0]["au"] . '</font>
			</td>
			<td>
				<font size=2><b>MO : </b> ' . $nut[0]["mo"] . '</font>
			</td>
			<td>
				<font size=2><b>SE : </b> ' . $nut[0]["se"] . '</font>
			</td>
		</tr>
		<tr>
			<td>
				<font size=2>Perdida de peso en ultimo trimestres <br>(4 opciones)</font>
			</td>
			<td align="center" colspan=3>
				<font size=2>' . $nut[4]["pat_result"] . '</font>
			</td>
			
		</tr>
		<tr>
			<td>
				<font size=2>Movilidad</font>
			</td>
			<td>
				<font size=2><b>VA :</b> ' . $nut[3]["va"] . '</font>
			</td>
			<td>
				<font size=2><b>SL :</b> ' . $nut[3]["sl"] . '</font>
			</td>
			<td>
				<font size=2><b>CS :</b> ' . $nut[3]["cs"] . '</font>
			</td>
		</tr>
		<tr>
			<td>
				<font size=2>Enfermedad aguada en ultimo trimestre</font>
			</td>
			<td>
				<font size=2>si : ' . $nut[1]["si"] . '</font>
			</td>
			<td>
				<font size=2>no : ' . $nut[1]["no"] . '</font>
			</td>
			<td>
				<font size=2> </font>
			</td>
		</tr>
			<tr>
			<td>
				<font size=2>Problema neuro psicologico <br> (Demencia o Depresión)</font>
			</td>
			<td>
				<font size=2>AU : ' . $nut[5]["au"] . '</font>
			</td>
			<td>
				<font size=2>MO : ' . $nut[5]["mo"] . '</font>
			</td>
			<td>
				<font size=2>SE : ' . $nut[5]["se"] . ' </font>
			</td>
		</tr>
		</tr>
		<tr>
			<td>
				<font size=2>Indice de masa corporal <br> (4 opciones)</font>
			</td>
			<td colspan=3 align="center">
				<font size=2>' . $nut[2][pat_result] . ' </font>
			</td>
		</tr>';
    for ($i = 0; $i < 6; $i++) {
        $tnutri += ($nut[$i]["pat_result"] + $nut[$i]["tau"] + $nut[$i]["tmo"] + $nut[$i]["tse"] + $nut[$i]["tva"] + $nut[$i]["tsl"] + $nut[$i]["tcs"] + $nut[$i]["tsi"]);
    }


    $html .= '
	    <tr>
			<td style="text-align: right; ">
				<font size=2><b>SCORE</b></font>
			</td>
			<th colspan=3 align="center">
				<font size=2>' . $tnutri . '</font>
			</th>
		</tr>

	</table>
	<table>
		<tr>
			<td><font size=1>RIESGO DE DESNUTRICIÓN : 12 o MAS = AUSENTE // MENOS DE 12 = PRESENTE</font></td>
		</tr>
	</table>	
  </td>
 </tr>
 </table>
 <table width="100%">
			<tr>
			<td><font size=1>SNS-MSP / HCU-form. 00000 / 2009</font></td>
			<td style="text-align:right;">
				<font size="3">ESCALAS GERIATRICAS</font>	
			</td>
		</tr>
		</table>
	</table>
</td>
</tr>

</table>
</div>
';
}
$html.='

	</body> 
	</html>

';
// CREACIÓN DE PDF 
$mpdf= new mPDF('c','A4-L','','arial');
$mpdf->writeHTML($html);
$mpdf->Output('Escala Geriatrica.pdf','I');

?>