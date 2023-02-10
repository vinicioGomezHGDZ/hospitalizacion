angular.module("perfil",['ngRoute'])
.controller('perfilCtrl',['$scope','$http','$routeParams',function($scope,$http,$routeParams,ModalService){

    if ($scope.sgh_user === undefined){$scope.cerrarsecion();}
$scope.Fecha = new Date();
$scope.combo={}; // variable donde se cargar el combo box
	// array de estado 
$scope.mensaje=false ;

//variables de paginacion

$scope.posicion=null;// guarda el total de items de la tabla
$scope.pagina=1; // variable de paginas a mostrar	 

//cargar datos con json
    
$scope.actu=function(){
   $http.post('src/sgh/perfil/php/sghListaPerfil.php',{op:1,usu:$scope.usuario}).success(function (data) {
       if (data.error === "error") {console.log(data);}else{
              $scope.perfil = {
                  usu_login:data[0].usu_login,
                  usu_password:data[0].usu_password,
              }
         } 
        console.log(data);
      
     }); 
}

if ($scope.histoclinica === null){
  //alert("Escoja un pacinete");
  window.location = "#/"
}else{
$scope.actu();

}
$scope.cancelar = function(){
      window.location="#/";
}
$scope.atras=function(){
  $scope.usu_password="";  
}
$scope.guardar = function(){
	$http.post('src/sgh/wells/php/sghInserWells.php',{op:1, tra:$scope.datosAguardar, hcl:$scope.histoclinica, usu:$scope.usuario}).success(function(data){	
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