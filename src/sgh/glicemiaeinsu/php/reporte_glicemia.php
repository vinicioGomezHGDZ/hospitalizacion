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
$hce_id_fk=$_GET['h'];
$fecha=$_GET['f'];
// CONSULTAS DE REPORRTE
	# CARGAR DATOS DE ENCABEZADO. array 0
		$per=$Con->Get_Consulta("sgh_mei_glicemia ep
		join sga_adm_historiaclinica as h on ep.hce_id_fk=h.hce_id_pk
		join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
		join sga_adm_persona as  per on p.per_id_fk=per.per_id_pk
    join sga_adm_cama as ca on ep.cam_id_fk=ca.cam_id_pk
    join sga_adm_tipocama as sa on ca.tca_habi_fk=sa.tca_id_pk
    join sga_adm_tipocama as ser on ca.tca_serv_fk =ser.tca_id_pk","per_nombres ||' ' ||per_apellidopaterno ||' '|| per_apellidomaterno as paciente,
			date_part('year',age(per_fechanacimiento)) as Edad, hce_numerohc,ca.cam_codigo as cama,sa.tca_descripcion as sala,ser.tca_descripcion as servicio,per_numeroidentificacion","","hce_id_fk",$hce_id_fk,2);


    # CARGAR Datos general  
        $gli=$ConDI->Get_Consulta("sgh_mei_glicemia where hgi_dia>='".$fecha."' and hce_id_fk= '".$hce_id_fk."' ORDER BY hgi_dia DESC","hgi_glicem,hgi_esquem,hgi_espaco,hgi_totadm,hgi_obcerv,hgi_dia || ' ' ||hgi_fecha fecha","","","",5);
				//print_r ($DiagI); 
// HTML DE REPORTE 

	# code...
$html='';
$html.= '

	<html>

	<head>

	<style>
			.th{
				   background: #99e6ff;
				   color: #000000;
				}

			@page {
			  //margin:5mm 5mm 5mm 5mm ; 
			  margin:13mm 5mm 13mm 5mm ;
				
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

		<IMG SRC="../../../../img/msp.jpg" WIDTH=110 HEIGHT=30>

		</span></td>

		<td width="10%" align="center" style="font-weight: bold; font-style: italic;"></td>

		<td width="80%" style="text-align: right;"><h4>'.$Con->entidad.'</h4></td>

		</tr>
	</table>
</htmlpageheader>


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

<table><tr><td></td></tr></table>
<!-- primera hoja  -->	
<table width="100%">
	<tr>
		<th >
			<center><H4>HOJA DE GLICEMIAS E INSULINA</H4></center>
		</th>	
	</tr>
</table>
<table width=100%> 
	           <tr>
	              <th width="" class=""><center><font size=1>NOMBRE: <font></th>
	              <td><center><font size=1>'.($per[0]["paciente"] ?? '') .' </font></center></td>
	              <th width="" class=""><center><font size=1>HCI: <font></center></th>
	              <td><center><font size=1>'.($per[0]["per_numeroidentificacion"] ?? '').'</font></center></td>
	              <th width="" class=""><center><font size=1>SALA: <font></center></th>
	              <td><center><font size=1>'.($per[0]["sala"] ?? '').'</font></center></td>
	              <th width="" class=""><center><font size=1>CAMA: <font></center><div>
	              <td><center><font size=1>'.($per[0]["cama"] ?? '').'</font></center></td>
	              <th width="" class=""><center><font size=1>SERVICIO:  <font></center></th>
	              <td><center><font size=1>'.($per[0]["servicio"] ?? '').'</font></center></td>   
	             
	              </tr>
	            </center>
	           
</table>
<table><tr><td></td></tr></table>
<table border="1" width="100%" cellspacing="0" cellpadding="2">
	<tr>
		<th class="th">	FECHA </th>	
		<th class="th">	GLICEMIA </th>	
		<th class="th">	ESQUEMA </th>	
		<th class="th">	ESPACES CORRECCIÒN </th>	
		<th class="th">	OBSERVACIÓN </th>	
	</tr>';
	for ($i=0; $i <sizeof($gli) ; $i++) { 
		$html.='
			<tr>
				<td><font size=2><center>'.($gli[$i]["fecha"] ?? '').'</center></font></td>	
				<td><font size=2><center>'.($gli[$i]["hgi_glicem"] ?? '').'  mg / dl</center></font></td>	
				<td><font size=2><center>'.($gli[$i]["hgi_esquem"] ?? '').' UI</center></font></td>	
				<td><font size=2><center>'.($gli[$i]["hgi_espaco"] ?? '').' UI</center></font></td>	
				<td><font size=2><center>'.($gli[$i]["hgi_obcerv"] ?? '').' </center></font></td>	
			</tr>
			
		';
	}

$html.=
	'
</table>

</div>
	</body>
	</html>
';

// CREACIÓN DE PDF 
//$mpdf= new mPDF('c','A4','','arial');
$mpdf->writeHTML($html);
$mpdf->Output('Control de Glicemia e insulina.pdf','I');

?>