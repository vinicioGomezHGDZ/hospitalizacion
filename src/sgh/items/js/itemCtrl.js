angular.module("item",['ngRoute'])
.controller('itemCtrl',['$scope','$http','$routeParams',function($scope,$http,$routeParams,ModalService){
	if ($scope.sgh_v_user === undefined){$scope.cerrarsecion();}

$scope.items = {};
$scope.datosAguardar={};

//variables de paginacion
$scope.posicion=null;// guarda el total de items de la tabla
$scope.pagina=1; // variable de paginas a mostrar	 
$scope.editado=false;

// accin del botun nuevo
	$scope.mostrarfor= false;
	$scope.mipunt="" ;
	$scope.punt={};
	$scope.mensaje=false;	
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
//cargar datos punt con json
$scope.actu=function(){
 $http.get('src/sgh/items/php/sghListarItem.php').success(function (data) {
        
        $scope.items = data;
        $scope.posicion=Math.ceil(data.length / $scope.totalpaginas);
    });
 // cargar combo box
$http.get('src/sgh/items/php/sghGetPunItem.php').success(function(data){

				$scope.punt=data;
	
		});
// paginacion de tabla
}
$scope.actu();
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
		$scope.posicion=Math.ceil($scope.Busqueda.length / $scope.totalpaginas);

});

// GUARDAR DATOS

	$scope.cancelar = function(){
	$("#closemodal").click()
        $scope.datosAguardar={};
      	$scope.mipunt="" ;
      	$scope.actu();
	}
////eliminar
	$scope.iliminar = function(id){
		$http.post('src/sgh/items/php/sghDeletItem.php',{id:id}).success(function(data){	
		$scope.editado= true;
		$scope.edita=data.sgh_item_edita_pa;	
		   // console.log(data);
			setTimeout(function() 
			 {
				$scope.editado= false;
				$scope.$apply();
				$scope.actu();
		    }, 1500);
		});
	}
////

$scope.guardar = function(){
	var fk =$scope.mipunt;

	$http.post('src/sgh/items/php/sghInsertItem.php',{proble:$scope.datosAguardar, fk:fk }).success(function(data){	
		 //$scope.mostrarfor = false;
			 $scope.text = data.sgh_item_ingresar_pa;
			 $scope.mensaje= true;
			 $scope.datosAguardar={};
			 setTimeout(function() 
			 {
				$scope.mensaje= false;
				$scope.$apply();  
			 }, 1000);		
	//console.log(data);
		});
}


//////////////////////////////////////////////////////
//EDICION DE CATEGORIA//

$scope.edita=function(codigo,fk){
	$scope.titulo="Editar Registro";
	$scope.op="editar";
	$scope.id=codigo;
	$scope.mipunt=fk;
	$http.get('src/sgh/items/php/sghGetlistaItem.php?c='+ codigo).success(function(data){

			$scope.datosAguardar={
	    	prb_proble:data[0].prb_proble
	    		   			 };	
	});

	}

$scope.actualizar = function(){
$http.post('src/sgh/items/php/sghUpdateItem.php',{items:$scope.datosAguardar, fk:$scope.mipunt , id:$scope.id}).success(function(data){	
		$scope.text = data.sgh_item_edita_pa;
		$scope.datosAguardar={};
			 $scope.mensaje= true; 
			 setTimeout(function() 
			 {
				$scope.mensaje= false;
				$scope.$apply();
			    $("#closemodal").click();
				$scope.actu();
				$scope.titulo="Nuevo Registro";

			 }, 1500);	
		//console.log(data);
	});

}

}]);