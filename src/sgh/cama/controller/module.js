angular.module("camas",["ui.bootstrap",
    {
        name: "camas",
        files: ["src/sgh/cama/controller/service.js"]
    }
])
.controller("camaController",
    ["$scope","getAll_camaFactory","getAll_tipocamaFactory","iu_camaFactory","deleteById_camaFactory","$timeout","$http","$filter",
    function($scope,getAll_camaFactory,getAll_tipocamaFactory,iu_camaFactory,deleteById_camaFactory,$timeout,$http,$filter)
{
    //menu activo
    $scope.setActive("cama");

    //progress bar
    $scope.mostrarProgreso = true;
    $scope.dataLength = 0;

    $scope.cargarDatos = function(){
        getAll_camaFactory.get().then(function(getData){
            $scope.camas = getData.data;
            // console.log(getData.data);
            //$scope.posicion = Math.round(getData.data.length/$scope.totalPaginas);
            $scope.dataLength = getData.data.length;
            $scope.mostrarProgreso = false;
        });
    };

    $scope.cargarDatosTipoCamaServicio = function(){
        getAll_tipocamaFactory.get().then(function(getData){
            $scope.tipoCamaServ = getData.data;
        });
    };

    $scope.cargarDatosTipoCamaPiso = function(){
        getAll_tipocamaFactory.get().then(function(getData){
            $scope.tipoCamaPiso = getData.data;
        });
    };

    $scope.cargarDatosTipoCamaHabitacion = function(){
        getAll_tipocamaFactory.get().then(function(getData){
            $scope.tipoCamaHab = getData.data;
        });
    };

    //variables de paginacion
    $scope.currentPage = 0;
    $scope.pageSize = 5;
    $scope.data = [];
    $scope.search = '';

    $scope.getData = function (){
      return $filter('filter')($scope.dataLength,$scope.search)
    };

    $scope.numberOfPages = function(){
        return Math.ceil($scope.dataLength/$scope.pageSize);
    };

    //formulario general
    $scope.titulo = "Cama";
    $scope.encabezadoForm = ["Id","Tipo Cama","Descripción","Visible","Acción"];

    //formulario modal
    $scope.formModal = "src/sgadm/cama/view/formModal.html";
    $scope.nuevo = false;

    //alerta
    $scope.estadoAlertaModal = false;
    $scope.estadoAlertaForm = false;

    $scope.mostrarAlerta = function(estado,mensaje,alerta) {
        //$scope.estadoAlerta = true;
        var icoAlerta = null;

        switch(alerta){
            case "m":
                $scope.estadoAlertaModal = true;
                break;
            case "f":
                $scope.estadoAlertaForm = true;
                break;
        }

        switch (estado) {
            case 0:
                tipo = "alert-success";
                icoAlerta = "glyphicon glyphicon-ok";
                break;
            case 1:
                tipo = "alert-info";
                icoAlerta = "glyphicon glyphicon-info-sign";
                break;
            case 2:
                tipo = "alert-warning";
                icoAlerta = "glyphicon glyphicon-warning-sign";
                break;
            case 3:
                tipo = "alert-danger";
                icoAlerta = "glyphicon-exclamation-sign";
                break;
            default:
                tipo = "alert-danger";
                icoAlerta = "glyphicon-exclamation-sign";
        }
        $scope.tipoAlerta = tipo;
        $scope.iconoAlerta = icoAlerta;
        $scope.mensajeAlerta = mensaje;
      $timeout(function(){
          $scope.estadoAlertaModal = false;
          $scope.estadoAlertaForm = false;

      },5000);
    };

    //formulario modal nuevo
    $scope.camaData = {};
    $scope.formNuevo = function(){
        $scope.nuevo = true;
        $scope.tituloForm = "Nuevo " + $scope.titulo;
        console.log("Nuevo");
        // $scope.camaData =
        $scope.camaData.cam_id_pk = null;
        $scope.camaData.tca_id_fk = null;
        //$scope.camaData.tzo_id_fk = $scope.tipozonas[0].tzo_id_pk;
        $scope.camaData.cam_descripcion = null;
        $scope.camaData.cam_codigo = null;
        $scope.camaData.cam_visible = true;

        //$scope.camaData.tzo_id_pk = $scope.idLastTipoZona[0].id_max;
        // console.log("id "+$scope.getLastID());
        //$scope.camaData.tzo_id_pk = $scope.idtipozonas[0].id_max;
    };


    //formulario modal editar
    $scope.formEditar = function(getData){
        $scope.nuevo = false;
        $scope.tituloForm = "Editar " + $scope.titulo;
        console.log("Editar");
        $scope.camaData = getData;
        console.log($scope.camaData);
    };

    $scope.submitForm = function() {
        console.log("Guardar");
        console.log($scope.camaData);
        console.log(JSON.stringify($scope.camaData));
        iu_camaFactory.post($scope.camaData).then(function(response){
            // console.log("Module");
            var res = response.data;
            // console.log(res);
            // console.log(res.Estado);
            // console.log(res.Mensaje);
            // console.log(response.data[0].sp_tipozona_ingresar.Estado);
            $scope.mostrarAlerta(res.Estado,res.Mensaje,"m");
            $scope.cargarDatos();
        });
    };

    $scope.borrarFila = function(fila){
        deleteById_camaFactory.post(fila).then(function(response){
            console.log("Module");
            var res = response.data;
            console.log(res);
            console.log(res.Estado);
            console.log(res.Mensaje);
            // console.log(response.data[0].sp_tipozona_ingresar.Estado);
            $scope.mostrarAlerta(res.Estado,res.Mensaje,"f");
            $scope.cargarDatos();
        });
    };

    $scope.deleteRow = function(fila){
        bootbox.confirm({
            title: "¿Está seguro/a que desea eliminar? ",
            message:  fila.cam_descripcion + " " + fila.cam_id_pk,
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Cancelar'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Confirmar'
                }
            },
            callback: function (result) {
                console.log('This was logged in the callback: ' + result);
                if (result){
                    //condicion verdadera
                    $scope.borrarFila(fila);
                }else{
                    //condicion falsa
                }
            }
        });
    };

}]);