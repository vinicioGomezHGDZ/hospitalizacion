     <?php

   // incluir conección de base de datos 
  require_once("../../../../php/conexion.php");
	$conn=new Conectar();	
	include_once("../../../../php/class_consulta.php");
  $Con=New Consulta();

	$data = json_decode(file_get_contents("php://input"));
  $null=null; 
 
 switch ($data->op)
 {
case 1:
  $datos =$data->ana;
  $items = $data->items;
  $op=4;
  $an=5;
  //$an=1;
  ///guarda anamnesis
      try{

          $consulta = $conn->prepare('SELECT sgh_anamnesis_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
          $consulta->bindParam(1, $an, PDO::PARAM_STR, 4000);
          $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
          $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
          $consulta->bindParam(4, $datos->{'ana_motivo'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(5, $datos->{'ana_menarq'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(6, $datos->{'ana_menopa'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(7, $datos->{'ana_ciclos'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(8, $datos->{'ana_vidasex'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(9, $datos->{'ana_gesta'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(10, $datos->{'ana_paros'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(11, $datos->{'ana_aborto'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(12, $datos->{'ana_cesarea'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(13, $datos->{'ana_hijosv'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(14, $datos->{'ana_fum'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(15, $datos->{'ana_fup'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(16, $datos->{'ana_fuc'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(17, $datos->{'ana_biopsia'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(18, $datos->{'ana_mepfam'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(19, $datos->{'ana_terhor'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(20, $datos->{'ana_colcop'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(21, $datos->{'ana_mamogr'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(22, $datos->{'ana_desant'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(23, $datos->{'ana_antfam'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(24, $datos->{'ana_enfpra'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(25, $datos->{'ana_desrev'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(26, $datos->{'ana_exafis'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(27, $datos->{'ana_plantr'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(28, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(29, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(30, $datos->{'siv_prarta'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(31, $datos->{'siv_frecar'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(32, $datos->{'siv_freres'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(33, $datos->{'siv_tempvo'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(34, $datos->{'siv_temper'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(35, $datos->{'siv_peso'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(36, $datos->{'siv_talla'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(37, $datos->{'siv_percef'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(38, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(39, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(40, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(41, $datos->{'ana_id_pk'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(42, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(43, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(44, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(45, $datos->{'ana_fecha'}, PDO::PARAM_STR, 4000);

          $consulta->execute();

         $dat=$consulta->fetch (PDO::FETCH_ASSOC);
          $consulta->closeCursor();
         
        }
    catch(PDOException $Exception){
              $dat= $Exception;
        }       
        $res = json_encode($dat);
        echo $res;
  /// guarda respuesta items  
     for ($i=0; $i < sizeof($items); $i++) {
     $res=$items[$i];
   //print_r($res);
    foreach($res as $clave => $valor)
    {    
        $respuesta=$valor;
        $item=$clave;
        $punto="anamnesis";
        

          $consulta = $conn->prepare('SELECT sgh_anamnesis_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
          $consulta->bindParam(1, $op, PDO::PARAM_STR, 4000);
          $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
          $consulta->bindParam(3, $null, 4000);
          $consulta->bindParam(4, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(5, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(6, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(7, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(8, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(9, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(10, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(11, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(12, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(13, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(14, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(15, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(16, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(17, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(18, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(19, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(20, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(21, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(22, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(23, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(24, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(25, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(26, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(27, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(28, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(29, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(30, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(31, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(32, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(33, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(34, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(35, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(36, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(37, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(38, $respuesta, PDO::PARAM_STR, 4000);
          $consulta->bindParam(39, $item, PDO::PARAM_STR, 4000);
          $consulta->bindParam(40, $punto, PDO::PARAM_STR, 4000);
          $consulta->bindParam(41, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(42, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(43, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(44, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(45, $datos->{'ana_fecha'}, PDO::PARAM_STR, 4000);
          $consulta->execute();
    } 
   } 
  
  break;
case 2:
// guardar diagnostico 
  $cie10=$data->c10;
  for ($i=0; $i < sizeof($cie10); $i++) {
    try{
       
        $consulta = $conn->prepare('SELECT sgh_anamnesis_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
        $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
        $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
        $consulta->bindParam(3, $null, 4000);
        $consulta->bindParam(4, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(5, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(6, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(7, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(8, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(9, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(10, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(11, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(12, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(13, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(14, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(15, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(16, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(17, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(18, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(19, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(20, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(21, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(22, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(23, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(24, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(25, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(26, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(27, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(28, $cie10[$i]->{'c10_id_pk'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(29, $cie10[$i]->{'dia_resp'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(30, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(31, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(32, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(33, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(34, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(35, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(36, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(37, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(38, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(39, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(40, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(41, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(42, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(43, $null, PDO::PARAM_STR, 4000);    
        $consulta->bindParam(44, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(45, $null, PDO::PARAM_STR, 4000);
        $consulta->execute();
        
        $dat=$consulta->fetch (PDO::FETCH_ASSOC);
        $consulta->closeCursor();
       
       }
        catch(PDOException $Exception){
            $dat= $Exception;
          } 
  }              
   // $res = json_encode($dat);
   // echo $res;
break;
case 5:
  $datos =$data->ana;
  $items = $data->items;
  $op=8;
  $sv=7;
  ///edita datos de anamnesis
      try{

          $consulta = $conn->prepare('SELECT sgh_anamnesis_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
          $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
          $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
          $consulta->bindParam(3, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(4, $datos->{'ana_motivo'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(5, $datos->{'ana_menarq'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(6, $datos->{'ana_menopa'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(7, $datos->{'ana_ciclos'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(8, $datos->{'ana_vidasex'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(9, $datos->{'ana_gesta'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(10, $datos->{'ana_paros'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(11, $datos->{'ana_aborto'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(12, $datos->{'ana_cesarea'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(13, $datos->{'ana_hijosv'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(14, $datos->{'ana_fum'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(15, $datos->{'ana_fup'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(16, $datos->{'ana_fuc'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(17, $datos->{'ana_biopsia'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(18, $datos->{'ana_mepfam'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(19, $datos->{'ana_terhor'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(20, $datos->{'ana_colcop'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(21, $datos->{'ana_mamogr'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(22, $datos->{'ana_desant'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(23, $datos->{'ana_antfam'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(24, $datos->{'ana_enfpra'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(25, $datos->{'ana_desrev'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(26, $datos->{'ana_exafis'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(27, $datos->{'ana_plantr'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(28, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(29, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(30, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(31, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(32, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(33, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(34, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(35, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(36, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(37, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(38, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(39, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(40, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(41, $datos->{'ana_id_pk'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(42, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(43, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(44, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(45, $datos->{'ana_fecha'}, PDO::PARAM_STR, 4000);
          $consulta->execute();

         $dat=$consulta->fetch (PDO::FETCH_ASSOC);
          $consulta->closeCursor();
         
        }
    catch(PDOException $Exception){
              $dat= $Exception;
        }       
        $res = json_encode($dat);
        echo $res;

$nombres=[
      'abdomen',
      'axilas',
      'boca',
      'cabeza',
      'cardio',
      'cardiorev',
      'columna',
      'cuello',
      'digestivo',
      'digestivorev',
      'endocrine',
      'endocrino',
      'genital',
      'genitales',
      'hemo',
      'hemorev',
      'ingle',
      'miembroi',
      'miembros',
      'musculo',
      'musculos',
      'nariz',
      'nervioso',
      'neurologico',
      'oidos',
      'ojos',
      'organos',
      'organosrev',
      'orofaringe',
      'piel',
      'respiratorio',
      'respiratoriorev',
      'torax',
      'urinario',
      'urinariorev',
];
  /// edita datos de respuesta revición 
  for ($i=0; $i < sizeof($items); $i++) {
    $respuesta=$items[$i]->{$nombres[$i]};
    $pat_id_pk=$items[$i]->{'pat_id_pk'}; 
          $consulta = $conn->prepare('SELECT sgh_anamnesis_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
          $consulta->bindParam(1, $op, PDO::PARAM_STR, 4000);
          $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
          $consulta->bindParam(3, $null, 4000);
          $consulta->bindParam(4, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(5, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(6, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(7, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(8, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(9, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(10, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(11, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(12, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(13, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(14, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(15, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(16, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(17, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(18, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(19, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(20, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(21, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(22, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(23, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(24, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(25, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(26, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(27, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(28, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(29, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(30, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(31, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(32, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(33, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(34, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(35, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(36, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(37, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(38, $respuesta, PDO::PARAM_STR, 4000);
          $consulta->bindParam(39, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(40, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(41, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(42, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(43, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(44, $pat_id_pk, PDO::PARAM_STR, 4000);
          $consulta->bindParam(45, $null, PDO::PARAM_STR, 4000);
          $consulta->execute();
 
  } 
  
  /// edita datos de signos vitales 
    try{

          $consulta = $conn->prepare('SELECT sgh_anamnesis_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
          $consulta->bindParam(1, $sv, PDO::PARAM_STR, 4000);
          $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
          $consulta->bindParam(3, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(4, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(5, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(6, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(7, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(8, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(9, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(10, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(11, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(12, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(13, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(14, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(15, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(16, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(17, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(18, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(19, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(20, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(21, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(22, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(23, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(24, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(25, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(26, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(27, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(28, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(29, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(30, $datos->{'siv_prarta'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(31, $datos->{'siv_frecar'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(32, $datos->{'siv_freres'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(33, $datos->{'siv_tempvo'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(34, $datos->{'siv_temper'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(35, $datos->{'siv_peso'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(36, $datos->{'siv_talla'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(37, $datos->{'siv_percef'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(38, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(39, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(40, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(41, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(42, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(43, $datos->{'siv_id_pk'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(44, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(45, $datos->{'ana_fecha'}, PDO::PARAM_STR, 4000);
          $consulta->execute();
          $dat=$consulta->fetch (PDO::FETCH_ASSOC);
          $consulta->closeCursor();
         
        }
      catch(PDOException $Exception){
              $dat= $Exception;
        }       

  break;

case 6:
  # editar datos de diagnostico
  $cie10=$data->c10;
  for ($i=0; $i < sizeof($cie10); $i++) {
    try{
       
        $consulta = $conn->prepare('SELECT sgh_anamnesis_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
        $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
        $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
        $consulta->bindParam(3, $null, 4000);
        $consulta->bindParam(4, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(5, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(6, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(7, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(8, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(9, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(10, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(11, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(12, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(13, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(14, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(15, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(16, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(17, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(18, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(19, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(20, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(21, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(22, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(23, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(24, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(25, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(26, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(27, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(28, $cie10[$i]->{'c10_id_pk'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(29, $cie10[$i]->{'dia_resp'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(30, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(31, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(32, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(33, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(34, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(35, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(36, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(37, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(38, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(39, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(40, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(41, $cie10[$i]->{'dia_id_pk'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(42, $cie10[$i]->{'dia_id_pk'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(43, $cie10[$i]->{'dia_id_pk'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(44, $cie10[$i]->{'dia_id_pk'}, PDO::PARAM_STR, 4000);
        $consulta->bindParam(45, $null, PDO::PARAM_STR, 4000);
        $consulta->execute();
        
        $dat=$consulta->fetch (PDO::FETCH_ASSOC);
        $consulta->closeCursor();
       
       }
        catch(PDOException $Exception){
            $dat= $Exception;
          } 
  }              
    $res = json_encode($dat); 
    echo $res;

  break;
case 9:
    try{
       
        $consulta = $conn->prepare('SELECT sgh_anamnesis_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
        $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
        $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
        $consulta->bindParam(3, $null, 4000);
        $consulta->bindParam(4, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(5, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(6, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(7, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(8, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(9, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(10, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(11, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(12, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(13, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(14, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(15, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(16, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(17, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(18, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(19, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(20, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(21, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(22, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(23, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(24, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(25, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(26, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(27, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(28, $data->c10_id_pk, PDO::PARAM_STR, 4000);
        $consulta->bindParam(29, $data->dia_resp, PDO::PARAM_STR, 4000);
        $consulta->bindParam(30, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(31, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(32, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(33, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(34, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(35, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(36, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(37, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(38, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(39, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(40, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(41, $data->ana_id_pk, PDO::PARAM_STR, 4000);
        $consulta->bindParam(42, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(43, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(44, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(45, $null, PDO::PARAM_STR, 4000);
        
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
  # code...
 $datos =$data->ana;
 $sv=3;
 $ana_sv=1;
try{
          $consulta = $conn->prepare('SELECT sgh_anamnesis_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
          $consulta->bindParam(1, $ana_sv, PDO::PARAM_STR, 4000);
          $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
          $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
          $consulta->bindParam(4, $datos->{'ana_motivo'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(5, $datos->{'ana_menarq'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(6, $datos->{'ana_menopa'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(7, $datos->{'ana_ciclos'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(8, $datos->{'ana_vidasex'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(9, $datos->{'ana_gesta'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(10, $datos->{'ana_paros'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(11, $datos->{'ana_aborto'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(12, $datos->{'ana_cesarea'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(13, $datos->{'ana_hijosv'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(14, $datos->{'ana_fum'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(15, $datos->{'ana_fup'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(16, $datos->{'ana_fuc'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(17, $datos->{'ana_biopsia'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(18, $datos->{'ana_mepfam'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(19, $datos->{'ana_terhor'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(20, $datos->{'ana_colcop'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(21, $datos->{'ana_mamogr'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(22, $datos->{'ana_desant'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(23, $datos->{'ana_antfam'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(24, $datos->{'ana_enfpra'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(25, $datos->{'ana_desrev'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(26, $datos->{'ana_exafis'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(27, $datos->{'ana_plantr'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(28, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(29, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(30, $datos->{'siv_prarta'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(31, $datos->{'siv_frecar'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(32, $datos->{'siv_freres'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(33, $datos->{'siv_tempvo'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(34, $datos->{'siv_temper'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(35, $datos->{'siv_peso'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(36, $datos->{'siv_talla'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(37, $datos->{'siv_percef'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(38, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(39, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(40, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(41, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(42, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(43, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(44, $null, PDO::PARAM_STR, 4000);
         $consulta->bindParam(45, $datos->{'ana_fecha'}, PDO::PARAM_STR, 4000);
          $consulta->execute();
          $dat=$consulta->fetch (PDO::FETCH_ASSOC);
          $consulta->closeCursor();
         
        }
      catch(PDOException $Exception){
              $dat= $Exception;
        }       
        $res = json_encode($dat); 
        echo $res;
  /// guardar signos vitales 
    try{

          $consulta = $conn->prepare('SELECT sgh_anamnesis_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
          $consulta->bindParam(1, $sv, PDO::PARAM_STR, 4000);
          $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
          $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
          $consulta->bindParam(4, $datos->{'ana_motivo'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(5, $datos->{'ana_menarq'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(6, $datos->{'ana_menopa'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(7, $datos->{'ana_ciclos'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(8, $datos->{'ana_vidasex'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(9, $datos->{'ana_gesta'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(10, $datos->{'ana_paros'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(11, $datos->{'ana_aborto'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(12, $datos->{'ana_cesarea'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(13, $datos->{'ana_hijosv'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(14, $datos->{'ana_fum'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(15, $datos->{'ana_fup'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(16, $datos->{'ana_fuc'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(17, $datos->{'ana_biopsia'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(18, $datos->{'ana_mepfam'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(19, $datos->{'ana_terhor'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(20, $datos->{'ana_colcop'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(21, $datos->{'ana_mamogr'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(22, $datos->{'ana_desant'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(23, $datos->{'ana_antfam'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(24, $datos->{'ana_enfpra'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(25, $datos->{'ana_desrev'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(26, $datos->{'ana_exafis'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(27, $datos->{'ana_plantr'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(28, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(29, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(30, $datos->{'siv_prarta'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(31, $datos->{'siv_frecar'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(32, $datos->{'siv_freres'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(33, $datos->{'siv_tempvo'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(34, $datos->{'siv_temper'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(35, $datos->{'siv_peso'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(36, $datos->{'siv_talla'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(37, $datos->{'siv_percef'}, PDO::PARAM_STR, 4000);
          $consulta->bindParam(38, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(39, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(40, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(41, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(42, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(43, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(44, $null, PDO::PARAM_STR, 4000);
          $consulta->bindParam(45, $datos->{'ana_fecha'}, PDO::PARAM_STR, 4000);
          $consulta->execute();
          $dat=$consulta->fetch (PDO::FETCH_ASSOC);
          $consulta->closeCursor();
         
        }
      catch(PDOException $Exception){
              $dat= $Exception;
        }       
       // $res = json_encode($dat); 
        //echo $res;

break;

case '10':
  try{

          $consulta = $conn->prepare('SELECT sgh_anamnesis_elimina_pa(?,?,?)');
          $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
          $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
          $consulta->bindParam(3, $data->Codigo, PDO::PARAM_STR, 4000);
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
