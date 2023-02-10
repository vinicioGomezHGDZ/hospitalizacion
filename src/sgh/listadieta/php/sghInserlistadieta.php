<?php
require_once("../../../../php/conexion.php");
	$conn=new Conectar();	
	
	$data = json_decode(file_get_contents("php://input"));
	
	$datos=$data->di;

	switch ($data->op) {
		case '1':
			# code.. insertar dieta
			try{
      	
		  	  $consulta = $conn->prepare('SELECT sgh_listadieta_ingreso_pa(?,?,?,?,?,?)');
		      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
		      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
		      $consulta->bindParam(3, $datos->{'die_descrip'}, PDO::PARAM_STR, 4000);
		      $consulta->bindParam(4, $datos->{'die_estado'}, PDO::PARAM_STR, 4000);
		      $consulta->bindParam(5, $datos->{'die_id_pk'}, PDO::PARAM_STR, 4000);
		      $consulta->bindParam(6, $datos->{'die_orden'}, PDO::PARAM_STR, 4000);


                $consulta->execute();
		      
		      $dat=$consulta->fetch (PDO::FETCH_ASSOC);
		      $consulta->closeCursor();
		     
		 		}
		 	    catch(PDOException $Exception){$dat= $Exception;}
				
				$res = json_encode($dat);	
				echo $res;
			break;
		case '2':

			# code... editar dieta
			try{
      	
		  	  $consulta = $conn->prepare('SELECT sgh_listadieta_ingreso_pa(?,?,?,?,?,?)');
		      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
		      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
		      $consulta->bindParam(3, $datos->{'die_descrip'}, PDO::PARAM_STR, 4000);
		      $consulta->bindParam(4, $datos->{'die_estado'}, PDO::PARAM_STR, 4000);
		      $consulta->bindParam(5, $datos->{'die_id_pk'}, PDO::PARAM_STR, 4000);
              $consulta->bindParam(6, $datos->{'die_orden'}, PDO::PARAM_STR, 4000);

                $consulta->execute();
		      
		      $dat=$consulta->fetch (PDO::FETCH_ASSOC);
		      $consulta->closeCursor();
		     
		 		}
		 	    catch(PDOException $Exception){$dat= $Exception;}
				
				$res = json_encode($dat);	
				echo $res;
			break;
				case '3':
			# code... desactivar activar dieta
			try{
      	
		  	  $consulta = $conn->prepare('SELECT sgh_listadieta_ingreso_pa(?,?,?,?,?,?)');
		      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
		      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
		      $consulta->bindParam(3, $datos->{'die_descrip'}, PDO::PARAM_STR, 4000);
		      $consulta->bindParam(4, $data->esta, PDO::PARAM_STR, 4000);
		      $consulta->bindParam(5, $data->codgo, PDO::PARAM_STR, 4000);
              $consulta->bindParam(6, $datos->{'die_orden'}, PDO::PARAM_STR, 4000);

                $consulta->execute();
		      
		      $dat=$consulta->fetch (PDO::FETCH_ASSOC);
		      $consulta->closeCursor();
		     
		 		}
		 	    catch(PDOException $Exception){$dat= $Exception;}
				
				$res = json_encode($dat);	
				echo $res;
			break;
		default:
			# code...
			break;
	}
?>