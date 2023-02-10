angular.module("evolucion", ['ngRoute'])
    .controller('evolucionCtrl', ['$scope', '$http', '$routeParams', function ($scope, $http, $routeParams, ModalService) {

        if ($scope.sgh_v_user === undefined) {
            $scope.cerrarsecion();
        }
        $scope.Fecha = new Date();

        // array de estado
        $scope.asunto = {
            model: "",
            availableOptions: [
                {id: 'EVOLUCIÓN', name: 'Evolución'},
                {id: 'REPORTE ENFERMERA', name: 'Reporte enfermera'},
                {id: 'NOTA DE INGRESO', name: 'Nota de ingreso'},
                {id: 'NOTA DE ACTUALIZACIÓN', name: 'Nota de Actualización'},
                {id: 'NOTA DE EGRESO', name: 'Nota de Egreso'},
                {id: 'EVOLUCIÓN DE NUTRICIÓN', name: 'Evolución de nutrición'}

            ]
        };
        $scope.estado_colores = function (op, fecha) {
            //console.log('fecha', fecha);
            //console.log('cen_fecha', $scope.cen_fecha);

            var fecha_actual = moment(fecha, 'YYYY-MM-DD');
            var fecha_cen = moment($scope.cen_fecha, 'YYYY-MM-DD')
            //console.log('diff', fecha_actual.diff(fecha_cen))

            if (fecha_actual.diff(fecha_cen)>=0) {
                if (op === true) {
                    return $scope.myStyle = {'background-color': '#CEF6CE', color: '#190707'}
                } else {

                    return $scope.myStyle = {'background-color': '#F6CECE', color: '#190707'}
                }
            } else {
                return $scope.myStyle = {'background-color': '#FFFFFF', color: '#190707'}
            }

        }
        $scope.estados = function (id) {
            $http.post('src/sgh/evolucion/php/sghInserEvolucion.php', {
                op: 4,
                codig: id,
                respon: $scope.nombre_perfil,
                usu: $scope.usuario
            }).success(function (data) {

                $scope.actu();
            });

        }
        $scope.esresident = function (id) {

            $http.post('src/sgh/evolucion/php/sghListaEvoluciones.php', {
                op: 4,
                codigo: $scope.usuario
            }).success(function (datar) {
                console.log(datar);
                if (datar[0].pro_codigomsp === null) {
                    if (datar[0].pro_codigosenescyt === null) {
                        $scope.msp = "C.I " + datar[0].per_numeroidentificacion;
                    } else {
                        $scope.msp = datar[0].pro_codigosenescyt
                    }
                    ;
                } else {
                    $scope.msp = datar[0].pro_codigomsp;
                }
                var profecional = datar[0].medico + " " + $scope.msp;
                $http.post('src/sgh/evolucion/php/sghInserEvolucion.php', {
                    op: 3,
                    codig: id,
                    respon: profecional,
                    usu: $scope.usuario
                }).success(function (data) {
                    console.log(data);
                    $scope.actu();
                });
            });
        }

        $scope.datosAguardar = {eyp_fecha: null};//datos que estraigo de los campos para guardar
        $scope.nuevafechaa = function () {
            $scope.datosAguardar = {eyp_fecha: null};//datos que estraigo de los campos para guardar
        }
        $scope.mensaje = false;

//variables de paginacion

        $scope.posicion = null;// guarda el total de items de la tabla
        $scope.pagina = 1; // variable de paginas a mostrar

//cargar datos con json
        $scope.medicorevisa = function (id_med) {
            var mensaje = "";
            if (id_med != null) {

            }
            return mensaje
        }
        $scope.actu = function () {

            $http.post('src/sgh/evolucion/php/sghListaEvoluciones.php', {
                op: 1,
                idhc: $scope.histoclinica
            }).success(function (data) {

                if (data.error === "error") {
                    console.log(data);
                } else {
                    $scope.evolucion = data;
                    $scope.posicion = Math.ceil(data.length / $scope.totalpaginas);
                }
            });
        }
        if ($scope.histoclinica === null) {
            //alert("Escoja un pacinete");
            window.location = "#/"
        } else {
            $scope.actu();
        }
// Cargar encabesado


        $scope.paginas = function (tipo) {
            if (tipo == 0 && $scope.pagina > 1) {
                $scope.pagina -= 1;
            } else if (tipo == 1 && $scope.pagina < $scope.posicion) {
                $scope.pagina += 1;
            }
        }

        $scope.$watch('Busqueda', function () {

            if ($scope.Busqueda == undefined) return;

            $scope.pagina = 1;
            $scope.posicion = Math.ceil($scope.Busqueda.length / $scope.totalpaginas);
        });

// GUARDAR DATOS
        $scope.men = function () {
            $scope.mensaje = true;
        }

        $scope.cancelar = function () {
            $("#closemodal").click();
            $scope.titulo = "Nuevo Registro";// titulo del modal
            $scope.actu();
            $scope.op = "nuevo";
            $scope.datosAguardar = {eyp_fecha: null};
            $scope.asunto.model = "";
            $scope.actguarda = false;
        }
        $scope.act_voalresidente = function (op) {

            if ($scope.usu_perfil === 'TRATANTE') {
                if (op === true) {
                    return resestado = true;
                } else {
                    return resestado = false;
                }

            } else {
                return resestado = true;
            }
        }
        $scope.actguarda = false;
        $scope.guardar = function () {
            $scope.actguarda = true;
            var asunto = $scope.asunto.model;
            if ($scope.usu_perfil === 'TRATANTE') {
                var resestado = false;

            } else {
                var resestado = false;
            }

            $http.post('src/sgh/evolucion/php/sghInserEvolucion.php', {
                op: 1,
                resp: resestado,
                evo: $scope.datosAguardar,
                hcl: $scope.histoclinica,
                usu: $scope.usuario,
                asu: asunto
            }).success(function (data) {
                console.log(data);
                $scope.text = data.sgh_mei_evolucion_ingresar_pa;
                $scope.mensaje = true;
                setTimeout(function () {
                    $scope.mensaje = false;
                    $scope.actguarda = false;
                    $scope.$apply();
                    $scope.cancelar();
                }, 1500);
                //alert(data);
                console.log(data);
            });
        }
/////////////// Editar ///////
        $scope.titulo = "Nuevo Registro";// titulo del modal
        $scope.op = "nuevo";
        $scope.accion = function () {
            if ($scope.op === 'nuevo') {
                $scope.guardar();
            }
            if ($scope.op === 'editar') {
                $scope.actualizar();
            }
        }


        $scope.edita = function (codigo, residente, enfermera, usu) {
            if ($scope.edita_paciente === true) {
                $scope.opedi = 5;

            } else {
                $scope.opedi = 2;
            }

            $scope.titulo = "Editar Registro";
            $scope.op = "editar";
            $scope.condi = false;

            // LLENA DATOS DE EDICION
            if ($scope.usu_perfil === 'TRATANTE' && residente === false) {
                $http.post('src/sgh/evolucion/php/sghListaEvoluciones.php', {
                    op: 3,
                    codigo: codigo
                }).success(function (data) {
                    if (data != "0") {
                        $scope.asunto.model = data[0].eyp_asunto;
                        $scope.datosAguardar = {
                            eyp_evolucion: data[0].eyp_nodevu,
                            eyp_prescripciones: data[0].eyp_prescr,
                            eyp_id_pk: data[0].eyp_id_pk,
                            eyp_fecha: null
                        }
                        $("#n").click()
                    } else {
                        alert("Lo Sentimos, ya pasaron más de 24 horas, o no es el usuario que ingreso esta evolución");
                        $scope.cancelar();
                    }

                });
            } else {
                if ($scope.usu_perfil === 'RESIDENTE' && enfermera === true && $scope.edita_paciente === false || $scope.usu_perfil === 'TRATANTE' && enfermera === true && $scope.edita_paciente === false) {
                    if (usu != $scope.usuario) {
                        alert("Lo Sentimos, no es el usuario que ingreso esta evolución");
                    } else {
                        alert("Lo Sentimos ya sacaron indicaciones cualquier novedad debe realizar una nueva evolución");

                    }

                } else {
                    $http.post('src/sgh/evolucion/php/sghListaEvoluciones.php', {
                        op: $scope.opedi,
                        codigo: codigo,
                        fech: $scope.Fecha,
                        usu: $scope.usuario
                    }).success(function (data) {
                        if (data != "0") {
                            $scope.asunto.model = data[0].eyp_asunto;
                            $scope.datosAguardar = {
                                eyp_evolucion: data[0].eyp_nodevu,
                                eyp_prescripciones: data[0].eyp_prescr,
                                eyp_id_pk: data[0].eyp_id_pk,
                                eyp_fecha: null,
                            }
                            $("#n").click()
                        } else {
                            if (usu != $scope.usuario) {
                                alert("Lo Sentimos, no es el usuario que ingreso esta evolución");
                            } else {
                                alert("Lo Sentimos, ya pasaron más de 24 horas.");
                                $scope.cancelar();
                            }
                        }
                    });
                }
            }

        }

        $scope.actualizar = function () {

            var asunto = $scope.asunto.model;
            $http.post('src/sgh/evolucion/php/sghInserEvolucion.php', {
                op: 2,
                evo: $scope.datosAguardar,
                asu: asunto,
                usu: $scope.usuario
            }).success(function (data) {
                $scope.text = data.sgh_mei_evolucion_ingresar_pa;
                $scope.mensaje = true;

                setTimeout(function () {
                    $scope.mensaje = false;
                    $scope.$apply();
                    $scope.cancelar();
                }, 1500);
                //alert(data);
                // console.log(data);
            });

        }
    }]);
