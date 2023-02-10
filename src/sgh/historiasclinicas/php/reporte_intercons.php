<?php
require_once("../../../../js/lib/mpdf-6.1.3/mpdf.php");
include_once("../../../../php/class_consulta.php");
$Coninter=New Consulta();

$hce_id_fk=$_GET['h'];

// CONSULTAS DE REPORRTE

$inter=$Coninter->Get_Consulta("sgh_mei_intercsol WHERE hce_id_fk='".$hce_id_fk."' ORDER BY hce_id_fk DESC","int_id_pk,int_fecha","","","",5);


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
	<htmlpageheader name="myHeader1" style="display:none">
	<!-- datos paciente -->	
	
	</htmlpageheader>

	<htmlpagefooter name="myFooter1" style="display:none">

		<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt;

	    color: #000000; font-weight: bold; font-style: italic;">SNS-MSP / HCU-form.006 / 2008

	    <tr>

	    <td width="33%"><span style="font-weight: bold; font-style: italic;">SNS-MSP / HCU-form.007 / 2008</span></td>

	    <td width="33%" align="center" style="font-weight: bold; font-style: italic;"></td>

	    <td width="33%" style="text-align: right; ">INTERCONSULTA - SOLICITUD </td>

	    </tr></table>
	</htmlpagefooter>

	<htmlpageheader name="Chapter2HeaderOdd" style="display:none">
		<!-- datos paciente -->	


	</htmlpageheader>

	<htmlpagefooter name="Chapter2FooterOdd" style="display:none">

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
    $Con='Con'.$r;
    $Conint='Conint'.$r;
    $ConDI='ConDI'.$r;
    $Consol='Consol'.$r;
    $ConDIin='ConDIin'.$r;

    $$Con=New Consulta();
    $$Conint=New Consulta();
    $$ConDI=New Consulta();
    $$Consol=New Consulta();
    $$ConDIin=new Consulta();
    $int_id_pk=$inter[$r]["int_id_pk"];
    # CARGAR DATOS DE ENCABEZADO. array 0
    $per=$$Con->Get_Consulta("sgh_mei_intercsol ep
		join sga_adm_historiaclinica as h on ep.hce_id_fk=h.hce_id_pk
		join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
		join sga_adm_persona as  per on p.per_id_fk=per.per_id_pk
		JOIN sga_adm_sexo as se on se.sex_id_pk=per.sex_id_fk","per_nombres,(per_apellidopaterno ||' '|| coalesce(per_apellidomaterno,'') ) as apellido,
			date_part('year',age(per_fechanacimiento)) as Edad,per_numeroidentificacion,sex_codigo as per_sexo","","int_id_pk",$int_id_pk,2);

    # CARGAR DATOS GENERALES
    $int=$$Conint->Get_Consulta("sgh_mei_intercsol as int
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
per_nombres || ' ' ||per_apellidopaterno ||' '|| coalesce(per_apellidomaterno,'')  as medicres,pro.pro_codigomsp,int.int_fecha",
        "","int.int_id_pk",$int_id_pk,2);
    //print_r($epic);

    # CARGAR DIAGNOSTICO INGRESO
    $dia=$$ConDI->Get_Consulta("sgh_mei_interdia join sgh_mei_diagnos as d on dia_id_fk=d.dia_id_pk 
    JOIN sgh_mei_codigocie10 as c10  on d.c10_id_fk=c10.c10_id_pk where int_id_fk='".$int_id_pk."'","c10_nombre AS detalle,
			c10_codigo as cie,
			sgh_conbiertepre('1',dia_resp) as pre,
			sgh_conbiertepre('2',dia_resp) as def",
        "","","",6);
    //print_r ($DiagI);
    # CARGAR DATOS GENERALES  INFORME
    $sol=$$Consol->Get_Consulta("sgh_mei_intercsol as inf
    join sgh_mei_intercsol sol on inf.int_id_fk=sol.int_id_pk
    join sgu_usu_usuario us on sol.usu_id_fk=us.usu_id_pk
    join sga_adm_profesional pro on us.pro_id_fk=pro.pro_id_pk
    join sga_adm_persona per on pro.per_id_fk=per.per_id_pk
            ","inf.int_cucint,inf.int_plandia,inf.int_pltrap,inf.int_recrcl,
per_nombres || ' ' ||per_apellidopaterno ||' '|| coalesce(per_apellidomaterno,'')  as medicres,pro.pro_codigomsp,sol.int_fecha",
        "","sol.int_id_pk",$int_id_pk,2);
# CARGAR DIAGNOSTICO INGRESO  solicitud
    $diainf=$$ConDIin->Get_Consulta("sgh_mei_intercsol as inf
    join sgh_mei_intercsol sol on inf.int_id_fk=sol.int_id_pk
    join sgh_mei_interdia diai on diai.int_id_fk=inf.int_id_pk
    join sgh_mei_diagnos as d on diai.dia_id_fk=d.dia_id_pk
    JOIN sgh_mei_codigocie10 as c10  on d.c10_id_fk=c10.c10_id_pk where sol.int_id_pk='".$int_id_pk."'","c10_nombre AS detalle,
			c10_codigo as cie,
			sgh_conbiertepre('1',dia_resp) as pre,
			sgh_conbiertepre('2',dia_resp) as def",
        "","","",6);
$html.='
	<div class="noheader">
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
	              <td><center><font size=1>HOSPITAL GENERAL SANTO DOMINGO</font></center></td>
	              <td><center><font size=1>'.$per[0]["per_nombres"].'</font></center></td>
	              <td><center><font size=1>'.$per[0]["apellido"].'</font></center></td>
	              <td><center><font size=1>'.$per[0]["per_sexo"].'</font></center></td>
	              <td><center><font size=1>'.$per[0]["edad"].'</font></center></td>
	              <td><center><font size=1>'.$per[0]["per_numeroidentificacion"].'</font></center></td>   
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
			<td height="20" width="80"><font size="2"><center>'.$int[0]["tca_descripcion"].'<center></font></td>
			<td width="100"><center><h6>SERVICIO QUE SOLICITA</h6></center></td>
			<td height="20" width="80"><font size=2><center>'.$int[0]["mds_sersol"].'</center></font></td>
		    <td width="30"><center><h6>SALA</h6></center></td>
			<td height="20" width="30"><font size=2><center>'.$int[0]["sala"].'</center></font></td>
			<td width="30"><center><h6>CAMA</h6></center></td>
			<td height="20" width="30"><font size=2><center>'.$int[0]["cama"].'</center></font></td>
		</tr>
		<tr>
		   <td width="80"><center><h6>NORMAL</h6></center></td>
		   <td height="20" width="30"><font size=2><center>'.$int[0]["noramal"].'</center></font></td>
		   <td width="80"><center><h6>URGENTE</h6></center></td>
		   <td height="20" width="30"><font size=2><center>'.$int[0]["urgente"].'</center></font></td>
   			<td width=""><center><h6>MEDICO INTERCONSULTA</h6></center></td>
   		<td height="20" width="30" colspan="5"><font size=2><center>'.$int[0]["mds_medico"].'</center></font></td>
		<tr>
	</table><br>
	
	
	<table border="1" width="100%" cellspacing="0" cellpadding="2">
		<tr>
		<td width="33%" class="th"><span style="font-weight: bold; font-style: italic;"><H4><b>2. CUADRO CLÍNICIO</b><h4></span></td>
		</tr>
		<tr>
			<td height="200" VALIGN="TOP">
			    <H6>'.$int[0]["int_cuclia"].'</H6>
			</td>
		</tr>
	</table><br>
	<table border="1" width="100%" cellspacing="0" cellpadding="2">
		<tr>
			<td width="33%" class="th"><span style="font-weight: bold; font-style: italic;"><H4><b>3. RESUMEN DE EXÁMENES Y PROCEDIMIENTOS DIAGNÓSTICOS</b><h4></span></td>
		</tr>
		<tr>
			<td height="150" VALIGN="TOP">
				<H6>'.$int[0]["int_resexa"].'</H6>
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
            		$html .='<tr>
	    		   	<td width="15" height="16"><font size="2"><center>'.$id.'</center></font></td>
		    		<td height="16"><font size="2">'.$dia[$i]["detalle"].'</font></td>
		    		<td width="20" height="16"><font size="2"><center>'.$dia[$i]["cie"].'</center></font></td>
		    		<td width="20" height="16"><font size="2"><center>'.$dia[$i]["pre"].'</center></font></td>
		    		<td width="20" height="16"><font size="2"><center>'.$dia[$i]["def"].'</center></font></td>
	    				</tr>';	
          		}
	    		$html .='
		  	</table><br>
	<table border="1" width="100%" cellspacing="0" cellpadding="2">
		<tr>
		 <td width="33%" class="th"><span style="font-weight: bold; font-style: italic;"><H4><b>5. PLANES DE DIAGNÓSTICO TERAPEÚTICOS Y EDUCACIONAL REALIZADOS</b><h4></span></td>
			h4></td>
		</tr>
		<tr>
			<td height="200" VALIGN="TOP">
			    <H6>'.$int[0]["int_planes"].'</H6>
			</td>
		</tr>

	</table> <br>
	  <table width="100%" border="1" cellspacing="0"> 
		<tr>
			<td width="5" class="th"><font size=3>SERVICIO</font></td> <td width="150"><font size="1">'.$int[0]["servisio"].''.$int[0]["int_fecha"].'</font></td>
			<td width="95" class="th"><font size=3>MEDICO</font></td><td width="150"><center><font size="1">'.$int[0]["medicres"].'</font></center></td>
			<td width="50"> <center><font size="1">'.$int[0]["pro_codigomsp"].'</center></td>
			<td width="30" class="th"><font size=3>FIRMA</font></td>  <td width="151"></td>
		<tr>
	</table>
</div>
	
<!-- 2 hoja  -->	
	<div class="chapter2">
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
	              <td><center><font size=1>HOSPITAL GENERAL SANTO DOMINGO</font></center></td>
	              <td><center><font size=1>'.$per[0]["per_nombres"].'</font></center></td>
	              <td><center><font size=1>'.$per[0]["apellido"].'</font></center></td>
	              <td><center><font size=1>'.$per[0]["per_sexo"].'</font></center></td>
	              <td><center><font size=1>'.$per[0]["edad"].'</font></center></td>
	              <td><center><font size=1>'.$per[0]["per_numeroidentificacion"].'</font></center></td>   
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
	    	<td height="200" VALIGN="TOP"> <font size="1">'.$sol[0]["int_cucint"].'</font></td>
	    </tr>
          	
	</table>
	<br>

	<table border="1" width="100%" cellspacing="0" >
		<tr>
	     <td width="33%" class="th"><span style="font-weight: bold; font-style: italic;"><H4><b>7. PLAN DE DIAGNÓSTICOS PROPUESTOS</b><h4></span></td>
			h4></td>	
		</tr>
		<tr>
		 	<td height="150" VALIGN="TOP"> <font size="1">'.$sol[0]["int_plandia"].'</font></td>
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
            		$html .='<tr>
	    		   	<td width="15" height="16"><font size="2"><center>'.$id.'</center></font></td>
		    		<td height="16"><font size="2">'.$diainf[$i]["detalle"].'</font></td>
		    		<td width="20" height="16"><font size="2"><center>'.$diainf[$i]["cie"].'</center></font></td>
		    		<td width="20" height="16"><font size="2"><center>'.$diainf[$i]["pre"].'</center></font></td>
		    		<td width="20" height="16"><font size="2"><center>'.$diainf[$i]["def"].'</center></font></td>
	    				</tr>';	
          		}
	    		$html .='
		  	</table><br>
	
	<table width="100%" border="1" cellspacing="0"> 
		<tr>
			<td  class="th" ><span style="font-weight: bold; font-style: italic;">
			9. PLAN DE TRATAMIENTO PROPUESTO</spant>
			</td>
		</tr>
		<tr>
	    	<td height="100" VALIGN="TOP"> <font size="1">'.$sol[0]["int_pltrap"].'</font></td>
	    </tr>
		
	</table>
	<br>
		<table border="1" width="100%" cellspacing="0" >
		<tr>
	     <td width="33%" class="th"><span style="font-weight: bold; font-style: italic;"><H4><b>10. RESUMEN DE CRITERIO CLÍNICIO</b><h4></span></td>
			h4></td>	
		</tr>
		<tr>
	    	<td height="150" VALIGN="TOP"> <font size="1">'.$sol[0]["int_recrcl"].'</font></td>
	    </tr>
	</table><br>
	<table width="100%" border="1" cellspacing="0"> 
		<tr>
		<td width="5" class="th"><font size=3>SERVICIO</font></td> <td width="150"><font size="1">'.$int[0]["servisio"].' - '.$sol[0]["int_fecha"].'</font></td>
			<td width="95" class="th"><font size=3>MEDICO</font></td><td width="150"><center><font size="1">'.$sol[0]["medicres"].'</font></center></td>
			<td width="50"> <center><font size="1">'.$sol[0]["pro_codigomsp"].'</center></td>
			<td width="30" class="th"><font size=3>FIRMA</font></td>  <td width="151"></td>
			
		<tr>
	</table>

	</div>
	';
}
$html.='
	</body> 
	</html>
';

// CREACIÓN DE PDF 
$mpdf= new mPDF('c','A4','','arial');
$mpdf->writeHTML($html);
$mpdf->Output('Interconsulta.pdf','I');
?>