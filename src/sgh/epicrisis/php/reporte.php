<?php
require_once '../../../../vendor/autoload.php';
include_once("../../../../php/class_consulta.php");
require_once("../../../../php/conexion.php");

use Mpdf\Mpdf;
$mpdf = new mPDF(['debug' => true,'mode'=>'utf-8','format'=>'A4']);

$Con=New Consulta();
$ConDI=New Consulta();
$ConDE=New Consulta();
$ConMT=New Consulta();
$epi_id_pk=$_GET['c'];
// CONSULTAS DE REPORRTE
	# CARGAR DATOS DE ENCABEZADO. array 0
		$per=$Con->Get_Consulta("sgh_mei_epicrisis ep
		join sga_adm_historiaclinica as h on ep.hce_id_fk=h.hce_id_pk
		join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
		join sga_adm_persona as  per on p.per_id_fk=per.per_id_pk
		JOIN sga_adm_sexo as se on se.sex_id_pk=per.sex_id_fk","per_nombres,(per_apellidopaterno ||' '|| coalesce(per_apellidomaterno,'') ) as apellido,
			date_part('year',age(per_fechanacimiento)) as Edad,hce_numerohc,sex_codigo as per_sexo,per_numeroidentificacion","","epi_id_pk",$epi_id_pk,2);
			//print_r($per);	
	# CARGAR DATOS GENERALES array 1
	  $epic=$Con->Get_Consulta("sgh_mei_epicrisis JOIN sgu_usu_usuario as us on usu_id_fk = us.usu_id_pk
				JOIN sga_adm_profesional as pr on us.pro_id_fk=pro_id_pk
				JOIN sga_adm_persona as pe  on pr.per_id_fk= pe.per_id_pk","	pe.per_nombres || ' ' || pe.per_apellidopaterno || ' ' || pe.per_apellidomaterno as responsable,pro_codigomsp,pro_codigosenescyt,per_numeroidentificacion,
		regexp_replace(epi_recucl,'\n','<br>','g') epi_recucl,
    regexp_replace(epi_reevco,'\n','<br>','g') epi_reevco,
    regexp_replace(epi_harexa,'\n','<br>','g') epi_harexa,
    regexp_replace(epi_rtrprt,'\n','<br>','g') epi_rtrprt,
    regexp_replace(epi_condic,'\n','<br>','g') epi_condic,
		sgh_conbiertetrue('1',epi_altdef) as alta_definitiva,
		sgh_conbiertetrue('1',epi_altran) as alta_transitoria,
		sgh_conbiertetrue('1',epi_asinto) as asintomatica,
		sgh_conbiertetrue('1',epi_dislev) as dicapacidad_leve,
		sgh_conbiertetrue('1',epi_dismod) as dicapacidad_modereada,
		sgh_conbiertetrue('1',epi_disgra) as dicapacidad_grave,
		sgh_conbiertetrue('1',epi_retaut) as retiro_atoriza,
		sgh_conbiertetrue('1',epi_retnau) as retiro_no_atoriza,
		sgh_conbiertetrue('1',epi_dme48h) as defucion_me_48,
		sgh_conbiertetrue('1',epi_dma48h) as defucion_mas_48,epi_diaest,epi_diadin,
		to_char(epi_fecha,'dd-MM-yyyy') as epi_fecha ,epi_hora,epi_respon,epi_rescmsp",
		"","epi_id_pk",$epi_id_pk,2);
		 	//print_r($epic);

    # CARGAR DIAGNOSTICO INGRESO 
        $DiagI=$ConDI->Get_Consulta("sgh_mei_dei join sgh_mei_diagnos as d on dia_id_fk=d.dia_id_pk 
        JOIN sgh_mei_codigocie10 as c10  on d.c10_id_fk=c10.c10_id_pk where dia_tipo='INGRESO' and epi_id_fk='".$epi_id_pk."' order by dei_id_pk","c10_nombre AS detalle,
			c10_codigo as cie,
			sgh_conbiertepre('1',dia_resp) as pre,
			sgh_conbiertepre('2',dia_resp) as def",
			"","","",5);
				//print_r ($DiagI); 
         
	# CARGAR DIAGNOSTICO EGRESO 
        $DiagE=$ConDE->Get_Consulta("sgh_mei_dei join sgh_mei_diagnos as d on dia_id_fk=d.dia_id_pk 
        JOIN sgh_mei_codigocie10 as c10  on d.c10_id_fk=c10.c10_id_pk where dia_tipo='EGRESO' and epi_id_fk='".$epi_id_pk."' order by dei_id_pk","c10_nombre AS detalle,
			c10_codigo as cie,
			sgh_conbiertepre('1',dia_resp) as pre,
			sgh_conbiertepre('2',dia_resp) as def",
			"","","",5);
				//print_r($DiagE); 
    # CARGAR MEDICOS TRATANTES 
		$Medi=$ConMT->Get_Consulta("sgh_mei_med as me
     	join sgh_mei_epicrisis as epi on me.epi_id_fk=epi_id_pk
      join sga_adm_especialidad_profesional as esp on me.pro_id_pk=esp.pro_id_fk
      join sga_adm_profesional pr on esp.pro_id_fk = pr.pro_id_pk
      join sga_adm_especialidad es on esp.esp_id_fk = es.esp_id_pk
      JOIN sga_adm_persona as pe on pe.per_id_pk=pr.per_id_fk where epi_id_pk='$epi_id_pk'","coalesce(per_nombres||' '||per_apellidopaterno||' '||per_apellidomaterno) as medico,
			esp_descripcion,pro_codigomsp,med_period as periodo, med_id_pk,epi_id_pk","","epi_id_pk","",6);


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
<!-- dise??o encabezado pie de pagina -->		
	<htmlpageheader name="myHeader1" style="display:none">

	

	</htmlpageheader>

	<htmlpagefooter name="myFooter1" style="display:none">

		<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt;

	    color: #000000; font-weight: bold; font-style: italic;">SNS-MSP / HCU-form.006 / 2008

	    <tr>

	    <td width="33%"><span style="font-weight: bold; font-style: italic;">SNS-MSP / HCU-form.006 / 2008</span></td>

	    <td width="33%" align="center" style="font-weight: bold; font-style: italic;"></td>

	    <td width="33%" style="text-align: right; ">EPICRISIS</td>

	    </tr></table>
	</htmlpagefooter>

	<htmlpageheader name="Chapter2HeaderOdd" style="display:none">
	</htmlpageheader>

	<htmlpagefooter name="Chapter2FooterOdd" style="display:none">

		<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt;

	    color: #000000; font-weight: bold; font-style: italic;">SNS-MSP / HCU-form.006 / 2008

	    <tr>

	    <td width="33%"><span style="font-weight: bold; font-style: italic;">SNS-MSP / HCU-form.006 / 2008</span></td>

	    <td width="33%" align="center" style="font-weight: bold; font-style: italic;"></td>

	    <td width="33%" style="text-align: right; ">EPICRISIS</td>

	    </tr></table>
	</htmlpagefooter>

	<div class="noheader">
		<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt;

	        color: #000000; font-weight: bold; font-style: italic;">SNS-MSP / HCU-form.006 / 2008

            <tr>
    
            <td width="33%"><span style="font-weight: bold; font-style: italic;">
            <IMG SRC="../../../../img/msp.jpg" WIDTH="80" HEIGHT="30">
            </span></td>
    
            <td width="5%" align="center" style="font-weight: bold; font-style: italic;"></td>
    
            <td width="40%" style="text-align: right; "><h3>'.$Con->entidad.'</h3></td>

	    </tr></table>
	<br>
<!-- datos paciente -->	
	<table border="1" width="100%" cellspacing="0" cellpadding="2"> 
	           <tr>
	              <th class="th" width="150"><center><h5>ESTABLECIMIENTO<h5></th>
	              <th class="th" width="150"><center><h5>NOMBRE<h5></center></th>
	              <th class="th" width="150"><center><h5>APELLIDO<h5></center></th>
	              <th class="th"  width="30"><center><h5>SEXO(M-F)<h5></center><div>
	              <th class="th" width="30"><center><h5>EDAD <h5></center></th>
	              <th class="th" width="150"><center><h5>N?? HISTORIA CL??NICA <h5></center></th>
	              
	              </div>
	               
	               </th>           
	              </font>
	              </tr>
	            </center>
	            <tr>
	              <td><center><font size=1>'.$Con->entidad.'</font></center></td>
	              <td><center><font size=1>'.($per[0]["per_nombres"] ?? '').'</font></center></td>
	              <td><center><font size=1>'.($per[0]["apellido"] ?? '').'</font></center></td>
	              <td><center><font size=1>'.($per[0]["per_sexo"] ?? '').'</font></center></td>
	              <td><center><font size=1>'.($per[0]["edad"] ?? '').'</font></center></td>
	              <td><center><font size=1>'.($per[0]["per_numeroidentificacion"] ?? '').'</font></center></td>   
	            </tr>  
	</table>
	<br>
<!-- primera hoja  -->	
	<table border="1" width="100%" cellspacing="0" cellpadding="2">
		<tr>
		<td width="33%" class="th"><span style="font-weight: bold; font-style: italic;"><H4><b>1. RESUMEN DE CUADRO CL??NICO</b><h4></span></td>
		</tr>
		<tr>
			<td  VALIGN="TOP">
			   <font size="2">'.($epic[1]["epi_recucl"] ?? '').'</font> 
			</td>
		</tr>
	</table><br>
	<table border="1" width="100%" cellspacing="0" cellpadding="2">
		<tr>
			<td width="33%" class="th"><span style="font-weight: bold; font-style: italic;"><H4><b>2. RESUMEN DE EVOLUCI??N Y COMPLICACIONES</b><h4></span></td>
		</tr>
		<tr>
			<td  VALIGN="TOP">
				<font size="2">'.($epic[1]["epi_reevco"] ?? '').'</font>
			</td>
		</tr>
	</table><br>
	<table border="1" width="100%" cellspacing="0" cellpadding="2">
		<tr>
	     <td width="33%" class="th"><span style="font-weight: bold; font-style: italic;"><H4><b>3. HALLAZGOS RELEVANTES DE EX??MENES Y PROCEDIMIENTOS DIAGN??STICOS</b><h4></span></td>
			h4></td>	
		</tr>
		<tr>
			<td  VALIGN="TOP">
				<font size="2">'.($epic[1]["epi_harexa"] ?? '').'</font>
			</td>
				
		</tr>
	</table>
	</div>
<!-- 2 hoja  -->	
	<div class="chapter2">

	<table border="1" width="100%" cellspacing="0" cellpadding="2">
		<tr>
		 <td width="33%" class="th"><span style="font-weight: bold; font-style: italic;"><H4><b>4. RESUMEN DE TRATAMIENTO Y PROCEDIMIENTOS TERAPE??TICOS</b><h4></span></td>
			h4></td>
		</tr>
		<tr>
			<td  VALIGN="TOP">
			    <font size="2">'.($epic[1]["epi_rtrprt"] ?? '').'</font>
			</td>
		</tr>

	</table>
	<br>

	<table width="100%">
	   <tr>
	    <td width="50%"  VALIGN="TOP">
	    	
	    	<table border="1" width="100%" cellspacing="0" cellpadding="2">
	    		<tr>
	    			<td width="" class="th" colspan="2"> <span style="font-weight: bold; font-style: italic;"><font size="2"> 5. DIAGN??STICO INGRESO</font> </spant></td>
	    			<th whdth="" class="th" ><font size="2">CIE</font></th>  
	    			<th whdth="" class="th" ><font size="2">PRE</font></th>  
	    			<th whdth="" class="th" ><font size="2">DEF</font></th>  
	    		</tr>';

				for ($i=0; $i < 6; $i++) {
                    $dne=$i+1;
            		$html .='<tr>
            <td widt="0.1%"><font size="2">'.$dne.'</font></td>
	    		   		<td widt=""><font size="1">'.($DiagI[$i]["detalle"] ?? '').'</font></td>
	    		   		<td widt=""><font size="1"><center>'.($DiagI[$i]["cie"] ?? '').'</center></font></td>
	    		   		<td widt=""><font size="1"><center>'.($DiagI[$i]["pre"] ?? '').'</center></font></td>
	    		   		<td widt=""><font size="1"><center>'.($DiagI[$i]["def"] ?? '').'</center></font></td>
	    				</tr>';
          		}
	    		$html .='
		  	</table>
	    </td>
	    <td width="50%"  VALIGN="TOP">
	        <table border="1" width="100%" cellspacing="0" cellpadding="2">
	    		<tr>
	    			<td width="" class="th" colspan="2"> <span style="font-weight: bold; font-style: italic;"><font size="2"> 6. DIAGN??STICO EGRESO </font></spant></td>
	    			<th whdth="" class="th" ><font size="2">CIE</font></th>  
	    			<th whdth="" class="th" ><font size="2">PRE</font></th>  
	    			<th whdth="" class="th" ><font size="2">DEF</font></th>  
	    		</tr>';
	    		for ($i=0; $i < 6; $i++) {
	    		    $td=$i+1;
            		$html .='<tr>
                         <td widt="0.1%"><font size="1">'.$td.'</font></td>
	    		   		<td widt=""><font size="1">'.($DiagE[$i]["detalle"] ?? '').'</font></td>
	    		   		<td widt=""><font size="1"><center>'.($DiagE[$i]["cie"] ?? '').'</center></font></td>
	    		   		<td widt=""><font size="1"><center>'.($DiagE[$i]["pre"] ?? '').'</center></font></td>
	    		   		<td widt=""><font size="1"><center>'.($DiagE[$i]["def"] ?? '').'</center></font></td>
	    				</tr>';
          		}
	    		$html .='
	    	</table>
	    </td>
	   </tr>
	</table>

	<br>

	<table border="1" width="100%" cellspacing="0" >
		<tr>
	     <td width="33%" class="th"><span style="font-weight: bold; font-style: italic;"><H4><b>7. CONDICIONES DE EGRESO Y PRON??STICO</b><h4></span></td>
			h4></td>	
		</tr>
		<tr>
			<td  VALIGN="TOP">
				<font size="2">'.($epic[1]["epi_condic"] ?? '').'</font>
			</td>
				<H6>SNS-MSP / HCU-form.006 / 2008 </H6>
		</tr>
	</table>
	<br>

	<table width="100%" border="1" cellspacing="0">
		<tr>
			<td class="th" colspan="5"><span style="font-weight: bold; font-style: italic;">
			8. M??DICOS TRATANTES</spant>
			</td>
		</tr>
		<tr>
			<td width="40%" colspan="2"></td>
			<td width="15%"><center>Especialidad</center></td>
			<td width="15%"><center>C??digo</center></td>
			<td width="25%"><center>Periodo de responsabilidad</center></td>
		</tr>';
		
			for ($i=0; $i < 4; $i++) {
					$n=$i+1;
            		$html .='<tr>
						<td width="0.1%"> <center> <font size="2">'.$n.' </font></center></td>
							<td width="40%"><font size="2">'.($Medi[$i]["medico"] ?? '').'</font></td>
							<td width="15%"><font size="2"><center>'.($Medi[$i]["esp_descripcion"] ?? '').'</center></font></td>
							<td width="15%"><font size="2"><center>'.($Medi[$i]["pro_codigomsp"] ?? '').'</center></font></td>
							<td width="25%"><font size="2"><center>'.($Medi[$i]["periodo"] ?? '').'</center></font></td>
						</tr>';	
          		}
	    		$html .='

	</table>
	<br>
	<table width="100%" border="1" cellspacing="0"> 
		<tr>
			<td  class="th" colspan="5" colspan="12" ><span style="font-weight: bold; font-style: italic;">
			9. CONDICIONES DE EGRESO Y PRON??STICO</spant>
			</td>
		</tr>
		<tr>
			<td class="th"><font size="2">Alta definitiva</td>
			<td width="20"><font size="2"><center>'.($epic[1]["alta_definitiva"] ?? '').'</center></font></td>
			<td class="th"><font size="2">Asintom??tico</td>
			<td width="20"><font size="2"><center>'.($epic[1]["asintomatica"] ?? '').'</center></font></td>
			<td class="th"><font size="2">Discapacidad moderada</td>
			<td width="20"><font size="2"><center>'.($epic[1]["dicapacidad_modereada"] ?? '').'</center></font></td>
			<td class="th"><font size="2">Retiro Autorizado</td>
			<td width="20"><font size="2"><center>'.($epic[1]["retiro_atoriza"] ?? '').'</center></font></td>
			<td class="th"><font size="2">Defunci??n - de 48 H</td>
			<td width="20"><font size="2"><center>'.($epic[1]["defucion_me_48"] ?? '').'</center></font></td>
			<td class="th"><font size="2">D??as de estadia</td>
			<td  width="20"><font size="2"><center>'.($epic[1]["epi_diaest"] ?? '').'</center></font></td>
			
		<tr>
		<tr>
			<td class="th"><font size="2">Alta transitoria</td>
			<td><font size="2"><center>'.($epic[1]["alta_transitoria"] ?? '').'</center></font></td>
			<td class="th"><font size="2">Discapacidad leve</td>
			<td><font size="2"><center>'.($epic[1]["dicapacidad_leve"] ?? '').'</center></font></td>
			<td class="th"><font size="2">Discapacidad grave</td>
			<td><font size="2"><center>'.($epic[1]["dicapacidad_grave"] ?? '').'</center></font></td>
			<td class="th"><font size="2">Retiro no autorizado</td>  
			<td><font size="2"><center>'.($epic[1]["retiro_no_atoriza"] ?? '').'</center></font></td>
			<td class="th"><font size="2">Defunci??n m??s de 48 H</td>  
			<td><font size="2"><center>'.($epic[1]["defucion_mas_48"] ?? '').'</center></font></td>
			<td class="th"><font size="2">D??as de incapacidad</td>  
			<td><font size="2"><center>'.($epic[1]["epi_diadin"] ?? '').'</center></font></td>
			
		<tr>
	</table>
	<br>
	
	<table border="1" cellspacing="0" width="100%"> 
		<tr>
			<td width="20" class="th"><font size="2">Fecha</font></td>
			<td width="10"><font size="2"><center>'.($epic[1]["epi_fecha"] ?? '').'</font></center></td>
			<td width="30" class="th"><font size="2">Hora</font></td>
			<td width="10"><font size="2"><center>'.substr($epic[1]["epi_hora"],0, -7) .'</font></center></td>
			<td width="95" class="th"><font size="2">Nombre del profesional</font></td>
			<td width="150"><font size="1"><center>'.($epic[1]["epi_respon"] ?? '').'</center></font></td> 
			<td width="50"><font size="1"><center>'.($epic[1]["epi_rescmsp"] ?? '').'</center></font></td>
			<td width="30" class="th"><font size="2">Firma</td>  
			<td width="150"></td>
			<td width="5" class="th"><font size="2">N??mero de hoja </font></td><td width="20"><center>2</center></td>
		<tr>
	</table>
	<font size="2"> REALIZADO POR : '. $epic[1]["responsable"].' '. $epic[1]["pro_codigomsp"].' '. $epic[1]["pro_codigosenescyt"].' C.I'. ($epic[1]["per_numeroidentificacion"] ?? '').'</font>
	</div>
	</body> 
	</html>
';
// CREACI??N DE PDF 
//$mpdf= new mPDF('c','A4','','arial');
$mpdf->writeHTML($html);
$mpdf->Output('Epicrisis.pdf','I');
?>