<?php
require_once("../../../../js/lib/mpdf-6.1.3/mpdf.php");
include_once("../../../../php/class_consulta.php");
$Conaam=New Consulta();
$hce_id_fk=$_GET['h'];
# CARGAR DATOS DE ENCABEZADO. array 0
$aam=$Conaam->Get_Consulta("sgh_mei_adulto where hce_id_fk='".$hce_id_fk."' ORDER BY aam_fecha DESC","hce_id_fk,aam_id_pk,aam_fecha","","","",5);
//$mpdf->useOddEven = 1;
// HTML DE REPORTE

# code...

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
	<htmlpageheader name="myHeader1" style="display:none">


	</htmlpageheader>

	<htmlpagefooter name="myFooter1" style="display:none">
		<br>	
		<br>	
		<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt;

	    color: #000000; font-weight: bold; font-style: italic;">

	    <tr>

	    <td width="33%"><span style="font-weight: bold; font-style: italic;">SNS-MSP / HCU-form.057 / 2010</span></td>

	    <td width="33%" align="center" style="font-weight: bold; font-style: italic;"></td>

	    <td width="33%" style="text-align: right; ">ATENCIÓN AL ADULTO MAYOR</td>

	    </tr></table>

	</htmlpagefooter>

	<htmlpageheader name="Chapter2HeaderOdd" style="display:none">
	</htmlpageheader>

	<htmlpagefooter name="Chapter2FooterOdd" style="display:none">

		<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt;

	    color: #000000; font-weight: bold; font-style: italic;">

	    <tr>

	    <td width="33%"><span style="font-weight: bold; font-style: italic;">SNS-MSP / HCU-form.006 / 2008</span></td>

	    <td width="33%" align="center" style="font-weight: bold; font-style: italic;"></td>

	    <td width="33%" style="text-align: right; ">ATENCIÓN AL ADULTO MAYOR</td>

	    </tr></table>
	</htmlpagefooter>

	
';
for ($r=0; $r <count($aam) ; $r++) {
    $epi_id_pk=$aam[$r][aam_id_pk];
    $Con='Con'.$r;
    $ConDI='ConDI'.$r;
    $ConDE='ConDE'.$r;
    $onMT='onMT'.$r;
    $Consv='Consv'.$r;
    $Coni='Coni'.$r;

    $$Con=New Consulta();
    $$ConDI=New Consulta();
    $$ConDE=New Consulta();
    $$ConMT=New Consulta();
    $$Consv=New Consulta();
    $$Coni=New Consulta();

// CONSULTAS DE REPORRTE
    # CARGAR DATOS DE ENCABEZADO. array 0
    $per=$$Con->Get_Consulta("sgh_mei_adulto ep
		join sga_adm_historiaclinica as h on ep.hce_id_fk=h.hce_id_pk
		join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
		join sga_adm_persona as  per on p.per_id_fk=per.per_id_pk
		JOIN sga_adm_sexo as se on se.sex_id_pk=per.sex_id_fk","per_nombres,(per_apellidopaterno ||' '|| coalesce(per_apellidomaterno,'') ) as apellido,
			date_part('year',age(per_fechanacimiento)) as Edad,per_numeroidentificacion,sex_codigo as per_sexo","","aam_id_pk",$epi_id_pk,2);
    # CARGAR DIAGNOSTICO EGRESO
    $adul=$$ConDE->Get_Consulta("sgh_mei_adulto
        	JOIN sgu_usu_usuario as us on usu_id_fk = us.usu_id_pk
            JOIN sga_adm_profesional as pr on us.pro_id_fk=pro_id_pk
			      JOIN sga_adm_persona as pe  on pr.per_id_fk= pe.per_id_pk
			      JOIN sga_adm_profesion as pro on pr.prf_id_fk = pro.prf_id_pk","aam_id_pk,aam_inform,CASE WHEN aam_respon='USUARIO' THEN 'X' END AS US, CASE WHEN aam_respon='CUIDADOR' THEN 'X' END AS CU,aam_motivo,aam_enferm,aam_meqrec,CASE WHEN aam_esgene='DEPENDIENTE' THEN 'O' END AS dependiente,
  			CASE WHEN aam_esgene='FRAGIL' THEN 'O' END AS fragil,
  			CASE WHEN aam_esgene='INDEPENDIENTE' THEN 'O' END AS independiente,aam_reacsi,aam_antepe,aam_antfam,aam_exafis,aam_prudia,aam_trata,aam_fecha,per_nombres || ' ' ||per_apellidopaterno ||' '|| per_apellidomaterno as profecional, pr.pro_codigomsp",
        "","aam_id_pk",$epi_id_pk,2);
    # items de formulaio
    $items=$$Coni->Get_Consulta("sgh_mei_adulpro JOIN sgh_mei_respuesta as res on pat_id_fk= res.pat_id_pk where aam_id_fk=".$epi_id_pk."ORDER BY pat_item","pat_id_pk,pat_item,
     	CASE WHEN pat_result= 'f' THEN 'X' end as x,
    	CASE WHEN pat_result= 't' THEN 'O' end as o,
    	CASE WHEN pat_result= 'CP' THEN 'X' end as cp,
    	CASE WHEN pat_result= 'SP' THEN 'X' end as sp,
    	pat_result","","","",5);
    # CARGAR DIAGNOSTICO
    $dia=$$ConDI->Get_Consulta("sgh_mei_diacnadul
		join sgh_mei_diagnos as d on dia_id_fk=d.dia_id_pk
		JOIN sgh_mei_codigocie10 as c10  on d.c10_id_fk=c10.c10_id_pk","c10_nombre AS detalle,
			c10_codigo as cie,
			sgh_conbiertepre('1',dia_resp) as pre,
			sgh_conbiertepre('2',dia_resp) as def,dia_descrip",
        "","aam_id_fk",$epi_id_pk,2);
    //print_r ($DiagI);
    # CARGAR Signos vitales
    $sigv=$$Consv->Get_Consulta("sgh_mei_sgvadma sv
				join sgh_mei_adulto as ad on sv.aam_id_fk = ad.aam_id_pk
				join sgh_mei_signosvi as svi on sv.siv_id_fk = svi.siv_id_pk",
        "aam_id_pk,siv_id_pk,siv_prarta,siv_prarte,siv_temper,siv_pulso,siv_freres,siv_peso,siv_talla,siv_imc,siv_percint  ,siv_percad,siv_perpan,
				  CASE WHEN siv_defvis =TRUE  then 'X' END AS difi_visual,
				  CASE WHEN siv_defaud=TRUE  then 'X' END AS difi_audi,
				  CASE WHEN siv_levand=TRUE  then 'X' END AS levanta_anda,
				  CASE WHEN siv_peinor=TRUE  then 'X' END AS perdida_orina,
				  CASE WHEN siv_pemere=TRUE  then 'X' END AS perdida_memoria,
				  CASE WHEN siv_perpes=TRUE  then 'X' END AS perdida_peso,
				  CASE WHEN siv_triste=TRUE  then 'X' END AS triste,
				  CASE WHEN siv_pubaso=TRUE  then 'X' END AS baña_solo,
				  CASE WHEN siv_sacoso=TRUE  then 'X' END AS sale_compras,
				  CASE WHEN siv_vivsol=TRUE  then 'X' END AS vive_solo","","aam_id_pk",$epi_id_pk,2);

    $html.='
<div class="noheader"><br>
<!-- datos paciente -->	
<table border="1" width="100%" cellspacing="0" cellpadding="2"> 
	           <tr>
	              <th width="150"><center><h5>ESTABLECIMIENTO<h5></th>
	              <th width="150"><center><h5>APELLIDO Y NOMBRE<h5></center></th>
	              <th width="30"><center><h5>SEXO(M-F)<h5></center><div>
	              <th width="30"><center><h5>EDAD <h5></center></th>
	              <th width="150"><center><h5>N° HISTORIA CLÍNICA <h5></center></th>
	              
	              </div>
	               
	               </th>           
	              </font>
	              </tr>
	            </center>
	            <tr>
	              <td><center><font size=1>HOSPITAL GENERAL SANTO DOMINGO</font></center></td>
	              <td><center><font size=1>'.$per[0]["apellido"] .' ' .$per[0]["per_nombres"].'</font></center></td>
	              <td><center><font size=1>'.$per[0]["per_sexo"].'</font></center></td>
	              <td><center><font size=1>'.$per[0]["edad"].'</font></center></td>
	              <td><center><font size=1>'.$per[0]["per_numeroidentificacion"].'</font></center></td>   
	            </tr>  
	</table>
<!-- primera hoja  -->	
	<table border="1" width="100%" cellspacing="0" cellpadding="2">
		<tr>
		<td width="50%"><h5><b>1. MOTIVO DE CONSULTA</b><h5></td>
		<td ><font size=1><center>INFORMANTE<center></font></td>
		<td ><font size=1><center>'.$adul[0]["aam_inform"].'<center></font></td>
		<td ><font size=1><center>USUARIO<center></font></td>
		<td ><font size=1><center>'.$adul[0]["us"].'<center></font> </td>
		<td ><font size=1><center>CUIDADOR<center></font></td>
		<td ><font size=1><center>'.$adul[0]["cu"].'<center></font> </td>
		</tr>
		<tr>
			<td height="50" VALIGN="TOP" colspan=7>
			    <font size=1>'.$adul[0]["aam_motivo"].'</font>
			</td>
		</tr>
	</table>
	
	<table border="1" width="100%" cellspacing="0" cellpadding="2">
		<tr>
				<td width="50%" colspan=2><h5><b>2. ENFERMEDAD O PROBLEMA ACTUAL</b><h5></td>
				<td width="60%" style="text-align: right;"><font size=1>cronología localización, caracteristicas, intensidad, causa aparente, factores que agravan o mejoran sintomas asociados, evolución, resultados de exámenes anteriores, condición actual, atícas</font>
			</td>
		</tr>
		<tr>
			<td height="140" VALIGN="TOP" colspan="3">
				<font size=1>'.$adul[0]["aam_enferm"].'</font>
			</td>
		</tr>
		<tr>
			<td width="15%"><font size=1>MEDICAMENTOS QUE RECIBE</font></td>
			<td width="80"  colspan="2"><font size=1>'.$adul[0]["aam_meqrec"].' </font></td>
		</tr>
		<tr>
			<td width="15%"><font size=1>ESTADO GENERAL</font></td>
			<td width="80" colspan="2">
			<table>
				<tr>
					<td>
						<font size=1>Dependiente</font>
					</td>
					<th><font size=2>'.$adul[0]["dependiente"].' </font></th>
					<td>
						<font size=1>Fragil</font>
					</td>
					<th><font size=2>'.$adul[0]["fragil"].' </font></th>
					<td>
						<font size=1>Independiente</font>
					</td>
						<th><font size=2>'.$adul[0]["independiente"].' </font></th>
				
				</tr>
			</table>	
			</td>
		</tr>
     	<tr>
     	</tr>
	</table>
	<table border="1" width="100%" cellspacing="0" cellpadding="2">
		<tr>
	     <td width="40%" colspan="9"><h5>3. REVISIÓN ACTUAL DEL SISTEMA <h5></td>
	     	<td colspan="9" width="60%" style="text-align: right;">
					<font size=1><b>CP </b>: Con patología. Describir anotando el numero.<b>SP </b>: Sin patolía. No Describir</font>
			</td>	
		</tr>
					<tr>
						<td></td>
						<td><font size=1>CP</font></td>
						<td><font size=1>SP</font></td>
						<td></td>
						<td><font size=1>CP</font></td>
						<td><font size=1>SP</font></td>
						<td></td>
						<td><font size=1>CP</font></td>
						<td><font size=1>SP</font></td>
						<td></td>
						<td><font size=1>CP</font></td>
						<td><font size=1>SP</font></td>
						<td></td>
						<td><font size=1>CP</font></td>
						<td><font size=1>SP</font></td>
						<td></td>
						<td><font size=1>CP</font></td>
						<td><font size=1>SP</font></td>
					</tr>
					<tr>
					    <td><font size=1>1.Visión</font></td>
						<td><font size=1>'.$items[104]["cp"].'</font></td>
						<td><font size=1>'.$items[104]["sp"].'</font></td>

						<td><font size=1>2.Audisión</font></td>
						<td><font size=1>'.$items[15]["cp"].'</font></td>
						<td><font size=1>'.$items[15]["sp"].'</font></td>

						<td><font size=1>3.Ofato y gusto</font></td>
						<td><font size=1>'.$items[73]["cp"].'</font></td>
						<td><font size=1>'.$items[73]["sp"].'</font></td>

						<td><font size=1>4.Respiratorio</font></td>
						<td><font size=1>'.$items[93]["cp"].'</font></td>
						<td><font size=1>'.$items[93]["sp"].'</font></td>

						<td><font size=1>5.Cardio vascular</font></td>
						<td><font size=1>'.$items[91]["cp"].'</font></td>
						<td><font size=1>'.$items[91]["sp"].'</font></td>

						<td><font size=1>6.Digestivo</font></td>
						<td><font size=1>'.$items[92]["cp"].'</font></td>
						<td><font size=1>'.$items[92]["sp"].'</font></td>
					</tr>
					<tr>
						<td><font size=1>8.Genito urinario</font></td>
						<td><font size=1>'.$items[51]["cp"].'</font></td>
						<td><font size=1>'.$items[51]["sp"].'</font></td>

						<td><font size=1>9. Musculo esquelético</font></td>
						<td><font size=1>'.$items[90]["cp"].'</font></td>
						<td><font size=1>'.$items[90]["sp"].'</font></td>

						<td><font size=1>10.Endocrino</font></td>
						<td><font size=1>'.$items[48]["cp"].'</font></td>
						<td><font size=1>'.$items[48]["sp"].'</font></td>

						<td><font size=1>11.Hemo linfático</font></td>
						<td><font size=1>'.$items[53]["cp"].'</font></td>
						<td><font size=1>'.$items[53]["sp"].'</font></td>

						<td><font size=1>12.Nervioso</font></td>
						<td><font size=1>'.$items[68]["cp"].'</font></td>
						<td><font size=1>'.$items[68]["sp"].'</font></td>
						<td><font size=1></font></td>
						<td><font size=1></font></td>
						<td><font size=1></font></td>
					
					</tr>
					<tr>
						<td height="70" VALIGN="TOP" colspan=18 >
							<font size=1>'.$adul[0][aam_reacsi].'</font>
						</td>
				   </tr>			
	</table>
	
	<table border="1" width="100%" cellspacing="0" cellpadding="2">
		<tr>
	     <td width="40%"><h5>4. ANTECEDENTES PERSONALES <h5>
	     	</td>
	     	<td width="60%" style="text-align: right;">
					<font size=1><b>CP </b>: Con patología. Describir anotando el numero. <br><b>SP </b>: Sin patolía. No Describir</font>
			</td>	
		</tr>
		<tr>
			<td colspan=2>
			<table >
				<tr>
					<td>
						<font size="1"> <b>Alerta de Riesgos : </font>	
					</td>
					<td>
						<font size="1"> 1.-Caidas</font>	
					</td>
					<th>
						<font size="1">'.$items[19]["o"].'</font>	
					</th>
					<td>
						<font size="1"> 2.-Dismovilidad</font>	
					</td>
					<th>
						<font size="1">'.$items[41]["o"].'</font>	
					</th>					
					<td>
						<font size="1"> 3..-Pérdida de peso</font>	
					</td>
					<th>
						<font size="1">'.$items[83]["o"].'</font>	
					</th>
					<td>
						<font size="1"> 4.-Astenia</font>	
					</td>
					<th>
						<font size="1">'.$items[14]["o"].'</font>	
					</th>
					<td>
						<font size="1"> 5.-Desorientación</font>	
					</td>
					<th>
						<font size="1">'.$items[34]["o"].'</font>	
					</th>
					<td>
						<font size="1"> 6.-Alteración del comportamiento</b></font>	
					</td>
					<th>
						<font size="1">'.$items[7]["o"].'</font>	
					</th>
				</tr>
				
			</table>
			<table >
				<tr>
					<td>
						<font size="1"> <b></font>	
					</td>
					 <td><font size="1"> <b></font></td> <td><font size="1">CP<b></font></td> <td><font size="1">SP<b></font></td>
					 <td><font size="1"> <b></font></td> <td><font size="1">CP<b></font></td> <td><font size="1">SP<b></font></td>
					 <td><font size="1"> <b></font></td> <td><font size="1">CP<b></font></td> <td><font size="1">SP<b></font></td>
					 <td><font size="1"> <b></font></td> <td><font size="1">CP<b></font></td> <td><font size="1">SP<b></font></td>
					 <td><font size="1"> <b></font></td> <td><font size="1">CP<b></font></td> <td><font size="1">SP<b></font></td>
				</tr>
				<tr>
					<td>
						<font size="1"> <b>Generales : </font>	
					</td>
					<td>
						<font size="1"> 1.-Imunizacion</font>	
					</td>
					<th>
						<font size="1">'.$items[59]["cp"].'</font>	
					</th>
					<th>
						<font size="1">'.$items[59]["sp"].'</font>	
					</th>

					<td>
						<font size="1"> 2.-Higiene general</font>	
					</td>
					<th>
						<font size="1">'.$items[55]["cp"].'</font>	
					</th>
					<th>
						<font size="1">'.$items[55]["sp"].'</font>	
					</th>

					<td>
						<font size="1"> 3..-Higiene oral de peso</font>	
					</td>
					<th>
						<font size="1">'.$items[56]["cp"].'</font>	
					</th>
					<th>
						<font size="1">'.$items[56]["sp"].'</font>	
					</th>


					<td>
						<font size="1"> 4.-Ejercicio</font>	
					</td>
					<th>
						<font size="1">'.$items[44]["cp"].'</font>	
					</th>
					<th>
						<font size="1">'.$items[44]["sp"].'</font>	
					</th>

					<td>
						<font size="1"> 5.-Alimentación</font>	
					</td>
					<th>
						<font size="1">'.$items[6]["cp"].'</font>	
					</th>
					<th>
						<font size="1">'.$items[6]["sp"].'</font>	
					</th>

				</tr>
				</tr>
					<tr>
					<td>
						<font size="1"> <b></font>	
					</td>
					<td>
						<font size="1"> 6.-Actividad recreativa</b></font>	
					</td>
					<th>
						<font size="1">'.$items[1]["cp"].'</font>	
					</th>
					<th>
						<font size="1">'.$items[1]["sp"].'</font>	
					</th>
					<td>
						<font size="1"> 7.-Controles de salud</b></font>	
					</td>
					<th>
						<font size="1">'.$items[26]["cp"].'</font>	
					</th>
					<th>
						<font size="1">'.$items[26]["sp"].'</font>	
					</th>
					<td>
						<font size="1"> 8.-Alergias</b></font>	
					</td>
					<th>
						<font size="1">'.$items[5]["cp"].'</font>	
					</th>
					<th>
						<font size="1">'.$items[5]["sp"].'</font>	
					</th>
					<td>
						<font size="1"> 9.-otros</b></font>	
					</td>
					<th>
						<font size="1">'.$items[79]["cp"].'</font>	
					</th>
					<th>
						<font size="1">'.$items[79]["sp"].'</font>	
					</th>
				</tr>	
				</table>
				
			<table>
				<tr>
					<td>
						<font size="1"> <b>Hábitos nocivos : </font>	
					</td>
					<td>
						<font size="1"> 1.-Tabaquismo</font>	
					</td>
					<th>
						<font size="1">'.$items[97]["o"].'</font>	
					</th>
					<td>
						<font size="1"> 2.-Alcholismo</font>	
					</td>
					<th>
						<font size="1">'.$items[4]["o"].'</font>	
					</th>
					<td>
						<font size="1"> 3.-Adicciones</font>	
					</td>
					<th>
						<font size="1">'.$items[2]["o"].'</font>	
					</th>
					<td>
						<font size="1"> 4.-Otro habito</font>	
					</td>
					<th>
						<font size="1">'.$items[78]["o"].'</font>	
					</th>
				</tr>
			</table>
			<table>
				<tr>
					<td>
						<font size="1"> <b>Clínica quirúrgica : </font>	
					</td>
					<td>
						<font size="1"> 1.-Demartológico</font>	
					</td>
					<th>
						<font size="1">'.$items[33]["o"].'</font>	
					</th>
					<td>
						<font size="1"> 2.-Visuales</font>	
					</td>
					<th>
						<font size="1">'.$items[105]["o"].'</font>	
					</th>
					<td>
						<font size="1"> 3.-Otorrino</font>	
					</td>
					<th>
						<font size="1">'.$items[76]["o"].'</font>	
					</th>
					<td>
						<font size="1"> 4.-Estomatologicos</font>	
					</td>
					<th>
						<font size="1">'.$items[49]["o"].'</font>	
					</th>
					<td>
						<font size="1"> 5.-Endocrinos</font>	
					</td>
					<th>
						<font size="1">'.$items[46]["o"].'</font>	
					</th>
					<td>
						<font size="1"> 6.-Cardio vascular</font>	
					</td>
					<th>
						<font size="1">'.$items[20]["o"].'</font>	
					</th>
					<td>
						<font size="1"> 7.-Respiratorio</font>	
					</td>
					<th>
						<font size="1">'.$items[95]["o"].'</font>	
					</th>
					<td>
						<font size="1"> 8.-Digestivos</font>	
					</td>
					<th>
						<font size="1">'.$items[39]["o"].'</font>	
					</th>
				</tr>
			</table>
			<table>
				<tr>
					<td>
						<font size="1"> 9.-Neurológico</font>	
					</td>
					<th>
						<font size="1">'.$items[69]["o"].'</font>	
					</th>
					<td>
						<font size="1"> 10.-Urologicos</font>	
					</td>
					<thh>
						<font size="1">'.$items[102]["o"].'</font>	
					</thh>
					<td>
						<font size="1"> 11.-Hemolinfaticos</font>	
					</td>
					<th>
						<font size="1">'.$items[54]["o"].'</font>	
					</thh>
					<td>
						<font size="1"> 12.-Infecciosos</font>	
					</td>
					<th>
						<font size="1">'.$items[58]["o"].'</font>	
					</th>
					<td>
						<font size="1"> 13.-Oncológicos</font>	
					</td>
					<th>
						<font size="1">'.$items[74]["o"].'</font>	
					</th>
					<td>
						<font size="1"> 14.-Musculo esqueléticos</font>	
					</td>
					<th>
						<font size="1">'.$items[64]["o"].'</font>	
					</th>
					<td>
						<font size="1"> 15.-Psiquiátrico</font>	
					</td>
					<th>
						<font size="1">'.$items[89]["o"].'</font>
					</th>	
				</tr>
			</table>
			<table  width="100%">
				<tr>
				    <td>
						<font size="1"> <b>Gineco obstetrico: </font>	
					</td>
					<td>
						<font size="1"> 1.-Edad menopausia</font>	
					</td>
					<td>
						<font size="1">'.$items[61]["pat_result"].'</font>	
					</td>
					<td>
						<font size="1"> 2.-Edad de ultima mamografia</font>	
					</td>
					<td>
						<font size="1">'.$items[60]["pat_result"].'</font>	
					</td>
					<td>
						<font size="1"> 3.-Edad de ultima citología</font>	
					</td>
					<td>
						<font size="1">'.$items[24]["pat_result"].'</font>	
					</td>	
					<td>
						<font size="1"> 4.-Embarazos</font>	
					</td>
					<td>
						<font size="1">'.$items[45]["pat_result"].'</font>	
					</td>	
					<td>
						<font size="1"> 5.-Partos</font>	
					</td>
					<td>
						<font size="1">'.$items[82]["pat_result"].'</font>	
					</td>
					<td>
						<font size="1"> 6.-Cesáreas</font>	
					</td>
					<td>
						<font size="1">'.$items[23]["pat_result"].'</font>	
					</td>
					<td>
						<font size="1"> 7.-Terapia hormonal</font>	
					</td>
					<td>
						<font size="1">'.$items[98]["pat_result"].'</font>	
					</td>		
				</tr>
			</table>
			<table  >
				<tr>
				    <td>
						<font size="1"> <b>Andrológia: </font>	
					</td>
					<td>
						<font size="1"> 1.-Edad ultimo antígeno prostático</font>	
					</td>
					<td width=30>
						<font size="1">'.$items[87]["pat_result"].'</font>	
					</td>
					<td>
						<font size="1"> 2.-Terapia hormonal</font>	
					</td>
					<td width=30>
						<font size="1">'.$items[99]["pat_result"].'</font>	
					</td>
					
				</tr>
			</table>
			<table>
				<tr>
					<td>
						<font size="1"> <b>Farcológico: </font>	
					</td>
					<td>
						<font size="1">1.-Aines</font>	
					</td>
					<td>
						<font size="1">'.$items[3]["o"].'</font>	
					</td>
					<td>
						<font size="1"> 2.-Analgésicos</font>	
					</td>
					<td>
						<font size="1">'.$items[9]["o"].'</font>	
					</td>
					<td>
						<font size="1"> 3.-Anti diabéticos</font>	
					</td>
					<td>
						<font size="1">'.$items[12]["o"].'</font>	
					</td>
					<td>
						<font size="1"> 4.-Anti hipertensivos</font>	
					</td>
					<td>
						<font size="1">'.$items[13]["o"].'</font>	
					</td>
					<td>
						<font size="1"> 5.-Anti cuagulantes</font>	
					</td>
					<td>
						<font size="1">'.$items[11]["o"].'</font>	
					</td>
					<td>
						<font size="1"> 6.-Psico fármacos</font>	
					</td>
					<td>
						<font size="1">'.$items[88]["o"].'</font>	
					</td>
					<td>
						<font size="1"> 7.-Antibióticos</font>	
					</td>
					<td>
						<font size="1">'.$items[10]["o"].'</font>	
					</td>
					<td>
						<font size="1"> 8.-Otros</font>	
					</td>
					<td>
						<font size="1">'.$items[77]["o"].'</font>	
					</td>
				</tr>
			</table>
			<table>
				<tr>
					<td>
						<font size="1"> 9.-Números de prescriptores</font>	
					</td>
					<td>
						<font size="1">'.$items[86]["pat_result"].'</font>	
				</tr>
				
			</table>
			<table border=1 width=100% cellspacing="0" cellpadding="2">		
					<tr>
						<td height="80" VALIGN="TOP" colspan=18 >
							<font size="1">'.$adul[0]["aam_antepe"].'</font>
						</td>
				   </tr>			
				</table>
			</td>
		</tr>
	</table>

	<table border="1" width="100%" cellspacing="0" cellpadding="2">
		<tr>
	     <td colspan=9 width="40%"><h5>5. ANTECEDENTES FAMILIARES Y SOCIALESS <h5></td>
	     	<td colspan=9 width="60%" style="text-align: right;">
					<font size=1><b>CP </b>: Con patología. Describir anotando el numero. <b>SP </b>: Sin patolía. No Describir</font>
			</td>	
		</tr>
			
					<tr>
						<td></td>
						<td><font size=1>CP</font></td>
						<td><font size=1>SP</font></td>
						<td></td>
						<td><font size=1>CP</font></td>
						<td><font size=1>SP</font></td>
						<td></td>
						<td><font size=1>CP</font></td>
						<td><font size=1>SP</font></td>
						<td></td>
						<td><font size=1>CP</font></td>
						<td><font size=1>SP</font></td>
						<td></td>
						<td><font size=1>CP</font></td>
						<td><font size=1>SP</font></td>
						<td></td>
						<td><font size=1>CP</font></td>
						<td><font size=1>SP</font></td>
					</tr>
					<tr>
					    <td><font size=1>1.Cardiopatías</font></td>
						<th>
							<font size="1">'.$items[21]["cp"].'</font>
						</th>
						<th>
							<font size="1">'.$items[21]["sp"].'</font>
						</th>

						<td><font size=1>2.Diabetes</font></td>
						<th>
							<font size="1">'.$items[36]["cp"].'</font>
						</th>
						<th>
							<font size="1">'.$items[36]["sp"].'</font>
						</th>

						<td><font size=1>3.Hipertención artesanal</font></td>
						<th>
							<font size="1">'.$items[57]["cp"].'</font>
						</th>
						<th>
							<font size="1">'.$items[57]["sp"].'</font>
						</th>

						<td><font size=1>4.Neoplasia</font></td>
						<th>
							<font size="1">'.$items[67]["cp"].'</font>
						</th>
						<th>
							<font size="1">'.$items[67]["sp"].'</font>
						</th>

						<td><font size=1>5.Alzheimer</font></td>
						<th>
							<font size="1">'.$items[8]["cp"].'</font>
						</th>
						<th>
							<font size="1">'.$items[8]["sp"].'</font>
						</th>

						<td><font size=1>6.Parkinson</font></td>
						<th>
							<font size="1">'.$items[81]["cp"].'</font>
						</th>
						<th>
							<font size="1">'.$items[81]["sp"].'</font>
						</th>
					</tr>
					<tr>
						<td><font size=1>7.Tuberculosis</font></td>
						<th>
							<font size="1">'.$items[101]["cp"].'</font>
						</th>
						<th>
							<font size="1">'.$items[101]["sp"].'</font>
						</th>

						<td><font size=1>8. Violencia intrafamiliar</font></td>
						<th>
							<font size="1">'.$items[103]["cp"].'</font>
						</th>
						<th>
							<font size="1">'.$items[103]["sp"].'</font>
						</th>

						<td><font size=1>9.Sindrome del cuidador</font></td>
						<th>
							<font size="1">'.$items[96]["cp"].'</font>
						</th>
						<th>
							<font size="1">'.$items[96]["sp"].'</font>
						</th>

						<td><font size=1>10.Otros</font></td>
						<th>
							<font size="1">'.$items[80]["cp"].'</font>
						</th>
						<th>
							<font size="1">'.$items[80]["sp"].'</font>
						</th>
						<td><font size=1></font></td>
						<th><font size="1"></font></th>
						<th><font size="1"></font></th>
						<td><font size=1></font></td>
						<th><font size="1"></font></th>
						<th><font size="1"></font></th>
					</tr>
					<tr>
						<td height="75" VALIGN="TOP" colspan=18 >
							<font size=1>'.$adul[0][aam_antfam].'</font>
						</td>
				   </tr>			
	</table>
	</div>
<!-- 2 hoja  -->	
<div class="chapter2">

<table border="1" width="100%" cellspacing="0" cellpadding="2">
		<tr>
		 <td width="33%"><H5><b>6. SIGNOS VITALES, ANTROPOMETRÍA Y TAMIZAJE</b><H5></td>
			H5></td>
		</tr>
		<tr>
			<td>
				<table width="100%" >
					<tr>
					   <td> <center><font size=1>P.ARTERIAL ACOSTADO<font> </center>
					    </td> 
                         <td> <center><font size=1>P.ARTERIAL SENTADO<font></center>
                         </td>
                         <td><center><font size=1>TEMPERATURA °C<font></center>
                         </td>
                         <td><center><font size=1>PULSO<font></center>
                         </td>
                         <td><center><font size=1>FRECUENCIA RESPIRATORIA / MIN <font></center>
                         </td>
                         <td><center><font size=1>PESO. Kg <font></center>
                         </td>
					</tr>
					<tr>
					   <td> <center><font size=1><font>'.$sigv[0]["siv_prarta"].' </center>
					    </td> 
					  
                         <td> <center><font size=1>'.$sigv[0]["siv_prarte"].'<font></center>
                         </td>

                         <td><center><font size=1>'.$sigv[0]["siv_temper"].'<font></center>
                         </td>
                         <td><center><font size=1>'.$sigv[0]["siv_pulso"].'<font></center>
                         </td>
                         <td><center><font size=1>'.$sigv[0]["siv_freres"].'<font></center>
                         </td>
                         <td><center><font size=1>'.$sigv[0]["siv_peso"].'<font></center>
                         </td>
					</tr>
				</table>
				<table width="100%">
					<tr>
						<td>
							<font size=1><b>TAMIZAJE RAPIDO</b></font>
						</td>
						<td>
							<font size=1><center>1 Dificultad Visual</center></font>
						</td>
							<td>
							<font size=1><center>'.$sigv[0]["difi_visual"].'</center></font>
						</td>
						<td>
							<font size=1><center>2 Dificultad Auditiva</center></font>
						</td>
							<td>
							<font size=1><center>'.$sigv[0]["difi_audi"].'</center></font>
						</td>
						<td>
							<font size=1><center>3 
							"Lebantate y anda " Mayor a 15a</center></font>
						</td>
							<td>
							<font size=1><center>'.$sigv[0]["levanta_anda"].'</center></font>
						</td>
						<td>
							<font size=1><center>4 Pérdida invt. de orina</center></font>
						</td>
							<td>
							<font size=1><center>'.$sigv[0]["perdida_orina"].'</center></font>
						</td>
						<td>
							<font size=1><center>5 Pérdida de memoria reciente</center></font>
						</td>
							<td>
							<font size=1><center>'.$sigv[0]["perdida_memoria"].'</center></font>
						</td>
							<td>
							<font size=1><center>6 Pierde peso mas de 4.5 kg. en 6 meses</center></font>
						</td>
							<td>
							<font size=1><center>'.$sigv[0]["perdida_peso"].'</center></font>
						</td>
					</tr>
				</table>
				<table >	
					<tr>
						<td>
							<font size=1>7 Se siente triste o deprimido</font>
						</td>
												<td>
							<font size=1><center>'.$sigv[0]["triste"].'</center></font>
						</td>
						<td>
							<font size=1><center>8 Puede Bañarse solo</center></font>
						</td>
						<td>
							<font size=1><center>'.$sigv[0]["baña_solo"].'</center></font>
						</td>
						<td>
							<font size=1><center>9 Sale de compras solo </center></font>
						</td>
							<td>
							<font size=1><center>'.$sigv[0]["sale_compras"].'</center></font>
						</td>
							<td>
							<font size=1><center>10 Vive solo</center></font>
						</td>
							<td>
							<font size=1><center>'.$sigv[0]["vive_solo"].'</center></font>
						</td>
					</tr>
				</table>
			</td>
		</tr>

	</table>
	<table  border="1" width="100%" cellspacing="0" cellpadding="2">
			<tr>
	    			<td colspan=7 width="" ><h5>7. EXAMEN FISICO</h5></td>
	    			<td colspan=6 width="" ><font size=1>REGIONAL(1-14) SISTÉMICO(1-9)</font></td>
	    			<td colspan=11 width="" style="text-align: right;">
					<font size=1><b>CP </b>: Con patología. Describir anotando el numero. <b>SP </b>: Sin patolía. No Describir</font>
			</td>
	    	</tr>
	 
	    			<tr>
	    			    <td></td> <td><font size=1>CP</font></td> <td><font size=1>SP</font></td>
                        <td></td> <td><font size=1>CP</font></td> <td><font size=1>SP</font></td>
                        <td></td> <td><font size=1>CP</font></td> <td><font size=1>SP</font></td>
                        <td></td> <td><font size=1>CP</font></td> <td><font size=1>SP</font></td>
                        <td></td> <td><font size=1>CP</font></td> <td><font size=1>SP</font></td>
                        <td></td> <td><font size=1>CP</font></td> <td><font size=1>SP</font></td>
                        <td></td> <td><font size=1>CP</font></td> <td><font size=1>SP</font></td>
                        <td></td> <td><font size=1>CP</font></td> <td><font size=1>SP</font></td>

                     </tr>  
                     <tr>
                       <td><font size=1> 1 Pifi</font></td> 
                       <td><font size=1>'.$items[85]["cp"] .' </font></td> <td><font size=1>'.$items[85]["sp"] .'</font></td>
                       <td><font size=1> 2 Cabeza</font></td> 
                       <td><font size=1>'.$items[18]["cp"] .' </font></td> <td><font size=1>'.$items[18]["sp"] .'</font></td>
                       <td><font size=1> 3 Ojos</font></td> 
                       <td><font size=1>'.$items[72]["cp"] .' </font></td> <td><font size=1>'.$items[72]["sp"] .'</font></td>
                       <td><font size=1> 4 Oídos</font></td> 
                       <td><font size=1>'.$items[71]["cp"] .' </font></td> <td><font size=1>'.$items[71]["sp"] .'</font></td>
                       <td><font size=1> 5 Boca</font></td> 
                      <td><font size=1>'.$items[17]["cp"] .' </font></td> <td><font size=1>'.$items[17]["sp"] .'</font></td>		
                       
                       <td><font size=1> 1 Org. de los sentidos </font></td> 
                       <td><font size=1>'.$items[75]["cp"] .' </font></td> <td><font size=1>'.$items[75]["sp"] .'</font></td>
                       <td><font size=1> 2 Respiratorio</font></td> 
                       <td><font size=1>'.$items[94]["cp"] .' </font></td> <td><font size=1>'.$items[94]["sp"] .'</font></td>
                       <td><font size=1> 3 Cardio vascular</font></td> 
                       <td><font size=1>'.$items[22]["cp"] .' </font></td> 
                       <td> <font size=1>'.$items[22]["sp"].' </font></td>
                    	
                    </tr>
                    <tr>
                       
                       <td><font size=1> 6 Nariz</font></td> 
                      <td><font size=1>'.$items[66]["cp"] .' </font></td> <td><font size=1>'.$items[66]["sp"] .'</font></td>
                       <td><font size=1> 7 Cuello</font></td> 
                       <td><font size=1>'.$items[27]["cp"] .' </font></td> <td><font size=1>'.$items[27]["sp"] .'</font></td>
                       <td><font size=1> 8 Axila-mama</font></td> 
                       <td><font size=1>'.$items[16]["cp"] .' </font></td> <td><font size=1>'.$items[16]["sp"] .'</font></td>
                        <td><font size=1> 9 Torax</font></td> 
                       <td><font size=1>'.$items[100]["cp"] .' </font></td> <td><font size=1>'.$items[100]["sp"] .'</font></td>
                       <td><font size=1> 10 Abdomen</font></td> 
                       <td><font size=1>'.$items[0]["cp"] .' </font></td> <td><font size=1>'.$items[0]["sp"] .'</font></td>
                      
                       <td><font size=1> 4 Digestivo vascular</font></td> 
                       <td><font size=1>'.$items[38]["cp"] .' </font></td> <td><font size=1>'.$items[38]["sp"] .'</font></td>
                       <td><font size=1> 5 Genito urinario </font></td> 
                       <td><font size=1>'.$items[50]["cp"] .' </font></td> <td><font size=1>'.$items[50]["sp"] .'</font></td>
                       <td><font size=1> 6 Músculo</font></td> 
                       <td><font size=1>'.$items[65]["cp"] .' </font></td> <td><font size=1>'.$items[65]["sp"] .'</font></td>
                       
                       
                    </tr>
                     <tr>
                       <td><font size=1> 11 Columna</font></td> 
                      <td><font size=1>'.$items[25]["cp"] .' </font></td> <td><font size=1>'.$items[25]["sp"] .'</font></td>
                       <td><font size=1> 12 Periné</font></td> 
                       <td><font size=1>'.$items[84]["cp"] .' </font></td> <td><font size=1>'.$items[84]["sp"] .'</font></td>
                       <td><font size=1> 13 M superior	</font></td> 
                       <td><font size=1>'.$items[63]["cp"] .' </font></td> <td><font size=1>'.$items[63]["sp"] .'</font></td>
					   <td><font size=1> 14 M inferior	</font></td> 
                       <td><font size=1>'.$items[62]["cp"] .' </font></td> <td><font size=1>'.$items[62]["sp"] .'</font></td>
                       <td><font size=1> 		</font></td> 
                      <td><font size=1> </font></td> <td><font size=1> </font></td>

                       <td><font size=1> 7 Endocrino</font></td> 
                      <td><font size=1>'.$items[47]["cp"] .' </font></td> <td><font size=1>'.$items[47]["sp"] .'</font></td>
                        <td><font size=1> 8 Hemolinfáticos</font></td> 
                      <td><font size=1>'.$items[52]["cp"] .' </font></td> <td><font size=1>'.$items[52]["sp"] .'</font></td>
                       <td><font size=1> 9 Neurológico</font></td> 
                      <td><font size=1>'.$items[70]["cp"] .' </font></td> <td><font size=1>'.$items[70]["sp"] .'</font></td>
                    
                    </tr>
               
               
                    <tr>
						<td height="350" VALIGN="TOP" colspan=24>
							<font size=1>'.$adul[0][aam_exafis].'</font>
						</td>
							
					</tr>
	</table>
	<table width=100%>
	  <tr>
	  	<td VALIGN="TOP">	
			<table border="1" width="100%" cellspacing="0" cellpadding="2">
		    		<tr>
		    			<td width="225" colspan="2"> <h5><b>8. DIAGNÓSTICO </b></h5></td>
		    			<th width="10" > <font size=1>P</font></th>  
		    			<th width="10" > <font size=1>D</font></th>
		    			<th width="20" > <font size=1>CIE</font></th>  
		    			<th width="70" > <font size=1>Clínico, Sindrómico, Psicologico, <br>Funcional, Nutricional </font></th>
		    			  
		    		</tr>';

    for ($i=0; $i < 4; $i++) {
        $it=$i+1;
        $html .='<tr>
                            
		    		   		<td width="0.1"><font size=1>'.$it.'</font></td>
		    		   		<td width=""><font size=1>'.$dia[$i]["detalle"].'</font></td>
		    		   		<td width=""><font size=1><center>'.$dia[$i]["pre"].'</center></font></td>
		    		   		<td width=""><font size=1><center>'.$dia[$i]["def"].'</center></font></td>
		    		   		<td width=""><font size=1><center>'.$dia[$i]["cie"].'</center></font></td>

		    		   		<td width=""><font size=1><center>'.$dia[$i]["dia_descrip"].'</center></font></td>
		    		   		
		    				</tr>';
    }
    $html .='
		    </table>
	    </td>
	    <td VALIGN="TOP" width=280>
	    	<table  border="1" width="100%	" cellspacing="0" cellpadding="2">
	    		<tr>
	    			<th colspan=4>
	    				<center><font size="2">SINDROMES GERIÁTRICOS</font></center>
	    			</th>
	    		</tr>
	    		<tr>
	    			<td>
	    				<font size="1">Fragilidad</font>
	    			</td>
	    			<th><font size=1>'.$items[35]["o"] .'</font></th>
	    			<td>
	    				<font size="1">Dismovilidad</font>
	    			</td>
	    			<th><font size=1>'.$items[32]["o"] .'</font></th>
	    		</tr>
	    		<tr>
	    			<td>
	    				<font size="1">Depresión</font>
	    			</td>
	    			<th><font size=1>'.$items[31]["o"] .'</font></th>
	    			<td>
	    				<font size="1">Caida</font>
	    			</td>
	    			<th><font size=1>'.$items[28]["o"] .'</font></th>
	    		</tr>
	    		<tr>
	    			<td>
	    				<font size="1">Delirio</font>
	    			</td>
	    			<th><font size=1>'.$items[29]["o"] .'</font></th>
	    			<td>
	    				<font size="1">Mal nutrición</font>
	    			</td>
	    			<th><font size=1>'.$items[42]["o"] .'</font></th>
	    		</tr>
	    		<tr>
	    			<td>
	    				<font size="1">Úlceras por presión</font>
	    			</td>
	    			<th><font size=1>'.$items[43]["o"] .'</font></th>
	    			<td>
	    				<font size="1">Demencia</font>
	    			</td>
	    			<th><font size=1>'.$items[30]["o"] .'</font></th>
	    		</tr>
	    		<tr>
	    			<td>
	    				<font size="1">Incontinecia</font>
	    			</td>
	    			<th><font size=1>'.$items[40]["o"] .'</font></th>
	    			<td>
	    				<font size="1">iatrogenia</font>
	    			</td>
	    			<th><font size=1>'.$items[37]["o"] .'</font></th>
	    		</tr>
	    	</table>
	    </td>
     </tr>
    </table> 	
	<table border="1" width="100%" cellspacing="0" >
		<tr>
	     <td width="33%"><H5><b>9 PRUEBAS DIAGNÓSTICAS</b><H5></td>
			h4></td>	
		</tr>
		<td width="33%" style="text-align: right;"><font size=1>REGIDTRAR LOS EXÁMENES DE LABORATORIO Y ESPECIALES SOLICITADOS<font></td>
			h4></td>	
		</tr>
		<tr>
			<td height="70" VALIGN="TOP" colspan=2>
				<font size=1>'.$adul[0]["aam_prudia"].'</font>
			</td>
				
		</tr>
	</table>
	<table border="1" width="100%" cellspacing="0" >
		<tr>
	     <td width="33%"><H5><b>10 TRATAMIENTO</b><H5></td>
			h4></td>	
		</tr>
		<td width="33%" style="text-align: right;"><font size=1>1.- Funcional, 2.-Nutricional, 3.-Psicologico, 4.-Social, 5.-Educativo, 6.-Faramcologico<font></td>
			h4></td>	
		</tr>
		<tr>
			<td height="150" VALIGN="TOP" colspan=2>
				<font size=1>'.$adul[0]["aam_trata"].'</font>
			</td>
				
		</tr>
	</table>


	<table border="1" cellspacing="0" width="100%"> 
		<tr>
			<th width="95"><font size=1>Profesional</center></th>
			<th width="150"><center><font size=1>Firma</font></center></th> 
			<th width="50"><center><font size=1>Código</font></center></th>
			<th width="20"><font size=1>Fecha Próxima cita</center></th>
			<th width="30"><font size=1>Fecha y hora</center></th>
			<th width="5"><font size=1>Hoja </center></th>
			
		</tr>
		<tr>
			<td width="95"><font size=1>'.$adul[0]["profecional"].'  </center></td>
			<td width="150"><center><font size=1>  </font></center></td> 
			<td width="50"><center><font size=1> '.$adul[0]["pro_codigomsp"].' </font></center></td>
			<td width="10"><center><font size=1></font></center></td>
			<td width="30"><center><font size=1>'.$adul[0]["aam_fecha"].'</font></center></td>
			<td width="5"><center><font size=1>2</font></center></td>
		</tr>
	</table>
	</div>';
}
$html.='
	</body>
	</html>

';



// CREACIÓN DE PDF 
$mpdf= new mPDF('c','A4','','');
$mpdf->writeHTML($html);
$mpdf->Output('Adulto mayor.pdf','I');

?>