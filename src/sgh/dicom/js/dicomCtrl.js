angular.module('dicom', ['ngRoute'])
    .controller('dicomCtrl', ['$scope', '$http', '$window', '$location', function ($scope, $http, $window, $location) {

        $scope.cargarDatos = function () {
            console.log('cargarDatos');
            console.log($scope.histoclinica);
            var send = {hce_id_fk: $scope.histoclinica};
            $http.post('src/sgh/dicom/php/getAll.php', send).success(function (data) {
                $scope.dicoms = data;
            });
        };

        $scope.visualizar = function (item) {
            console.log('visualizar dicom');
            var store = {
                hca_id_pk: item.hca_id_pk,
                tdo_descripcion: item.tdo_descripcion,
                hca_descripcion: item.hca_descripcion,
                hca_fecha: item.hca_fecha,
                hca_ruta_archivo: item.hca_ruta_vista + item.hca_id_pk + '.' + item.hca_extension,
                paciente: item.paciente,
                edad: item.edad
            };
            console.log(store);
            sessionStorage.setItem('sessionDicom', angular.toJson(store));
            var dicom_url = '/scripts/cornerstoneWADOImageLoader-master/examples/wadouri/index.html';
            var app_project = null;
            switch ($location.host()) {
                case '181.196.107.91':
                case '172.20.19.241':
                case 'sgh.hgsd.gob.ec':
                    app_project = '/sgh';
                    break;
                case 'localhost':
                    app_project = '/sgadm_urban';
                    break;

            }
            $window.open(app_project + dicom_url, '_blank');
        };

    }]);