<?php
//    header('Content-Type: text/html; charset=UTF-8');
require_once '../../../../vendor/autoload.php';
include_once("../../../../php/class_consulta.php");
use Mpdf\Mpdf;
$mpdf = new mPDF(['debug' => true,'mode'=>'utf-8','format'=>'A4']);
//  $data = file_get_contents("php://input");
//$mpdf = new mPDF('utf-8', 'A4',8,'arial');
date_default_timezone_set("America/Bogota");
//$mpdf = new mPDF('c', 'A4', '', 'arial', 10, 10, 5, 10);
//$mpdf = new mPDF('utf-8', 'A4', 8, 'arial', 10, 10, 5, 10);

$hce_id_pk = $_GET['h'];
//$adm_id_pk = $_GET['c'];
$Conres = new Consulta();

$responsable = $Conres->Get_Consulta("sga_adm_historiaclinica
", "fecha_creacion->>'usu_login' nombre", "", "hce_id_pk", $hce_id_pk, 2);


$Con = New Consulta();
$cabecera = $Con->Get_Consulta("sga_adm_historiaclinica hc
inner join sga_adm_establecimiento establecimiento on establecimiento.eta_id_pk = hc.eta_id_fk
inner join sga_adm_institucion institucion on institucion.ins_id_pk = establecimiento.ins_id_fk
left join sga_adm_parroquia parroquia on parroquia.par_id_pk = establecimiento.par_id_fk
left join sga_adm_canton canton on canton.can_id_pk = parroquia.can_id_fk
left join sga_adm_provincia provincia on provincia.prv_id_pk = canton.prv_id_fk", " ins_abreviacion,eta_descripcion,eta_codigo,lpad(par_codigo,2,'0') par_codigo,
  lpad(can_codigo,2,'0') can_codigo,
 lpad(prv_codigo,2,'0') prv_codigo", "", "hce_id_pk", $hce_id_pk, 2);
$Conp = new Consulta();
$registroPrimera = $Conp->Get_Consulta(" sga_adm_historiaclinica hc
                                            inner join sga_adm_paciente paciente on paciente.pac_id_pk = hc.pac_id_fk
                                            inner join sga_adm_persona persona on persona.per_id_pk = paciente.per_id_fk
                                            left join sga_adm_parroquia parroquia on parroquia.par_id_pk = persona.par_id_fk
                                            left join sga_adm_canton canton on canton.can_id_pk = parroquia.can_id_fk
                                            left join sga_adm_provincia provincia on provincia.prv_id_pk = canton.prv_id_fk

                                            left join sga_adm_parroquia parroquia_nac on parroquia_nac.par_id_pk = persona.par_id_fk_nac
                                            left join sga_adm_canton canton_nac on canton_nac.can_id_pk = parroquia_nac.can_id_fk
                                            left join sga_adm_provincia provincia_nac on provincia_nac.prv_id_pk = canton_nac.prv_id_fk
                                            left join sga_adm_pais pais_nac on pais_nac.pai_id_pk = provincia_nac.pai_id_fk
inner join sga_adm_autoetnica aut on aut.aet_id_pk = persona.aet_id_fk
                                            inner join sga_adm_sexo sexo on sexo.sex_id_pk = persona.sex_id_fk
                                            inner join sga_adm_estadocivil estadocivil on estadocivil.esc_id_pk = persona.esc_id_fk
                                            inner join sga_adm_niveleducacion ne on ne.ned_id_pk = persona.ned_id_fk
                                            ", "    per_apellidopaterno,per_apellidomaterno,per_nombres,per_numeroidentificacion,
                                              per_direccionprincipal || '/' || per_direccionsecundaria per_direccion,
                                              per_direccionbarrio,
                                              parroquia.par_descripcion,
                                              canton.can_descripcion,
                                              provincia.prv_descripcion,
                                              null zona,
                                              per_telefonocelular || '/' || per_telefonoconvencional per_telefono,date_part('year',age(per_fechanacimiento)) edad,
                                              to_char(per_fechanacimiento,'DD.MM.YYYY') per_fechanacimiento,
                                              parroquia_nac.par_descripcion par_descripcion_nac,
                                              canton_nac.can_descripcion can_descripcion_nac,
                                              provincia_nac.prv_descripcion prv_descripcion_nac,
                                              pais_nac.pai_descripcion pai_descripcion_nac,aet_descripcion,
                                              case when sex_codigo='M' then 'X' end sexo_m,
                                              case when sex_codigo='F' then 'X' end sexo_f,
                                              case when esc_codigo='SOL' then 'X' end ecivil_sol,
                                              case when esc_codigo='CAS' then 'X' end ecivil_cas,
                                              case when esc_codigo='DIV' then 'X' end ecivil_div,
                                              case when esc_codigo='VIU' then 'X' end ecivil_viu,
                                              case when esc_codigo='U-L' then 'X' end ecivil_ul
                                              ", "", "hce_id_pk", $hce_id_pk, 2);
$Conpe = new Consulta();
$registroPrimeraExtra = $Conpe->Get_Consulta("sga_adm_historiaclinica hc
    inner join sga_adm_paciente paciente on paciente.pac_id_pk = hc.pac_id_fk
    inner join sga_adm_persona persona on persona.per_id_pk = paciente.per_id_fk

    inner join sga_adm_tipoempresatrabajo tipo_emp on tipo_emp.tet_id_pk = persona.tid_id_fk
    inner join sga_adm_tiposeguro tipo_seg on tipo_seg.tse_id_pk = paciente.tse_id_fk
    left join sga_adm_paciente_referente pac_ref on pac_ref.pac_id_fk = paciente.pac_id_pk
    left join sga_adm_tipoparentesco tipo_par on tipo_par.tpr_id_pk = pac_ref.tpr_id_fk", " null fecha_admision,
                                              tet_descripcion,
                                              tse_descripcion,
                                              null refererido,
                                              pcf_apellidos || ' '|| pcf_nombres pcf_nombres,
                                              tpr_descripcion,
                                              pcf_direccion,
                                              pcf_telefonocelular || '/' || pcf_telefonoconvencional pcf_telefono", "", "hce_id_pk", $hce_id_pk, 2);

$html = '
          <style>
              @page
              {
        
                  /* this affects the margin in the printer settings */
                  /*margin: 5mm 10mm 10mm 10mm;*/
                  /*margin-top: 10mm;
                  margin-right: 10mm;
                  margin-bottom: 10mm;
                  margin-left: 10mm;*/
              }
            
              body
              {
                font-family: "sans-serif","arial","times";
                font-size: 8pt;
              }
              
              .table {
                border-collapse: collapse;
                text-align: center;
                width: 100%;
              }
              
              .table td {
                  border: 1px solid black;
                  font-weight: bold;
                    font-weight: normal;
                    
              }
              .borde {
                border: 1px solid black;
                font-weight: bold;
                background: #99e6ff;
				color: #000000;
              }
              .verticalTableHeader {
                text-align:center;
                white-space:nowrap;
                transform-origin:50% 50%;
                -webkit-transform: rotate(-90deg);
                -moz-transform: rotate(-90deg);
                -ms-transform: rotate(-90deg);
                -o-transform: rotate(-90deg);
                transform: rotate(-90deg);
                
            }
            
            .verticalTableHeader p {
                margin:0 -100% ;
                display:inline-block;
            }
            
            .verticalTableHeader:before {
                content:\'\';
                padding-top:110%;/* takes width as reference, + 10% for faking some extra padding */
                display:inline-block;
                vertical-align:middle;
            }
        
         </style>

 
         <table style="width:100%">
            <tr>
            <td><IMG SRC="../../../../img/msp.jpg" WIDTH="110" HEIGHT="30"></td>
                <td style="text-align: right; font-size: 14pt"><strong>'.$Conpe->entidad.'</strong></td>
            </tr>
        </table>
        
        <table class="table">
            <tr>
                <th rowspan="2" class="borde">INSTITUCIÓN DEL SISTEMA</th>
                <th rowspan="2" class="borde">UNIDAD OPERATIVA</th>
                <th rowspan="2" class="borde">COD. UO</th>
                <th colspan="3" class="borde">COD. LOCALIZACIÓN</th>
                <th rowspan="2" class="borde"> NÚMERO DE HISTORIA</th>
            </tr>
            <tr>
                <td class="borde">PARROQUIA</td>
                <td class="borde">CANTÓN</td>
                <td class="borde">PROVINCIA</td>
            </tr>
            <tr>
              <td>'.($cabecera[0]["ins_abreviacion"] ?? '')  .'</td>
              <td>'.($cabecera[0]["eta_descripcion"] ?? '')  .'</td>
              <td>'.($cabecera[0]["eta_codigo"] ?? '')  .'</td>
              <td>'.($cabecera[0]["par_codigo"] ?? '')  .'</td>
              <td>'.($cabecera[0]["can_codigo"] ?? '')  .'</td>
              <td>'.($cabecera[0]["prv_codigo"] ?? '')  .'</td>
              <td> ' . ($registroPrimera[0]["per_numeroidentificacion"] ?? '')  .'</td>
            </tr>
        </table>
        
        <br>
        
        <table class="table">
          <tr>
            <th colspan="13" style="text-align: left; font-size:11pt; font-weight: bold" class="borde">1 REGISTRO DE PRIMERA ADMISIÓN</th>
          </tr>
          <tr>
            <td colspan="2" class="borde">APELLIDO PATERNO</td>
            <td colspan="2" class="borde">APELLIDO MATERNO</td>
            <td colspan="4" class="borde">NOMBRES</td>
            <td colspan="5" class="borde">NÚMERO DE IDENTIFICACIÓN</td>
          </tr>
          <tr>
            <td colspan="2">'.($registroPrimera[0]["per_apellidopaterno"] ?? '')  .'</td>
            <td colspan="2">'.($registroPrimera[0]["per_apellidomaterno"] ?? '')  .'</td>
            <td colspan="4">'.($registroPrimera[0]["per_nombres"] ?? '')  .'</td>
            <td colspan="5">'.($registroPrimera[0]["per_numeroidentificacion"] ?? '')  .'</td>
          </tr>
          <tr>
            <td colspan="2" class="borde">DIRECCIÓN</td>
            <td class="borde">BARRIO</td>
            <td class="borde">PARROQUIA</td>
            <td colspan="2" class="borde">CANTON</td>
            <td colspan="3" class="borde">PROVINCIA</td>
            <td class="borde">ZONA</td>
            <td colspan="3" class="borde">N° TELEFONO</td>
          </tr>
          <tr>
            <td colspan="2"><font size="1">'.($registroPrimera[0]["per_direccion"] ?? '')  .'</font></td>
            <td><font size="1">'.($registroPrimera[0]["per_direccionbarrio"] ?? '')  .'</font></td>
            <td><font size="1">'.($registroPrimera[0]["par_descripcion"] ?? '')  .'</font></td>
            <td colspan="2"><font size="1">'.($registroPrimera[0]["can_descripcion"] ?? '')  .'</font></td>
            <td colspan="3"><font size="1">'.($registroPrimera[0]["prv_descripcion"] ?? '')  .'</font></td>
            <td></td>
            <td colspan="3"><font size="1">'.($registroPrimera[0]["per_telefono"] ?? '')  .'</font></td>
          </tr>
          <tr>
            <td class="borde">FECHA DE NACIMIENTO</td>
            <td class="borde">LUGAR DE NACIMIENTO</td>
            <td class="borde">NACIONALIDAD</td>
            <td class="borde">AUTOIDENTIFICACIÓN</td>
            <td class="borde">EDAD</td>
            <td class="borde" colspan="2">SEXO</td>
            <td class="borde" colspan="5">ESTADO CIVIL</td>
            <td class="borde">INSTRUCCIÓN</td>
          </tr>
          <tr>
            <td class="borde">dd.mm.aaaa</td>
            <td rowspan="2">'.($registroPrimera[0]["par_descripcion_nac"] ?? '')  .'</td>
            <td rowspan="2">'.($registroPrimera[0]["pai_descripcion_nac"] ?? '')  .'</td>
            <td rowspan="2">'.($registroPrimera[0]["aet_descripcion"] ?? '')  .'</td>
            <td rowspan="2">'.($registroPrimera[0]["edad"] ?? '')  .'</td>
            <td class="borde">M</td>
            <td class="borde">F</td>
            <td class="borde">SOL</td>
            <td class="borde">CAS</td>
            <td class="borde">DIV</td>
            <td class="borde">VIU</td>
            <td class="borde">U-L</td>
            <td rowspan="2">'.($registroPrimera[0]["ned_descripcion"] ?? '')  .'</td>
          </tr>
          <tr>
            <td>'.($registroPrimera[0]["per_fechanacimiento"] ?? '')  .'</td>
            <td>'.($registroPrimera[0]["sexo_m"] ?? '')  .'</td>
            <td>'.($registroPrimera[0]["sexo_f"] ?? '')  .'</td>
            <td>'.($registroPrimera[0]["ecivil_sol"] ?? '')  .'</td>
            <td>'.($registroPrimera[0]["ecivil_cas"] ?? '')  .'</td>
            <td>'.($registroPrimera[0]["ecivil_div"] ?? '')  .'</td>
            <td>'.($registroPrimera[0]["ecivil_viu"] ?? '')  .'</td>
            <td>'.($registroPrimera[0]["ecivil_ul"] ?? '')  .'</td>
          </tr>
         
          <tr>
            <td class="borde" >FECHA ADMISIÓN</td>
            <td class="borde" >OCUPACIÓN</td>
            <td class="borde" >EMPRESA DONDE TRABAJA</td>
            <td class="borde" ></td>
            <td class="borde"  colspan="5">TIPO DE SEGURO DE SALUD</td>
            <td class="borde"  colspan="4">REFERIDO DE</td>
          </tr>
          <tr>
            <td>'.($registroPrimeraExtra[0]["fecha_admision"] ?? '')  .'</td>
            <td></td>
            <td>'.($registroPrimeraExtra[0]["tet_descripcion"] ?? '')  .'</td>
            <td></td>
            <td colspan="5">'.($registroPrimeraExtra[0]["tse_descripcion"] ?? '')  .'</td>
            <td colspan="4">'.($registroPrimeraExtra[0]["referido"] ?? '')  .'</td>
          </tr>
          <tr>
            <td class="borde" >EN CASO DE LLAMAR A:</td>
            <td class="borde" >PARENTESCO</td>
            <td class="borde" colspan="8">DIRECCIÓN</td>
            <td class="borde"  colspan="3">N° TELEFONO</td>
          </tr>
          <tr>
            <td>'.($registroPrimeraExtra[0]["pcf_nombres"] ?? '')  .'</td>
            <td>'.($registroPrimeraExtra[0]["tpr_descripcion"] ?? '')  .'</td>
            <td colspan="8">'.($registroPrimeraExtra[0]["pcf_direccion"] ?? '')  .'</td>
            <td colspan="3">'.($registroPrimeraExtra[0]["pcf_telefono"] ?? '')  .'</td>
          </tr>
        </table>
        
        <table style="width: 100%">
             <tr>
                <th style="text-align: right" colspan="3">CÓDIGO</th>
              </tr>
              <tr>
                <td style="border-collapse: collapse; border: 1px solid black; font-size: 6pt">COD=CÓDIGO U=URBANA R=RURAL M=MASCULINO F=FEMENINO SOL=SOLTERO CAS=CASADO DIV=DIVORCIADO VIU=VIUDO U-L=UNION LIBRE</td>
                <td class="borde" style="border-collapse: collapse; border: 1px solid black; font-weight: bold">ADMISIONISTA</td>
                <td style="border-collapse: collapse; border: 1px solid black" width="100px">'.($responsable[0]["nombre"] ?? '')  .'</td>
              </tr>
        </table>
        
        <table class="table">
          <tr>
            <th  class="borde" colspan="14" style="text-align: left; font-size:11pt; font-weight: bold">2. REGISTRO DE NUEVAS ADMISIONES PARA ATENCIONES DE PRIMERA VEZ Y SUBSECUENTES</th>
          </tr>
          <tr>
            <th class="borde">N°</th>
            <th class="borde">FECHA</th>
            <th class="borde">EDAD</th>
            <th class="borde">REFERIDO DE</th>
            <th class="borde" text-rotate="90">PRIMERA VEZ</th>
            <th class="borde" text-rotate="90">SUBSECUENTE</th>
            <th class="borde" >CÓDIGO <br>ADMISIONISTA</th>
            <th class="borde" >N°</th>
            <th class="borde" >FECHA</th>
            <th class="borde" >EDAD</th>
            <th class="borde" >REFERIDO DE</th>
            <th class="borde" text-rotate="90">PRIMERA VEZ</th>
            <th class="borde" text-rotate="90">SUBSECUENTE</th>
            <th class="borde" >CÓDIGO ADMISIONISTA</th>
          </tr>
          <tr>
            <td class="borde">1</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="borde">11</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="borde">2</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="borde">12</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="borde">3</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="borde">13</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="borde">4</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="borde" >14</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="borde" >5</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="borde">15</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="borde">6</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="borde">16</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="borde" >7</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="borde" >17</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
         
        </table>
        
        <br>
        
        <table class="table">
          <tr>
            <th colspan="10" style="text-align: left; font-size:11pt; font-weight: bold" class="borde">3 REGISTRO DE CAMBIOS</th>
          </tr>
          <tr>
            <td class="borde" width="2%" rowspan="4">1</td>
            <td class="borde">FECHA</td>
            <td class="borde">ESTADO CIVIL</td>
            <td  class="borde" colspan="2">INSTRUCCIÓN</td>
            <td  class="borde" colspan="2">OCUPACIÓN</td>
            <td  class="borde" colspan="2">EMPRESA</td>
            <td class="borde">TIPO DE SEGURO</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2"></td>
            <td colspan="2"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="borde"  colspan="3">DIRECCIÓN</td>
            <td class="borde">BARRIO</td>
            <td class="borde">ZONA</td>
            <td class="borde">PARROQUIA</td>
            <td class="borde">CANTON</td>
            <td class="borde">PROVINCIA</td>
            <td class="borde">N° TELÉFONO</td>
          </tr>
          <tr>
            <td colspan="3"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        
        <br>
        
        <table class="table">
          <tr>
            <td class="borde" width="2%" rowspan="4">2</td>
            <td class="borde">FECHA</td>
            <td class="borde">ESTADO CIVIL</td>
            <td class="borde" colspan="2">INSTRUCCIÓN</td>
            <td class="borde" colspan="2">OCUPACIÓN</td>
            <td class="borde" colspan="2">EMPRESA</td>
            <td class="borde">TIPO DE SEGURO</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2"></td>
            <td colspan="2"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td  class="borde" colspan="3">DIRECCIÓN</td>
            <td class="borde" >BARRIO</td>
            <td class="borde" >ZONA</td>
            <td class="borde" >PARROQUIA</td>
            <td class="borde" >CANTON</td>
            <td class="borde" >PROVINCIA</td>
            <td class="borde" >N° TELÉFONO</td>
          </tr>
          <tr>
            <td colspan="3"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        
        <table class="table">
          <tr>
            <td  class="borde" width="2%" rowspan="4">3</td>
            <td class="borde" >FECHA</td>
            <td class="borde" >ESTADO CIVIL</td>
            <td class="borde"  colspan="2">INSTRUCCIÓN</td>
            <td  class="borde" colspan="2">OCUPACIÓN</td>
            <td class="borde"  colspan="2">EMPRESA</td>
            <td class="borde" >TIPO DE SEGURO</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2"></td>
            <td colspan="2"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="borde" colspan="3">DIRECCIÓN</td>
            <td class="borde">BARRIO</td>
            <td class="borde">ZONA</td>
            <td class="borde">PARROQUIA</td>
            <td class="borde">CANTON</td>
            <td class="borde">PROVINCIA</td>
            <td class="borde">N° TELÉFONO</td>
          </tr>
          <tr>
            <td colspan="3"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        
        <table class="table">
          <tr>
            <td class="borde"  width="2%" rowspan="4">4</td>
            <td class="borde" >FECHA</td>
            <td class="borde" >ESTADO CIVIL</td>
            <td class="borde"  colspan="2">INSTRUCCIÓN</td>
            <td class="borde"  colspan="2">OCUPACIÓN</td>
            <td class="borde"  colspan="2">EMPRESA</td>
            <td class="borde" >TIPO DE SEGURO</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2"></td>
            <td colspan="2"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="borde"  colspan="3">DIRECCIÓN</td>
            <td class="borde" >BARRIO</td>
            <td class="borde" >ZONA</td>
            <td class="borde" >PARROQUIA</td>
            <td class="borde" >CANTON</td>
            <td class="borde" >PROVINCIA</td>
            <td class="borde" >N° TELÉFONO</td>
          </tr>
          <tr>
            <td colspan="3"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        
        <br>
        
        <table class="table">
          <tr>
            <th class="borde" style="text-align: left; font-size:11pt; font-weight: bold">4 INFORME ADICIONAL</th>
            <th class="borde" style="text-align: right; font-size:6pt;">ESPACIO RESERVADO PARA REGISTRAR OTROS DATOS ESPECÍFICOS DEL USUARIO<br>REQUERIDOS POR LA INSTITUCIÓN QUE CONSTA EN EL ENCABEZAMIENTO</th>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
        </table>
        <label style="text-align: left; font-size: 7pt">SNS-MSP/HCU-FORM. 001 / 2008</label>
        <label style="text-align: right; font-size: 7pt">ADMISIÓN</label>';

//página 2
// fecha de ingreso y altade admsión
$Conegreso = new Consulta();
$admisioni = $Conegreso->Get_Consulta("sga_adm_admision",
    "*", "", "hce_id_fk", $hce_id_pk, 2);


$html2 = '
<html>';

for ($r = 0; $r < count($admisioni); $r++) {

    $Conadmision = 'Conadmision' . $r;
    $ConServi = 'ConServi' . $r;
    $ConDIadmision = 'ConDIadmision' . $r;
    $ConDEadmision = 'ConDEadmision' . $r;

    $$Conadmision = new Consulta();
    $$ConServi = New Consulta();
    $$ConDIadmision = new Consulta();
    $$ConDEadmision = new Consulta();

    if ($admisioni[$r]["adm_fechadealta"] <> null) {
        # servicion
        $servicion = $$ConServi->Get_Consulta("sgh_mei_censo censo
            JOIN sga_adm_cama cama on censo.cam_id_fk = cama.cam_id_pk
            join sga_adm_tipocama servicion on cama.tca_serv_fk = servicion.tca_id_pk",
            "servicion.tca_descripcion as servicio", "", "cen_fecha='" . $admisioni[$r]["adm_fechaingreso"] . "'and cen_tipo='INGRESO' and hce_id_fk", $hce_id_pk, 2);
        # anamnesis
        $hegresohospi = $$Conadmision->Get_Consulta("sgh_mei_epicrisis",
            "epi_id_pk,sgh_conbiertetrue('1',epi_altdef) as alta_definitiva,sgh_conbiertetrue('1',epi_dme48h) as defucion_me_48,
		sgh_conbiertetrue('1',epi_dma48h) as defucion_mas_48", "", "epi_fecha='" . $admisioni[$r]["adm_fechadealta"] . "' and hce_id_fk", $hce_id_pk, 2);
        # CARGAR DIAGNOSTICO INGRESO
        $DiagI = $$ConDIadmision->Get_Consulta("sgh_mei_dei join sgh_mei_diagnos as d on dia_id_fk=d.dia_id_pk JOIN sgh_mei_codigocie10 as c10  on d.c10_id_fk=c10.c10_id_pk", "c10_nombre AS detalle,
                c10_codigo as cie,
                sgh_conbiertepre('1',dia_resp) as pre,
                sgh_conbiertepre('2',dia_resp) as def",
            "", "dia_tipo='INGRESO'and epi_id_fk", $hegresohospi[0]["epi_id_pk"], 2);
        //print_r ($DiagI);
        # CARGAR DIAGNOSTICO EGRESO
        $DiagE = $$ConDEadmision->Get_Consulta("sgh_mei_dei join sgh_mei_diagnos as d on dia_id_fk=d.dia_id_pk JOIN sgh_mei_codigocie10 as c10  on d.c10_id_fk=c10.c10_id_pk", "c10_nombre AS detalle,
                c10_codigo as cie,
                sgh_conbiertepre('1',dia_resp) as pre,
                sgh_conbiertepre('2',dia_resp) as def",
            "", "dia_tipo='EGRESO'and epi_id_fk", $hegresohospi[0]["epi_id_pk"], 2);
    }
    $html2 .= '   
<div>
    
    <table class="table">
          <tr>
            <th colspan="21" style="text-align: left; font-size:11pt; font-weight: bold" class="borde">5 ALTA AMBULATORIA</th>
          </tr>
          <tr>
            <td colspan="9" class="borde">CARACTERÍSTICAS</td>
            <td colspan="8" class="borde">DIAGNÓSTICO</td>
            <td colspan="4" class="borde">TRATAMIENTO</td>
          </tr>
          <tr>
            <td rowspan="2" text-rotate="90" class="borde">NÚMERO DE ORDEN</td>
            <td rowspan="2" class="borde">FECHAS DE ADMISIÓNY ALTA</td>
            <td rowspan="2" class="borde">
             <table> 
		        <tr>
		            <th text-rotate="90">
		           <font size=2> CONSULTAS DE</font>
                 
		            </th>
		            <th text-rotate="90">
		           <font size=2> EMERGENCIA</font>
		            </th>
		        </tr>
            </table>     
            </td>
            <td rowspan="2" class="borde">
              <table class="table-responsive"> 
		        <tr>
		            <th text-rotate="90">
		           <font size=2> NÚMERO DE</font>
                 
		            </th>
		            <th text-rotate="90">
		           <font size=2>CONSULTAS EXTERNAS</font>
		            </th>
		        </tr>
            </table> 
            </td>
            <td rowspan="2" class="borde">ESPECIALIDAD DEL SERVICIO</td>
            <td colspan="3" class="borde">CONDICIÓN AL ALTA</td>
            <td rowspan="2" text-rotate="90" class="borde">MUERTO</td>
            <td rowspan="2" class="borde">DIAGNÓSTICOS O SINDROMES</td>
            <td rowspan="2" text-rotate="90" class="borde">CIE</td>
            <td rowspan="2" text-rotate="90" class="borde">PRESUNTIVO</td>
            <td rowspan="2" text-rotate="90" class="borde">DEFINITIVO</td>
            <td rowspan="2" class="borde">DIAGNÓSTICOS O SÍNDROMES</td>
            <td rowspan="2" text-rotate="90" class="borde">CIE</td>
            <td rowspan="2" text-rotate="90" class="borde">PRESUNTIVO</td>
            <td rowspan="2" text-rotate="90" class="borde">DEFINITIVO</td>
            <td rowspan="2" text-rotate="90" class="borde">CLÍNICO</td>
            <td rowspan="2" text-rotate="90" class="borde">QUIRÚRGICO</td>
            <td rowspan="2" class="borde">PROCEDIMIENTOS CLÍNICOS O<br>QUIRÚRGICOS PRINCIPALES</td>
            <td rowspan="2" class="borde">CÓDIGO DEL RESPONSABLE</td>
          </tr>
          <tr>
            <td text-rotate="90" class="borde">CURADO</td>
            <td text-rotate="90" class="borde">IGUAL</td>
            <td text-rotate="90" class="borde">PEOR</td>
          </tr>
          <tr>
            <td class="borde" rowspan="2">1</td>
            <td></td>
            <td rowspan="2"></td>
            <td rowspan="2"></td>
            <td rowspan="2"></td>
            <td rowspan="2"></td>
            <td rowspan="2"></td>
            <td rowspan="2"></td>
            <td rowspan="2"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="borde" rowspan="2">2</td>
            <td>&nbsp;</td>
            <td rowspan="2"></td>
            <td rowspan="2"></td>
            <td rowspan="2"></td>
            <td rowspan="2"></td>
            <td rowspan="2"></td>
            <td rowspan="2"></td>
            <td rowspan="2"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="borde" rowspan="2">3</td>
            <td>&nbsp;</td>
            <td rowspan="2"></td>
            <td rowspan="2"></td>
            <td rowspan="2"></td>
            <td rowspan="2"></td>
            <td rowspan="2"></td>
            <td rowspan="2"></td>
            <td rowspan="2"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="borde" rowspan="2">4</td>
            <td>&nbsp;</td>
            <td rowspan="2"></td>
            <td rowspan="2"></td>
            <td rowspan="2"></td>
            <td rowspan="2"></td>
            <td rowspan="2"></td>
            <td rowspan="2"></td>
            <td rowspan="2"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
    </table>
    
    <br>
    
    <table class="table">
      <tr>
        <th colspan="18" style="text-align: left; font-size:11pt; font-weight: bold" class="borde">6 EGRESO HOSPITALARIO</th>
      </tr>
      <tr>
        <td colspan="6" class="borde">CARACTERÍSTICAS</td>
        <td colspan="8" class="borde">DIAGNÓSTICO</td>
        <td colspan="4" class="borde">TRATAMIENTO</td>
      </tr>
      <tr>
        <td rowspan="2" text-rotate="90" class="borde">NÚMERO DE ORDEN</td>
        <td rowspan="2" class="borde">
           <table class="th"> 
		        <tr >
		            <th text-rotate="90">
		           <font size=2>FECHAS DE </font>
                 
		            </th>
		            <th text-rotate="90">
		           <font size=2>ADMISIÓN Y ALTA</font>
		            </th>
		        </tr>
            </table> 
        </td>
        <td rowspan="2" text-rotate="90" class="borde">SERVICIO</td>
        <td colspan="3" class="borde">CONDICIÓN AL EGRESO</td>
        <td rowspan="2" class="borde">DIAGNÓSTICOS O SINDROMES</td>
        <td rowspan="2" text-rotate="90" class="borde">CIE</td>
        <td rowspan="2" text-rotate="90" class="borde">PRESUNTIVO</td>
        <td rowspan="2" text-rotate="90" class="borde">DEFINITIVO</td>
        <td rowspan="2" class="borde">DIAGNÓSTICOS O SÍNDROMES</td>
        <td rowspan="2" class="borde">CIE</td>
        <td rowspan="2" text-rotate="90" class="borde">CIE</td>
        <td rowspan="2" text-rotate="90" class="borde">PRESUNTIVO</td>
        <td rowspan="2" text-rotate="90" class="borde">DEFINITIVO</td>
        <td rowspan="2" text-rotate="90" class="borde">QUIRÚRGICO</td>
        <td rowspan="2" class="borde">PROCEDIMIENTOS CLÍNICOS O<br>QUIRÚRGICOS PRINCIPALES</td>
        <td rowspan="2" class="borde">CÓDIGO DEL RESPONSABLE</td>
      </tr>
      <tr>
        <td text-rotate="90" class="borde">ALTA</td>
        <td class="borde">
             <table class="th"> 
		        <tr >
		            <th text-rotate="90">
		           <font size=2>MUERTE MENOS</font>
                 
		            </th>
		            <th text-rotate="90">
		           <font size=2>DE 48 HORAS</font>
		            </th>
		        </tr>
            </table> 
        </td>
        
        <td class="borde">
            <table class="th"> 
		        <tr >
		            <th text-rotate="90">
		           <font size=2> MUERTE MAS</font>
                 
		            </th>
		            <th text-rotate="90">
		           <font size=2>DE 48 HORAS</font>
		            </th>
		        </tr>
            </table>
            
           </td>
      </tr>
      
      <tr>
        <td rowspan="2">1</td>
        <td height="20"> <center>'.($admisioni[$r]["adm_fechaingreso"] ?? '').'</center></td>
        <td rowspan="2"> <center>'.($servicion[0]["servicio"] ?? '').'</center></td>
        <td rowspan="2"> <center>'.($hegresohospi[0]["alta_definitiva"] ?? '').'</center></td>
        <td rowspan="2"> <center>'.($hegresohospi[0]["defucion_me_48"] ?? '').'</center></td>
        <td rowspan="2"> <center>'.($hegresohospi[0]["defucion_mas_48"] ?? '').'</center></td>
       
        <td rowspan="2"  VALIGN="TOP"><center>';
    if ($DiagE > $DiagI) {
        $valor = $DiagE;
    } else {
        $valor = $DiagI;
    }
    if (!empty($valor)) {
        for ($i = 0; $i < count($valor); $i++) {
            $html2 .= '
                <table width="100%">
                    <tr>
                    <td height="25"><font size="1">'.($DiagI[$i]["detalle"] ?? '')  .'</font></td>
                     </tr>    
                </table>';
        }
    }
    $html2 .= '
        </center></td>
        
        <td rowspan="2" VALIGN="TOP"><center> 
        ';
    if (!empty($valor)) {
        for ($i = 0; $i < count($valor); $i++) {
            $html2 .= '
                <table>
                    <tr>
                    <td width="20" height="25"><font size=1>'.($DiagI[$i]["cie"] ?? '')  .'</font></td>
                     </tr>    
                </table>';
        }
    }
    $html2 .= '
        </center></td>
        <td rowspan="2" VALIGN="TOP"><center> 
        ';
    if (!empty($valor)) {
        for ($i = 0; $i < count($valor); $i++) {
            $html2 .= '
                <table>
                    <tr>
                    <td width="20" height="25"><font size=1>'.($DiagI[$i]["pre"] ?? '')  .'</font></td>
                     </tr>    
                </table>';
        }
    }
    $html2 .= '
        </center></td>
        <td rowspan="2" VALIGN="TOP"><center> 
        ';
    if (!empty($valor)) {
        for ($i = 0; $i < count($valor); $i++) {
            $html2 .= '
                <table>
                    <tr>
                    <td width="20" height="25"><font size=1>'.($DiagI[$i]["def"] ?? '')  .'</font></td>
                     </tr>    
                </table>';
        }
    }
    $html2 .= '
        </center></td>
         
        <td rowspan="2" VALIGN="TOP"><center>
        ';
    if (!empty($valor)) {
        for ($i = 0; $i < count($valor); $i++) {
            $html2 .= '
                <table width="100%">
                    <tr>
                    <td width="20" height="25"><font size=1>'.($DiagE[$i]["detalle"] ?? '')  .'</font></td>
                     </tr>    
                </table>';
        }
    }
    $html2 .= '
       </center></td>
        <td rowspan="2" VALIGN="TOP"><center> 
        ';
    if (!empty($valor)) {
        for ($i = 0; $i < count($valor); $i++) {
            $html2 .= '
                <table>
                    <tr>
                    <td width="20" height="25"><font size=1>'.($DiagE[$i]["cie"] ?? '')  .'</font></td>
                     </tr>    
                </table>';
        }
    }
    $html2 .= '
       </center></td>
        <td rowspan="2" VALIGN="TOP"><center> 
        ';
    if (!empty($valor)) {
        for ($i = 0; $i < count($valor); $i++) {
            $html2 .= '
                <table>
                    <tr>
                    <td width="20" height="25"><font size=1>'.($DiagE[$i]["pre"] ?? '')  .'</font></td>
                     </tr>    
                </table>';
        }
    }
    $html2 .= '
        </center></td>
        <td rowspan="2" VALIGN="TOP"><center> 
        ';
    if (!empty($valor)) {
        for ($i = 0; $i < count($valor); $i++) {
            $html2 .= '
                <table>
                    <tr>
                    <td width="20" height="25"><font size=1>'.($DiagE[$i]["def"] ?? '')  .'</font></td>
                     </tr>    
                </table>';
        }
    }
    $html2 .= '
        </center>
        </td>
         <td rowspan="2" VALIGN="TOP"><center> 
        ';
    if (!empty($valor)) {
        for ($i = 0; $i < count($valor); $i++) {
            $html2 .= '
                <table>
                    <tr>
                    <td width="20" height="25"></td>
                     </tr>    
                </table>';
        }
    }
    $html2 .= '
        </center>
        </td>
         <td rowspan="2" VALIGN="TOP"><center> 
        ';
    if (!empty($valor)) {
        for ($i = 0; $i < count($valor); $i++) {
            $html2 .= '
                <table>
                    <tr>
                    <td width="20" height="25"></td>
                     </tr>    
                </table>';
        }
    }
    $html2 .= '
        </center>
        </td>
         <td rowspan="2" VALIGN="TOP"><center> 
        ';
    if (!empty($valor)) {
        for ($i = 0; $i < count($valor); $i++) {
            $html2 .= '
                <table width="100%">
                    <tr>
                    <td width="20" height="25"></td>
                     </tr>    
                </table>';
        }
    }
    $html2 .= '
        </center>
        </td>
         <td rowspan="2" VALIGN="TOP"><center> 
        ';
    if (!empty($valor)) {
        for ($i = 0; $i < count($valor); $i++) {
            $html2 .= '
                <table width="100%">
                    <tr>
                    <td width="20" height="25"></td>
                     </tr>    
                </table>';
        }
    }
    $html2 .= '
        </center>
        </td>
      </tr>
      <tr>
        <td>&nbsp;' . ($admisioni[$r]["adm_fechadealta"] ?? '')  .'</td>
      </tr>
   
    </table>
    <label style="font-size:7pt">SNS-MSP / HCU-FORM. 001 / 2008</label>
    <label style="font-size:7pt">ALTA-EGRESO</label>
   <br><br> <br><br> <br><br> <br><br>
   <br><br> <br><br> <br><br> <br><br>
   <br><br> <br><br> <br><br> <br>
  
  
   </div>
   </html>';
}

//$mpdf = new mPDF('c', 'A4','','arial',10,10,5,10);

$mpdf->writeHTML($html);

$mpdf->AddPage('A4-L');
//$mpdf = new mPDF('utf-8','A4-L',8,'arial');
$mpdf->writeHTML($html2);

$mpdf->Output('Hoja-de-admision.pdf', 'I');
exit;
?>