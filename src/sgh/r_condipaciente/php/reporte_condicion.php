<?php
require_once '../../../../vendor/autoload.php';
include_once("../../../../php/class_consulta.php");
use Mpdf\Mpdf;
$mpdf = new mPDF(['debug' => true,'mode'=>'utf-8','format'=>'A4']);

$Con=New Consulta();
$ConDI=New Consulta();
$ConMT=New Consulta();
$serv=$_GET['s'];
$fecha=$_GET['f'];
$responsble=$_GET['res'];

// responsable //

$respon=$Con->Get_Consulta("sgu_usu_usuario us
join sga_adm_profesional pr on us.pro_id_fk = pr.pro_id_pk
join sga_adm_persona per on pr.per_id_fk = per.per_id_pk where usu_id_pk='$responsble'","per_nombres || ' ' || per_apellidopaterno || ' ' || per_apellidomaterno as responsable , pro_codigomsp","","","",5);

// SALA //
$consal=new Consulta();
$sala=$consal->Get_Consulta("sga_adm_cama ca
left join sga_adm_tipocama ha on ca.tca_habi_fk =ha.tca_id_pk
left join sga_adm_tipocama se on ca.tca_serv_fk = se.tca_id_pk
where se.tca_descripcion='$serv' ","min(ha.tca_descripcion), max(ha.tca_descripcion)","","","",5);

$siv=$ConMT->Get_Consulta("sgh_mei_condipac con
left join sga_adm_cama ca on con.cam_id_fk = ca.cam_id_pk
left join sga_adm_tipocama ser on ca.tca_serv_fk = ser.tca_id_pk
left join sga_adm_historiaclinica as h on con.hce_id_fk=h.hce_id_pk
left join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
left join sga_adm_persona as  per on p.per_id_fk=per.per_id_pk where tca_descripcion='".$serv."' AND cdp_fecha='".$fecha."'",
            "ser.tca_descripcion as esp,cdp_fecha,ca.cam_codigo,per_nombres,per_apellidomaterno,per_apellidopaterno,
  case  when cdp_condic ='IGUAL' THEN 'X'  END IGUAL,
  case  when cdp_condic ='MEJORANDO' THEN 'X'  END MEJORANDO,
  case  when cdp_condic ='EMPEORANDO' THEN 'X'  END EMPEORANDO,
  case  when cdp_condic ='GRAVE' THEN 'X'  END GRAVE,
  case  when cdp_condic ='DEFUCION' THEN 'X'  END DEFUCION,cdp_fpalta as falta, cdp_fopera as foperacopn,cdp_fuoper as fueoperado,
  cdp_id_med","","","",6);

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
					margin:40mm 10mm 35mm 10mm ; 
			         size: auto;
			}

			@page chapter2 {

			    odd-header-name: html_Chapter2HeaderOdd;

			    even-header-name: html_Chapter2HeaderEven;

			    odd-footer-name: html_Chapter2FooterOdd;

			    even-footer-name: html_Chapter2FooterEven;

			}

			@page noheader {

			     odd-header-name: html_myHeader1;

			  even-header-name: html_myHeader2;

			  odd-footer-name: html_myFooter1;

			  even-footer-name: html_myFooter2;
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
	<table width="100%">
	    <tr>

	    <td width="33%"> <span style="font-weight: bold; font-style: italic;">
	    
	    <IMG SRC="../../../../img/msp.jpg" WIDTH="150" HEIGHT="50">

	    </span></td>

	    <td width="10%" align="center" style="font-weight: bold; font-style: italic;"></td>

	    <td width="50%" style="text-align: right; "><h4>'.$Con->entidad.'</h4></td>

	    </tr></table>
   <table><tr><td></td></tr></table>
	<!-- cabesera-->
	<table width="100%" border=1 cellspacing="0" cellpadding="2">
		<tr>
			<td>
				<center><b>Especialidad</b></center>
				<font size="2"><center>'.$serv.'<center></font>
			</td>
			<td>
				<center><b>Sala</b></center>	
				<font size="2"><center> '.($sala[0]["min"] ?? '') .' - '.($sala[0]["max"] ?? '') .'<center></font>
			</td>
			<td>
				<center><b>Fecha</b></center>	
				<font size="2"><center> '.$fecha.'<center></font>
			</td>
			
		</tr>
	</table>
	<table><tr><td></td></tr></table>
	
	</htmlpageheader>

	<htmlpagefooter name="myFooter1">
        <table width="100%">
        <tr>
        <td rowspan="2"><font size="1">La presente información es de total responsabilidad del servicio de enfermeria <br> y deberá entregarse a las 7 de la mañana a INFORMACÓN</font></td>
            <td style="text-align: right; ">
            <font size="1">'.($respon[0]["responsable"] ?? '') .' '.($respon[0]["pro_codigomsp"] ?? '') .'</font> 
            </td>
            </tr>
       <tr>
       	 
		 <td style="text-align: right; "> 
				<font size="2"> ENFERMERA / O</font> 
				
		 </td>
      </tr>
    </table>
    <br>
    <br>
        
		<table width="100%">
	    <tr>
	    <td width="30%">M.S.P - S.I Form. 554</td>
	    <td width="40%" style="text-align: right; "> Parte diario de la condición del paciente</td>

	    </tr></table>
	</htmlpagefooter>

<div class="noheader">


	<table border=1 cellspacing="0" cellpadding="2" width="100%">
		<tr>
			<td align="center" width=30 rowspan="2"><font size=1>Nº DE CAMA </font> </td>
			<td align="center" width=30 rowspan="2"><font size=1>NOMBRE</font> </td>
			<td align="center" width=30  colspan="5"><font size=1>CONDICIÓN DEL PACIENTE </font> </td>
			<td align="center" width=30 rowspan="2"><font size=1>FECHA PROBABLE ALTA  </font></td>
			<td align="center" width=30 rowspan="2"><font size=1>FECHA DE OPERACIÓN</font> </td>
			<td align="center" width=30 rowspan="2"><font size=1>FUE OPERAFO EL </font></td>
			<td align="center" width=30 rowspan="2"><font size=1>MÉDICO TRATANTE</font></td>
		</tr>
		<tr>
			<td align="center" width=30><font size=1>IGUAL</font></td>
			<td align="center" width=30><font size=1>MEJORANDO</font></td>
			<td align="center" width=30><font size=1>EMPEORANDO</font></td>
			<td align="center" width=30><font size=1>GRAVE</font></td>
			<td align="center" width=30><font size=1>DEFUCIÓN</font></td>
        </tr>
		';
		for ($i=0; $i <count($siv) ; $i++) {
			$html.='
			<tr>
			<td align="center"><font size=1>'.($siv[$i]["cam_codigo"] ?? '') .'</font> </td>
			<td align=""><font size=1>'.($siv[$i]["per_nombres"] ?? '') .' '.($siv[$i]["per_apellidopaterno"] ?? '') .'</font> </td>
			<td align="center"><font size=1>'.($siv[$i]["igual"] ?? '') .'</font> </td>
			<td align="center"><font size=1>'.($siv[$i]["mejorando"] ?? '') .'</font> </td>
			<td align="center"><font size=1>'.($siv[$i]["empeorando"] ?? '') .'</font> </td>
			<td align="center"><font size=1>'.($siv[$i]["grave"] ?? '') .'</font> </td>
			<td align="center"><font size=1>'.($siv[$i]["defucion"] ?? '') .'</font> </td>
			<td align="center"><font size=1>'.($siv[$i]["falta"    ] ?? '') .'</font> </td>
			<td align="center"><font size=1>'.($siv[$i]["foperacopn"] ?? '') .'</font> </td>
			<td align="center"><font size=1>'.($siv[$i]["fueoperado"] ?? '') .'</font> </td>
			<td align=""><font size=1>'.($siv[$i]["cdp_id_med"] ?? '') .'</font> </td>
			</tr>
			';
		}
		$html.='
	</table>
	 
    </div>
</body>
		
';




// CREACIÓN DE PDF 
//$mpdf= new mPDF('c','A4','','arial');
$mpdf->writeHTML($html);
$mpdf->Output('Condiciòn del paciente.pdf','I');
?>