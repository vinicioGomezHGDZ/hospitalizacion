angular.module("censo_dia",['ui.router'])
.controller('censo_diaCtrl',['$scope','$http','$stateParams',function($scope,$http,$stateParams,ModalService) {

$scope.datosAguardar={
	tca_serv_fk:"0",
	tca_piso_fk:"0",
	fecha: null
}
$scope.cancelar=function(){
	$scope.datosAguardar={
	tca_serv_fk:"0",
	tca_piso_fk:"0",
	fecha: null
	}
}

$scope.o_piso=false;
$scope.o_servicio=false;
$scope.op_reporte="0";
	$scope.op_report=function () {
		if ($scope.op_reporte === "0"){
			$scope.o_piso=false;
			$scope.o_servicio=true;
			$scope.actu();
			$scope.datosAguardar={
				tca_serv_fk:"0",
				tca_piso_fk:"0",
				fecha: null
			}
		}
		else {
			$scope.o_piso=true;
			$scope.o_servicio=false;
			$scope.actu();
			$scope.datosAguardar={
				tca_serv_fk:"0",
				tca_piso_fk:"0",
				fecha: null
			}
		}
	}
$scope.actu=function(){
		$http.post('src/sgh/cama/php/sghListarcama.php',{op:2,fil:'S'}).success(function (data) {
			console.log(data);
			$scope.servicio = data;
		});
	}
		$scope.actu();

	$scope.selec_servicio=function (op) {

		if ($scope.datosAguardar.tca_serv_fk === "0"){$scope.piso={}; $scope.datosAguardar.tca_piso_fk="0";}
		else{
			$http.post('src/sgh/cama/php/sghListarcama.php',{op:4,codigo:$scope.datosAguardar.tca_serv_fk}).success(function (data) {
				 console.log(data);
				if (data.error === "erro"){}
				else{
					$scope.datosAguardar.tca_piso_fk=op+"";
					// console.log(data);
					$scope.piso = data;}
			});
		}
	}

	$scope.reporte=function () {
	
		 $http.post('src/sgh/censo_dia/php/sghListarCenso.php',{op:1,codigo:$scope.datosAguardar.tca_serv_fk}).success(function (data) {
					 console.log(data);
					if (data.error === "erro"){}
					else{
						$scope.serv=data[0].tca_descripcion;
						$http.post('src/sgh/censo_dia/php/sghListarCenso.php',{op:1,codigo:$scope.datosAguardar.tca_piso_fk}).success(function (data) {
							console.log(data);
							if (data.error === "erro"){}
							else{
								$scope.piso=data[0].tca_descripcion;
								frame.setAttribute("src", "src/sgh/censo_dia/php/repor_censo.php?s="+$scope.serv +"&p=" +$scope.piso+ "&f="+$scope.datosAguardar.fecha+"&res="+$scope.usuario)
								$scope.cancelar();
								}
						});
					}
	   });
	}
//// general
	$scope.reporte_g=function () {
		$http.post('src/sgh/censo_dia/php/sghListarCenso.php',{op:1,codigo:$scope.datosAguardar.tca_serv_fk}).success(function (data) {
			console.log(data);
			if (data.error === "erro"){}
			else{
				$scope.serv=data[0].tca_descripcion;
						$scope.piso=data[0].tca_descripcion;
						frame.setAttribute("src", "src/sgh/censo_dia/php/repor_censo_general.php?s="+$scope.serv + "&f="+$scope.datosAguardar.fecha +"&res="+$scope.usuario)

			}
		});
	}

}]);
