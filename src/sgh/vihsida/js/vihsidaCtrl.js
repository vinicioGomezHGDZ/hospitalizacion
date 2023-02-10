angular.module("vihsida",['ngRoute'])
.controller('vihsidaCtrl',['$scope','$http','$routeParams','upload',function($scope,$http,$routeParams,upload){
    if ($scope.sgh_v_user === undefined){$scope.cerrarsecion();}
$scope.Fecha = new Date();
    $scope.activa_desactiva=function(op) {
        if (op === "null") {return true;}
        else {return false;}
    }

$scope.activa=function(id){
	//alert(id);
	if (id === "")
	{
	 $scope.otros=true;
	}else{$scope.otros=false;}
}
$scope.datosAguardar={
    vih_motivo: null, vih_otros:null
			};

//datos que estraigo de los campos para guardar
$scope.mensaje=false ;
$scope.cat=1;
//variables de paginacion

$scope.posicion=null;// guarda el total de items de la tabla
$scope.pagina=1; // variable de paginas a mostrar
//cargar datos con json

$scope.actu=function(){
   $http.post('src/sgh/vihsida/php/sghListaVihsida.php',{op:'1',idhc:$scope.histoclinica}).success(function (data) {
    if (data.error === "error") {console.log(data);}else{     
      $scope.vihsida = data;
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

$scope.tabla=true;
$scope.ana=function(id){
 

}


$scope. paginas = function(tipo)
{if (tipo == 0 && $scope.pagina  > 1 ){$scope.pagina-=1;}
 else if (tipo == 1 && $scope.pagina < $scope.posicion ){$scope.pagina+=1;}
}

// GUARDAR DATOS
$scope.cancelar = function(){
        angular.element("input[type='file']").val(null);
		    $("#closemodal").click()
		    $scope.actu();
        $scope.datosAguardar={
		   vih_motivo: null, vih_otros:null
			};
    $scope.actguarda=false;
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
$scope.guardar = function(){
    $scope.actguarda=true;
    var file = $scope.file;
    upload.uploadFile(file, name).success(function(res)
    {
      $scope.text=res;
      if ($scope.text==="")
      {
        $http.post('src/sgh/vihsida/php/sghInserVihsida.php',{op:1,hcl: $scope.histoclinica ,usu:$scope.usuario,eti:$scope.entidad,vih:$scope.datosAguardar}) .success(function(data){ 
         $scope.text = data.sgh_vihsida_ingreso_pa;
         $scope.mensaje= true;
          
          setTimeout(function() 
          {
            $scope.mensaje= false;
            $scope.$apply();
           // $("#closemodal").click();
            $scope.cancelar();
          }, 1500);
         console.log(data);
        });  
    }
    else { 
        $scope.text=res;

         $scope.mensaje= true;
          $scope.actguarda=false;
          setTimeout(function() 
          {
            $scope.mensaje= false;
            $scope.$apply();
            //$("#closemodal").click();
          //  $scope.actu();

          }, 2000);

    }
      console.log(res);
    })
  /**/	
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
    return $http.post("src/sgh/vihsida/php/sube_vihsertificado.php", formData,
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