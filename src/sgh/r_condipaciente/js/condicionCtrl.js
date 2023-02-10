angular.module("condicion",['ui.router'])
.controller('condicionCtrl',['$scope','$http','$stateParams',function($scope,$http) {

$scope.datosAguardar={
	tca_serv_fk:"0",
	tca_piso_fk:"0",
	fecha: null
}

$scope.o_piso=false;
$scope.o_servicio=true;
$scope.op_reporte="0";
	$scope.op_report=function () {
		if ($scope.op_reporte === "0"){
			$scope.o_piso=false;
			$scope.o_servicio=true;
			$scope.actu();
		}
		else {
			$scope.o_piso=true;
			$scope.o_servicio=false;
			$scope.actu();
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

//// general
	$scope.reporte_g=function () {
		$http.post('src/sgh/censo_dia/php/sghListarCenso.php',{op:1,codigo:$scope.datosAguardar.tca_serv_fk}).success(function (data) {
			console.log(data);
			if (data.error === "erro"){}
			else{
				$scope.serv=data[0].tca_descripcion;
						$scope.piso=data[0].tca_descripcion;
						frame.setAttribute("src", "src/sgh/r_condipaciente/php/reporte_condicion.php?s="+$scope.serv + "&f="+$scope.datosAguardar.fecha +"&res="+$scope.usuario)

			}
		});
	}

}]);
