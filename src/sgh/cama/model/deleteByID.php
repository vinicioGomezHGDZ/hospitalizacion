<?php
    try
    {
        require_once "../../../../php/conexion.php";
        $data = json_decode(file_get_contents("php://input"));

        $tzo_id_pk = $data->{'tzo_id_pk'};
        $conn = db_connect();
        $query = $conn->prepare("select sp_sga_zona_eliminar_porid (?)");
        $query->bindValue(1,$tzo_id_pk);
        $query->execute();

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        print_r($rows[0]["sp_sga_zona_eliminar_porid"]);
        //echo json_encode(array("Estado" => 0,"Mensaje" => "Se ha eliminado con éxito"));
    } catch(Exception $e) {
        echo json_encode(array("Estado" => 3,"Mensaje" => "Error: ". $e->getMessage()));
    }
?>