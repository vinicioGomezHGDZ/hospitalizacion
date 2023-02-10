<?php
// retornma un json 

date_default_timezone_set('America/Guayaquil');
include_once("../../../../php/class_consulta.php");
$Con=New Consulta();


$data = json_decode(file_get_contents("php://input"));
$error="error";
switch ($data->op) {
	case '1':
	# code...

  				$Regd=$Con->Get_Consulta("sgh_mei_fisireabi WHERE hce_id_fk='".$data->idhc."'order by mfr_fecha desc","*","","","",5);
        	    //print_r($Regd);
				if (count($Regd)==0) 
				{
				echo json_encode(array('error' =>$error, )); 
				}else{
				echo json_encode($Regd); 
				}
	break;
	case '2':
		# code...
	  $Regd=$Con->Get_Consulta("sgh_mei_horario where mfr_di_fk='".$data->codigo."' order by hra_dia desc ","*","","","",5);
     //print_r($Regd);
       
                if (count($Regd)==0) 
                {

                echo json_encode(array('err'=> true,'mensaje'=>'codigo no exixte'));

                }else{
                echo json_encode($Regd); 
                } 
		break;
	
		case '3':
		# cargar datos para edicio
		 $time = time();
	 	$date=date("Y-m-d ", $time);
		$mensaje=0;
		$Regd=$Con->Get_Consulta("sgh_mei_fisireabi","*","","usu_id_fk='".$data->usu."' and mfr_fecha='".$date."' and  mfr_di_pk",$data->codigo,2);
	    
				if (count($Regd)==0) 
				{

				echo json_encode(array($mensaje));

				}else{
				echo json_encode($Regd); 
				} 
		break;
	default:
				# code...
				break;
		}		
?>
