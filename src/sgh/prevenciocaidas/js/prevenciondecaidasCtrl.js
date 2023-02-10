angular.module("prevenciodecaidas",['ngRoute'])
.controller('prevenciondecaidasCtrl',['$scope','$http','$routeParams',function($scope,$http,$routeParams,ModalService){

    if ($scope.sgh_v_user === undefined){$scope.cerrarsecion();}
$scope.Fecha = new Date();
$scope.combo={}; // variable donde se cargar el combo box

	// array de estado 
   $scope.datosAguardar={
   rcp_matano:"",
   rcp_renaci :2,
   rcp_lacmen :0,
   rcp_lacmay :0,
   rcp_preescola:0,
   rcp_escola :0,
   rcp_si :0,
   rcp_no :0,
   rcp_hipera :0,
   rcp_proneu :0,
   rcp_sincon :0,
   rcp_daorce :0,
   rcp_otros :0,
   rcp_sinant :0,
   rcp_sicoco :0,
   rcp_nococo :0,
  };//datos que estraigo de los campos para guardar
$scope.rcp_califi=0;
$scope.mensaje=false ;

//variables de paginacion

$scope.posicion=null;// guarda el total de items de la tabla
$scope.pagina=1; // variable de paginas a mostrar	 

//cargar datos con json
$scope.valores=function(){
   if ($scope.rcp_renaci === true) {$scope.datosAguardar.rcp_renaci=2;}
   else {  $scope.datosAguardar.rcp_renaci=0;}
    if ($scope.rcp_lacmen === true) {$scope.datosAguardar.rcp_lacmen=2;}
   else {  $scope.datosAguardar.rcp_lacmen=0;}
    if ($scope.rcp_lacmay === true) {$scope.datosAguardar.rcp_lacmay=3;}
   else {  $scope.datosAguardar.rcp_lacmay=0;}
    if ($scope.rcp_preescola === true) {$scope.datosAguardar.rcp_preescola=3;}
    else {  $scope.datosAguardar.rcp_preescola=0;}
    if ($scope.rcp_escola === true) {$scope.datosAguardar.rcp_escola=1;}
   else {  $scope.datosAguardar.rcp_escola=0;}
    if ($scope.rcp_si === true) {$scope.datosAguardar.rcp_si=1;}
   else {  $scope.datosAguardar.rcp_si=0;}
    if ($scope.rcp_no === true) {$scope.datosAguardar.rcp_no=0;}
   else {  $scope.datosAguardar.rcp_no=0;}
    if ($scope.rcp_hipera === true) {$scope.datosAguardar.rcp_hipera=1;}
   else {  $scope.datosAguardar.rcp_hipera=0;}
    if ($scope.rcp_proneu === true) {$scope.datosAguardar.rcp_proneu=1;}
   else {  $scope.datosAguardar.rcp_proneu=0;}
    if ($scope.rcp_sincon === true) {$scope.datosAguardar.rcp_sincon=1;}
   else {  $scope.datosAguardar.rcp_sincon=0;}

    if ($scope.rcp_daorce === true) {$scope.datosAguardar.rcp_daorce=1;}
   else {  $scope.datosAguardar.rcp_daorce=0;}
    if ($scope.rcp_otros === true) {$scope.datosAguardar.rcp_otros=1;}
   else {  $scope.datosAguardar.rcp_otros=0;}
    if ($scope.rcp_sinant === true) {$scope.datosAguardar.rcp_sinant=1;}
   else {  $scope.datosAguardar.rcp_sinant=0;}
    if ($scope.rcp_sicoco === true) {$scope.datosAguardar.rcp_sicoco=1;}
   else {  $scope.datosAguardar.rcp_sicoco=0;}
     if ($scope.rcp_nococo === true) {$scope.datosAguardar.rcp_nococo=0;}
   else {  $scope.datosAguardar.rcp_nococo=0;}

   $scope.rcp_califi=$scope.datosAguardar.rcp_preescola+$scope.datosAguardar.rcp_renaci+$scope.datosAguardar.rcp_nococo+$scope.datosAguardar.rcp_sicoco+$scope.datosAguardar.rcp_sinant+$scope.datosAguardar.rcp_otros+$scope.datosAguardar.rcp_daorce+$scope.datosAguardar.rcp_sincon+$scope.datosAguardar.rcp_proneu+$scope.datosAguardar.rcp_hipera+$scope.datosAguardar.rcp_no+$scope.datosAguardar.rcp_si+$scope.datosAguardar.rcp_escola+$scope.datosAguardar.rcp_lacmay+$scope.datosAguardar.rcp_lacmen;
    $scope.interpretacion();
}
    $scope.interpretacion=function(){
        if ($scope.rcp_califi <= 1) {$scope.interpre="  Bajo Riesgo";}

        if ($scope.rcp_califi >=2 && $scope.rcp_califi <=3 ) {$scope.interpre="Mediano Riesgo";}

        if ($scope.rcp_califi > 3) {$scope.interpre="Alto Riesgo";}
    }
$scope.actu=function(){
   $http.post('src/sgh/prevenciocaidas/php/sghListaPrevenciondecaidas.php',{op:1,idhc:$scope.histoclinica}).success(function (data) {
       if (data.error === "error") {console.log(data);}else{
        $scope.prevenciondecaidas = data;
 		    $scope.posicion=Math.ceil(data.length / $scope.totalpaginas);
        }
     }); 
}

if ($scope.histoclinica === null){
  //alert("Escoja un pacinete");
  window.location = "#/"
}else{
$scope.actu();
}
// paginacion de tabla

$scope. paginas = function(tipo){
    if (tipo == 0 && $scope.pagina  > 1 ){$scope.pagina-=1;}
    else if (tipo == 1 && $scope.pagina < $scope.posicion ){$scope.pagina+=1;}
  }
// $scope.men=function(){$scope.mensaje= true;}

$scope.cancelar = function(){
		$("#closemodal").click();
      $scope.titulo="Nuevo Registro";// titulo del modal
      $scope.actu();
      $scope.op="nuevo";
  $scope.datosAguardar={
           rcp_matano:"",
           rcp_renaci :0,
           rcp_lacmen :0,
           rcp_lacmay :0,
           rcp_escola :0,
           rcp_si :0,
           rcp_no :0,
           rcp_hipera :0,
           rcp_proneu :0,
           rcp_sincon :0,
           rcp_daorce :0,
           rcp_otros :0,
           rcp_sinant :0,
           rcp_sicoco :0,
           rcp_nococo :0,
  };//datos que estraigo de los campos para guardar
   $scope.rcp_renaci =false,
   $scope.rcp_lacmen =false,
   $scope.rcp_lacmay =false,
   $scope.rcp_escola =false,
   $scope.rcp_si =false,
   $scope.rcp_no =false,
   $scope.rcp_hipera =false,
   $scope.rcp_proneu =false,
   $scope.rcp_sincon =false,
   $scope.rcp_daorce =false,
   $scope.rcp_otros =false,
   $scope.rcp_sinant =false,
   $scope.rcp_sicoco =false,
   $scope.rcp_nococo =false,
   $scope.rcp_califi=0;
}
$scope.actguarda=false;
$scope.guardar = function(){$scope.actguarda=true;
	$http.post('src/sgh/prevenciocaidas/php/sghInserPrevenciondecaidas.php',{op:1, pdc:$scope.datosAguardar, hcl:$scope.histoclinica, usu:$scope.usuario, cam:$scope.cama}).success(function(data){	
       $scope.text = data.sgh_prevencioncaidas_ingreso_pa;
			 $scope.mensaje= true;
			 
       setTimeout(function() 
				{
          $scope.mensaje= false;$scope.actguarda=false;
					$scope.$apply();
          $scope.cancelar();   
   		  }, 1500);
		//alert(data);
		console.log(data);
	});
	}
/////////////// Editar ///////
$scope.titulo="Nuevo Registro";// titulo del modal
$scope.op="nuevo";
$scope.accion=function(){
  if($scope.op === 'nuevo') { 
    $scope.guardar();
    }
  if($scope.op === 'editar') {
    $scope.actualizar();
  }
}

$scope.bool=function(valor){
  if (valor === 0){
    var bool = false;
  }else{var bool = true;}
return bool;  
}

$scope.editando=function(codigo){
  $scope.titulo="Editar Registro";
  $scope.op="editar";
  $scope.condi=false;
  // LLENA DATOS DE EDICION
   $http.post('src/sgh/prevenciocaidas/php/sghListaPrevenciondecaidas.php',{op:2, codigo:codigo, usu:$scope.usuario}).success(function (data) {
     if (data != "0")
      {  
         $scope.rcp_renaci =$scope.bool(data[0].rcp_renaci);
         $scope.rcp_lacmen =$scope.bool(data[0].rcp_lacmen);
         $scope.rcp_lacmay =$scope.bool(data[0].rcp_lacmay);
          $scope.rcp_preescola =$scope.bool(data[0].rcp_preescola);
         $scope.rcp_escola =$scope.bool(data[0].rcp_escola);
         $scope.rcp_si =$scope.bool(data[0].rcp_si);
         $scope.rcp_no =$scope.bool(data[0].rcp_no);
         $scope.rcp_hipera =$scope.bool(data[0].rcp_hipera);
         $scope.rcp_proneu =$scope.bool(data[0].rcp_proneu);
         $scope.rcp_sincon =$scope.bool(data[0].rcp_sincon);
         $scope.rcp_daorce =$scope.bool(data[0].rcp_daorce);
         $scope.rcp_otros =$scope.bool(data[0].rcp_otros);
         $scope.rcp_sinant =$scope.bool(data[0].rcp_sinant);
         $scope.rcp_sicoco =$scope.bool(data[0].rcp_sicoco);
         $scope.rcp_nococo =$scope.bool(data[0].rcp_nococo);

         $scope.datosAguardar={
          rcp_matano :data[0].rcp_matano,
          rcp_renaci :data[0].rcp_renaci,
          rcp_lacmen :data[0].rcp_lacmen,
          rcp_lacmay :data[0].rcp_lacmay,
          rcp_preescola :data[0].rcp_preescola,
          rcp_escola :data[0].rcp_escola,
          rcp_si :data[0].rcp_si,
          rcp_no :data[0].rcp_no,
          rcp_hipera :data[0].rcp_hipera,
          rcp_proneu :data[0].rcp_proneu,
          rcp_sincon :data[0].rcp_sincon,
          rcp_daorce :data[0].rcp_daorce,
          rcp_otros :data[0].rcp_otros,
          rcp_sinant :data[0].rcp_sinant,
          rcp_sicoco :data[0].rcp_sicoco,
          rcp_nococo :data[0].rcp_nococo,
          rcp_id_pk :data[0].rcp_id_pk,
          }
   $scope.rcp_califi=$scope.datosAguardar.rcp_renaci+$scope.datosAguardar.rcp_nococo+$scope.datosAguardar.rcp_sicoco+$scope.datosAguardar.rcp_sinant+$scope.datosAguardar.rcp_otros+$scope.datosAguardar.rcp_daorce+$scope.datosAguardar.rcp_sincon+$scope.datosAguardar.rcp_proneu+$scope.datosAguardar.rcp_hipera+$scope.datosAguardar.rcp_no+$scope.datosAguardar.rcp_si+$scope.datosAguardar.rcp_escola+$scope.datosAguardar.rcp_lacmay+$scope.datosAguardar.rcp_lacmen;

        $("#n").click();
      }
      else
      {
          alert("Lo Sentimos, ya pasaron más de 24 horas");
        $scope.cancelar();
      }
      console.log(data);
     });   
}
$scope.actualizar=function(){

  $http.post('src/sgh/prevenciocaidas/php/sghInserPrevenciondecaidas.php',{op:2,pdc:$scope.datosAguardar,usu:$scope.usuario}).success(function(data){
       $scope.text = data.sgh_prevencioncaidas_ingreso_pa;
       $scope.mensaje= true;
       
       setTimeout(function() 
        {
          $scope.mensaje= false;
          $scope.$apply();
          $scope.cancelar();
        }, 1500);
    //alert(data);
    console.log(data);
  });
}
}]);