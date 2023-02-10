angular.module("exalb",['ngRoute'])
.controller('exalbCtrl',['$scope','$http',function($scope,$http){

$scope.datosAguardar={exa_tipo:"false"};
	if ($scope.sgh_v_user === undefined){$scope.cerrarsecion();}
//variables de paginacion
$scope.posicion=null;// guarda el total de items de la tabla
$scope.pagina=1; // variable de paginas a mostrar	 
$scope.editado=false;
// accin del botun nuevo
	$scope.mostrarfor= false;
	$scope.micat="";
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
//cargar datos con json
$scope.actu=function(){
 $http.post('src/sgh/exalabo/php/sghListarExalabo.php').success(function (data) {
        $scope.exalb = data;
           $scope.posicion=Math.ceil(data.length / $scope.totalpaginas);
    }); 
//cargar combo de categorias
$http.post('src/sgh/exalabo/php/sghGetCatExalabo.php').success(function(data){
		$scope.catlb=data;
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
		$scope.posicion=Math.ceil($scope.Busqueda.length / $scope.totalpaginas);

});

// GUARDAR DATOS
	$scope.cancelar = function(){
		$("#closemodal").click()
        $scope.datosAguardar={};
        $scope.micat="";
        $scope.actu();
	}

////eliminar
	$scope.iliminar = function(id){
		if (window.confirm("Confirme eliminación") === true){
	
		$http.post('src/sgh/exalabo/php/sghDeletExalabo.php',{id:id}).success(function(data){	
		$scope.editado= true;
		$scope.edita=data.sgh_examenlabo_edita_pa;	
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
	var fk =$scope.micat;
	var fk =$scope.CombC10;
 if ($scope.micat === ""){
	 alert("Seleccione una Categoría");
}
else
{
	$http.post('src/sgh/exalabo/php/sghInserExalabo.php',{exalb:$scope.datosAguardar, fk:$scope.micat}).success(function(data){	
			 $scope.text = data.sgh_examenlabo_ingresar_pa;
			 $scope.mensaje= true;
			 $scope.datosAguardar={};
			 setTimeout(function() 
			 {
				$scope.mensaje= false;
				$scope.$apply();
			 }, 1500);
		console.log(data);
		});
}
}

//////////////////////////////////////////////////////
//EDICION DE CATEGORIA//

$scope.edita=function(codigo,fk){
	$scope.titulo="Editar Registro";
	$scope.op="editar";
	$scope.id=codigo;
	$scope.micat=fk;
   $http.post('src/sgh/exalabo/php/sghGetlistaExalabo.php?c',{codigo:codigo}).success(function(data){
		 if (data[0].exa_tipo === true ){$scope.tipo="true"}else{$scope.tipo="false"}
		 $scope.datosAguardar={
	    	exa_descrip: data[0].exa_descrip,
	    	exa_tipo:$scope.tipo	    		   
	    };
	});
}

$scope.actualizar = function(){
	$http.post('src/sgh/exalabo/php/sghUpdateExalabo.php',{exalb:$scope.datosAguardar, id:$scope.id, fk:$scope.micat }).success(function(data){	

		$scope.text = data.sgh_examenlabo_edita_pa;	   
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
	
	});
}


}]);