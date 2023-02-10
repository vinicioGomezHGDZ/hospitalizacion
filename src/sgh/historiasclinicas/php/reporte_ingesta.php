<?php
require_once("../../../../js/lib/mpdf-6.1.3/mpdf.php");
include_once("../../../../php/class_consulta.php");
$Conesg=New Consulta();

$idhc=$_GET['h'];

$esger=$Conesg->Get_Consulta("sgh_mei_ingrelimi where hce_id_fk='".$idhc."' order by cie_fecha desc",
    "cie_fecha","","","",6);



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
					 margin:3mm 5mm 5mm 5mm ;
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

	    <td width="30%"><span style="font-weight: bold; font-style: italic;"></td>

	    <td width="30%" align="center" style="font-weight: bold; font-style: italic;"></td>

	    <td width="40%" style="text-align: right; "></td>

	    </tr></table>
	</htmlpagefooter>
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

    $fecha=$esger[$r][cie_fecha];

    $Con='Con'.$r;
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

    $$Con=New Consulta();
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
    $per=$$Con->Get_Consulta("sgh_mei_ingrelimi ep
		join sga_adm_historiaclinica as h on ep.hce_id_fk=h.hce_id_pk
		join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
		join sga_adm_persona as  per on p.per_id_fk=per.per_id_pk
    jOIN sga_adm_cama as ca on ep.cam_id_fk= ca.cam_id_pk
    join sga_adm_tipocama as hab on ca.tca_habi_fk =hab.tca_id_pk
    join sga_adm_tipocama as pis on ca.tca_piso_fk =pis.tca_id_pk
		join sga_adm_tipocama as ser on ca.tca_serv_fk =ser.tca_id_pk
		"," hce_numerohc,per_nombres || '' ||per_apellidopaterno ||' '|| coalesce(per_apellidomaterno,'')  as paciente,
  'Cuarto ' ||hab.tca_descripcion || ' Cama ' ||ca.cam_codigo as cuca ,ser.tca_descripcion as servicio",
        "","hce_id_fk",$idhc,2);
    $html .= '
<div class="noheader">
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
			   <font size=1 >'.$resmalic[0]["resposable"].' '.$resmalic[0]["pro_codigomsp"].' </font>
			<td>
		    <td>
                    <font size=3><b>Firma y función: </b></font> 
                    <font size=1><b>'.$resmaaxi[0]["resposable"].' </b></font> 
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
        $html.='
                    <tr>
                       <td><center><font size=1>'.$moral[$i]["cie_hora"].'</font><center></td>
                       <td><center><font size=1>'.$moral[$i]["cie_clase"].'</font></center></td>
                       <td><center><font size=1>'.$moral[$i]["cie_cantcc"].'</font></center></td>
                    </tr>';
    }

    $html.='
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
        $html.='

                   <tr>
                      <td><center><font size=1>'.$mparental[$i]["cie_clase"].'</font></center></td>
                      <td><center><font size=1>'.$mparental[$i]["cie_cantcc"].'</font></center></td>
                      <td><center><font size=1>'.$mparental[$i]["cie_canabs"].'</font></center></td>
                    </tr>
                    ';
    }

    $html.='
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
        $html.='
                    <tr>
                       <td><center><font size=1>'.$morina[$i]["cie_clase"].'</font></center></td>
                       <td><center><font size=1>'.$morina[$i]["cie_cantcc"].'</font></center></td>
                    </tr>';
    }

    $html.='
                     
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
        $html.='
                    <tr>
                       <td><center><font size=1>'.$motros[$i]["cie_clase"].'</font></center></td>
                       <td><center><font size=1>'.$motros[$i]["cie_cantcc"].'</font></center></td>
                    </tr>';
    }

    $html.='
                     
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
			   <font size=3><b>Firma y función: </b></font> <font size=1 >'.$restalic[0]["resposable"].' '.$resmalic[0]["pro_codigomsp"].'</font>
			</td>
                <td colspan="7">
                    <font size=3><b>Firma y función: </b></font> 
                    <font size=1><b>'.$restaaxi[0]["resposable"].' </b></font> 
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
        $html.='
                    <tr>
                       <td><center><font size=1>'.$toral[$i]["cie_hora"].'</font><center></td>
                       <td><center><font size=1>'.$toral[$i]["cie_clase"].'</font></center></td>
                       <td><center><font size=1>'.$toral[$i]["cie_cantcc"].'</font></center></td>
                    </tr>';
    }

    $html.='
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
        $html.='

                   <tr>
                      <td><center><font size=1>'.$tparental[$i]["cie_clase"].'</font></center></td>
                      <td><center><font size=1>'.$tparental[$i]["cie_cantcc"].'</font></center></td>
                      <td><center><font size=1>'.$tparental[$i]["cie_canabs"].'</font></center></td>
                    </tr>
                    ';
    }

    $html.='
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
        $html.='
                    <tr>
                       <td><center><font size=1>'.$torina[$i]["cie_clase"].'</font></center></td>
                       <td><center><font size=1>'.$torina[$i]["cie_cantcc"].'</font></center></td>
                    </tr>';
    }

    $html.='
                     
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
        $html.='
                    <tr>
                       <td><center><font size=1>'.$totros[$i]["cie_clase"].'</font></center></td>
                       <td><center><font size=1>'.$totros[$i]["cie_cantcc"].'</font></center></td>
                    </tr>';
    }

    $html.='
                     
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
			   <font size=1 >'.$resnoalic[0]["resposable"].' '.$resnoalic[0]["pro_codigomsp"].' </font>
			   
			  
			</td>
            <td>
                 <font size=3><b>Firma y función: </b></font> 
               <font size=1><b>'.$resnoaxi[0]["resposable"].' </b></font> 
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
        $html.='
                    <tr>
                       <td><center><font size=1>'.$noral[$i]["cie_hora"].'</font><center></td>
                       <td><center><font size=1>'.$noral[$i]["cie_clase"].'</font></center></td>
                       <td><center><font size=1>'.$noral[$i]["cie_cantcc"].'</font></center></td>
                    </tr>';
    }

    $html.='
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
        $html.='

                   <tr>
                      <td><center><font size=1>'.$nparental[$i]["cie_clase"].'</font></center></td>
                      <td><center><font size=1>'.$nparental[$i]["cie_cantcc"].'</font></center></td>
                      <td><center><font size=1>'.$nparental[$i]["cie_canabs"].'</font></center></td>
                    </tr>
                    ';
    }

    $html.='
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
        $html.='
                    <tr>
                       <td><center><font size=1>'.$norina[$i]["cie_clase"].'</font></center></td>
                       <td><center><font size=1>'.$norina[$i]["cie_cantcc"].'</font></center></td>
                    </tr>';
    }

    $html.='

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
        $html.='
                    <tr>
                       <td><center><font size=1>'.$notros[$i]["cie_clase"].'</font></center></td>
                       <td><center><font size=1>'.$notros[$i]["cie_cantcc"].'</font></center></td>
                    </tr>';
    }

    $html.='

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

    $html.='
                       
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

    $html.='
                       
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
                 ENFERMERÍA<br> 
                '.$per[0]["servicio"].'<br>  
                '.$per[0]["paciente"].'<br> 
                '.$per[0]["cuca"].'<br>
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
	            <font size="3">Firma y funciòn: '.$resnoalic[0]["resposable"].' '.$resnoalic[0]["pro_codigomsp"].'</font><font size="2"></font>
	        </td>
	    </tr>
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
$mpdf->Output('Ingesta e Eliminación.pdf','I');
?>