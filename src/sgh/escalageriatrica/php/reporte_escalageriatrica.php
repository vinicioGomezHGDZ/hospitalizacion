<?php

require_once '../../../../vendor/autoload.php';

use Mpdf\Mpdf;

include_once("../../../../php/class_consulta.php");
$Con = new Consulta();
$Conta = new Consulta();
$Concr = new Consulta();
$Conai = new Consulta();
$Conab = new Consulta();
$Conde = new Consulta();
$Connu = new Consulta();
$esg_id_pk = $_GET['c'];


$per = $Con->Get_Consulta("sgh_mei_escgeria ep
		join sga_adm_historiaclinica as h on ep.hce_id_fk=h.hce_id_pk
		join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
		join sga_adm_persona as  per on p.per_id_fk=per.per_id_pk
       JOIN sga_adm_sexo as se on se.sex_id_pk=per.sex_id_fk", "per_nombres,(per_apellidopaterno ||' '|| per_apellidomaterno ) as apellido,
			date_part('year',age(per_fechanacimiento)) as Edad,hce_numerohc,sex_codigo as per_sexo,per_numeroidentificacion", "", "esg_id_pk", $esg_id_pk, 2);
# CARGAR DATOS DE congnitivo y resurso social
$esg = $Concr->Get_Consulta("sgh_mei_escgeria
join sgu_usu_usuario usu on usu_id_fk=usu.usu_id_pk
join sga_adm_profesional  pr on usu.pro_id_fk=pr.pro_id_pk
join sga_adm_persona per on pr.per_id_fk=per.per_id_pk", "esg_fecha,esg_sabfec,esg_apnobj,esg_renual,esg_tompap,esg_repser,esg_copdib,esg_viveco,esg_reconso,esg_apreso,
  per_nombres || ' ' ||per_apellidopaterno ||' '|| per_apellidomaterno responsable", "", "esg_id_pk", $esg_id_pk, 2);
# CARGAR DATOS DE tamizaje rapido
$tami = $Conta->Get_Consulta("sgh_mei_escalpro
					join sgh_mei_respuesta as res on pat_id_fk=res.pat_id_pk where pat_punto='TAMIZAJE' AND esg_id_fk=" . $esg_id_pk . "ORDER BY pat_item", "pat_id_pk,
  CASE WHEN pat_result='SI' THEN 'X' END as si,
  CASE WHEN pat_result='NO' THEN 'X' END as no,
  pat_item,pat_punto", "", "", "", 5);
# CARGAR DATOS DE ACTIVIDAD INSTRUMENTAL
$aci = $Conai->Get_Consulta("sgh_mei_escalpro
					join sgh_mei_respuesta as res on pat_id_fk=res.pat_id_pk where pat_punto='ACTIVIDADES INSTRUMENTAL' AND esg_id_fk=" . $esg_id_pk . "ORDER BY pat_item", "CASE WHEN pat_result='DEPENDIENTE' THEN 'X' END as DE,
  CASE WHEN pat_result='CON AYUDA' THEN 'X' END as CA,
  CASE WHEN pat_result='INDEPENDIENTE' THEN 'X' END as in,pat_item,
  pat_punto", "", "", "", 5);

# CARGAR DATOS DE ACTIVIDAD BÁSICA
$acb = $Conab->Get_Consulta("sgh_mei_escalpro
					join sgh_mei_respuesta as res on pat_id_fk=res.pat_id_pk where pat_punto='ACTIVIDADES BÁSICAS' AND esg_id_fk=" . $esg_id_pk . "ORDER BY pat_item", "CASE WHEN pat_result='DEPENDIENTE' THEN 'X' END as DE,
  CASE WHEN pat_result='CON AYUDA' THEN 'X' END as CA,
  CASE WHEN pat_result='INDEPENDIENTE' THEN 'X' END as in,pat_item,
  pat_punto", "", "", "", 5);
# CARGAR DATOS DE depresión
$dep = $Conde->Get_Consulta("sgh_mei_escalpro
					join sgh_mei_respuesta as res on pat_id_fk=res.pat_id_pk where pat_punto='DEPRESIÓN' AND esg_id_fk=" . $esg_id_pk . "ORDER BY pat_item", "CASE WHEN pat_result='SI' THEN 'X' END as si,
 					 CASE WHEN pat_result='NO' THEN 'X' END as no,pat_item,
  pat_punto,CASE WHEN pat_result='SI' THEN '1' END as ts", "", "", "", 5);

# CARGAR DATOS DE depresión
$nut = $Connu->Get_Consulta("sgh_mei_escalpro
					join sgh_mei_respuesta as res on pat_id_fk=res.pat_id_pk where pat_punto='NUTRICIONAL' AND esg_id_fk=" . $esg_id_pk . "ORDER BY pat_item", "CASE WHEN pat_result='AUSENTE' THEN 'X' END as au,
 CASE WHEN pat_result='MODERADA' THEN 'X' END as mo,
 CASE WHEN pat_result='SEVERA' THEN 'X' END as se,
  pat_result,
 CASE WHEN pat_result='VA A FUERA' THEN 'X' END as va,
 CASE WHEN pat_result='SE LEVANTA NO SALE' THEN 'X' END as sl,
 CASE WHEN pat_result='CAMA-SILLA' THEN 'X' END as cs,

 CASE WHEN pat_result='SI' THEN 'X' END as si,
 CASE WHEN pat_result='NO' THEN 'X' END as no,
  CASE WHEN pat_result='AUSENTE' THEN '3' END as tau,
 CASE WHEN pat_result='MODERADA' THEN '2' END as tmo,
 CASE WHEN pat_result='SEVERA' THEN '1' END as tse,
 CASE WHEN pat_result='VA A FUERA' THEN '3' END as tva,
 CASE WHEN pat_result='SE LEVANTA NO SALE' THEN '2' END as tsl,
 CASE WHEN pat_result='CAMA-SILLA' THEN '1' END as tcs,
 CASE WHEN pat_result='SI' THEN '1' END as tsi,
  pat_punto", "", "", "", 5);

/*print_r($per); echo '';
print_r($esg); echo '';
print_r($tami); echo '';
print_r($aci); echo '';
print_r($acb); echo '';
print_r($dep); echo '';
print_r($nut); echo '';
die();*/
//print_r($esg); die();

$style = '<style>
    body,table {
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        font-size: 8pt;
    }

    .table {
        border-collapse: collapse;
        text-align: left;
        width: 100%;
    }

    .table th, .table td {
        border: 1px solid black;
        font-weight: normal;
    }

    .table-center {
        text-align: center;
    }

    .table-left th, .table-left td {
        text-align: center;
    }

</style>   
';

$html = '
        <div style="page-break-inside: avoid" >
        <table class="table table-center">
        <thead>
          <tr>
            <th>ESTABLECIMIENTO</th>
            <th>NOMBRE Y APELLIDO DEL ADULTO MAYOR</th>
            <th>NOMBRE Y APELLIDO DEL CUIDADOR</th>
            <th>EDAD</th>
            <th>SEXO</th>
            <th>NRO. HISTORIA CLÍNICA</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>HOSPITAL GENERAL DR. GUSTAVO DOMINGUEZ ZAMBRANO</td>
            <td>' . $per[0]["per_nombres"] . '</td>
            <td></td>
            <td>' . $per[0]["edad"] . '</td>
            <td>' . $per[0]["per_sexo"] . '</td>
            <td>' . $per[0]["per_numeroidentificacion"] . '</td>
          </tr>
        </tbody>
        </table>
        
        <table width="100%">
        <thead>
          <tr>
            <th colspan="3">11 ESCALAS GERIÁTRICAS (PRIMER SEMESTRE)</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td style="width: 33%" valign="top">
             <table class="table" >
                <thead>
                  <tr>
                    <th>TAMIZAJE RÁPIDO</th>
                    <th>SI</th>
                    <th>NO</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>DIFICULTAD VISUAL</td>
                    <td>' . $tami[1]["si"] . '</td>
                    <td>' . $tami[1]["no"] . '</td>
                  </tr>
                  <tr>
                    <td>DIFICULTAD AUDITIVA</td>
                    <td>' . $tami[0]["si"] . '</td>
                    <td>' . $tami[0]["no"] . '</td>
                  </tr>
                  <tr>
                    <td>PRUEBA DE "LEVÁNTATE Y ANDA" MAYOR A 15 SEG.</td>
                    <td>' . $tami[2]["si"] . '</td>
                    <td>' . $tami[2]["no"] . '</td>
                  </tr>
                  <tr>
                    <td>PÉRDIDA INVOLUNTARIA DE ORINA</td>
                    <td>' . $tami[4]["si"] . '</td>
                    <td>' . $tami[4]["no"] . '</td>
                  </tr>
                  <tr>
                    <td>PÉRDIDA DE PESO MAYOR A 4.5KG EN 6 MESES</td>
                    <td>' . $tami[5]["si"] . '</td>
                    <td>' . $tami[5]["no"] . '</td>
                  </tr>
                  <tr>
                    <td>PÉRDIDA DE MEMORIA RECIENTE</td>
                    <td>' . $tami[3]["si"] . '</td>
                    <td>' . $tami[3]["no"] . '</td>
                  </tr>
                  <tr>
                    <td>SE SIENTE TRISTE O DEPRIMIDO</td>
                    <td>' . $tami[8]["si"] . '</td>
                    <td>' . $tami[8]["no"] . '</td>
                  </tr>
                  <tr>
                    <td>PUEDE BAÑARSE SOLO</td>
                    <td>' . $tami[6]["si"] . '</td>
                    <td>' . $tami[6]["no"] . '</td>
                  </tr>
                  <tr>
                    <td>SALE DE COMPRAS SOLO</td>
                    <td>' . $tami[7]["si"] . '</td>
                    <td>' . $tami[7]["no"] . '</td>
                  </tr>
                  <tr>
                    <td>VIVE SOLO</td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td>FECHA</td>
                    <td colspan="2">' . $esg[0]["esg_fecha"] . '</td>
                  </tr>
                  <tr>
                    <td>RESPONSABLE</td>
                    <td colspan="2">' . $esg[0]["responsable"] . '</td>
                  </tr>
                </tbody>
                </table>
                
                <table class="table" autosize="1">
                    <thead>
                      <tr>
                        <th>ACTIVIDADES BASICAS</th>
                        <th>I</th>
                        <th>A</th>
                        <th>D</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>SE BAÑA</td>
                        <td>' . $acb[4]["in"] . '</td>
                        <td>' . $acb[4]["ca"] . '</td>
                        <td>' . $acb[4]["de"] . '</td>
                      </tr>
                      <tr>
                        <td>SE VISTE Y SE DESVISTE</td>
                        <td>' . $acb[7]["in"] . '</td>
                        <td>' . $acb[7]["ca"] . '</td>
                        <td>' . $acb[7]["de"] . '</td>
                      </tr>
                      <tr>
                        <td>CUIDA SU APARIENCIA PERSONAL</td>
                        <td>' . $acb[2]["in"] . '</td>
                        <td>' . $acb[2]["ca"] . '</td>
                        <td>' . $acb[2]["de"] . '</td>
                      </tr>
                      <tr>
                        <td>UTILIZA EL INODORO</td>
                        <td>' . $acb[6]["in"] . '</td>
                        <td>' . $acb[6]["ca"] . '</td>
                        <td>' . $acb[6]["de"] . '</td>
                      </tr>
                      <tr>
                        <td>CONTROLA ESFINTERES</td>
                        <td>' . $acb[1]["in"] . '</td>
                        <td>' . $acb[1]["ca"] . '</td>
                        <td>' . $acb[1]["de"] . '</td>
                      </tr>
                      <tr>
                        <td>SE TRASLADA, SE ACUESTA, SE LEVANTA</td>
                        <td>' . $acb[5]["in"] . '</td>
                        <td>' . $acb[5]["ca"] . '</td>
                        <td>' . $acb[5]["de"] . '</td>
                      </tr>
                      <tr>
                        <td>CAMINA</td>
                        <td>' . $acb[0]["in"] . '</td>
                        <td>' . $acb[0]["ca"] . '</td>
                        <td>' . $acb[0]["de"] . '</td>
                      </tr>
                      <tr>
                        <td>SE ALIMENTA</td>
                        <td>' . $acb[3]["in"] . '</td>
                        <td>' . $acb[3]["ca"] . '</td>
                        <td>' . $acb[3]["de"] . '</td>
                      </tr>
                      <tr>
                        <td>FECHA</td>
                        <td colspan="3">' . $esg[0]["esg_fecha"] . '</td>
                      </tr>
                      <tr>
                        <td>RESPONSABLE</td>
                        <td colspan="3">' . $esg[0]["responsable"] . '</td>
                      </tr>
                    </tbody>
                    </table>
            </td>
            
            <td style="width: 33%" valign="top">
            
            <table class="table" autosize="1">
                <thead>
                  <tr>
                    <th>ACTIVIDAD INSTRUMENTAL</th>
                    <th>I</th>
                    <th>A</th>
                    <th>D</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>CUIDA LA CASA</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td>LAVA LA ROPA</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td>PREPARA LA COMIDA</td>
                    <td>' . $aci[2]["in"] . '</td>
                    <td>' . $aci[2]["ca"] . '</td>
                    <td>' . $aci[2]["de"] . '</td>
                  </tr>
                  <tr>
                    <td>VA DE COMPRAS</td>
                    <td>' . $aci[5]["in"] . '</td>
                    <td>' . $aci[5]["ca"] . '</td>
                    <td>' . $aci[5]["de"] . '</td>
                  </tr>
                  <tr>
                    <td>USA EL TELEFONO</td>
                    <td>' . $aci[4]["in"] . '</td>
                    <td>' . $aci[4]["ca"] . '</td>
                    <td>' . $aci[4]["de"] . '</td>
                  </tr>
                  <tr>
                    <td>USA MEDIOS DE TRANSPORTE</td>
                    <td>' . $aci[3]["in"] . '</td>
                    <td>' . $aci[3]["ca"] . '</td>
                    <td>' . $aci[3]["de"] . '</td>
                  </tr>
                  <tr>
                    <td>MANEJA DINERO</td>
                    <td>' . $aci[1]["in"] . '</td>
                    <td>' . $aci[1]["ca"] . '</td>
                    <td>' . $aci[1]["de"] . '</td>
                  </tr>
                  <tr>
                    <td>CONTROLA SUS MEDICAMENTOS</td>
                    <td>' . $aci[0]["in"] . '</td>
                    <td>' . $aci[0]["ca"] . '</td>
                    <td>' . $aci[0]["de"] . '</td>
                  </tr>
             
                  <tr>
                    <td>FECHA</td>
                    <td colspan="3">' . $esg[0]["esg_fecha"] . '</td>
                  </tr>
                  <tr>
                    <td>RESPONSABLE</td>
                    <td colspan="3">' . $esg[0]["responsable"] . '</td>
                  </tr>
                </tbody>
                </table>
                
                <table class="table" autosize="1">
                    <thead>
                      <tr>
                        <th>COGNITIVO</th>
                        <th>PUNTOS</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>SABE FECHA: DÍA, MES, AÑO, SEMANA</td>
                        <td>' . $esg[0]["esg_sabfec"] . '</td>
                      </tr>
                      <tr>
                        <td>APRENDE EL NOMBRE DE 3 OBJETOS</td>
                        <td>' . $esg[0]["esg_apnobj"] . '</td>
                      </tr>
                      <tr>
                        <td>REPITE NÚMEROS AL REVÉS</td>
                        <td>' . $esg[0]["esg_renual"] . '</td>
                      </tr>
                      <tr>
                        <td>TOMA DOBLA Y COLOCA, PAPEL</td>
                        <td>' . $esg[0]["esg_tompap"] . '</td>
                      </tr>
                      <tr>
                        <td>REPITE SERIES DE 3 PALABRAS</td>
                        <td>' . $esg[0]["esg_repser"] . '</td>
                      </tr>
                      <tr>
                        <td>COPIA 2 CÍRCULOS CRUZADOS</td>
                        <td>' . $esg[0]["esg_copdib"] . '</td>
                      </tr>
                      <tr>
                        <td>PUNTAJE</td>
                        <td>' . ($esg[0]["esg_sabfec"] + $esg[0]["esg_apnobj"] + $esg[0]["esg_renual"] + $esg[0]["esg_tompap"] + $esg[0]["esg_repser"] + $esg[0]["esg_copdib"]) . '</td>
                      </tr>
                      <tr>
                        <td>FECHA</td>
                        <td>' . $esg[0]["esg_fecha"] . '</td>
                      </tr>
                      <tr>
                        <td>RESPONSABLE</td>
                        <td>' . $esg[0]["responsable"] . '</td>
                      </tr>
                    </tbody>
                    </table>
                    
                    <table class="table" autosize="1">
                        <thead>
                          <tr>
                            <th>RECURSO SOCIAL</th>
                            <th>PUNTOS</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>SITUACIÓN FAMILIAR VIVE CON:</td>
                            <td>' . $esg[0]["esg_sabfec"] . '</td>
                          </tr>
                          <tr>
                            <td>RELACIONES Y CONTACTOS SOCIALES</td>
                            <td>' . $esg[0]["esg_reconso"] . '</td>
                          </tr>
                          <tr>
                            <td>APOYO DE LA RED SOCIAL</td>
                            <td>' . $esg[0]["esg_apreso"] . '</td>
                          </tr>
                          <tr>
                            <td>PUNTAJE</td>
                            <td>' . ($esg[0]["esg_sabfec"] + $esg[0]["esg_reconso"] + $esg[0]["esg_apreso"]) . '</td>
                          </tr>  
                            <tr>
                            <td>FECHA</td>
                            <td>' . $esg[0]["esg_fecha"] . '</td>
                          </tr>
                          <tr>
                            <td>RESPONSABLE</td>
                            <td>' . $esg[0]["responsable"] . '</td>
                          </tr>
                        </tbody>
                        </table>
            
            </td>
            
            <td style="width: 33%" valign="top">
            <table class="table" autosize="1">
                <thead>
                  <tr>
                    <th>DEPRESIÓN</th>
                    <th>SI</th>
                    <th>NO</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>ESTÁ SATISFECHO CON SU VIDA</td>
                    <td>' . $dep[3]["si"] . '</td>
                    <td>' . $dep[3]["no"] . '</td>
                  </tr>
                  <tr>
                    <td>HA DEJADO DE HACER ACTIVIDADES DE INTERÉS</td>
                    <td>' . $dep[0]["si"] . '</td>
                    <td>' . $dep[0]["no"] . '</td>
                  </tr>
                  <tr>
                    <td>SIENTE SU VIDA VACÍA</td>
                    <td>' . $dep[14]["si"] . '</td>
                    <td>' . $dep[14]["no"] . '</td>
                  </tr>
                  <tr>
                    <td>SE ABURRE CON FRECUENCIA</td>
                    <td>' . $dep[9]["si"] . '</td>
                    <td>' . $dep[9]["no"] . '</td>
                  </tr>
                  <tr>
                    <td>ESTÁ DE BUEN ÁNIMO LA MAYOR PARTE DEL TIEMPO</td>
                    <td>' . $dep[1]["si"] . '</td>
                    <td>' . $dep[1]["no"] . '</td>
                  </tr>
                  <tr>
                    <td>ESTÁ PREOCUPADO PORQUE ALGO MALO VA A SUCEDERLE</td>
                    <td>' . $dep[7]["si"] . '</td>
                    <td>' . $dep[7]["no"] . '</td>
                  </tr>
                  <tr>
                    <td>SE SIENTE FELIZ LA MAYOR PARTE DEL TIEMPO</td>
                    <td>' . $dep[11]["si"] . '</td>
                    <td>' . $dep[11]["no"] . '</td>
                  </tr>
                  <tr>
                    <td>SE SIENTE A MENUDO DESAMPARADO</td>
                    <td>' . $dep[10]["si"] . '</td>
                    <td>' . $dep[10]["no"] . '</td>
                  </tr>
                  <tr>
                    <td>PREFIERE ESTAR EN CASA A SALIR A ACTIVIDADES NUEVAS</td>
                    <td>' . $dep[6]["si"] . '</td>
                    <td>' . $dep[6]["no"] . '</td>
                  </tr>
                  <tr>
                    <td>TIENE MÁS PROBLEMAS DE MEMORIA QUE LOS DEMÁS</td>
                    <td>' . $dep[8]["si"] . '</td>
                    <td>' . $dep[8]["no"] . '</td>
                  </tr>
                  <tr>
                    <td>CREE QUE ES MARAVILLOSO ESTAR VIVO</td>
                    <td>' . $dep[2]["si"] . '</td>
                    <td>' . $dep[2]["no"] . '</td>
                  </tr>
                  <tr>
                    <td>SE SIENTE INÚTIL</td>
                    <td>' . $dep[13]["si"] . '</td>
                    <td>' . $dep[13]["no"] . '</td>
                  </tr>
                  <tr>
                    <td>SE SIENTE LLENO DE ENERGÍA</td>
                    <td>' . $dep[4]["si"] . '</td>
                    <td>' . $dep[4]["no"] . '</td>
                  </tr>
                  <tr>
                    <td>SE SIENTE SIN ESPERANZA ANTE LA SITUACIÓN ACTUAL</td>
                    <td>' . $dep[12]["si"] . '</td>
                    <td>' . $dep[12]["no"] . '</td>
                  </tr>
                  <tr>
                    <td>SIENTE QUE LA MAYORÍA DE LA GENTE ESTÁ MEJOR QUE USTED</td>
                    <td>' . $dep[5]["si"] . '</td>
                    <td>' . $dep[5]["no"] . '</td>
                  </tr>
                  <tr>
                    <td>PUNTAJE</td>
                    <td colspan="2"></td>
                  </tr>
                  <tr>
                    <td>FECHA</td>
                    <td colspan="2">' . $esg[0]["esg_fecha"] . '</td>
                  </tr>
                  <tr>
                    <td>RESPONSABLE</td>
                    <td colspan="2">' . $esg[0]["responsable"] . '</td>
                  </tr>
                </tbody>
                </table>
                <table class="table" autosize="1">
                    <thead>
                      <tr>
                        <th>NUTRICIONAL</th>
                        <th>A</th>
                        <th>M</th>
                        <th>S</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>DISMINUCIÓN DE INGESTA EN EL ÚLTIMO TRIMESTRE</td>
                        <td>' . $nut[0]["au"] . '</td>
                        <td>' . $nut[0]["mo"] . '</td>
                        <td>' . $nut[0]["se"] . '</td>
                      </tr>
                      <tr>
                        <td>INMOVILIDAD</td>
                        <td>' . $nut[3]["va"] . '</td>
                        <td>' . $nut[3]["sl"] . '</td>
                        <td>' . $nut[3]["cs"] . '</td>
                      </tr>
                      <tr>
                        <td>PROBLEMA NEURO PSICOLÓGICO (DEMENCIA O DEPRESIÓN)</td>
                        <td>' . ($nut[5]["au"] ?? ''). '</td>
                        <td>' . ($nut[5]["mo"] ?? ''). '</td>
                        <td>' . ($nut[5]["se"] ?? ''). '</td>
                      </tr>
                      <tr>
                        <td>ENFERMEDAD AGUDA E O ÚLTIMO TRIMESTRE</td>
                        <td>' . $nut[1]["si"] . '</td>
                        <td colspan="2">' . $nut[1]["no"] . '</td>
                      </tr>
                      <tr>
                        <td>PÉRDIDA DE PESO EN EL ÚLTIMO TRIMESTRE</td>
                        <td colspan="3">' . ($nut[4]["pat_result"] ?? '') . '</td>
                      </tr>
                      <tr>
                        <td>ÍNDICE DE MASA CORPORAL</td>
                        <td colspan="3">' . ($nut[2]["pat_result"] ?? '') . '</td>
                      </tr>
                      <tr>
                        <td>FECHA</td>
                        <td colspan="2">' . $esg[0]["esg_fecha"] . '</td>
                      </tr>
                      <tr>
                        <td>RESPONSABLE</td>
                        <td colspan="2"></td>
                      </tr>
                    </tbody>
                    </table>
            </td>
          </tr>
        </tbody>
        </table>
        </div>
';

$footer = '
    <table width="100%" style="font-size: 7pt">
    <thead>
      <tr>
        <td align="left">SNS-MSP / HCU-form057/2010</td>
        <td align="right">ESCALAS GERIÁTRICAS (1)</td>
      </tr>
    </thead>
    </table>
';


$mpdf = new mPDF(['debug' => true,
    //'allow_output_buffering' => true,
    'mode' => 'utf-8',
    'format' => 'A4',
    'orientation' => 'L',
    //'table_error_report' => true
]);
//print_r($html); die();
//$mpdf->shrink_tables_to_fit = 1;
$mpdf->writeHTML($style, 1);
$mpdf->writeHTML($html);
$mpdf->setHTMLFooter($footer);
$mpdf->Output('Escala Geriatrica.pdf', 'I');

