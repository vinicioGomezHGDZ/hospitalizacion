<?php
require_once("../../../../js/lib/mpdf-6.1.3/mpdf.php");
include_once("../../../../php/class_consulta.php");
$Conre=New Consulta();

$hce_id_fk=$_GET['h'];
// CONSULTAS DE REPORRTE
$recon=$Conre->Get_Consulta("sgh_mei_reoncimedi where hce_id_fk='".$hce_id_fk."' ORDER BY frm_fecha DESC","frm_id_pk,frm_fecha","","","",5);
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

			div.chapter3 {

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

		<table width="100%" border="1" cellspacing="0" cellpadding="2">
	    <tr>

		    <td width="50%" rowspan="2"  align="center" >
			    <IMG SRC="../../../../img/logo.png" WIDTH=150 HEIGHT=50>
		    </td>
		    <td width="10%" align="center" height="25"></td>
		    <td width="25%" style="text-align: center;"></td>
	    </tr>
	    <tr>
	    <td width="10%" align="center">Versión</td>
		    <td width="20%" style="text-align: center;">0</td>
	    </tr>
	    <tr>
	    	<td align="center"> <b>Formulario de Reconciliación de Medicamentos</b><td/>
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
                    Fuente: Manual Técnico de seguridad de paciente,  MSP, 2017<br>
                    Elaborado por : Comite tecnico de seguridad de paciente  <br>
                    </font>	
				</td>
			</tr>
			<tr>
				<td>
				</td>
			</tr>
			<tr>
			 <td width="100%" style="text-align: justify; ">
			
			</td></tr>
	 	</table>
	</htmlpagefooter>

<htmlpageheader name="Chapter2HeaderOdd" style="display:none">
		<table width="100%" border="1" cellspacing="0" cellpadding="2">
	    <tr>

		    <td width="50%" rowspan="2"  align="center" >
			    <IMG SRC="../../../../img/logo.png" WIDTH=150 HEIGHT=50>
		    </td>
		    <td width="10%" align="center" height="25"></td>
		    <td width="25%" style="text-align: center; "></td>
	    </tr>
	    <tr>
	    <td width="10%" align="center">Versión</td>
		    <td width="20%" style="text-align: center; ">0</td>
	    </tr>
	    <tr>
	    	<td align="center"> <b>Formulario de Reconciliación de Medicamentos</b><td/>
	        <td width="10%" align="center">Fecha</td>
		    <td width="20%" style="text-align: center; "></td>
	    </tr>
	    
	    </table>
	</htmlpageheader>

	<htmlpagefooter name="Chapter2FooterOdd" style="display:none">
		<table>
		<tr>
			<td>
			<font size="2" >
 		             Fuente: Manual Técnico de seguridad de paciente,  MSP, 2017 <br>
                    Elaborado por : Comite tecnico de seguridad de paciente  <br>
 		     </font>	
			</td>
		</tr>
		<tr>
			<td>
			</td>
		</tr>
		<tr>
		 <td width="100%" style="text-align: justify; ">
		
		</td></tr>
 	 </table>
		
	</htmlpagefooter>

';

for ($r=0; $r <count($recon) ; $r++) {
    $Con='Con'.$r;
    $ConAC='ConAC'.$r;
    $ConDE='ConDE'.$r;
    $ConMT='ConMT'.$r;
    $frm_id_pk=$recon[$r]["frm_id_pk"];
    $$Con=New Consulta();
    $$ConAC=New Consulta();
    $$ConDE=New Consulta();
    $$ConMT=New Consulta();


# CARGAR DATOS DE ENCABEZADO. array 0
  $per=$$Con->Get_Consulta("sgh_mei_reoncimedi ep
		join sga_adm_historiaclinica as h on ep.hce_id_fk=h.hce_id_pk
		join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
		join sga_adm_persona as  per on p.per_id_fk=per.per_id_pk
    JOIN sga_adm_sexo as se on se.sex_id_pk=per.sex_id_fk
    join sga_adm_tipocama as ser on ep.ser_id_fk=ser.tca_id_pk","frm_id_pk,per_nombres || ' ' ||per_apellidopaterno ||' '|| coalesce(per_apellidomaterno,'')  as persona,frm_fecha,
  frm_motate as motivo,frm_ocupacion,
  tca_descripcion as servicio,
  date_part('year',age(per_fechanacimiento)) || ' Años '||date_part('mons',age(per_fechanacimiento)) ||' Meses '|| date_part('days',age(per_fechanacimiento)) || ' Días' as Edad,
  se.sex_codigo as sexo,frm_tiposangre,frm_emblac,per_numeroidentificacion,frm_peso,frm_fueinf,frm_cual as pregunta1,frm_intqui as pregunta2,
  frm_suspel as pregunta3,frm_enfcro as pregunta4,frm_dondia pregunta5,frm_habito pregunta6,frm_faencr pregunta7,frm_viaje pregunta8,
  frm_fitote as pregunta9,frm_obmeul,frm_obmeho,frm_quifar,frm_medent,frm_medrev","","frm_id_pk",$frm_id_pk,2);

# CARGAR DATOS que medicamentos estaba recibiendo en último mes
    $mrum=$$ConAC->Get_Consulta("sgh_mei_reoncimedi rm
  join sgh_mei_medirec as mu on mu.frm_id_fk=rm.frm_id_pk","frm_id_fk,mum_medica,mum_dosis,mum_frecue,mum_paraq,mum_xcuati,mum_comtom,mum_quirec,mum_condes","","frm_id_fk",$frm_id_pk,2);

# CARGAR DATOS de medicamentos prescritos deurante la hospitalización
    $mrho=$$ConDE->Get_Consulta(" sgh_mei_reoncimedi rm
  join sgh_mei_medihospit as mu on mu.frm_id_fk=rm.frm_id_pk","frm_id_fk,mph_medica,mph_dosis,mph_frecue,mph_via,mph_discre,mph_meqcam","","frm_id_fk",$frm_id_pk,2);
# CARGAR DATOS de medicamentos prescritos para alta
    $mral=$$ConMT->Get_Consulta(" sgh_mei_reoncimedi rm
  join sgh_mei_medicialta as mu on mu.frm_id_fk=rm.frm_id_pk","frm_id_fk,mpa_medica,mpa_dosis,mpa_frecue,mpa_via,mpa_recome","","frm_id_fk",$frm_id_pk,2);
//$mpdf->useOddEven = 1;
// HTML DE REPORTE

$html.='
<!-- primera hoja  -->
<div class="chapter3"><br><br><br><br>
	<table width="100%">
		<tr>
			<th>
			   <H4><center>FORMULARIO RECONCILIACION DE MEDICAMENTO </center><H4>

			<th>
		</tr>
	</table>
	<table >
		<tr>
			<td>Nombre y Apellido</td><td width="500"><font size=3>'.$per[0]["persona"].'</font></td>
		</tr>	
	</table>
	<table>		
		<tr>
			<td>Fecha de la entrevista</td>	
			<td width="100"><font size=3>'.$per[0]["frm_fecha"].'</font></td>
			<td>Motivo de atención</td><td width="200"><font size=3>'.$per[0]["motivo"].'</font></td>
		</tr>
	</table>
	<table width="100%">		
		<tr>
			<td>Ocupación</td> <td width="100"><font size=3>'.$per[0]["frm_ocupacion"].'</font> </td> 
			<td>Servicio</td> <td width="125"><font size=3>'.$per[0]["servicio"].'</font></td> 
			<td>Edad</td> <td width="200"><font size=3>'.$per[0]["edad"].'</font></td>
		</tr>
	</table>
	<table>
		<tr>
			<td>Sexo</td> <td width="50"> <font size=3>'.$per[0]["sexo"].'</font></td> 
			<td>Tipo de sangre</td> <td width="100"><font size=3>'.$per[0]["frm_tiposangre"].'</font></td> 
			<td>embarazo / lactancia</td> <td width="100"><font size=3>'.$per[0]["frm_emblac"].'</font></td>
		</tr>
	</table>
	<table>
		<tr>
			<td>Cédula</td> <td width="100"><font size=3>'.$per[0]["per_numeroidentificacion"].'</font></td> 
			<td>peso</td> <td width="50"><font size=3>'.$per[0]["frm_peso"].'</font></td> 
			<td>Fuente de información(parentesco)</td> <td width="200"><font size=1>'.$per[0]["frm_fueinf"].'</font></td>
		</tr>
	</table>
	<table>
		<tr>
			<td>
				¿Ha tenido o tiene alergias a medicamentos, alimentos u otro tipo de alergias ?¿Cual?
			</td>
		</tr>
		<tr>
			<td height="40">
			<font size=3>'.$per[0]["pregunta1"].'</font>		
			</td>
		</tr>	
	</table>
	<table>
		<tr>
			<td>
				 ¿Ha sido sometido a intervenciones quirúrgicas anteriormente? ¿De qué tipo? ¿Hace cuánto tiempo?
			</td>
		</tr>
		<tr>
			<td height="40">
				<font size=3>'.$per[0]["pregunta2"].'</font>		
			</td>
		</tr>	
	</table>
	<table>
		<tr>
			<td>
				 ¿Trabaja o ha trabajado con sustancias peligrosas? ¿Durante qué tiempo? ¿Tipo de actividad y sustancias manejadas?
			</td>
		</tr>
		<tr>
			<td height="40">
				<font size=3>'.$per[0]["pregunta3"].'</font>		
			</td>
		</tr>	
	</table>
	<table>
		<tr>
			<td>
				 Padecía o padece de alguna enfermedad crónica como hipertensión diabetes, colesterol alto, problemas renales, artritis. tiroides u otras? ¿Qué enfermedad?
			</td>
		</tr>
		<tr>
			<td height="40">
				<font size=3>'.$per[0]["pregunta4"].'</font>		
			</td>
		</tr>	
	</table>
	<table>
		<tr>
			<td>
				¿ Dónde la diagnosticaron la enfermedad y hace cuánto tiempo ?
			</td>
		</tr>
		<tr>
			<td height="40">
				<font size=3>'.$per[0]["pregunta5"].'</font>		
			</td>
		</tr>	
	</table>
	<table>
		<tr>
			<td>
				¿Tiene hábitos de fumar, beber, drogas, aguas, aromáticas? ¿con que frecuencia, desde hace que tiempo?
			</td>
		</tr>
		<tr>
			<td height="40">
				<font size=3>'.$per[0]["pregunta6"].'</font>		
			</td>
		</tr>	
	</table>
	<table>
		<tr>
			<td>
				¿En su familia ha habido enfermedades crónicas o muertes por este tipo de enfermedades?empo?
			</td>
		</tr>
		<tr>
			<td height="40">
				<font size=3>'.$per[0]["pregunta7"].'</font>		
			</td>
		</tr>	
	</table>
		<table>
		<tr>
			<td>
				¿Ha viajado fuera de su lugar residencia en el último mes? ¿ A dónde y por cuánto tiempo?
			</td>
		</tr>
		<tr>
			<td height="40">
				<font size=3>'.$per[0]["pregunta8"].'</font>		
			</td>
		</tr>	
	</table>
	<table>
		<tr>
			<td>
				¿Recibe fitoterapia?
			</td>
		</tr>
		<tr>
			<td height="40">
				<font size=3>'.$per[0]["pregunta9"].'</font>		
			</td>
		</tr>	
	</table>
</div>
<!-- segunda hoja  -->
<div class="chapter2"><br><br><br><br>
  <table width="100%" >
		<tr>
			<td>¿Qué medicamentos estaba recibiendo en el último mes?</td>
		</tr>
	<tr>
	  <td height="200" VALIGN="TOP">	
		<table border="1" width="100%" cellspacing="0" cellpadding="0">
			<tr>
				<th><font size="2">Medicamento</font></th>
				<th><font size="2">Dosis</font></th>
				<th><font size="2">Frecuencia</font></th>
				<th><font size="2">Para que</font></th>
				<th><font size="2">Por cuanto tiempo</font></th>
				<th><font size="2">Como lo toma</font></th>
				<th><font size="2">Quien se lo receto</font></th>
				<th><font size="2">Continuar / descontinuar</font></th>
			</tr>';
				for ($a=0; $a <sizeof($mrum) ; $a++) { 
			$html.='
			<tr>
			
				<td><font size="1"><center>'.$mrum[$a]["mum_medica"].'</center></font></td>
				<td><font size="1"><center>'.$mrum[$a]["mum_dosis"].'</center></font></td>
				<td><font size="1"><center>'.$mrum[$a]["mum_frecue"].'</center></font></td>
				<td><font size="1"><center>'.$mrum[$a]["mum_paraq"].'</center></font></td>
				<td><font size="1"><center>'.$mrum[$a]["mum_xcuati"].'</center></font></td>
				<td><font size="1"><center>'.$mrum[$a]["mum_comtom"].'</center></font></td>
				<td><font size="1"><center>'.$mrum[$a]["mum_quirec"].'</center></font></td>
				<td><font size="1"><center>'.$mrum[$a]["mum_condes"].'</center></font></td>
			
			</tr>';
			}
			$html.='
		</table>
	  </td>
    </tr>
    <tr>
    	<td>
    	Obcervaciones: 
    	</td>
    </tr>
        <tr>
    	<td height="125" VALIGN="top">
    		<font size=2> '.$per[0]["frm_obmeul"].'</font> 
    	</td>
    </tr>
  </table>

  <table width="100%">
	 <tr>
		<td>Medicamento prescritos durante la Hospitalización / cambios de tratamientos</td>
	 </tr>
  	 <tr>
	  <td height="200" VALIGN="TOP">	
		<table border="1"  cellspacing="0" cellpadding="0">
			<tr>
				<th width="70"> <font size="2">Número</font></th>
				<th width="110"> <font size="2">Medicamento</font></th>
				<th width="70"> <font size="2">Dosis</font></th>
				<th width="110"> <font size="2">Frecuencia</font></th>
				<th width="70"> <font size="2">Vía</font></th>
				<th width="110"> <font size="2">Discrepancia / error</font></th>
				<th width="150"> <font size="2">Médico que realiza el cambìo</font></th>
			</tr>';
				for ($b=0; $b <sizeof($mrho) ; $b++) { 
					$num=$b+1;
			$html.='
			<tr>
			
				<td><font size="1"><center> '.$num.' </center></font></td>
				<td><font size="1"><center> '.$mrho[$b]["mph_medica"].' </center></font></td>
				<td><font size="1"><center> '.$mrho[$b]["mph_dosis"].' </center></font></td>
				<td><font size="1"><center> '.$mrho[$b]["mph_frecue"].' </center></font></td>
				<td><font size="1"><center> '.$mrho[$b]["mph_via"].' </center></font></td>
				<td><font size="1"><center> '.$mrho[$b]["mph_discre"].' </center></font></td>
				<td><font size="1"><center> '.$mrho[$b]["mph_meqcam"].' </center></font></td>
			
			</tr>';
			}
			$html.='
			<tr>
				<td colspan="3">Quìmico Farmcèutico que revisa</td>
				<td VALIGN="top" colspan=4>
    				<font size=2>  '.$per[0]["frm_quifar"].' </font> 
    			</td>
			</tr>
		</table>
	  </td>
    </tr>
    <tr>
    	<td>
    	Obcervaciones: 
    	</td>
    </tr>
    <tr>	
    	<td height="125" VALIGN="top">
    		<font size=2>  '.$per[0]["frm_obmeho"].' </font> 
    	</td>
    </tr>
  </table>
</div>
<!-- tercera hoja  -->
<div class="chapter3"> <br><br><br><br>
 <table width="100%">
 	<tr>
		<td colspan>Medicamentos prescritos para alta médica</td>
	 </tr>
	 <tr>
	  <td VALIGN="TOP">	
		<table border="1" width="100%" cellspacing="0" cellpadding="0">
			<tr>
				<th width="70"> <font size="2">Número</font></th>
				<th width="110"> <font size="2">Medicamento</font></th>
				<th width="70"> <font size="2">Dosis</font></th>
				<th width="110"> <font size="2">Frecuencia</font></th>
				<th width="70"> <font size="2">Vía</font></th>
				<th width="110"> <font size="2">Recomendaciòn</font></th>
			</tr>';
			$i=0;
			while ( $i< sizeof($mral)) {
					$numa=$i+1;
				$html.='
				<tr>
					<td><font size="1"><center>'.$numa.'</center></font></td>
					<td><font size="1"><center>'.$mral[$i]["mpa_medica"].'</center></font></td>
					<td><font size="1"><center>'.$mral[$i]["mpa_dosis"].'</center></font></td>
					<td><font size="1"><center>'.$mral[$i]["mpa_frecue"].'</center></font></td>
					<td><font size="1"><center>'.$mral[$i]["mpa_via"].'</center></font></td>
					<td><font size="1"><center>'.$mral[$i]["mpa_recome"].'</center></font></td>
				</tr>
				';
				$i+=1;
			}
			$html.='
		</table>
	  </td>
    </tr>

</table>
<br><br>
<br><br>
<table>
	<tr>
		<td>
			_______________________________
		</td>
		<td width="100"></td>
		<td>
			_______________________________
		</td>
 	</tr>
 	<tr>
		<td>
			<b>FIRMA Y SELLO</b><br>
			Médico que realiza la entrevista
		</td>
		<td width="100"></td>
		<td>
			<b>FIRMA Y SELLO</b><br>
			Profecional Q.F. realiza revisión
		</td>	
 	</tr>
 </table>

<div>
';
}
$html.='
	</body> 
	</html>

';
// CREACIÓN DE PDF 
$mpdf= new mPDF('c','A4','','arial');
$mpdf->writeHTML($html);
$mpdf->Output('Reconciliación de medicamentos.pdf','I');
?>