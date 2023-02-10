angular.module("microbiologico",['ngRoute'])
.controller('microbiologicoCtrl',['$scope','$http','$routeParams','upload',function($scope,$http,$routeParams,upload){
    if ($scope.sgh_v_user === undefined){$scope.cerrarsecion();}
$scope.Fecha = new Date();
    $scope.activa_desactiva=function(op) {
        if (op === "null") {return true;}
        else {return false;}
    }
$scope.activa=function(id){
	if (id === "0")	{ $scope.otros=true;}
  else{ $scope.otros=false; 
    $scope.datosAguardar.mic_cuales=null;
   }

}
$scope.activa2=function(id){
  if (id === "0")  { $scope.otro=true; 
  }
  else{ $scope.otro=false; 
  $scope.datosAguardar.mic_cual = null;}
}

$scope.datosAguardar={
       mic_intran:false,
       mic_cuales:null,
       mic_comimu:false,
       mic_cual:null,
			};

//datos que estraigo de los campos para guardar
$scope.mensaje=false ;
$scope.cat=1;
//variables de paginacion

$scope.posicion=null;// guarda el total de items de la tabla
$scope.pagina=1; // variable de paginas a mostrar
//cargar datos con json

$scope.actu=function(){
   $http.post('src/sgh/microbiologico/php/sghListaMicrobiologico.php',{op:'1',idhc:$scope.histoclinica}).success(function (data) {
   if (data.error === "error") {console.log(data);}else{
    $scope.microbiologico = data;
 		$scope.posicion=Math.ceil(data.length / $scope.totalpaginas);
 		}
     }); 

   	 

}
/////////////// cargar encabezado
if ($scope.histoclinica === null){
  //alert("Escoja un pacinete");
  window.location = "#/"
}else{
$scope.actu();		
}

///////////
$scope.regresar=function(){$scope.tabla=true;  $scope.anadatos=false; $scope.cancelar();}
$scope.char=function(valor){

    if (valor === true){
      var bool = "true";
    }else{var bool = "false";}
  return bool;  
  }
$scope.tabla=true;
$scope.datos=function(id){
  $scope.tabla=false;
  $scope.anadatos=true;
  $http.post('src/sgh/microbiologico/php/sghListaMicrobiologico.php',{op:'2',codigo:id}).success(function (data) {
     $scope.datosAguardar = {
          mic_antcli:data[0].mic_antcli,
          mic_antibi:data[0].mic_antibi,
          mic_caul:data[0].mic_caul ,
          mic_comimu:$scope.char(data[0].mic_comimu),
          mic_cuales:data[0].mic_cuales,
          mic_cultde:data[0].mic_cultde,
          mic_daepre:data[0].mic_daepre,
          mic_fecha:data[0].mic_fecha, 
          mic_infecc:data[0].mic_infecc,
          mic_intran:$scope.char(data[0].mic_intran),
          mic_obcerb:data[0].mic_obcerb,
          mic_otrlab:data[0].mic_otrlab,
          mic_proinv:data[0].mic_proinv,
          mic_recpor:data[0].mic_recpor,
          mic_sosdia:data[0].mic_sosdia,
          mic_urocul:data[0].mic_urocul

    };
  }); 

}


$scope. paginas = function(tipo)
{if (tipo == 0 && $scope.pagina  > 1 ){$scope.pagina-=1;}
 else if (tipo == 1 && $scope.pagina < $scope.posicion ){$scope.pagina+=1;}
}

// GUARDAR DATOS
$scope.cancelar = function(){
      // angular.element("input[type='file']").val(null);
		    
        $("#closemodal").click()
		    $scope.actu();
      $scope.datosAguardar={
       mic_intran:false,
       mic_cuales:null,
       mic_comimu:false,
       mic_cual:null,
      };	
		
}

$scope.activa=function(id){
  if (id === "0")
  {
   $scope.otros=true;
   
  }else{$scope.otros=false;
    $scope.datosAguardar.vih_otros=null;
  }
}

// GUARDAR DATOS
$scope.actguarda=false;
$scope.guardar = function(){$scope.actguarda=true;
        $http.post('src/sgh/microbiologico/php/sghInserMicrobiologico.php',{op:1,hcl: $scope.histoclinica ,usu:$scope.usuario,cama:$scope.cama,mic:$scope.datosAguardar}) .success(function(data){ 
         $scope.text = data.sgh_microbiologico_ingreso_pa;
         $scope.mensaje= true;
          
          setTimeout(function() 
          {
            $scope.mensaje= false;$scope.actguarda=false;
            $scope.$apply();
           // $("#closemodal").click();
            $scope.cancelar();
          }, 1500);
         console.log(data);
        });  
     }

}])

.directive('uploaderModel', ["$parse", function ($parse) {
  return {
    restrict: 'A',
    link: function (scope, iElement, iAttrs) 
    {
      iElement.on("change", function(e)
      {
        $parse(iAttrs.uploaderModel).assign(scope, iElement[0].files[0]);
      });
    }
  };
}])

.service('upload', ["$http", "$q", function ($http, $q) 
{
  this.uploadFile = function(file, name)
  {
    var deferred = $q.defer();
    var formData = new FormData();
    formData.append("name", name);
    formData.append("file", file);
    return $http.post("src/sgh/microbiologico/php/con_sube.php", formData,
     {
      headers: {
        "Content-type": undefined
      },
      transformRequest: angular.identity
    }

    )

    .success(function(res)
    {
      deferred.resolve(res);
    })
    .error(function(msg, code)
    {
      deferred.reject(msg);
    })
    return deferred.promise;
  } 
}]) 