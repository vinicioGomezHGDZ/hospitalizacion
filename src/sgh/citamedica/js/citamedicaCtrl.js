angular.module("citamedica",['ngRoute'])
.controller('citamedicaCtrl',['$scope','$http','$routeParams',function($scope,$http,$routeParams,ModalService){

	if ($scope.sgh_v_user === undefined){$scope.cerrarsecion();}
$scope.datosAguardar={
	esp_id_fk:"",cte_id_fk:1,cti_id_fk:1
};

	$scope.mostrarfor= false;
	$scope.micat="";
	$scope.mensaje=false;

//cargar datos con json
$scope.actu=function(){
 $http.post('src/sgh/citamedica/php/sghListarCitamedica.php',{op:1}).success(function (data) {
        $scope.especia = data;
         console.log(data);
    });

}

$scope.actu();

// GUARDAR DATOS
	$scope.cancelar = function(){
		$("#closemodal").click()
        $scope.datosAguardar={
        	esp_id_fk:"",
			cte_id_fk:1,
			cti_id_fk:1,
			cit_fechaproxima:null,

        };
        $scope.micat="";
        $scope.actu();
	}

////eliminar
$scope.actguarda=false;
$scope.guardar = function(){$scope.actguarda=true;
 if ($scope.datosAguardar.esp_id_fk === ""){
	 alert("Seleccione una Servicio");
}
else
{
	$http.post('src/sgh/citamedica/php/sghInserCitamedica.php',{cita:$scope.datosAguardar, hcl:$scope.histoclinica,usu:$scope.usuario}).success(function(data){	
			 $scope.text = data.sgh_citamedica_pa;
			 $scope.mensaje= true;
			 $scope.datosAguardar={};
			 setTimeout(function() 
			 {
				$scope.mensaje= false;$scope.actguarda=false;
				$scope.$apply();
			 }, 1500);
		console.log(data);
		});
}
}


}]);