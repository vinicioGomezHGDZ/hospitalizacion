angular.module("catlb",['ngRoute'])
.controller('catlbCtrl',['$scope','$http',function($scope,$http){
	if ($scope.sgh_v_user === undefined){$scope.cerrarsecion();}

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
 $http.post('src/sgh/catlabo/php/sghListarCatlabo.php').success(function (data) {
        $scope.catlb = data;
		 $scope.posicion=Math.ceil(data.length / $scope.totalpaginas)
  });

}
$scope.actu();
// paginacion de tabla

$scope. paginas = function(tipo){if (tipo == 0 && $scope.pagina  > 1 ){$scope.pagina-=1;}else if (tipo == 1 && $scope.pagina < $scope.posicion ) {$scope.pagina+=1;}}


// GUARDAR DATOS
$scope.cancelar = function(){
	     	$scope.actu();
		$("#closemodal").click()
        $scope.datosAguardar={};   
        $scope.titulo="Nuevo Registro";
  	}
////eliminar
$scope.iliminar = function(id){
		if (window.confirm("Confirme eliminación") === true){
	
		$http.post('src/sgh/catlabo/php/sghDeletCatlabo.php',{id:id}).success(function(data){	
		$scope.editado= true;
		$scope.edita=data.sgh_categorialabo_edita_pa;	
		//console.log(data);
			setTimeout(function() 
			 {
				$scope.editado= false;
				$scope.$apply();
				$scope.cancelar();
		    }, 1500);
	});}else{}
	}
////

$scope.guardar = function(){
	
	$http.post('src/sgh/catlabo/php/sghInserCatlabo.php',$scope.datosAguardar).success(function(data){	
			
			//$res=data.mensaje;
			//$scope.mostrarfor = false;
			 $scope.text = data.sgh_categorialabo_ingrso_pa;
			 $scope.mensaje= true;
			 
			 setTimeout(function() 
			 {
				$scope.mensaje= false;
				$scope.actu();
				$scope.datosAguardar={};	
  				
			 }, 1500);		
		console.log(data);
		});
}
//////////////////////////////////////////////////////
//EDICION DE CATEGORIA//

$scope.edita=function(codigo){
	$scope.titulo="Editar Registro";
	$scope.op="editar";
	$scope.id=codigo;
	$http.post('src/sgh/catlabo/php/sghGetlistaCatlabo.php?',{codigo:codigo}).success(function(data){
		var deta =data[0].cat_descrip;
	    $scope.datosAguardar={
	    	cat_descrip:deta
	    		   			 };
	});

}
$scope.actualizar = function(){

	$http.post('src/sgh/catlabo/php/sghUpdateCatlabo.php',{catlb:$scope.datosAguardar,id:$scope.id}).success(function(data){	
		   $scope.text = data.sgh_categorialabo_edita_pa;	   
			$scope.datosAguardar={};
			 $scope.mensaje= true; 
			 setTimeout(function() 
			 {
				$scope.mensaje= false;
				$scope.$apply();
				$scope.actu();
				$scope.cancelar();
				$scope.titulo="Nuevo Registro";
				$scope.op="nuevo";
			 }, 1500);	
		//console.log(data);
	
	});
}


}]);