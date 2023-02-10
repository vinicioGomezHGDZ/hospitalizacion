<?php
require_once("../../../../js/lib/mpdf-6.1.3/mpdf.php");
include_once("../../../../php/class_consulta.php");
$Con=New Consulta();
$ConDI=New Consulta();
$ConMT=New Consulta();
$serv=$_GET['s'];
$fecha=$_GET['f'];
$responsble=$_GET['res'];

// CONSULTAS DE REPORRTE
	# CARGAR DATOS DE ENCABEZADO. array 0
$consal=new Consulta();
$sala=$consal->Get_Consulta("sga_adm_cama ca
join sga_adm_tipocama ha on ca.tca_habi_fk =ha.tca_id_pk
join sga_adm_tipocama se on ca.tca_serv_fk = se.tca_id_pk
where se.tca_descripcion='$serv' ","min(ha.tca_descripcion), max(ha.tca_descripcion)","","","",5);

		$siv=$ConMT->Get_Consulta("sgh_mei_condipac con
join sga_adm_cama ca on con.cam_id_fk = ca.cam_id_pk
join sga_adm_tipocama ser on ca.tca_serv_fk = ser.tca_id_pk
join sga_adm_historiaclinica as h on con.hce_id_fk=h.hce_id_pk
join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
join sga_adm_persona as  per on p.per_id_fk=per.per_id_pk where cdp_fecha='".$fecha."'",
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
				margin:20mm 5mm 13mm 5mm ; 
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

	    <td width="33%" align="center" style="font-weight: bold; font-style: italic;"></td>

	    <td width="40%" style="text-align: right;"><h4>'.$consal->entidad.'</h4></td>

	    </tr>
	</table>
		
	
	</htmlpageheader>

	<htmlpagefooter name="myFooter1" style="display:none">

		<table width="100%">
			    <tr>
			    <td width="33%"> <br><br><br><br><font size=1>M.S.P S.I. form.554 </font></td>

			    <td width="33%" align="center"></td>

			    <td width="33%" style="text-align: right;">
				<br><br><br><br><font size=3>
			    Parte diaria de la condiciòn del paciente</font></td>
			    </tr>
	    </table>
	</htmlpagefooter>
	    
<!-- primera hoja  -->	
	<table border=1 cellspacing="0" cellpadding="2" width="100%">
	    <tr>
	        <td>ESPECIALIDAD</td>
	        <td>SALA</td>
	        <td>FECHA</td>
        </tr>
        <tr>	
			<td>

				<font size="2"><center>'.$serv.'<center></font>
			</td>
			<td>	
				<font size="2"><center> '.$sala[0]["min"].' - '.$sala[0]["max"].'<center></font>
			</td>
			<td>
				<font size="2"><center> '.$fecha.'<center></font>
			</td>		
		</tr>
    </table>
    	<table >
	    <tr>
	        <td></td>
        </tr>
    </table>
	<table border=1 cellspacing="0" cellpadding="2" width="100%">
		<tr>
			<th class="" width=30 rowspan="2"><font size=1>Nº DE CANA </font> </th>
			<th class="" width=30 rowspan="2"><font size=1>NOMBRE</font> </th>
			<th class="" width=30  colspan="5"><font size=1>CONDICIÓN DEL PACIENTE </font> </th>
			<th class="" width=30 rowspan="2"><font size=1>FECHA PROBABLE ALTA  </font></th>
			<th class="" width=30 rowspan="2"><font size=1>FECHA DE OPERACIÓN</font> </th>
			<th class="" width=30 rowspan="2"><font size=1>FUE OPERAFO EL :</font></th>
			<th class="" width=30 rowspan="2"><font size=1>MÉDICO TRATANTE</font></th>
		</tr>
		<tr>
			<th class="" width=30><font size=1>IGUAL</font></th>
			<th class="" width=30><font size=1>MEJORANDO</font></th>
			<th class="" width=30><font size=1>EMPEORANDO</font></th>
			<th class="" width=30><font size=1>GRAVE</font></th>
			<th class="" width=30><font size=1>DEFUCIÓN</font></th>
        </tr>
		    
		';
		for ($i=0; $i <count($siv) ; $i++) { 
			$html.='
			<tr>
			<td align="center"><font size=1>'.$siv[$i]["cam_codigo"].'</font> </td>
			<td align="center"><font size=1>'.$siv[$i]["per_nombres"].' '.$siv[$i]["per_apellidopaterno"].' '.$siv[$i]["per_apellidomaterno"].'</font> </td>
			<td align="center"><font size=1>'.$siv[$i]["igual"].'</font> </td>
			<td align="center"><font size=1>'.$siv[$i]["mejorando"].'</font> </td>
			<td align="center"><font size=1>'.$siv[$i]["empeorando"].'</font> </td>
			<td align="center"><font size=1>'.$siv[$i]["grave"].'</font> </td>
			<td align="center"><font size=1>'.$siv[$i]["defucion"].'</font> </td>
			<td align="center"><font size=1>'.$siv[$i]["falta"    ].'</font> </td>
			<td align="center"><font size=1>'.$siv[$i]["foperacopn"].'</font> </td>
			<td align="center"><font size=1>'.$siv[$i]["fueoperado"].'</font> </td>
			<td align="center"><font size=1>'.$siv[$i]["cdp_id_med"].'</font> </td>
			</tr>
			';
		}
		$html.='
	</table>
	<table>
	<tr>
	
    </tr>
    <tr>
       
    </tr>
    </table> 
</body>
		
';

// CREACIÓN DE PDF 
$mpdf= new mPDF('c','A4','','arial');
$mpdf->writeHTML($html);
$mpdf->Output('Signos Vitales.pdf','I');
?>