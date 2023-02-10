<?php
     //header("Content-Type: application/json;charset=utf-8");
     try {
        require_once "../../../../php/conexion.php";

        $data = json_decode(file_get_contents("php://input"));
        $tzo_id_pk = $data->{'tzo_id_pk'};

        $conn = db_connect();
        $query = $conn->prepare("select json_agg(t order by tzo_id_pk asc) from sga_adm_tipozona t;");
        $query->bindValue(1,$tzo_id_pk);
        $query->execute();

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        //$query->closeCursor();
        //echo json_encode($rows);
        print_r($rows[0]["json_agg"]);
     } catch(Exception $e) {
         echo "Error: ". $e->getMessage();
     }
?>