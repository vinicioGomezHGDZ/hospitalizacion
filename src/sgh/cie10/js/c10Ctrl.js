angular.module("cie10",['ui.router'])
.controller('c10Ctrl',['$scope','$http',function($scope,$http){
	if ($scope.sgh_v_user === undefined){$scope.cerrarsecion();}
//variables de paginacion
		$scope.posicion=null;// guarda el total de items de la tabla
		$scope.pagina=1; // variable de paginas a mostrar	 
		$scope.mostrarfor= false;// mostrar el form nuevo
		$scope.mensaje=false; // mostrar mensaje de guardado
		$scope.editado=false;
//variables de paginacion
$scope.editado=false;
// accin del botun nuevo
	$scope.mostrarfor= false;/// para ocultar el formulario de nuevo
	$scope.mensaje=false ;// para ocultar el mensaje de guardodo o de registro ya existe
	$scope.CombC10=0;// da incio a la primera pocicion del combo (seleccione)
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
$http.get('src/sgh/cie10/php/sghListarc10.php').success(function (data) {
        $scope.cie10 = data;
  		$scope.posicion=Math.ceil(data.length / $scope.totalpaginas);
  	  });
 
 $http.get('src/sgh/cie10/php/sghGetituC10.php').success(function(data){
			//console.log(data);
 	        $scope.c10=data;
		});
	}
$scope.actu();
///cargar datos json 

///
// paginacion de tabla
$scope. paginas = function(tipo){if (tipo == 0 && $scope.pagina  > 1 ){$scope.pagina-=1;}else if (tipo == 1 && $scope.pagina < $scope.posicion ){$scope.pagina+=1;}}

// GUARDAR DATOS
$scope.cancelar = function(){
		$("#closemodal").click()
        $scope.datosAguardar={};
        $scope.CombC10="";     
        $scope.titulo="Nuevo Registro";
        $scope.actu();
	}
////eliminar
	$scope.eliminar = function(id,estado){
		//alert("cambiar estado");
		$http.post('src/sgh/cie10/php/sghDeletC10.php',{id:id,estado:estado,usuario_id:$scope.usuario}).success(function(data){	
		$scope.editado= true;
		$scope.edita=data.sgh_cie10_editar_pa;	
		console.log(data);
			setTimeout(function() 
			 {
				$scope.editado= false;
				$scope.$apply();
				$scope.actu();
		    }, 1500);	
 	
	});
	}
////guardar
$scope.guardar = function(){
	//$scope.fk = $scope.CombC10;
	$scope.fk = null;
/*  if ($scope.CombC10 === ""){
	 alert("Seleccione una Categoría");
}
else
{ */
$http.post('src/sgh/cie10/php/sghInserCie10.php',{usu:$scope.usuario,c10:$scope.datosAguardar,fk:$scope.fk}).success(function(data){
			
			 $scope.text = data.sgh_cie10_ingresar_pa;
			 $scope.mensaje= true;
			 $scope.datosAguardar={};
			 setTimeout(function() 
			 {
				$scope.mensaje= false;
				$scope.$apply();
				$scope.CombC10="";
   		  }, 1500);
	 console.log(data);
	});
}
//}
//////////////////////////////////////////////////////
//EDICION DE datos//
$scope.edita=function(codigo,fk){
	$scope.titulo="Editar Registro";
	$scope.op="editar";
	$scope.id=codigo;
	$scope.CombC10=fk;
	// LLENA DATOS DE EDICION
	$http.post('src/sgh/cie10/php/sghGetlistac10.php?',{codigo:codigo}).success(function(data){
		 $scope.datosAguardar={
	    	c10_codigo: data[0].c10_codigo,
	    	c10_nombre: data[0].c10_nombre
	    		 };
	   // console.log(data);		 
	});
}
$scope.actualizar = function(){

$http.post('src/sgh/cie10/php/sghUpdatec10.php',{usu:$scope.usuario,c10:$scope.datosAguardar,id:$scope.id, fk:$scope.CombC10}).success(function(data){

		   $scope.text = data.sgh_cie10_editar_pa;	   
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
