<?php
require_once("../../../../js/lib/mpdf-6.1.3/mpdf.php");
include_once("../../../../php/class_consulta.php");
$Con=New Consulta();
$Cona=New Consulta();
$Conf=New Consulta();
$hce_id_fk=$_GET['h'];
// CONSULTAS DE REPORRTE
# CARGAR DATOS DE ENCABEZADO. array 0
		$per=$Con->Get_Consulta("sgh_mei_kardex ep
		join sga_adm_historiaclinica as h on ep.hce_id_fk=h.hce_id_pk
		join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
		join sga_adm_persona as  per on p.per_id_fk=per.per_id_pk
		JOIN sga_adm_sexo as se on se.sex_id_pk=per.sex_id_fk","per_nombres ,per_apellidopaterno ||' '|| coalesce(per_apellidomaterno,'')  as apellido,
			date_part('year',age(per_fechanacimiento)) || ' Años '||date_part('mons',age(per_fechanacimiento)) ||' Meses '|| date_part('days',age(per_fechanacimiento)) || ' Días' as Edad,per_numeroidentificacion,sex_codigo as per_sexo
      , kar_fecha,kar_medica,kar_id_pk","","hce_id_fk",$hce_id_fk,2);

	# CARGAR DIAGNOSTICO EGRESO 
 //$mpdf->useOddEven = 1;
// HTML DE REPORTE 

	# code...

$html.= '

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

	    <td width="33%"><font size=1>SNS-MSP / HCU-form.022 / 2008</font></td>

	    <td width="33%" align="center" style="font-weight: bold; font-style: italic;"></td>

	    <td width="33%" style="text-align: right; "><font size=3>ADMINISTRACIÓN DE MEDICAMENTOS</font></td>

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
	              <th width="50" class="th"><center><font size=1>N° HOJA <font></center></th>
	              <th width="125" class="th"><center><font size=1>N° HISTORIA CLÍNICA <font></center></th>
	              
	              </div>
	               
	               </th>           
	              </font>
	              </tr>
	            </center>
	            <tr>
	              <td><center><font size=1>HOSPITAL GENERAL SANTO DOMINGO</font></center></td>
	              <td><center><font size=1>'.$per[0]["per_nombres"] .' </font></center></td>
	              <td><center><font size=1>' .$per[0]["apellido"].'</font></center></td>
	              <td><center><font size=1>'.$per[0]["per_sexo"].'</font></center></td>
	              <td><center><font size=1>1</font></center></td>
	              <td><center><font size=1>'.$per[0]["per_numeroidentificacion"].'</font></center></td>   
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
	for ($m=0; $m <count($per) ; $m++) { 
				
	$html.='

	<tr>
		<td width=200>
			<font size=3 ><center>'.$per[$m]["kar_medica"].'</center></font>
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
									$admi=$Cona->Get_Consulta("sgh_mei_aministradm am
									join sgu_usu_usuario us on am.usu_id_fk=us.usu_id_pk
									join sga_adm_profesional pr on us.pro_id_fk=pr.pro_id_pk
									join sga_adm_persona per on pr.per_id_fk=per_id_pk WHERE kar_id_fk='".$per[$m]["kar_id_pk"]."'","kar_id_fk,hda_fecha,hda_hora,
										case when  position(' ' IN per_nombres)=0 then per_nombres else
										trim(left(per_nombres, position(' ' IN per_nombres))) end || ' ' ||per_apellidopaterno as responsable,hda_obcerv","","","",5);
									$conad=count($admi);
									for ($i=$ii; $i <count($admi) ; $i++) { 
										$html.='
										<tr>
										    <td align="center">
                                                <font size=1>'.$admi[$i]["hda_fecha"].' </font>
                                            </td>
											<td align="center">
												<font size=1>'.$admi[$i]["hda_hora"].'</font>
											</td>
											<td align="center">
												<font size=1>'.$admi[$i]["responsable"].'</font>
											</td>
											<td align="center">
												<font size=1>'.$admi[$i]["hda_obcerv"].'</font>
											</td>
										</tr>
											';
										}
									$ii=count($admi);
								$html.='	
							</table>
						</td>
					</tr>
					</table>		
				</td>
	</tr>';
	}	
	$html.='

</table>

</div>
	</body>
	</html>
';

// CREACIÓN DE PDF 
$mpdf= new mPDF('c','A4','','arial');
$mpdf->writeHTML($html);
$mpdf->Output('Administración de medicamentos.pdf','I');

?>