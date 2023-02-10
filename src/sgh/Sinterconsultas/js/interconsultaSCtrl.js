angular.module("interconsultaS",['ngRoute'])
.controller('interconsultaSCtrl',['$scope','$http','$routeParams',function($scope,$http,$routeParams,ModalService){
    if ($scope.sgh_v_user === undefined){alert("Se agoto su tiempo de cesión ");$scope.cerrarsecion();}
    $scope.search={
        servicio:''
    };

//variables de paginacion
$scope.posicion=null;// guarda el total de items de la tabla
$scope.pagina=1; // variable de paginas a mostrar	 
$scope.tinterconsultas=0;

$scope.smito=0; // total mediciina intena
$scope.smtno=0;  // total de medicina interna normal
$scope.smtur=0; // total de medicina interna urgete
$scope.spedto=0; // total de pediatria
$scope.spedno=0; // total de pediatria normal
$scope.spedur=0; // total de pediatria urgente

//cargar datos con json

$scope.actu=function(){
// servicios
    $http.post('src/sgh/cama/php/sghListarcama.php',{op:2,fil:'S'}).success(function (data) {
        console.log(data);
        $scope.servicio = data;
    });

	// carga datos en total general 
 $http.post('src/sgh/Sinterconsultas/php/sghListarSinterconsulta.php',{op:1}).success(function (data) {
        if (data.error != "error") {
			$scope.sinterconsulta = data;
        	$scope.posicion=Math.ceil(data.length / $scope.totalpaginas);
        	$scope.tinterconsultas=data.length;
        	}
        else
        {
        	console.log(data)
			$scope.sinterconsulta = null;
			$scope.tinterconsultas=0;
        }
        console.log(data)
    }); 
 // carga dotos de pediatria totales urgentes y normales
  $http.post('src/sgh/Sinterconsultas/php/sghListarSinterconsulta.php',{op:3,ser:'MEDICINA INTERNA'}).success(function (data) {
        if (data.error != "error") {
		
        	$scope.smito=data.length;
        	}
        else
        {
        	console.log(data)
			$scope.smito=0;
        }
        console.log(data)
    }); 
 $http.post('src/sgh/Sinterconsultas/php/sghListarSinterconsulta.php',{op:2,ser:'MEDICINA INTERNA' ,gra:'NORMAL'}).success(function (data) {
        if (data.error != "error") {
        	$scope.smtno=data.length;
        	}
        else
        {
        	console.log(data)
			$scope.smtno=0;
        }
        console.log(data)
    }); 
  $http.post('src/sgh/Sinterconsultas/php/sghListarSinterconsulta.php',{op:2,ser:'MEDICINA INTERNA' ,gra:'URGENTE'}).success(function (data) {
        if (data.error != "error") {
		
        	$scope.smtur=data.length;
        	}
        else
        {
        	console.log(data)
			$scope.smtur=0;
        }
    }); 
  //carga informacion de pediatria totales urgentes y normales  
   $http.post('src/sgh/Sinterconsultas/php/sghListarSinterconsulta.php',{op:3,ser:'PEDIATRIA' }).success(function (data) {
        if (data.error != "error") {
		
        	$scope.spedto=data.length;
        	}
        else
        {
        	console.log(data)
			$scope.spedto=0;
        }
        console.log(data)
    });
  $http.post('src/sgh/Sinterconsultas/php/sghListarSinterconsulta.php',{op:2,ser:'PEDIATRIA' ,gra:'NORMAL'}).success(function (data) {
        if (data.error != "error") {
		
        	$scope.spedno=data.length;
        	}
        else
        {
        	console.log(data)
			$scope.spedno=0;
        }
    }); 
  $http.post('src/sgh/Sinterconsultas/php/sghListarSinterconsulta.php',{op:2,ser:'PEDIATRIA' ,gra:'URGENTE'}).success(function (data) {
        if (data.error != "error") {
		
        	$scope.spedur=data.length;
        	}
        else
        {
        	console.log(data)
			$scope.spedur=0;
        }
    });
  /// cargar cirugía
    //carga informacion de pediatria totales urgentes y normales
    $http.post('src/sgh/Sinterconsultas/php/sghListarSinterconsulta.php',{op:3,ser:'CIRUGÍA' }).success(function (data) {
        if (data.error != "error") {

            $scope.scirto=data.length;
        }
        else
        {
            console.log(data)
            $scope.scirto=0;
        }
        console.log(data)
    });
    $http.post('src/sgh/Sinterconsultas/php/sghListarSinterconsulta.php',{op:2,ser:'CIRUGÍA' ,gra:'NORMAL'}).success(function (data) {
        if (data.error != "error") {

            $scope.scirno=data.length;
        }
        else
        {
            console.log(data)
            $scope.scirno=0;
        }
    });
    $http.post('src/sgh/Sinterconsultas/php/sghListarSinterconsulta.php',{op:2,ser:'CIRUGÍA' ,gra:'URGENTE'}).success(function (data) {
        if (data.error != "error") {

            $scope.scirur=data.length;
        }
        else
        {
            console.log(data)
            $scope.scirur=0;
        }
    });

}



    $scope.resactualiza=function(){
        setTimeout(function()
        {
            $scope.$apply();
            $scope.resactualiza();
            $scope.actu();
        }, 100000);
    }
    $scope.actu();
    $scope.resactualiza();
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

}]);