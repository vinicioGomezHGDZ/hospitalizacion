     <?php
     date_default_timezone_set('America/Guayaquil');
   // incluir conección de base de datos 
    require_once("../../../../php/conexion.php");
	$conn=new Conectar();	
	
	$data = json_decode(file_get_contents("php://input"));
  $null=null;
	//declaracion de bariables

	 switch ($data->op) {
     case '1':
         $sgv =$data->sgv;
           try{
           //Importo conexion de archivo debido a que mensaje de respuesta no devuelve con metodo de conexion
               $consulta = $conn->prepare('SELECT sgh_sigvitalesdia_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
                 
                  $consulta->bindParam(1, $data->usu, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(2, $data->hcl, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(3, $sgv->{'svd_fcha'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(4, $data->diant, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(5, $sgv->{'svd_pulos'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(6, $sgv->{'svd_temper'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(7, $sgv->{'svd_freres'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(8, $sgv->{'svd_presis'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(9, $sgv->{'svd_predia'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(10, $sgv->{'svd_satoxi'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(11, $sgv->{'svd_parent'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(12, $sgv->{'svd_viaora'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(13, $sgv->{'svd_toting'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(14, $sgv->{'svd_orina'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(15, $sgv->{'svd_drenaj'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(16, $sgv->{'svd_otros'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(17, $sgv->{'svd_toteli'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(18, $sgv->{'svd_aseo'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(19, $sgv->{'svd_peso'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(20, $sgv->{'svd_dieadm'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(21, $sgv->{'svd_numcom'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(22, $sgv->{'svd_numicc'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(23, $sgv->{'svd_numdep'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(24, $sgv->{'svd_actfis'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(25, $sgv->{'svd_camson'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(26, $sgv->{'svd_recvia'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(27, $sgv->{'svd_banio'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(28, $data->cam, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(29, $null, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(30, $sgv->{'cdp_fpalta'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(31, $sgv->{'cdp_fopera'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(32, $sgv->{'cdp_fuoper'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(33, $sgv->{'cdp_id_med'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(34, $data->op, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(35, $null, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(36, $sgv->{'svd_talla'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(37, $sgv->{'svd_opingreso'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(38, $sgv->{'svd_perabdo'}, PDO::PARAM_STR, 4000);

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
     
     case '2':

           $sgv =$data->sgv;
              try{
           //Importo conexion de archivo debido a que mensaje de respuesta no devuelve con metodo de conexion
               $consulta = $conn->prepare('SELECT sgh_sigvitalesdia_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');

                  $consulta->bindParam(1, $data->usu, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(2, $data->hcl, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(3, $sgv->{'svd_fcha'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(4, $data->diant, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(5, $sgv->{'svd_pulos'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(6, $sgv->{'svd_temper'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(7, $sgv->{'svd_freres'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(8, $sgv->{'svd_presis'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(9, $sgv->{'svd_predia'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(10, $sgv->{'svd_satoxi'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(11, $sgv->{'svd_parent'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(12, $sgv->{'svd_viaora'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(13, $sgv->{'svd_toting'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(14, $sgv->{'svd_orina'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(15, $sgv->{'svd_drenaj'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(16, $sgv->{'svd_otros'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(17, $sgv->{'svd_toteli'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(18, $sgv->{'svd_aseo'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(19, $sgv->{'svd_peso'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(20, $sgv->{'svd_dieadm'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(21, $sgv->{'svd_numcom'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(22, $sgv->{'svd_numicc'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(23, $sgv->{'svd_numdep'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(24, $sgv->{'svd_actfis'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(25, $sgv->{'svd_camson'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(26, $sgv->{'svd_recvia'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(27, $sgv->{'svd_banio'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(28, $null, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(29, $null, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(30, $sgv->{'cdp_fpalta'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(31, $sgv->{'cdp_fopera'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(32, $sgv->{'cdp_fuoper'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(33, $sgv->{'cdp_id_med'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(34, $data->op, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(35, $sgv->{'svd_id_pk'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(36, $sgv->{'svd_talla'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(37, $sgv->{'svd_opingreso'}, PDO::PARAM_STR, 4000);
                  $consulta->bindParam(38, $sgv->{'svd_perabdo'}, PDO::PARAM_STR, 4000);

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

     case '3':
           $sgv =$data->sgv;

             try{
                 //Importo conexion de archivo debido a que mensaje de respuesta no devuelve con metodo de conexion
                 $consulta = $conn->prepare('SELECT sgh_sigvitalesdia_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');

                 $consulta->bindParam(1, $data->usu, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(2, $data->hcl, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(3, $sgv->{'svd_fcha'}, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(4, $data->diant, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(5, $sgv->{'svd_pulos'}, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(6, $sgv->{'svd_temper'}, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(7, $sgv->{'svd_freres'}, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(8, $sgv->{'svd_presis'}, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(9, $sgv->{'svd_predia'}, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(10, $sgv->{'svd_satoxi'}, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(11, $sgv->{'svd_parent'}, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(12, $sgv->{'svd_viaora'}, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(13, $sgv->{'svd_toting'}, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(14, $sgv->{'svd_orina'}, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(15, $sgv->{'svd_drenaj'}, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(16, $sgv->{'svd_otros'}, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(17, $sgv->{'svd_toteli'}, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(18, $sgv->{'svd_aseo'}, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(19, $sgv->{'svd_peso'}, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(20, $sgv->{'svd_dieadm'}, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(21, $sgv->{'svd_numcom'}, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(22, $sgv->{'svd_numicc'}, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(23, $sgv->{'svd_numdep'}, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(24, $sgv->{'svd_actfis'}, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(25, $sgv->{'svd_camson'}, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(26, $sgv->{'svd_recvia'}, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(27, $sgv->{'svd_banio'}, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(28, $data->cam, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(29, $data->con, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(30, $sgv->{'cdp_fpalta'}, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(31, $sgv->{'cdp_fopera'}, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(32, $sgv->{'cdp_fuoper'}, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(33, $sgv->{'cdp_id_med'}, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(34, $data->op, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(35, $null, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(36, $null, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(37, $null, PDO::PARAM_STR, 4000);
                 $consulta->bindParam(38, $null, PDO::PARAM_STR, 4000);


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

       default:
       # code...
       break;
   }
 

?>