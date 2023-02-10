angular.module("graf",['ngRoute'])
.controller('grafCtrl',['$scope','$http','$routeParams',function($scope,$http,$routeParams,ModalService){


$scope.grafi = {};

//variables de paginacion
$scope.posicion=null;// guarda el total de items de la tabla
$scope.pagina=1; // variable de paginas a mostrar	 
$scope.mostrarfor= false;// mostrar el form nuevo
$scope.mensaje=false; // mostrar mensaje de guardado
$scope.editado=false;
/// Accion si edita o guarda registro 
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

//cargar datos con json
     

$scope.actu=function(){
 $http.get('src/sgh/grafico/php/sghListarGrafi.php').success(function (data) {
        
        $scope.grafi = data;
        $scope.posicion=Math.ceil(data.length / $scope.totalpaginas);
    }); 
}

$scope.actu();
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

 $scope.$watch('Busqueda', function() {

		if($scope.Busqueda == undefined) return;

		$scope.pagina=1;

		$scope.posicion= Math.ceil($scope.Busqueda.length / $scope.totalpaginas);

});

// GUARDAR DATO
	$scope.cancelar = function(){
		$("#closemodal").click();
        $scope.datosAguardar={};
	}
////eliminar
	$scope.iliminar = function(id){
		if (!confirm("Confirme eliminación") === false){
		$http.post('src/sgh/grafico/php/sghDeletGrafi.php',{id:id}).success(function(data){	
		$scope.editado= true;
		$scope.edita=data.sgh_graf_edita_pa;	
		//console.log(data);
			setTimeout(function() 
			 {
				$scope.editado= false;
				$scope.$apply();
				$scope.actu();
		    }, 1500);

	});}else{}
	}
////

$scope.guardar = function(){
	
	$http.post('src/sgh/grafico/php/sghInserGrafi.php',$scope.datosAguardar).success(function(data){	

			 //$scope.mostrarfor = false;
			 $scope.text = data.sgh_graf_ingreso_pa;
			 $scope.mensaje= true;
			 
			 setTimeout(function() 
			 {
				$scope.mensaje= false;
				$scope.$apply();	
				$("#closemodal").click();
  				$scope.actu();
			 }, 1500);
	
		//console.log(data);
		});
}
//////////////////////////////////////////////////////
//EDICION DE CATEGORIA//

$scope.edita=function(codigo){
	$scope.titulo="Editar Registro";
	$scope.op="editar";
	$scope.id=codigo;
	$http.get('src/sgh/grafico/php/sghGetlistaGrafi.php?c='+ codigo).success(function(data){
	    	$scope.datosAguardar={
	    	gra_nombre:data[0].gra_nombre
	    		   			 };	
	});

	}

$scope.actualizar = function(){


	$http.post('src/sgh/grafico/php/sghUpdateGrafi.php',{grafi:$scope.datosAguardar , id:$scope.id}).success(function(data){	
	
		$scope.text = data.sgh_graf_edita_pa;
		$scope.datosAguardar={};
			 $scope.mensaje= true; 
			 setTimeout(function() 
			 {
				$scope.mensaje= false;
				$scope.$apply();
			    $("#closemodal").click();
				$scope.actu();
				$scope.titulo="Nuevo Registro";
				$scope.op="nuevo";
			 }, 1500);	
		//console.log(data);
	
	});
}

}]);