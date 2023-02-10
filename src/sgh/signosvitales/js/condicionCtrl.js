angular.module("condi",['ngRoute'])
.controller('condiCtrl',['$scope','$http','$routeParams',function($scope,$http,$routeParams,ModalService){
    if ($scope.sgh_v_user === undefined){$scope.cerrarsecion();}
$scope.posicion=null;// guarda el total de items de la tabla
$scope.pagina=1; // variable de paginas a mostrar	 
//cargar datos con json
   $scope.actu= function () {
       $http.post('src/sgh/signosvitales/php/sghListaCondi.php',{idhc:$scope.histoclinica}).success(function (data) {
           if (data.error === "error") {console.log(data);}
           else
           {
               $scope.condi = data;
               $scope.posicion=Math.ceil(data.length / $scope.totalpaginas);
           }
           console.log(data);
       });
   }

    $scope.actu();
 $scope. paginas = function(tipo){if (tipo == 0 && $scope.pagina  > 1 ){$scope.pagina-=1;}else if (tipo == 1 && $scope.pagina < $scope.posicion ){$scope.pagina+=1;}}
    $scope.condicion = {
        model:"",
        condi: [
            {id: 'IGUAL', name: 'IGUAL'},
            {id: 'MEJORANDO', name: 'MEJORANDO'},
            {id: 'EMPEORANDO', name: 'EMPEORANDO'},
            {id: 'GRAVE', name: 'GRAVE'},
            {id: 'DEFUCION', name: 'DEFUCION'},

        ]
    };

    $scope.cancelar = function() {

        $("#closemodal").click()
        $scope.actu();
        $scope.datosAguardar={};
    }
    $scope.guardar = function(){
        $scope.actguarda=true;
        var con =$scope.condicion.model;
        $http.post('src/sgh/signosvitales/php/sghInserSignosVitales.php',{cam:$scope.cama,op:3,sgv:$scope.datosAguardar, hcl:$scope.histoclinica, usu:$scope.usuario, con:con, fecha:$scope.Fecha, diant:$scope.diases, usu:$scope.usuario}).success(function(data){
            $scope.text = data.sgh_sigvitalesdia_ingreso_pa;
            $scope.mensaje= true; $scope.actguarda=false;
            //	 console.log(data);
            setTimeout(function()
            {
                $scope.mensaje= false;
                $scope.$apply();
                $scope.cancelar();
            }, 1500);
           console.log(data);
        });
    }


}]);