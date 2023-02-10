<?php
require_once '../../../../vendor/autoload.php';
include_once("../../../../php/class_consulta.php");
use Mpdf\Mpdf;
$mpdf = new mPDF(['debug' => true,'mode'=>'utf-8','format'=>'A4']);

$Conead=New Consulta();
$hce_id_fk=$_GET['h'];
$eventop=$Conead->Get_Consulta("sgh_mei_eventosadver  where hce_id_fk='".$hce_id_fk."' ORDER BY fed_fecha DESC","fed_id_pk,fed_fecha","","","",5);

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

			  size: auto;
			  margin: 7mm 7mm 7mm 7mm ; 
			  
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

		<table width="100%" border="1" cellspacing="0" cellpadding="2">
	    <tr>

		    <td width="50%" rowspan="2"  align="center" >
			<IMG SRC="../../../../img/msp.jpg" WIDTH="150" HEIGHT="50">
		    </td>
		    <td width="10%" align="center" style="font-weight: bold; font-style: italic;">Código</td>
		    <td width="25%" style="text-align: center; ">Anexo 1 PSQ 721.001-REA-A</td>
	    </tr>
	    <tr>
	    <td width="10%" align="center" style="font-weight: bold; font-style: italic;">Versión</td>
		    <td width="20%" style="text-align: center; ">0</td>
	    </tr>
	    <tr>
	    	<td align="center"> <b>Procedimiento Cultural de la Seguridad</b><td/>
	        <td width="10%" align="center" style="font-weight: bold; font-style: italic;">Fecha</td>
		    <td width="20%" style="text-align: center; ">05/01/2015</td>
	    </tr>
	    
	    </table>

	</htmlpageheader>

	<htmlpagefooter name="myFooter1" style="display:none">
	
	</htmlpagefooter>

	<htmlpageheader name="Chapter2HeaderOdd" style="display:none">
	<table width="100%" border="1" cellspacing="0" cellpadding="2">
	    <tr>

		    <td width="50%" rowspan="2"  align="center" >
			<IMG SRC="../../../../img/msp.jpg" WIDTH="150" HEIGHT="50">
		    </td>
		    <td width="10%" align="center" style="font-weight: bold; font-style: italic;"></td>
		    <td width="25%" style="text-align: center; "></td>
	    </tr>
	    <tr>
	    <td width="10%" align="center" style="font-weight: bold; font-style: italic;">Versión</td>
		    <td width="20%" style="text-align: center; "></td>
	    </tr>
	    <tr>
	    	<td align="center"> <b>Solicitud de Acción  Correctiva / Preventiva</b><td/>
	        <td width="10%" align="center" style="font-weight: bold; font-style: italic;">Fecha</td>
		    <td width="20%" style="text-align: center; "></td>
	    </tr>
	    
	    </table>
	</htmlpageheader>

	<htmlpagefooter name="Chapter2FooterOdd" style="display:none">

		
	</htmlpagefooter>

';

for ($r=0; $r <count($eventop) ; $r++) {

    $Con='Con'.$r;
    $ConAC='ConAC'.$r;

    $$Con=New Consulta();
    $$ConAC=New Consulta();
    $fed_id_pk=$eventop[$r][fed_id_pk];
// CONSULTAS DE REPORRTE
    # CARGAR DATOS DE ENCABEZADO. array 0
    $per=$$Con->Get_Consulta("sgh_mei_eventosadver as edv
join sga_adm_tipocama as ser on edv.ser_id_fk=ser.tca_id_pk
join sga_adm_historiaclinica as his on edv.hce_id_fk=his.hce_id_pk
JOIN sga_adm_paciente as pas  on his.pac_id_fk= pas.pac_id_pk
JOIN sga_adm_persona as peh  on pas.per_id_fk= peh.per_id_pk","tca_descripcion,fed_fecha, (peh.per_nombres ||' '||peh.per_apellidopaterno || ' ' || coalesce(per_apellidomaterno,'')) AS usuario,
fed_relacon,fed_prodale,sgh_conbiertepre('1',fed_prodale) as si,sgh_conbiertepre('2',fed_prodale) as no,
sgh_combercionmotivoreferencia('11',fed_ocasio) as paciente,
sgh_combercionmotivoreferencia('12',fed_ocasio) as familia,
sgh_combercionmotivoreferencia('13',fed_ocasio) as visitante,
sgh_combercionmotivoreferencia('14',fed_ocasio) as funcionario,
sgh_combercionmotivoreferencia('15',fed_ocasio) as equipo,
fed_desles,fed_medado,
sgh_combercionmotivoreferencia('16',fed_tipcla) as indicente,
sgh_combercionmotivoreferencia('17',fed_tipcla) as alto_impacto,
sgh_combercionmotivoreferencia('18',fed_tipcla) as medio_impacto,
sgh_combercionmotivoreferencia('19',fed_tipcla) as bajo_impacto,fed_tipcla","","fed_id_pk",$fed_id_pk,2);

    # CARGAR DATOS DE ENCABEZADO. array 0
    $acp=$$ConAC->Get_Consulta("sgh_mei_soliaccion as acp 
join sgh_mei_eventosadver as edv on acp.fed_id_fk=edv.fed_id_pk","acp_accion,
sgh_combercionmotivoreferencia('20',acp_accion) as ac,
sgh_combercionmotivoreferencia('21',acp_accion) as ap,
  acp_fecha,acp_ncorre,acp_npreve,
acp_acp_tipo,acp_felim,acp_por,acp_descrip,acp_hallas,acp_accorr,acp_medica,acp_feacor,
  acp_acfuef,
sgh_conbiertepre('1',acp_acfuef) as si,
  sgh_conbiertepre('2',acp_acfuef) as no,
  acp_nuacap","","fed_id_pk",$fed_id_pk,2);


    $html.='
<div class="noheader"><br><br><br><br><br><br>
<!-- primera hoja  -->

	<table width="100%">
		<tr>
			<th>
			   <H4><center>FORMULARIO DE NOTIFICACIÓN Y EVENTOS ADVERSOS<br>'.$Conead->entidad.'</center><H4>

			<th>
		</tr>
	</table><br>
	<table width="100%">	
		<tr>	
			<td  width="50%">
				<font size="4"><b>Servicio o unidad  : </b>' . $per[0]["tca_descripcion"] . '</font>
			</td>
			<td  width="50%">
				<font size="4"><b>Lugar de ocurrencia : </b></font>
			</td>		
		</tr>
		<tr>	
			<td  width="50%">
				<font size="4"><b> Fecha : </b>' . $per[0]["fed_fecha"] . '</font>
			</td>
			<td  width="50%">
				<font size="4"><b>Hora :  </b>
			</td>		
		</tr>

		<tr>	
			<td colspan="4">
				<font size="4"><b>Nombre del Usuario: </b>' . $per[0]["usuario"] . '</font>
			</td>
				
		</tr>
	</table>
	<br>	
	<table border="1" cellspacing="0" cellpadding="2"  width="100%">
		<tr>
			<td>	
				<table width="100%">
					<tr>
						<td>
							<font size="4"><b>Relato de lo acontecido : </b></font>	
						</td>
					</tr>
					<tr>
						<td height="80" VALIGN="TOP">
							<font size="2">' . $per[0]["fed_relacon"] . '</font>	
						</td>		
					</tr>		
				</table>
				<hr>
				<table >
					<tr>
						<td colspan="3">
							<font size="4"><b>Provoca daño o lesións : </b></font>	
						</td>
					</tr>

					<tr>
						<td width="10"></td>
						<td width="200"></td>	
						<td>
							<table border="1" cellspacing="0" cellpadding="2" width="100%">
								<tr>
									<td width="70" height="30">
										<font size="3"><center>SI</center></font>	
									</td>	
									<td width="70" height="30">	
										<font size="2"><center>' . $per[0]["si"] . '</center></font>	
									</td>
									<td width="70" height="30">
										<font size="3"><center>NO</center></font>	
									</td>	
									<td width="70" height="30">	
										<font size="2"><center>' . $per[0]["no"] . '</center></font>	
									</td>		
								</tr>	
					    	</table>	
				        </td>		
			        </tr>
		        </table>
				<hr>
				<table width="100%">
					<tr>
						<td>
							<font size="4"><b>Ocasionado a : </b></font>	
						</td>
					</tr>
					<tr>
						<td>
							<table border="1" cellspacing="0" cellpadding="2" width="100%">	
								<tr>
									<td width="40">
										<font size="3"><center>Paciente</center></font>	
									</td>	
									<td width="40">	
										<font size="2"><center>' . $per[0]["paciente"] . '</center></font>	
									</td>
									<td width="40">
										<font size="3"><center>Familia</center></font>	
									</td>	
									<td width="40">	
										<font size="2"><center>' . $per[0]["familia"] . '</center></font>	
									</td>
									<td width="40">
										<font size="3"><center>Visitante</center></font>	
									</td>	
									<td width="40">	
										<font size="2"><center>' . $per[0]["visitante"] . '</center></font>
									</td>

									<td width="40">
										<font size="3"><center>Funcionario</center></font>	
									</td>	
									<td width="40">	
										<font size="2"><center>' . $per[0]["funcionario"] . '</center></font>
									</td>
									<td width="40">
										<font size="3"><center>Equipo/insumo</center></font>
									</td>	
									<td width="40">	
										<font size="2"><center>' . $per[0]["equipo"] . '</center>
										</font>
									</td>

								</tr>	
							</table>
						</td>
					</tr>
					<tr>
						<td>
							<font size="4"><b>Describa el daño o lesión : </b></font>	
						</td>		
					</tr>
					<tr>
						<td height="70" VALIGN="TOP">
							<font size="2">' . $per[0]["fed_desles"] . '</font>		
						</td>	
					</tr>
				</table>
				<hr>
				<table  width="100%">
					<tr>
						<td>
							<font size="4"><b>Medidas inmediatas adoptadas : </b></font>	
						</td>

					</tr>	
					<tr>
						<td height="70" VALIGN="TOP">
							<font size="2">' . $per[0]["fed_medado"] . '</font>	
						</td>		
					</tr>
				</table>
				<hr>	
				<table border="1" cellspacing="0" cellpadding="2" >
					<tr>
						<td>
							<font size="2">Incidente</font>		
						</td>
						<td width="90" align="center" >
							<font size="2">' . $per[0]["indicente"] . '</font>			
						</td>		
					</tr>
					<tr>
						<td>
							<font size="2">Evento adverso de alto impacto</font>		
						</td>
						<td width="90" align="center" >
							<font size="2">' . $per[0]["alto_impacto"] . '</font>			
						</td>		
					</tr>
					<tr>
						<td>
							<font size="2">Evento adverso de mediano impacto</font>		
						</td>
						<td width="90" align="center" >
							<font size="2">' . $per[0]["medio_impacto"] . '</font>			
						</td>		
					</tr>
						<tr>
						<td>
							<font size="2">Evento adverso de bajo impacto</font>		
						</td>
						<td width="90" align="center" >
							<font size="2">' . $per[0]["bajo_impacto"] . '</font>			
						</td>		
					</tr>		
				</table>
				<br>
				<table width="100%" border="1" cellspacing="0" cellpadding="2">
					<tr>
						<td>
							<font size="2">Tipo de clasificación :</font>	
							<font size="2">' . $per[0]["fed_tipcla"] . '</font>		
						</td>
								
					</tr>		
				</table>	
				
				<center>
						<font size="2">(Uso exclusivo Unidad de calidad y Seguridad del PAciente)</font>	
				</center>	
			</td>
		</tr>	
	</table>
	<br>
	<font size="4"><b>		Responsable de la notificación : .............................................................................................................. </b></font><br>

	<font size="4"><b>		C.I : ............................................................................... Firma : .............................................................. </b></font><br>	
    <br>
    <font size="2" >
 		             Fuente: Manual Técnico de seguridad de paciente,  MSP, 2017 <br>
                    Elaborado por : Comite tecnico de seguridad de paciente  <br>
 		     </font>
</div>
<!-- 2 hoja  -->		
 <div class="chapter2">
 		<br></br><br></br><br></br><br><br><br>
 		<table width="100%">
 			<tr>
 				<td align="right">
 					<font size="4"><b>Solicitud de Acción Correctiva / Preventiva</b></font>
 				</td>	
 			</tr>	
 		</table>
 		<table width="100%"> 
 			<tr>
 			<td width="300"></td>
 				<td>
 					<font size="6"><b>AC</b></font>
 				<td>
 		
 				<td>
 				<table border="1" cellspacing="0" cellpadding="2">
 						<tr>
 							<td width="30" height="30">
 								' . $acp[0]["ac"] . '
 							</td>
 						</tr>
 					</table>
 				</td>
 					<td>
 					<font size="6"><b>AP</b></font>
 				<td>
 				<td>
 					<table border="1" cellspacing="0" cellpadding="2">
 						<tr>
 							<td width="30" height="30">
 							' . $acp[0]["ap"] . '
 							</td>
 						</tr>
 					</table>
 				</td>
 				<td width="300"></td>
 			</tr>
			</table>
			<table width="100%">
 			<tr>
 				<td colspan="4">
 					<center>
 					<font size="3">(Marque el cuadro apropiado para indicar acción correctiva o accion preventiva)</font>
 					</center>
 				</td>
 			</tr>
 		</table>
			<table width="100%">
 			<tr>
 				<td colspan="2" style="text-align: right; ">
 					<font size="4">Acción Correctiva N° ' . $acp[0]["acp_ncorre"] . '</font>
 				</td>
 				<td width="160"></td>
 			</tr>
 			<tr>
 				<td>
 					<font size="4">Fecha: ' . $acp[0]["acp_fecha"] . '</font>
 				</td>	
 				 <td style="text-align: right; ">
 					<font size="4">Acción Preventiva N° ' . $acp[0]["acp_npreve"] . '</font>
 				</td>
				<td width="160"></td>
 			</tr>
 		</table> <br>
 		<table width="100%" border="1" cellspacing="0" cellpadding="2" align="center">
 			<tr>
 				<td width="200">

 				</td>
 				<td align="center">
 					Fecha Límite
 				</td>
 				<td align="center">
 					Por / Asignada a 
 				</td>
 				<td align="center">
 					Firma y Fecha de Realización
 				</td>
 			</tr>
		    <tr>
 				<td>' . $acp[0]["acp_acp_tipo"] . '</td>
 				<td>' . $acp[0]["acp_felim"] . '</td>
 				<td>' . $acp[0]["acp_por"] . '</td>
 				<td></td>
 			</tr>
 			<tr>
 				<td  colspan="4" align="center">
 						<font size="4">Descripción del asunto</font>
 				</td>
 			</tr>
 			 <tr>
 				<td  colspan="4" height="500" VALIGN="TOP">
 						<font size="3">' . $acp[0]["acp_descrip"] . '</font>
 				</td>
 			</tr>
 		</table>
 		<br>
 		<br>
 		<br>
 		<br>
		<br>
 		<br>
 		<br><br>
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
		<font size="2">
		</font>
		</td></tr>
 	</table>

</div>
<!-- 3 hoja  -->
<div class="chapter2">
 		<br></br><br></br><br></br><br><br><br>
 		<table width="100%">
 			<tr>
 				<td align="right">
 					<font size="4"><b>Solicitud de Acción Correctiva / Preventiva</b></font>
 				</td>	
 			</tr>	
 		</table>
 		<table width="100%"> 
 			<tr>
 			<td width="300"></td>
 				<td>
 				</td>
 				<td width="300"></td>
 			</tr>
			</table>
			<table width="100%">
 			<tr>
 				<td colspan="4">
 					
 				</td>
 			</tr>
 		</table>

			<table width="100%">
 			<tr>
 				
 			</tr>
 			<tr>
 				
 			</tr>
 		</table> <br>
 		<table width="100%" border="1" cellspacing="0" cellpadding="2" align="center">
 			
 			<tr>
 				<td  colspan="4" align="center">
 						<font size="4">Hallazgo de Investigación / Causa Fundamental</font>
 				</td>
 			</tr>
 			 <tr>
 				<td  colspan="4" height="250" VALIGN="TOP">
 						<font size="3">' . $acp[0]["acp_hallas"] . '</font>
 				</td>
 			</tr>
 		</table><br>
 		<table width="100%" border="1" cellspacing="0" cellpadding="2" align="center">
 			
 			<tr>
 				<td  colspan="4" align="center">
 						<font size="4">Acción Correctiva / Preventiva</font>
 				</td>
 			</tr>
 			 <tr>
 				<td  colspan="4" height="200" VALIGN="TOP">
 						<font size="3">' . $acp[0]["acp_accorr"] . '</font>
 				</td>
 			</tr>
 			<tr>
 				<td height="50" VALIGN="TOP" colspan="4">
	 			<table>
		 			<tr>	
						<td colspan="4">
		 						<font size="3">Acordada por: ' . $acp[0]["acp_medica"] . '</font>
		 				</td>
		 			</tr>
		 			<tr>	
						<td colspan="4">
		 						<font size="3">Fecha : ' . $acp[0]["acp_feacor"] . '</font>
		 				</td>
		 			</tr>
	 			</table>
	 			</td>
 			</tr>
 		</table><br>
 			<table width="100%" border="1" cellspacing="0" cellpadding="2" align="center">
 			
 			<tr>
 				<td  colspan="4" align="center">
 					<font size="4">Comentarios del Auditor</font>
 						<br>
 					<table width="100%">
 					<tr>
 						<td>
 							<font size="4">¿ Acción tomada fue eficaz ? </font>
 						</td>
 						<td>
 							<table border="1" cellspacing="0" cellpadding="2" align="center">
 								<tr>
 									<td width="15" height="15" >
 									' . $acp[0]["si"] . '
 									</td>
 								</tr>	
 							</table>
 						</td>
 						<td>SI</td>
 						<td>
 							<table border="1" cellspacing="0" cellpadding="2" align="center">
 								<tr>
 									<td width="15" height="15" >
 										' . $acp[0]["no"] . '
 									</td>
 								</tr>	
 							</table>
 						</td>
 						<td>NO</td>
 						<td>
 							Si no, número de nueva AC/AP: ' . $acp[0]["acp_nuacap"] . ' 
 						</td>
 						<td></td>
 					</tr>	
 					</table>
 				</td>
 			</tr>
 		</table><br>
 		<table>
 			<tr>
 				<td>
 					Fuente Normas ISO 9001-2008<br>
 					Firma:.................................
 				</td>
 			</tr>

 		</table>
 		
 		<br>
 		<br>
		<br>
 		<br>
 		<br>

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
		<font size="2">
		</font>
		</td></tr>
 	</table>
</div>';
}
$html.='

	</body> 
	</html>

';
// CREACIÓN DE PDF 
//$mpdf= new mPDF('c','A4','','arial');
$mpdf->writeHTML($html);
$mpdf->Output('Eventos Adversos.pdf','I');
?>