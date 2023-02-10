angular.module("admision",['ngRoute'])
.controller('admisionCtrl',['$scope','$http',function($scope,$http){

//variables de paginacion
$scope.posicion=null;// guarda el total de items de la tabla
$scope.pagina=1; // variable de paginas a mostrar	 


//cargar datos con json

$scope.actu=function(){
 $http.post('src/sgh/admision/php/sghListarAdmision.php',{idhc:$scope.histoclinica}).success(function (data) {
     if (data.error != "error") {

         $scope.admision=[];
         $scope.num=data.length +1 ;
         for ($i = 0; $i < data.length; $i++) {
             $scope.num = $scope.num - 1 ;
             $scope.admision.push({Num:$scope.num,adm_fechaingreso:data[$i].adm_fechaingreso,adm_fechadealta:data[$i].adm_fechadealta,adm_id_pk:data[$i].adm_id_pk});
         }
       //  $scope.admision = data;
    	$scope.posicion = Math.ceil(data.length / $scope.totalpaginas);
 	}
 else
        {
        	console.log(data)
        }
    }); 
}
$scope.actu();
// paginacion de tabla
	if ($scope.sgh_v_user === undefined){$scope.cerrarsecion();}


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

}]);