<?php
require_once '../../../../vendor/autoload.php';
include_once("../../../../php/class_consulta.php");
use Mpdf\Mpdf;
$mpdf = new mPDF(['debug' => true,'mode'=>'utf-8','format'=>'A4']);
// retornma un json
date_default_timezone_set('America/Guayaquil');

$Con=New Consulta();
$Conpa=New Consulta();
$ConDE=New Consulta();
$ConMT=New Consulta();

$fecha=$_GET['f'];
//echo $fecha;

// CONSULTAS DE REPORRTE
	# CARGAR DATOS DE ENCABEZADO. array 0
	$cen=$Con->Get_Consulta("sgh_mei_censo di
                join sga_adm_cama ca on di.cam_id_fk=ca.cam_id_pk
                join sga_adm_tipocama pi on ca.tca_piso_fk=pi.tca_id_pk
                join sga_adm_tipocama se on ca.tca_serv_fk=se.tca_id_pk
                where cen_tipo='INGRESO' AND cen_visible='true'","se.tca_descripcion as servicio, pi.tca_descripcion","","","",6);
			//print_r($per);	

   //print_r($per);

//$mpdf->useOddEven = 1;
// HTML DE REPORTE 

$html = '

	<html>

	<head>
	<style>
			.th{
				  
				}
            .tr {
                   bordercolor:#FFFFFF;
                }
            
			@page {
			
			  size: auto;
			   margin: 7mm 7mm 7mm 7mm ; 
			}
			
			@page chapter2 {

			    odd-header-name: html_Chapter2HeaderOdd;

			    even-header-name: html_Chapter2HeaderEven;

			    odd-footer-name: html_Chapter2FooterOdd;

			    even-footer-name: html_Chapter2FooterEven;

			}
            div.chapter2 {
    
                    page-break-before: right;
    
                    page: chapter2;
    
                }
	</style>

		
		
	</head>



<!-- diseño encabezado pie de pagina -->		

	<htmlpageheader name="myHeader1" style="display:none">

<!-- datos paciente -->	
	

	
	</htmlpageheader>
	<htmlpagefooter name="myFooter1" style="display:none">
	</htmlpagefooter>
<!-- PEDIATRIA  -->	

';

for ($s=0; $s <count($cen) ; $s++)
{
    $d1 = 0;
    $d2 = 0;
    $d3 = 0;
    $d4 = 0;
    $d5 = 0;
    $d6 = 0;
    $d7 = 0;
    $d8 = 0;
    $d9 = 0;
    $d10 = 0;
    $d11 = 0;
    $d12 = 0;
    $colaion=0;
    $cena=0;
    $dimadre=0;
    $totaldie=0;
    $Conpa='Conpa'.$s;

    $$Conpa=New Consulta();
$html.='
<div class="chapter2">
<table width="100%">
	    <tr>
	    <td width="33%"><span style="font-weight: bold; font-style: italic;">
	    <IMG SRC="../../../../img/msp.jpg" WIDTH=200 HEIGHT=50>
	    </span></td>
	    <td width="40%" style="text-align: right;"><h3>'.$Con->entidad.'</h3></td>
	    </tr>
	</table>	
		<table width="100%">
			<tr>
				<td>
				<center>
				SERVICIO DE HOSPITALIZACIÓN '.($cen[$s]["servicio"] ?? '') .' <br>
				PEDIDO DE DIETAS
				</center>
				</td>	
			</tr>
		</table>
		<table>
			<tr>
				<td width=325>
					<font size=2><b>HOSPITAL </b></font><font size=2>'.$Con->entidad.' </font>
				</td>
			
				<td width=250>
					<font size=2><b>LOCALIDAD </b></font><font size=2></font>
				</td>
			

			</tr>
			<tr>
				<td>
					<font size=2><b>SALA </b></font>	<font size=2>'.($cen[$s]["tca_descripcion"] ?? '') .'</font>
				</td>
				
				<td>
					<font size=2><b>FECHA </b></font><font size=2>'.$fecha.'</font>
				</td>
			
			</tr>
		</table>
		
	<table  border="1" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<th text-rotate="90" align="center" width="10" rowspan="2">
				<font size=1>CUARTO</font>
			</th>
			<th text-rotate="90" align="center" width="10" rowspan="2">
				<font size=1>CAMA</font>
			</th>			
			<th align="center" rowspan="2">
				<font size=2>NOMBRE DEL PACIENTE</font>
			</th>
			<th text-rotate="90" align="center" rowspan="2">
				<font size=2>DIETA MADRE</font>
			</th>
			<th text-rotate="90" align="center" rowspan="2">
				<font size=2>DIETA GENERAL</font>
			</th>	<th align="center" colspan="2">
				<font size=2>LÍQUIDAS</font>
			</th>	
			<th align="center" colspan="3">
				<font size=2>BLANDAS</font>
			</th>
			<th align="center" colspan="6">
				<font size=2>RESTRINGIDAS</font>
			</th>
			<th text-rotate="90" align="center" rowspan="2">
				<font size=2>COLACIÓN</font>
			</th>
			<th text-rotate="90" align="center" rowspan="2">
				<font size=2>CENA</font>
			</th>
		</tr>
		<tr>                                
		    <th text-rotate="90" ><font size=2>ESTRICTA</font></th>
		    <th text-rotate="90" ><font size=2>AMPLIA</font></th>
		    <th text-rotate="90" ><font size=2>HIPOGRASA</font></th>
		    <th text-rotate="90" ><font size=2>INTESTINAL</font></th>
		    <th text-rotate="90" ><font size=2>GÁSTRICA</font></th>
		    <th class="borde">
		     
		     <table class="th"> 
		        <tr >
		            <th text-rotate="90">
		           <font size=2>HIPOIDRO </font>
                 
		            </th>
		            <th text-rotate="90">
		           <font size=2>CARBONADA</font>
		            </th>
		        </tr>
            </table> 
            <table border="1" cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
		    </th>
		    <th text-rotate="90" ><font size=2>HIPOCALÓRICA</font></th>
		    <th text-rotate="90" ><font size=2>HIPERPROTÉICA</font></th>
		    <th text-rotate="90" ><font size=2>HIPOPROTÉICA</font></th>
		    <th text-rotate="90" ><font size=2>HIPOSODICA</font></th>
		    <th text-rotate="90" ><font size=2>SONDA</font></th>
		</tr>
		';
            $pas=$$Conpa->Get_Consulta("sgh_mei_dietas_detalle di
            join sga_adm_historiaclinica hc on di.hce_id_fk=hc.hce_id_pk
            join sga_adm_paciente pa on hc.pac_id_fk=pa.pac_id_pk
            join sga_adm_persona pe on pa.per_id_fk=pe.per_id_pk
            join sga_adm_cama ca on di.cam_id_fk=ca.cam_id_pk
            join sga_adm_tipocama hab on ca.tca_habi_fk=hab.tca_id_pk
            join sga_adm_tipocama pi on ca.tca_piso_fk=pi.tca_id_pk
            join sga_adm_tipocama se on ca.tca_serv_fk=se.tca_id_pk
            join sgh_mei_censo cen on cen.hce_id_fk=di.hce_id_fk where cen_tipo='INGRESO' AND cen_visible='true' and
            pi.tca_descripcion='".$cen[$s]["tca_descripcion"]."' and se.tca_descripcion='".$cen[$s]["servicio"]."'","hc.hce_id_pk,hab.tca_descripcion as cuarto,ca.cam_codigo as cama, per_nombres ||' '|| per_apellidopaterno || ' ' || per_apellidomaterno as paciente","","","",6);

                 for ($p=0; $p <count($pas) ; $p++) {

                     $Condi = 'Condi' . $s;
                     $Condisuma = 'Condisuma' . $s;

                     $$Condi = New Consulta();
                     $$Condisuma = New Consulta();

                     $die = $$Condi->Get_Consulta("sgh_mei_dietas_detalle di
                    join sga_adm_cama ca on di.cam_id_fk=ca.cam_id_pk
                    join sga_adm_tipocama pi on ca.tca_piso_fk=pi.tca_id_pk
                    join sga_adm_tipocama se on ca.tca_serv_fk=se.tca_id_pk
                    join sgh_mei_censo cen on cen.hce_id_fk=di.hce_id_fk
                    join sgh_mei_dieta die on di.die_id_fk=die.die_id_pk
                        where cen_tipo='INGRESO' AND cen_visible='true' and
                        pi.tca_descripcion='" . $cen[$s]["tca_descripcion"] . "' and se.tca_descripcion='" . $cen[$s]["servicio"] . "'  and did_fecha='" . $fecha . "' and di.hce_id_fk='" . $pas[$p]["hce_id_pk"] . "' ORDER BY die_orden", "die_id_pk,die_descrip,did_obce,die_orden,
                        CASE when (did_res=true) then 'X'END did_res", "", "", "", 5);


                     $html .= '
					<tr>
						<td align="center" HEIGHT="30"><font size=1>' . $pas[$p]["cuarto"] . '</font></td>
						<td align="center" HEIGHT="30"><font size=1>' . $pas[$p]["cama"] . '</font></td>
						<td width="200"><font size=1>' . $pas[$p]["paciente"] . '</font></td>
					    ';
                              $html .= '
                                <td align="center"><font size="2"><b>'.($die[12]["did_res"] ?? '') .'</b></font> <br> <font size="1">'.($die[12]["did_obce"] ?? '') .'</font></td>
                                <td align="center"><font size="2"><b>'.($die[1]["did_res"] ?? '') .'</b></font> <br> <font size="1">'.($die[1]["did_obce"] ?? '') .'</font></td>
                                <td align="center"><font size="2"><b>'.($die[2]["did_res"] ?? '') .'</b></font> <br> <font size="1">'.($die[2]["did_obce"] ?? '') .'</font></td>
                                <td align="center"><font size="2"><b>'.($die[3]["did_res"] ?? '') .'</b></font> <br> <font size="1">'.($die[3]["did_obce"] ?? '') .'</font></td>
                                <td align="center"><font size="2"><b>'.($die[4]["did_res"] ?? '') .'</b></font> <br> <font size="1">'.($die[4]["did_obce"] ?? '') .'</font></td>
                                <td align="center"><font size="2"><b>'.($die[5]["did_res"] ?? '') .'</b></font> <br> <font size="1">'.($die[5]["did_obce"] ?? '') .'</font></td>
                                <td align="center"><font size="2"><b>'.($die[6]["did_res"] ?? '') .'</b></font> <br> <font size="1">'.($die[6]["did_obce"] ?? '') .'</font></td>
                                <td align="center"><font size="2"><b>'.($die[7]["did_res"] ?? '') .'</b></font> <br> <font size="1">'.($die[7]["did_obce"] ?? '') .'</font></td>
                                <td align="center"><font size="2"><b>'.($die[8]["did_res"] ?? '') .'</b></font> <br> <font size="1">'.($die[8]["did_obce"] ?? '') .'</font></td>
                                <td align="center"><font size="2"><b>'.($die[9]["did_res"] ?? '') .'</b></font> <br> <font size="1">'.($die[9]["did_obce"] ?? '') .'</font></td>
                                <td align="center"><font size="2"><b>'.($die[10]["did_res"] ?? '') .'</b></font> <br> <font size="1">'.($die[10]["did_obce"] ?? '') .'</font></td>
                                <td align="center"><font size="2"><b>'.($die[11]["did_res"] ?? '') .'</b></font> <br> <font size="1">'.($die[11]["did_obce"] ?? '') .'</font></td>
                                <td align="center"><font size="2"><b>'.($die[0]["did_res"] ?? '') .'</b></font> <br> <font size="1">'.($die[0]["did_obce"] ?? '') .'</font></td>
                                <td align="center"><font size="2">'.($die[13]["did_obce"] ?? '') .'</font></td>
                                <td align="center"><font size="2">'.($die[14]["did_obce"] ?? '') .'</font></td>
                             ';
                     $diesum = $$Condisuma->Get_Consulta("sgh_mei_dietas_detalle di
                    join sga_adm_cama ca on di.cam_id_fk=ca.cam_id_pk
                    join sga_adm_tipocama pi on ca.tca_piso_fk=pi.tca_id_pk
                    join sga_adm_tipocama se on ca.tca_serv_fk=se.tca_id_pk
                    join sgh_mei_censo cen on cen.hce_id_fk=di.hce_id_fk
                    join sgh_mei_dieta die on di.die_id_fk=die.die_id_pk
                        where cen_tipo='INGRESO' AND cen_visible='true' and
                        pi.tca_descripcion='" . $cen[$s]["tca_descripcion"] . "' and se.tca_descripcion='" . $cen[$s]["servicio"] . "'  and did_fecha='" . $fecha . "' and di.hce_id_fk='" . $pas[$p]["hce_id_pk"] . "' and did_res=true ORDER BY die_orden", "die_id_pk,die_descrip,did_obce,die_orden,
                        CASE when (did_res=true) then 'X'END did_res", "", "", "", 5);

                           for ($dc = 0; $dc < count($diesum); $dc++) {
                                         if ($diesum[$dc]["die_orden"] === 1) {
                                             $d1 += 1;
                                             break;
                                         }
                                         if ($diesum[$dc]["die_orden"] === 2) {
                                             $d2 += 1;
                                             break;
                                         }
                                         if ($diesum[$dc]["die_orden"] === 3) {
                                             $d3 += 1;
                                             break;
                                         }
                                         if ($diesum[$dc]["die_orden"] === 4) {
                                             $d4 += 1;
                                             break;
                                         }
                                         if ($diesum[$dc]["die_orden"] === 5) {
                                             $d5 += 1;
                                             break;
                                         }
                                         if ($diesum[$dc]["die_orden"] === 6) {
                                             $d6 += 1;
                                             break;
                                         }
                                         if ($diesum[$dc]["die_orden"] === 7) {
                                             $d7 += 1;
                                             break;
                                         }
                                         if ($diesum[$dc]["die_orden"] === 8) {
                                             $d8 += 1;
                                             break;
                                         }
                                         if ($diesum[$dc]["die_orden"] === 9) {
                                             $d9 += 1;
                                             break;
                                         }
                                         if ($diesum[$dc]["die_orden"] === 10) {
                                             $d10 += 1;
                                             break;
                                         }
                                         if ($diesum[$dc]["die_orden"] === 11) {
                                             $d11 += 1;
                                             break;
                                         }
                                         if ($diesum[$dc]["die_orden"] === 12) {
                                             $d12 += 1;
                                             break;
                                         }
                                     }

                           for ($de=0; $de < count($diesum); $de++){
                                         $valor=$diesum[$de]["did_obce"];
                                         if($diesum[$de]["die_id_pk"] === 23){$dimadre+=1;}
                                         if($diesum[$de]["die_id_pk"] === 24){$cena+=$valor;}
                                         if($diesum[$de]["die_id_pk"] === 18){$colaion+=$valor;}
                                     }
                     $totaldie=$d1+$d2+$d3+$d4+$d5+$d6+$d7+$d8+$d9+$d10+$d11+$d12;
                         $html .= '
            </tr>
        
            ';
         }

    $html.='
           <tr>
                 <th colspan="3">
	              Total <br> '.$totaldie.'
                 </th>
             <td align="center"><font size="1">'.$dimadre.'</font></td>  
             <td align="center"><font size="1">'.$d2.'</font></td>  
             <td align="center"><font size="1">'.$d3.'</font></td>  
             <td align="center"><font size="1">'.$d4.'</font></td>  
             <td align="center"><font size="1">'.$d5.'</font></td>  
             <td align="center"><font size="1">'.$d6.'</font></td>  
             <td align="center"><font size="1">'.$d7.'</font></td>  
             <td align="center"><font size="1">'.$d8.'</font></td>  
             <td align="center"><font size="1">'.$d9.'</font></td>  
             <td align="center"><font size="1">'.$d10.'</font></td>  
             <td align="center"><font size="1">'.$d11.'</font></td>  
             <td align="center"><font size="1">'.$d12.'</font></td> 
             <td align="center"><font size="1">'.$d1.'</font></td>  
             <td align="center"><font size="1">'.$colaion.'</font></td>  
             <td align="center"><font size="1">'.$cena.'</font></td>   
                  
            </tr>                     
	</table>
</div>
</html>	

';
}


// CREACIÓN DE PDF 
//$mpdf= new mPDF('c','A4','','arial');
$mpdf->writeHTML($html);
$mpdf->Output('Pedido de Dietas.pdf','I');

?>