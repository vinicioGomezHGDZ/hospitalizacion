<?php
date_default_timezone_set('America/Guayaquil');
require_once("../../../../js/lib/mpdf-6.1.3/mpdf.php");
include_once("../../../../php/class_consulta.php");
$Con=New Consulta();
$Conit=New Consulta();
$Cone=New Consulta();
$Conet=New Consulta();
$Conde=New Consulta();
$Condme=New Consulta();
$Condma=New Consulta();
$Concaocu=New Consulta();
$Concades=New Consulta();
$Concadañ=New Consulta();
$Cont24h=New Consulta();
$Cont0h=new Consulta();
$Cont0hda=new Consulta();
$conrs=new Consulta();

$serv=$_GET['s'];
$piso_sala=$_GET['p'];
$fecha=$_GET['f'];
$responsble=$_GET['res'];

// responsable //
$respon=$conrs->Get_Consulta("sgu_usu_usuario us
join sga_adm_profesional pr on us.pro_id_fk = pr.pro_id_pk
join sga_adm_persona per on pr.per_id_fk = per.per_id_pk where usu_id_pk='$responsble'","per_nombres || ' ' || per_apellidopaterno || ' ' || per_apellidomaterno as responsable , pro_codigomsp","","","",5);

$totalingreso=0;
$totalingresot=0;
$totalegresos=0;
$totalegresost=0;
$totame48h=0;
$totamas48h=0;
$camaocupada=0;
$camadesocupada=0;
$camadañada=0;
$total24h=0;$total0h=0;

// CONSULTAS DE REPORRTE
// total contar las defuncion de - de 48 horas
		$tdme=$Condme->Get_Consulta("sgh_mei_censo cen
        join sga_adm_historiaclinica his on cen.hce_id_fk=his.hce_id_pk
	 	join sga_adm_paciente as p on his.pac_id_fk=p.pac_id_pk
	 	join sga_adm_persona as pe on p.per_id_fk=pe.per_id_pk
        join sga_adm_cama as c on cen.cam_id_fk=c.cam_id_pk
		JOIN sga_adm_tipocama as tc on c.tca_serv_fk=tc.tca_id_pk
		join sga_adm_tipocama as pi on tca_piso_fk=pi.tca_id_pk
		join sga_adm_tipocama as ha on tca_habi_fk=ha.tca_id_pk where tc.tca_descripcion ='".$serv."' and pi.tca_descripcion='".$piso_sala."' and cen_def_48 = 't'  and cen_fecha='".$fecha."'","cen_fecha","","","",5);
		$totame48h=sizeof($tdme);
		print_r($tdme);

// total contar las defuncion de - de 48 horas
		$tdma=$Condma->Get_Consulta("sgh_mei_censo cen
        join sga_adm_historiaclinica his on cen.hce_id_fk=his.hce_id_pk
	 	join sga_adm_paciente as p on his.pac_id_fk=p.pac_id_pk
	 	join sga_adm_persona as pe on p.per_id_fk=pe.per_id_pk
        join sga_adm_cama as c on cen.cam_id_fk=c.cam_id_pk
		JOIN sga_adm_tipocama as tc on c.tca_serv_fk=tc.tca_id_pk
		join sga_adm_tipocama as pi on tca_piso_fk=pi.tca_id_pk
		join sga_adm_tipocama as ha on tca_habi_fk=ha.tca_id_pk where tc.tca_descripcion ='".$serv."' and pi.tca_descripcion='".$piso_sala."' and cen_def48 = 't' and cen_fecha='".$fecha."'","cen_fecha","","","",5);
		$totamas48h=sizeof($tdma);
// total camas ocupadas    
    $caoc=$Concaocu->Get_Consulta("sgh_mei_censo cen
        join sga_adm_historiaclinica his on cen.hce_id_fk=his.hce_id_pk
	 	join sga_adm_paciente as p on his.pac_id_fk=p.pac_id_pk
	 	join sga_adm_persona as pe on p.per_id_fk=pe.per_id_pk
        join sga_adm_cama as c on cen.cam_id_fk=c.cam_id_pk
		JOIN sga_adm_tipocama as tc on c.tca_serv_fk=tc.tca_id_pk
		join sga_adm_tipocama as pi on tca_piso_fk=pi.tca_id_pk
		join sga_adm_tipocama as ha on tca_habi_fk=ha.tca_id_pk where cen_tipo ='INGRESO' AND pi.tca_descripcion='".$piso_sala."' and tc.tca_descripcion ='".$serv."' and cen_visible=TRUE and cen_fecha<='".$fecha."'",
        "cen_fecha","","","",5);

	$camaocupada=sizeof($caoc);
// total camas servicio
   $cade=$Concades->Get_Consulta("sga_adm_cama  c
	join sga_adm_camaestado ce on c.ces_id_fk=ce.ces_id_pk
	JOIN sga_adm_tipocama ser on c.tca_serv_fk=ser.tca_id_pk
	join sga_adm_tipocama as pi on tca_piso_fk=pi.tca_id_pk
	WHERE ser.tca_descripcion='".$serv."' AND pi.tca_descripcion='".$piso_sala."' and cam_visible=true","ser.tca_descripcion,pi.tca_descripcion,ce.ces_descripcion","","","",5);

	$camadesocupada=sizeof($cade)-sizeof($caoc);

// total camas dañada
	$cada=$Concadañ->Get_Consulta("sga_adm_cama  c
	join sga_adm_camaestado ce on c.ces_id_fk=ce.ces_id_pk
	JOIN sga_adm_tipocama ser on c.tca_serv_fk=ser.tca_id_pk
	JOIN sga_adm_tipocama pis on c.tca_piso_fk=pis.tca_id_pk
	WHERE ser.tca_descripcion='".$serv."' AND pis.tca_descripcion='".$piso_sala."' and ce.ces_descripcion='DAÑADA' and cam_visible=true","ser.tca_descripcion,pis.tca_descripcion,ce.ces_descripcion","","","",5);
	$camadañada=sizeof($cada);				
// total a las 24 h 
      $t24h=$Cont24h->Get_Consulta("sgh_mei_censo cen
        join sga_adm_historiaclinica his on cen.hce_id_fk=his.hce_id_pk
	 	join sga_adm_paciente as p on his.pac_id_fk=p.pac_id_pk
	 	join sga_adm_persona as pe on p.per_id_fk=pe.per_id_pk
        join sga_adm_cama as c on cen.cam_id_fk=c.cam_id_pk
		JOIN sga_adm_tipocama as tc on c.tca_serv_fk=tc.tca_id_pk
		join sga_adm_tipocama as pi on tca_piso_fk=pi.tca_id_pk
		join sga_adm_tipocama as ha on tca_habi_fk=ha.tca_id_pk where cen_tipo ='INGRESO' and tc.tca_descripcion ='".$serv."' and pi.tca_descripcion='".$piso_sala."' AND cen_visible=TRUE",
		"cen_fecha","","","",5);
		$total24h=sizeof($t24h);
// total a las 0 h 
      $t0h=$Cont0h->Get_Consulta("sgh_mei_censo cen
        join sga_adm_historiaclinica his on cen.hce_id_fk=his.hce_id_pk
	 	join sga_adm_paciente as p on his.pac_id_fk=p.pac_id_pk
	 	join sga_adm_persona as pe on p.per_id_fk=pe.per_id_pk
        join sga_adm_cama as c on cen.cam_id_fk=c.cam_id_pk
		JOIN sga_adm_tipocama as tc on c.tca_serv_fk=tc.tca_id_pk
		join sga_adm_tipocama as pi on tca_piso_fk=pi.tca_id_pk
		join sga_adm_tipocama as ha on tca_habi_fk=ha.tca_id_pk where cen_tipo ='INGRESO' and tc.tca_descripcion ='".$serv."' and pi.tca_descripcion='".$piso_sala."' AND cen_visible=TRUE and cen_fecha<>'".$fecha."'",
		"cen_fecha","","","",5);
		$total0h=sizeof($t0h);
		 $total0h=sizeof($t0h)- sizeof($t0hda); 

// TOTAL A LAS 0 HORAS DEL MISMO DIA
   $t0hda=$Cont0hda->Get_Consulta("sgh_mei_censo cen
        join sga_adm_historiaclinica his on cen.hce_id_fk=his.hce_id_pk
	 	join sga_adm_paciente as p on his.pac_id_fk=p.pac_id_pk
	 	join sga_adm_persona as pe on p.per_id_fk=pe.per_id_pk
        join sga_adm_cama as c on cen.cam_id_fk=c.cam_id_pk
		JOIN sga_adm_tipocama as tc on c.tca_serv_fk=tc.tca_id_pk
		join sga_adm_tipocama as pi on tca_piso_fk=pi.tca_id_pk
		join sga_adm_tipocama as ha on tca_habi_fk=ha.tca_id_pk where cen_tipo ='INGRESO' and tc.tca_descripcion ='".$serv."' and cen_visible=false and pi.tca_descripcion='".$piso_sala."' and cen_fecha='".$fecha."'",
    "cen_fecha","","","",5);
# cargar datos de ingreso
		$ing=$Con->Get_Consulta("sgh_mei_censo cen
        join sga_adm_historiaclinica his on cen.hce_id_fk=his.hce_id_pk
	 	join sga_adm_paciente as p on his.pac_id_fk=p.pac_id_pk
	 	join sga_adm_persona as pe on p.per_id_fk=pe.per_id_pk
        join sga_adm_cama as c on cen.cam_id_fk=c.cam_id_pk
		JOIN sga_adm_tipocama as tc on c.tca_serv_fk=tc.tca_id_pk
		join sga_adm_tipocama as pi on tca_piso_fk=pi.tca_id_pk
		join sga_adm_tipocama as ha on tca_habi_fk=ha.tca_id_pk where cen_tipo ='INGRESO' and tc.tca_descripcion ='".$serv."' and pi.tca_descripcion='".$piso_sala."'  AND cen.cen_ingreso_tras IS NULL and cen_fecha='".$fecha."' AND cen_visible=TRUE",
		"(per_nombres||' '||per_apellidopaterno ||' '|| per_apellidomaterno ) as persona,per_numeroidentificacion,per_numeroidentificacion,hce_id_pk,
  		cam_codigo,tc.tca_descripcion as servicio,ha.tca_descripcion as habitacion ,pi.tca_descripcion as piso,cen_id_pk,cen_tipo,cen_ingreso_tras,cen_def_48,cen_def48,cen_fecha","","","",5);
# cargar datos de ingreso transferidos
		$ingt=$Conit->Get_Consulta("sgh_mei_censo cen
        join sga_adm_historiaclinica his on cen.hce_id_fk=his.hce_id_pk
	 	join sga_adm_paciente as p on his.pac_id_fk=p.pac_id_pk
	 	join sga_adm_persona as pe on p.per_id_fk=pe.per_id_pk
        join sga_adm_cama as c on cen.cam_id_fk=c.cam_id_pk
		JOIN sga_adm_tipocama as tc on c.tca_serv_fk=tc.tca_id_pk
		join sga_adm_tipocama as pi on tca_piso_fk=pi.tca_id_pk
		join sga_adm_tipocama as ha on tca_habi_fk=ha.tca_id_pk where cen_tipo ='INGRESO' and tc.tca_descripcion ='".$serv."' and pi.tca_descripcion='".$piso_sala."'and cen.cen_ingreso_tras='trans' and cen_fecha='".$fecha."' AND cen_visible=TRUE",

		"(per_nombres||' '||per_apellidopaterno ||' '|| per_apellidomaterno ) as persona,per_numeroidentificacion,per_numeroidentificacion,hce_id_pk,
  		cam_codigo,tc.tca_descripcion as servicio,ha.tca_descripcion as habitacion ,pi.tca_descripcion as piso,cen_id_pk,cen_tipo,cen_ingreso_tras,cen_def_48,cen_def48,cen_fecha","",
  		"","",5);
# cargar datos de egresos
		$egre=$Cone->Get_Consulta("sgh_mei_censo cen
        join sga_adm_historiaclinica his on cen.hce_id_fk=his.hce_id_pk
	 	join sga_adm_paciente as p on his.pac_id_fk=p.pac_id_pk
	 	join sga_adm_persona as pe on p.per_id_fk=pe.per_id_pk
        join sga_adm_cama as c on cen.cam_id_fk=c.cam_id_pk
		JOIN sga_adm_tipocama as tc on c.tca_serv_fk=tc.tca_id_pk
		join sga_adm_tipocama as pi on tca_piso_fk=pi.tca_id_pk
		join sga_adm_tipocama as ha on tca_habi_fk=ha.tca_id_pk where cen_tipo ='EGRESO' and tc.tca_descripcion ='".$serv."' and pi.tca_descripcion='".$piso_sala."'  AND cen.cen_ingreso_tras IS NULL and cen_fecha='".$fecha."'",

		"(per_nombres||' '||per_apellidopaterno ||' '|| per_apellidomaterno ) as persona,per_numeroidentificacion,per_numeroidentificacion,hce_id_pk,
  		cam_codigo,tc.tca_descripcion as servicio,ha.tca_descripcion as habitacion ,pi.tca_descripcion as piso,cen_id_pk,cen_tipo,cen_ingreso_tras,cen_def_48,cen_def48,cen_fecha","",
  		"","",5);
# cargar datos de egresos trans
        $egret=$Conet->Get_Consulta("sgh_mei_censo cen
        join sga_adm_historiaclinica his on cen.hce_id_fk=his.hce_id_pk
	 	join sga_adm_paciente as p on his.pac_id_fk=p.pac_id_pk
	 	join sga_adm_persona as pe on p.per_id_fk=pe.per_id_pk
        join sga_adm_cama as c on cen.cam_id_fk=c.cam_id_pk
		JOIN sga_adm_tipocama as tc on c.tca_serv_fk=tc.tca_id_pk
		join sga_adm_tipocama as pi on tca_piso_fk=pi.tca_id_pk
		join sga_adm_tipocama as ha on tca_habi_fk=ha.tca_id_pk where cen_tipo ='EGRESO' and tc.tca_descripcion ='".$serv."' and pi.tca_descripcion='".$piso_sala."'and cen.cen_ingreso_tras='trans' and cen_fecha='".$fecha."'",
		"(per_nombres||' '||per_apellidopaterno ||' '|| per_apellidomaterno ) as persona,per_numeroidentificacion,per_numeroidentificacion,hce_id_pk,
  		cam_codigo,tc.tca_descripcion as servicio,ha.tca_descripcion as habitacion ,pi.tca_descripcion as piso,cen_id_pk,cen_tipo,cen_ingreso_tras,cen_def_48,cen_def48,cen_fecha","",
  		"","",5);
# cargar datos de defunciones
		$def=$Conde->Get_Consulta("sgh_mei_censo cen
        join sga_adm_historiaclinica his on cen.hce_id_fk=his.hce_id_pk
	 	join sga_adm_paciente as p on his.pac_id_fk=p.pac_id_pk
	 	join sga_adm_persona as pe on p.per_id_fk=pe.per_id_pk
        join sga_adm_cama as c on cen.cam_id_fk=c.cam_id_pk
		JOIN sga_adm_tipocama as tc on c.tca_serv_fk=tc.tca_id_pk
		join sga_adm_tipocama as pi on tca_piso_fk=pi.tca_id_pk
		join sga_adm_tipocama as ha on tca_habi_fk=ha.tca_id_pk where cen_tipo ='DEFUNCION' and tc.tca_descripcion ='".$serv."' and pi.tca_descripcion='".$piso_sala."' and cen_fecha='".$fecha."'",
		"(per_nombres||' '||per_apellidopaterno ||' '|| per_apellidomaterno ) as persona,per_numeroidentificacion,per_numeroidentificacion,hce_id_pk,
  		cam_codigo,tc.tca_descripcion as servicio,ha.tca_descripcion as habitacion ,pi.tca_descripcion as piso,cen_id_pk,cen_tipo,cen_ingreso_tras,
			case WHEN cen_def_48 = 't' THEN 'X' END as menos48,
			case WHEN cen_def48 = 't' THEN 'X' END as mas48,
			cen_fecha","",
  		"","",5);

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
					margin:6mm 6mm 6mm 6mm ; 
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
	</htmlpageheader>

	<htmlpagefooter name="myFooter1" style="display:none">

		<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt;

	    color: #000000; font-weight: bold; font-style: italic;">
	    <tr>

	    <td width="30%">M.S.P.-S1 - Form.555/88</td>

	    <td width="30%" align="center" style="font-weight: bold; font-style: italic;"></td>

	    <td width="40%" style="text-align: right; ">CENSO DIARIO</td>

	    </tr></table>
	</htmlpagefooter>

  <div class="noheader"><br>
  <!-- primera hoja  -->
  <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt;
	    color: #000000; font-weight: bold; font-style: italic;">
	    <tr>

	    <td width="33%"><span style="font-weight: bold; font-style: italic;">
	    
	    <IMG SRC="../../../../img/logo.png" WIDTH=150 HEIGHT=50>

	    </span></td>

	    <td width="10%" align="center" style="font-weight: bold; font-style: italic;"></td>

	    <td width="50%" style="text-align: right; "><h2>HOSPITAL GENERAL SANTO DOMINGO</h2></td>

	    </tr></table>
  <br>
	<!-- cabesera-->
	<table width="100%" border=1 cellspacing="0" cellpadding="2">
		<tr>
			<th>
				<center>Especialidad</center>	
			</th>
			<th>
				<center>Sala</center>	
			</th>
			<th>
				<center>Fecha</center>	
			</th>
			
		</tr>
		<tr>	
			<td>

				<font size="2"><center>'.$serv.'<center></font>
			</td>
			<td>	
				<font size="2"><center> '.$piso_sala.'<center></font>
			</td>
			<td>
				<font size="2"><center> '.$fecha.'<center></font>
			</td>		
		</tr>
	</table>
  <!-- tabla divisora-->

  <table>
   <!-- superiors ingreso egresos-->
	<tr>
		<!-- superiors ingreso-->
		<td VALIGN="TOP" width="500">
			<table width="100%" border=1 cellspacing="0" cellpadding="3">
				<tr>
				<td colspan="3"><span style="font-weight: bold; font-style: italic;" ><H4><center><b>INGRESOS</b></center><h4></span></td>
				</tr>
				<tr>
					<td height="662" VALIGN="TOP" colspan="3">
					 	<table  width="100%" >	
					 		<tr>
					 			<th>
					 				<center>Cama</center>	
					 			</th>
					 			<th>
					 				<center>N° Hist. Clínica</center>	
					 			</th>
					 			<th>
					 				<center>Apellido y nombre </center>			
					 			</th>	
					 		</tr>
					 		';
					 		$totalingreso=sizeof($ing);
					 		for ($i=0; $i < sizeof($ing); $i++) {

			            		$html .='<tr>
				    		   		<td widt=""><center>'.$ing[$i]["cam_codigo"].'</center></td>
				    		   		<td widt=""><center>'.$ing[$i]["per_numeroidentificacion"].'</center></td>
				    		   		<td widt=""><center>'.$ing[$i]["persona"].'</center></td>
				    				</tr>';	
			          		}
				    		$html .='
				    		
					 	</table>		
					</td>
				</tr>
				<tr>
				    <th>
				    	<b>TOTAL DE INGRESOS </b>
				    </th>
				    <td>
				    	| '.$totalingreso.' |
					</td>
					<td style="text-align: right"><b>2</b></td>	
				</tr>	
			</table>
		</td>
		superiors egresos y egrreso transferea-->
		<td VALIGN="TOP" width="500">	
			<table width="100%" border=1 cellspacing="0" cellpadding="3">
				<tr>
					<td colspan="3"><span style="font-weight: bold; font-style: italic;"><H4><center><b>EGRESO </b></center><h4></span></td>
				</tr>
				<tr>
					<td height="415" VALIGN="TOP" colspan="3">
						<table  width="100%">	
					 		<tr>
					 			<th>
					 				<center>Cama</center>
					 			</th>
					 			<th>
					 				<center>N° Hist. Clínica</center>	
					 			</th>
					 			<th >
					 				<center>Apellido y nombre </center>			
					 			</th>	
					 		</tr>
					 		';
					 		$totalegresos=sizeof($egre);
					 		for ($i=0; $i < sizeof($egre); $i++) {
			            		$html .='<tr>
				    		   		<td widt=""><center>'.$egre[$i]["cam_codigo"].'</center></td>
				    		   		<td widt=""><center>'.$egre[$i]["per_numeroidentificacion"].'</center></td>
				    		   		<td widt=""><center>'.$egre[$i]["persona"].'</center></td>
				    				</tr>';	
			          		}
				    		$html .='
				    		
					 	</table>	
					</td>
				</tr>
				<tr>
				    <th>
				    	TATAL DE ALTAS
				    </th>
				    <td>
				    	| '.$totalegresos.' |
				    </td><td style="text-align: right"><b>5</b></td>	
				</tr>
			</table>		
			
			<table width="100%" border=1 cellspacing="0" cellpadding="3">
					<tr>
						<td colspan="3"><span style="font-weight: bold; font-style: italic;"><H4><center><b>TRANSFERENCIA A OTRAS ESPECIALIDADES </b></center><h4></span></td>
					</tr>
					<tr>
						<td height="200" VALIGN="TOP" colspan="3">
							<table  width="100%">	
						 		<tr>
						 			<th>
						 				<center>Cama</center>
						 			</th>
						 			<th>
						 				<center>N° Hist. Clínica</center>	
						 			</th>
						 			<th >
						 				<center>Apellido y nombre </center>			
						 			</th>	
						 		</tr>
						 		';
						 		$totalegresost=sizeof($egret);
						 		for ($i=0; $i < sizeof($egret); $i++) {
				            		$html .='<tr>
					    		   		<td widt=""><center>'.$egret[$i]["cam_codigo"].'</center></td>
					    		   		<td widt=""><center>'.$egret[$i]["per_numeroidentificacion"].'</center></td>
					    		   		<td widt=""><center>'.$egret[$i]["persona"].'</center></td>
					    				</tr>';	
				          		}
					    		$html .='
					    		
					    		</tr>
						 	</table>	
						</td>
					</tr>
					<tr>
					    			<th>
					    				Total de transferencias a otras especialidades
					    			</th>
					    			<td>| '.$totalegresost.' |</td>
					    			<td style="text-align: right"><b>6</b></td>	
					</tr>
			</table>
			
		</td>
	</tr>
  </table>

	<table>
  <!-- inferior isz transferencias-->
	<tr>
	<!-- inferior ingreso por transferencias --> 		
		<td VALIGN="TOP" width="500">
		<table width="100%"  border=1 cellspacing="0" cellpadding="3">
				<tr>
					<td colspan="3"><span style="font-weight: bold; font-style: italic;"><H4><center><b>TRANSFERENCIA DE OTRAS ESPECIALIDADES </b></center><h4></span></td>
				</tr>
				<tr>
					<td height="200" VALIGN="TOP" colspan="3">
						<table  width="100%" >	
					 		<tr>
					 			<th>
					 				<center>Cama</center>
					 			</th>
					 			<th>
					 				<center>N° Hist. Clínica</center>	
					 			</th>
					 			<th >
					 				<center>Apellido y nombre </center>			
					 			</th>	
					 		</tr>
					 		';
					 		$totalingresot=sizeof($ingt);
					 		for ($i=0; $i < sizeof($ingt); $i++) {
			            		$html .='<tr>
				    		   		<td widt=""><center>'.$ingt[$i]["cam_codigo"].'</center></td>
				    		   		<td widt=""><center>'.$ingt[$i]["per_numeroidentificacion"].'</center></td>
				    		   		<td widt=""><center>'.$ingt[$i]["persona"].'</center></td>
				    				</tr>';	
			          		}
				    		$html .='
				    		

					 	</table>	
					</td>
				</tr>
				<tr>
				    <th>
				    	Total de transferencias de otras especialidades
				    </th>
				    <td>
				    	| '.$totalingresot.' |</td>
				    <td style="text-align: right"><b>3</b></td>	
				</tr>
		    </table>
		</td>	
	<!-- inferior defucion-->
		<td VALIGN="TOP" width="500">
		<table  width="100%" border=1 cellspacing="0" cellpadding="3">
				<tr>
					<td  colspan="3"><span style="font-weight: bold; font-style: italic;"><H4><center><b>DEFUNCIONES </b></center><h4></span></td>
				</tr>
				<tr>
					<td height="200" VALIGN="TOP" colspan="3" >
						<table width="100%">	
					 		<tr>
					 			<th><center>Cama</center></th>
					 			<th><center>N° Hist. Clínica</center></th>
					 			<th><center>Apellido y nombre </center>	</th>
					 			<th><center>- 48 H</center>	</th>
					 			<th><center>+ 48 H</center>	</th>
					 			
					 		</tr>
					 		';
					 		$totadefuncion=sizeof($def);
					 		for ($i=0; $i < sizeof($def); $i++) {
			            		$html .='<tr>
				    		   		<td widt=""><center>'.$def[$i]["cam_codigo"].'</center></td>
				    		   		<td widt=""><center>'.$def[$i]["per_numeroidentificacion"].'</center></td>
				    		   		<td widt=""><center>'.$def[$i]["persona"].'</center></td>
				    		   		<td widt=""><center>'.$def[$i]["menos48"].'</center></td>
				    		   		<td widt=""><center>'.$def[$i]["mas48"].'</center></td>
				    				</tr>';	
			          		}
				    		$html .='
				    		
	
					 	</table>	
					</td>
				</tr>
				<tr>
				    <th>
				    	TOTAL DE DEFUNCIONES
				    </th>
				    <td >
				    	| '.$totame48h.' |
						'.$totamas48h.' |
				    </td>
				    <td style="text-align: right">
				    	<b>7|8</b>	
				    </td>			
				   
				</tr>
		    </table>
		</td>	
	</tr>	
	</table>



  <table width="100%">
		<tr>
			<td>
				<center>RESUMEN DEL DIA</center>	
			<td>	
		</tr>	
	</table>
	<table width="100%" border=1 cellspacing="0" cellpadding="2">
		<tr>
			<td rowspan=3>
				Existencia pacientes a las (0) horas	
			</td>
			<td colspan=2>
				<center>INGRESOS</center>
			</td>	
			<td rowspan=3>
				TOTAL	
			</td>
			<td colspan=4>
				<center>EGRESOS</center>
			</td>
			<td rowspan=3>
				<center>TOTAL</center>
			</td>
			<td rowspan=3>
				Total días de pacientes
			</td>
			<td colspan=3>	
			<center>RESUMEN DE CAMAS</center>
			</td>
			<td rowspan=3>
			CAMAS DISPONIBLES A LAS 24 HORAS
			</td>
			<td rowspan=3>
			TOTAL PACIENTES A LAS 24 HORAS
			</td>	
		</tr>
		<tr>	
			<td rowspan=2>
			Ingresos 
			</td>
			<td rowspan=2>
			Transferencia de otras especialidades 
			</td>
			<td rowspan=2>
				Altas
			</td>	
			<td rowspan=2>
				Transferencia a otras especialidades
			</td>	
			<td colspan=2>
				DEFUNCIONES
			</td>
			<td rowspan=2>
				OCUPADAS
			</td>
			<td rowspan=2>
				DESOCUPADAS
			</td>
			<td rowspan=2>
				DAÑADAS Y/O CONTAMINADAS
			</td>
		</tr>	
		<tr>
			<td>
				-48 h
			</td>

			<td>
				+48 h
			</td>
		</tr>
		<tr>
			<td></td><td></td><td></td>
			<td><center>(2+3)</center></td>
			<td></td><td></td><td></td><td></td>
			<td><center>(5+6+7+8)</center></td>
			<td><center>(1+4-6)</center></td>
			<td></td><td></td><td></td>
			<td><center>(11+12)</center></td>
			<td><center>(1+4-9)</center></td>	
		</tr>
		<tr>
			<td><center>1</center></td><td><center>2</center></td><td><center>3</center></td><td><center>4</center></td><td><center>5</center></td><td><center>6</center></td><td><center>7</center></td><td><center>8</center></td>
			<td><center>9</center></td><td><center>10</center></td><td><center>11</center></td><td><center>12</center></td><td><center>13</center></td><td><center>14</center></td><td><center>15</center></td>
		</tr>
		<tr>
	
<!--1-->	        <td><center>'.$t0h=$total0h+$totalegresos+$totalegresost+$totame48h+$totamas48h.'  </center></td>
<!--2-->			<td><center>'.$totalingreso.'</center></td>			
<!--3-->			<td><center>'.$totalingresot.'  </center></td>
<!--4-->			<td><center>'.$ti=$totalingreso+$totalingresot.'  </center></td>
<!--5-->			<td><center>'.$totalegresos.'  </center></td>			
<!--6-->			<td><center>'.$totalegresost.'  </center></td>
<!--7-->			<td><center> '.$totame48h.'  </center></td>
<!--8-->			<td><center> '.$totamas48h.' </center></td>			
<!--9-->			<td><center> '.$te=$totalegresos+$totalegresost+$totame48h+ $totamas48h.'</center></td>
<!--10-->			<td><center> '.$tdia=($totalingreso+$totalingresot + $total0h+$totalegresos+$totalegresost+$totame48h+$totamas48h)-$totalegresost.' </center></td>
<!--11-->			<td><center> '.$camaocupada.' </center></td>			
<!--12-->			<td><center> '.$camadesocupada.' </center></td>	
<!--13-->			<td><center> '.$camadañada.'</center></td>
<!--14-->			<td><center> '.$dis=$camaocupada+$camadesocupada.' </center></td>			
<!--15-->			<td><center>'.$total24h=$total0h+$totalegresos+$totalegresost+$totame48h+$totamas48h+$totalingreso+$totalingresot-($totalegresos+$totalegresost+$totame48h+ $totamas48h).'  </center></td>						
		</tr>
		<tr>
			<td colspan=11> 
				<font size=2>La presente información es de total responsabilidad del servicio de enfermería y la anotación deberá hacerse simultaneamente con el ingreso y/o egreso y entregarce a las 8 de la mañana a la oficina de estadisticas y registros Médicos (Sección Procedamiento de Datos).<br>
				Transferir l columna "15" a la "1". del censo del siguiente día.
				</font>	
			</td>
			<td colspan=4> 
				 FIRMA DE LA ENFERMERA : <font size="1">'.$respon[0]["responsable"].' '.$respon[0]["pro_codigomsp"].'</font>  
			</td>
		</tr>	
  </table>
			
	</body> 
	</html>
';
// CREACIÓN DE PDF 
$mpdf= new mPDF('c','A4');
$mpdf->writeHTML($html);
$mpdf->Output('Censo diario '.$fecha.'.pdf','I');

?>