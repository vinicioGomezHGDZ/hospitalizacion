angular.module("punto",['ngRoute'])
.controller('puntoCtrl',['$scope','$http','$routeParams',function($scope,$http,$routeParams,ModalService){
	if ($scope.sgh_v_user === undefined){$scope.cerrarsecion();}

$scope.punt = {};// Variable para cargar los datos de los puntos
$scope.datosAguardar={};//datos que estraigo de los campos para guardar
$scope.mensaje=false ;
//variables de paginacion
$scope.posicion=null;// guarda el total de items de la tabla
$scope.pagina=1; // variable de paginas a mostrar	 
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
//cargar datos c10 con json
$scope.actu=function(){
 $http.get('src/sgh/punform/php/sghListarPuntform.php').success(function (data) {
        
        $scope.punt = data;
 		$scope.posicion=Math.ceil(data.length / $scope.totalpaginas);

    }); 
}
 $scope.actu();
 //paginación 
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
		$("#closemodal").click();
        $scope.datosAguardar={};
	}
////eliminar
	$scope.iliminar = function(id){
	   $http.post('src/sgh/punform/php/sghDeletPuntform.php',{id:id}).success(function(data){	
		$scope.editado= true;
		$scope.edita=data.sgh_punt_edita_pa;	
		//console.log(data);
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
	
	$http.post('src/sgh/punform/php/sghInserPuntform.php',$scope.datosAguardar).success(function(data){	
			
             $res=data.sgh_punto_ingreso_pa;
             $scope.text = data.sgh_punto_ingreso_pa;
			 $scope.mensaje= true;
			 setTimeout(function() 
				{
					$scope.mensaje= false;
					$scope.$apply();
					$("#closemodal").click();
    				$scope.actu();
							
				 }, 1500);
		//console.log(data);
	});}

//////////////////////////////////////////////////////
//EDICION DE CATEGORIA//

$scope.edita=function(codigo){
	$scope.titulo="Editar Registro";
	$scope.op="editar";
	$scope.id=codigo;
	$http.get('src/sgh/punform/php/sghGetlistaPuntform.php?c='+ codigo).success(function(data){
	    $scope.datosAguardar={
	    	pun_descrip:data[0].pun_descri,
	    	pun_form:data[0].pun_form
	    		   			 };	
	});
}
$scope.actualizar = function(){
$http.post('src/sgh/punform/php/sghUpdatePuntform.php',{getpun:$scope.datosAguardar , id:$scope.id}).success(function(data){	
		$scope.text = data.sgh_punt_edita_pa;
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