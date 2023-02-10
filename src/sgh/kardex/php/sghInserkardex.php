     <?php

   // incluir conección de base de datos 
    require_once("../../../../php/conexion.php");
	$conn=new Conectar();	
	
	$data = json_decode(file_get_contents("php://input"));

  $med =$data->med;

     switch ($data->op)
     {
         case 1:

	try{
    //Importo conexion de archivo debido a que mensaje de respuesta no devuelve con metodo de conexion

 	 $consulta = $conn->prepare('SELECT sgh_kardex_inreso_pa(?,?,?)');
     
      $consulta->bindParam(1, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $med->{'kar_medica'}, PDO::PARAM_STR, 4000);
      
      $consulta->execute();
      
      $dat=$consulta->fetch (PDO::FETCH_ASSOC);
      $consulta->closeCursor();
     
    }
  catch(PDOException $Exception){
          $dat= $Exception;
    }

  $res = json_encode($dat); 

echo $res;

             break;
         case 2 :

             $med=$data->med;
             $med_op="1";

             try{

                 //Importo conexion de archivo debido a que mensaje de respuesta no devuelve con metodo de conexion
                 $consulta = $conn->prepare('SELECT sgh_kardex_edita_pa(?,?,?,?)');

                 $consulta->bindParam(1, $med_op, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(2, $data->id, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(3, $med->{'kar_medica'}, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(4, $data->usu, PDO::PARAM_STR, 4000);
                 $consulta->execute();

                 $dat=$consulta->fetch (PDO::FETCH_ASSOC);
                 $consulta->closeCursor();

             }

             catch(PDOException $Exception)
             {
                 $dat= $Exception;
             }

             $res = json_encode( $dat );

             echo $res;

         break;

         default:
             # code...
             break;
     }

	?>