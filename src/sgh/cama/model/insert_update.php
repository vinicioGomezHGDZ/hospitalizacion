<?php
     try {
        require_once "../../../../php/Database.php";

        $data = json_decode(file_get_contents("php://input"),true);
//
        $conn = db_connect();
        $query = $conn->prepare("select sp_sga_zona_ingresar (?,?,?,?,?)");
        $query->bindValue(1,$data["zon_id_pk"]);
        $query->bindValue(2,$data["tzo_id_fk"]);
        $query->bindValue(3,$data["zon_codigo"]);
        $query->bindValue(4,$data["zon_descripcion"]);
        $query->bindValue(5,$data["zon_visible"],PDO::PARAM_BOOL);
//        print_r($query);
        $query->execute();

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
//        print_r($rows);
        print_r($rows[0]["sp_sga_zona_ingresar"]);

    } catch(Exception $e) {
        echo "Error: ". $e->getMessage();
    }
?>