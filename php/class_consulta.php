<?php
	require_once("conexion.php");

	class Consulta
	{
		private $datos;
        public $entidad="HOSPITAL GENERAL DR. GUSTAVO DOMINGUEZ ZAMBRANO";
		public function __construct()
		{
			$this->datos=array();
		}

		public function Get_Consulta($tabla,$cadena,$cadena2,$CampWher,$CampFil,$op)
		{
			$bdd= new Conectar();
			switch ($op) {
				case '1':
					$sql=$bdd->prepare("SELECT $cadena From $tabla order by $CampFil desc");
					break;
				case '2':
					$sql=$bdd->prepare("SELECT $cadena From $tabla where $CampWher='$CampFil'");
					break;
				case '3':
					$sql=$bdd->prepare("SELECT $cadena From $tabla order by $CampFil desc limit $CampWher,$cadena2");
					break;
				case '4':
					$sql=$bdd->prepare("SELECT $cadena From $tabla where $cadena2");
					break;
				case '5':
					$sql=$bdd->prepare("SELECT $cadena From $tabla");
					break;
				case '6':
					$sql=$bdd->prepare("SELECT DISTINCT $cadena From $tabla");
					break;
				default:
					# code...
					break;
			}
		$sql->execute();
		while ($dat=$sql->fetch (PDO::FETCH_ASSOC))
			{
				$this->datos[]=$dat;
			}
			return $this->datos;
		}

		
		function validarUsuario($tabla,$cadena,$campo,$campo1,$usuario,$clave)
		{
			
			print_r($_POST);
			$bdd= new Conectar();
			$sql=$bdd->prepare("SELECT $cadena From $tabla where $campo = '$usuario' and $campo1 = '$clave'");
			$sql->execute(); 
			$fila = $sql->fetch (PDO::FETCH_ASSOC);
				if (count($fila)>0){
					return true;						
			}
				else{					
					return false;
			}
			//if($fila['BHCUS_CONTRA'] != NULL)
			//////echo $sql1;
				//$reg1=mysql_query($sql1,Conectar::Conec());
			//	$fila1 = mysql_fetch_assoc($reg1);
			//	if($fila1['BHCUS_CONTRA']==1)
			//		return true;						
			//	else					
			//		return false;
			//}
			//else
			//		return false;
		}
		function validarCedula($ced)
		{
			$c=1;
			$coe=0;
			for ($i=0; $i<=strlen($ced)-2;$i++)
			{	
				$c=($c==1 ? 2 : 1);
				$mul=(substr($ced,$i,1))*$c;
				if($mul>9){
					$coe+=substr($mul,0,1)+substr($mul,1,1)*($c==2 ? 1 : 2);	
				}
				else{
					$coe+=$mul;
				}
			}
			$dt=$coe % 10;
			$dv=($dt==0 ? 0 : 10-($coe % 10));
	
			if($dv==substr($ced,9,1)){

				return true;
			}
			else
			{
				return false;
			}

		}
	}
?>
