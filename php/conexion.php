<?php
	/**
	*Autor: R
	Fecha: 17 de octubre del 2016 :
	Descripcion: 
				$sghUrl= url de la base de datos.
				$sghUser= nombre de la base de datos.
				$sguPass= clave de la base de datos. 				

	Relaciones: Conexion principar para todo el sistema..
	*/
    /*
     * CONEXXION LOCAL SERVIDOR
      $sghUrl="pgsql:host=172.20.19.177;port=5433;dbname=sgh_database";
				$sghUser="rafael.real";
				$sghPass="r.f2017";
	 */
	class Conectar extends PDO 
	{
		public function __construct(){
			try {

                //$sghUrl="pgsql:host=181.196.107.91;port=5433;dbname=sgh_database";
                $sghUrl="pgsql:host=his.hgdz.gob.ec;port=5432;dbname=his_database";
                //$sghUser="sih.hospitalizacion";
				//$sghPass="Hgdz.H0sp1t@lizac10n.2019";
				$sghUser="vinicio.gomez";
                $sghPass="Sport2023*";
                parent::__construct($sghUrl,$sghUser,$sghPass);
				$this->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		    }
		    catch (Exception $c) 
			  {
				 die("La base de datos selecionada no existe ");
			  }
		}
	}
?>
