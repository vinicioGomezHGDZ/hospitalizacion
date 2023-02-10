angular.module("reporte",['ngRoute'])
.controller('reportCtrl',['$scope','$http','$stateParams',function($scope,$http,$stateParams){

$scope.codped = $stateParams.id; //getting fooVal

var f= document.getElementById("frame");
f.setAttribute("src", "src/sgh/referencia/php/form053.php?c="+$scope.codped)

}]);
