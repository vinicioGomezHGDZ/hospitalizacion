<?php
require_once '../../../../vendor/autoload.php';
include_once("../../../../php/class_consulta.php");
use Mpdf\Mpdf;
$mpdf = new mPDF(['debug' => true,'mode'=>'utf-8','format'=>'A4']);;

$fi=$_GET['fi'];
$fa=$_GET['fa'];

$Consigvit=New Consulta();
$ConDIsigvit=New Consulta();
$ConMTsigvit=New Consulta();
$hce_id_pk=$_GET['h'];

// CONSULTAS DE REPORRTE
# CARGAR DATOS DE ENCABEZADO. array 0
$per=$Consigvit->Get_Consulta("sgh_mei_sivitdia ep
		join sga_adm_historiaclinica as h on ep.hce_id_fk=h.hce_id_pk
		join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
		join sga_adm_persona as  per on p.per_id_fk=per.per_id_pk
		JOIN sga_adm_sexo as se on se.sex_id_pk=per.sex_id_fk","per_nombres,(per_apellidopaterno ||' '|| per_apellidomaterno ) as apellido,
			date_part('year',age(per_fechanacimiento)) as Edad,per_numeroidentificacion,sex_codigo as per_sexo","","hce_id_fk",$hce_id_pk,2);
//print_r($per);

$sivitales=$ConMTsigvit->Get_Consulta("sgh_mei_sivitdia
			join sgu_usu_usuario us on usu_id_fk=usu_id_pk
			join sga_adm_profesional pr on us.pro_id_fk=pro_id_pk
			join sga_adm_persona per on pr.per_id_fk=per.per_id_pk where svd_fecha >='$fi' and svd_fecha <='$fa' and hce_id_fk='".$hce_id_pk."' order by svd_fecha desc","svd_fecha,svd_hora,svd_diante,svd_pulso,svd_tempe,svd_freres,svd_presis,svd_predia,svd_satoxi,svd_parent,svd_viaora,svd_toteli,svd_orina,svd_drenaj,svd_otros,svd_toting,
			 CASE WHEN svd_aseo=true then 'X' end aseo,
			 CASE WHEN svd_banio=true then 'X' end baño
			,svd_peso,svd_dieadm,svd_numcom,svd_numicc,svd_numdep,svd_actfis,
			CASE WHEN svd_camson=true then 'X' end sonda,svd_recvia,
			per_nombres || ' ' || per_apellidopaterno || ' ' || per_apellidomaterno as resposable","","","",5);

$sivitalesgeneral=$ConDIsigvit->Get_Consulta("sgh_mei_sivitdia
		join sgu_usu_usuario us on usu_id_fk=usu_id_pk
		join sga_adm_profesional pr on us.pro_id_fk=pro_id_pk
		join sga_adm_persona per on pr.per_id_fk=per.per_id_pk where svd_fecha >='$fi' and svd_fecha <='$fa' and svd_dieadm is not null AND hce_id_fk='".$hce_id_pk."' order by svd_fecha desc","svd_fecha,svd_hora,svd_diante,svd_pulso,svd_tempe,svd_freres,svd_presis,svd_predia,svd_satoxi,svd_parent,svd_viaora,svd_toteli,svd_orina,svd_drenaj,svd_otros,svd_toting,
		 CASE WHEN svd_aseo=true then 'X' end aseo,
		 CASE WHEN svd_banio=true then 'X' end baño
		,svd_peso,svd_dieadm,svd_numcom,svd_numicc,svd_numdep,svd_actfis,
		CASE WHEN svd_camson=true then 'X' end sonda,svd_recvia,
		per_nombres || ' ' || per_apellidopaterno || ' ' || per_apellidomaterno as resposable","","","",5);

//$mpdf->useOddEven = 1;
// HTML DE REPORTE
//$mpdf = new mPDF('utf-8', 'A4');
$htmlanamnesis='';
$htmladulto='';
$ConMT='';
$htmlkardex ='';
$ttardeaotro ='';
$ttardeaotro ='';
$htmlglicemia ='';
$htmlproblemas ='';
$htmldownes ='';

$htmlsignosvitales = '

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

			

			}

			@page chaptersiv {

			    odd-header-name: html_encabezado_siv;
			    odd-footer-name: html_piedepagina_siv;

			}

			div.chaptersiv {

			    page-break-before: right;

			    page: chaptersiv;

			}

	</style>

	</head>

	<body>

	<!-- diseño encabezado pie de pagina -->		
		
		<htmlpageheader name="encabezado_siv" style="display:none">
		<!-- datos paciente -->	
		<table width="100%" >
		    <tr>

		    <td width="33%"><span style="font-weight: bold; font-style: italic;">
		    
		    <IMG SRC="../../../../img/msp.jpg" WIDTH="110" HEIGHT="30">

		    </span></td>

		    <td width="33%" align="center" style="font-weight: bold; font-style: italic;"></td>

		    <td width="40%" style="text-align: right;"><h4>'.$Consigvit->entidad.'</h4></td>

		    </tr>
		</table>	
		<table border="1" width="100%" cellspacing="0" cellpadding="2" > 
		           <tr>
		              <td class="th" width="150"><center><font size=2>ESTABLECIMIENTO</font></td>
		              <td class="th" width="150"><center><font size=2>NOMBRE</font></center></td>
		              <td class="th" width="150"><center><font size=2>APELLIDO</font></center></td>
		              <td class="th" width="30"><center><font size=2>SEXO(M-F)</font></center></td>
		              <td class="th" width="30"><center><font size=2>EDAD </font></center></td>
		              <td class="th" width="150"><center><font size=2>N° HISTORIA CLÍNICA </font></center></td>
		              </tr>
		            </center>
		            <tr>
		              <td><center><font size=1>'.$Consigvit->entidad.'</font></center></td>
		              <td><center><font size=1>'.($per[0]["per_nombres"] ?? '') .'</font></center></td>
		              <td><center><font size=1>'.($per[0]["apellido"] ?? '') .'</font></center></td>
		              <td><center><font size=1>'.($per[0]["per_sexo"] ?? '') .'</font></center></td>
		              <td><center><font size=1>'.($per[0]["edad"] ?? '') .'</font></center></td>
		              <td><center><font size=1>'.($per[0]["per_numeroidentificacion"] ?? '') .'</font></center></td>   
		            </tr>  
		</table>
		</htmlpageheader>

		<htmlpagefooter name="piedepagina_siv" style="display:none">

			<table width="100%">
				    <tr>
				    <td width="33%"> <br><br><br><br><font size=1>SNS-MSP / HCU-form.020 / 2008 </font></td>

				    <td width="33%" align="center"></td>

				    <td width="33%" style="text-align: right;">
					<br><br><br><br><font size=3>
				   SIGNOS VITALES</font></td>

				    </tr>
		    </table>
		</htmlpagefooter>
	<!-- primera hoja  -->	
	
	<div class="chaptersiv">
		<table border=1 cellspacing="0" cellpadding="2" width="100%">
			<tr>
				<td class="th" colspan=9>
				1 SIGNOS VITALES
				</td>
			</tr>
			<tr>
				<th class="" width=30><font size=1>FECHA </font> </th>
				<th class="" width=30><font size=1>DÍA DE INTERNCACIÓN </font> </th>
				<th class="" width=30><font size=1>PULSO </font> </th>
				<th class="" width=30><font size=1>TEMPERATURA  </font></th>
				<th class="" width=30><font size=1>F, RESPIRATORIA X min </font> </th>
				<th class="" width=30><font size=1>PRESIÓN SITÓLICA   </font></th>
				<th class="" width=30><font size=1>PRESIÓN DIASTÓLICA  </font></th>
				<th class="" width=30><font size=1>SATURACIÓNDE O2  </font> </th>
				<th class="" width=20><font size=1>RESPONSABLE</font> </th>
			</tr>';
for ($i=0; $i <count($sivitales) ; $i++) {
    $htmlsignosvitales.='
				<tr>
				<td align="center"><font size=1>'.($sivitales[$i]["svd_fecha"] ?? '') .' <br> '.($sivitales[$i]["svd_hora"] ?? '') .'</font> </td>
				<td align="center"><font size=1>'.($sivitales[$i]["svd_diante"] ?? '') .'</font> </td>
				<td align="center"><font size=1>'.($sivitales[$i]["svd_pulso"] ?? '') .'</font> </td>
				<td align="center"><font size=1>'.($sivitales[$i]["svd_tempe"] ?? '') .'</font> </td>
				<td align="center"><font size=1>'.($sivitales[$i]["svd_freres"] ?? '') .'</font> </td>
				<td align="center"><font size=1>'.($sivitales[$i]["svd_presis"] ?? '') .'</font> </td>
				<td align="center"><font size=1>'.($sivitales[$i]["svd_predia"] ?? '') .'</font> </td>
				<td align="center"><font size=1>'.($sivitales[$i]["svd_satoxi"] ?? '') .'</font> </td>
				<td align="center"><font size=1>'.($sivitales[$i]["resposable"] ?? '') .'</font> </td>
				</tr>
				';
}
$htmlsignosvitales.='
		</table>
		<table><tr><td></td></tr></table>

		<table border=1 cellspacing="0" cellpadding="2" width="100%">
			<tr>
				<td class="th" colspan=2>
				2 BALANCE HÍDRICO 
				</td>
			</tr>

			<tr>
				<th class=""><font size=1>INGRESOS CC</font></th>
				<th class=""><font size=1>ELIMINCACIÓN CC  </font></th>
			</tr>
				<tr>
				<td class="">
					<table width="100%" border=1 cellspacing="0" cellpadding="2">
						<tr>
							<th  width=30>
								<font size=1>FECHA</font>
							</th>
							<th width=30>
								<font size=1>DÍA DE INTERNCACIÓN</font>
							</th>
							<th  width=30>
								<font size=1>PARENTAL</font>
							</th>
							<th  width=30>
								<font size=1>VÍA ORAL</font>
							</th>
							<th width=20>
								<font size=1>TATAL</font>
							</th>
							<th class="" width=20><font size=1>RESPONSABLE</font> </th>
						</tr>
						';
for ($i=0; $i <count($sivitalesgeneral) ; $i++) {
    $htmlsignosvitales.='
				<tr>
				<td align="center"><font size=1>'.($sivitalesgeneral[$i]["svd_fecha"] ?? '') .' <br> '.($sivitalesgeneral[$i]["svd_hora"] ?? '') .'</font> </td>
				<td align="center"><font size=1>'.($sivitalesgeneral[$i]["svd_diante"] ?? '') .'</font> </td>
				<td align="center"><font size=1>'.($sivitalesgeneral[$i]["svd_parent"] ?? '') .'</font> </td>
				<td align="center"><font size=1>'.($sivitalesgeneral[$i]["svd_viaora"] ?? '') .'</font> </td>
				<td align="center"><font size=1>'.($sivitalesgeneral[$i]["svd_toting"] ?? '') .'</font> </td>
				<td align="center"><font size=1>'.($sivitalesgeneral[$i]["resposable"] ?? '') .'</font> </td>
				</tr>
				';
}
$htmlsignosvitales.='
		
					</table>	
				</td>
				<td class="">
					<table width="100%" border=1 cellspacing="0" cellpadding="2">
						<tr>
							<th>
								<font size=1>FECHA</font>
							</th>
							<th width=30>
								<font size=1>DÍA DE INTERNCACIÓN</font>
							</th>
							<th>
								<font size=1>ORINA</font>
							</th>
							<th>
								<font size=1>DRENAJE</font>
							</th>
							<th>
								<font size=1>OTROS</font>
							</th>
							<th>
								<font size=1>TOTAL</font>
							</th>
							<th class="" width=20><font size=1>RESPONSABLE</font> </th>
						</tr>	
							';
for ($i=0; $i <count($sivitalesgeneral) ; $i++) {
    $htmlsignosvitales.='
							<tr>
							<td align="center"><font size=1>'.($sivitalesgeneral[$i]["svd_fecha"] ?? '') .' <br> '.($sivitalesgeneral[$i]["svd_hora"] ?? '') .'</font> </td>
							<td align="center"><font size=1>'.($sivitalesgeneral[$i]["svd_diante"] ?? '') .'</font> </td>
							<td align="center"><font size=1>'.($sivitalesgeneral[$i]["svd_orina"] ?? '') .'</font> </td>
							<td align="center"><font size=1>'.($sivitalesgeneral[$i]["svd_drenaj"] ?? '') .'</font> </td>
							<td align="center"><font size=1>'.($sivitalesgeneral[$i]["svd_otros"] ?? '') .'</font> </td>
							<td align="center"><font size=1>'.($sivitalesgeneral[$i]["svd_toteli"] ?? '') .'</font> </td>
							<td align="center"><font size=1>'.($sivitalesgeneral[$i]["resposable"] ?? '') .'</font> </td>
							</tr>
							';
}
$htmlsignosvitales.='
					</table>	

				</td>
			</tr>		
		</table>
		<table><tr><td></td></tr></table>

			<table border=1 cellspacing="0" cellpadding="2" width="100%">
			<tr>
				<td class="th" colspan=13>
				3 MEDICIONES Y ACTIVIDADES
				</td>
			</tr>
				<tr>
							<th>
								<font size=1>FECHA</font>
							</th>
							<th width=30>
								<font size=1>DÍA DE INTERNCACIÓN</font>
							</th>
							<th>
								<font size=1>ASEO</font>
							</th>
							<th>
								<font size=1>BAÑO</font>
							</th>
							<th>
								<font size=1>PESO kg</font>
							</th>
				
				
							<th>
								<font size=1>DIETA ADMINISTRADA</font>
							</th>
							<th>
								<font size=1>NUMERO DE COMIDAS</font>
							</th>
							<th>
								<font size=1>NUMERO MICCIONES </font>
							</th>
							<th>
								<font size=1>NUMERO DE DEPOSICIONES</font>
							</th>
							<th>
								<font size=1>ACTIVIDAD FÍSICA</font>
							</th>
							<th>
								<font size=1>CAMBIO DE SONDA</font>
							</th>
							<th>
								<font size=1>RECANALIZACIÓN VÍA</font>
							</th>
							<th>
								<font size=1>RESPONSABLE</font>
							</th>	
				</tr>
					';
for ($i=0; $i <count($sivitalesgeneral) ; $i++) {
    $htmlsignosvitales.='
							<tr>
							<td align="center"><font size=1>'.($sivitalesgeneral[$i]["svd_fecha"] ?? '') .' <br> '.($sivitalesgeneral[$i]["svd_hora"] ?? '') .'</font> </td>
							<td align="center"><font size=1>'.($sivitalesgeneral[$i]["svd_diante"] ?? '') .'</font> </td>
							<td align="center"><font size=1>'.($sivitalesgeneral[$i]["aseo"] ?? '') .'</font> </td>
							<td align="center"><font size=1>'.($sivitalesgeneral[$i]["baño"] ?? '') .'</font> </td>
							<td align="center"><font size=1>'.($sivitalesgeneral[$i]["svd_peso"] ?? '') .'</font> </td>
							<td align="center"><font size=1>'.($sivitalesgeneral[$i]["svd_dieadm"] ?? '') .'</font> </td>
							<td align="center"><font size=1>'.($sivitalesgeneral[$i]["svd_numcom"] ?? '') .'</font> </td>
							<td align="center"><font size=1>'.($sivitalesgeneral[$i]["svd_numicc"] ?? '') .'</font> </td>
							<td align="center"><font size=1>'.($sivitalesgeneral[$i]["svd_numdep"] ?? '') .'</font> </td>
							<td align="center"><font size=1>'.($sivitalesgeneral[$i]["svd_actfis"] ?? '') .'</font> </td>
							<td align="center"><font size=1>'.($sivitalesgeneral[$i]["svd_camson"] ?? '') .'</font> </td>
							<td align="center"><font size=1>'.($sivitalesgeneral[$i]["svd_recvia"] ?? '') .'</font> </td>
							<td align="center"><font size=1>'.($sivitalesgeneral[$i]["resposable"] ?? '') .'</font> </td>
							</tr>
							';
}
$htmlsignosvitales.='	
					
		</table>
    </div>
	</body>
	</html>	
';

// evolución //

$Conevo=New Consulta();
$ConMTevo=New Consulta();
$hce_id_pk=$_GET['h'];
// CONSULTAS DE REPORRTE
# CARGAR DATOS DE ENCABEZADO. array 0
$perevo=$Conevo->Get_Consulta("sgh_mei_evolucion ep
		join sga_adm_historiaclinica as h on ep.hce_id_fk=h.hce_id_pk
		join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
		join sga_adm_persona as  per on p.per_id_fk=per.per_id_pk
		JOIN sga_adm_sexo as se on se.sex_id_pk=per.sex_id_fk","per_nombres,(per_apellidopaterno ||' '|| per_apellidomaterno ) as apellido,
			date_part('year',age(per_fechanacimiento)) as Edad,per_numeroidentificacion,sex_codigo as per_sexo","","hce_id_fk",$hce_id_pk,2);
//print_r($perevo);

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

$htmlevolucion = '

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
			}

			@page chapterevo {

			    odd-header-name: html_encabezado;
			    odd-footer-name: html_piepagina;
			}

			
			div.chapterevo {

			    page-break-before: right;

			    page: chapterevo;

			}


	</style>

	</head>

	<body>

<!-- diseño encabezado pie de pagina -->		
	
	<htmlpageheader name="encabezado" style="display:none">
	<!-- datos paciente -->	
	<table width="100%" >
	    <tr>

	    <td width="33%"><span style="font-weight: bold; font-style: italic;">
	    
	    <IMG SRC="../../../../img/msp.jpg" WIDTH="110" HEIGHT="30">

	    </span></td>

	    <td width="33%" align="center" style="font-weight: bold; font-style: italic;"></td>

	    <td width="40%" style="text-align: right;"><h4>'.$Consigvit->entidad.'</h4></td>

	    </tr>
	</table>	
	<table border="1" width="100%" cellspacing="0" cellpadding="2" > 
	           <tr>
	              <td class="th" width="150"><center><font size=2>ESTABLECIMIENTO</font></td>
	              <td class="th" width="150"><center><font size=2>NOMBRE</font></center></td>
	              <td class="th" width="150"><center><font size=2>APELLIDO</font></center></td>
	              <td class="th" width="30"><center><font size=2>SEXO(M-F)</font></center></td>
	              <td class="th" width="30"><center><font size=2>EDAD </font></center></td>
	              <td class="th" width="150"><center><font size=2>N° HISTORIA CLÍNICA </font></center></td>
	              </tr>
	            </center>
	            <tr>
	              <td><center><font size=1>'.$Consigvit->entidad.'</font></center></td>
	              <td><center><font size=1>'.($perevo[0]["per_nombres"] ?? '') .'</font></center></td>
	              <td><center><font size=1>'.($perevo[0]["apellido"] ?? '') .'</font></center></td>
	              <td><center><font size=1>'.($perevo[0]["per_sexo"] ?? '') .'</font></center></td>
	              <td><center><font size=1>'.($perevo[0]["edad"] ?? '') .'</font></center></td>
	              <td><center><font size=1>'.($perevo[0]["per_numeroidentificacion"] ?? '') .'</font></center></td>   
	            </tr>  
	</table>
	</htmlpageheader>

	<htmlpagefooter name="piepagina" style="display:none">

		<table width="100%">
			    <tr>
			    <td width="33%"> <br><br><br><br><font size=1>SNS-MSP / HCU-form.005 / 2008 </font></td>

			    <td width="33%" align="center"></td>

			    <td width="33%" style="text-align: right;">
				<br><br><br><br><font size=3>
			    EVOLUCIÓN Y PRESCRIPCIONES</font></td>

			    </tr>
	    </table>
	</htmlpagefooter>
<!-- primera hoja  -->	
<div class="chapterevo">
	<table border=1 cellspacing="0" cellpadding="2" width="100%">
					<tr>
						<td colspan="3" class="th">
							<font size=3> <b>1 EVOLUCIÓN</b></font>	
						</td>
						<td class="th">
							<font size=3> <b>2 PRESCRIPCIONES</b></font>	
						</td>
					</tr>
				    <tr>
						<td class="th" width="10">
							<font size=1> <center>FECHA <br> (DIA/MES/AÑO)</center></font>	
						</td>
						<td class="th" width="10">
							<font size=1><center>HORA</center></font>	
						</td>
						<td class="th">
							<font size=1><center> NOTA DE EVOLUCIÓN</center></font>	
						</td>
						<td class="th">
							<font size=1> <center><b>FARMACOTERAPIA E INDICACIONES </b><br>
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
        if ($evo[$i]["sncy"] === null) {$msp='C.I  '.($evo[$i]["ci"] ?? '') .'';}
    }
    else{
        $msp=$evo[$i]["msp"];
    };
    $htmlevolucion.='
					<tr>

						<td class="" width="10" VALIGN="TOP">
							<font size=1><center> '.($evo[$i]["eyp_fechas"] ?? '') .'</center></font>
						</td>
						<td class="" width="10" VALIGN="TOP">
							<font size=1><center>'.substr($evo[$i]["eyp_hora"],0,8).'</center></font>
						</td>
						<td class="" width="500" VALIGN="TOP" style="text-align: justify">
							<font size=1><b >'.($evo[$i]["eyp_asunto"] ?? '') .'</b> <br><br>
						    '.($evo[$i]["eyp_nodevu"] ?? '') .'
							</font>
						</td>
						<td VALIGN="TOP"  width="360" style="text-align: justify">
							<font size=1>'.($evo[$i]["eyp_prescr"] ?? '') .'</font> <br><br>
							<font size=1>'.($evo[$i]["medico"] ?? '') .'  '.$msp.'</font><br><br>

							<font size=1>'.($evo[$i]["eyp_revisaresidente"] ?? '') .'</font>
						</td>
					</tr>';
}
$htmlevolucion.='
	</table>
</div>
</body>
</html>		
';

// anamnesis //

$Cona=New Consulta();
$hcl_id_fk=$_GET['h'];
// CONSULTAS DE REPORRTE
$anamesis=$Cona->Get_Consulta("sgh_mei_anamnesis where ana_fecha >='$fi' and ana_fecha <='$fa' and hce_id_fk= '".$hcl_id_fk."'ORDER BY ana_fecha DESC ","ana_id_pk,hce_id_fk","","","",5);

$htmlanamnesis.= '

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

			

			}

			@page chapterana {
			    odd-footer-name: html_h2_anamnesis;
			}

			@page noheaderana {
				
			   odd-footer-name: html_h1_anamnesis;
			}
			

			div.chapterana {

			    page-break-before: right;

			    page: chapterana;

			}

			div.noheaderana {

			    page-break-before: right;

			    page: noheaderana;

			}

	</style>

	</head>

	<body>

	
<!-- diseño encabezado pie de pagina -->		
	<htmlpagefooter name="h1_anamnesis" style="display:none">
			
		<table width="100%">

	    <tr>

	    <td width="33%"><font size=1>SNS-MSP / HCU-form.003 / 2008</font></td>

	    <td width="33%" align="center" style="font-weight: bold; font-style: italic;"></td>

	    <td width="33%" style="text-align: right; "><font size=3>ANAMNESIS</font></td>

	    </tr></table>

	</htmlpagefooter>

	<htmlpagefooter name="h2_anamnesis" style="display:none">

		<table width="100%">

	    <tr>

	    <td width="33%"><font size=1><b> SNS-MSP / HCU-form.003 / 2008</b></font></td>

	    <td width="33%" align="center" style="font-weight: bold; font-style: italic;"></td>

	    <td width="33%" style="text-align: right; "><font size=3><b>EXAMEN FÍSICO</b></font></td>

	    </tr></table>
	</htmlpagefooter>

	';

for ($r=0; $r <count($anamesis) ; $r++) {
    $Conana = 'Conana'.$r;
    $ConDIana='ConDIana'.$r;
    $ConDEana='ConDEana'.$r;
    $Consvana='Consvana'.$r;
    $Coniana='Coniana'.$r;
    $ana_id_pk=$anamesis[$r]["ana_id_pk"];
    $$Conana=New Consulta();
    $$ConDIana=New Consulta();
    $$ConDEana=New Consulta();
    $$Consvana=New Consulta();
    $$Coniana=New Consulta();


    # CARGAR DATOS DE ENCABEZADO. array 0
    $perana=$$Conana->Get_Consulta("sgh_mei_anamnesis ep
		join sga_adm_historiaclinica as h on ep.hce_id_fk=h.hce_id_pk
		join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
		join sga_adm_persona as  per on p.per_id_fk=per.per_id_pk
		JOIN sga_adm_sexo as se on se.sex_id_pk=per.sex_id_fk","per_nombres,(per_apellidopaterno ||' '|| per_apellidomaterno ) as apellido,
			date_part('year',age(per_fechanacimiento)) as Edad,per_numeroidentificacion,sex_codigo as per_sexo","","ana_id_pk",$ana_id_pk,2);
    # CARGAR datos generales anamnesis
    $ana=$$ConDEana->Get_Consulta("sgh_mei_anamnesis
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
    $itemsana=$$Coniana->Get_Consulta("sgh_mei_anapro JOIN sgh_mei_respuesta as res on pat_id_fk= res.pat_id_pk where ana_id_fk=".$ana_id_pk."ORDER BY pat_item","pat_id_pk,pat_item,  
     	CASE WHEN pat_result= 'f' THEN 'X' end as x,
    	CASE WHEN pat_result= 't' THEN 'O' end as o,
    	CASE WHEN pat_result= 'CP' THEN 'X' end as cp,
    	CASE WHEN pat_result= 'SP' THEN 'X' end as sp,
    	pat_result","","","",5);
    # CARGAR DIAGNOSTICO
    $diaana=$$ConDIana->Get_Consulta("sgh_mei_danamdiag join sgh_mei_diagnos as d on dia_id_fk=d.dia_id_pk
    JOIN sgh_mei_codigocie10 as c10  on d.c10_id_fk=c10.c10_id_pk where ana_id_fk='".$ana_id_pk."'","c10_nombre AS detalle,
			c10_codigo as cie,
			sgh_conbiertepre('1',dia_resp) as pre,
			sgh_conbiertepre('2',dia_resp) as def,dia_descrip",
        "","","",6);
    # CARGAR Signos vitales
    $sigvana=$$Consvana->Get_Consulta("sgh_mei_sivanam as  sva
	  jOIN sgh_mei_signosvi as sv on sva.siv_id= sv.siv_id_pk
	  JOIN sgh_mei_anamnesis as ana on sva.ana_id_fk= ana.ana_id_pk",
        "siv_id_pk,siv_frecar,siv_freres,siv_percef,siv_peso,siv_prarta,siv_talla,siv_temper,siv_tempvo","","ana_id_fk",$ana_id_pk,2);

    $htmlanamnesis .= '

<!-- datos paciente -->	
<div class="noheaderana">
<br>
<table border="1" width="100%" cellspacing="0" cellpadding="2"> 
	           <tr>
	              <th width="125" class="th"><center><font size=1>ESTABLECIMIENTO<font></th>
	              <th width="150" class="th"><center><font size=1>NOMBRE<font></center></th>
	              <th width="150" class="th"><center><font size=1>APELLIDO<font></center></th>
	              <th width="30" class="th"><center><font size=1>SEXO(M-F)<font></center><div>
	              <th width="50" class="th"><center><font size=1>N° HOJA <font></center></th>
	              <th width="125" class="th"><center><font size=1>N° HISTORIA CLÍNICA <font></center></th>
	              
	              </div>
	               
	               </th>           
	              </font>
	              </tr>
	            </center>
	            <tr>
	              <td><center><font size=1>'.$Consigvit->entidad.'</font></center></td>
	              <td><center><font size=1>' . ($perana[0]["per_nombres"] ?? '') .' </font></center></td>
	              <td><center><font size=1>' . ($perana[0]["apellido"] ?? '') .'</font></center></td>
	              <td><center><font size=1>' . ($perana[0]["per_sexo"] ?? '') .'</font></center></td>
	              <td><center><font size=1>1</font></center></td>
	              <td><center><font size=1>' . ($perana[0]["per_numeroidentificacion"] ?? '') .'</font></center></td>   
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
			<font size=1>Anotar la causa del problema en la versíon del informante</font> 
			</td>
		</tr>
		
		<tr>
			<td height="70" VALIGN="TOP" colspan=2>
			   <font size=1>' . ($ana[0]["ana_motivo"] ?? '') .'</font>
			</td>
		</tr>
	</table>
	<table><tr><td></td></tr></table>
	<table border="1" width="100%" cellspacing="0" cellpadding="2">
		<tr>
				<td  class="th" colspan=4><h5><b>2. ANTECEDENTES PERSONALES</b><h5></td>
				<td style="text-align: right;" class="th" colspan=12><font size=1>Describir abajo, con el Números respectivo FUM: Fecha ultima mensturacón FUP: Fecha ultimo parto FUC: Fecha ultima citología</font>
			</td>
		</tr>
					<tr>
						<td class="th"><font size=1>1.Vacunas</font></td>
						<td class="th"><font size=1>5.Enf. Alérgias</font></td>
						<td class="th"><font size=1>9.Enf. Neurológico</font></td>
						<td class="th"><font size=1>13.Enf. traumatol</font></td>
						<td class="th"><font size=1>17.Tendencia Sexual</font></td>
						<td class="th"><font size=1>21.Actividad física</font></td>
						<td class="th"><font size=1><center>Menarquia<br>-edad-</center></font></td>
						<td width=20><font size=1 ><center>' . ($ana[0]["ana_menarq"] ?? '') .'</center></font></td>
						<td class="th"><font size=1><center>Menopausia<br>-edad-</center></font></td>
						<td width=20><font size=1 ><center>' . ($ana[0]["ana_menopa"] ?? '') .'</center></font></td>
						<td class="th"><font size=1><center>Ciclos</center></font></td>
						<td width=20><font size=1 ><center>' . ($ana[0]["ana_ciclos"] ?? '') .'</center></font></td>
						<td class="th" colspan=2><font size=1><center>Vida sexual activa</center></font></td>
						<td width=20 colspan=2><font size=1 ><center>' . ($ana[0]["vidasex"] ?? '') .'</center></font></td>
					</tr>
					<tr>
						<td class="th"><font size=1>2.Enf. Perinatal</font></td>
						<td class="th"><font size=1>6.Enf. Cardiaca</font></td>
						<td class="th"><font size=1>10.Enf. Metabólica</font></td>
						<td class="th"><font size=1>14.Enf. Quirúrgica</font></td>
						<td class="th"><font size=1>18.Riesgo docisl</font></td>
						<td class="th"><font size=1>22.Dieta y hábitos</font></td>
						<td class="th"><font size=1><center>Gesta</center></font></td>
						<td><font size=1><center>  ' . ($ana[0]["ana_gesta"] ?? '') .' </center>   </font>   </td>
						<td class="th"><font size=1><center>Partos</center></font></td>
						<td><font size=1><center>  ' . ($ana[0]["ana_paros"] ?? '') .'  </center>    </font>   </td>
						<td class="th"><font size=1><center>Abortos</center></font></td>
						<td><font size=1><center>  ' . ($ana[0]["ana_aborto"] ?? '') .'  </center></font>   </td>
						<td class="th"><font size=1><center>Cesáreas</center></font></td>
						<td width=20><font size=1><center>  ' . ($ana[0]["ana_cesarea"] ?? '') .'  </center></font></td>
						<td class="th"><font size=1><center>Hijos vivos</center></font></td>
						<td width=20><font size=1><center> ' . ($ana[0]["ana_hijosv"] ?? '') .'  </center></font></td>
					</tr>	
					<tr>
						<td class="th"><font size=1>3.Enf. Infancia</font></td>
						<td class="th"><font size=1>7.Enf. Respiratoria</font></td>
						<td class="th"><font size=1>11.Enf. Hemo linf</font></td>
						<td class="th"><font size=1>15.Enf. Mental</font></td>
						<td class="th"><font size=1>19.Riesgo laboral</font></td>
						<td class="th"><font size=1>23.Religión y cultura</font></td>
						<td class="th"><font size=1><center>FUM</center></font></td>
						<td><font size=1><center> ' . ($ana[0]["ana_fum"] ?? '') .'  </center></font></td>
						<td class="th"><font size=1><center>FUP</center></font></td>
						<td><font size=1><center>  ' . ($ana[0]["ana_fup"] ?? '') .' </center></font></td>
						<td class="th"><font size=1><center>FUC</center></font></td>
						<td><font size=1><center>  ' . ($ana[0]["ana_fuc"] ?? '') .' </center></font></td>
						<td class="th" colspan=2><font size=1><center>Biopsia</center></font></td>
						<td colspan=2><font size=1><center> ' . ($ana[0]["biopsia"] ?? '') .'  </center></font></td>
					</tr>	
					<tr>
						<td class="th"><font size=1>4.Enf. Adolescente</font></td>
						<td class="th"><font size=1>8.Enf. Digestiva</font></td>
						<td class="th"><font size=1>12.Enf. urinario</font></td>
						<td class="th"><font size=1>16.Enf. T. Sexual</font></td>
						<td class="th"><font size=1>20.Riesgo Familiar</font></td>
						<td class="th"><font size=1>24.Otro</font></td>
						<td class="th"><font size=1><center>Método de P. Familiar</center></font></td>
						<td><font size=1><center>  ' . ($ana[0]["ana_mepfam"] ?? '') .'  </center></font></td>
						<td class="th"><font size=1><center>Terapia hormonal</center></font></td>
						<td><font size=1><center> ' . ($ana[0]["terhormonal"] ?? '') .'   </center></font></td>
						<td class="th"><font size=1><center>Colposcopia   </center></font></td>
						<td><font size=1><center> ' . ($ana[0]["colposcopia"] ?? '') .'   </center></font></td>
						<td class="th" colspan=2><font size=1><center>Mamografia</center></font></td>
						<td colspan=2><font size=1><center>  ' . ($ana[0]["mamografia"] ?? '') .'  </center></font></td>
					</tr>		
		<tr>
			<td height="140" VALIGN="TOP" colspan="16">
				<font size=1>' . ($ana[0]["ana_desant"] ?? '') .'</font>
			</td>
		</tr>
	</table>
		<table><tr><td></td></tr></table>
	<table border="1" width="100%" cellspacing="0" cellpadding="2">
		<tr>
	     <td width="40%" class="th"  colspan=6><h5>3. ANTECEDENTES FAMILIARES <h5></td>
	     	<td width="60%" style="text-align: right;" class="th" colspan=4>
					<font size=1><b>Describir abajo anotando el Números</font>
			</td>	
		</tr>
		<tr>
					<tr>
						<td class="th"><font size=1>1 Cardiopatía </font></td>
						<td class="th"><font size=1>2 Diabetes </font></td>
						<td class="th"><font size=1>3 Enf. C. vascular </font></td>
						<td class="th"><font size=1>4 Hipertensión </font></td>
						<td class="th"><font size=1>5 Cáncer </font></td>
						<td class="th"><font size=1>6 Tuberculosis</font></td>
						<td class="th"><font size=1>7 Enf. Mental</font></td>
						<td class="th"><font size=1>8 Enf infecciosa</font></td>
						<td class="th"><font size=1>9 Mal formación</font></td>
						<td class="th"><font size=1>10 Otros</font></td>
					</tr>
					<tr>
						<td height="80" VALIGN="TOP" colspan=20 >
							<font size=1>' . ($ana[0]["ana_antfam"] ?? '') .'</font>
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
							<font size="1">' . ($ana[0]["ana_enfpra"] ?? '') .'</font>
						</td>
		</tr>
	</table>
  <table><tr><td></td></tr></table>
	<table border="1" width="100%" cellspacing="0" cellpadding="2">
		<tr>
	     <td width="40%" colspan=6 class="th"><h5>5. ANTECEDENTES FAMILIARES Y SOCIALESS <h5></td>
	     	<td width="60%" style="text-align: right;" colspan=9 class="th">
					<font size=1><b>CP </b>: Con patología. Describir anotando el numero.<b>SP </b>: Sin patolía. No Describir</font>
			</td>	
		</tr>
		<tr>
					<tr>
						<td class="th"></td>
						<td><font size=1>CP</font></td>
						<td><font size=1>SP</font></td>
						<td class="th"></td>
						<td><font size=1>CP</font></td>
						<td><font size=1>SP</font></td>
						<td class="th"></td>
						<td><font size=1>CP</font></td>
						<td><font size=1>SP</font></td>
						<td class="th"></td>
						<td><font size=1>CP</font></td>
						<td><font size=1>SP</font></td>
						<td class="th"></td>
						<td><font size=1>CP</font></td>
						<td><font size=1>SP</font></td>
					</tr>
					<tr>
					    <td class="th"><font size=1>1.Organos de los sentidos</font></td>
						<th>
							<font size="1">' . ($itemsana[27]["cp"] ?? '') .'</font>
						</th>
						<th>
							<font size="1">' . ($itemsana[27]["sp"] ?? '') .'</font>
						</th>

						<td class="th"><font size=1>3. Cardio vascular</font></td>
						<th>
							<font size="1">' . ($itemsana[5]["cp"] ?? '') .'</font>
						</th>
						<th>
							<font size="1">' . ($itemsana[5]["sp"] ?? '') .'</font>
						</th>

						<td class="th"><font size=1>5. Genital</font></td>
						<th>
							<font size="1">' . ($itemsana[12]["cp"] ?? '') .'</font>
						</th>
						<th>
							<font size="1">' . ($itemsana[12]["sp"] ?? '') .'</font>
						</th>

						<td class="th"><font size=1>7. Músculo Esqueléticos</font></td>
						<th>
							<font size="1">' . ($itemsana[19]["cp"] ?? '') .'</font>
						</th>
						<th >
							<font size="1">' . ($itemsana[19]["sp"] ?? '') .'</font>
						</th>

						<td class="th"><font size=1>9. Hemo </font></td>
						<th >
							<font size="1">' . ($itemsana[15]["cp"] ?? '') .'</font>
						</th>
						<th>
							<font size="1">' . ($itemsana[15]["sp"] ?? '') .'</font>
						</th>
					</tr>
					<tr>
						<td class="th"><font size=1>2.Respiratorio</font></td>
						<th>
							<font size="1">' . ($itemsana[31]["cp"] ?? '') .'</font>
						</th>
						<th>
							<font size="1">' . ($itemsana[31]["sp"] ?? '') .'</font>
						</th>

						<td class="th"><font size=1>4. Digestivo</font></td>
						<th>
							<font size="1">' . ($itemsana[9]["cp"] ?? '') .'</font>
						</th>
						<th>
							<font size="1">' . ($itemsana[9]["sp"] ?? '') .'</font>
						</th>

						<td class="th"><font size=1>6. Urinario</font></td>
						<th>
							<font size="1">' . ($itemsana[34]["cp"] ?? '') .'</font>
						</th>
						<th>
							<font size="1">' . ($itemsana[34]["sp"] ?? '') .'</font>
						</th>

						<td class="th"><font size=1>8. Endocrino</font></td>
						<th>
							<font size="1">' . ($itemsana[11]["cp"] ?? '') .'</font>
						</th>
						<th>
							<font size="1">' . ($itemsana[11]["sp"] ?? '') .'</font>
						</th>
						<td class="th"><font size=1>10. Nervioso</font></td>
						<th>
							<font size="1">' . ($itemsana[22]["cp"] ?? '') .'</font>
						</th>
						<th>
							<font size="1">' . ($itemsana[22]["sp"] ?? '') .'</font>
						</th>
					</tr>
					<tr>
						<td height="100" VALIGN="TOP" colspan=15 >
							<font size=1>' . ($ana[0]["ana_desrev"] ?? '') .'</font>
						</td>
				   </tr>			
	</table>
	</div>
<!-- 2 hoja  -->	
	<div class="chapterana">
                    
	<table border="1" width="100%" cellspacing="0" cellpadding="2">
		<tr>
		 <td width="33%" colspan=16 class="th"><H5><b>6. SIGNOS VITALES, ANTROPOMETRÍA Y TAMIZAJE</b><H5></td>
			H5></td>
		</tr>
		<tr>
			<th class="th"><center><font size=1>Presión<br> arterial<font> </center></th> 
			 <td> <center><font size=1><font>' . ($sigvana[0]["siv_prarta"] ?? '') .' </center>
            <th class="th"> <center><font size=1>Frecuencia<br> cardiaca min<font></center></th>
             <td> <center><font size=1><font>' . ($sigvana[0]["siv_frecar"] ?? '') .' </center>
            <th class="th"><center><font size=1>Frecuencia<br> Respira min<font></center></th>
             <td> <center><font size=1><font>' . ($sigvana[0]["siv_freres"] ?? '') .' </center>
            <th class="th"><center><font size=1>Temperatura<br> BucalºC<font></center></th>
             <td> <center><font size=1><font>' . ($sigvana[0]["siv_tempvo"] ?? '') .' </center>
             <th class="th"><center><font size=1>Temperatura<br> Axilar ºC<font></center></th>
             <td> <center><font size=1><font>' . ($sigvana[0]["siv_temper"] ?? '') .' </center>
            <th class="th"><center><font size=1>Peso<br> Kg<font></center></th>
             <td> <center><font size=1><font>' . ($sigvana[0]["siv_peso"] ?? '') .' </center>
            <th class="th"><center><font size=1>Talla<br> m<font></center></th>
             <td> <center><font size=1><font>' . ($sigvana[0]["siv_talla"] ?? '') .' </center>
             <th class="th"><center><font size=1>Perímetro<br> cefálic cm<font></center></th>
             <td> <center><font size=1><font>' . ($sigvana[0]["siv_percef"] ?? '') .' </center> 
		</tr>
	</table>
	
	
	<table><tr><td></td></tr></table>
	
	<table  border="1" width="100%" cellspacing="0" cellpadding="2">
			<tr>
	    			<td class="th"  colspan=4><h5>7. EXAMEN FISICO</h5></td>
	    			<td class="th"  colspan=4><font size=1>R=REGIONAL S=SISTÉMICO</font></td>
	    			<td class="th" style="text-align: right;" colspan=7>
					<font size=1><b>CP </b>: Con patología. Describir anotando el numero. <b>SP</b: Sin patolía. No Describir</font>td>
	    	</tr>
	    			<tr>
	    			    <td class="th"></td> <td><font size=1>CP</font></td> <td><font size=1>SP</font></td>
                        <td class="th"></td> <td><font size=1>CP</font></td> <td><font size=1>SP</font></td>
                        <td class="th"></td> <td><font size=1>CP</font></td> <td><font size=1>SP</font></td>
                        <td class="th"></td> <td><font size=1>CP</font></td> <td><font size=1>SP</font></td>
                        <td class="th"></td> <td><font size=1>CP</font></td> <td><font size=1>SP</font></td>

                     </tr>  
                     <tr>
                       <td class="th"><font size=1> 1-R Pie- Faneras</font></td> 
                       <td><font size=1>' . ($itemsana[29]["cp"] ?? '') .' </font></td> <td><font size=1>' . ($itemsana[29]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size=1> 6-R Boca</font></td> 
                       <td><font size=1>' . ($itemsana[2]["cp"] ?? '') .' </font></td> <td><font size=1>' . ($itemsana[2]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size=1> 11-R Abdomen</font></td> 
                       <td><font size=1>' . ($itemsana[0]["cp"] ?? '') .' </font></td> <td><font size=1>' . ($itemsana[0]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size=1> 1-S Órganos de los sentidos</font></td> 
                       <td><font size=1>' . ($itemsana[26]["cp"] ?? '') .' </font></td> <td><font size=1>' . ($itemsana[26]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size=1> 6-S Urinario</font></td> 
                      <td><font size=1>' . ($itemsana[33]["cp"] ?? '') .' </font></td> <td><font size=1>' . ($itemsana[33]["sp"] ?? '') .'</font></td>		
                    	
                    </tr>
                    <tr>
                       <td class="th"><font size=1> 2-R Cabeza</font></td> 
                       <td><font size=1>' . ($itemsana[3]["cp"] ?? '') .' </font></td> <td><font size=1>' . ($itemsana[3]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size=1> 7-R Oro Faringe</font></td> 
                       <td><font size=1>' . ($itemsana[28]["cp"] ?? '') .' </font></td> <td><font size=1>' . ($itemsana[28]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size=1> 12-R Columna vertebral</font></td> 
                       <td><font size=1>' . ($itemsana[6]["cp"] ?? '') .' </font></td> <td><font size=1>' . ($itemsana[6]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size=1> 2-S Respiratorio</font></td> 
                       <td><font size=1>' . ($itemsana[30]["cp"] ?? '') .' </font></td> <td><font size=1>' . ($itemsana[30]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size=1> 7-S Músculo Esqueléticos</font></td> 
                      <td><font size=1>' . ($itemsana[20]["cp"] ?? '') .' </font></td> <td><font size=1>' . ($itemsana[20]["sp"] ?? '') .'</font></td>		
                    	
                    </tr>
                    <tr>
                       <td class="th"><font size=1> 3-R Ojos</font></td> 
                       <td><font size=1>' . ($itemsana[25]["cp"] ?? '') .' </font></td> <td><font size=1>' . ($itemsana[25]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size=1> 8-R Cuello</font></td> 
                       <td><font size=1>' . ($itemsana[7]["cp"] ?? '') .' </font></td> <td><font size=1>' . ($itemsana[7]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size=1> 13-R Ingle-periné</font></td> 
                       <td><font size=1>' . ($itemsana[16]["cp"] ?? '') .' </font></td> <td><font size=1>' . ($itemsana[16]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size=1> 3-S Cardio vascular</font></td> 
                       <td><font size=1>' . ($itemsana[4]["cp"] ?? '') .' </font></td> <td><font size=1>' . ($itemsana[4]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size=1> 8-S Endocrino</font></td> 
                      <td><font size=1>' . ($itemsana[10]["cp"] ?? '') .' </font></td> <td><font size=1>' . ($itemsana[10]["sp"] ?? '') .'</font></td>		
                    	
                    </tr>
                     <tr>
                       <td class="th"><font size=1> 4-R Oídos</font></td> 
                       <td><font size=1>' . ($itemsana[24]["cp"] ?? '') .' </font></td> <td><font size=1>' . ($itemsana[24]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size=1> 9-R Axilas-mamas</font></td> 
                       <td><font size=1>' . ($itemsana[1]["cp"] ?? '') .' </font></td> <td><font size=1>' . ($itemsana[1]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size=1> 14-R Miembros superiores</font></td> 
                       <td><font size=1>' . ($itemsana[18]["cp"] ?? '') .' </font></td> <td><font size=1>' . ($itemsana[18]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size=1> 4-S Digestivo</font></td> 
                       <td><font size=1>' . ($itemsana[8]["cp"] ?? '') .' </font></td> <td><font size=1>' . ($itemsana[8]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size=1> 9-S Hemo linfático</font></td> 
                      <td><font size=1>' . ($itemsana[14]["cp"] ?? '') .' </font></td> <td><font size=1>' . ($itemsana[14]["sp"] ?? '') .'</font></td>		
                    	
                    </tr>
                     <tr>
                       <td class="th"><font size=1> 5-R Nariz</font></td> 
                       <td><font size=1>' . ($itemsana[21]["cp"] ?? '') .' </font></td> <td><font size=1>' . ($itemsana[21]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size=1> 10-R Tórax</font></td> 
                       <td><font size=1>' . ($itemsana[32]["cp"] ?? '') .' </font></td> <td><font size=1>' . ($itemsana[32]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size=1> 15-R Miembros inferiores</font></td> 
                       <td><font size=1>' . ($itemsana[17]["cp"] ?? '') .' </font></td> <td><font size=1>' . ($itemsana[17]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size=1> 5-S Genital</font></td> 
                       <td><font size=1>' . ($itemsana[13]["cp"] ?? '') .' </font></td> <td><font size=1>' . ($itemsana[13]["sp"] ?? '') .'</font></td>
                       <td class="th"><font size=1> 10-S Neurològico</font></td> 
                      <td><font size=1>' . ($itemsana[23]["cp"] ?? '') .' </font></td> <td><font size=1>' . ($itemsana[23]["sp"] ?? '') .'</font></td>		
                    	
                    </tr>
        <tr>
						<td height="400" VALIGN="TOP" colspan=15>
							<font size=1>' . ($ana[0]["ana_exafis"] ?? '') .'</font>
		</td>
							
					</tr>
	</table>
		<table><tr><td></td></tr></table>

			<table border="1" width="100%" cellspacing="0" cellpadding="2">
		    		<tr>
		    			<td width="560" class="th" colspan="2"> <h5><b>8. DIAGNÓSTICO </b></h5></td>
		    			<th whdth="10"  class="th"> <font size=1>PRE</font></th>  
		    			<th whdth="10"  class="th"> <font size=1>DEF</font></th>
		    			<th whdth="20"  class="th"> <font size=1>CIE</font></th>  
		    			  
		    		</tr>';

    for ($i = 0; $i < 6; $i++) {
        $ita=$i+1;
        $htmlanamnesis .= '<tr>
		    		   		<td widt="1"><font size=1>' . $ita . '</font></td>
		    		   		<td widt="500"><font size=1>' . ($diaana[$i]["detalle"] ?? '') .'</font></td>
		    		   		<td widt="10"><font size=1><center>' . ($diaana[$i]["pre"] ?? '') .'</center></font></td>
		    		   		<td widt="10"><font size=1><center>' . ($diaana[$i]["def"] ?? '') .'</center></font></td>
		    		   		<td widt="20"><font size=1><center>' . ($diaana[$i]["cie"] ?? '') .'</center></font></td>
		    				</tr>';
    }
    $htmlanamnesis .= '
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
				<font size=1>' . ($ana[0]["ana_plantr"] ?? '') .'</font>
			</td>
				
		</tr>
	</table>
<table><tr><td></td></tr></table>
	<table border="1" cellspacing="0" width="100%"> 
		<tr>
			<th width="20" class="th"><font size=2>Fecha</font></th>
			<td width="10"><center><font size=1>' . ($ana[0]["ana_fecha"] ?? '') .'</font></center></td>
			<th width="30" class="th"><font size=2>Hora</font></th>
			<td width="10"><font size=1><center>' . substr($ana[0]["ana_hora"], 0, -7) . '</center></font></td>
			<th width="95" class="th"><font size=2>Nombre del profesional</font></th>
			<td width="150"><center><font size=1>' . ($ana[0]["profecional"] ?? '') .'</font></center></td> <td width="50"><center><font size=1>' . ($ana[0]["pro_codigomsp"] ?? '') .'</font></center></td>
			<th width="30" class="th"><font size=2>Firma</font></th>  <td width="150"></td>
			<th width="5" class="th"><font size=2>Número de hoja </font></th><td width="20"><center><font size=1>2</font></center></td>
			
		<tr>
	</table>
	</div>

	</body>
	</html>
	';
}

// ADULTO MAYOR //


$Conaam=New Consulta();
$hce_id_fk=$_GET['h'];
# CARGAR DATOS DE ENCABEZADO. array 0
$aam=$Conaam->Get_Consulta("sgh_mei_adulto where aam_fecha >='$fi' and aam_fecha <='$fa' and hce_id_fk='".$hce_id_fk."' ORDER BY aam_fecha DESC","hce_id_fk,aam_id_pk,aam_fecha","","","",5);
//$mpdf->useOddEven = 1;
// HTML DE REPORTE

$htmladulto.= '

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
			}

			@page chapteraam {

			    odd-header-name: html_h1_encabesado_aam;
			    odd-footer-name: html_h1_piedepagina_aam;

			}

			div.chapteraam {

			    page-break-before: right;

			    page: chapteraam;

			}
	</style>

	</head>

	<body>
<!-- diseño encabezado pie de pagina -->		

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

	<htmlpageheader name="h1_encabesado_aam" style="display:none">
	</htmlpageheader>

	<htmlpagefooter name="h1_piedepagina_aam" style="display:none">

		<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt;

	    color: #000000; font-weight: bold; font-style: italic;">

	    <tr>

	    <td width="33%"><span style="font-weight: bold; font-style: italic;">SNS-MSP / HCU-form.057 / 2010</span></td>

	    <td width="33%" align="center" style="font-weight: bold; font-style: italic;"></td>

	    <td width="33%" style="text-align: right; ">ATENCIÓN AL ADULTO MAYOR</td>

	    </tr></table>
	</htmlpagefooter>

';
for ($r=0; $r <count($aam) ; $r++) {
    $epi_id_pk=$aam[$r]["aam_id_pk"];
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
		JOIN sga_adm_sexo as se on se.sex_id_pk=per.sex_id_fk","per_nombres,(per_apellidopaterno ||' '|| per_apellidomaterno ) as apellido,
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
		JOIN sgh_mei_codigocie10 as c10  on d.c10_id_fk=c10.c10_id_pk where aam_id_fk='".$epi_id_pk."'","c10_nombre AS detalle,
			c10_codigo as cie,
			sgh_conbiertepre('1',dia_resp) as pre,
			sgh_conbiertepre('2',dia_resp) as def,dia_descrip",
        "","","",6);
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

    $htmladulto.='
<div class="chapteraam"><br>
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
	              <td><center><font size=1>'.$Consigvit->entidad.'</font></center></td>
	              <td><center><font size=1>'.($per[0]["apellido"] ?? '') .' ' .($per[0]["per_nombres"] ?? '') .'</font></center></td>
	              <td><center><font size=1>'.($per[0]["per_sexo"] ?? '') .'</font></center></td>
	              <td><center><font size=1>'.($per[0]["edad"] ?? '') .'</font></center></td>
	              <td><center><font size=1>'.($per[0]["per_numeroidentificacion"] ?? '') .'</font></center></td>   
	            </tr>  
	</table>
<!-- primera hoja  -->	
	<table border="1" width="100%" cellspacing="0" cellpadding="2">
		<tr>
		<td width="50%"><h5><b>1. MOTIVO DE CONSULTA</b><h5></td>
		<td ><font size=1><center>INFORMANTE<center></font></td>
		<td ><font size=1><center>'.($adul[0]["aam_inform"] ?? '') .'<center></font></td>
		<td ><font size=1><center>USUARIO<center></font></td>
		<td ><font size=1><center>'.($adul[0]["us"] ?? '') .'<center></font> </td>
		<td ><font size=1><center>CUIDADOR<center></font></td>
		<td ><font size=1><center>'.($adul[0]["cu"] ?? '') .'<center></font> </td>
		</tr>
		<tr>
			<td height="50" VALIGN="TOP" colspan=7>
			    <font size=1>'.($adul[0]["aam_motivo"] ?? '') .'</font>
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
				<font size=1>'.($adul[0]["aam_enferm"] ?? '') .'</font>
			</td>
		</tr>
		<tr>
			<td width="15%"><font size=1>MEDICAMENTOS QUE RECIBE</font></td>
			<td width="80"  colspan="2"><font size=1>'.($adul[0]["aam_meqrec"] ?? '') .' </font></td>
		</tr>
		<tr>
			<td width="15%"><font size=1>ESTADO GENERAL</font></td>
			<td width="80" colspan="2">
			<table>
				<tr>
					<td>
						<font size=1>Dependiente</font>
					</td>
					<th><font size=2>'.($adul[0]["dependiente"] ?? '') .' </font></th>
					<td>
						<font size=1>Fragil</font>
					</td>
					<th><font size=2>'.($adul[0]["fragil"] ?? '') .' </font></th>
					<td>
						<font size=1>Independiente</font>
					</td>
						<th><font size=2>'.($adul[0]["independiente"] ?? '') .' </font></th>
				
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
						<td><font size=1>'.($items[104]["cp"] ?? '') .'</font></td>
						<td><font size=1>'.($items[104]["sp"] ?? '') .'</font></td>

						<td><font size=1>2.Audisión</font></td>
						<td><font size=1>'.($items[15]["cp"] ?? '') .'</font></td>
						<td><font size=1>'.($items[15]["sp"] ?? '') .'</font></td>

						<td><font size=1>3.Ofato y gusto</font></td>
						<td><font size=1>'.($items[73]["cp"] ?? '') .'</font></td>
						<td><font size=1>'.($items[73]["sp"] ?? '') .'</font></td>

						<td><font size=1>4.Respiratorio</font></td>
						<td><font size=1>'.($items[93]["cp"] ?? '') .'</font></td>
						<td><font size=1>'.($items[93]["sp"] ?? '') .'</font></td>

						<td><font size=1>5.Cardio vascular</font></td>
						<td><font size=1>'.($items[91]["cp"] ?? '') .'</font></td>
						<td><font size=1>'.($items[91]["sp"] ?? '') .'</font></td>

						<td><font size=1>6.Digestivo</font></td>
						<td><font size=1>'.($items[92]["cp"] ?? '') .'</font></td>
						<td><font size=1>'.($items[92]["sp"] ?? '') .'</font></td>
					</tr>
					<tr>
						<td><font size=1>8.Genito urinario</font></td>
						<td><font size=1>'.($items[51]["cp"] ?? '') .'</font></td>
						<td><font size=1>'.($items[51]["sp"] ?? '') .'</font></td>

						<td><font size=1>9. Musculo esquelético</font></td>
						<td><font size=1>'.($items[90]["cp"] ?? '') .'</font></td>
						<td><font size=1>'.($items[90]["sp"] ?? '') .'</font></td>

						<td><font size=1>10.Endocrino</font></td>
						<td><font size=1>'.($items[48]["cp"] ?? '') .'</font></td>
						<td><font size=1>'.($items[48]["sp"] ?? '') .'</font></td>

						<td><font size=1>11.Hemo linfático</font></td>
						<td><font size=1>'.($items[53]["cp"] ?? '') .'</font></td>
						<td><font size=1>'.($items[53]["sp"] ?? '') .'</font></td>

						<td><font size=1>12.Nervioso</font></td>
						<td><font size=1>'.($items[68]["cp"] ?? '') .'</font></td>
						<td><font size=1>'.($items[68]["sp"] ?? '') .'</font></td>
						<td><font size=1></font></td>
						<td><font size=1></font></td>
						<td><font size=1></font></td>
					
					</tr>
					<tr>
						<td height="70" VALIGN="TOP" colspan=18 >
							<font size=1>'.($adul[0]["aam_reacsi"] ?? '') .'</font>
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
						<font size="1">'.($items[19]["o"] ?? '') .'</font>	
					</th>
					<td>
						<font size="1"> 2.-Dismovilidad</font>	
					</td>
					<th>
						<font size="1">'.($items[41]["o"] ?? '') .'</font>	
					</th>					
					<td>
						<font size="1"> 3..-Pérdida de peso</font>	
					</td>
					<th>
						<font size="1">'.($items[83]["o"] ?? '') .'</font>	
					</th>
					<td>
						<font size="1"> 4.-Astenia</font>	
					</td>
					<th>
						<font size="1">'.($items[14]["o"] ?? '') .'</font>	
					</th>
					<td>
						<font size="1"> 5.-Desorientación</font>	
					</td>
					<th>
						<font size="1">'.($items[34]["o"] ?? '') .'</font>	
					</th>
					<td>
						<font size="1"> 6.-Alteración del comportamiento</b></font>	
					</td>
					<th>
						<font size="1">'.($items[7]["o"] ?? '') .'</font>	
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
						<font size="1">'.($items[59]["cp"] ?? '') .'</font>	
					</th>
					<th>
						<font size="1">'.($items[59]["sp"] ?? '') .'</font>	
					</th>

					<td>
						<font size="1"> 2.-Higiene general</font>	
					</td>
					<th>
						<font size="1">'.($items[55]["cp"] ?? '') .'</font>	
					</th>
					<th>
						<font size="1">'.($items[55]["sp"] ?? '') .'</font>	
					</th>

					<td>
						<font size="1"> 3..-Higiene oral de peso</font>	
					</td>
					<th>
						<font size="1">'.($items[56]["cp"] ?? '') .'</font>	
					</th>
					<th>
						<font size="1">'.($items[56]["sp"] ?? '') .'</font>	
					</th>


					<td>
						<font size="1"> 4.-Ejercicio</font>	
					</td>
					<th>
						<font size="1">'.($items[44]["cp"] ?? '') .'</font>	
					</th>
					<th>
						<font size="1">'.($items[44]["sp"] ?? '') .'</font>	
					</th>

					<td>
						<font size="1"> 5.-Alimentación</font>	
					</td>
					<th>
						<font size="1">'.($items[6]["cp"] ?? '') .'</font>	
					</th>
					<th>
						<font size="1">'.($items[6]["sp"] ?? '') .'</font>	
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
						<font size="1">'.($items[1]["cp"] ?? '') .'</font>	
					</th>
					<th>
						<font size="1">'.($items[1]["sp"] ?? '') .'</font>	
					</th>
					<td>
						<font size="1"> 7.-Controles de salud</b></font>	
					</td>
					<th>
						<font size="1">'.($items[26]["cp"] ?? '') .'</font>	
					</th>
					<th>
						<font size="1">'.($items[26]["sp"] ?? '') .'</font>	
					</th>
					<td>
						<font size="1"> 8.-Alergias</b></font>	
					</td>
					<th>
						<font size="1">'.($items[5]["cp"] ?? '') .'</font>	
					</th>
					<th>
						<font size="1">'.($items[5]["sp"] ?? '') .'</font>	
					</th>
					<td>
						<font size="1"> 9.-otros</b></font>	
					</td>
					<th>
						<font size="1">'.($items[79]["cp"] ?? '') .'</font>	
					</th>
					<th>
						<font size="1">'.($items[79]["sp"] ?? '') .'</font>	
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
						<font size="1">'.($items[97]["o"] ?? '') .'</font>	
					</th>
					<td>
						<font size="1"> 2.-Alcholismo</font>	
					</td>
					<th>
						<font size="1">'.($items[4]["o"] ?? '') .'</font>	
					</th>
					<td>
						<font size="1"> 3.-Adicciones</font>	
					</td>
					<th>
						<font size="1">'.($items[2]["o"] ?? '') .'</font>	
					</th>
					<td>
						<font size="1"> 4.-Otro habito</font>	
					</td>
					<th>
						<font size="1">'.($items[78]["o"] ?? '') .'</font>	
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
						<font size="1">'.($items[33]["o"] ?? '') .'</font>	
					</th>
					<td>
						<font size="1"> 2.-Visuales</font>	
					</td>
					<th>
						<font size="1">'.($items[105]["o"] ?? '') .'</font>	
					</th>
					<td>
						<font size="1"> 3.-Otorrino</font>	
					</td>
					<th>
						<font size="1">'.($items[76]["o"] ?? '') .'</font>	
					</th>
					<td>
						<font size="1"> 4.-Estomatologicos</font>	
					</td>
					<th>
						<font size="1">'.($items[49]["o"] ?? '') .'</font>	
					</th>
					<td>
						<font size="1"> 5.-Endocrinos</font>	
					</td>
					<th>
						<font size="1">'.($items[46]["o"] ?? '') .'</font>	
					</th>
					<td>
						<font size="1"> 6.-Cardio vascular</font>	
					</td>
					<th>
						<font size="1">'.($items[20]["o"] ?? '') .'</font>	
					</th>
					<td>
						<font size="1"> 7.-Respiratorio</font>	
					</td>
					<th>
						<font size="1">'.($items[95]["o"] ?? '') .'</font>	
					</th>
					<td>
						<font size="1"> 8.-Digestivos</font>	
					</td>
					<th>
						<font size="1">'.($items[39]["o"] ?? '') .'</font>	
					</th>
				</tr>
			</table>
			<table>
				<tr>
					<td>
						<font size="1"> 9.-Neurológico</font>	
					</td>
					<th>
						<font size="1">'.($items[69]["o"] ?? '') .'</font>	
					</th>
					<td>
						<font size="1"> 10.-Urologicos</font>	
					</td>
					<thh>
						<font size="1">'.($items[102]["o"] ?? '') .'</font>	
					</thh>
					<td>
						<font size="1"> 11.-Hemolinfaticos</font>	
					</td>
					<th>
						<font size="1">'.($items[54]["o"] ?? '') .'</font>	
					</thh>
					<td>
						<font size="1"> 12.-Infecciosos</font>	
					</td>
					<th>
						<font size="1">'.($items[58]["o"] ?? '') .'</font>	
					</th>
					<td>
						<font size="1"> 13.-Oncológicos</font>	
					</td>
					<th>
						<font size="1">'.($items[74]["o"] ?? '') .'</font>	
					</th>
					<td>
						<font size="1"> 14.-Musculo esqueléticos</font>	
					</td>
					<th>
						<font size="1">'.($items[64]["o"] ?? '') .'</font>	
					</th>
					<td>
						<font size="1"> 15.-Psiquiátrico</font>	
					</td>
					<th>
						<font size="1">'.($items[89]["o"] ?? '') .'</font>
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
						<font size="1">'.($items[61]["pat_result"] ?? '') .'</font>	
					</td>
					<td>
						<font size="1"> 2.-Edad de ultima mamografia</font>	
					</td>
					<td>
						<font size="1">'.($items[60]["pat_result"] ?? '') .'</font>	
					</td>
					<td>
						<font size="1"> 3.-Edad de ultima citología</font>	
					</td>
					<td>
						<font size="1">'.($items[24]["pat_result"] ?? '') .'</font>	
					</td>	
					<td>
						<font size="1"> 4.-Embarazos</font>	
					</td>
					<td>
						<font size="1">'.($items[45]["pat_result"] ?? '') .'</font>	
					</td>	
					<td>
						<font size="1"> 5.-Partos</font>	
					</td>
					<td>
						<font size="1">'.($items[82]["pat_result"] ?? '') .'</font>	
					</td>
					<td>
						<font size="1"> 6.-Cesáreas</font>	
					</td>
					<td>
						<font size="1">'.($items[23]["pat_result"] ?? '') .'</font>	
					</td>
					<td>
						<font size="1"> 7.-Terapia hormonal</font>	
					</td>
					<td>
						<font size="1">'.($items[98]["pat_result"] ?? '') .'</font>	
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
						<font size="1">'.($items[87]["pat_result"] ?? '') .'</font>	
					</td>
					<td>
						<font size="1"> 2.-Terapia hormonal</font>	
					</td>
					<td width=30>
						<font size="1">'.($items[99]["pat_result"] ?? '') .'</font>	
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
						<font size="1">'.($items[3]["o"] ?? '') .'</font>	
					</td>
					<td>
						<font size="1"> 2.-Analgésicos</font>	
					</td>
					<td>
						<font size="1">'.($items[9]["o"] ?? '') .'</font>	
					</td>
					<td>
						<font size="1"> 3.-Anti diabéticos</font>	
					</td>
					<td>
						<font size="1">'.($items[12]["o"] ?? '') .'</font>	
					</td>
					<td>
						<font size="1"> 4.-Anti hipertensivos</font>	
					</td>
					<td>
						<font size="1">'.($items[13]["o"] ?? '') .'</font>	
					</td>
					<td>
						<font size="1"> 5.-Anti cuagulantes</font>	
					</td>
					<td>
						<font size="1">'.($items[11]["o"] ?? '') .'</font>	
					</td>
					<td>
						<font size="1"> 6.-Psico fármacos</font>	
					</td>
					<td>
						<font size="1">'.($items[88]["o"] ?? '') .'</font>	
					</td>
					<td>
						<font size="1"> 7.-Antibióticos</font>	
					</td>
					<td>
						<font size="1">'.($items[10]["o"] ?? '') .'</font>	
					</td>
					<td>
						<font size="1"> 8.-Otros</font>	
					</td>
					<td>
						<font size="1">'.($items[77]["o"] ?? '') .'</font>	
					</td>
				</tr>
			</table>
			<table>
				<tr>
					<td>
						<font size="1"> 9.-Números de prescriptores</font>	
					</td>
					<td>
						<font size="1">'.($items[86]["pat_result"] ?? '') .'</font>	
				</tr>
				
			</table>
			<table border=1 width=100% cellspacing="0" cellpadding="2">		
					<tr>
						<td height="80" VALIGN="TOP" colspan=18 >
							<font size="1">'.($adul[0]["aam_antepe"] ?? '') .'</font>
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
							<font size="1">'.($items[21]["cp"] ?? '') .'</font>
						</th>
						<th>
							<font size="1">'.($items[21]["sp"] ?? '') .'</font>
						</th>

						<td><font size=1>2.Diabetes</font></td>
						<th>
							<font size="1">'.($items[36]["cp"] ?? '') .'</font>
						</th>
						<th>
							<font size="1">'.($items[36]["sp"] ?? '') .'</font>
						</th>

						<td><font size=1>3.Hipertención artesanal</font></td>
						<th>
							<font size="1">'.($items[57]["cp"] ?? '') .'</font>
						</th>
						<th>
							<font size="1">'.($items[57]["sp"] ?? '') .'</font>
						</th>

						<td><font size=1>4.Neoplasia</font></td>
						<th>
							<font size="1">'.($items[67]["cp"] ?? '') .'</font>
						</th>
						<th>
							<font size="1">'.($items[67]["sp"] ?? '') .'</font>
						</th>

						<td><font size=1>5.Alzheimer</font></td>
						<th>
							<font size="1">'.($items[8]["cp"] ?? '') .'</font>
						</th>
						<th>
							<font size="1">'.($items[8]["sp"] ?? '') .'</font>
						</th>

						<td><font size=1>6.Parkinson</font></td>
						<th>
							<font size="1">'.($items[81]["cp"] ?? '') .'</font>
						</th>
						<th>
							<font size="1">'.($items[81]["sp"] ?? '') .'</font>
						</th>
					</tr>
					<tr>
						<td><font size=1>7.Tuberculosis</font></td>
						<th>
							<font size="1">'.($items[101]["cp"] ?? '') .'</font>
						</th>
						<th>
							<font size="1">'.($items[101]["sp"] ?? '') .'</font>
						</th>

						<td><font size=1>8. Violencia intrafamiliar</font></td>
						<th>
							<font size="1">'.($items[103]["cp"] ?? '') .'</font>
						</th>
						<th>
							<font size="1">'.($items[103]["sp"] ?? '') .'</font>
						</th>

						<td><font size=1>9.Sindrome del cuidador</font></td>
						<th>
							<font size="1">'.($items[96]["cp"] ?? '') .'</font>
						</th>
						<th>
							<font size="1">'.($items[96]["sp"] ?? '') .'</font>
						</th>

						<td><font size=1>10.Otros</font></td>
						<th>
							<font size="1">'.($items[80]["cp"] ?? '') .'</font>
						</th>
						<th>
							<font size="1">'.($items[80]["sp"] ?? '') .'</font>
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
							<font size=1>'.($adul[0]["aam_antfam"] ?? '') .'</font>
						</td>
				   </tr>			
	</table>
	</div>
<!-- 2 hoja  -->	
<div class="chapteraam">

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
					   <td> <center><font size=1><font>'.($sigv[0]["siv_prarta"] ?? '') .' </center>
					    </td> 
					  
                         <td> <center><font size=1>'.($sigv[0]["siv_prarte"] ?? '') .'<font></center>
                         </td>

                         <td><center><font size=1>'.($sigv[0]["siv_temper"] ?? '') .'<font></center>
                         </td>
                         <td><center><font size=1>'.($sigv[0]["siv_pulso"] ?? '') .'<font></center>
                         </td>
                         <td><center><font size=1>'.($sigv[0]["siv_freres"] ?? '') .'<font></center>
                         </td>
                         <td><center><font size=1>'.($sigv[0]["siv_peso"] ?? '') .'<font></center>
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
							<font size=1><center>'.($sigv[0]["difi_visual"] ?? '') .'</center></font>
						</td>
						<td>
							<font size=1><center>2 Dificultad Auditiva</center></font>
						</td>
							<td>
							<font size=1><center>'.($sigv[0]["difi_audi"] ?? '') .'</center></font>
						</td>
						<td>
							<font size=1><center>3 
							"Lebantate y anda " Mayor a 15a</center></font>
						</td>
							<td>
							<font size=1><center>'.($sigv[0]["levanta_anda"] ?? '') .'</center></font>
						</td>
						<td>
							<font size=1><center>4 Pérdida invt. de orina</center></font>
						</td>
							<td>
							<font size=1><center>'.($sigv[0]["perdida_orina"] ?? '') .'</center></font>
						</td>
						<td>
							<font size=1><center>5 Pérdida de memoria reciente</center></font>
						</td>
							<td>
							<font size=1><center>'.($sigv[0]["perdida_memoria"] ?? '') .'</center></font>
						</td>
							<td>
							<font size=1><center>6 Pierde peso mas de 4.5 kg. en 6 meses</center></font>
						</td>
							<td>
							<font size=1><center>'.($sigv[0]["perdida_peso"] ?? '') .'</center></font>
						</td>
					</tr>
				</table>
				<table >	
					<tr>
						<td>
							<font size=1>7 Se siente triste o deprimido</font>
						</td>
												<td>
							<font size=1><center>'.($sigv[0]["triste"] ?? '') .'</center></font>
						</td>
						<td>
							<font size=1><center>8 Puede Bañarse solo</center></font>
						</td>
						<td>
							<font size=1><center>'.($sigv[0]["baña_solo"] ?? '') .'</center></font>
						</td>
						<td>
							<font size=1><center>9 Sale de compras solo </center></font>
						</td>
							<td>
							<font size=1><center>'.($sigv[0]["sale_compras"] ?? '') .'</center></font>
						</td>
							<td>
							<font size=1><center>10 Vive solo</center></font>
						</td>
							<td>
							<font size=1><center>'.($sigv[0]["vive_solo"] ?? '') .'</center></font>
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
                       <td><font size=1>'.($items[85]["cp"] ?? '') .' </font></td> <td><font size=1>'.($items[85]["sp"] ?? '') .'</font></td>
                       <td><font size=1> 2 Cabeza</font></td> 
                       <td><font size=1>'.($items[18]["cp"] ?? '') .' </font></td> <td><font size=1>'.($items[18]["sp"] ?? '') .'</font></td>
                       <td><font size=1> 3 Ojos</font></td> 
                       <td><font size=1>'.($items[72]["cp"] ?? '') .' </font></td> <td><font size=1>'.($items[72]["sp"] ?? '') .'</font></td>
                       <td><font size=1> 4 Oídos</font></td> 
                       <td><font size=1>'.($items[71]["cp"] ?? '') .' </font></td> <td><font size=1>'.($items[71]["sp"] ?? '') .'</font></td>
                       <td><font size=1> 5 Boca</font></td> 
                      <td><font size=1>'.($items[17]["cp"] ?? '') .' </font></td> <td><font size=1>'.($items[17]["sp"] ?? '') .'</font></td>		
                       
                       <td><font size=1> 1 Org. de los sentidos </font></td> 
                       <td><font size=1>'.($items[75]["cp"] ?? '') .' </font></td> <td><font size=1>'.($items[75]["sp"] ?? '') .'</font></td>
                       <td><font size=1> 2 Respiratorio</font></td> 
                       <td><font size=1>'.($items[94]["cp"] ?? '') .' </font></td> <td><font size=1>'.($items[94]["sp"] ?? '') .'</font></td>
                       <td><font size=1> 3 Cardio vascular</font></td> 
                       <td><font size=1>'.($items[22]["cp"] ?? '') .' </font></td> 
                       <td> <font size=1>'.($items[22]["sp"] ?? '') .' </font></td>
                    	
                    </tr>
                    <tr>
                       
                       <td><font size=1> 6 Nariz</font></td> 
                      <td><font size=1>'.($items[66]["cp"] ?? '') .' </font></td> <td><font size=1>'.($items[66]["sp"] ?? '') .'</font></td>
                       <td><font size=1> 7 Cuello</font></td> 
                       <td><font size=1>'.($items[27]["cp"] ?? '') .' </font></td> <td><font size=1>'.($items[27]["sp"] ?? '') .'</font></td>
                       <td><font size=1> 8 Axila-mama</font></td> 
                       <td><font size=1>'.($items[16]["cp"] ?? '') .' </font></td> <td><font size=1>'.($items[16]["sp"] ?? '') .'</font></td>
                        <td><font size=1> 9 Torax</font></td> 
                       <td><font size=1>'.($items[100]["cp"] ?? '') .' </font></td> <td><font size=1>'.($items[100]["sp"] ?? '') .'</font></td>
                       <td><font size=1> 10 Abdomen</font></td> 
                       <td><font size=1>'.($items[0]["cp"] ?? '') .' </font></td> <td><font size=1>'.($items[0]["sp"] ?? '') .'</font></td>
                      
                       <td><font size=1> 4 Digestivo vascular</font></td> 
                       <td><font size=1>'.($items[38]["cp"] ?? '') .' </font></td> <td><font size=1>'.($items[38]["sp"] ?? '') .'</font></td>
                       <td><font size=1> 5 Genito urinario </font></td> 
                       <td><font size=1>'.($items[50]["cp"] ?? '') .' </font></td> <td><font size=1>'.($items[50]["sp"] ?? '') .'</font></td>
                       <td><font size=1> 6 Músculo</font></td> 
                       <td><font size=1>'.($items[65]["cp"] ?? '') .' </font></td> <td><font size=1>'.($items[65]["sp"] ?? '') .'</font></td>
                       
                       
                    </tr>
                     <tr>
                       <td><font size=1> 11 Columna</font></td> 
                      <td><font size=1>'.($items[25]["cp"] ?? '') .' </font></td> <td><font size=1>'.($items[25]["sp"] ?? '') .'</font></td>
                       <td><font size=1> 12 Periné</font></td> 
                       <td><font size=1>'.($items[84]["cp"] ?? '') .' </font></td> <td><font size=1>'.($items[84]["sp"] ?? '') .'</font></td>
                       <td><font size=1> 13 M superior	</font></td> 
                       <td><font size=1>'.($items[63]["cp"] ?? '') .' </font></td> <td><font size=1>'.($items[63]["sp"] ?? '') .'</font></td>
					   <td><font size=1> 14 M inferior	</font></td> 
                       <td><font size=1>'.($items[62]["cp"] ?? '') .' </font></td> <td><font size=1>'.($items[62]["sp"] ?? '') .'</font></td>
                       <td><font size=1> 		</font></td> 
                      <td><font size=1> </font></td> <td><font size=1> </font></td>

                       <td><font size=1> 7 Endocrino</font></td> 
                      <td><font size=1>'.($items[47]["cp"] ?? '') .' </font></td> <td><font size=1>'.($items[47]["sp"] ?? '') .'</font></td>
                        <td><font size=1> 8 Hemolinfáticos</font></td> 
                      <td><font size=1>'.($items[52]["cp"] ?? '') .' </font></td> <td><font size=1>'.($items[52]["sp"] ?? '') .'</font></td>
                       <td><font size=1> 9 Neurológico</font></td> 
                      <td><font size=1>'.($items[70]["cp"] ?? '') .' </font></td> <td><font size=1>'.($items[70]["sp"] ?? '') .'</font></td>
                    
                    </tr>
               
               
                    <tr>
						<td height="350" VALIGN="TOP" colspan=24>
							<font size=1>'.($adul[0]["aam_exafis"] ?? '') .'</font>
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
		    			<th width="70" > <font size=1> </font></th>
		    			  
		    		</tr>';

    for ($i=0; $i < 5; $i++) {
        $it=$i+1;
        $htmladulto .='<tr>
                            
		    		   		<td width="0.1"><font size=1>'.$it.'</font></td>
		    		   		<td width=""><font size=1>'.($dia[$i]["detalle"] ?? '') .'</font></td>
		    		   		<td width=""><font size=1><center>'.($dia[$i]["pre"] ?? '') .'</center></font></td>
		    		   		<td width=""><font size=1><center>'.($dia[$i]["def"] ?? '') .'</center></font></td>
		    		   		<td width=""><font size=1><center>'.($dia[$i]["cie"] ?? '') .'</center></font></td>

		    		   		<td width=""><font size=1><center>'.($dia[$i]["dia_descrip"] ?? '') .'</center></font></td>
		    		   		
		    				</tr>';
    }
    $htmladulto .='
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
	    			<th><font size=1>'.($items[35]["o"] ?? '') .'</font></th>
	    			<td>
	    				<font size="1">Dismovilidad</font>
	    			</td>
	    			<th><font size=1>'.($items[32]["o"] ?? '') .'</font></th>
	    		</tr>
	    		<tr>
	    			<td>
	    				<font size="1">Depresión</font>
	    			</td>
	    			<th><font size=1>'.($items[31]["o"] ?? '') .'</font></th>
	    			<td>
	    				<font size="1">Caida</font>
	    			</td>
	    			<th><font size=1>'.($items[28]["o"] ?? '') .'</font></th>
	    		</tr>
	    		<tr>
	    			<td>
	    				<font size="1">Delirio</font>
	    			</td>
	    			<th><font size=1>'.($items[29]["o"] ?? '') .'</font></th>
	    			<td>
	    				<font size="1">Mal nutrición</font>
	    			</td>
	    			<th><font size=1>'.($items[42]["o"] ?? '') .'</font></th>
	    		</tr>
	    		<tr>
	    			<td>
	    				<font size="1">Úlceras por presión</font>
	    			</td>
	    			<th><font size=1>'.($items[43]["o"] ?? '') .'</font></th>
	    			<td>
	    				<font size="1">Demencia</font>
	    			</td>
	    			<th><font size=1>'.($items[30]["o"] ?? '') .'</font></th>
	    		</tr>
	    		<tr>
	    			<td>
	    				<font size="1">Incontinecia</font>
	    			</td>
	    			<th><font size=1>'.($items[40]["o"] ?? '') .'</font></th>
	    			<td>
	    				<font size="1">iatrogenia</font>
	    			</td>
	    			<th><font size=1>'.($items[37]["o"] ?? '') .'</font></th>
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
				<font size=1>'.($adul[0]["aam_prudia"] ?? '') .'</font>
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
				<font size=1>'.($adul[0]["aam_trata"] ?? '') .'</font>
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
			<td width="95"><font size=1>'.($adul[0]["profecional"] ?? '') .'  </center></td>
			<td width="150"><center><font size=1>  </font></center></td> 
			<td width="50"><center><font size=1>'.($adul[0]["pro_codigomsp"] ?? '') .'  </font></center></td>
			<td width="10"><center><font size=1></font></center></td>
			<td width="30"><center><font size=1>'.($adul[0]["aam_fecha"] ?? '') .'</font></center></td>
			<td width="5"><center><font size=1>2</font></center></td>
		</tr>
	</table>
	</div>';
}
$htmladulto.='
	</body>
	</html>

';

// kardex ///


$Conkardex=New Consulta();
$Conadmin=New Consulta();
// CONSULTAS DE REPORRTE
# CARGAR DATOS DE ENCABEZADO. array 0
$kardex=$Conkardex->Get_Consulta("sgh_mei_kardex ep
		join sga_adm_historiaclinica as h on ep.hce_id_fk=h.hce_id_pk
		join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
		join sga_adm_persona as  per on p.per_id_fk=per.per_id_pk
		JOIN sga_adm_sexo as se on se.sex_id_pk=per.sex_id_fk where kar_fecha >='$fi' and kar_fecha<='$fa' and hce_id_fk='$hce_id_fk' ORDER BY kar_fecha DESC","per_nombres ,per_apellidopaterno ||' '|| per_apellidomaterno  as apellido,
			date_part('year',age(per_fechanacimiento)) || ' Años '||date_part('mons',age(per_fechanacimiento)) ||' Meses '|| date_part('days',age(per_fechanacimiento)) || ' Días' as Edad,per_numeroidentificacion,sex_codigo as per_sexo
      , kar_fecha,kar_medica,kar_id_pk","","","",5);

# CARGAR DIAGNOSTICO EGRESO
//$mpdf->useOddEven = 1;
// HTML DE REPORTE

# code...

$htmlkardex.= '

	<html>

	<head>

	<style>
			.th{
				   background: #99e6ff;
				   color: #000000;
				}

			@page {
			  margin:5mm 5mm 15mm 5mm ; 
				
			  size: auto;

			

			}

			@page noheadekar {
				
			   odd-header-name: html_encabezado_kar;
  			   odd-footer-name: html_piedepagina_kar;

			}

        	div.noheadekar {

			    page-break-before: right;

			    page: noheadekar;

			}

	</style>

	</head>

	<body>
	<!-- diseño encabezado pie de pagina -->		
		<htmlpagefooter name="piedepagina_kar" style="display:none">
				
			<table width="100%">

		    <tr>

		    <td width="33%"><font size=1>SNS-MSP / HCU-form.022 / 2008</font></td>

		    <td width="33%" align="center" style="font-weight: bold; font-style: italic;"></td>

		    <td width="33%" style="text-align: right; "><font size=3>ADMINISTRACIÓN DE MEDICAMENTOS</font></td>

		    </tr></table>

		</htmlpagefooter>
	<div class="noheadekar"><br>

	<!-- datos paciente -->	
	<table border="1" width="100%" cellspacing="0" cellpadding="2"> 
		           <tr>
		              <th width="125" class="th"><center><font size=1>ESTABLECIMIENTO<font></th>
		              <th width="150" class="th"><center><font size=1>NOMBRE<font></center></th>
		              <th width="150" class="th"><center><font size=1>APELLIDO<font></center></th>
		              <th width="30" class="th"><center><font size=1>SEXO(M-F)<font></center><div>
		              <th width="50" class="th"><center><font size=1>N° HOJA <font></center></th>
		              <th width="125" class="th"><center><font size=1>N° HISTORIA CLÍNICA <font></center></th>
		              
		              </div>
		               
		               </th>           
		              </font>
		              </tr>
		            </center>
		            <tr>
		              <td><center><font size=1>'.$Consigvit->entidad.'</font></center></td>
		              <td><center><font size=1>'.($kardex[0]["per_nombres"] ?? '') .' </font></center></td>
		              <td><center><font size=1>' .($kardex[0]["apellido"] ?? '') .'</font></center></td>
		              <td><center><font size=1>'.($kardex[0]["per_sexo"] ?? '') .'</font></center></td>
		              <td><center><font size=1>1</font></center></td>
		              <td><center><font size=1>'.($kardex[0]["per_numeroidentificacion"] ?? '') .'</font></center></td>   
		            </tr>  
	</table>
	<table><tr><td></td></tr></table>
	<!-- primera hoja  -->	

	<table  border="1" width="100%" cellspacing="0" cellpadding="2">
		<tr>
			<td class="th" width=200>
				<h4>1 MEDICAMENTOS</h4>
			</td>	
			<td class="th" >
				<h4>2 ADMINISTRACIÓN</h4>
			</td>
		</tr>
		<tr>
			<td class="th" width=200>
				<font size=3 ><center>PRESENTACIÓN, VÍA, DOSIS, UNITARIA, FRECUENCIA</center></font>
			</td>	
			<td class="th">
				<font size=3 ><center>DIA Y MES</center></font>
			</td>
		</tr>';
$ai=0;
$ii=0;
for ($m=0; $m <count($kardex) ; $m++) {

    $htmlkardex.='

		<tr>
			<td width=200>
				<font size=3 ><center>'.($kardex[$m]["kar_medica"] ?? '') .'</center></font>
			</td>
					<td>
						<table width="100%">

						<tr>
							<td  VALIGN="TOP">
								<table border="1" width="100%" cellspacing="0" cellpadding="2">
									<tr>
										
									</tr>
										<tr>
									<th align="center">
										<font size=1>FECHA</font>
									</th>	
									<th align="center">
										<font size=1>HORA</font>
									</th>
									<th align="center">
										<font size=1>RESPOSABLE</font>
									</th>
										<th align="center"  width=300>
										<font size=1>OBSERVACIÓN</font>
									</th>
						
									</tr>
										';
    $admi=$Conadmin->Get_Consulta("sgh_mei_aministradm am
										join sgu_usu_usuario us on am.usu_id_fk=us.usu_id_pk
										join sga_adm_profesional pr on us.pro_id_fk=pr.pro_id_pk
										join sga_adm_persona per on pr.per_id_fk=per_id_pk WHERE hda_fecha >='$fi' and hda_fecha<='$fa' and kar_id_fk='".$kardex[$m]["kar_id_pk"]."'","kar_id_fk,hda_fecha,hda_hora,
											case when  position(' ' IN per_nombres)=0 then per_nombres else
											trim(left(per_nombres, position(' ' IN per_nombres))) end || ' ' ||per_apellidopaterno as responsable,hda_obcerv","","","",5);
      $conad=count($admi);
    for ($i=$ii; $i <count($admi) ; $i++) {
        $htmlkardex.='
											<tr>
											    <td align="center">
	                                                <font size=1>'.($admi[$i]["hda_fecha"] ?? '') .' </font>
	                                            </td>
												<td align="center">
													<font size=1>'.($admi[$i]["hda_hora"] ?? '') .'</font>
												</td>
												<td align="center">
													<font size=1>'.($admi[$i]["responsable"] ?? '') .'</font>
												</td>
												<td align="center">
													<font size=1>'.($admi[$i]["hda_obcerv"] ?? '') .'</font>
												</td>
											</tr>
												';
    }
    $ii=count($admi);
    $htmlkardex.='	
								</table>
							</td>
						</tr>
						</table>		
					</td>
		</tr>';
}
$htmlkardex.='
	</table>
	</div>
	</body>
	</html>
';

// ingesta e eliminacion

$Conesg=New Consulta();
$idhc=$_GET['h'];
$esger=$Conesg->Get_Consulta("sgh_mei_ingrelimi where cie_fecha >='$fi' and cie_fecha <= '$fa' and hce_id_fk='".$idhc."' order by cie_fecha desc",
    "cie_fecha","","","",6);


// HTML DE REPORTE
$htmlingesta = '

	<html>

	<head>

	<style>
			.th{
				   background: #99e6ff;
				   color: #000000;
				}

			@page {
					 margin:3mm 5mm 5mm 5mm ;
			  size: auto;

			}

	

	</style>

	</head>

	<body>
 


    ';

for ($r=0; $r <count($esger) ; $r++) {

    $tmañanaparental=0;
    $tmañanaoral=0;
    $tmañanaparental=0;
    $tmañanaorina=0;
    $tmañanaotro=0;
    $ttardeoral=0;
    $ttardeparental=0;
    $ttardeorina=0;
    $ttardeotro=0;
    $tnocheoral=0;
    $tnocheparental=0;
    $tnocheorina=0;
    $tnocheotro=0;
    $ingreso=0;
    $totaleliminacion=0;

    $fecha=$esger[$r]["cie_fecha"];

    $Coning='Coning'.$r;
    $Conmo='Conmo'.$r;
    $Conmp='Conmp'.$r;
    $Conmor='Conmor'.$r;
    $Conmot='Conmot'.$r;

    $Conto='Conto'.$r;
    $Contp='Contp'.$r;
    $Contor='Contor'.$r;
    $Contot='Contot'.$r;

    $Conno='Conno'.$r;
    $Connp='Connp'.$r;
    $Connor='Connor'.$r;
    $Connot='Connot'.$r;

    $resml='resml'.$r;
    $resmA='resmA'.$r;
    $restl='restl'.$r;
    $restA='restA'.$r;
    $resnl='resnl'.$r;
    $resnA='resnA'.$r;

    $$resml=New Consulta();
    $$resmA=New Consulta();
    $$restl=New Consulta();
    $$restA=New Consulta();
    $$resnl=New Consulta();
    $$resnA=New Consulta();

    $$Coning=New Consulta();
    $$Conmo=New Consulta();
    $$Conmp=New Consulta();
    $$Conmor=New Consulta();
    $$Conmot=New Consulta();

    $$Conto=New Consulta();
    $$Contp=New Consulta();
    $$Contor=New Consulta();
    $$Contot=New Consulta();

    $$Conno=New Consulta();
    $$Connp=New Consulta();
    $$Connor=New Consulta();
    $$Connot=New Consulta();
// RESPONSABLES DE LA MAÑANA LICENCIADA


    $resmalic=$$resml->Get_Consulta("sgh_mei_ingrelimi i
				JOIN sgu_usu_usuario us on  i.usu_id_fk=us.usu_id_pk
			 JOIN sga_adm_profesional as pr on us.pro_id_fk = pr.pro_id_pk
				JOIN sga_adm_persona as pe  on pr.per_id_fk= pe.per_id_pk
				JOIN sga_adm_profesion as pro on pr.prf_id_fk = pro.prf_id_pk where hce_id_fk='".$idhc."' and cie_turno= 'MAÑANA' AND  cie_fecha='".$fecha."'  and prf_descripcion='LICENCIADO'",
        "'LIC. ' || per_nombres || ' ' || per_apellidopaterno as resposable,pr.pro_codigomsp,prf_descripcion","","","",5);

// RESPONSABLES DE LA MAÑANA LICENCIADA

    $resmaaxi=$$resmA->Get_Consulta("sgh_mei_ingrelimi i
				JOIN sgu_usu_usuario us on  i.usu_id_fk=us.usu_id_pk
			 JOIN sga_adm_profesional as pr on us.pro_id_fk = pr.pro_id_pk
				JOIN sga_adm_persona as pe  on pr.per_id_fk= pe.per_id_pk
				JOIN sga_adm_profesion as pro on pr.prf_id_fk = pro.prf_id_pk where hce_id_fk='".$idhc."' and cie_turno= 'MAÑANA' AND  cie_fecha='".$fecha."' and prf_descripcion<>'LICENCIADO'",
        "'AUX. ' || per_nombres || ' ' || per_apellidopaterno  as resposable,prf_descripcion","","","",5);


// RESPONSABLES DE LA TARDE LICENCIADA


    $restalic=$$restl->Get_Consulta("sgh_mei_ingrelimi i
				JOIN sgu_usu_usuario us on  i.usu_id_fk=us.usu_id_pk
			 JOIN sga_adm_profesional as pr on us.pro_id_fk = pr.pro_id_pk
				JOIN sga_adm_persona as pe  on pr.per_id_fk= pe.per_id_pk
				JOIN sga_adm_profesion as pro on pr.prf_id_fk = pro.prf_id_pk where hce_id_fk='".$idhc."' and cie_turno= 'TARDE' AND  cie_fecha='".$fecha."'  and prf_descripcion='LICENCIADO'",
        "'LIC. ' || per_nombres || ' ' || per_apellidopaterno  as resposable,pr.pro_codigomsp,prf_descripcion","","","",5);

// RESPONSABLES DE LA TARDE LICENCIADA

    $restaaxi=$$restA->Get_Consulta("sgh_mei_ingrelimi i
				JOIN sgu_usu_usuario us on  i.usu_id_fk=us.usu_id_pk
			 JOIN sga_adm_profesional as pr on us.pro_id_fk = pr.pro_id_pk
				JOIN sga_adm_persona as pe  on pr.per_id_fk= pe.per_id_pk
				JOIN sga_adm_profesion as pro on pr.prf_id_fk = pro.prf_id_pk where hce_id_fk='".$idhc."' and cie_turno= 'TARDE' AND  cie_fecha='".$fecha."' and prf_descripcion<>'LICENCIADO'",
        "'AUX. ' || per_nombres || ' ' || per_apellidopaterno  as resposable,prf_descripcion","","","",5);

// RESPONSABLES DE LA TARDE LICENCIADA


    $resnoalic=$$resnl->Get_Consulta("sgh_mei_ingrelimi i
				JOIN sgu_usu_usuario us on  i.usu_id_fk=us.usu_id_pk
			 JOIN sga_adm_profesional as pr on us.pro_id_fk = pr.pro_id_pk
				JOIN sga_adm_persona as pe  on pr.per_id_fk= pe.per_id_pk
				JOIN sga_adm_profesion as pro on pr.prf_id_fk = pro.prf_id_pk where hce_id_fk='".$idhc."' and cie_turno= 'NOCHE' AND  cie_fecha='".$fecha."'  and prf_descripcion='LICENCIADO'",
        "'LIC. ' || per_nombres || ' ' || per_apellidopaterno  as resposable,pr.pro_codigomsp,prf_descripcion","","","",5);

// RESPONSABLES DE LA TARDE LICENCIADA

    $resnoaxi=$$resnA->Get_Consulta("sgh_mei_ingrelimi i
				JOIN sgu_usu_usuario us on  i.usu_id_fk=us.usu_id_pk
			 JOIN sga_adm_profesional as pr on us.pro_id_fk = pr.pro_id_pk
				JOIN sga_adm_persona as pe  on pr.per_id_fk= pe.per_id_pk
				JOIN sga_adm_profesion as pro on pr.prf_id_fk = pro.prf_id_pk where hce_id_fk='".$idhc."' and cie_turno= 'NOCHE' AND  cie_fecha='".$fecha."' and prf_descripcion<>'LICENCIADO'",
        "'AUX. ' || per_nombres || ' ' || per_apellidopaterno  as resposable,prf_descripcion","","","",5);




    // CONSULTAS DE MAÑANA
    $moral=$$Conmo->Get_Consulta("sgh_mei_ingrelimi where hce_id_fk='".$idhc."' and cie_turno= 'MAÑANA' AND  cie_fecha='".$fecha."' AND cie_tipo='ORAL' order by cie_hora desc",
        "cie_hora,cie_clase,cie_cantcc,cie_canabs,cie_id_pk","","","",5);

    $mparental=$$Conmp->Get_Consulta("sgh_mei_ingrelimi where hce_id_fk='".$idhc."' and cie_turno= 'MAÑANA' AND  cie_fecha='".$fecha."' AND cie_tipo='PARENTAL' order by cie_hora desc",
        "cie_hora,cie_clase,cie_cantcc,cie_canabs,cie_id_pk","","","",5);

    $morina=$$Conmor->Get_Consulta("sgh_mei_ingrelimi where hce_id_fk='".$idhc."' and cie_turno= 'MAÑANA' AND  cie_fecha='".$fecha."' AND cie_tipo='ORINA' order by cie_hora desc",
        "cie_hora,cie_clase,cie_cantcc,cie_canabs,cie_id_pk","","","",5);

    $motros=$$Conmot->Get_Consulta("sgh_mei_ingrelimi where hce_id_fk='".$idhc."' and cie_turno= 'MAÑANA' AND  cie_fecha='".$fecha."' AND cie_tipo='OTROS' order by cie_hora desc",
        "cie_hora,cie_clase,cie_cantcc,cie_canabs,cie_id_pk","","","",5);
    // CONSULTA DE TARDE
    $toral=$$Conto->Get_Consulta("sgh_mei_ingrelimi where hce_id_fk='".$idhc."' and cie_turno= 'TARDE' AND  cie_fecha='".$fecha."' AND cie_tipo='ORAL' order by cie_hora desc",
        "cie_hora,cie_clase,cie_cantcc,cie_canabs,cie_id_pk","","","",5);

    $tparental=$$Contp->Get_Consulta("sgh_mei_ingrelimi where hce_id_fk='".$idhc."' and cie_turno= 'TARDE' AND  cie_fecha='".$fecha."' AND cie_tipo='PARENTAL' order by cie_hora desc",
        "cie_hora,cie_clase,cie_cantcc,cie_canabs,cie_id_pk","","","",5);

    $torina=$$Contor->Get_Consulta("sgh_mei_ingrelimi where hce_id_fk='".$idhc."' and cie_turno= 'TARDE' AND  cie_fecha='".$fecha."' AND cie_tipo='ORINA' order by cie_hora desc",
        "cie_hora,cie_clase,cie_cantcc,cie_canabs,cie_id_pk","","","",5);

    $totros=$$Contot->Get_Consulta("sgh_mei_ingrelimi where hce_id_fk='".$idhc."' and cie_turno= 'TARDE' AND  cie_fecha='".$fecha."' AND cie_tipo='OTROS' order by cie_hora desc",
        "cie_hora,cie_clase,cie_cantcc,cie_canabs,cie_id_pk","","","",5);
    // CONSULTA DE NOCHE
    $noral=$$Conno->Get_Consulta("sgh_mei_ingrelimi where hce_id_fk='".$idhc."' and cie_turno= 'NOCHE' AND  cie_fecha='".$fecha."' AND cie_tipo='ORAL' order by cie_hora desc",
        "cie_hora,cie_clase,cie_cantcc,cie_canabs,cie_id_pk","","","",5);

    $nparental=$$Connp->Get_Consulta("sgh_mei_ingrelimi where hce_id_fk='".$idhc."' and cie_turno= 'NOCHE' AND  cie_fecha='".$fecha."' AND cie_tipo='PARENTAL' order by cie_hora desc",
        "cie_hora,cie_clase,cie_cantcc,cie_canabs,cie_id_pk","","","",5);

    $norina=$$Connor->Get_Consulta("sgh_mei_ingrelimi where hce_id_fk='".$idhc."' and cie_turno= 'NOCHE' AND  cie_fecha='".$fecha."' AND cie_tipo='ORINA' order by cie_hora desc",
        "cie_hora,cie_clase,cie_cantcc,cie_canabs,cie_id_pk","","","",5);

    $notros=$$Connot->Get_Consulta("sgh_mei_ingrelimi where hce_id_fk='".$idhc."' and cie_turno= 'NOCHE' AND  cie_fecha='".$fecha."' AND cie_tipo='OTROS' order by cie_hora desc",
        "cie_hora,cie_clase,cie_cantcc,cie_canabs,cie_id_pk","","","",5);

    # CARGAR DATOS DE ENCABEZADO. array 0
    $pering=$$Coning->Get_Consulta("sgh_mei_ingrelimi ep
    		join sga_adm_historiaclinica as h on ep.hce_id_fk=h.hce_id_pk
    		join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
    		join sga_adm_persona as  per on p.per_id_fk=per.per_id_pk
        jOIN sga_adm_cama as ca on ep.cam_id_fk= ca.cam_id_pk
        join sga_adm_tipocama as hab on ca.tca_habi_fk =hab.tca_id_pk
        join sga_adm_tipocama as pis on ca.tca_piso_fk =pis.tca_id_pk
    		join sga_adm_tipocama as ser on ca.tca_serv_fk =ser.tca_id_pk
    		"," per_numeroidentificacion,per_nombres || '' ||per_apellidopaterno ||' '|| per_apellidomaterno  as paciente,
      'Cuarto ' ||hab.tca_descripcion || ' Cama ' ||ca.cam_codigo as cuca ,ser.tca_descripcion as servicio",
        "","hce_id_fk",$idhc,2);
    $htmlingesta .= '
    <div class="noheader">
    <!-- primera hoja  -->
   <!-- primera hoja  -->
    	<br><br>
    	<table width="100%">
		<tr>
			<th>
			   <H2><center>CONTROL DE INGESTA Y ELIMINACIÓN </center><H2> 
			<th>
		</tr>
	</table>
	<table width="100%" >
		<tr>
			<td>
			   <H4>TURNO DE LA MAÑANA:<H4> 
			<td>
			<td>
			   <font size=3><b>Firma y función: </b></font> 
			   <font size=1 >'.($resmalic[0]["resposable"] ?? '') .' '.($resmalic[0]["pro_codigomsp"] ?? '') .' </font>
			<td>
		    <td>
                    <font size=3><b>Firma y función: </b></font> 
                    <font size=1><b>'.($resmaaxi[0]["resposable"] ?? '') .' </b></font> 
                </td> 
		</tr>
	</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="2" > 
          <tr>
            <th colspan="6"><center>INGESTA</center></th>
            <th colspan="4"><center>ELIMINACIÓN</center></th>
          </tr>

           <tr>
                  <th colspan="3" VALIGN="TOP" height="200"><font size=3>ORAL</font>
                    <table border="1" width="100%" cellspacing="0" cellpadding="2">
              <tr>  
                    <th ><center><font size=1>Hora</font></center></th>
                    <th ><center><font size=1>Clase</font></center></th>
                    <th ><center><font size=1>Cantidad c.c</font></center></th>
                    </tr>';

                    for ($i=0; $i <sizeof($moral) ; $i++) {
                    $tmañanaoral+=$moral[$i]["cie_cantcc"];
                    $htmlingesta.='
                    <tr>
                       <td><center><font size=1>'.($moral[$i]["cie_hora"] ?? '') .'</font><center></td>
                       <td><center><font size=1>'.($moral[$i]["cie_clase"] ?? '') .'</font></center></td>
                       <td><center><font size=1>'.($moral[$i]["cie_cantcc"] ?? '') .'</font></center></td>
                    </tr>';
                    }

                    $htmlingesta.='
                    <tr>
                   
          </table>
                   
                </th>
                  <th colspan="3" VALIGN="TOP"> <font size=3>PARENTAL</font>  
                    <table border="1" width="100%" cellspacing="0" cellpadding="2"> 
                    <tr>  
                      <th><font size=1>Clase</font></th>
                      <th><font size=1>Cantidad c.c</font></th>
                      <th><font size=1>Cantidad Absorbida</font></th>
                    </tr>';

                    for ($i=0; $i <sizeof($mparental) ; $i++) {
                    $tmañanaparental+=$mparental[$i]["cie_canabs"];
                    $htmlingesta.='

                   <tr>
                      <td><center><font size=1>'.($mparental[$i]["cie_clase"] ?? '') .'</font></center></td>
                      <td><center><font size=1>'.($mparental[$i]["cie_cantcc"] ?? '') .'</font></center></td>
                      <td><center><font size=1>'.($mparental[$i]["cie_canabs"] ?? '') .'</font></center></td>
                    </tr>
                    ';
                    }

                    $htmlingesta.='
                    </table>
                  </th>
                   <th colspan="2" VALIGN="TOP"> <font size=3>ORINA</font>
                    <table border="1" width="100%" cellspacing="0" cellpadding="2"> 
                    <tr>  
                      <th><font size=1>Como obtuvo</font></th>
                      <th><font size=1>Cantidad c.c</font></th>
                    </tr>
                    ';

                    for ($i=0; $i <sizeof($morina) ; $i++) {
                    $tmañanaorina+=$morina[$i]["cie_cantcc"];
                    $htmlingesta.='
                    <tr>
                       <td><center><font size=1>'.($morina[$i]["cie_clase"] ?? '') .'</font></center></td>
                       <td><center><font size=1>'.($morina[$i]["cie_cantcc"] ?? '') .'</font></center></td>
                    </tr>';
                    }

                    $htmlingesta.='
                     
                    </table>
                  </th>
                  <th colspan="2" VALIGN="TOP"> <font size=3>OTROS</font> 
                    <table border="1" width="100%" cellspacing="0" cellpadding="2"> 
                    <tr>  
                       <th ><font size=1>Origen</font></th>
                       <th ><font size=1>Cantidad c.c</font></th>
                    </tr>
                    ';

                    for ($i=0; $i <sizeof($motros) ; $i++) {
                    $tmañanaotro+=$motros[$i]["cie_cantcc"];
                    $htmlingesta.='
                    <tr>
                       <td><center><font size=1>'.($motros[$i]["cie_clase"] ?? '') .'</font></center></td>
                       <td><center><font size=1>'.($motros[$i]["cie_cantcc"] ?? '') .'</font></center></td>
                    </tr>';
                    }

                    $htmlingesta.='
                     
                    </table>
                  </th>
           </tr>
          <tr>
               <td colspan="3"  VALIGN="TOP"><font size=3></font>
                    <table border="0" width="100%" cellspacing="0" cellpadding="2">
                    <tr>
                      <td><font size=1><b>SUB-<br>TOTAL</b></font></td>
                       <th><center></center></th>
                       <th width=100><font size=3>'.$tmañanaoral.'</font></th>
                    </tr>
                   </table>
                   
                  </th>
                  <th colspan="3" VALIGN="TOP"> <font size=3></font>  
                    <table border="0" width="100%" cellspacing="0" cellpadding="2"> 
                    
                   <tr>
                   <th><center></center></th><th><center></center></th>
                      <th width=100><font size=3 >'.$tmañanaparental.'</font></th>
                    </tr>
                    </table>
                  </th>
                   <th colspan="2" VALIGN="TOP"> <font size=3></font>
                    <table border="0" width="100%" cellspacing="0" cellpadding="2"> 
                    
                     <tr>
                      <th width=100><font size=3 >'.$tmañanaorina.'</font></th>
                    </tr>
                    </table>
                  </th>
                  <th colspan="2" VALIGN="TOP"> <font size=3></font> 
                    <table border="0" width="100%" cellspacing="0" cellpadding="2"> 
                    <tr>
                      <th width=100><font size=3 >'.$tmañanaotro.'</font></th>
                    </tr>
                    </table>
                  </td>
          </tr>
         
         </table> <!--/tabla de mañna-->  
	
	<table width="100%">
		<tr>
			<td>
			   <H4>TURNO DE LA TARDE:<H4> 
			</td>	
			<td>
			   <font size=3><b>Firma y función: </b></font> <font size=1 >'.($restalic[0]["resposable"] ?? '') .' '.($resmalic[0]["pro_codigomsp"] ?? '') .'</font>
			</td>
                <td colspan="7">
                    <font size=3><b>Firma y función: </b></font> 
                    <font size=1><b>'.($restaaxi[0]["resposable"] ?? '') .' </b></font> 
                </td>   
			
		</tr>
	</table>    
	<table  border="0" width="100%" cellspacing="0" cellpadding="2" > 

           <tr>
                  <th colspan="3" VALIGN="TOP" height="200"><font size=3></font>
                    <table border="1" width="100%" cellspacing="0" cellpadding="2">
                    <tr>  
                    <th ><center><font size=1>Hora</font></center></th>
                    <th ><center><font size=1>Clase</font></center></th>
                    <th ><center><font size=1>Cantidad c.c</font></center></th>
                    </tr>';

                    for ($i=0; $i <sizeof($toral) ; $i++) {
                    $ttardeoral+=$toral[$i]["cie_cantcc"];
                    $htmlingesta.='
                    <tr>
                       <td><center><font size=1>'.($toral[$i]["cie_hora"] ?? '') .'</font><center></td>
                       <td><center><font size=1>'.($toral[$i]["cie_clase"] ?? '') .'</font></center></td>
                       <td><center><font size=1>'.($toral[$i]["cie_cantcc"] ?? '') .'</font></center></td>
                    </tr>';
                    }

                    $htmlingesta.='
                    <tr>
                   
                   </table>
                   
                  </th>
                  <th colspan="3" VALIGN="TOP"> <font size=3></font>  
                    <table border="1" width="100%" cellspacing="0" cellpadding="2"> 
                    <tr>  
                      <th><font size=1>Clase</font></th>
                      <th><font size=1>Cantidad c.c</font></th>
                      <th><font size=1>Cantidad Absorbida</font></th>
                    </tr>';

                    for ($i=0; $i <sizeof($tparental) ; $i++) {
                    $ttardeparental+=$tparental[$i]["cie_canabs"];
                    $htmlingesta.='

                   <tr>
                      <td><center><font size=1>'.($tparental[$i]["cie_clase"] ?? '') .'</font></center></td>
                      <td><center><font size=1>'.($tparental[$i]["cie_cantcc"] ?? '') .'</font></center></td>
                      <td><center><font size=1>'.($tparental[$i]["cie_canabs"] ?? '') .'</font></center></td>
                    </tr>
                    ';
                    }

                    $htmlingesta.='
                    </table>
                  </th>
                   <th colspan="2" VALIGN="TOP"> <font size=3></font>
                    <table border="1" width="100%" cellspacing="0" cellpadding="2"> 
                    <tr>  
                      <th><font size=1>Como obtuvo</font></th>
                      <th><font size=1>Cantidad c.c</font></th>
                    </tr>
                    ';

                    for ($i=0; $i <sizeof($torina) ; $i++) {
                    $ttardeorina+=$torina[$i]["cie_cantcc"];
                    $htmlingesta.='
                    <tr>
                       <td><center><font size=1>'.($torina[$i]["cie_clase"] ?? '') .'</font></center></td>
                       <td><center><font size=1>'.($torina[$i]["cie_cantcc"] ?? '') .'</font></center></td>
                    </tr>';
                    }

                    $htmlingesta.='
                     
                    </table>
                  </th>
                  <th colspan="2" VALIGN="TOP"> <font size=3></font> 
                    <table border="1" width="100%" cellspacing="0" cellpadding="2"> 
                    <tr>  
                       <th ><font size=1>Origen</font></th>
                       <th ><font size=1>Cantidad c.c</font></th>
                    </tr>
                    ';

                    for ($i=0; $i <sizeof($totros) ; $i++) {
                    $ttardeotro+=$totros[$i]["cie_cantcc"];
                    $htmlingesta.='
                    <tr>
                       <td><center><font size=1>'.($totros[$i]["cie_clase"] ?? '') .'</font></center></td>
                       <td><center><font size=1>'.($totros[$i]["cie_cantcc"] ?? '') .'</font></center></td>
                    </tr>';
                    }

                    $htmlingesta.='
                     
                    </table>
                  </th>
           </tr>
          <tr>
               <td colspan="3"  VALIGN="TOP"><font size=3></font>
                    <table border="0" width="100%" cellspacing="0" cellpadding="2">
                    <tr>
                      <td><font size=1><b>SUB-<br>TOTAL</b></font></td>
                       <th><center></center></th>
                       <th width=100><font size=3>'.$ttardeoral.'</font></th>
                    </tr>
                   </table>
                   
                  </th>
                  <th colspan="3" VALIGN="TOP"> <font size=3></font>  
                    <table border="0" width="100%" cellspacing="0" cellpadding="2"> 
                    
                   <tr>
                      <th><center></center></th>
                      <th><center></center></th>
                      <th width=100><font size=3 >'.$ttardeparental.'</font></th>
                    </tr>
                    </table>
                  </th>
                   <th colspan="2" VALIGN="TOP"> <font size=3></font>
                    <table border="0" width="100%" cellspacing="0" cellpadding="2"> 
                    
                     <tr>
                      <th><center></center></th>
                      <th width=100><font size=3 >'.$ttardeorina.'</font></th>
                    </tr>
                    </table>
                  </th>
                  <th colspan="2" VALIGN="TOP"> <font size=3></font> 
                    <table border="0" width="100%" cellspacing="0" cellpadding="2"> 
                    
                    <tr>
                      <th><center></center></th>
                      <th width=100><font size=3 >'.$ttardeaotro.'</font></th>
                    </tr>
                    </table>
                  </td>
          </tr>
          
     </table> <!--/tabla de tarde-->   
         
         
	<table width="100%" >
		<tr>
			<td>
			   <H4>TURNO DE LA NOCHE:<H4> 
			</td>
			
			<td>
			   <font size=3><b>Firma y función: </b></font> 
			   <font size=1 >'.($resnoalic[0]["resposable"] ?? '') .' '.($resnoalic[0]["pro_codigomsp"] ?? '') .' </font>
			   
			  
			</td>
            <td>
                 <font size=3><b>Firma y función: </b></font> 
               <font size=1><b>'.($resnoaxi[0]["resposable"] ?? '') .' </b></font> 
            </td>
           
		</tr>
		
	</table>
	
	
	<table  border="0" width="100%" cellspacing="0" cellpadding="2" > 
         
           <tr>
                  <th colspan="3" VALIGN="TOP" height="200"><font size=3></font>
                    <table border="1" width="100%" cellspacing="0" cellpadding="2">
                    <tr>  
                    <th ><center><font size=1>Hora</font></center></th>
                    <th ><center><font size=1>Clase</font></center></th>
                    <th ><center><font size=1>Cantidad c.c</font></center></th>
                    </tr>';

                    for ($i=0; $i <sizeof($noral) ; $i++) {
                    $tnocheoral+=$noral[$i]["cie_cantcc"];
                    $htmlingesta.='
                    <tr>
                       <td><center><font size=1>'.($noral[$i]["cie_hora"] ?? '') .'</font><center></td>
                       <td><center><font size=1>'.($noral[$i]["cie_clase"] ?? '') .'</font></center></td>
                       <td><center><font size=1>'.($noral[$i]["cie_cantcc"] ?? '') .'</font></center></td>
                    </tr>';
                    }

                    $htmlingesta.='
                    <tr>
                   
                   </table>
                   
                  </th>
                  <th colspan="3" VALIGN="TOP"> <font size=3></font>  
                    <table border="1" width="100%" cellspacing="0" cellpadding="2"> 
                    <tr>  
                      <th><font size=1>Clase</font></th>
                      <th><font size=1>Cantidad c.c</font></th>
                      <th><font size=1>Cantidad Absorbida</font></th>
                    </tr>';

                    for ($i=0; $i <sizeof($nparental) ; $i++) {
                    $tnocheparental+=$nparental[$i]["cie_canabs"];
                    $htmlingesta.='

                   <tr>
                      <td><center><font size=1>'.($nparental[$i]["cie_clase"] ?? '') .'</font></center></td>
                      <td><center><font size=1>'.($nparental[$i]["cie_cantcc"] ?? '') .'</font></center></td>
                      <td><center><font size=1>'.($nparental[$i]["cie_canabs"] ?? '') .'</font></center></td>
                    </tr>
                    ';
                    }

                    $htmlingesta.='
                    </table>
                  </th>
                   <th colspan="2" VALIGN="TOP"> <font size=3></font>
                    <table border="1" width="100%" cellspacing="0" cellpadding="2">
                    <tr>
                      <th><font size=1>Como obtuvo</font></th>
                      <th><font size=1>Cantidad c.c</font></th>
                    </tr>
                    ';

                    for ($i=0; $i <sizeof($norina) ; $i++) {
                    $tnocheorina+=$norina[$i]["cie_cantcc"];
                    $htmlingesta.='
                    <tr>
                       <td><center><font size=1>'.($norina[$i]["cie_clase"] ?? '') .'</font></center></td>
                       <td><center><font size=1>'.($norina[$i]["cie_cantcc"] ?? '') .'</font></center></td>
                    </tr>';
                    }

                    $htmlingesta.='

                    </table>
                  </th>
                  <th colspan="2" VALIGN="TOP"> <font size=3></font>
                    <table border="1" width="100%" cellspacing="0" cellpadding="2">
                    <tr>
                       <th ><font size=1>Origen</font></th>
                       <th ><font size=1>Cantidad c.c</font></th>
                    </tr>
                    ';

                    for ($i=0; $i <sizeof($notros) ; $i++) {
                    $tnocheotro+=$notros[$i]["cie_cantcc"];
                    $htmlingesta.='
                    <tr>
                       <td><center><font size=1>'.($notros[$i]["cie_clase"] ?? '') .'</font></center></td>
                       <td><center><font size=1>'.($notros[$i]["cie_cantcc"] ?? '') .'</font></center></td>
                    </tr>';
                    }

                    $htmlingesta.='

                    </table>
                  </th>
           </tr>
          <tr>
               <td colspan="3"  VALIGN="TOP"><font size=3></font>
                    <table border="0" width="100%" cellspacing="0" cellpadding="2">
                    <tr>
                      <td><font size=1><b>SUB-<br>TOTAL</b></font></td>
                       <th><center></center></th>
                       <th width=100><font size=3>'.$tnocheoral.'</font></th>
                    </tr>
                   </table>

                  </th>
                  <th colspan="3" VALIGN="TOP"> <font size=3></font>
                    <table border="0" width="100%" cellspacing="0" cellpadding="2">

                   <tr>
                      <th><center></center></th>
                      <th><center></center></th>
                      <th width=100><font size=3 >'.$tnocheparental.'</font></th>
                    </tr>
                    </table>
                  </th>
                   <th colspan="2" VALIGN="TOP"> <font size=3></font>
                    <table border="0" width="100%" cellspacing="0" cellpadding="2">

                     <tr>
                      <th><center></center></th>
                      <th width=100><font size=3 >'.$tnocheorina.'</font></th>
                    </tr>
                    </table>
                  </th>
                  <th colspan="2" VALIGN="TOP"> <font size=3></font>
                    <table border="0" width="100%" cellspacing="0" cellpadding="2">

                    <tr>
                      <th><center></center></th>
                      <th width=100><font size=3 >'.$tnocheotro.'</font></th>
                    </tr>
                    </table>
                  </td>
          </tr>
        
          <tr>
               <td colspan="3" VALIGN="TOP"><font size=3></font>
                    <table border="0" width="100%" cellspacing="0" cellpadding="2">
                    <tr>
                      <td><font size=1><b>TOTAL<br>24 H</b></font></td>
                       ';
                            $t24horal=$tmañanaoral+$ttardeoral+$tnocheoral;
                            $t24hparental=$tmañanaparental+$ttardeparental+$tnocheparental;
                            $t24horina=$tmañanaorina+$ttardeorina+$tnocheorina;
                            $t24hotros=$tmañanaotro+$ttardeotro+$tnocheotro;

    $htmlingesta.='
                       
                       <th width=100 colspan="2"><font size=3>'.$t24horal.'</font></th>
                    </tr>
                   </table> 

                  </th>
                  <th colspan="3" > <font size=3></font>
                    <table border="0" width="100%" cellspacing="0" cellpadding="2">
                   <tr>
                     
                      <th width=100 colspan="2"><font size=3 >'.$t24hparental.'</font></th>
                    </tr>
                    </table>
                  </th>
                   <th colspan="2" > <font size=3></font>
                    <table border="0" width="100%" cellspacing="0" cellpadding="2">

                     <tr>
                
                      <th width=100><font size=3 >'.$t24horina.'</font></th>
                    </tr>
                    </table>
                  </th>
                  <th colspan="2" VALIGN="TOP"> <font size=3></font>
                    <table border="0" width="100%" cellspacing="0" cellpadding="2">

                    <tr>
                    
                      <th width=100><font size=3 >'.$t24hotros.'</font></th>
                    </tr>
                    </table>
                  </td>
          </tr>
          </table>
          <table width="">
          <tr>
               <td VALIGN="TOP"><font size=3></font>
                    <table border="0" width="100%" cellspacing="0" cellpadding="2">
                    <tr>
                      <td width="250"><font size=3 ><b>TOTAL DE INGRESOS</b></font></td>
                       ';
                            $ingreso= $t24horal+$t24hparental;
                            $totaleliminacion= $t24horina+ $t24hotros;

    $htmlingesta.='
                       
                       <td width="200"><font size=3><b>'.$ingreso.'</b></font></td>
                       <td width="200"><font size=3 ><b>TOTAL DE ELIMINACION</b></font></td>
                       <th><font size=3>'.$totaleliminacion.'</font></th>
    
                    </tr>
                    
                   </table>
                </td>
                </tr>
       </table> <!--/tabla de mañna-->
	
    
	<table width="100%">
		<tr>
	    <td>
	<table width="">
		<tr>
			<td VALIGN="TOP"><font size=2><b>CLAVE:</b></font><br> 
			</td>
			<td VALIGN="TOP">
			   <font size=2>
                Orina             <br>  
                Sonda Nasogástrica<br> 
                Cateterismo       <br>
                Sonda Foley       <br>
                Vómito            <br>
                Deposición        <br>
                </font>
			<td>
			<td VALIGN="TOP">
			   <font size=2>
                 O.<br>  
                 SNG.<br> 
                 C.<br>
                 SF.<br>
                 Vom.<br>
                 Dpl.<br>
                </font>
			<td>
		</tr>
	</table>
	</td>
	<td VALIGN="TOP">
	       <table border="" width="100%" cellspacing="0" cellpadding="2">
			<tr>
			<td style="text-align: right; " VALIGN="TOP" width="325">
			   <font size="2">
                <b>RESPONSABLE:</b><br> 
                <b>SERVICIO :</b><br>  
                <b>NOMBRE:</b><br> 
                <b>CUARTO DE CAMA:</b><br>
              </font>
            </td>
			<td style="" VALIGN="TOP" >
			   <font size="2"> 
                 EBFERMERÍA<br> 
                '.($pering[0]["servicio"] ?? '') .'<br>  
                '.($pering[0]["paciente"] ?? '') .'<br> 
                '.($pering[0]["cuca"] ?? '') .'<br>
              </font>
			</td>
		</tr>
	    </table>
	    
	</td>
	</tr>
	</table>

	<table width="100%">
	    <tr>
	        <td>
	            <font size="3">Fecha: </font><font size="3"> ' .$fecha.'</font>
	        </td>
	         <td>
	            <font size="3">Firma y funciòn: '.($resnoalic[0]["resposable"] ?? '') .' '.($resnoalic[0]["pro_codigomsp"] ?? '') .'</font><font size="2"></font>
	        </td>
	    </tr>
	</table>
</div>
    	';
}
$htmlingesta.='
    	</body> 
    	</html>
';

// glicemia e insulina //
$Conglic=New Consulta();
$ConDIglic=New Consulta();
$hce_id_fk=$_GET['h'];
// CONSULTAS DE REPORRTE
# CARGAR DATOS DE ENCABEZADO. array 0
$perglic=$Conglic->Get_Consulta("sgh_mei_glicemia ep
		join sga_adm_historiaclinica as h on ep.hce_id_fk=h.hce_id_pk
		join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
		join sga_adm_persona as  per on p.per_id_fk=per.per_id_pk
    join sga_adm_cama as ca on ep.cam_id_fk=ca.cam_id_pk
    join sga_adm_tipocama as sa on ca.tca_habi_fk=sa.tca_id_pk
    join sga_adm_tipocama as ser on ca.tca_serv_fk =ser.tca_id_pk","per_nombres ||' ' ||per_apellidopaterno ||' '|| per_apellidomaterno as paciente,
			date_part('year',age(per_fechanacimiento)) as Edad, per_numeroidentificacion,ca.cam_codigo as cama,sa.tca_descripcion as sala,ser.tca_descripcion as servicio","","hce_id_fk",$hce_id_fk,2);

# CARGAR Datos general
$gli=$ConDIglic->Get_Consulta("sgh_mei_glicemia where hgi_dia>='$fi' and hgi_dia <='$fa' and  hce_id_fk= '".$hce_id_fk."' ORDER BY hgi_dia DESC","hgi_glicem,hgi_esquem,hgi_espaco,hgi_totadm,hgi_obcerv,hgi_dia || ' ' ||hgi_fecha fecha","","","",5);
//print_r ($DiagI);
// HTML DE REPORTE

# code...

$htmlglicemia.= '

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

			 

			}


			@page noheadergli {
  			    odd-footer-name: html_pie;
			}

		
			div.noheadergli {

			    page-break-before: right;
			    page: noheadergli;

			}

	</style>

	</head>

	<body>
	<!-- diseño encabezado pie de pagina -->		
		<htmlpagefooter name="pie" style="display:none">

		</htmlpagefooter>


	<div class="noheadergli"><br>

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
		              <th width="" class=""><center><font size=1>NOMBRE<font></th>
		              <td><center><font size=1>'.($perglic[0]["paciente"] ?? '') .' </font></center></td>
		              <th width="" class=""><center><font size=1>HCI<font></center></th>
		              <td><center><font size=1>' .($perglic[0]["per_numeroidentificacion"] ?? '') .'</font></center></td>
		              <th width="" class=""><center><font size=1>SALA<font></center></th>
		              <td><center><font size=1>'.($perglic[0]["sala"] ?? '') .'</font></center></td>
		              <th width="" class=""><center><font size=1>CAMA<font></center><div>
		              <td><center><font size=1>'.($perglic[0]["cama"] ?? '') .'</font></center></td>
		              <th width="" class=""><center><font size=1>SERVICIO <font></center></th>
		              <td><center><font size=1>'.($perglic[0]["servicio"] ?? '') .'</font></center></td>   
		             
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
		<th class="th">	OBCERVACIÓN </th>
		</tr>';
for ($i=0; $i <sizeof($gli) ; $i++) {
    $htmlglicemia.='
				<tr>
					<td><font size=2><center>'.($gli[$i]["fecha"] ?? '') .'</center></font></td>	
				<td><font size=2><center>'.($gli[$i]["hgi_glicem"] ?? '') .'  mg / dl</center></font></td>	
				<td><font size=2><center>'.($gli[$i]["hgi_esquem"] ?? '') .'  UI</center></font></td>	
				<td><font size=2><center>'.($gli[$i]["hgi_espaco"] ?? '') .' UI</center></font></td>	
				<td><font size=2><center>'.($gli[$i]["hgi_obcerv"] ?? '') .' </center></font></td>	
				</tr>
				
			';
}
$htmlglicemia.=
    '
	</table>

	</div>
		</body>
		</html>
';

// interconsulta ///

$Coninter=New Consulta();
$hce_id_fk=$_GET['h'];

// CONSULTAS DE REPORRTE

$inter=$Coninter->Get_Consulta("sgh_mei_intercsol WHERE int_fecha>='$fi' and int_fecha <='$fa' and hce_id_fk='".$hce_id_fk."' ORDER BY hce_id_fk DESC","int_id_pk,int_fecha","","","",5);


//$mpdf->useOddEven = 1;
// HTML DE REPORTE

$htmlinterconsulta = '

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
				}

				@page chapterint {

				    odd-header-name: html_h2_interconsulta;

				    odd-footer-name: html_h2_interconsulta_pie;

				}

				@page noheaderint {

				  odd-header-name: html_h1_interconsulta;
   				  odd-footer-name: html_h1_interconsulta_pie;
				}

				div.chapterint {

				    page-break-before: right;

				    page: chapterint;

				}

				div.noheaderint {

				    page-break-before: right;

				    page: noheaderint;

				}

		</style>

		</head>

		<body>
		<!-- diseño encabezado pie de pagina -->		
			<htmlpageheader name="h1_interconsulta" style="display:none">
			<!-- datos paciente -->	
			
			</htmlpageheader>

			<htmlpagefooter name="h1_interconsulta_pie" style="display:none">

				<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt;

			    color: #000000; font-weight: bold; font-style: italic;">SNS-MSP / HCU-form.006 / 2008

			    <tr>

			    <td width="33%"><span style="font-weight: bold; font-style: italic;">SNS-MSP / HCU-form.007 / 2008</span></td>

			    <td width="33%" align="center" style="font-weight: bold; font-style: italic;"></td>

			    <td width="33%" style="text-align: right; ">INTERCONSULTA - SOLICITUD </td>

			    </tr></table>
			</htmlpagefooter>

			<htmlpageheader name="h2_interconsulta" style="display:none">
				<!-- datos paciente -->	


			</htmlpageheader>

			<htmlpagefooter name="h2_interconsulta_pie" style="display:none">

				<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt;

			    color: #000000; font-weight: bold; font-style: italic;">

			    <tr>

			    <td width="33%"><span style="font-weight: bold; font-style: italic;">SNS-MSP / HCU-form.007 / 2008</span></td>

			    <td width="33%" align="center" style="font-weight: bold; font-style: italic;"></td>

			    <td width="33%" style="text-align: right; ">INTERCONSULTA - INFORME </td>

			    </tr></table>
			</htmlpagefooter>
		<!-- primera hoja  -->	
		';
for ($r=0; $r <count($inter) ; $r++) {
    $Conint='Conint'.$r;
    $Conintint='Conintint'.$r;
    $ConDIint='ConDIint'.$r;
    $Consolint='Consolint'.$r;
    $ConDIinint='ConDIinint'.$r;

    $$Conint=New Consulta();
    $$Conintint=New Consulta();
    $$ConDIint=New Consulta();
    $$Consolint=New Consulta();
    $$ConDIinint=new Consulta();
    $int_id_pk=$inter[$r]["int_id_pk"];
    # CARGAR DATOS DE ENCABEZADO. array 0
    $perint=$$Conint->Get_Consulta("sgh_mei_intercsol ep
				join sga_adm_historiaclinica as h on ep.hce_id_fk=h.hce_id_pk
				join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
				join sga_adm_persona as  per on p.per_id_fk=per.per_id_pk
				JOIN sga_adm_sexo as se on se.sex_id_pk=per.sex_id_fk","per_nombres,(per_apellidopaterno ||' '|| per_apellidomaterno ) as apellido,
					date_part('year',age(per_fechanacimiento)) as Edad,per_numeroidentificacion,sex_codigo as per_sexo","","int_id_pk",$int_id_pk,2);
    # CARGAR DATOS GENERALES
    $int=$$Conintint->Get_Consulta("sgh_mei_intercsol as int
				JOIN sgh_mei_motdes as mo on mo.int_id_fk= int.int_id_pk
				jOIN sga_adm_cama as ca on mo.cam_id_fk= ca.cam_id_pk
				join sga_adm_tipocama as pis on ca.tca_piso_fk =pis.tca_id_pk
				join sga_adm_tipocama as ser on ca.tca_serv_fk =ser.tca_id_pk
		        join sgu_usu_usuario us on int.usu_id_fk=us.usu_id_pk
		        join sga_adm_profesional pro on us.pro_id_fk=pro.pro_id_pk
		        join sga_adm_persona per on pro.per_id_fk=per.per_id_pk
				","ser.tca_descripcion as servisio,mds_sersol,pis.tca_descripcion as sala ,ca.cam_codigo as cama,
				sgh_combercionmotivoreferencia('9',mds_grabed) as noramal ,
			 	 sgh_combercionmotivoreferencia('10',mds_grabed) as urgente,mds_medico,
					int.int_cuclia,int.int_resexa,int.int_planes,
				per_nombres || ' ' ||per_apellidopaterno ||' '|| per_apellidomaterno  as medicres,pro.pro_codigomsp,int.int_fecha",
        "","int.int_id_pk",$int_id_pk,2);
    # CARGAR DIAGNOSTICO INGRESO
    $diaint=$$ConDIint->Get_Consulta("sgh_mei_interdia join sgh_mei_diagnos as d on dia_id_fk=d.dia_id_pk 
    JOIN sgh_mei_codigocie10 as c10  on d.c10_id_fk=c10.c10_id_pk where int_id_fk='".$int_id_pk."' ","c10_nombre AS detalle,
					c10_codigo as cie,
					sgh_conbiertepre('1',dia_resp) as pre,
					sgh_conbiertepre('2',dia_resp) as def",
        "","","",6);
    # CARGAR DATOS GENERALES  INFORME
    $sol=$$Consolint->Get_Consulta("sgh_mei_intercsol as inf
			    join sgh_mei_intercsol sol on inf.int_id_fk=sol.int_id_pk
			    join sgu_usu_usuario us on sol.usu_id_fk=us.usu_id_pk
			    join sga_adm_profesional pro on us.pro_id_fk=pro.pro_id_pk
			    join sga_adm_persona per on pro.per_id_fk=per.per_id_pk
			            ","inf.int_cucint,inf.int_plandia,inf.int_pltrap,inf.int_recrcl,
				per_nombres || ' ' ||per_apellidopaterno ||' '|| per_apellidomaterno  as medicres,pro.pro_codigomsp,sol.int_fecha",
        "","sol.int_id_pk",$int_id_pk,2);
    # CARGAR DIAGNOSTICO INGRESO  solicitud
    $diaintinf=$$ConDIinint->Get_Consulta("sgh_mei_intercsol as inf
				    join sgh_mei_intercsol sol on inf.int_id_fk=sol.int_id_pk
				    join sgh_mei_interdia diai on diai.int_id_fk=inf.int_id_pk
				    join sgh_mei_diagnos as d on diai.dia_id_fk=d.dia_id_pk
				    JOIN sgh_mei_codigocie10 as c10  on d.c10_id_fk=c10.c10_id_pk where sol.int_id_pk='".$int_id_pk."'","c10_nombre AS detalle,
					c10_codigo as cie,
					sgh_conbiertepre('1',dia_resp) as pre,
					sgh_conbiertepre('2',dia_resp) as def",
        "","","",6);
    $htmlinterconsulta.='
			<div class="noheaderint">
		         <table border="1" width="100%" cellspacing="0" cellpadding="2"> 
			           <tr>
			              <th class="th" width="150"><center><h5>ESTABLECIMIENTO<h5></th>
			              <th class="th" width="150"><center><h5>NOMBRE<h5></center></th>
			              <th class="th" width="150"><center><h5>APELLIDO<h5></center></th>
			              <th class="th" width="30"><center><h5>SEXO(M-F)<h5></center><div>
			              <th class="th" width="30"><center><h5>EDAD <h5></center></th>
			              <th class="th" width="150"><center><h5>N° HISTORIA CLÍNICA <h5></center></th>
			              
			              </div>
			               
			               </th>           
			              </font>
			              </tr>
			            </center>
			            <tr>
			              <td><center><font size=1>'.$Consigvit->entidad.'</font></center></td>
			              <td><center><font size=1>'.($perint[0]["per_nombres"] ?? '') .'</font></center></td>
			              <td><center><font size=1>'.($perint[0]["apellido"] ?? '') .'</font></center></td>
			              <td><center><font size=1>'.($perint[0]["per_sexo"] ?? '') .'</font></center></td>
			              <td><center><font size=1>'.($perint[0]["edad"] ?? '') .'</font></center></td>
			              <td><center><font size=1>'.($perint[0]["per_numeroidentificacion"] ?? '') .'</font></center></td>   
			            </tr>  
			</table>
			<br>       
				<table border="1" width="100%" cellspacing="0" cellpadding="2">
				<tr>
				<td class="th" colspan="10"><span style="font-weight: bold; font-style: italic;"><H4><b>2. MOTIVO Y DESTINO DE LA SOLICITUD</b><h4></span></td>
				</tr>
				<tr>
					<td width="100"><center><h6>ESTABLECIMIENTO DE DESTIONO</h6></center></td>
					<td height="20" width="80"></td>
					<td width="100"><center><h6>SERVICIO CONSULTADO</h6></center></td>
					<td height="20" width="80"><font size="2"><center>'.($int[0]["tca_descripcion"] ?? '') .'<center></font></td>
					<td width="100"><center><h6>SERVICIO QUE SOLICITA</h6></center></td>
					<td height="20" width="80"><font size=2><center>'.($int[0]["mds_sersol"] ?? '') .'</center></font></td>
				    <td width="30"><center><h6>SALA</h6></center></td>
					<td height="20" width="30"><font size=2><center>'.($int[0]["sala"] ?? '') .'</center></font></td>
					<td width="30"><center><h6>CAMA</h6></center></td>
					<td height="20" width="30"><font size=2><center>'.($int[0]["cama"] ?? '') .'</center></font></td>
				</tr>
				<tr>
				   <td width="80"><center><h6>NORMAL</h6></center></td>
				   <td height="20" width="30"><font size=2><center>'.($int[0]["noramal"] ?? '') .'</center></font></td>
				   <td width="80"><center><h6>URGENTE</h6></center></td>
				   <td height="20" width="30"><font size=2><center>'.($int[0]["urgente"] ?? '') .'</center></font></td>
		   			<td width=""><center><h6>MEDICO INTERCONSULTA</h6></center></td>
		   		<td height="20" width="30" colspan="5"><font size=2><center>'.($int[0]["mds_medico"] ?? '') .'</center></font></td>
				<tr>
			</table><br>
			
			
			<table border="1" width="100%" cellspacing="0" cellpadding="2">
				<tr>
				<td width="33%" class="th"><span style="font-weight: bold; font-style: italic;"><H4><b>2. CUADRO CLÍNICIO</b><h4></span></td>
				</tr>
				<tr>
					<td height="200" VALIGN="TOP">
					    <H6>'.($int[0]["int_cuclia"] ?? '') .'</H6>
					</td>
				</tr>
			</table><br>
			<table border="1" width="100%" cellspacing="0" cellpadding="2">
				<tr>
					<td width="33%" class="th"><span style="font-weight: bold; font-style: italic;"><H4><b>3. RESUMEN DE EXÁMENES Y PROCEDIMIENTOS DIAGNÓSTICOS</b><h4></span></td>
				</tr>
				<tr>
					<td height="150" VALIGN="TOP">
						<H6>'.($int[0]["int_resexa"] ?? '') .'</H6>
					</td>
				</tr>
			</table><br>

			 <table border="1" width="100%" cellspacing="0" cellpadding="2">
			    		<tr>
			    			<td width="" colspan="2" class="th"> <span style="font-weight: bold; font-style: italic;"  > 5. DIAGNÓSTICO </spant></td>
			    			<th whdth="" class="th" ><h5>CIE<h5></th>  
			    			<th whdth="" class="th" ><h5>PRE<h5></th>  
			    			<th whdth="" class="th" ><h5>DEF<h5></th>  
			    		</tr>';

    for ($i=0; $i < 6; $i++) {
        $id=$i+1;
        $htmlinterconsulta .='<tr>
			    		   	<td width="15" height="16"><font size="2"><center>'.$id.'</center></font></td>
				    		<td height="16"><font size="2">'.($diaint[$i]["detalle"] ?? '') .'</font></td>
				    		<td width="20" height="16"><font size="2"><center>'.($diaint[$i]["cie"] ?? '') .'</center></font></td>
				    		<td width="20" height="16"><font size="2"><center>'.($diaint[$i]["pre"] ?? '') .'</center></font></td>
				    		<td width="20" height="16"><font size="2"><center>'.($diaint[$i]["def"] ?? '') .'</center></font></td>
			    				</tr>';
    }
    $htmlinterconsulta .='
				  	</table><br>
			<table border="1" width="100%" cellspacing="0" cellpadding="2">
				<tr>
				 <td width="33%" class="th"><span style="font-weight: bold; font-style: italic;"><H4><b>5. PLANES DE DIAGNÓSTICO TERAPEÚTICOS Y EDUCACIONAL REALIZADOS</b><h4></span></td>
					h4></td>
				</tr>
				<tr>
					<td height="200" VALIGN="TOP">
					    <H6>'.($int[0]["int_planes"] ?? '') .'</H6>
					</td>
				</tr>

			</table> <br>
			  <table width="100%" border="1" cellspacing="0"> 
				<tr>
					<td width="5" class="th"><font size=3>SERVICIO</font></td> <td width="150"><font size="1">'.($int[0]["servisio"] ?? '') .''.($int[0]["int_fecha"] ?? '') .'</font></td>
					<td width="95" class="th"><font size=3>MEDICO</font></td><td width="150"><center><font size="1">'.($int[0]["medicres"] ?? '') .'</font></center></td>
					<td width="50"> <center><font size="1">'.($int[0]["pro_codigomsp"] ?? '') .'</center></td>
					<td width="30" class="th"><font size=3>FIRMA</font></td>  <td width="151"></td>
				<tr>
			</table>
		</div>
			
		<!-- 2 hoja  -->	
			<div class="chapterint">
				<table border="1" width="100%" cellspacing="0" cellpadding="2"> 
			           <tr>
			              <th class="th" width="150"><center><h5>ESTABLECIMIENTO<h5></th>
			              <th class="th" width="150"><center><h5>NOMBRE<h5></center></th>
			              <th class="th" width="150"><center><h5>APELLIDO<h5></center></th>
			              <th class="th" width="30"><center><h5>SEXO(M-F)<h5></center><div>
			              <th class="th" width="30"><center><h5>EDAD <h5></center></th>
			              <th class="th" width="150"><center><h5>N° HISTORIA CLÍNICA <h5></center></th>
			              
			              </div>
			               
			               </th>           
			              </font>
			              </tr>
			            </center>
			            <tr>
			              <td><center><font size=1>'.$Consigvit->entidad.'</font></center></td>
			              <td><center><font size=1>'.($perint[0]["per_nombres"] ?? '') .'</font></center></td>
			              <td><center><font size=1>'.($perint[0]["apellido"] ?? '') .'</font></center></td>
			              <td><center><font size=1>'.($perint[0]["per_sexo"] ?? '') .'</font></center></td>
			              <td><center><font size=1>'.($perint[0]["edad"] ?? '') .'</font></center></td>
			              <td><center><font size=1>'.($perint[0]["per_numeroidentificacion"] ?? '') .'</font></center></td>   
			            </tr>  
			</table>
			<br><br>

			<table border="1" width="100%" cellspacing="0" cellpadding="2">
				<tr>
				 <td width="33%" class="th">
				 <span style="font-weight: bold; font-style: italic;"><H4><b>6. CUADRO CLÍNICIO DE INTERCONSULTA</b><h4></span>
				 </td>
				
				</tr>
		        <tr>
			    	<td height="200" VALIGN="TOP"> <font size="1">'.($sol[0]["int_cucint"] ?? '') .'</font></td>
			    </tr>
		          	
			</table>
			<br>

			<table border="1" width="100%" cellspacing="0" >
				<tr>
			     <td width="33%" class="th"><span style="font-weight: bold; font-style: italic;"><H4><b>7. PLAN DE DIAGNÓSTICOS PROPUESTOS</b><h4></span></td>
					h4></td>	
				</tr>
				<tr>
				 	<td height="150" VALIGN="TOP"> <font size="1">'.($sol[0]["int_plandia"] ?? '') .'</font></td>
			    </tr>
			</table>
			<br>
		    <table border="1" width="100%" cellspacing="0" cellpadding="2">
			    		<tr>
			    			<td width="" class="th" colspan="2"> <span style="font-weight: bold; font-style: italic;"> 8. DIAGNÓSTICO </spant></td>
			    			<th whdth="" class="th" ><h5>CIE</h5></th>  
			    			<th whdth="" class="th" ><h5>PRE</h5></th>  
			    			<th whdth="" class="th" ><h5>DEF</h5></th>  
			    		</tr>';

    for ($i=0; $i < 6; $i++) {
        $id = $i+1;
        $htmlinterconsulta .='<tr>
			    		   	<td width="15" height="16"><font size="2"><center>'.$id.'</center></font></td>
				    		<td height="16"><font size="2">'.($diaintinf[$i]["detalle"] ?? '') .'</font></td>
				    		<td width="20" height="16"><font size="2"><center>'.($diaintinf[$i]["cie"] ?? '') .'</center></font></td>
				    		<td width="20" height="16"><font size="2"><center>'.($diaintinf[$i]["pre"] ?? '') .'</center></font></td>
				    		<td width="20" height="16"><font size="2"><center>'.($diaintinf[$i]["def"] ?? '') .'</center></font></td>
			    				</tr>';
    }
    $htmlinterconsulta .='
				  	</table><br>
			
			<table width="100%" border="1" cellspacing="0"> 
				<tr>
					<td  class="th" ><span style="font-weight: bold; font-style: italic;">
					9. PLAN DE TRATAMIENTO PROPUESTO</spant>
					</td>
				</tr>
				<tr>
			    	<td height="100" VALIGN="TOP"> <font size="1">'.($sol[0]["int_pltrap"] ?? '') .'</font></td>
			    </tr>
				
			</table>
			<br>
				<table border="1" width="100%" cellspacing="0" >
				<tr>
			     <td width="33%" class="th"><span style="font-weight: bold; font-style: italic;"><H4><b>10. RESUMEN DE CRITERIO CLÍNICIO</b><h4></span></td>
					h4></td>	
				</tr>
				<tr>
			    	<td height="150" VALIGN="TOP"> <font size="1">'.($sol[0]["int_recrcl"] ?? '') .'</font></td>
			    </tr>
			</table><br>
			<table width="100%" border="1" cellspacing="0"> 
				<tr>
				<td width="5" class="th"><font size=3>SERVICIO</font></td> <td width="150"><font size="1">'.($int[0]["servisio"] ?? '') .' - '.($sol[0]["int_fecha"] ?? '') .'</font></td>
					<td width="95" class="th"><font size=3>MEDICO</font></td><td width="150"><center><font size="1">'.($sol[0]["medicres"] ?? '') .'</font></center></td>
					<td width="50"> <center><font size="1">'.($sol[0]["pro_codigomsp"] ?? '') .'</center></td>
					<td width="30" class="th"><font size=3>FIRMA</font></td>  <td width="151"></td>
					
				<tr>
			</table>

			</div>
			</body> 
			</html>
			';
}
/// epicrisis ///


$Conepi=New Consulta();
$hce_id_fk=$_GET['h'];

// CONSULTAS DE REPORRTE
# CARGAR DATOS DE ENCABEZADO. array 0
$epicr=$Conepi->Get_Consulta("sgh_mei_epicrisis  where  epi_fecha >='$fi' and epi_fecha <='$fa' and  hce_id_fk='".$hce_id_fk."' ORDER BY epi_fecha DESC ","epi_id_pk,epi_fecha","","","",5);

//$mpdf->useOddEven = 1;
// HTML DE REPORTE

$htmlepicrisis = '

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
			}
			@page noheaderepi {

			  odd-footer-name: html_piedepagina_epi;
			}
			div.noheaderepi {

			    page-break-before: right;

			    page: noheaderepi;

			}

	</style>

	</head>

	<body>
<!-- diseño encabezado pie de pagina -->		

	<htmlpagefooter name="piedepagina_epi" style="display:none">

		<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt;

	    color: #000000; font-weight: bold; font-style: italic;">SNS-MSP / HCU-form.006 / 2008

	    <tr>

	    <td width="33%"><span style="font-weight: bold; font-style: italic;">SNS-MSP / HCU-form.006 / 2008</span></td>

	    <td width="33%" align="center" style="font-weight: bold; font-style: italic;"></td>

	    <td width="33%" style="text-align: right; ">EPICRISIS</td>

	    </tr></table>
	</htmlpagefooter>



';
for ($r=0; $r <count($epicr) ; $r++) {
    $epi_id_pk=$epicr[$r]["epi_id_pk"];

    $Con='Con'.$r;
    $ConDI='ConDI'.$r;
    $ConDE='ConDE'.$r;
    $ConMT='ConMT'.$r;

    $$Con=New Consulta();
    $$ConDI=New Consulta();
    $$ConDE=New Consulta();
    $$ConMT=New Consulta();
    # CARGAR DATOS DE ENCABEZADO. array 0
    $per=$$Con->Get_Consulta("sgh_mei_epicrisis ep
		join sga_adm_historiaclinica as h on ep.hce_id_fk=h.hce_id_pk
		join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
		join sga_adm_persona as  per on p.per_id_fk=per.per_id_pk
		JOIN sga_adm_sexo as se on se.sex_id_pk=per.sex_id_fk","per_nombres,(per_apellidopaterno ||' '|| per_apellidomaterno ) as apellido,
			date_part('year',age(per_fechanacimiento)) as Edad,per_numeroidentificacion,sex_codigo as per_sexo","","epi_id_pk",$epi_id_pk,2);
    //print_r($per);
    # CARGAR DATOS GENERALES array 1
    $epic=$$Con->Get_Consulta("sgh_mei_epicrisis JOIN sgu_usu_usuario as us on usu_id_fk = us.usu_id_pk
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
    $DiagI=$$ConDI->Get_Consulta("sgh_mei_dei join sgh_mei_diagnos as d on dia_id_fk=d.dia_id_pk 
    JOIN sgh_mei_codigocie10 as c10  on d.c10_id_fk=c10.c10_id_pk where dia_tipo='INGRESO' and epi_id_fk='".$epi_id_pk."'  order by dei_id_pk","c10_nombre AS detalle,
			c10_codigo as cie,
			sgh_conbiertepre('1',dia_resp) as pre,
			sgh_conbiertepre('2',dia_resp) as def",
        "","","",5);
    //print_r ($DiagI);

    # CARGAR DIAGNOSTICO EGRESO
    $DiagE=$$ConDE->Get_Consulta("sgh_mei_dei join sgh_mei_diagnos as d on dia_id_fk=d.dia_id_pk 
    JOIN sgh_mei_codigocie10 as c10  on d.c10_id_fk=c10.c10_id_pk where dia_tipo='EGRESO' and epi_id_fk='".$epi_id_pk."'  order by dei_id_pk","c10_nombre AS detalle,
			c10_codigo as cie,
			sgh_conbiertepre('1',dia_resp) as pre,
			sgh_conbiertepre('2',dia_resp) as def",
        "","","",5);
    //print_r($DiagE);
    # CARGAR MEDICOS TRATANTES
    $Medi=$$ConMT->Get_Consulta("sgh_mei_med as me
     	join sgh_mei_epicrisis as epi on me.epi_id_fk=epi_id_pk
      join sga_adm_especialidad_profesional as esp on me.pro_id_pk=esp.pro_id_fk
      join sga_adm_profesional pr on esp.pro_id_fk = pr.pro_id_pk
      join sga_adm_especialidad es on esp.esp_id_fk = es.esp_id_pk
      JOIN sga_adm_persona as pe on pe.per_id_pk=pr.per_id_fk","coalesce(per_nombres||' '||per_apellidopaterno||' '||per_apellidomaterno) as medico,
			esp_descripcion,pro_codigomsp,med_period as periodo, med_id_pk","","epi_id_fk",$epi_id_pk,2);

    $htmlepicrisis.= '
	<div class="noheaderepi">
		<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt;

	        color: #000000; font-weight: bold; font-style: italic;">SNS-MSP / HCU-form.006 / 2008

            <tr>
    
            <td width="33%"><span style="font-weight: bold; font-style: italic;">
            
            <IMG SRC="../../../../img/msp.jpg" WIDTH="80" HEIGHT="30">
    
            </span></td>
    
            <td width="33%" align="center" style="font-weight: bold; font-style: italic;"></td>
    
            <td width="40%" style="text-align: right; "><h3>'.$Consigvit->entidad.'</h3></td>

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
	              <th class="th" width="150"><center><h5>N° HISTORIA CLÍNICA <h5></center></th>
	              
	              </div>
	               
	               </th>           
	              </font>
	              </tr>
	            </center>
	            <tr>
	              <td><center><font size=1>'.$Consigvit->entidad.'</font></center></td>
	              <td><center><font size=1>' . ($per[0]["per_nombres"] ?? '') .'</font></center></td>
	              <td><center><font size=1>' . ($per[0]["apellido"] ?? '') .'</font></center></td>
	              <td><center><font size=1>' . ($per[0]["per_sexo"] ?? '') .'</font></center></td>
	              <td><center><font size=1>' . ($per[0]["edad"] ?? '') .'</font></center></td>
	              <td><center><font size=1>' . ($per[0]["per_numeroidentificacion"] ?? '') .'</font></center></td>   
	            </tr>  
	</table>
	<br>
<!-- primera hoja  -->	
	<table border="1" width="100%" cellspacing="0" cellpadding="2">
		<tr>
		<td width="33%" class="th"><span style="font-weight: bold; font-style: italic;"><H4><b>1. RESUMEN DE CUADTRO CLÍNICIO</b><h4></span></td>
		</tr>
		<tr>
			<td height="260" VALIGN="TOP">
			   <font size="2">' . ($epic[1]["epi_recucl"] ?? '') .'</font> 
			</td>
		</tr>
	</table><br>
	<table border="1" width="100%" cellspacing="0" cellpadding="2">
		<tr>
			<td width="33%" class="th"><span style="font-weight: bold; font-style: italic;"><H4><b>2. RESUMEN DE EVOLUVIÓN Y COMPLICACIONES</b><h4></span></td>
		</tr>
		<tr>
			<td height="260" VALIGN="TOP">
				<font size="2">' . ($epic[1]["epi_reevco"] ?? '') .'</font>
			</td>
		</tr>
	</table><br>
	<table border="1" width="100%" cellspacing="0" cellpadding="2">
		<tr>
	     <td width="33%" class="th"><span style="font-weight: bold; font-style: italic;"><H4><b>3. HALLASZGO RELEVANTES DE EXÁMENES Y PROCEDIMIENTOS DIAGNÓSTICOS</b><h4></span></td>
			h4></td>	
		</tr>
		<tr>
			<td height="280" VALIGN="TOP">
				<font size="2">' . ($epic[1]["epi_harexa"] ?? '') .'</font>
			</td>
				
		</tr>
	</table>
	</div>
<!-- 2 hoja  -->	
	<div class="noheaderepi">

	<table border="1" width="100%" cellspacing="0" cellpadding="2">
		<tr>
		 <td width="33%" class="th"><span style="font-weight: bold; font-style: italic;"><H4><b>4. RESUMEN DE TRATAMIENTO Y PROCEDIMIENTOS TERAPEÚTICOS</b><h4></span></td>
			h4></td>
		</tr>
		<tr>
			<td height="400" VALIGN="TOP">
			    <font size="2">' . ($epic[1]["epi_rtrprt"] ?? '') .'</font>
			</td>
		</tr>

	</table>
	<br>

	<table width="100%">
	   <tr>
	    <td width="50%"  VALIGN="TOP">
	    	
	    	<table border="1" width="100%" cellspacing="0" cellpadding="2">
	    		<tr>
	    			<td width="70" class="th" colspan="2"> <span style="font-weight: bold; font-style: italic;"><font size="2"> 5. DIAGNÓSTICO INGRESO </font></spant></td>
	    			<th width="10" class="th" ><font size="2">CIE</font></th>  
	    			<th width="10" class="th" ><font size="2">PRE</font></th>  
	    			<th width="10" class="th" ><font size="2">DEF</font></th>  
	    		</tr>';

    for ($i = 0; $i < 6; $i++) {
        $iti=$i+1;
        $htmlepicrisis .= '<tr>
	    		   		<td width="1"><font size="1">' .$iti. '</font></td>
	    		   		<td width="70"><font size="1">' . ($DiagI[$i]["detalle"] ?? '') .'</font></td>
	    		   		<td width="10"><font size="1"><center>' . ($DiagI[$i]["cie"] ?? '') .'</center></font></td>
	    		   		<td width="10"><font size="1"><center>' . ($DiagI[$i]["pre"] ?? '') .'</center></font></td>
	    		   		<td width="10"><font size="1"><center>' . ($DiagI[$i]["def"] ?? '') .'</center></font></td>
	    				</tr>';
    }
    $htmlepicrisis .= '
		  	</table>
	    </td>
	    <td width="50%"  VALIGN="TOP">
	        <table border="1" width="100%" cellspacing="0" cellpadding="2">
	    		<tr>
	    			<td width="70" class="th" colspan="2"> <span style="font-weight: bold; font-style: italic;"><font size="2"> 6. DIAGNÓSTICO EGRESO </spant></td>
	    			<th width="10" class="th" ><font size="2">CIE</font></th>  
	    			<th width="10" class="th" ><font size="2">PRE</font></th>  
	    			<th width="10" class="th" ><font size="2">DEF</font></th>  
	    		</tr>';
    for ($i = 0; $i < 6; $i++) {
        $ite=$i+1;
        $htmlepicrisis .= '<tr>
	    		   		<td width="1"><font size="1">' . $ite . '</font></td>
	    		   		<td width="70"><font size="1">' . ($DiagE[$i]["detalle"] ?? '') .'</font></td>
	    		   		<td width="10"><font size="1"><center>' . ($DiagE[$i]["cie"] ?? '') .'</center></font></td>
	    		   		<td width="10"><font size="1"><center>' . ($DiagE[$i]["pre"] ?? '') .'</center></font></td>
	    		   		<td width="10"><font size="1"><center>' . ($DiagE[$i]["def"] ?? '') .'</center></font></td>
	    				</tr>';
    }
    $htmlepicrisis .= '
	    	</table>
	    </td>
	   </tr>
	</table>

	<br>

	<table border="1" width="100%" cellspacing="0" >
		<tr>
	     <td width="33%" class="th"><span style="font-weight: bold; font-style: italic;"><H4><b>7. CONDICIONES DE EGRESO Y PRONÓSTICO</b><h4></span></td>
			h4></td>	
		</tr>
		<tr>
			<td height="100" VALIGN="TOP">
				<font size="2">' . ($epic[1]["epi_condic"] ?? '') .'</font>
			</td>
				<H6>SNS-MSP / HCU-form.006 / 2008 </H6>
		</tr>
	</table>
	<br>

	<table width="100%" border="1" cellspacing="0">
		<tr>
			<td class="th" colspan="5"><span style="font-weight: bold; font-style: italic;">
			8. MÉDICOS TRATANTES</spant>
			</td>
		</tr>
		<tr>
			<td width="40%" colspan="2"></td>
			<td width="15%"><center>Especialidad</center></td>
			<td width="15%"><center>Código</center></td>
			<td width="25%"><center>Periodo de responsabilidad</center></td>
		</tr>';

    for ($i = 0; $i < 5; $i++) {
        $n = $i + 1;
        $htmlepicrisis .= '<tr>
						<td width="0.1%"> <center> <font size="2">' . $n . ' </font></center></td>
							<td width="40%"><font size="2">' . ($Medi[$i]["medico"] ?? '') .'</font></td>
							<td width="15%"><font size="2"><center>' . ($Medi[$i]["esp_descripcion"] ?? '') .'</center></font></td>
							<td width="15%"><font size="2"><center>' . ($Medi[$i]["pro_codigomsp"] ?? '') .'</center></font></td>
							<td width="25%"><font size="2"><center>' . ($Medi[$i]["periodo"] ?? '') .'</center></font></td>
						</tr>';
    }
    $htmlepicrisis .= '

	</table>
	<br>
	<table width="100%" border="1" cellspacing="0"> 
		<tr>
			<td  class="th" colspan="5" colspan="12" ><span style="font-weight: bold; font-style: italic;">
			9. CONDICIONES DE EGRESO Y PRONÓSTICO</spant>
			</td>
		</tr>
		<tr>
			<td class="th"><font size="2">Alta definitiva</td>
			<td width="20"><font size="2"><center>' . ($epic[1]["alta_definitiva"] ?? '') .'</center></font></td>
			<td class="th"><font size="2">Asintomático</td>
			<td width="20"><font size="2"><center>' . ($epic[1]["asintomatica"] ?? '') .'</center></font></td>
			<td class="th"><font size="2">Discapacidad moderada</td>
			<td width="20"><font size="2"><center>' . ($epic[1]["dicapacidad_modereada"] ?? '') .'</center></font></td>
			<td class="th"><font size="2">Retiro Autorizado</td>
			<td width="20"><font size="2"><center>' . ($epic[1]["retiro_atoriza"] ?? '') .'</center></font></td>
			<td class="th"><font size="2">Defunción - de 48 H</td>
			<td width="20"><font size="2"><center>' . ($epic[1]["defucion_me_48"] ?? '') .'</center></font></td>
			<td class="th"><font size="2">Días de estada</td>
			<td  width="20"><font size="2"><center>' . ($epic[1]["epi_diaest"] ?? '') .'</center></font></td>
			
		<tr>
		<tr>
			<td class="th"><font size="2">Alta transitoria</td>
			<td><font size="2"><center>' . ($epic[1]["alta_transitoria"] ?? '') .'</center></font></td>
			<td class="th"><font size="2">Discapacidad leve</td>
			<td><font size="2"><center>' . ($epic[1]["dicapacidad_leve"] ?? '') .'</center></font></td>
			<td class="th"><font size="2">Discapacidad grave</td>
			<td><font size="2"><center>' . ($epic[1]["dicapacidad_grave"] ?? '') .'</center></font></td>
			<td class="th"><font size="2">Retiro no autorizado</td>  
			<td><font size="2"><center>' . ($epic[1]["retiro_no_atoriza"] ?? '') .'</center></font></td>
			<td class="th"><font size="2">Defunción más de 48 H</td>  
			<td><font size="2"><center>' . ($epic[1]["defucion_mas_48"] ?? '') .'</center></font></td>
			<td class="th"><font size="2">Días de incapacidad</td>  
			<td><font size="2"><center>' . ($epic[1]["epi_diadin"] ?? '') .'</center></font></td>
			
		<tr>
	</table>
	<br>
	
	<table border="1" cellspacing="0" width="100%"> 
		<tr>
			<td width="20" class="th"><font size="2">Fecha</font></td>
			<td width="10"><font size="2"><center>' . ($epic[1]["epi_fecha"] ?? '') .'</font></center></td>
			<td width="30" class="th"><font size="2">Hora</font></td>
			<td width="10"><font size="2"><center>' . substr($epic[1]["epi_hora"], 0, -7) . '</font></center></td>
			<td width="95" class="th"><font size="2">Nombre del profesional</font></td>
			<td width="150"><font size="1"><center>'.($epic[1]["epi_respon"] ?? '') .'</center></font></td> 
			<td width="50"><font size="1"><center>'. ($epic[1]["epi_rescmsp"] ?? '') .'</center></font></td>
			<td width="30" class="th"><font size="2">Firma</td>  
			<td width="150"></td>
			<td width="5" class="th"><font size="2">Número de hoja </font></td><td width="20"><center>2</center></td>
			
		<tr>
	</table>
	<font size="2"> REALIZADO POR : '. ($epic[1]["responsable"] ?? '') .' '. ($epic[1]["pro_codigomsp"] ?? '') .' '. ($epic[1]["pro_codigosenescyt"] ?? '') .' C.I'. ($epic[1]["per_numeroidentificacion"] ?? '') .' </font>
	</div>
	';
}
$htmlepicrisis.='
	</body> 
	</html>
';

// lista de problemas //


$Conpro=New Consulta();
$ConDEpro=New Consulta();

$hce_id_pk=$_GET['h'];
// CONSULTAS DE REPORRTE
# CARGAR DATOS DE ENCABEZADO. array 0
$per=$Conpro->Get_Consulta("sgh_ped_prblemas ep
		join sga_adm_historiaclinica as h on ep.hce_id_fk=h.hce_id_pk
		join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
		join sga_adm_persona as  per on p.per_id_fk=per.per_id_pk
		JOIN sga_adm_sexo as se on se.sex_id_pk=per.sex_id_fk","per_nombres,(per_apellidopaterno ||' '|| per_apellidomaterno ) as apellido,
			date_part('year',age(per_fechanacimiento)) || ' Años '||date_part('mons',age(per_fechanacimiento)) ||' Meses '|| date_part('days',age(per_fechanacimiento)) || ' Días' as Edad,per_numeroidentificacion,sex_codigo as per_sexo","","hce_id_fk",$hce_id_pk,2);

# CARGAR DIAGNOSTICO EGRESO
$pro=$ConDEpro->Get_Consulta("sgh_ped_prblemas WHERE pbl_fehca >='$fi' and  pbl_fehca <='$fa'  and hce_id_fk='".$hce_id_pk."' ORDER BY pbl_id_pk DESC","hce_id_fk,pbl_edad,pbl_fecini,pbl_fecdet,pbl_antece,
CASE WHEN pbl_actpasi ='ACTIVO' then 'x' end as activo,CASE WHEN pbl_actpasi ='PASIVO' then 'x' end as pasivo,pbl_sindro,pbl_fehca","","","",5);

//$mpdf->useOddEven = 1;

$htmlproblemas.= '

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

		

			}


			@page noheader22 {
				

			}
			
			div.noheader22 {

			    page-break-before: right;

			    page: noheader22;

			}

	</style>

	</head>

	<body>
<!-- diseño encabezado pie de pagina -->		
	

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
	              <td><center><font size=1>'.$Consigvit->entidad.'</font></center></td>
	              <td><center><font size=1>'.($per[0]["per_nombres"] ?? '') .' </font></center></td>
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
// score downes
$Condow=New Consulta();
$Conddow=New Consulta();

$hce_id_pk=$_GET['h'];
$fi=$_GET['fi'];
$fa=$_GET['fa'];
// CONSULTAS DE REPORRTE
# CARGAR DATOS DE ENCABEZADO. array 0
$per=$Condow->Get_Consulta("sgh_ped_dawnes ep
		join sga_adm_historiaclinica as h on ep.hce_id_fk=h.hce_id_pk
		join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
		join sga_adm_persona as  per on p.per_id_fk=per.per_id_pk
		JOIN sga_adm_sexo as se on se.sex_id_pk=per.sex_id_fk","per_nombres,(per_apellidopaterno ||' '|| per_apellidomaterno ) as apellido,
			date_part('year',age(per_fechanacimiento)) || ' Años '||date_part('mons',age(per_fechanacimiento)) ||' Meses '|| date_part('days',age(per_fechanacimiento)) || ' Días' as Edad,per_numeroidentificacion,sex_codigo as per_sexo","","hce_id_fk",$hce_id_pk,2);

# CARGAR DIAGNOSTICO EGRESO
$daw=$Conddow->Get_Consulta("sgh_ped_dawnes where scd_fecha>='".$fi."' and  scd_fecha<='".$fa."' and  hce_id_fk='".$hce_id_pk."' ORDER BY scd_fecha DESC","*","","","",5);


# code...

$htmldownes.= '

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
	              <td><center><font size=1>'.$Consigvit->entidad.'</font></center></td>
	              <td><center><font size=1>'.($per[0]["per_nombres"] ?? '') .' </font></center></td>
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
		<td colspan="7">
			<center><h5>SCORE DOWNES</h5></center>
		</td>	
	</tr>
	<tr>
		<td colspan="7">
		<table width="100%">
			<tr>
				<th class="th"><font size=2>Puntos</font></th>
				<th class="th"><font size=2>Sibilancias</font></th>
				<th class="th"><font size=2>Tiraje</font></th>
				<th class="th"><font size=2>FR</font></th>
				<th class="th"><font size=2>FC</font></th>
				<th class="th"><font size=2>Ventilación</font></th>
				<th class="th"><font size=2>Cianosis</font></th>
			</tr>
			<tr>
				<td class="th"><font size=3>0</font></td>
				<td class="th"><font size=3>No </font></td>
				<td class="th"><font size=3>No</font></td>
				<td class="th"><font size=3>< 30</font></td>
				<td class="th"><font size=3>< 120</font></td>
				<td class="th"><font size=3>Buena. Simétrica</font></td>
				<td class="th"><font size=3>No</font></td>
			</tr>
			<tr>
				<td class="th"><font size=3>1</font></td>
				<td class="th"><font size=3>Final espiración </font></td>
				<td class="th"><font size=3>Subcostal. Intercostal</font></td>
				<td class="th"><font size=3>31 - 45</font></td>
				<td class="th"><font size=3> >120 </font></td>
				<td class="th"><font size=3>Regular. Simétrica</font></td>
				<td class="th"><font size=3>Sí</font></td>
			</tr>
			<tr>
				<td class="th"><font size=3>2</font></td>
				<td class="th"><font size=3>Toda espiración</font></td>
				<td class="th"><font size=3>+ Supraclavicula <br> + Aleteo nosal</font></td>
				<td class="th"><font size=3>46 - 60</font></td>
				<td class="th"><font size=3></font></td>
				<td class="th"><font size=3>Muy disminuida</font></td>
				<td class="th"><font size=3></font></td>
			</tr>
			<tr>
				<td class="th"><font size=3>3</font></td>
				<td class="th"><font size=3>+ Inspiración</font></td>
				<td class="th"><font size=3>+ Todo lo anterior <br> + Suprasternal</font></td>
				<td class="th"><font size=3></font></td>
				<td class="th"><font size=3></font></td>
				<td class="th"><font size=3>Tórax silente</font></td>
				<td class="th"><font size=3></font></td>
			</tr>

		</table>
		</td>
	</tr>
	</table>
	<table border="1" width="100%" cellspacing="0" cellpadding="2">
	<tr>
				<th><font size=3>Fecha</font></th>
				<th><font size=3>Sibilancias</font></th>
				<th><font size=3>Tiraje</font></th>
				<th><font size=3>F Respiratoria</font></th>
				<th><font size=3>F Cardiaca</font></th>
				<th><font size=3>Ventilación</font></th>
				<th><font size=3>Cianosis</font></th>
				<th><font size=3>Total</font></th>

	</tr>';
for ($i=0; $i <sizeof($daw) ; $i++) {
    $htmldownes.='
			<tr>
				<td><font size=3><center>'.($daw[$i]["scd_fecha"] ?? '') .'</center></font></td>
				<td><font size=3><center>'.($daw[$i]["scd_sibila"] ?? '') .'</center></font></td>
				<td><font size=3><center>'.($daw[$i]["scd_tiraje"] ?? '') .'  </center></font></td>
				<td><font size=3><center>'.($daw[$i]["scd_frespi"] ?? '') .'  </center></font></td>
				<td><font size=3><center>'.($daw[$i]["scd_frecar"] ?? '') .'  </center></font></td>
				<td><font size=3><center>'.($daw[$i]["scd_ventil"] ?? '') .'  </center></font></td>
				<td><font size=3><center>'.($daw[$i]["scd_cianos"] ?? '') .'  </center></font></td>
				<td><font size=3><center>'.($daw[$i]["scd_total"] ?? '') .' </center></font></td>
			</tr>
		';
}

$htmldownes.='	

</table>

</div>
	</body>
	</html>
';

//$mpdf=new mPDF('c','A4');

$mpdf->writeHTML($htmlproblemas);
$mpdf->writeHTML($htmldownes);
$mpdf->writeHTML($htmlglicemia);
$mpdf->writeHTML($htmlingesta);
$mpdf->writeHTML($htmlanamnesis);
$mpdf->writeHTML($htmlevolucion);
$mpdf->writeHTML($htmlepicrisis);
$mpdf->writeHTML($htmlinterconsulta);
$mpdf->writeHTML($htmlsignosvitales);
$mpdf->writeHTML($htmlkardex);
$mpdf->writeHTML($htmladulto);

$mpdf->Output('General.pdf','I');

exit;
?>