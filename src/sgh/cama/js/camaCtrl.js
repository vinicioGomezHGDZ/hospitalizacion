angular.module("cama",['ui.router','ui.bootstrap.pagination'])
.controller('camaCtrl',['$scope','$http','$stateParams',function($scope,$http,$stateParams,ModalService) {
    if ($scope.sgh_v_user === undefined) {
        $scope.cerrarsecion();
    }

    $scope.estado_colores = function (op) {

        if (op === 'DESOCUPADA') {
            return $scope.myStyle = {'background-color': '#CEF6CE', color: '#190707'}
        }
        else {

            return $scope.myStyle = {'background-color': '#F6CECE', color: '#190707'}
        }
    }
    $scope.acrtiva = function (op) {

        if (op === 'DESOCUPADA') {
            return false
        }
        else {
            return true
        }
    }
    $scope.pasiente = function (cama) {
    $http.post('src/sgh/cama/php/sghListarcama.php', {op: 6, codigo: cama}).success(function (data) {
        console.log(data);
        if (data.error === "error") {
        	alert("Cama sin paciente");
        }
        else {
            alert (data[0].paciente);
        }
    });
}


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

	$scope.datosAguardar={
		ces_id_fk:"",
		tca_serv_fk:0+"",
		tca_piso_fk:0+"",
		tca_habi_fk:0+"",
		cam_id_pk:null
	};
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
if ($scope.op_cargar === 'MEDICINA INTERNA'){$scope.ser_filtra=$scope.op_cargar}
else if ($scope.op_cargar === 'PEDIATRÍA'){$scope.ser_filtra=$scope.op_cargar}
else if ($scope.op_cargar === 'CIRUGÍA'){$scope.ser_filtra=$scope.op_cargar}
else{$scope.ser_filtra=''};

    $scope.search={
        servisio:$scope.ser_filtra,
		estado:''
    };
//cargar datos c10 con json

	//$scope.totalItems
	$scope.maxSize = 5;
$scope.actu=function(){
$http.post('src/sgh/cama/php/sghListarcama.php',{op:1}).success(function (data) {
        //console.log(data);
	if (data.error === 'error') {console.log(data);}
	else {
		$scope.Camas = data;
		$scope.posicion = Math.ceil(data.length / $scope.totalpaginas);
        //$scope.totalItems = data.length;
	}
  	  });
	$http.post('src/sgh/cama/php/sghListarcama.php',{op:3}).success(function (data) {
		//console.log(data);
		$scope.camas_estados = data;
	});

	$http.post('src/sgh/cama/php/sghListarcama.php',{op:2,fil:'S'}).success(function (data) {
		console.log(data);
		$scope.servicio = data;
	});
	}
	$scope.selec_servicio=function (op) {

		if ($scope.datosAguardar.tca_serv_fk === "0"){$scope.piso={}; $scope.datosAguardar.tca_piso_fk="0";}
		else{
		$http.post('src/sgh/cama/php/sghListarcama.php',{op:4,codigo:$scope.datosAguardar.tca_serv_fk}).success(function (data) {
			// console.log(data);
			if (data.error === "erro"){}
			else{
				$scope.datosAguardar.tca_piso_fk=op+"";
				// console.log(data);
			    $scope.piso = data;}
		});
		}
	}
	$scope.selec_piso=function (op) {

		if ($scope.datosAguardar.tca_piso_fk === "0"){$scope.habitacion={}; $scope.datosAguardar.tca_habi_fk="0";}
		else{
		$http.post('src/sgh/cama/php/sghListarcama.php',{op:4,codigo:$scope.datosAguardar.tca_piso_fk}).success(function (data) {
			// console.log(data);
			if (data.error === "erro "){}
			else{$scope.datosAguardar.tca_habi_fk =op+"";
			$scope.habitacion = data;}
		});
		}
	}
$scope.actu();
$scope.categoria=false;

// paginacion de tabla
$scope. paginas = function(tipo){if (tipo == 0 && $scope.pagina  > 1 ){$scope.pagina-=1;}else if (tipo == 1 && $scope.pagina < $scope.posicion ){$scope.pagina+=1;}}

// GUARDAR DATOS
$scope.cancelar = function(){
		$("#closemodal").click();
    $scope.ver_elimina=false;
    $scope.ver_nuevo=true;
	$scope.datosAguardar={
		ces_id_fk:"",
		tca_serv_fk:0+"",
		tca_piso_fk:0+"",
		tca_habi_fk:0+"",
		cam_id_pk:null
	};
	$scope.habitacion={};$scope.habitacion={};
        $scope.titulo="Nuevo Registro";
		$scope.op="nuevo";
        $scope.actu();
	}

////guardar
	$scope.actguarda=false;
$scope.guardar = function(){
	$scope.actguarda=true;
if ($scope.datosAguardar.tca_habi_fk === "0"){
	$scope.text ="Selecione una habitación";
	$scope.mensaje= true;
	setTimeout(function()
	{
		$scope.mensaje= false;
		$scope.$apply();$scope.actguarda=false;
		//$scope.actu();
	}, 1500);
}
else{
$http.post('src/sgh/cama/php/sghInsercama.php',{op:1, tpc:$scope.datosAguardar,usu:$scope.usuario}).success(function(data){
	console.log(data);
	$scope.text = data.sgh_cama_ingresar_pa;
			 $scope.mensaje= true;
			 setTimeout(function()
			 {
				$scope.mensaje= false;
				$scope.$apply();
				//$scope.actu();
   		  }, 1500);

	});
}
}

//////////////////////////////////////////////////////
//EDICION DE datos//
$scope.visible=function (id,valor) {

	$scope.datosAguardar.cam_id_pk=id;
	$scope.datosAguardar.tca_visible=valor;
	$http.post('src/sgh/cama/php/sghInsercama.php',{op:2,tpc:$scope.datosAguardar,usu:$scope.usuario}).success(function(data){
		$scope.cancelar();
	});
}
$scope.edita=function(codigo){
	$scope.titulo="Editar Registro";
	$scope.op="editar";
	$scope.id=codigo;
	// LLENA DATOS DE EDICION

	$http.post('src/sgh/cama/php/sghListarcama.php',{op:5,codigo:codigo}).success(function(data){
		$scope.datosAguardar={
			ces_id_fk:data[0].ces_id_fk+"",
			tca_serv_fk:data[0].tca_serv_fk+"",
			tca_piso_fk:data[0].tca_piso_fk,
			tca_habi_fk:data[0].tca_habi_fk,
			cam_id_pk:data[0].cam_id_pk,
			cam_codigo:data[0].cam_codigo,
			cam_descripcion:data[0].cam_descripcion
		};
		$scope.selec_servicio(data[0].tca_piso_fk);
		$scope.selec_piso(data[0].tca_habi_fk);

	    console.log(data);
	});
}
$scope.actualizar = function(){

$http.post('src/sgh/cama/php/sghInsercama.php',{op:1,tpc:$scope.datosAguardar,usu:$scope.usuario}).success(function(data){

		   $scope.text = data.sgh_cama_ingresar_pa;
			$scope.datosAguardar={};
			 $scope.mensaje= true; 
			 setTimeout(function() 
			 {
				$scope.mensaje= false;
				$scope.$apply();
			    $("#closemodal").click();
				 $scope.cancelar();
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
	$scope.titulo = "Estas segura de Desactivar esta cama"
	}
	else{$scope.titulo = "Estas segura de Activar esta cama"}
}

}]);
