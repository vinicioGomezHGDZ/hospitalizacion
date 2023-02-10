<?php
/**
 * Created by PhpStorm.
 * User: vinicio.gomez
 * Date: 2019-02-14
 * Time: 15:44
 */
header('Content-Type: application/json;charset=utf-8');
try {
    require_once '../../../../php/conexion.php';
    $data = file_get_contents('php://input');
    $conn = new Conectar();

    $query = $conn->prepare('select json_agg(r) from (
        select * from sga_adm_pais
    )r;');
    //$query->bindValue(1,$data);
    $query->execute();
    $rows = $query->fetchColumn();
    $query->closeCursor();
    //echo json_encode($rows);
    print_r($rows);
} catch(Exception $e) {
    echo json_encode(array('Estado' => 3,'Mensaje' => 'Error: '. $e->getMessage()));
}
