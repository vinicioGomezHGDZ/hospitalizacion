angular.module("downton",['ngRoute'])
.controller('downtonCtrl',['$scope','$http','$routeParams',function($scope,$http,$routeParams,ModalService){

    if ($scope.sgh_v_user === undefined){$scope.cerrarsecion();}
$scope.Fecha = new Date();
$scope.combo={}; // variable donde se cargar el combo box

	// array de estado 

$scope.datosAguardar={
            dsd_matano: "",
            dsd_no: 0  ,       
            dsd_si: 0  ,       
            dsd_ninguna: 0,
            dsd_tranqu: 0,
            dsd_diuret: 0,
            dsd_hipote: 0,
            dsd_antpar: 0,
            dsd_antide: 0,
            dsd_otrmed: 0,
            dsd_ningun: 0,
            dsd_altvis: 0,
            dsd_altaud: 0,
            dsd_extrem: 0,
            dsd_orient: 0,
            dsd_confus: 0,
            dsd_normal: 0,
            dsd_segayu: 0,
            dsd_insayu: 0,
            dsd_nodeam: 0,
            dsd_califi:0
};//datos que estraigo de los campos para guardar
$scope.mensaje=false ;

//variables de paginacion

$scope.posicion=null;// guarda el total de items de la tabla
$scope.pagina=1; // variable de paginas a mostrar	 
$scope.valores=function(){
  if ($scope.dsd_no === true) {$scope.datosAguardar.dsd_no=1;}else{$scope.datosAguardar.dsd_no=0;}
  if ($scope.dsd_si === true) {$scope.datosAguardar.dsd_si=1;}else{$scope.datosAguardar.dsd_si=0;}
  if ($scope.dsd_ninguna === true) {$scope.datosAguardar.dsd_ninguna=1;}else{$scope.datosAguardar.dsd_ninguna=0;}
  if ($scope.dsd_tranqu === true) {$scope.datosAguardar.dsd_tranqu=1;}else{$scope.datosAguardar.dsd_tranqu=0;}
  if ($scope.dsd_diuret === true) {$scope.datosAguardar.dsd_diuret=1;}else{$scope.datosAguardar.dsd_diuret=0;}
  if ($scope.dsd_hipote === true) {$scope.datosAguardar.dsd_hipote=1;}else{$scope.datosAguardar.dsd_hipote=0;}
  if ($scope.dsd_antpar === true) {$scope.datosAguardar.dsd_antpar=1;}else{$scope.datosAguardar.dsd_antpar=0;}
  if ($scope.dsd_antide === true) {$scope.datosAguardar.dsd_antide=1;}else{$scope.datosAguardar.dsd_antide=0;}
  if ($scope.dsd_otrmed === true) {$scope.datosAguardar.dsd_otrmed=1;}else{$scope.datosAguardar.dsd_otrmed=0;}
  if ($scope.dsd_ningun === true) {$scope.datosAguardar.dsd_ningun=1;}else{$scope.datosAguardar.dsd_ningun=0;}
  if ($scope.dsd_altvis === true) {$scope.datosAguardar.dsd_altvis=1;}else{$scope.datosAguardar.dsd_altvis=0;}
  if ($scope.dsd_altaud === true) {$scope.datosAguardar.dsd_altaud=1;}else{$scope.datosAguardar.dsd_altaud=0;}
  if ($scope.dsd_extrem === true) {$scope.datosAguardar.dsd_extrem=1;}else{$scope.datosAguardar.dsd_extrem=0;}
  if ($scope.dsd_orient === true) {$scope.datosAguardar.dsd_orient=1;}else{$scope.datosAguardar.dsd_orient=0;}
  if ($scope.dsd_confus === true) {$scope.datosAguardar.dsd_confus=1;}else{$scope.datosAguardar.dsd_confus=0;}
  if ($scope.dsd_normal === true) {$scope.datosAguardar.dsd_normal=1;}else{$scope.datosAguardar.dsd_normal=0;}
  if ($scope.dsd_segayu === true) {$scope.datosAguardar.dsd_segayu=1;}else{$scope.datosAguardar.dsd_segayu=0;}
  if ($scope.dsd_insayu === true) {$scope.datosAguardar.dsd_insayu=1;}else{$scope.datosAguardar.dsd_insayu=0;}
  if ($scope.dsd_nodeam === true) {$scope.datosAguardar.dsd_nodeam=1;}else{$scope.datosAguardar.dsd_nodeam=0;}
  $scope.datosAguardar.dsd_califi=$scope.datosAguardar.dsd_no+$scope.datosAguardar.dsd_si+$scope.datosAguardar.dsd_ninguna+
                                                   $scope.datosAguardar.dsd_tranqu+
                                                   $scope.datosAguardar.dsd_diuret+
                                                   $scope.datosAguardar.dsd_hipote+
                                                   $scope.datosAguardar.dsd_antpar+
                                                   $scope.datosAguardar.dsd_antide+
                                                   $scope.datosAguardar.dsd_otrmed+
                                                   $scope.datosAguardar.dsd_ningun+
                                                   $scope.datosAguardar.dsd_altvis+
                                                   $scope.datosAguardar.dsd_altaud+
                                                   $scope.datosAguardar.dsd_extrem+
                                                   $scope.datosAguardar.dsd_orient+
                                                   $scope.datosAguardar.dsd_confus+
                                                   $scope.datosAguardar.dsd_normal+
                                                   $scope.datosAguardar.dsd_segayu+
                                                   $scope.datosAguardar.dsd_insayu+
                                                   $scope.datosAguardar.dsd_nodeam;

$scope.int();
}
$scope.int=function(){
      if ($scope.datosAguardar.dsd_califi <= 1) {$scope.interpre="  Bajo Riesgo";}

      if ($scope.datosAguardar.dsd_califi >=2 && $scope.datosAguardar.dsd_califi <=3 ) {$scope.interpre="Mediano Riesgo";}

      if ($scope.datosAguardar.dsd_califi > 3) {$scope.interpre="Alto Riesgo";}
}

//cargar datos con json
$scope.actu=function(){
   $http.post('src/sgh/downton/php/sghListaDownton.php',{op:1,idhc:$scope.histoclinica}).success(function (data) {
        
       if (data.error === "error") {console.log(data);}else{
        $scope.downton = data;
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
$scope. paginas = function(tipo)
{
  if (tipo == 0 && $scope.pagina  > 1 )
    {
    $scope.pagina-=1;
    }
     else if (tipo == 1 && $scope.pagina < $scope.posicion )
     {
      $scope.pagina+=1;
    }

 }
// $scope.men=function(){$scope.mensaje= true;}

$scope.cancelar = function(){
    $scope.ver_fecha=true;
		$("#closemodal").click();
      $scope.titulo="Nuevo Registro";// titulo del modal
      $scope.actu();
      $scope.op="nuevo";
      $scope.datosAguardar={
            dsd_matano: "",
            dsd_no: 0  ,       
            dsd_si: 0  ,       
            dsd_ninguna: 0,
            dsd_tranqu: 0,
            dsd_diuret: 0,
            dsd_hipote: 0,
            dsd_antpar: 0,
            dsd_antide: 0,
            dsd_otrmed: 0,
            dsd_ningun: 0,
            dsd_altvis: 0,
            dsd_altaud: 0,
            dsd_extrem: 0,
            dsd_orient: 0,
            dsd_confus: 0,
            dsd_normal: 0,
            dsd_segayu: 0,
            dsd_insayu: 0,
            dsd_nodeam: 0, dsd_califi:0};
            
            $scope.dsd_no= false  ;       
            $scope.dsd_si= false  ;       
            $scope.dsd_ninguna= false;
            $scope.dsd_tranqu= false;
            $scope.dsd_diuret= false;
            $scope.dsd_hipote= false;
            $scope.dsd_antpar= false;
            $scope.dsd_antide= false;
            $scope.dsd_otrmed= false;
            $scope.dsd_ningun= false;
            $scope.dsd_altvis= false;
            $scope.dsd_altaud= false;
            $scope.dsd_extrem= false;
            $scope.dsd_orient= false;
            $scope.dsd_confus= false;
            $scope.dsd_normal= false;
            $scope.dsd_segayu= false;
            $scope.dsd_insayu= false;
            $scope.dsd_nodeam= false;
    	}

    	$scope.actguarda=false;
$scope.guardar = function(){$scope.actguarda=true;
	$http.post('src/sgh/downton/php/sghInserDownton.php',{op:1,tra:$scope.datosAguardar, hcl:$scope.histoclinica, usu:$scope.usuario, cam:$scope.cama}).success(function(data){	
       $scope.text = data.sgh_downton_ingreso_pa;
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
$scope.ver_fecha=true;

$scope.edita=function(codigo){
    $scope.ver_fecha=false;
  $scope.titulo="Editar Registro";
  $scope.op="editar";
  $scope.condi=false;
  // LLENA DATOS DE EDICION
   $http.post('src/sgh/downton/php/sghListaDownton.php',{op:2, codigo:codigo,usu:$scope.usuario}).success(function (data) {
     if (data != "0")
      { 

            $scope.dsd_no= $scope.bool(data[0].dsd_no)  ;       
            $scope.dsd_si= $scope.bool(data[0].dsd_si)  ;       
            $scope.dsd_ninguna= $scope.bool(data[0].dsd_ninguna);
            $scope.dsd_tranqu= $scope.bool(data[0].dsd_tranqu);
            $scope.dsd_diuret= $scope.bool(data[0].dsd_diuret);
            $scope.dsd_hipote= $scope.bool(data[0].dsd_hipote);
            $scope.dsd_antpar= $scope.bool(data[0].dsd_antpar);
            $scope.dsd_antide= $scope.bool(data[0].dsd_antide);
            $scope.dsd_otrmed= $scope.bool(data[0].dsd_otrmed);
            $scope.dsd_ningun= $scope.bool(data[0].dsd_ningun);
            $scope.dsd_altvis= $scope.bool(data[0].dsd_altvis);
            $scope.dsd_altaud= $scope.bool(data[0].dsd_altaud);
            $scope.dsd_extrem= $scope.bool(data[0].dsd_extrem);
            $scope.dsd_orient= $scope.bool(data[0].dsd_orient);
            $scope.dsd_confus= $scope.bool(data[0].dsd_confus);
            $scope.dsd_normal= $scope.bool(data[0].dsd_normal);
            $scope.dsd_segayu= $scope.bool(data[0].dsd_segayu);
            $scope.dsd_insayu= $scope.bool(data[0].dsd_insayu);
            $scope.dsd_nodeam= $scope.bool(data[0].dsd_nodeam);

         $scope.datosAguardar={
            dsd_matano:data[0].dsd_matano,
            dsd_no:parseInt(data[0].dsd_no),
            dsd_si:parseInt(data[0].dsd_si),
            dsd_ninguna:parseInt(data[0].dsd_ninguna),
            dsd_tranqu:parseInt(data[0].dsd_tranqu),
            dsd_diuret:parseInt(data[0].dsd_diuret),
            dsd_hipote:parseInt(data[0].dsd_hipote),
            dsd_antpar:parseInt(data[0].dsd_antpar),
            dsd_antide:parseInt(data[0].dsd_antide),
            dsd_otrmed:parseInt(data[0].dsd_otrmed),
            dsd_ningun:parseInt(data[0].dsd_ningun),
            dsd_altvis:parseInt(data[0].dsd_altvis),
            dsd_altaud:parseInt(data[0].dsd_altaud),
            dsd_extrem:parseInt(data[0].dsd_extrem),
            dsd_orient:parseInt(data[0].dsd_orient),
            dsd_confus:parseInt(data[0].dsd_confus),
            dsd_normal:parseInt(data[0].dsd_normal),
            dsd_segayu:parseInt(data[0].dsd_segayu),
            dsd_insayu:parseInt(data[0].dsd_insayu),
            dsd_nodeam:parseInt(data[0].dsd_nodeam),
            dow_id_pk:data[0].dow_id_pk,
            dsd_fecha:new Date(data[0].dsd_fehca)
        }
          $scope.datosAguardar.dsd_califi=$scope.datosAguardar.dsd_no+$scope.datosAguardar.dsd_si+$scope.datosAguardar.dsd_ninguna+
                                                   $scope.datosAguardar.dsd_tranqu+
                                                   $scope.datosAguardar.dsd_diuret+
                                                   $scope.datosAguardar.dsd_hipote+
                                                   $scope.datosAguardar.dsd_antpar+
                                                   $scope.datosAguardar.dsd_antide+
                                                   $scope.datosAguardar.dsd_otrmed+
                                                   $scope.datosAguardar.dsd_ningun+
                                                   $scope.datosAguardar.dsd_altvis+
                                                   $scope.datosAguardar.dsd_altaud+
                                                   $scope.datosAguardar.dsd_extrem+
                                                   $scope.datosAguardar.dsd_orient+
                                                   $scope.datosAguardar.dsd_confus+
                                                   $scope.datosAguardar.dsd_normal+
                                                   $scope.datosAguardar.dsd_segayu+
                                                   $scope.datosAguardar.dsd_insayu+
                                                   $scope.datosAguardar.dsd_nodeam;

          $scope.int();
         $("#n").click()
      }else
      {
          alert("Lo Sentimos, ya pasaron más de 24 horas");
        $scope.cancelar();
      }
      console.log(data);
     });   
}
$scope.actualizar=function(){

  $http.post('src/sgh/downton/php/sghInserDownton.php',{op:2,tra:$scope.datosAguardar, usu:$scope.usuario}).success(function(data){
       $scope.text = data.sgh_downton_ingreso_pa;
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