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
		$per=$Con->Get_Consulta("sgh_mei_evolucion ep
		join sga_adm_historiaclinica as h on ep.hce_id_fk=h.hce_id_pk
		join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
		join sga_adm_persona as  per on p.per_id_fk=per.per_id_pk
		JOIN sga_adm_sexo as se on se.sex_id_pk=per.sex_id_fk","per_nombres,(per_apellidopaterno ||' '|| per_apellidomaterno ) as apellido,
			date_part('year',age(per_fechanacimiento)) as Edad,per_numeroidentificacion,sex_codigo as per_sexo","","hce_id_fk",$hce_id_pk,2);
			//print_r($per);	



$bdd= new Conectar();
$sql=$bdd->prepare("
        select json_agg(t) from (
         select to_char(eyp_fechas,'dd-MM-YYYY') as eyp_fechas,eyp_hora,regexp_replace(eyp_nodevu,'\n','<br>','g') eyp_nodevu,
          regexp_replace(eyp_prescr,'\n','<br>','g') eyp_prescr,eyp_asunto,pe.per_nombres || ' ' ||per_apellidopaterno  || ' ' || per_apellidomaterno  as medico,pr.pro_codigomsp as msp,pr.pro_codigosenescyt as sncy,pe.per_numeroidentificacion as ci,eyp_revisaresidente
          from sgh_mei_evolucion ev
			JOIN sgu_usu_usuario as us on usu_id_fk = us.usu_id_pk
           JOIN sga_adm_profesional as pr on us.pro_id_fk=pro_id_pk
			JOIN sga_adm_persona as pe  on pr.per_id_fk= pe.per_id_pk
			JOIN sga_adm_profesion as pro on pr.prf_id_fk = pro.prf_id_pk where eyp_fechas >='$fi' and eyp_fechas <='$fa' and hce_id_fk='".$hce_id_pk."' order by eyp_id_pk,eyp_hora 
        )t");

$sql->execute();
$row=$sql->fetchAll (PDO::FETCH_ASSOC);
$evo=json_decode($row[0]["json_agg"],true);



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

		<script src="dist/autosize.js"></script>
		
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
	            
	            <tr>
				<td><center><font size="1"><small>'.$Con->entidad.'</small></font></center></td>
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
			    <td width="33%"> <br><br><br><br><font size="1">SNS-MSP / HCU-form.005 / 2008 </font></td>

			    <td width="33%" align="center"></td>

			    <td width="33%" style="text-align: right;">
				<br><br><br><br><font size="3">
			    EVOLUCIÓN Y PRESCRIPCIONES</font></td>

			    </tr>
	    </table>
	</htmlpagefooter>
<!-- primera hoja  -->	
	<table border=1 cellspacing="0" cellpadding="2" width="100%">
					<tr>
						<td colspan="3" class="th">
							<font size="3"> <b>1 EVOLUCIÓN</b></font>	
						</td>
						<td class="th">
							<font size="3"> <b>2 PRESCRIPCIONES</b></font>	
						</td>
					</tr>
				    <tr>
						<td class="th" width="10">
							<font size="1"> <center>FECHA <br> (DIA/MES/AÑO)</center></font>	
						</td>
						<td class="th" width="10">
							<font size="1"><center>HORA</center></font>	
						</td>
						<td class="th">
							<font size="1"><center> NOTA DE EVOLUCIÓN</center></font>	
						</td>
						<td class="th">
							<font size="1"> <center><b>FARMACOTERAPIA E INDICACIONES </b><br>
											(PARA ENFERMERÍA Y OTRO PERSONAL)
							</center></font>	
						</td>
					</tr>';
$contador=0;
if(!is_null($evo)){
	$contador=count($evo);
}
					
for ($i=0; $i < $contador; $i++) {
    if ($evo[$i]["msp"] === null){
        $msp=$evo[$i]["sncy"];
        if ($evo[$i]["sncy"] === null) {$msp='C.I  '.$evo[$i]["ci"].'';}
    }
    else{
        $msp=$evo[$i]["msp"];
    };
    $html.='
					<tr>

						<td class="" width="10" VALIGN="TOP">
							<font size="1"><center> '.($evo[$i]["eyp_fechas"] ?? '') .'</center></font>
						</td>
						<td class="" width="10" VALIGN="TOP">
							<font size="1"><center>'.substr($evo[$i]["eyp_hora"],0,8).'</center></font>
						</td>
						<td class="" width="500" VALIGN="TOP" style="text-align: justify">
							<font size="1"><b >'.($evo[$i]["eyp_asunto"] ?? '') .'</b> <br><br>
						    '.$evo[$i]["eyp_nodevu"].'
							</font>
						</td>
						<td VALIGN="TOP"  width="360" style="text-align: justify">
							<font size="1">'.($evo[$i]["eyp_prescr"] ?? '') .'</font> <br><br>
							<font size="1">'.($evo[$i]["medico"] ?? '').'  '.$msp.'</font><br><br>

							<font size="1">'.($evo[$i]["eyp_revisaresidente"] ?? '') .'</font>
						</td>
					</tr>';}
$html.='
	</table>

</body>
		
';

// CREACIÓN DE PDF 
//$mpdf= new mPDF('c','A4','8','arial');
$mpdf->writeHTML($html);
$mpdf->Output('Evolución.pdf','I');
?>