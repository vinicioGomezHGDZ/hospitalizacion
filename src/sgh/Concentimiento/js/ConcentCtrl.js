angular.module("evolucion",['ngRoute'])

.controller('concentCtrl',['$scope','$http','upload',function($scope,$http,upload){
$scope.Fecha = new Date();
$scope.combo={}; // variable donde se cargar el combo box

// array de estado 
    if ($scope.sgh_v_user === undefined){$scope.cerrarsecion();}
$scope.mensaje=false ;

//variables de paginacion

$scope.posicion=null;// guarda el total de items de la tabla
$scope.pagina=1; // variable de paginas a mostrar	 

//cargar datos con json
$scope.actu=function(){
   $http.post('src/sgh/Concentimiento/php/sghListaConcent.php',{op:1,idhc:$scope.histoclinica}).success(function (data) {
        if (data.error === "error") {console.log(data);}else{
        $scope.Concentimiento = data;
 	    	$scope.posicion=Math.ceil(data.length / $scope.totalpaginas);
      }
     }); 
}
if ($scope.histoclinica === null){
 // alert("Escoja un pacinete");
  window.location = "#/"
}else{

$scope.actu();
 }

 $scope. paginas = function(tipo){if (tipo == 0 && $scope.pagina  > 1 ){$scope.pagina-=1;} else if (tipo == 1 && $scope.pagina < $scope.posicion ){$scope.pagina+=1;}}
// GUARDAR DATOS
$scope.cancelar = function(){
        angular.element("input[type='file']").val(null);
        $("#closemodal").click();
        $scope.actu();$scope.actguarda=false;
}
$scope.actguarda=false;
$scope.guardar = function(){
    $scope.actguarda=true;
    var file = $scope.file;
    upload.uploadFile(file, name).success(function(res)
    {
      $scope.text=res;
      if ($scope.text==="")
      {
         $http.post('src/sgh/Concentimiento/php/sghInserConcent.php',{hcl:  $scope.histoclinica ,usu:$scope.usuario}) .success(function(data){
         $scope.text = data.sgh_concentimiento_ingresa_pa;
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
          $scope.actguarda=false;
        $scope.text=res;
        $scope.mensaje= true;
          setTimeout(function()
          {
            $scope.mensaje= false;
            $scope.$apply();
            angular.element("input[type='file']").val(null);
            //$("#closemodal").click();
            //$scope.actu();
              $scope.actguarda=false;
          }, 5000);
    }
      console.log(res);
    })
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
    return $http.post("src/sgh/Concentimiento/php/con_sube.php", formData,
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