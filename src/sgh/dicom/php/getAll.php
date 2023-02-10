<?php
     header('Content-Type: application/json;charset=utf-8');
     try {
        require_once '../../../../php/conexion.php';
        $data = json_decode(file_get_contents('php://input'),true);
        $conn = new Conectar();

        $query = $conn->prepare("select json_agg(row) from (
                                           select 
                                           hca_id_pk,
                                           hce_id_fk,
                                           per_apellidopaterno || ' ' || coalesce(per_apellidomaterno ||' ','') ||' ' || per_nombres paciente,
                                           date_part('year',age(per_fechanacimiento)) || ' año(s) ' || date_part('mons',age(per_fechanacimiento)) || ' mes(es) ' || date_part('days',age(per_fechanacimiento)) || ' día(s)' edad, 
                                           hca_descripcion,
                                           hca_tamano,
                                           hca_tipo,                                        
                                           hca_fecha,
                                           tdo_id_fk,
                                           hca_ruta,
                                           hca_ruta_vista,
                                           hca_extension,
                                          '/sgh_archivos' || right(hca_ruta,length(hca_ruta)+1 - position('/sgadm' in hca_ruta)) hca_ruta_corta,
                                           tdo_descripcion
                                           from sga_adm_historiaclinica_archivo archivo
                                           join sga_adm_historiaclinica_tipodocumento tipo on tipo.tdo_id_pk = archivo.tdo_id_fk
                                           join sga_adm_historiaclinica hc on hc.hce_id_pk = archivo.hce_id_fk
                                           join sga_adm_paciente pac on pac.pac_id_pk =  hc.pac_id_fk
                                           join sga_adm_persona per on per.per_id_pk = pac.per_id_fk
                                           where 
                                           tdo_id_fk = 7
                                           and hce_id_fk = ?
                                           ) row;");
        $query->bindValue(1,$data['hce_id_fk']);
        $query->execute();
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        //echo json_encode($rows);
        print_r($rows[0]['json_agg']);
    } catch(Exception $e) {
            echo json_encode(array('Estado' => 3,'Mensaje' => 'Error: '. $e->getMessage()));
        }
?>