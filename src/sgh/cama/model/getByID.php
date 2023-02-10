<?php
    try {
        header("Content-Type: application/json;charset=utf-8");
        require_once "../../../../php/conexion.php";
        $conn = db_connect();

        $query = $conn->prepare("select max(tzo_id_pk)+1 as id_max from sga_adm_tipozona;");
        $query->execute();

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        //$query->closeCursor();
        echo json_encode($rows);
    } catch(Exception $e) {
        echo json_encode(array("Estado" => 3,"Mensaje" => "Error: ". $e->getMessage()));
    }
?>