<?php
require_once '../../../../vendor/autoload.php';
include_once("../../../../php/class_consulta.php");
use Mpdf\Mpdf;
$mpdf = new mPDF(['debug' => true,'mode'=>'utf-8','format'=>'A4']);
$Conpro=New Consulta();
$ConDEpro=New Consulta();
$entidad=$Conpro->entidad;
$hce_id_pk=$_GET['h'];
$fi=$_GET['fi'];
$fa=$_GET['fa'];
// CONSULTAS DE REPORRTE
	# CARGAR DATOS DE ENCABEZADO. array 0
		$per=$Conpro->Get_Consulta("sgh_ped_prblemas ep
		join sga_adm_historiaclinica as h on ep.hce_id_fk=h.hce_id_pk
		join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
		join sga_adm_persona as  per on p.per_id_fk=per.per_id_pk
		JOIN sga_adm_sexo as se on se.sex_id_pk=per.sex_id_fk","per_nombres,(per_apellidopaterno ||' '|| per_apellidomaterno ) as apellido,
			date_part('year',age(per_fechanacimiento)) || ' Años '||date_part('mons',age(per_fechanacimiento)) ||' Meses '|| date_part('days',age(per_fechanacimiento)) || ' Días' as Edad,per_numeroidentificacion,sex_codigo as per_sexo","","hce_id_fk",$hce_id_pk,2);
			
	# CARGAR DIAGNOSTICO EGRESO 
    $pro=$ConDEpro->Get_Consulta("sgh_ped_prblemas WHERE pbl_fehca >='$fi' and  pbl_fehca <='$fa'  and hce_id_fk='".$hce_id_pk."' ORDER BY pbl_fehca DESC","hce_id_fk,pbl_edad,pbl_fecini,pbl_fecdet,pbl_antece,
CASE WHEN pbl_actpasi ='ACTIVO' then 'x' end as activo,CASE WHEN pbl_actpasi ='PASIVO' then 'x' end as pasivo,pbl_sindro,pbl_fehca","","","",5);
	
//$mpdf->useOddEven = 1;
// HTML DE REPORTE 

	# code...

$htmlproblemas= '

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

			@page chapter22 {

			    odd-header-name: html_Chapter2HeaderOdd;

			    even-header-name: html_Chapter2HeaderEven;

			    odd-footer-name: html_Chapter2FooterOdd;

			    even-footer-name: html_Chapter2FooterEven;

			}

			@page noheader22 {
				
			    odd-header-name: _blank;

			    even-header-name: _blank;

			    odd-footer-name: _blank;

			    even-footer-name: _blank;

			}

			div.chapter22 {

			    page-break-before: right;

			    page: chapter22;

			}

			div.noheader22 {

			    page-break-before: right;

			    page: noheader22;

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


<div class="noheader22"><br>

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
	              <td><center><font size=1>'.$entidad.'</font></center></td>
	              <td><center><font size=1>'.($per[0]["per_nombres"] ?? '') .'</font></center></td>
	              <td><center><font size=1>' .($per[0]["apellido"] ?? '') .'</font></center></td>
	              <td><center><font size=1>'.($per[0]["per_sexo"] ?? '') .'</font></center></td>
	              <td><center><font size=1>'.($per[0]["edad"] ?? '') .'</font></center></td>
	              <td><center><font size=1>'.($per[0]["per_numeroidentificacion"] ?? '') .'</font></center></td>   
	            </tr>  
</table>
<table><tr><td></td></tr></table>
<!-- primera hoja  -->	
<table border="1" width="100%" cellspacing="0" cellpadding="2">
	<tr>
		<td class="th" colspan=7>
			<center><h5>PROBLEMAS</h5></center>
		</td>	
		<td class="th" colspan=2>
			<center><h5>RESUELTO A:</h5></center>
		</td>
	</tr>
	<tr>
		<td class="th"><font size=1><center>NUM</center></font></td>	
		<td class="th"><font size=1><center>EDAD</center></font></td>
		<td class="th"><font size=1><center>FECHA DE INICIO</center></font></td>
		<td class="th"><font size=1><center>FECHA DE DETECCIÓN</center></font></td>
		<td class="th"><font size=1><center>ANTECEDENTES FAMILIARES HEREDITARIOS DIAGNOSTICOS PREVIOS, FACTORES DE RIESGO SINTOMAS, SIGNOS</center></font></td>
		<td class="th"><font size=1><center>ACTIVO</center></font></td>
		<td class="th"><font size=1><center>PASIVO</center></font></td>
		<td class="th"><font size=1><center>SINDROME, DIAGNOSTICOS, RPOBLEMAS, I DIAGNOSTICOS DEFINITIVOS</center> </font></td>
		<td class="th"><font size=1><center>FECHA</center></font></td>
	</tr>';
		for ($i=0; $i <sizeof($pro); $i++) {
		$num=$i+1; 
		$htmlproblemas.='
		<tr>		
			<td><font size=1><center>'.$num.'</center></font></td>		
			<td><font size=1><center>'.($pro[$i]["pbl_edad"] ?? '') .'</center></font></td>		
			<td><font size=1><center>'.($pro[$i]["pbl_fecini"] ?? '') .'</center></font></td>
			<td><font size=1><center>'.($pro[$i]["pbl_fecdet"] ?? '') .'</center></font></td>
			<td><font size=1><center>'.($pro[$i]["pbl_antece"] ?? '') .'</center></font></td>
			<td><font size=1><center>'.($pro[$i]["activo"] ?? '') .'</center></font></td>
			<td><font size=1><center>'.($pro[$i]["pasivo"] ?? '') .'</center></font></td>
			<td><font size=1><center>'.($pro[$i]["pbl_sindro"] ?? '') .'</center></font></td>
			<td><font size=1><center>'.($pro[$i]["pbl_fehca"] ?? '') .'</center></font></td>
		</tr>	
		';	
		}
	$htmlproblemas.='	

</table>

</div>
	</body>
	</html>
';

// CREACIÓN DE PDF 
//$mpdf= new mPDF('c','A4','','arial');
$mpdf->writeHTML($htmlproblemas);
$mpdf->Output('Lista de problemas.pdf','I');

?>