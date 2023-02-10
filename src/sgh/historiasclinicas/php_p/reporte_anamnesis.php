<?php
require_once '../../../../vendor/autoload.php';
include_once("../../../../php/class_consulta.php");
use Mpdf\Mpdf;
$mpdf = new mPDF(['debug' => true,'mode'=>'utf-8','format'=>'A4']);
$Con=New Consulta();
$ConDI=New Consulta();
$ConDE=New Consulta();
$ConMT=New Consulta();
$Consv=New Consulta();
$Coni=New Consulta();
$entidad=$Con->entidad;

$Cona=New Consulta();
$hcl_id_fk=$_GET['h'];
$fi=$_GET['fi'];
$fa=$_GET['fa'];
// CONSULTAS DE REPORRTE
$anamesis=$Cona->Get_Consulta("sgh_mei_anamnesis where ana_fecha >='$fi' and ana_fecha <='$fa' and hce_id_fk= '".$hcl_id_fk."'ORDER BY ana_fecha DESC ","ana_id_pk,hce_id_fk","","","",5);



//$mpdf->useOddEven = 1;
// HTML DE REPORTE 

	# code...

$html= '

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

	    <td width="33%"><font size="1">SNS-MSP / HCU-form.003 / 2008</font></td>

	    <td width="33%" align="center" style="font-weight: bold; font-style: italic;"></td>

	    <td width="33%" style="text-align: right; "><font size="3">ANAMNESIS</font></td>

	    </tr></table>

	</htmlpagefooter>

	<htmlpagefooter name="Chapter2FooterOdd" style="display:none">

		<table width="100%">

	    <tr>

	    <td width="33%"><font size="1"><b> SNS-MSP / HCU-form.003 / 2008</b></font></td>

	    <td width="33%" align="center" style="font-weight: bold; font-style: italic;"></td>

	    <td width="33%" style="text-align: right; "><font size="3"><b>EXAMEN FÍSICO</b></font></td>

	    </tr></table>
	</htmlpagefooter>

	';

for ($r=0; $r <count($anamesis) ; $r++) {
    $Con = 'Con'.$r;
    $ConDI='ConDI'.$r;
    $ConDE='ConDE'.$r;
    $Consv='Consv'.$r;
    $Coni='Coni'.$r;

    $ana_id_pk=$anamesis[$r]["ana_id_pk"];

    $$Con=New Consulta();
    $$ConDI=New Consulta();
    $$ConDE=New Consulta();
    $$Consv=New Consulta();
    $$Coni=New Consulta();


    # CARGAR DATOS DE ENCABEZADO. array 0
    $per=$$Con->Get_Consulta("sgh_mei_anamnesis ep
		join sga_adm_historiaclinica as h on ep.hce_id_fk=h.hce_id_pk
		join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
		join sga_adm_persona as  per on p.per_id_fk=per.per_id_pk
		JOIN sga_adm_sexo as se on se.sex_id_pk=per.sex_id_fk","per_nombres,(per_apellidopaterno ||' '|| per_apellidomaterno ) as apellido,
			date_part('year',age(per_fechanacimiento)) as Edad,per_numeroidentificacion,sex_codigo as per_sexo","","ana_id_pk",$ana_id_pk,2);
# CARGAR datos generales anamnesis
    $ana=$$ConDE->Get_Consulta("sgh_mei_anamnesis
        	JOIN sgu_usu_usuario as us on usu_id_fk = us.usu_id_pk
            JOIN sga_adm_profesional as pr on us.pro_id_fk=pro_id_pk
			      JOIN sga_adm_persona as pe  on pr.per_id_fk= pe.per_id_pk
			      JOIN sga_adm_profesion as pro on pr.prf_id_fk = pro.prf_id_pk","ana_id_pk,ana_motivo,ana_menarq,ana_menopa,ana_ciclos,CASE when ana_vidasex = true then 'x' END as vidasex,ana_gesta,ana_paros,ana_aborto,ana_cesarea,ana_hijosv,
  ana_fum,ana_fup,ana_fuc, CASE when ana_biopsia= true then 'x' END as biopsia,ana_mepfam,CASE when ana_terhor= true then 'x' END as terhormonal,
   CASE when ana_colcop= true then 'x' END as colposcopia,
   CASE when ana_mamogr= true then 'x' END as mamografia,ana_desant,ana_antfam,ana_enfpra,ana_desrev,ana_exafis,ana_plantr,ana_fecha,
  per_nombres || ' ' ||per_apellidopaterno ||' '|| per_apellidomaterno as profecional, pr.pro_codigomsp,ana_hora",
        "","ana_id_pk",$ana_id_pk,2);
    # items de formulaio
    $items=$$Coni->Get_Consulta("sgh_mei_anapro JOIN sgh_mei_respuesta as res on pat_id_fk= res.pat_id_pk where ana_id_fk=".$ana_id_pk."ORDER BY pat_item","pat_id_pk,pat_item,  
     	CASE WHEN pat_result= 'f' THEN 'X' end as x,
    	CASE WHEN pat_result= 't' THEN 'O' end as o,
    	CASE WHEN pat_result= 'CP' THEN 'X' end as cp,
    	CASE WHEN pat_result= 'SP' THEN 'X' end as sp,
    	pat_result","","","",5);
    # CARGAR DIAGNOSTICO
    $dia=$$ConDI->Get_Consulta("sgh_mei_danamdiag join sgh_mei_diagnos as d on dia_id_fk=d.dia_id_pk 
    JOIN sgh_mei_codigocie10 as c10  on d.c10_id_fk=c10.c10_id_pk where ana_id_fk='".$ana_id_pk."'","c10_nombre AS detalle,
			c10_codigo as cie,
			sgh_conbiertepre('1',dia_resp) as pre,
			sgh_conbiertepre('2',dia_resp) as def,dia_descrip",
        "","","",6);
    //print_r ($DiagI);
    # CARGAR Signos vitales
    $sigv=$$Consv->Get_Consulta("sgh_mei_sivanam as  sva
	  jOIN sgh_mei_signosvi as sv on sva.siv_id= sv.siv_id_pk
	  JOIN sgh_mei_anamnesis as ana on sva.ana_id_fk= ana.ana_id_pk",
        "siv_id_pk,siv_frecar,siv_freres,siv_percef,siv_peso,siv_prarta,siv_talla,siv_temper,siv_tempvo","","ana_id_fk",$ana_id_pk,2);

    $html .= '

<!-- datos paciente -->	
<div class="noheader"><br>
<table border="1" width="100%" cellspacing="0" cellpadding="2"> 
	           <tr>
	              <th width="125" class="th"><center><font size="1">ESTABLECIMIENTO<font></th>
	              <th width="150" class="th"><center><font size="1">NOMBRE<font></center></th>
	              <th width="150" class="th"><center><font size="1">APELLIDO<font></center></th>
	              <th width="30" class="th"><center><font size="1">SEXO(M-F)<font></center><div>
	              <th width="50" class="th"><center><font size="1">N° HOJA <font></center></th>
	              <th width="125" class="th"><center><font size="1">N° HISTORIA CLÍNICA <font></center></th>
	              
	              </div>
	               
	               </th>           
	              </font>
	              </tr>
	            </center>
	            <tr>
	              <td><center><font size="1">'.$entidad.'</font></center></td>
	              <td><center><font size="1">'.($per[0]["per_nombres"] ?? '') .'</font></center></td>
	              <td><center><font size="1">'.($per[0]["apellido"] ?? '') .'</font></center></td>
	              <td><center><font size="1">'.($per[0]["per_sexo"] ?? '') .'</font></center></td>
	              <td><center><font size="1">1</font></center></td>
	              <td><center><font size="1">'.($per[0]["per_numeroidentificacion"] ?? '') .'</font></center></td>   
	            </tr>  
	</table>
	<table><tr><td></td></tr></table>
<!-- primera hoja  -->	
	<table border="1" width="100%" cellspacing="0" cellpadding="2">
		<tr>
			<td class="th">
			<h5><b>1. MOTIVO DE CONSULTA</b></h5>
			</td>
			<td style="text-align: right; " class="th">
			<font size="1">Anotar la causa del problema en la versíon del informante</font> 
			</td>
		</tr>
		
		<tr>
			<td height="70" VALIGN="TOP" colspan=2>
			   <font size="1">'.($ana[0]["ana_motivo"] ?? '') .'</font>
			</td>
		</tr>
	</table>
	<table><tr><td></td></tr></table>
	<table border="1" width="100%" cellspacing="0" cellpadding="2">
		<tr>
				<td  class="th" colspan=4><h5><b>2. ANTECEDENTES PERSONALES</b><h5></td>
				<td style="text-align: right;" class="th" colspan=12><font size="1">Describir abajo, con el Números respectivo FUM: Fecha ultima mensturacón FUP: Fecha ultimo parto FUC: Fecha ultima citología</font>
			</td>
		</tr>
					<tr>
						<td class="th"><font size="1">1.Vacunas</font></td>
						<td class="th"><font size="1">5.Enf. Alérgias</font></td>
						<td class="th"><font size="1">9.Enf. Neurológico</font></td>
						<td class="th"><font size="1">13.Enf. traumatol</font></td>
						<td class="th"><font size="1">17.Tendencia Sexual</font></td>
						<td class="th"><font size="1">21.Actividad física</font></td>
						<td class="th"><font size="1"><center>Menarquia<br>-edad-</center></font></td>
						<td width=20><font size="1" ><center>'.($ana[0]["ana_menarq"] ?? '') .'</center></font></td>
						<td class="th"><font size="1"><center>Menopausia<br>-edad-</center></font></td>
						<td width=20><font size="1" ><center>'.($ana[0]["ana_menopa"] ?? '') .'</center></font></td>
						<td class="th"><font size="1"><center>Ciclos</center></font></td>
						<td width=20><font size="1" ><center>'.($ana[0]["ana_ciclos"] ?? '') .'</center></font></td>
						<td class="th" colspan=2><font size="1"><center>Vida sexual activa</center></font></td>
						<td width=20 colspan=2><font size="1" ><center>'.($ana[0]["vidasex"] ?? '') .'</center></font></td>
					</tr>
					<tr>
						<td class="th"><font size="1">2.Enf. Perinatal</font></td>
						<td class="th"><font size="1">6.Enf. Cardiaca</font></td>
						<td class="th"><font size="1">10.Enf. Metabólica</font></td>
						<td class="th"><font size="1">14.Enf. Quirúrgica</font></td>
						<td class="th"><font size="1">18.Riesgo docisl</font></td>
						<td class="th"><font size="1">22.Dieta y hábitos</font></td>
						<td class="th"><font size="1"><center>Gesta</center></font></td>
						<td><font size="1"><center>'.($ana[0]["ana_gesta"] ?? '') .'</center>   </font>   </td>
						<td class="th"><font size="1"><center>Partos</center></font></td>
						<td><font size="1"><center>'.($ana[0]["ana_paros"] ?? '') .'</center>    </font>   </td>
						<td class="th"><font size="1"><center>Abortos</center></font></td>
						<td><font size="1"><center>'.($ana[0]["ana_aborto"] ?? '') .'</center></font>   </td>
						<td class="th"><font size="1"><center>Cesáreas</center></font></td>
						<td width=20><font size="1"><center>'.($ana[0]["ana_cesarea"] ?? '') .'</center></font></td>
						<td class="th"><font size="1"><center>Hijos vivos</center></font></td>
						<td width=20><font size="1"><center>'.($ana[0]["ana_hijosv"] ?? '') .'</center></font></td>
					</tr>	
					<tr>
						<td class="th"><font size="1">3.Enf. Infancia</font></td>
						<td class="th"><font size="1">7.Enf. Respiratoria</font></td>
						<td class="th"><font size="1">11.Enf. Hemo linf</font></td>
						<td class="th"><font size="1">15.Enf. Mental</font></td>
						<td class="th"><font size="1">19.Riesgo laboral</font></td>
						<td class="th"><font size="1">23.Religión y cultura</font></td>
						<td class="th"><font size="1"><center>FUM</center></font></td>
						<td><font size="1"><center>'.($ana[0]["ana_fum"] ?? '') .'</center></font></td>
						<td class="th"><font size="1"><center>FUP</center></font></td>
						<td><font size="1"><center>'.($ana[0]["ana_fup"] ?? '') .'</center></font></td>
						<td class="th"><font size="1"><center>FUC</center></font></td>
						<td><font size="1"><center>'.($ana[0]["ana_fuc"] ?? '') .'</center></font></td>
						<td class="th" colspan=2><font size="1"><center>Biopsia</center></font></td>
						<td colspan=2><font size="1"><center>'.($ana[0]["biopsia"] ?? '') .'</center></font></td>
					</tr>	
					<tr>
						<td class="th"><font size="1">4.Enf. Adolescente</font></td>
						<td class="th"><font size="1">8.Enf. Digestiva</font></td>
						<td class="th"><font size="1">12.Enf. urinario</font></td>
						<td class="th"><font size="1">16.Enf. T. Sexual</font></td>
						<td class="th"><font size="1">20.Riesgo Familiar</font></td>
						<td class="th"><font size="1">24.Otro</font></td>
						<td class="th"><font size="1"><center>Método de P. Familiar</center></font></td>
						<td><font size="1"><center>'.($ana[0]["ana_mepfam"] ?? '') .'</center></font></td>
						<td class="th"><font size="1"><center>Terapia hormonal</center></font></td>
						<td><font size="1"><center>'.($ana[0]["terhormonal"] ?? '') .'   </center></font></td>
						<td class="th"><font size="1"><center>Colposcopia   </center></font></td>
						<td><font size="1"><center>'.($ana[0]["colposcopia"] ?? '') .'   </center></font></td>
						<td class="th" colspan=2><font size="1"><center>Mamografia</center></font></td>
						<td colspan=2><font size="1"><center>'.($ana[0]["mamografia"] ?? '') .'</center></font></td>
					</tr>		
		<tr>
			<td height="140" VALIGN="TOP" colspan="16">
				<font size="1">'.($ana[0]["ana_desant"] ?? '') .'</font>
			</td>
		</tr>
	</table>
		<table><tr><td></td></tr></table>
	<table border="1" width="100%" cellspacing="0" cellpadding="2">
		<tr>
	     <td width="40%" class="th"  colspan=6><h5>3. ANTECEDENTES FAMILIARES <h5></td>
	     	<td width="60%" style="text-align: right;" class="th" colspan=4>
					<font size="1"><b>Describir abajo anotando el Números</font>
			</td>	
		</tr>
		<tr>
					<tr>
						<td class="th"><font size="1">1 Cardiopatía </font></td>
						<td class="th"><font size="1">2 Diabetes </font></td>
						<td class="th"><font size="1">3 Enf. C. vascular </font></td>
						<td class="th"><font size="1">4 Hipertensión </font></td>
						<td class="th"><font size="1">5 Cáncer </font></td>
						<td class="th"><font size="1">6 Tuberculosis</font></td>
						<td class="th"><font size="1">7 Enf. Mental</font></td>
						<td class="th"><font size="1">8 Enf infecciosa</font></td>
						<td class="th"><font size="1">9 Mal formación</font></td>
						<td class="th"><font size="1">10 Otros</font></td>
					</tr>
					<tr>
						<td height="80" VALIGN="TOP" colspan=20 >
							<font size="1">'.($ana[0]["ana_antfam"] ?? '') .'</font>
						</td>
					</tr>
		
	</table>
	<table><tr><td></td></tr></table>
	<table border="1" width="100%" cellspacing="0" cellpadding="2">
		<tr>
	     <td width="40%" class="th"><h5>4. ENFERMEDAD O PROBLEMA ACTUAL <h5>
	     	</td>
		</tr>	
		<tr>
						<td height="225" VALIGN="TOP" colspan= >
							<font size="1">'.($ana[0]["ana_enfpra"] ?? '') .'</font>
						</td>
		</tr>
	</table>
  <table><tr><td></td></tr></table>
	<table border="1" width="100%" cellspacing="0" cellpadding="2">
		<tr>
	     <td width="40%" colspan=6 class="th"><h5>5. ANTECEDENTES FAMILIARES Y SOCIALESS <h5></td>
	     	<td width="60%" style="text-align: right;" colspan=9 class="th">
					<font size="1"><b>CP </b>: Con patología. Describir anotando el numero.<b>SP </b>: Sin patolía. No Describir</font>
			</td>	
		</tr>
		<tr>
					<tr>
						<td class="th"></td>
						<td><font size="1">CP</font></td>
						<td><font size="1">SP</font></td>
						<td class="th"></td>
						<td><font size="1">CP</font></td>
						<td><font size="1">SP</font></td>
						<td class="th"></td>
						<td><font size="1">CP</font></td>
						<td><font size="1">SP</font></td>
						<td class="th"></td>
						<td><font size="1">CP</font></td>
						<td><font size="1">SP</font></td>
						<td class="th"></td>
						<td><font size="1">CP</font></td>
						<td><font size="1">SP</font></td>
					</tr>
					<tr>
					    <td class="th"><font size="1">1.Organos de los sentidos</font></td>
						<th>
							<font size="1">'.($items[27]["cp"] ?? '') .'</font>
						</th>
						<th>
							<font size="1">'.($items[27]["sp"] ?? '') .'</font>
						</th>

						<td class="th"><font size="1">3. Cardio vascular</font></td>
						<th>
							<font size="1">'.($items[5]["cp"] ?? '') .'</font>
						</th>
						<th>
							<font size="1">'.($items[5]["sp"] ?? '') .'</font>
						</th>

						<td class="th"><font size="1">5. Genital</font></td>
						<th>
							<font size="1">'.($items[12]["cp"] ?? '') .'</font>
						</th>
						<th>
							<font size="1">'.($items[12]["sp"] ?? '') .'</font>
						</th>

						<td class="th"><font size="1">7. Músculo Esqueléticos</font></td>
						<th>
							<font size="1">'.($items[19]["cp"] ?? '') .'</font>
						</th>
						<th >
							<font size="1">'.($items[19]["sp"] ?? '') .'</font>
						</th>

						<td class="th"><font size="1">9. Hemo </font></td>
						<th >
							<font size="1">'.($items[15]["cp"] ?? '') .'</font>
						</th>
						<th>
							<font size="1">'.($items[15]["sp"] ?? '') .'</font>
						</th>
					</tr>
					<tr>
						<td class="th"><font size="1">2.Respiratorio</font></td>
						<th>
							<font size="1">'.($items[31]["cp"] ?? '') .'</font>
						</th>
						<th>
							<font size="1">'.($items[31]["sp"] ?? '') .'</font>
						</th>

						<td class="th"><font size="1">4. Digestivo</font></td>
						<th>
							<font size="1">'.($items[9]["cp"] ?? '') .'</font>
						</th>
						<th>
							<font size="1">'.($items[9]["sp"] ?? '') .'</font>
						</th>

						<td class="th"><font size="1">6. Urinario</font></td>
						<th>
							<font size="1">'.($items[34]["cp"] ?? '') .'</font>
						</th>
						<th>
							<font size="1">'.($items[34]["sp"] ?? '') .'</font>
						</th>

						<td class="th"><font size="1">8. Endocrino</font></td>
						<th>
							<font size="1">'.($items[11]["cp"] ?? '') .'</font>
						</th>
						<th>
							<font size="1">'.($items[11]["sp"] ?? '') .'</font>
						</th>
						<td class="th"><font size="1">10. Nervioso</font></td>
						<th>
							<font size="1">'.($items[22]["cp"] ?? '') .'</font>
						</th>
						<th>
							<font size="1">'.($items[22]["sp"] ?? '') .'</font>
						</th>
					</tr>
					<tr>
						<td height="100" VALIGN="TOP" colspan=15 >
							<font size="1">'.($ana[0]["ana_desrev"] ?? '') .'</font>
						</td>
				   </tr>			
	</table>
	</div>
<!-- 2 hoja  -->	

	<div class="chapter2">

	<table border="1" width="100%" cellspacing="0" cellpadding="2">
		<tr>
		 <td width="33%" colspan=16 class="th"><H5><b>6. SIGNOS VITALES, ANTROPOMETRÍA Y TAMIZAJE</b><H5></td>
			H5></td>
		</tr>
		<tr>
			<th class="th"><center><font size="1">Presión<br> arterial<font> </center></th> 
			 <td> <center><font size="1"><font>'.($sigv[0]["siv_prarta"] ?? '') .'</center>
            <th class="th"> <center><font size="1">Frecuencia<br> cardiaca min<font></center></th>
             <td> <center><font size="1"><font>'.($sigv[0]["siv_frecar"] ?? '') .'</center>
            <th class="th"><center><font size="1">Frecuencia<br> Respira min<font></center></th>
             <td> <center><font size="1"><font>'.($sigv[0]["siv_freres"] ?? '') .'</center>
            <th class="th"><center><font size="1">Temperatura<br> BucalºC<font></center></th>
             <td> <center><font size="1"><font>'.($sigv[0]["siv_tempvo"] ?? '') .'</center>
             <th class="th"><center><font size="1">Temperatura<br> Axilar ºC<font></center></th>
             <td> <center><font size="1"><font>'.($sigv[0]["siv_temper"] ?? '') .'</center>
            <th class="th"><center><font size="1">Peso<br> Kg<font></center></th>
             <td> <center><font size="1"><font>'.($sigv[0]["siv_peso"] ?? '') .'</center>
            <th class="th"><center><font size="1">Talla<br> m<font></center></th>
             <td> <center><font size="1"><font>'.($sigv[0]["siv_talla"] ?? '') .'</center>
             <th class="th"><center><font size="1">Perímetro<br> cefálic cm<font></center></th>
             <td> <center><font size="1"><font>'.($sigv[0]["siv_percef"] ?? '') .'</center> 
		</tr>
	</table>
	<table><tr><td></td></tr></table>
	<table  border="1" width="100%" cellspacing="0" cellpadding="2">
			<tr>
	    			<td class="th"  colspan=4><h5>7. EXAMEN FISICO</h5></td>
	    			<td class="th"  colspan=4><font size="1">R=REGIONAL S=SISTÉMICO</font></td>
	    			<td class="th" style="text-align: right;" colspan=7>
					<font size="1"><b>CP </b>: Con patología. Describir anotando el numero. <b>SP</b: Sin patolía. No Describir</font>td>
	    	</tr>
	    			<tr>
	    			    <td class="th"></td> <td><font size="1">CP</font></td> <td><font size="1">SP</font></td>
                        <td class="th"></td> <td><font size="1">CP</font></td> <td><font size="1">SP</font></td>
                        <td class="th"></td> <td><font size="1">CP</font></td> <td><font size="1">SP</font></td>
                        <td class="th"></td> <td><font size="1">CP</font></td> <td><font size="1">SP</font></td>
                        <td class="th"></td> <td><font size="1">CP</font></td> <td><font size="1">SP</font></td>

                     </tr>  
                     <tr>
                       <td class="th"><font size="1"> 1-R Pie- Faneras</font></td> 
                       <td><font size="1">'.($items[29]["cp"] ?? '') .'</font></td> <td><font size="1">'.($items[29]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size="1"> 6-R Boca</font></td> 
                       <td><font size="1">'.($items[2]["cp"] ?? '') .'</font></td> <td><font size="1">'.($items[2]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size="1"> 11-R Abdomen</font></td> 
                       <td><font size="1">'.($items[0]["cp"] ?? '') .'</font></td> <td><font size="1">'.($items[0]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size="1"> 1-S Órganos de los sentidos</font></td> 
                       <td><font size="1">'.($items[26]["cp"] ?? '') .'</font></td> <td><font size="1">'.($items[26]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size="1"> 6-S Urinario</font></td> 
                      <td><font size="1">'.($items[33]["cp"] ?? '') .'</font></td> <td><font size="1">'.($items[33]["sp"] ?? '') .'</font></td>		
                    	
                    </tr>
                    <tr>
                       <td class="th"><font size="1"> 2-R Cabeza</font></td> 
                       <td><font size="1">'.($items[3]["cp"] ?? '') .'</font></td> <td><font size="1">'.($items[3]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size="1"> 7-R Oro Faringe</font></td> 
                       <td><font size="1">'.($items[28]["cp"] ?? '') .'</font></td> <td><font size="1">'.($items[28]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size="1"> 12-R Columna vertebral</font></td> 
                       <td><font size="1">'.($items[6]["cp"] ?? '') .'</font></td> <td><font size="1">'.($items[6]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size="1"> 2-S Respiratorio</font></td> 
                       <td><font size="1">'.($items[30]["cp"] ?? '') .'</font></td> <td><font size="1">'.($items[30]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size="1"> 7-S Músculo Esqueléticos</font></td> 
                      <td><font size="1">'.($items[20]["cp"] ?? '') .'</font></td> <td><font size="1">'.($items[20]["sp"] ?? '') .'</font></td>		
                    	
                    </tr>
                    <tr>
                       <td class="th"><font size="1"> 3-R Ojos</font></td> 
                       <td><font size="1">'.($items[25]["cp"] ?? '') .'</font></td> <td><font size="1">'.($items[25]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size="1"> 8-R Cuello</font></td> 
                       <td><font size="1">'.($items[7]["cp"] ?? '') .'</font></td> <td><font size="1">'.($items[7]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size="1"> 13-R Ingle-periné</font></td> 
                       <td><font size="1">'.($items[16]["cp"] ?? '') .'</font></td> <td><font size="1">'.($items[16]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size="1"> 3-S Cardio vascular</font></td> 
                       <td><font size="1">'.($items[4]["cp"] ?? '') .'</font></td> <td><font size="1">'.($items[4]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size="1"> 8-S Endocrino</font></td> 
                      <td><font size="1">'.($items[10]["cp"] ?? '') .'</font></td> <td><font size="1">'.($items[10]["sp"] ?? '') .'</font></td>		
                    	
                    </tr>
                     <tr>
                       <td class="th"><font size="1"> 4-R Oídos</font></td> 
                       <td><font size="1">'.($items[24]["cp"] ?? '') .'</font></td> <td><font size="1">'.($items[24]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size="1"> 9-R Axilas-mamas</font></td> 
                       <td><font size="1">'.($items[1]["cp"] ?? '') .'</font></td> <td><font size="1">'.($items[1]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size="1"> 14-R Miembros superiores</font></td> 
                       <td><font size="1">'.($items[18]["cp"] ?? '') .'</font></td> <td><font size="1">'.($items[18]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size="1"> 4-S Digestivo</font></td> 
                       <td><font size="1">'.($items[8]["cp"] ?? '') .'</font></td> <td><font size="1">'.($items[8]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size="1"> 9-S Hemo linfático</font></td> 
                      <td><font size="1">'.($items[14]["cp"] ?? '') .'</font></td> <td><font size="1">'.($items[14]["sp"] ?? '') .'</font></td>		
                    	
                    </tr>
                     <tr>
                       <td class="th"><font size="1"> 5-R Nariz</font></td> 
                       <td><font size="1">'.($items[21]["cp"] ?? '') .'</font></td> <td><font size="1">'.($items[21]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size="1"> 10-R Tórax</font></td> 
                       <td><font size="1">'.($items[32]["cp"] ?? '') .'</font></td> <td><font size="1">'.($items[32]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size="1"> 15-R Miembros inferiores</font></td> 
                       <td><font size="1">'.($items[17]["cp"] ?? '') .'</font></td> <td><font size="1">'.($items[17]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size="1"> 5-S Genital</font></td> 
                       <td><font size="1">'.($items[13]["cp"] ?? '') .'</font></td> <td><font size="1">'.($items[13]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size="1"> 10-S Neurològico</font></td> 
                      <td><font size="1">'.($items[23]["cp"] ?? '') .'</font></td> <td><font size="1">'.($items[23]["sp"] ?? '') .'</font></td>		
                    	
                    </tr>
        <tr>
						<td height="400" VALIGN="TOP" colspan=15>
							<font size="1">'.($ana[0]["ana_exafis"] ?? '') .'</font>
		</td>
							
					</tr>
	</table>
		<table><tr><td></td></tr></table>

			<table border="1" width="100%" cellspacing="0" cellpadding="2">
		    		<tr>
		    			<td width="560" class="th" colspan="2"> <h5><b>8. DIAGNÓSTICO </b></h5></td>
		    			<th whdth="10"  class="th"> <font size="1">PRE</font></th>  
		    			<th whdth="10"  class="th"> <font size="1">DEF</font></th>
		    			<th whdth="20"  class="th"> <font size="1">CIE</font></th>  
		    			  
		    		</tr>';

    for ($i = 0; $i < 6; $i++) {
        $it=$i+1;
        $html .= '<tr>
		    		   		<td widt="0.1%"><font size="1">' .$it. '</font></td>
		    		   		<td widt="560"><font size="1">'.($dia[$i]["detalle"] ?? '') .'</font></td>
		    		   		<td widt="10"><font size="1"><center>'.($dia[$i]["pre"] ?? '') .'</center></font></td>
		    		   		<td widt="10"><font size="1"><center>'.($dia[$i]["def"] ?? '') .'</center></font></td>
		    		   		<td widt="20"><font size="1"><center>'.($dia[$i]["cie"] ?? '') .'</center></font></td>
		    				</tr>';
    }
    $html .= '
		    </table>
	  <table><tr><td></td></tr></table>
	<table border="1" width="100%" cellspacing="0" >
		<tr>
	     <td width="33%" class="th"><H5><b>9 PLANES DE TRATAMIENTO</b><H5></td>
			h4></td>	
		</tr>
		</tr>
		<tr>
			<td height="200" VALIGN="TOP">
				<font size="1">'.($ana[0]["ana_plantr"] ?? '') .'</font>
			</td>
				
		</tr>
	</table>
<table><tr><td></td></tr></table>
	<table border="1" cellspacing="0" width="100%"> 
		<tr>
			<th width="20" class="th"><font size="2">Fecha</font></th>
			<td width="10"><center><font size="1">'.($ana[0]["ana_fecha"] ?? '') .'</font></center></td>
			<th width="30" class="th"><font size="2">Hora</font></th>
			<td width="10"><center><font size="2">' . substr($ana[0]["ana_hora"], 0, -7) . '</font></center></td>
			<th width="95" class="th"><font size="2">Nombre del profesional</font></th>
			<td width="150"><center><font size="1">'.($ana[0]["profecional"] ?? '') .'</font></center></td> <td width="50"><center><font size="1">'.($ana[0]["pro_codigomsp"] ?? '') .'</font></center></td>
			<th width="30" class="th"><font size="2">Firma</font></th>  <td width="150"></td>
			<th width="5" class="th"><font size="2">Número de hoja </font></th><td width="20"><center><font size="1">2</font></center></td>
			
		<tr>
	</table>
	</div>
	</body>
	</html>
	';
}
//$html.='
//
//	</body>
//	</html>
//';

// CREACIÓN DE PDF 
//$mpdf= new mPDF('c','A4','','arial');
$mpdf->writeHTML($html);
$mpdf->Output('Anamnesis.pdf','I');

?>