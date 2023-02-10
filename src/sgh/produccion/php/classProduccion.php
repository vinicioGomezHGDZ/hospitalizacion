<?php
/**
 * Created by PhpStorm.
 * User: vinicio.gomez
 * Date: 2019-02-14
 * Time: 15:44
 */
//header('Content-Type: application/json;charset=utf-8');
require_once '../../../../php/conexion.php';
function getAllEvolucion($data)
{
    try {
        //$data = file_get_contents('php://input');
        $conn = new Conectar();

        //print_r($data);
        $query = $conn->prepare("
            select 
                row_number() over() numero,
                eyp_asunto,
                eyp_fechas,
                eyp_hora,
                eyp_nodevu,
                eyp_prescr
                from sgh_mei_evolucion
            where usu_id_fk=?;
            ");
        $query->bindValue(1, $data['id_profesional']);
        $query->execute();
        $rows = $query->fetchAll(PDO::FETCH_NUM);
        $query->closeCursor();
        //echo json_encode($rows);
        //print('<pre>'.print_r($rows,true).'</pre>');
        return $rows;
    } catch (Exception $e) {
        echo json_encode(array('Estado' => 3, 'Mensaje' => 'Error: ' . $e->getMessage()));
    }
}
