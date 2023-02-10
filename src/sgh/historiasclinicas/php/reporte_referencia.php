<?php
require_once("../../../../js/lib/mpdf-6.1.3/mpdf.php");
include_once("../../../../php/class_consulta.php");
$Con=New Consulta();
$Conre=New Consulta();
$Condi=New Consulta();
$Conde=New Consulta();
$Conor=New Consulta();
$ref_id_pk=$_GET['c'];
// CONSULTAS DE REPORRTE
	# CARGAR DATOS DE ENCABEZADO. array 0
		$per=$Con->Get_Consulta("sgh_mei_referencia as r
join sga_adm_historiaclinica as h on h.hce_id_pk=r.hce_id_fk
join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
join sga_adm_persona as  per on p.per_id_fk=per.per_id_pk
join sga_adm_parroquia as pa on per.par_id_fk=pa.par_id_pk
join sga_adm_canton as ca on pa.can_id_fk=ca.can_id_pk
join sga_adm_provincia as pro on ca.prv_id_fk=pro.prv_id_pk
join sga_adm_pais as pais on pro.pai_id_fk = pais.pai_id_pk
JOIN sga_adm_sexo as se on se.sex_id_pk=per.sex_id_fk","ref_id_pk,
           per_apellidopaterno,
           per_apellidomaterno,per_nombres,to_char(per_fechanacimiento,'dd-MM-YYYY') as per_fechanacimiento,date_part('year',age(per_fechanacimiento)) as Edad,sex_codigo as sexo,pai_descripcion,per_numeroidentificacion,coalesce(prv_descripcion||'/ '||can_descripcion||'/ '||par_descripcion) as lugar_residencia,per_direccionprincipal,per_numeroidentificacion,per_telefonocelular as tel_numero
","","ref_id_pk",$ref_id_pk,2);

	# CARGAR DATOS DE REFERENCIA. array 0
		$ref=$Conre->Get_Consulta("sgh_mei_referencia","ref_id_pk,ref_servi,ref_espec,
sgh_combercionmotivoreferencia('7',ref_tipo) as T1 ,
sgh_combercionmotivoreferencia('8',ref_tipo) as T2 ,
sgh_combercionmotivoreferencia('1',ref_motivo) as uno ,
sgh_combercionmotivoreferencia('2',ref_motivo) as dos ,
sgh_combercionmotivoreferencia('3',ref_motivo) as tres,
sgh_combercionmotivoreferencia('4',ref_motivo) as cuatro,
sgh_combercionmotivoreferencia('5',ref_motivo) as cinco ,
sgh_combercionmotivoreferencia('6',ref_motivo) as otros ,
    ref_rescuad,ref_halrel,ref_medico,ref_codmsp","","ref_id_pk",$ref_id_pk,2);
		
	# CARGAR Diagnotico. array 0
		$dia=$Condi->Get_Consulta("sgh_mei_drd
			JOIN sgh_mei_diagnos as d on dia_id_fk=d.dia_id_pk
			JOIN sgh_mei_codigocie10 as c10  on d.c10_id_fk=c10.c10_id_pk where ref_id_fk='".$ref_id_pk."'","c10_nombre as Diagnostico,c10_codigo as cie_10,dia_resp,sgh_conbiertepre('1',dia_resp) as pre,sgh_conbiertepre('2',dia_resp) as def
","","","",6);
		# cargar institucion destino
				$insd=$Conde->Get_Consulta("sgh_mei_referencia	as r
join sga_adm_historiaclinica as hist on r.hce_id_fk=hist.hce_id_pk
join sga_adm_establecimiento as es on r.ins_de_fk=es.eta_id_pk
join sga_adm_institucion as ins on es.ins_id_fk=ins.ins_id_pk
join sga_adm_tipologiainstitucion as tip on es.tin_id_fk= tip.tin_id_pk
join sga_adm_nivelinstitucion as niv on tip.nin_id_fk=niv.nin_id_pk","ins_abreviacion as Entidad,eta_descripcion ,ref_servi,ref_espec,to_char(ref_fecha,'dd-MM-YYYY') as ref_fecha
","","ref_id_pk",$ref_id_pk,2);
		# cargar institucion or
				$inor=$Conor->Get_Consulta(" sgh_mei_referencia as r
INNER JOIN sga_adm_establecimiento establecimiento ON establecimiento.eta_id_pk = r.ins_or_fk
INNER JOIN sga_adm_institucion institucion ON institucion.ins_id_pk = establecimiento.ins_id_fk
INNER JOIN sga_adm_tipologiainstitucion tipoins ON tipoins.tin_id_pk = establecimiento.tin_id_fk
INNER JOIN sga_adm_parroquia parroquia ON parroquia.par_id_pk = establecimiento.par_id_fk
INNER JOIN sga_adm_canton canton ON canton.can_id_pk = parroquia.can_id_fk
INNER JOIN sga_adm_zona distrito ON distrito.zon_id_pk = canton.zon_id_fk
INNER JOIN sga_adm_provincia provincia ON provincia.prv_id_pk = canton.prv_id_fk","establecimiento.eta_descripcion as establecimiento_or,
institucion.ins_abreviacion as entidad_or,
tipoins.tin_abreviacion as tipo,
provincia.prv_codigo || distrito.zon_descripcion distrito_or
","","ref_id_pk",$ref_id_pk,2);		
//$mpdf->useOddEven = 1;
// HTML DE REPORTE 

$html = '

	<html>

	<head>

	<style>
			.th{
				   background: #CED1D3;
				   color: #000000;
				}
              
			@page {

              margin:5mm 5mm 5mm 5mm ; 
             
              
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

		

	</htmlpageheader>

	<htmlpagefooter name="myFooter1" style="display:none">

		<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt;

	    color: #000000; font-weight: bold; font-style: italic;">
	    <tr>
            <br> <br>
	    <td width="50%"><span style="font-weight: bold; font-style: italic;" VALIGN="TOP"><H5>MSP-DNEAIS/form. 053/ene/2014</H5></td>

	    <td width="30%">
	    		<table border="1"  cellspacing="0" cellpadding="2">
	    			<tr>
	    				<td>
	    				7. <h6>Referencia Justificada</h6>

	    				</td>	
	    				<td width="30"> </td>
	    			</tr>
	    		</table>
	    </td>

	    <td width="30%" style="text-align: right; "></td>

	    </tr></table>
	</htmlpagefooter>

<div class="noheader">
<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt;
	    color: #000000; font-weight: bold; font-style: italic;">
	    <tr>

	    <td width="33%" ><span style="font-weight: bold; font-style: italic;">
	    
	    <IMG SRC="../../../../img/msp.jpg" WIDTH=100 HEIGHT=30>

	    </span></td>

	    <td width="10%" align="center" style="font-weight: bold; font-style: italic;"></td>

	    <td width="50%" style="text-align: right; "><h3>HOSPITAL GENERAL SANTODOMINGO</h3></td>

	    </tr></table>

<!-- encabezado  -->	
	<table width="100%"  align="center" style="font-weight: bold; font-style: italic;">
		<tr> 
		<th class="th">FORMULARIO DE REFERENCIA,DERIVACIÓN,CONTRAREFERENCIA Y REFERENCIA INVERSA</th>
		</tr>
	</table>
	<table>
	<tr>
			<td colspan="7"><h5>I.DATOS DEL USUARIO/USUARIA</h5></td>
		</tr>
	</table>
	
	<table width="100%" border="1" width="100%" cellspacing="0" cellpadding="0">
		
		<tr>
			<th class="th"><h6>Apellido Paterno<h6></th>	
			<th class="th"><h6>Apellido Materno<h6></th>	
			<th class="th"><h6>Nombre<h6></th>	
			<th class="th"><h6>Fecha de nacimeinto<h6></th>	
			<th class="th"><h6>Edad<h6></th>	
			<th class="th"><h6>Sexo<h6></th>	
		<tr>
		<tr>
			<td><font size=1><center>'.$per[0]["per_apellidopaterno"].'</center></font></td>	
			<td><font size=1><center>'.$per[0]["per_apellidomaterno"].'</center></font></td>	
			<td><font size=1><center>'.$per[0]["per_nombres"].'</center></font></td>	
			<td><font size=1><center>'.$per[0]["per_fechanacimiento"].'</center></font></td>	
			<td><font size=1><center>'.$per[0]["edad"].'</center></font></td>	
			<td><font size=1><center>'.$per[0]["sexo"].'</center></font></td>
		</tr>
	</table>
	<table width="100%" border="1" cellspacing="0" cellpadding="0">	
		<tr>
			<th class="th"><font size=1>Nacionalidad</font></th>	
			<th class="th"><font size=1>País</font></th>	
			<th class="th" width="120"><font size=1>Cédula de Ciudadania ó pasaporte<font></th>	
			<th class="th"><font size=1>Lugar de residencia actual</font></th>	
			<th class="th"><font size=1>Dirección Domicilio</font></th>	
			<th class="th"><font size=1>N° Teléfonico</font></th>
		</tr>
		<tr>
			<td><font size=1><center>'.$per[0]["pai_descripcion"].'</center></font></td>	
			<td><font size=1><center>'.$per[0]["pai_descripcion"].'</center></font></td>	
			<td><font size=1><center>'.$per[0]["per_numeroidentificacion"].'</font></center></font></td>	
			<td><font size=1><center>'.$per[0]["lugar_residencia"].'</font></center></td>	
			<td><font size=1><center>'.$per[0]["per_direccionprincipal"].'</font></center></td>
			<td><font size=1><center>'.$per[0]["tel_numero"].'</font></center></td>
		</tr>
		<tr>
			<td class="th" height="10"><center><font size=1>Ver. Instructivo</font></center></td>	
			<td class="th" height="10"><center><font size=1>Describir Pais</font></center></td>	
			<td class="th" height="10"><center><font size=1>Cpedula diez digito</font></center></td>	
			<td class="th" height="10"><center><font size=1>provincia | Cantón | Parroqui</font></center></td>	
			<td class="th" height="10"><center><font size=1>Calle Principal y Secundaria</font></center></td>	
			<td class="th" height="10"><center><font size=1>Convecional /celular</font></center></td>
		</tr>
	</table>
<!-- primera bloque de referencia -->		
<table>
	<tr>
		<td>
			<h5>II.REFERENCIA: </h5>
		</td><td>1<td>

		<td width="40" >
			<table width="100%" border="1" cellspacing="0" cellpadding="1">
				<tr> <td HEIGHT="15"><center><h6><center>'.$ref[0]["t1"].'</center><h6></center></td></tr>
			</table>	
		</td>

		<td>
			<h4>DERIVACIÓN: </H5>
		</td><td>2<td>

		<td width="40" >
			<table width="100%" border="1" cellspacing="0" cellpadding="1">
				<tr> <td HEIGHT="15"><center><font size=1>'.$ref[0]["t2"].'</font></center></td></tr>
			</table>
		</td>
	</tr>
</table>

	  <table>
				<tr>
					<td><h5>1. Datos Institucionales</H5></td>
				</tr>
			</table>
			<table  border="1" width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<th class="th" width="120"><center><H5>Entidad del Sistema</H5></center></th>	
					<th class="th"><center><H5>Hist. clínica No.</H5></center></th>	
					<th class="th"><center><H5>Establecimiento de salud</H5></center></th>	
					<th class="th"><center><H5>Tipo</H5></center></th>	
					<th class="th"><center><H5>Distrito/Área</H5></center></th>	
				</tr>
				<tr>
					<td><font size=1><center>'.$inor[0]["entidad_or"].'</center></font></td>
					<td><font size=1><center>'.$per[0]["per_numeroidentificacion"].'</center></font></td>
					<td><font size=1><center>'.$inor[0]["establecimiento_or"].'</center></font></td>
					<td><font size=1><center>'.$inor[0]["tipo"].'</center></font></td>
					<td><font size=1><center>'.$inor[0]["distrito_or"].'</center></font></td>
				</tr>
			</table>
			<table  border="1" width="100%" cellspacing="0" cellpadding="0">
				<tr><th colspan="4" class="th"><h5>Refiere o Deriva a:</h5></th> <td class="th"><h5><center>Fecha</center></h5></td><tr>
				<tr>
					<td><font size=1><center>'.$insd[0]["entidad"].'</center></font></td>
					<td><font size=1><center>'.$insd[0]["eta_descripcion"].'</center></font></td>
					<td><font size=1><center>'.$insd[0]["ref_servi"].'</center></font></td>
					<td><font size=1><center>'.$insd[0]["ref_espec"].'</center></font></td>
					<td><font size=1><center>'.$insd[0]["ref_fecha"].'</center></font></td>
				</tr>
				<tr>
					<th class="th" width="120"><center><h6>Entidad del Sistema</h6></center></th>	
					<th class="th"><center><h6>Establecimiento de salud</h6></center></th>	
					<th class="th"><center><h6>Servicio</h6></center></th>	
					<th class="th"><center><h6>Especialidad</h6></center></th>	
					<th class="th"><center><h6>Día/Mes/Año</h6></center></th>	
				</tr>
			</table>
			<table>
			    <tr> 
			    <td><b><h5>2. Motivo de la Referencia o Derivación</h5></b></td>
			    </tr>
			    <tr>
			    <td>
			    <table> 
			    <tr>
				    <td> <font size=2>1 Limitada capacidad resolutiva </font> </td> 
				    <td width="30" HEIGHT="12"border="1" cellspacing="0" cellpadding="0">
				    		 <center> <font size=1>'.$ref[0]["uno"].'</font></center>
					
				    </td>
				    <td><font size=2>4 Saturación de capacidad instalada</font> </td> 
				    <td width="30" HEIGHT="12">
				    	<center><h6>'.$ref[0]["cuatro"].'</h6></center>
					</td>
			    </tr>
			    <tr> 
				    <td><font size=2> 2 Ausencia temporal del profesional</font></td> 
				    <td width="30" HEIGHT="12">
				    	<center><h6>'.$ref[0]["dos"].'</h6></center>
					
				    </td>
				    <td><font size=2> 5 Otro / Especifique: </font></td>
				    <td width="30" td HEIGHT="12">
				    	<center><h6>'.$ref[0]["cinco"].'</h6></center>
				    </td>
			    </tr> 
			    <tr> 
			        <td><font size=2>3 Falta de profesional </font></td>
			        <td width="30" HEIGHT="12">
				    	<center><h6>'.$ref[0]["tres"].'</h6></center>
						</table>
			        </td>
			        <td><center><h6>'.$ref[0]["otros"].'</h6></center></td>
			    </tr>
			    <td>    
			   </tr>
			  </table>     
			</table>
			<table width="100%">
				<tr>
					<td><h5>3. Resumen de cuadro clinico</h5></td>
				</tr>
				<tr>
					<td>
						<table border="1" width="100%" cellspacing="0" cellpadding="0">
							<tr>
							   <td width="100%" height="30" VALIGN="TOP"><font size=1>'.$ref[0]["ref_rescuad"].'</font></>
							  </td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td><h5>4. Hallazgos relevantes de exámenes y procedientos diagnóstico</h5></td>
				</tr>
				<tr>
					<td>
						<table border="1" width="100%" cellspacing="0" cellpadding="0">
							<tr>
							   <td width="100%" height="30" VALIGN="TOP"><font size=1>'.$ref[0]["ref_halrel"].'</font></>
							  </td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<table width="100%"><tr><td>
		    <table border="1" width="100%" cellspacing="0" cellpadding="0">
		    	<tr>
		    		<td class="th" colspan="2"><h5>5. Diagnóstico</h5></td>
		    		<td class="th"><h6>CIE-10</h6></td>
		    		<td class="th"><h6>PRE</h6></td>
		    		<td class="th"><h6>DEF</h6></td>
		    	</tr>';
		    	for ($i=0; $i < 2; $i++) {
		    		$id=$i+1;
		    	$html.='
		    	<tr>
		    		<td width="15" height="16"><font size=1><center>'.$id.'</center></font></td>
		    		<td height="16"><font size=1>'.$dia[$i]["diagnostico"].'</font></td>
		    		<td width="20" height="16"><font size=1><center>'.$dia[$i]["cie_10"].'</font></center></h6></H6></td>
		    		<td width="20" height="16"><font size=1><center>'.$dia[$i]["pre"].'</font></center></h6></H6></td>
		    		<td width="20" height="16"><font size=1><center>'.$dia[$i]["def"].'</font></center></h6></H6></td>
		    		
		    	</tr>';
		    	}
		    	$html.='
		    </table></td></tr></table>
			<table width="100%">
				<tr>
					<td style="text-align: right; "><h6>Nombre del Profecional:</h6></td><td>____________________</td>
					<td style="text-align: right; "><h6>Código MSP:</h6></td><td>______________</td>
					<td style="text-align: right; "><h6>Firma:</h6></td><td>____________________</td>
									
				</tr>
			</table>
<!-- segundo bloque contrareferencia  -->
<table>
	<tr>
		<td>
			<H5>II.CONTRAREFERENCIA: </H5>
		</td><td>3<td>

		<td width="40" height="10">
			<table width="100%" border="1" cellspacing="0" cellpadding="1">
				<tr> <td HEIGHT="15"><center><h6></h6></center></td></tr>
			</table>	
		</td>

		<td>
			<H5>REFERENCIA INVERSA: </H5>
		</td><td>4<td>

		<td width="40" height="10">
			<table width="100%" border="1" cellspacing="0" cellpadding="1">
				<tr> <td HEIGHT="15"><center><h6></h6></center></td></tr>
			</table>
		</td>
	</tr>
</table>
			<table>
				<tr>
					<td  height="10"><h5>1. Datos Institucionales</H5></td>
				</tr>
			</table>
			<table  border="1" width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<th class="th" width="120"><center><H5>Entidad del Sistema</H5></center></th>	
					<th class="th"><center><H5>Hist. clínica No.</H5></center></th>	
					<th class="th"><center><H5>Establecimiento de salud</H5></center></th>	
					<th class="th"><center><H5>Tipo</H5></center></th>	
					<th class="th"><center><H5>Servicio</H5></center></th>	
					<th class="th"><center><H5>Especialidad del servicio</H5></center></th>	
				</tr>
				<tr>
					<td height="16"><H6><center></center></H6></td>
					<td height="16"><H6><center></center></H6></td>
					<td height="16"><H6><center></center></H6></td>
					<td height="16"><H6><center> </center></H6></td>
					<td height="16"><H6><center></center></H6></td>
					<td height="16"> <H6><center></center></H6></td>
				</tr>
			</table>
			<table  border="1" width="100%" cellspacing="0" cellpadding="0">
				<tr><th colspan="4" class="th"><h5>Contrareferencia o Referencia inversa a :</h5></th> <td class="th"><h5><center>Fecha</center></h5></td><tr>
				<tr>
					<td height="16"><H6><center></center></H6></td>
					<td height="16"><H6><center></center></H6></td>
					<td height="16"><H6><center></center></H6></td>
					<td height="16"><H6><center></center></H6></td>
					<td height="16"><H6><center></center></H6></td>
				</tr>
				<tr>
					<th class="th" width="120"><center><font size=1>Entidad del Sistema</font></center></th>	
					<th class="th"><center><font size=1>Establecimiento de salud</font></center></th>	
					<th class="th"><center><font size=1>Tipo</font></center></th>	
					<th class="th"><center><font size=1>Distrito/Área</font></center></th>	
					<th class="th"><center><font size=1>día/Mes/Año</font></center></th>	
				</tr>
			</table>
			<table width="100%">
				<tr>
					<td><h5>2. Resumen de cuadro clinico</h5></td>
				</tr>
				<tr>
					<td>
						<table border="1" width="100%" cellspacing="0" cellpadding="0">
							';
							for ($i=0; $i < 3; $i++) {
								$id = $i+1;
			            		$html .='
			            		<tr>
				    		   		<td height="15"><center></center></td>
				    		   	</tr>';	
			          		}
				    		$html .='
						</table>
					</td>
				</tr>
				<tr>
					<td><h5>3. Hallazgos relevantes de exámenes y procedientos diagnóstico</h5></td>
				</tr>
				<tr>
					<td>
						<table border="1" width="100%" cellspacing="0" cellpadding="0">
							';
								for ($i=0; $i < 2; $i++) {
									$id = $i+1;
				            		$html .='<tr>
					    		   		<td height="15"><center></center></td>
					    		   	</tr>';	
				          		}
					    		$html .='
						</table>
					</td>
				</tr>
				<tr>
					<td><h5>4. Tratamientos y procedimeitos terapéuticos realizados</h5></td>
				</tr>
				<tr>
					<td>
						<table border="1" width="100%" cellspacing="0" cellpadding="0">
							';
								for ($i=0; $i < 2; $i++) {
									$id = $i+1;
				            		$html .='<tr>
					    		   		<td height="15"><center></center></td>
					    		   	</tr>';	
				          		}
					    		$html .='
						</table>
					</td>
				</tr>
			</table>
			<table border="1" width="100%" cellspacing="0" cellpadding="0">
		    	<tr>
		    		<td class="th" colspan="2"><h5>5. Diagnóstico</h5></td>
		    		<td class="th"><h5>CIE-10</h5></td>
		    		<td class="th"><h5>PRE</h5></td>
		    		<td class="th"><h5>DEF</h5></td>
		    	</tr>
		    	';
				for ($i=0; $i < 2; $i++) {
					$id = $i+1;
            		$html .='<tr>
	    		   	<td width="15" height="15"><H6><center>'.$id.'</center></H6></td>
		    		<td height="16"><h6></h6></td>
		    		<td width="20" height="15"><H6><h6><center></center></h6></H6></td>
		    		<td width="20" height="15"><H6><h6><center></center></h6></H6></td>
		    		<td width="20" height="15"><H6><h6><center></center></h6></H6></td>
	    		   	</tr>';	
          		}
	    		$html .='
		    </table>
		    <table width="100%">
		    	<tr>
					<td><h5>6. Tratamiento recomendado a seguir en Establecimiento de salud de menor nivel de complejidad</h5></td>
				</tr>
		    	<tr>
					<td>
						<table border="1" width="100%" cellspacing="0" cellpadding="0">
							';
								for ($i=0; $i < 2; $i++) {
									$id = $i+1;
				            		$html .='<tr>
					    		   		<td height="15"><center></center></td>
					    		   	</tr>';	
				          		}
					    		$html .='
						</table>
					</td>
				</tr>
		    </table>
			<table width="100%">
				<tr>
					<td style="text-align: right; "><h5>Nombre del Profecional:</H5></td><td>____________________</td>
					<td style="text-align: right; "><h5>Código MSP:</H5></td><td>______________</td>
					<td style="text-align: right; "><h5>Firma:</H5></td><td>____________________</td>
									
				</tr>
			</table>
</div	
	</body> 
	</html>
';
// CREACIÓN DE PDF 
$mpdf= new mPDF('c','A4','10','arial');
$mpdf->writeHTML($html);
$mpdf->Output('Referencia.pdf','I');
?>