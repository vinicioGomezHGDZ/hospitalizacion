angular.module("tipocama",['ui.router'])
.controller('tipocamaCtrl',['$scope','$http','$stateParams',function($scope,$http,$stateParams,ModalService){
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
	$scope.CombC10="";// da incio a la primera pocicion del combo (seleccione)
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
$http.post('src/sgh/tipo_cama/php/sghListartipocama.php',{op:1}).success(function (data) {
        //console.log(data);
	   $scope.tipoCamas = data;
  		$scope.posicion=Math.ceil(data.length / $scope.totalpaginas);
  	  });
	}
$scope.actu();
$scope.categoria=false;
$scope.tipodeingreso=function (op) {

	if (op === 'S'){
		$scope.categoria=false;

	}
	if (op === 'P'){
		$scope.categoria=true;
		$scope.titu="Sevicio que pertenece: ";
		$scope.datosAguardar.tca_codigoprincipal="0";
		$http.post('src/sgh/tipo_cama/php/sghListartipocama.php',{op:2,fil:'S'}).success(function (data) {
			//console.log(data);
			$scope.codiCamas = data;
			$scope.posicion=Math.ceil(data.length / $scope.totalpaginas);
		});
	}
	if (op === 'H'){
		$scope.categoria=true;
        $scope.titu="Piso que pertenece: ";
		$scope.datosAguardar.tca_codigoprincipal="0";
			$http.post('src/sgh/tipo_cama/php/sghListartipocama.php',{op:3,fil:'P'}).success(function (data) {
				//console.log(data);
				$scope.codiCamas = data;
				$scope.posicion=Math.ceil(data.length / $scope.totalpaginas);
			});
	}

}
///cargar datos json 


///
// paginacion de tabla
$scope. paginas = function(tipo){if (tipo == 0 && $scope.pagina  > 1 ){$scope.pagina-=1;}else if (tipo == 1 && $scope.pagina < $scope.posicion ){$scope.pagina+=1;}}
	$scope.datosAguardar={tca_codigoprincipal:"0",tca_tipo:'S',tca_id_pk:null};
// GUARDAR DATOS
$scope.cancelar = function(){
		$("#closemodal").click();
        $scope.datosAguardar={tca_codigoprincipal:"0",tca_tipo:'S',tca_id_pk:null};
        $scope.titulo="Nuevo Registro";
        $scope.actu();
		$scope.tipodeingreso($scope.datosAguardar.tca_tipo);
    $scope.ver_elimina=false;
    $scope.ver_nuevo=true;
	}
////eliminar
	$scope.iliminar = function(id){
		if (window.confirm("Confirme eliminación") === true){
		$http.post('src/sgh/cie10/php/sghDeletC10.php',{id:id}).success(function(data){	
		$scope.editado= true;
		$scope.edita=data.sgh_cie10_editar_pa;	
		//console.log(data);
			setTimeout(function() 
			 {
				$scope.editado= false;
				$scope.$apply();
				$scope.actu();
		    }, 1500);	
 	
	});
	}else{}}
////guardar
$scope.guardar = function(){
$http.post('src/sgh/tipo_cama/php/sghInsertipocama.php',{op:1, tpc:$scope.datosAguardar, usu:$scope.usuario}).success(function(data){
	console.log(data);
	$scope.text = data.sgh_tipocama_ingresar_pa;
			 $scope.mensaje= true;
			 setTimeout(function()
			 {
				$scope.mensaje= false;
				$scope.$apply();
				//$scope.actu();

   		  }, 1500);

	});
}

//////////////////////////////////////////////////////
//EDICION DE datos//
$scope.visible=function (id,valor) {
	$scope.datosAguardar.tca_id_pk=id;
	$scope.datosAguardar.tca_visible=valor;
	$http.post('src/sgh/tipo_cama/php/sghInsertipocama.php',{op:2,tpc:$scope.datosAguardar, usu:$scope.usuario}).success(function(data){
		$scope.cancelar();
	});
}
$scope.edita=function(codigo,op){
	$scope.titulo="Editar Registro";
	$scope.op="editar";
	$scope.id=codigo;
	// LLENA DATOS DE EDICION
	$scope.tipodeingreso(op);
	$http.post('src/sgh/tipo_cama/php/sghListartipocama.php',{op:4,codigo:codigo}).success(function(data){
		 $scope.datosAguardar={
			 tca_codigoprincipal:data[0].tca_codigoprincipal+"",
			 tca_tipo:data[0].tca_tipo,
			 tca_descripcion:data[0].tca_descripcion,
			 tca_id_pk:data[0].tca_id_pk

	     };
	   // console.log(data);		 
	});
}
$scope.actualizar = function(){

$http.post('src/sgh/tipo_cama/php/sghInsertipocama.php',{op:1,tpc:$scope.datosAguardar, usu:$scope.usuario}).success(function(data){

		   $scope.text = data.sgh_tipocama_ingresar_pa;
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
		console.log(data);
	});
}

    $scope.ver_elimina=false;
    $scope.ver_nuevo=true;
    $scope.eliminar = function (cama_codigo,cama_estado) {
        $scope.ver_elimina=true;
        $scope.ver_nuevo=false;
        $scope.cama_codigo=cama_codigo;
        $scope.camas_estados=cama_estado;

        if (cama_estado === false){
            $scope.titulo = "Estas segura de Desactivar"
        }
        else{$scope.titulo = "Estas segura de Activar"}
    }
}]);
