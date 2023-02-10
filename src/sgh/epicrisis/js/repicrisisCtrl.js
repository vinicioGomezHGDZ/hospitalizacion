angular.module("repicrisis",['ngRoute'])
.controller('repicrisisCtrl',['$scope','$http','$stateParams',function($scope,$http,$stateParams,ModalService){

$scope.codped = $stateParams.id; //getting fooVal

var f= document.getElementById("frame");
f.setAttribute("src", "src/sgh/epicrisis/php/reporte.php?c="+$scope.codped)
}]);