     <?php

   // incluir conección de base de datos 
  require_once("../../../../php/conexion.php");
	$conn=new Conectar();	
	include_once("../../../../php/class_consulta.php");
  $Con=New Consulta();
 
	$data = json_decode(file_get_contents("php://input"));
  $null=null; 
  
   //print_r($data);
  switch ($data->op)
 {
case 1:
  $datos =$data->ana;
  $items = $data->items;
  $op=4;
  $adu=5;
  $sv=7;
  ///guarda adulto mayor
  try{

      $consulta = $conn->prepare('SELECT sgh_adulto_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $adu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $datos->{'aam_inform'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $datos->{'aam_respon'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos->{'aam_motivo'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $datos->{'aam_enferm'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos->{'aam_meqrec'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $datos->{'aam_esgene'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $datos->{'aam_reacsi'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $datos->{'aam_antepe'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12, $datos->{'aam_antfam'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(13, $datos->{'aam_exafis'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(14, $datos->{'aam_prudia'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(15, $datos->{'aam_trata'}, PDO::PARAM_STR, 4000);
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
      $consulta->bindParam(38, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(39, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(40, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(41, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(42, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(43, $datos->{'aam_id_pk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(44, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(45, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(46, $null, PDO::PARAM_STR, 4000);
      $consulta->execute();

      $dat=$consulta->fetch (PDO::FETCH_ASSOC);
      $consulta->closeCursor();
     
    }

  catch(PDOException $Exception){
          $dat= $Exception;
    }       
    $res = json_encode($dat); 
    echo $res;
    
  /// guarda respuestas de los items 
  for ($i=0; $i < sizeof($items); $i++) {
   $res=$items[$i];
    foreach($res as $clave => $valor)
    {
      $respuesta=$valor;
      $item=$clave;
      $punto="adulto";
       $consulta = $conn->prepare('SELECT sgh_adulto_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
        $consulta->bindParam(1, $op, PDO::PARAM_STR, 4000);
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
        $consulta->bindParam(40, $respuesta, PDO::PARAM_STR, 4000);
        $consulta->bindParam(41, $item, PDO::PARAM_STR, 4000);
        $consulta->bindParam(42, $punto, PDO::PARAM_STR, 4000);
        $consulta->bindParam(43, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(44, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(45, $null, PDO::PARAM_STR, 4000);
        $consulta->bindParam(46, $null, PDO::PARAM_STR, 4000);
        
        $consulta->execute();
    }

  }
  // guardar signos vitales

    try{
      $consulta = $conn->prepare('SELECT sgh_adulto_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $sv, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
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
      $consulta->bindParam(19, $datos->{'siv_prarta'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(20, $datos->{'siv_prarte'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(21, $datos->{'siv_temper'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(22, $datos->{'siv_pulso'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(23, $datos->{'siv_freres'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(24, $datos->{'siv_peso'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(25, $datos->{'siv_talla'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(26, $datos->{'siv_imc'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(27, $datos->{'siv_percint'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(28, $datos->{'siv_percad'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(29, $datos->{'siv_perpan'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(30, $datos->{'siv_defvis'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(31, $datos->{'siv_defaud'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(32, $datos->{'siv_levand'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(33, $datos->{'siv_peinor'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(34, $datos->{'siv_pemere'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(35, $datos->{'siv_perpes'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(36, $datos->{'siv_triste'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(37, $datos->{'siv_pubaso'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(38, $datos->{'siv_sacoso'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(39, $datos->{'siv_vivsol'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(40, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(41, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(42, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(43, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(44, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(45, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(46, $datos->{'siv_id_pk'}, PDO::PARAM_STR, 4000);
      
      $consulta->execute();
      
      //$dat=$consulta->fetch (PDO::FETCH_ASSOC);
      //$consulta->closeCursor();
     
    }
      catch(PDOException $Exception){$dat= $Exception;}       
    
break;

case 2:
    // guardar diagnostico 
   $cie10=$data->c10;
   for ($i=0; $i < sizeof($cie10); $i++) {
   try{
     
      $consulta = $conn->prepare('SELECT sgh_adulto_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
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
      $consulta->bindParam(16, $cie10[$i]->{'c10_id_pk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(17, $cie10[$i]->{'resp'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(18, $cie10[$i]->{'descrip'}, PDO::PARAM_STR, 4000);
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
      $consulta->bindParam(38, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(39, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(40, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(41, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(42, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(43, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(44, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(45, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(46, $null, PDO::PARAM_STR, 4000);
      
      $consulta->execute();
      
      //$dat=$consulta->fetch (PDO::FETCH_ASSOC);
    //  $consulta->closeCursor();
    }
    catch(PDOException $Exception){
          $dat= $Exception;
        } 
  }  
 // $res = json_encode($dat); 
 //  echo $res;
   
 break;
//// EDICION DE ADULTO MAYOR ////
case 5:

  $datos =$data->ana;
  $items =$data->items;

    $op=8;
  $sv=7;

///guarda adulto mayor

  try{

      $consulta = $conn->prepare('SELECT sgh_adulto_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $datos->{'aam_inform'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $datos->{'aam_respon'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos->{'aam_motivo'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $datos->{'aam_enferm'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos->{'aam_meqrec'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $datos->{'aam_esgene'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $datos->{'aam_reacsi'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $datos->{'aam_antepe'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12, $datos->{'aam_antfam'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(13, $datos->{'aam_exafis'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(14, $datos->{'aam_prudia'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(15, $datos->{'aam_trata'}, PDO::PARAM_STR, 4000);
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
      $consulta->bindParam(38, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(39, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(40, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(41, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(42, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(43, $datos->{'aam_id_pk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(44, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(45, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(46, $null, PDO::PARAM_STR, 4000);
      $consulta->execute();

      $dat=$consulta->fetch (PDO::FETCH_ASSOC);
      $consulta->closeCursor();
     
    }

  catch(PDOException $Exception){
          $dat= $Exception;
    }       
    //$res = json_encode($dat);
    //echo $res;
    
/// guarda respuestas de los items 
$nombres = [
    'vision',
    'genitourinario',
    'audision',
    'rasmusculo',
    'olfatogusto',
    'endocriono10',
    'reacsirespitatorio',
    'hemolinfatico',
    'reacsicardiovascular',
    'nervioso',
    'reacsidigestivo',
    'caidas',
    'dismovilidad',
    'perdidapeso',
    'astenia',
    'desorientacion',
    'alteracion',
    'inmunoizaciones',
    'actividadrecreativa',
    'higienegeneral',
    'controlessalud',
    'higieneoral',
    'alergias',
    'ejercicios',
    'otros',
    'alimentacion',
    'tabaquismo',
    'alcoholismo',
    'adicciones',
    'otrohabito',
    'demartologico',
    'visuales',
    'otorrino',
    'estomatologicos',
    'endocrinos',
    'cardio',
    'infecciosos',
    'hemolinfaticos',
    'urologicos',
    'neurologicos',
    'psiquiatricos',
    'musculoesqueletico',
    'digestivos',
    'respiratorios',
    'oncologicos',
    'menopausia',
    'mamografia',
    'citologia',
    'embarazos',
    'partos',
    'cesareas',
    'tehormonal',
    'prostatica',
    'terapiahor',
    'aines',
    'analgesicos',
    'antidiabeticos',
    'antihipertensivos',
    'anticuagulantes',
    'psicofarmacos',
    'antibioticos',
    'otrofarcologico',
    'prescritores',
    'cardiopatias',
    'tuberculosis',
    'diabetes',
    'violencia',
    'hipertencion',
    'sindrome',
    'neoplasia',
    'otrosantecedentes',
    'parkinson',
    'alzheimer',
    'pifi',
    'oidos',
    'cuello',
    'abdomen',
    'msuperiores',
    'columna',
    'axilamama',
    'boca',
    'cabeza',
    'ojos',
    'nariz',
    'torax',
    'perine',
    'minferiores',
    'genito',
    'cardiovascular',
    'orgsentidos',
    'endocrio',
    'neurologio',
    'hemolinf',
    'musculos',
    'digestivo',
    'respiratorio',
    'dincontinencia',
    'dulcera',
    'ddelirio',
    'ddepresion',
    'dfragilidad',
    'ddismovilidad',
    'dcaida',
    'dmalnutricion',
    'ddemencia',
    'diatrogenia',
];

for ($i=0; $i < sizeof($items); $i++) {
    $respuesta=$items[$i]->{$nombres[$i]};
    //echo ($nombres[$i]. " : ". $respuesta. " id ".$items[$i]->{'pat_id_pk'}."   ");
    $pat_id_pk=$items[$i]->{'pat_id_pk'};
    $consulta = $conn->prepare('SELECT sgh_adulto_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $null, PDO::PARAM_STR,4000);
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
      $consulta->bindParam(38, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(39, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(40, $respuesta, PDO::PARAM_STR, 4000);
      $consulta->bindParam(41, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(42, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(43, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(44, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(45, $pat_id_pk, PDO::PARAM_STR, 4000);
      $consulta->bindParam(46, $null, PDO::PARAM_STR, 4000);
      
      $consulta->execute();
    }

/// guardar signos vitales 
   
   try{
      $consulta = $conn->prepare('SELECT sgh_adulto_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $sv, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
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
      $consulta->bindParam(19, $datos->{'siv_prarta'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(20, $datos->{'siv_prarte'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(21, $datos->{'siv_temper'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(22, $datos->{'siv_pulso'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(23, $datos->{'siv_freres'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(24, $datos->{'siv_peso'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(25, $datos->{'siv_talla'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(26, $datos->{'siv_imc'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(27, $datos->{'siv_percint'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(28, $datos->{'siv_percad'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(29, $datos->{'siv_perpan'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(30, $datos->{'siv_defvis'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(31, $datos->{'siv_defaud'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(32, $datos->{'siv_levand'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(33, $datos->{'siv_peinor'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(34, $datos->{'siv_pemere'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(35, $datos->{'siv_perpes'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(36, $datos->{'siv_triste'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(37, $datos->{'siv_pubaso'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(38, $datos->{'siv_sacoso'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(39, $datos->{'siv_vivsol'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(40, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(41, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(42, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(43, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(44, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(45, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(46, $datos->{'siv_id_pk'}, PDO::PARAM_STR, 4000);
      
      $consulta->execute();
      
      $dat=$consulta->fetch (PDO::FETCH_ASSOC);
     $consulta->closeCursor();
     
    }
      catch(PDOException $Exception){$dat= $Exception;}
        $res = json_encode($dat);
        echo $res;
    break;
case 6:
    // guardar diagnostico 
   $cie10=$data->c10;
   for ($i=0; $i < sizeof($cie10); $i++) {
   try{
     
      $consulta = $conn->prepare('SELECT sgh_adulto_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
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
      $consulta->bindParam(16, $cie10[$i]->{'c10_id_pk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(17, $cie10[$i]->{'dia_resp'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(18, $cie10[$i]->{'descrip'}, PDO::PARAM_STR, 4000);
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
      $consulta->bindParam(38, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(39, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(40, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(41, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(42, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(43, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(44, $cie10[$i]->{'dia_id_pk'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(45, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(46, $null, PDO::PARAM_STR, 4000);
      
      $consulta->execute();
      
      //$dat=$consulta->fetch (PDO::FETCH_ASSOC);
    //  $consulta->closeCursor();
    }catch(PDOException $Exception){
          $dat= $Exception;
        } 
  }  
            
  // $res = json_encode($dat); 
 //  echo $res;
   
 break;
case 9:
 // print_r($data);
    // guardar diagnostico 
   try{
     
      $consulta = $conn->prepare('SELECT sgh_adulto_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $data->op, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
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
      $consulta->bindParam(16, $data->c10_id_pk, PDO::PARAM_STR, 4000);
      $consulta->bindParam(17, $data->dia_resp, PDO::PARAM_STR, 4000);
      $consulta->bindParam(18, $data->descrip, PDO::PARAM_STR, 4000);
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
      $consulta->bindParam(38, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(39, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(40, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(41, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(42, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(43, $data->aam_id_pk, PDO::PARAM_STR, 4000);
      $consulta->bindParam(44, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(45, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(46, $null, PDO::PARAM_STR, 4000);
      
      $consulta->execute();
      
      $dat=$consulta->fetch (PDO::FETCH_ASSOC);
      $consulta->closeCursor();
    }catch(PDOException $Exception){
          $dat= $Exception;
        }  
   $res = json_encode($dat); 
  echo $res;
 break;
case '3':
    print_r($data);
   $datos =$data->ana;
   $adu=1;
   $sv=3;
   # code...
    try{

      $consulta = $conn->prepare('SELECT sgh_adulto_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $adu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
      $consulta->bindParam(4, $datos->{'aam_inform'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(5, $datos->{'aam_respon'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(6, $datos->{'aam_motivo'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(7, $datos->{'aam_enferm'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(8, $datos->{'aam_meqrec'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(9, $datos->{'aam_esgene'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(10, $datos->{'aam_reacsi'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(11, $datos->{'aam_antepe'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(12, $datos->{'aam_antfam'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(13, $datos->{'aam_exafis'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(14, $datos->{'aam_prudia'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(15, $datos->{'aam_trata'}, PDO::PARAM_STR, 4000);
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
      $consulta->bindParam(38, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(39, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(40, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(41, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(42, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(43, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(44, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(45, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(46, $null, PDO::PARAM_STR, 4000);
      $consulta->execute();

      $dat=$consulta->fetch (PDO::FETCH_ASSOC);
      $consulta->closeCursor();
     
    }

  catch(PDOException $Exception){
          $dat= $Exception;
    }       
//    $res = json_encode($dat);
//    echo $res;
    

 /// guardar signos vitales 
   try{
      $consulta = $conn->prepare('SELECT sgh_adulto_ingreso_pa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
      $consulta->bindParam(1, $sv, PDO::PARAM_STR, 4000);
      $consulta->bindParam(2, $data->usu, PDO::PARAM_STR, 4000);
      $consulta->bindParam(3, $data->hcl, PDO::PARAM_STR, 4000);
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
      $consulta->bindParam(19, $datos->{'siv_prarta'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(20, $datos->{'siv_prarte'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(21, $datos->{'siv_temper'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(22, $datos->{'siv_pulso'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(23, $datos->{'siv_freres'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(24, $datos->{'siv_peso'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(25, $datos->{'siv_talla'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(26, $datos->{'siv_imc'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(27, $datos->{'siv_percint'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(28, $datos->{'siv_percad'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(29, $datos->{'siv_perpan'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(30, $datos->{'siv_defvis'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(31, $datos->{'siv_defaud'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(32, $datos->{'siv_levand'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(33, $datos->{'siv_peinor'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(34, $datos->{'siv_pemere'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(35, $datos->{'siv_perpes'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(36, $datos->{'siv_triste'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(37, $datos->{'siv_pubaso'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(38, $datos->{'siv_sacoso'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(39, $datos->{'siv_vivsol'}, PDO::PARAM_STR, 4000);
      $consulta->bindParam(40, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(41, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(42, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(43, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(44, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(45, $null, PDO::PARAM_STR, 4000);
      $consulta->bindParam(46, $null, PDO::PARAM_STR, 4000);
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