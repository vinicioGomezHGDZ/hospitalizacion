angular.module("repote",['ngRoute'])
    .controller('repadultoCtrl',['$scope','$http','$stateParams',function($scope,$http,$stateParams){

        $scope.codped = $stateParams.id; //getting fooVal
        $scope.ruta = $stateParams.ruta; //getting fooVal

if  ($scope.cen_fecha === null){
    alert("Paciente ya dado de alta, solo edición de datos , para imprimir ir a Reportes - Historias clínicas.");
    window.location = "#/listahistorias";
}
else{
      var f= document.getElementById("frame");
        f.setAttribute("src", $scope.ruta+$scope.codped+"&h="+$scope.histoclinica+"&f="+ $scope.cen_fecha)
}
    }]);