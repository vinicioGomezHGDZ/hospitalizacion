angular.module("wells",['ngRoute'])
.controller('wellsCtrl',['$scope','$http','$routeParams',function($scope,$http,$routeParams,ModalService){

    if ($scope.sgh_v_user === undefined){$scope.cerrarsecion();}
$scope.Fecha = new Date();
$scope.combo={}; // variable donde se cargar el combo box

	// array de estado 
  $scope.wel_califi=0;

  $scope.datosAguardar={
    wel_neopla:0,
    wel_parali:0,
    wel_estanc:0,
    wel_molest:0,
    wel_edepie:0,
    wel_aument:0,
    wel_edema:0,
    wel_otro:0,
    wel_venaco:0
  };//datos que estraigo de los campos para guardar

$scope.valores=function(){

  if ($scope.wel_neopla === true) 
    {
      $scope.datosAguardar.wel_neopla=1;
    }else {$scope.datosAguardar.wel_neopla=0;}

  if ($scope.wel_parali === true) 
    {
      
      $scope.datosAguardar.wel_parali=1;
    }else {$scope.datosAguardar.wel_parali=0;}

  if ($scope.wel_estanc === true) 
    {
      
      $scope.datosAguardar.wel_estanc=1;
    }else {$scope.datosAguardar.wel_estanc=0;}

  if ($scope.wel_molest === true) 
    {
      
      $scope.datosAguardar.wel_molest=1;
    }else {$scope.datosAguardar.wel_molest=0;}

  if ($scope.wel_edepie === true) 
    {
      
      $scope.datosAguardar.wel_edepie=1;
    }else {$scope.datosAguardar.wel_edepie=0;}

  if ($scope.wel_aument === true) 
    {
      
      $scope.datosAguardar.wel_aument=1;
    }else {$scope.datosAguardar.wel_aument=0;}

  if ($scope.wel_edema === true) 
    {
      
      $scope.datosAguardar.wel_edema=1;
    }else {$scope.datosAguardar.wel_edema=0;}

  if ($scope.wel_venaco === true) 
    {
      
      $scope.datosAguardar.wel_venaco=1;
    }else {$scope.datosAguardar.wel_venaco=0;}

  if ($scope.wel_otro === true) 
    {
      
      $scope.datosAguardar.wel_otro=-2;
    }else {$scope.datosAguardar.wel_otro=0;}

  $scope.wel_califi = $scope.datosAguardar.wel_neopla + $scope.datosAguardar.wel_parali + $scope.datosAguardar.wel_estanc + $scope.datosAguardar.wel_molest + $scope.datosAguardar.wel_edepie +$scope.datosAguardar.wel_aument + $scope.datosAguardar.wel_edema + $scope.datosAguardar.wel_venaco + $scope.datosAguardar.wel_otro;
   
  $scope.int();
}

$scope.int=function(){
      if ($scope.wel_califi <= 0) {$scope.interpre="Riesgo Bajo";}

      if ($scope.wel_califi >=1 && $scope.wel_califi <= 2) {$scope.interpre="Riesgo Intermedio";}

      if ($scope.wel_califi >= 3) {$scope.interpre="Riesgo Alto";}
}
$scope.int();
$scope.mensaje=false ;

//variables de paginacion

$scope.posicion=null;// guarda el total de items de la tabla
$scope.pagina=1; // variable de paginas a mostrar	 

//cargar datos con json
    
$scope.actu=function(){
   $http.post('src/sgh/wells/php/sghListaWells.php',{op:1,idhc:$scope.histoclinica}).success(function (data) {
       if (data.error === "error") {console.log(data);}else{
        $scope.wells = data;
 		    $scope.posicion=Math.ceil(data.length / $scope.totalpaginas);
        } 
        
     }); 
}

if ($scope.histoclinica === null){
  //alert("Escoja un pacinete");
  window.location = "#/"
}else{
$scope.actu();
$scope.int();
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
      $scope.ver_fecha=true;
     $scope.datosAguardar={
          wel_neopla:0,
          wel_parali:0,
          wel_estanc:0,
          wel_molest:0,
          wel_edepie:0,
          wel_aument:0,
          wel_edema:0,
          wel_otro:0,
          wel_venaco:0
      };//datos que estraigo de los campos para guardar
    $scope.wel_neopla=false;
    $scope.wel_parali=false;
    $scope.wel_estanc=false;
    $scope.wel_molest=false;
    $scope.wel_edepie=false;
    $scope.wel_aument=false;
    $scope.wel_edema=false;
    $scope.wel_otro=false;
    $scope.wel_venaco=false;
    $scope.wel_califi=0;
}
    $scope.actguarda=false;
$scope.guardar = function(){
    $scope.actguarda=true;

        $http.post('src/sgh/wells/php/sghInserWells.php', {
            op: 1,
            tra: $scope.datosAguardar,
            hcl: $scope.histoclinica,
            usu: $scope.usuario
        }).success(function (data) {
            $scope.text = data.sgh_wells_ingreso_pa;
            $scope.mensaje = true;

            setTimeout(function () {
                $scope.mensaje = false;
                $scope.actguarda = false;
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
$scope.ver_fecha=true;
$scope.editando=function(codigo){
    $scope.ver_fecha=false;
  $scope.titulo="Editar Registro";
  $scope.op="editar";
  $scope.condi=false;
  // LLENA DATOS DE EDICION
   $http.post('src/sgh/wells/php/sghListaWells.php',{op:2, codigo:codigo,usu:$scope.usuario}).success(function (data) {
     if (data != "0")
      {  
          $scope.wel_neopla=$scope.bool(data[0].wel_neopla);
          $scope.wel_parali=$scope.bool(data[0].wel_parali);
          $scope.wel_estanc=$scope.bool(data[0].wel_estanc);
          $scope.wel_molest=$scope.bool(data[0].wel_molest);
          $scope.wel_edepie=$scope.bool(data[0].wel_edepie);
          $scope.wel_aument=$scope.bool(data[0].wel_aument);
          $scope.wel_edema=$scope.bool(data[0].wel_edema);
          $scope.wel_otro=$scope.bool(data[0].wel_otro);
          $scope.wel_venaco=$scope.bool(data[0].wel_venaco);

         $scope.datosAguardar={
            wel_neopla:data[0].wel_neopla,
            wel_parali:data[0].wel_parali,
            wel_estanc:data[0].wel_estanc,
            wel_molest:data[0].wel_molest,
            wel_edepie:data[0].wel_edepie,
            wel_aument:data[0].wel_aument,
            wel_edema:data[0].wel_edema,
            wel_otro:data[0].wel_otro,
            wel_venaco:data[0].wel_venaco,
            wel_id_pk:data[0].wel_id_pk,
            wel_fecha:new Date(data[0].wel_fecha)
          }

        $scope.wel_califi = $scope.datosAguardar.wel_neopla + $scope.datosAguardar.wel_parali + $scope.datosAguardar.wel_estanc + $scope.datosAguardar.wel_molest + $scope.datosAguardar.wel_edepie +$scope.datosAguardar.wel_aument + $scope.datosAguardar.wel_edema + $scope.datosAguardar.wel_venaco + $scope.datosAguardar.wel_otro;
        $scope.int();

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

  $http.post('src/sgh/wells/php/sghInserWells.php',{op:2,tra:$scope.datosAguardar,usu: $scope.usuario}).success(function(data){
       $scope.text = data.sgh_wells_ingreso_pa;
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