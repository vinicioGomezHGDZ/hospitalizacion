angular.module("reventoadverso",['ngRoute'])
.controller('reventoadversoCtrl',['$scope','$http','$stateParams',function($scope,$http,$stateParams,ModalService){

$scope.codped = $stateParams.id; //getting fooVal

var f= document.getElementById("frame");
f.setAttribute("src", "src/sgh/eventosadversos/php/repor_eventos_Adversos.php?c="+$scope.codped)
}]);