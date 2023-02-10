<?php
try {

  require '../../../../vendor/autoload.php';
  require '../../../../php/conexion.php';

  $conn = new Conectar();

  $ref_id_pk = $_GET['c'];
  $tipo_file = isset($_GET['tipo']) ? strtoupper($_GET['tipo']) : 'I';

//Encabezado
  $query = $conn->prepare("select ref_id_pk,
           per_apellidopaterno,
           per_apellidomaterno,per_nombres,to_char(per_fechanacimiento,'dd-MM-YYYY') as per_fechanacimiento,
           date_part('year',age(per_fechanacimiento)) as Edad,sex_codigo as sexo,pai_descripcion,
           per_numeroidentificacion,coalesce(prv_descripcion||'/ '||can_descripcion||'/ '||par_descripcion) as lugar_residencia,
           prv_descripcion,
           can_descripcion,
           par_descripcion,
           per_direccionprincipal,
           hce_numerohc,per_telefonocelular as tel_numero
           from sgh_mei_referencia as r
                join sga_adm_historiaclinica as h on h.hce_id_pk=r.hce_id_fk
                join sga_adm_paciente as p on h.pac_id_fk=p.pac_id_pk
                join sga_adm_persona as  per on p.per_id_fk=per.per_id_pk
                left join sga_adm_parroquia as pa on per.par_id_fk=pa.par_id_pk
                left join sga_adm_canton as ca on pa.can_id_fk=ca.can_id_pk
                left join sga_adm_provincia as pro on ca.prv_id_fk=pro.prv_id_pk
                left join sga_adm_pais as pais on pro.pai_id_fk = pais.pai_id_pk
                JOIN sga_adm_sexo as se on se.sex_id_pk=per.sex_id_fk
            where
            ref_id_pk=?");
  $query->bindValue(1, $ref_id_pk);
  $query->execute();
  $per = $query->fetch(PDO::FETCH_ASSOC);
  $query->closeCursor();

//print_r($per);

//CARGAR DATOS DE REFERENCIA
  $query = $conn->prepare("select
	ref_id_pk,
	--ser_descripcion,
	--esp_descripcion,
	ref_medico,
	ref_codmsp,
	sgh_combercionmotivoreferencia('7',ref_tipo) as T1 ,
	sgh_combercionmotivoreferencia('8',ref_tipo) as T2 ,
	sgh_combercionmotivoreferencia('1',ref_motivo) as uno ,
	sgh_combercionmotivoreferencia('2',ref_motivo) as dos ,
	sgh_combercionmotivoreferencia('3',ref_motivo) as tres,
	sgh_combercionmotivoreferencia('4',ref_motivo) as cuatro,
	sgh_combercionmotivoreferencia('5',ref_motivo) as cinco ,
	sgh_combercionmotivoreferencia('6',ref_motivo) as otros ,
		ref_rescuad,ref_halrel,ref_medico,ref_codmsp, ref_estado, ref_motivo_cancelar, 
    to_char((ref_usuario_cancelar->>'fecha')::timestamp,'dd-MM-YYYY HH24:MI') || ' / ' || upper(ref_usuario_cancelar->>'usu_login') ref_usuario_cancelar
		from sgh_mei_referencia referencia
		--inner join sga_adm_especialidad especialidad on especialidad.esp_id_pk = referencia.ref_id_especialidad
		--inner join sga_adm_servicio servicio on servicio.ser_id_pk = referencia.ref_id_servicio
		where ref_id_pk=?");
  $query->bindValue(1, $ref_id_pk);
  $query->execute();
  $ref = $query->fetch(PDO::FETCH_ASSOC);
  $query->closeCursor();
  //var_dump($ref_id_pk);
  //var_dump($ref);

# CARGAR Diagnostico. array 0
  $query = $conn->prepare("select
            c10_nombre as Diagnostico,c10_codigo as cie_10,dia_resp,sgh_conbiertepre('1',dia_resp) as pre,sgh_conbiertepre('2',dia_resp) as def
            from
                sgh_mei_drd
			JOIN sgh_mei_diagnos as d on dia_id_fk=d.dia_id_pk
			JOIN sgh_mei_codigocie10 as c10  on d.c10_id_fk=c10.c10_id_pk
			where ref_id_fk=?");
  $query->bindValue(1, $ref_id_pk);
  $query->execute();
  $dia = $query->fetchAll(PDO::FETCH_ASSOC);
  $query->closeCursor();
  //var_dump($dia); die();
//print_r($dia);

// institucion destino
  $query = $conn->prepare("
    select
    ins_abreviacion as Entidad,
    eta_descripcion,
    ref_servi,
    ref_espec,
    --ser_descripcion,
    --esp_descripcion,
    to_char(ref_fecha,'dd-MM-YYYY') as ref_fecha,
    tip.tin_abreviacion as tipo
    from sgh_mei_referencia as r
    join sga_adm_historiaclinica as hist on r.hce_id_fk=hist.hce_id_pk
    join sga_adm_establecimiento as es on r.ins_de_fk =es.eta_id_pk
    join sga_adm_institucion as ins on es.ins_id_fk=ins.ins_id_pk
    join sga_adm_tipologiainstitucion as tip on es.tin_id_fk= tip.tin_id_pk
    join sga_adm_nivelinstitucion as niv on tip.nin_id_fk=niv.nin_id_pk
    --inner join sga_adm_especialidad especialidad on especialidad.esp_id_pk = r.ref_id_especialidad
    --inner join sga_adm_servicio servicio on servicio.ser_id_pk = r.ref_id_servicio
    where ref_id_pk=?
");
  $query->bindValue(1, $ref_id_pk);
  $query->execute();
  $insd = $query->fetch(PDO::FETCH_ASSOC);
  $query->closeCursor();
  //print_r($ref_id_pk);
  //var_dump($insd); die();

//print_r($insd);

//institucion origen
  $query = $conn->prepare("select
establecimiento.eta_descripcion as establecimiento_or,
institucion.ins_abreviacion as entidad_or,
tipoins.tin_abreviacion as tipo,
provincia.prv_codigo || distrito.zon_descripcion distrito_or
from
sgh_mei_referencia as r
INNER JOIN sga_adm_establecimiento establecimiento ON establecimiento.eta_id_pk = r.ins_or_fk
INNER JOIN sga_adm_institucion institucion ON institucion.ins_id_pk = establecimiento.ins_id_fk
INNER JOIN sga_adm_tipologiainstitucion tipoins ON tipoins.tin_id_pk = establecimiento.tin_id_fk
INNER JOIN sga_adm_parroquia parroquia ON parroquia.par_id_pk = establecimiento.par_id_fk
INNER JOIN sga_adm_canton canton ON canton.can_id_pk = parroquia.can_id_fk
INNER JOIN sga_adm_zona distrito ON distrito.zon_id_pk = canton.zon_id_fk
INNER JOIN sga_adm_provincia provincia ON provincia.prv_id_pk = canton.prv_id_fk
where ref_id_pk=?");
  $query->bindValue(1, $ref_id_pk);
  $query->execute();
  $inor = $query->fetch(PDO::FETCH_ASSOC);
  $query->closeCursor();
  //var_dump($inor); die();
//print_r($inor);

//Contrareferencia
  $query = $conn->prepare("select
    ref_id_pk,
    ser_descripcion,
    esp_descripcion,
    ref_medico,
    ref_codmsp,
    sgh_combercionmotivoreferencia('7',ref_tipo) as T1 ,
    sgh_combercionmotivoreferencia('8',ref_tipo) as T2 ,
    ref_rescuad,
    ref_halrel,
    ref_trarea,
    ref_trarec,
    concat_ws(' ',per_apellidopaterno, per_apellidomaterno , per_nombres ) pro_nombres_completos,
    profesional.pro_codigomsp,
    ref_justif,
    to_char(ref_fecha,'dd-MM-YYYY') as ref_fecha
    from sgh_mei_referencia referencia
    inner join sga_adm_especialidad especialidad on especialidad.esp_id_pk = referencia.ref_id_especialidad
    inner join sga_adm_servicio servicio on servicio.ser_id_pk = referencia.ref_id_servicio
    inner join sga_adm_profesional profesional on profesional.pro_id_pk = referencia.ref_id_medico
    inner join sga_adm_persona persona on persona.per_id_pk = profesional.per_id_fk
    where ref_id_fk=?");
  $query->bindValue(1, $ref_id_pk);
  $query->execute();
  $contraref = $query->fetch(PDO::FETCH_ASSOC);
  $query->closeCursor();
  //var_dump($contraref); die();

  $id_contrareferencia = empty($contraref)?null:$contraref['ref_id_pk'];
  //var_dump($id_contrareferencia);

//Diagnostico
  $diaContra = null;
  if ($id_contrareferencia){
    $query = $conn->prepare("select
            c10_nombre as Diagnostico,c10_codigo as cie_10,
            dia_resp,sgh_conbiertepre('1',dia_resp) as pre,
            sgh_conbiertepre('2',dia_resp) as def
            from sgh_mei_drd
			JOIN sgh_mei_diagnos as d on dia_id_fk=d.dia_id_pk
			JOIN sgh_mei_codigocie10 as c10  on d.c10_id_fk=c10.c10_id_pk
			where ref_id_fk=?");
    $query->bindValue(1, $id_contrareferencia);
    $query->execute();
    $diaContra = $query->fetchAll(PDO::FETCH_ASSOC);
    $query->closeCursor();
  }
  //var_dump($diaContra); die();
//print_r($diaContra);

  $style= '
  <style>
    body{
     font-family: "sans-serif","arial","times";
        font-size: 9pt;
    }
     .table {
        border-collapse: collapse;
        text-align: center;
        width: 100%;
      }

      .table th, .table td {
          border: 1px solid black;
          font-weight: bold;
      }

      .table td {
        font-weight: normal;
      }

      .table-none {
        border: none;
        text-align: center;
      }

      .table-none th,.table-none td {
        border: none;
        padding: 0px;
      }

      .etiqueta8 tr, .etiqueta8 td {
        font-size: 8pt;
      }

      .etiqueta6 tr, .etiqueta6 td {
        font-size: 6pt;
      }
  </style>
  ';

  $html = '
    <table class="table">
    <thead>
      <tr>
        <th rowspan="2"><img src="../../../../img/msp.jpg" width="110" height="30"></th>
        <th>MINISTERIO DE SALUD PÚBLICA</th>
      </tr>
      <tr>
        <th>'.$inor['establecimiento_or'].'</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td colspan="2" style="font-weight: bold">FORMULARIO DE REFERENCIA, DERIVACIÓN, CONTRAREFERENCIA Y REFERENCIA INVERSA</td>
      </tr>
    </tbody>
    </table>

    <table class="table">
<thead>
  <tr>
    <th colspan="9" style="text-align: left">I. DATOS DEL USUARIO/USUARIA</th>
  </tr>
</thead>
<tbody>
  <tr class="etiqueta8">
    <td>Apellido paterno</td>
    <td>Apellido Materno</td>
    <td colspan="3">Nombres</td>
    <td colspan="3">Fecha de Nacimiento</td>
    <td>Sexo</td>
  </tr>
  <tr>
    <td>'. $per['per_apellidopaterno'] .'</td>
    <td>' . $per['per_apellidomaterno'] . '</td>
    <td colspan="3">' . $per['per_nombres'] . '</td>
    <td colspan="3">' . $per['per_fechanacimiento'] . '</td>
    <td>' . $per['sexo'] . '</td>
  </tr>
  <tr class="etiqueta6">
    <td colspan="5"></td>
    <td>día</td>
    <td>mes</td>
    <td>año</td>
    <td>1=H / 2=M</td>
  </tr>
  <tr class="etiqueta8">
    <td>Nacionalidad</td>
    <td>País</td>
    <td>Cédula de Ciudadanía<br>o Pasaporte</td>
    <td colspan="3">Lugar de residencia actual</td>
    <td colspan="2">Dirección Domicilio</td>
    <td>N° Teléfono</td>
  </tr>
  <tr>
    <td>' . $per['pai_descripcion'] . '</td>
    <td>' . $per['pai_descripcion'] . '</td>
    <td>' . $per['per_numeroidentificacion'] . '</td>
    <td>' . $per['prv_descripcion'] . '</td>
    <td>' . $per['can_descripcion'] . '</td>
    <td>' . $per['par_descripcion'] . '</td>
    <td colspan="2">' . $per['per_direccionprincipal'] . '</td>
    <td>' . $per['tel_numero'] . '</td>
  </tr>
  <tr class="etiqueta6">
    <td>1=Ecua / 2=Ext.</td>
    <td></td>
    <td></td>
    <td>Provincia</td>
    <td>Cantón</td>
    <td>Parroquia</td>
    <td colspan="2"></td>
    <td></td>
  </tr>
</tbody>
</table>';

$html .= '<table>
<thead>
  <tr>
    <td style="text-align: left; font-weight: bold">II. REFERENCIA:</td>
    <td></td>
    <td>1</td>
    <td><table class="table"><tr><td style="width: 15px">' . ($ref['t1']??'') . '</td></tr></table></td>
    <td></td>
    <td style="text-align: left; font-weight: bold">DERIVACIÓN:</td>
    <td>2</td>
    <td><table class="table"><tr><td style="width: 15px">' . ($ref['t2']?? '') . '</td></tr></table></td>
  </tr>
</thead>
</table>
  ';

  $html .= '
    <table class="table">
      <thead>
        <tr>
          <th colspan="9" style="text-align: left">1. Datos institucionales</th>
        </tr>
      </thead>
      <tbody>
        <tr class="etiqueta8">
          <td>Entidad del sistema</td>
          <td>Hist. Clínica No.</td>
          <td>Establecimiento de salud</td>
          <td>Tipo</td>
          <td colspan="5">Distrito/Área</td>
        </tr>
        <tr>
          <td>' . $inor['entidad_or'] . '</td>
          <td>' . $per['per_numeroidentificacion'] . '</td>
          <td>' . $inor['establecimiento_or'] . '</td>
          <td>' . $inor['tipo'] . '</td>
          <td colspan="5">' . $inor['distrito_or'] . '</td>
        </tr>
        <tr>
          <td colspan="6">Refiere o Deriva a:</td>
          <td colspan="3">Fecha</td>
        </tr>
        <tr>
          <td>' . $insd['entidad'] . '</td>
          <td colspan="2">' . $insd['eta_descripcion']  . '</td>
          <td colspan="2">' . $insd['ref_servi']  . '</td>
          <td>' . $insd['ref_espec'] . '</td>
          <td  colspan="3">' . $insd['ref_fecha']  . '</td>
        </tr>
        <tr class="etiqueta6">
          <td>Entidad del Sistema</td>
          <td colspan="2">Establecimiento de Salud</td>
          <td colspan="2">Servicio</td>
          <td>Especialidad</td>
          <td>día</td>
          <td>mes</td>
          <td>año</td>
        </tr>
        <tr>
          <td colspan="9" style="text-align: left; font-weight: bold">2. Motivo de la Referencia o Derivación:</td>
        </tr>
        <tr>
          <td colspan="9">
            <table class="table-none" style="width:100%; text-align: left">
              <tbody>
                <tr>
                    <td>Limitada capacidad resolutiva</td>
                    <td></td>
                    <td>1</td>
                    <td><table class="table"><tr><td>' . ($ref['uno']?? '') . '</td></tr></table></td>
                    <td>&nbsp;</td>
                    <td>Saturación de capacidad instalada</td>
                    <td></td>
                    <td>4</td>
                    <td><table class="table"><tr><td>' . ($ref['cuatro']?? '') . '</td></tr></table></td>
                  </tr>
                <tr>
                  <td>Ausencia temporal del profesional</td>
                  <td></td>
                  <td>2</td>
                  <td><table class="table"><tr><td>' . ($ref['dos']?? '') . '</td></tr></table></td>
                  <td>&nbsp;</td>
                  <td>Otros/Especifique</td>
                  <td></td>
                  <td>5</td>
                  <td><table class="table"><tr><td>' . ($ref['cinco']?? '') . '</td></tr></table></td>
                </tr>
                <tr>
                  <td>Falta de profesional</td>
                  <td></td>
                  <td>3</td>
                  <td><table class="table"><tr><td>' . ($ref['tres']?? '') . '</td></tr></table></td>
                  <td></td>
                  <td>' . $ref['otros'] . '</td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
              </tbody>
              </table>
          </td>
        </tr>
        <tr>
          <td colspan="9" style="text-align: left; font-weight: bold">3. Resumen del cuadro clínico</td>
        </tr>
        <tr>
          <td colspan="9">' . ($ref['ref_rescuad']?:'<br><br><br>') . '</td>
        </tr>
        <tr>
          <td colspan="9" style="text-align: left; font-weight: bold">4. Hallazgos relevantes de exámenes y procedimientos diagnósticos</td>
        </tr>
        <tr>
          <td colspan="9">' . ($ref['ref_halrel']?:'<br><br><br>') . '</td>
        </tr>
        <tr>
          <td colspan="9" style="text-align: left; font-weight: bold">5. Diagnóstico</td>
        </tr>
        <tr>
          <td colspan="9">
            <table class="table" style="width:100%; text-align: left">
              <thead>
                <tr class="etiqueta8">
                  <th colspan="2"></th>
                  <th>CIE-10</th>
                  <th>PRE</th>
                  <th>DEF</th>
                </tr>
              </thead>
              <tbody>';
              for ($i=0; $i<sizeof($dia);$i++){
      $html .= '<tr>
                  <td>'. ($i+1) .'</td>
                  <td>' . $dia[$i]['diagnostico'] . '</td>
                  <td style="text-align: center">' . $dia[$i]['cie_10'] . '</td>
                  <td style="text-align: center">' . $dia[$i]['pre'] . '</td>
                  <td style="text-align: center">' . $dia[$i]['def'] . '</td>
                </tr>';
               }
      $html .='<tbody>
              </table>
          </td>
        </tr>
        <tr>
          <td colspan="9">
            <table class="table-none" style="width:100%; text-align: left">
              <thead>
                <tr>
                  <td>Nombre del profesional:</td>
                  <td>' . $ref['ref_medico'] . '</td>
                  <td>&nbsp;</td>
                  <td>Código MSP:</td>
                  <td>' . $ref['ref_codmsp'] . '</td>
                  <td>&nbsp;</td>
                  <td>Firma:</td>
                  <td>____________________</td>
                </tr>
              </thead>
              </table>
          </td>
        </tr>
      </tbody>
      </table>
  ';

  //referencia cancelada
 if ($ref['ref_estado']==false){
  $html.='<br>
  <table class="table">
    <thead>
      <tr>
        <th colspan="2">CANCELADA</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>FECHA Y USUARIO</td>
        <td>'.$ref['ref_usuario_cancelar'].'</td>
      </tr>
      <tr>
        <td>MOTIVO</td>
        <td>'.$ref['ref_motivo_cancelar'].'</td>
      </tr>
    </tbody>
    </table>
  ';
 }

  // contrareferencia
  $html .= '<table>
<thead>
  <tr>
    <td style="text-align: left; font-weight: bold">III. CONTRAREFERENCIA:</td>
    <td></td>
    <td>1</td>
    <td><table class="table"><tr><td style="width: 15px">X</td></tr></table></td>
    <td></td>
    <td style="text-align: left; font-weight: bold">REFERENCIA INVERSA:</td>
    <td>2</td>
    <td><table class="table"><tr><td style="width: 15px">&nbsp;</td></tr></table></td>
  </tr>
</thead>
</table>
  ';

  $html .= '
    <table class="table">
      <thead>
        <tr>
          <th colspan="9" style="text-align: left">1. Datos institucionales</th>
        </tr>
      </thead>
      <tbody>
        <tr class="etiqueta8">
          <td>Entidad del sistema</td>
          <td>Hist. Clínica No.</td>
          <td>Establecimiento de salud</td>
          <td>Tipo</td>
          <td>Servicio</td>
          <td colspan="4">Especialidad del servicio</td>
        </tr>
        <tr>
          <td>' . $insd['entidad'] . '</td>
          <td>' . $per['per_numeroidentificacion'] . '</td>
          <td>' . $insd['eta_descripcion'] . '</td>
          <td>' . $insd['tipo'] . '</td>
          <td>' . $insd['ref_servi'] . '</td>
          <td colspan="4">' . $insd['ref_espec'] . '</td>
        </tr>
        <tr>
          <td colspan="6">Refiere o Deriva a:</td>
          <td colspan="3">Fecha</td>
        </tr>
        <tr>
          <td>' . $inor['entidad_or'] . '</td>
          <td colspan="2">' . $inor['establecimiento_or'] . '</td>
          <td colspan="2">' . $inor['tipo'] . '</td>
          <td>' . $inor['distrito_or'] . '</td>
          <td colspan="3">' . ($contraref?$contraref['ref_fecha']:'') . '</td>
        </tr>
        <tr class="etiqueta6">
          <td>Entidad del Sistema</td>
          <td colspan="2">Establecimiento de Salud</td>
          <td colspan="2">Tipo</td>
          <td>Distrito/Área</td>
          <td>día</td>
          <td>mes</td>
          <td>año</td>
        </tr>
        <tr>
          <td colspan="9" style="text-align: left; font-weight: bold">3. Resumen del cuadro clínico</td>
        </tr>
        <tr>
          <td colspan="9">' . ($contraref?$contraref['ref_rescuad']:'<br><br><br>') . '</td>
        </tr>
        <tr>
          <td colspan="9" style="text-align: left; font-weight: bold">4. Hallazgos relevantes de exámenes y procedimientos diagnósticos</td>
        </tr>
        <tr>
          <td colspan="9">' . ($contraref?$contraref['ref_halrel']:'<br><br><br>') . '</td>
        </tr>
        <tr>
          <td colspan="9" style="text-align: left; font-weight: bold">4. Tratamientos y procedimientos terapéuticos realizados</td>
        </tr>
        <tr>
          <td colspan="9">' . ($contraref?$contraref['ref_trarea']:'<br><br><br>') . '</td>
        </tr>
        <tr>
          <td colspan="9" style="text-align: left; font-weight: bold">5. Diagnóstico</td>
        </tr>
        <tr>
          <td colspan="9">
            <table class="table" style="width:100%; text-align: left">
              <thead>
                <tr class="etiqueta8">
                  <th colspan="2"></th>
                  <th>CIE-10</th>
                  <th>PRE</th>
                  <th>DEF</th>
                </tr>
              </thead>
              <tbody>';
  $dc = sizeof($dia);
  //$dc=3;
  for ($i=0; $i<$dc;$i++){
    $html .= '<tr>
                  <td>'. ($i+1) .'</td>
                  <td>' . ($diaContra?$diaContra[$i]['diagnostico']:'') . '</td>
                  <td style="text-align: center">' .( $diaContra?$diaContra[$i]['cie_10']:'') . '</td>
                  <td style="text-align: center">' . ($diaContra?$diaContra[$i]['pre']:'') . '</td>
                  <td style="text-align: center">' . ($diaContra?$diaContra[$i]['def']:'') . '</td>
                </tr>';
  }
  $html .='<tbody>
              </table>
          </td>
        </tr>
        <tr>
          <td colspan="9" style="text-align: left; font-weight: bold">6. Tratamiento recomendado a seguir en Establecimiento de Saluld de menor nivel de complejidad</td>
        </tr>
        <tr>
          <td colspan="9">' . ($contraref?$contraref['ref_trarec']:'<br><br><br>') . '</td>
        </tr>
        <tr>
          <td colspan="9">
            <table class="table-none" style="width:100%; text-align: left">
              <thead>
                <tr>
                  <td>Nombre del profesional:</td>
                  <td>' . ($contraref?$contraref['pro_nombres_completos']:'&nbsp;') . '</td>
                  <td>&nbsp;</td>
                  <td>Código MSP:</td>
                  <td>' . ($contraref?$contraref['pro_codigomsp']:'&nbsp;') . '</td>
                  <td>&nbsp;</td>
                  <td>Firma:</td>
                  <td>____________________</td>
                </tr>
              </thead>
              </table>
          </td>
        </tr>
        <tr class="table-none">
          <td colspan="2" style="text-align: left;font-size: 6pt;font-weight: bold">MSP/DENAIS/form. 053/ene/2014</td>
          <td><table class="table"><tr><td style="font-weight: bold">7. Referencia justificada</td><td style="width: 10%">'. ($contraref?$contraref['ref_justif']:'&nbsp;') .'</td></tr></table></td>
          <td colspan="2"></td>
        </tr>
      </tbody>
      </table>
  ';

  $mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4',
    'default_font_size' => 10,
    'margin_left' => 10,
    'margin_right' => 10,
    'margin_top' => 5,
    'margin_bottom' => 10,
    'debug' => true
  ]);
  $mpdf->SetDisplayMode('fullpage');

  $mpdf->writeHTML($style);
  $mpdf->writeHTML($html);
  $mpdf->Output("referencia-{$per['per_numeroidentificacion']}.pdf", $tipo_file);
} catch (Exception $e){
  print_r($e->getMessage());
}
exit();

