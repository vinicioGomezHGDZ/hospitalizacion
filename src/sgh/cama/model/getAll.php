<?php
     //header("Content-Type: application/json;charset=utf-8");
     try {
        require_once "../../../../php/conexion.php";
        $data = json_decode(file_get_contents("php://input"),true);
        $conn = db_connect();

        if(isset($data["cam_visible_valor"]))
        {
            $data["cam_visible_valor"] = ($data["cam_visible_valor"] == 1 ? "true" : "false");
        }
        else
        {
            $data["cam_visible_valor"]="null";
        }
        $string = "select json_agg(row) from (
                                             SELECT
                                               c.*,
                                               t.tca_descripcion
                                             FROM sga_adm_cama c
                                               INNER JOIN sga_adm_tipocama t ON t.tca_id_pk = c.tca_serv_fk
                                               where cam_visible=coalesce(".$data['cam_visible_valor'].",cam_visible)
                                             order by cam_id_pk asc
                                           ) row;";
        $query = $conn->prepare($string);
        //$query = $conn->prepare("select json_agg(sga_adm_tipozona) from sga_adm_tipozona order by tzo_id_pk;");
//        print_r($string);
        $query->execute();

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        //$query->closeCursor();
        //echo json_encode($rows);
        print_r($rows[0]["json_agg"]);
    } catch(Exception $e) {
            echo json_encode(array("Estado" => 3,"Mensaje" => "Error: ". $e->getMessage()));
        }
?>