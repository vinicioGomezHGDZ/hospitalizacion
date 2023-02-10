angular.module("listadieta",['ui.router'])
.controller('listadietaCtrl',['$scope','$http',function($scope,$http){
	if ($scope.sgh_v_user === undefined){$scope.cerrarsecion();}
//variables de paginacion
		$scope.posicion=null;// guarda el total de items de la tabla
		$scope.pagina=1; // variable de paginas a mostrar	 
		$scope.mostrarfor= false;// mostrar el form nuevo
		$scope.mensaje=false; // mostrar mensaje de guardado
		$scope.editado=false;
//variables de paginacion

	if ($scope.usu_perfil != 'NUTRICIÓN'){$scope.admi=true}
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
$http.post('src/sgh/listadieta/php/sghListarlistadieta.php',{op:1}).success(function (data) {
       console.log(data);
       if (data.error === "error") {}
       	else{
        $scope.dieta = data;
  		$scope.posicion=Math.ceil(data.length / $scope.totalpaginas);
  	  }
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

////guardar
$scope.guardar = function(){

$http.post('src/sgh/listadieta/php/sghInserlistadieta.php',{op:1,di:$scope.datosAguardar,usu:$scope.usuario}).success(function(data){	
			console.log(data);
			 $scope.text = data.sgh_listadieta_ingreso_pa;
			 $scope.mensaje= true;
			 $scope.datosAguardar={};
			 setTimeout(function() 
			 {
				$scope.mensaje= false;
				$scope.$apply();
				$scope.actu();
   		  }, 1500);
	});
}

//////////////////////////////////////////////////////
//EDICION DE datos//

$scope.edita=function(id){
	$scope.titulo="Editar Registro";
	$scope.op="editar";
	$scope.id=id;
	// LLENA DATOS DE EDICION


	$http.post('src/sgh/listadieta/php/sghListarlistadieta.php',{op:2,codigo:id}).success(function (data) {
		 $scope.datosAguardar={
	    	die_descrip: data[0].die_descrip,
	    	die_id_pk: data[0].die_id_pk,
             die_orden:data[0].die_orden
	    		 };
	   // console.log(data);		 
	});
}
$scope.actualizar = function(){
$http.post('src/sgh/listadieta/php/sghInserlistadieta.php',{op:2,di:$scope.datosAguardar,usu:$scope.usuario}).success(function(data){
		   $scope.text = data.sgh_listadieta_ingreso_pa;
			 $scope.mensaje= true; 
			 setTimeout(function() 
			 {
				$scope.mensaje= false;
				$scope.$apply();
				$scope.cancelar();
				$scope.titulo="Nuevo Registro";
				$scope.op="nuevo";
			 }, 1500);	
		console.log(data);
	});
}
$scope.visible=function(id,estado){
$http.post('src/sgh/listadieta/php/sghInserlistadieta.php',{op:3,codgo:id,esta:estado,usu:$scope.usuario}).success(function(data){

		console.log(data);
	});

}

}]);
