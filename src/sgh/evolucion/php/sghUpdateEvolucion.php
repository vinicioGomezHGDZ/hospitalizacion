<?php

	require_once("../../../../php/class_actualizar.php");
	$conn=new Conectar();
	$Upd=New Actualizar();
		
	$data = json_decode(file_get_contents("php://input"));
	
	//print_r($data);
	
	$punto=$data->getpun;
 	$pun_estado=$data->est;
	$pun_id_pk= $punto[0]->{'pun_id'};
	$pun_descri= $punto[0]->{'pun_descri'};
	$pun_form= $punto[0]->{'pun_form'};
	
	 //Importo conexion de archivo debido a que mensaje de respuesta no devuelve con metodo de conexion
      $consulta = $conn->prepare('SELECT sgh_punt_edita_pa(?,?,?,?)');
      
      $consulta->bindParam(1, $pun_id_pk, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $pun_descri, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $pun_form, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $pun_estado, PDO::PARAM_STR, 4000);
     
     $echo= $consulta->execute();

$respuesta ="";
if ($echo == '1') {

$respuesta = json_encode(array('err' =>false,'mensaje'=>'resgistro actualizado' ));	
}else
{
	$respuesta = json_encode(array('err' =>true,'mensaje'=>$echo ));
}
	
echo $respuesta;
	
?>
