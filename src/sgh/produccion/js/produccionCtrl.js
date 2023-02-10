angular.module('produccion', ['ui.router', 'ui.bootstrap'])
    .controller('produccionCtrl', ['$scope', '$http', '$stateParams', function ($scope, $http) {


        const startOfMonth = moment().startOf('month').format('DD-MM-YYYY');
        const endOfMonth = moment().endOf('month').format('DD-MM-YYYY');

        $scope.reporte = {
            'opcion': 0,
            'pro_id_pk': null,
            'opcion1_fecha1': startOfMonth,
            'opcion1_fecha2': endOfMonth,

        }

        $scope.open = function ($event, option) {
            $event.preventDefault();
            $event.stopPropagation();

            switch (option) {
                case 1:
                    $scope.opcion1_opened1 = true;
                    break;
                case 2:
                    $scope.opcion1_opened2 = true;
                    break;
            }
        };

        $scope.dateOptions = {
            formatYear: 'yyyy',
            formatMonth: 'MM',
            formatDay: 'dd',
            startingDay: 1
        };

        $scope.cargarMedicos = function () {
            $http.get('src/sgh/produccion/php/getAllMedico.php').then(function (response) {
                $scope.medicos = response.data;
                //console.log($scope.medicos);
            })
        }

//// general
        $scope.generar_reporte = function (report) {

            var url = null;
            switch (report) {
                case 1:
                    if ($scope.reporte.pro_id_pk === null) return;
                    url = 'src/sgh/produccion/php/reporte_produccion_medico.php?'
                        .concat(
                            'id_profesional=', $scope.reporte.pro_id_pk,
                            '&fecha_desde=', $scope.reporte.opcion1_fecha1,
                            '&fecha_hasta=', $scope.reporte.opcion1_fecha2
                        )
                    console.log(url);
                    break;
                case 2:

                    break;

                default:
                    console.error('No ha escogido ningún reporte')
                    break;
                    return;
            }

            frame.setAttribute(
                'src', url
            )

            /*  $http.post('src/sgh/censo_dia/php/sghListarCenso.php', {
                  op: 1,
                  codigo: $scope.datosAguardar.tca_serv_fk
              }).success(function (data) {
                  console.log(data);
                  if (data.error === 'erro') {
                  } else {
                      $scope.serv = data[0].tca_descripcion;
                      $scope.piso = data[0].tca_descripcion;
                      frame.setAttribute('src', 'src/sgh/r_condipaciente/php/reporte_condicion.php?s=' + $scope.serv + '&f=' + $scope.datosAguardar.fecha + '&res=' + $scope.usuario)

                  }
              });*/
        }

    }]);
