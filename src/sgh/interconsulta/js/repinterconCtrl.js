angular.module("reinterconsulta",['ngRoute'])
.controller('repinterconCtrl',['$scope','$http','$stateParams',function($scope,$http,$stateParams,ModalService){

$scope.codped = $stateParams.id; //getting fooVal

var f= document.getElementById("frame");
f.setAttribute("src", "src/sgh/interconsulta/php/reporte_intercons.php?c="+$scope.codped)
}]);