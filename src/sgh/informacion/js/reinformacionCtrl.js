angular.module("reinformacion",['ngRoute'])
.controller('reinformacionCtrl',['$scope','$http','$stateParams',function($scope,$http,$stateParams,ModalService){

$scope.codped = $stateParams.id; //getting fooVal

var f= document.getElementById("frame");
f.setAttribute("src", "src/sgh/informacion/php/repor_informacion.php?c="+$scope.codped)

}]);