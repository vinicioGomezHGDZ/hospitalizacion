angular.module("listahistorias", ['ngRoute'])
    .controller('listahistoriasCtrl', ['$scope', '$http', 'upload', function ($scope, $http, upload) {
        if ($scope.sgh_v_user === undefined) {
            $scope.cerrarsecion();
        }
        $scope.Fecha = new Date();

//datos que estraigo de los campos para guardar
        $scope.mensaje = false;
        $scope.cat = 1;

//variables de paginacion tabla de periodos
        $scope.posicion = null;// guarda el total de items de la tabla
        $scope.pagina = 1; // variable de paginas a mostrar
        $scope.paginas = function (tipo) {
            if (tipo == 0 && $scope.pagina > 1) {
                $scope.pagina -= 1;
            } else if (tipo == 1 && $scope.pagina < $scope.posicion) {
                $scope.pagina += 1;
            }
        }


//variables de paginacion de tabla de anexos
        $scope.posicion2 = null;// guarda el total de items de la tabla
        $scope.pagina2 = 1; // variable de paginas a mostrar
        $scope.paginas2 = function (tipo) {
            if (tipo == 0 && $scope.pagina2 > 1) {
                $scope.pagina2 -= 1;
            } else if (tipo == 1 && $scope.pagina2 < $scope.posicion2) {
                $scope.pagina2 += 1;
            }
        }

//variables de paginacion de tabla de concentimiendo
        $scope.posicion3 = null;// guarda el total de items de la tabla
        $scope.pagina3 = 1; // variable de paginas a mostrar
        $scope.paginas3 = function (tipo) {
            if (tipo == 0 && $scope.pagina3 > 1) {
                $scope.pagina3 -= 1;
            } else if (tipo == 1 && $scope.pagina3 < $scope.posicion3) {
                $scope.pagina3 += 1;
            }
        }
//variables de paginacion de tabla de concentimiendo de historia cl
        $scope.posicion4 = null;// guarda el total de items de la tabla
        $scope.pagina4 = 1; // variable de paginas a mostrar
        $scope.paginas4 = function (tipo) {
            if (tipo == 0 && $scope.pagina4 > 1) {
                $scope.pagina4 -= 1;
            } else if (tipo == 1 && $scope.pagina4 < $scope.posicion4) {
                $scope.pagina4 += 1;
            }
        }

//cargar datos con json
        $scope.lis_hist = true;
        $scope.lis_menu = false;
        $scope.periodo = false;
        $scope.anexo = false;
        $scope.ver_conce = false;
        $http.post('src/sgh/historiasclinicas/php/sghlistarhistorias.php').success(function (data) {
            //console.log(data);
            if (data.error === "error") {
            } else {
                $scope.historia = data;
                $scope.posicion4 = Math.ceil(data.length / $scope.totalpaginas);
            }
        });
        $scope.actu = function () {
            $http.post('src/sgh/admision/php/sghListarAdmision.php', {idhc: $scope.histoclinica_lacal}).success(function (data) {
                //     console.log(data);
                if (data.error != "error") {

                    $scope.admision = [];
                    $scope.num = data.length + 1;
                    for ($i = 0; $i < data.length; $i++) {
                        $scope.num = $scope.num - 1;
                        $scope.admision.push({
                            Num: $scope.num,
                            adm_fechaingreso: data[$i].adm_fechaingreso,
                            adm_fechadealta: data[$i].adm_fechadealta,
                            adm_id_pk: data[$i].adm_id_pk
                        });
                    }
                    //  $scope.admision = data;
                    $scope.posicion = Math.ceil(data.length / $scope.totalpaginas);
                } else {
                    console.log(data)
                }
            });
        }

        $scope.verhistoria = function (id_his) {
            $scope.histoclinica_lacal = id_his;
            $scope.histoclinica = id_his;
            $scope.lis_hist = false;
            $scope.lis_menu = false;
            $scope.periodo = true;
            $scope.anexo = false;
            $scope.ver_conce = false;
            $scope.actu();
        };
        $scope.verlistareportes = function (fi, fe) {

            if ($scope.histoclinica_lacal != null && fi != null && fe != null) {
                $scope.general_general = true;
                $scope.fe_ingreso = fi;
                $scope.fe_alta = fe;
                $scope.op_reporte = "r_periodo";
                $scope.phpop = 'php_p';
                $scope.lis_hist = false;
                $scope.lis_menu = true;
                $scope.periodo = false;
                $scope.anexo = false;
                $scope.ver_conce = false;

            } else {
                alert("Periodo Incompleto");
            }
            ;

        };
        $scope.verlistareportes_general = function () {

            if ($scope.histoclinica_lacal != null) {
                $scope.general_general = false;
                $scope.op_reporte = "general";
                $scope.phpop = 'php';
                $scope.lis_hist = false;
                $scope.lis_menu = true;
                $scope.periodo = false;
                $scope.anexo = false;
                $scope.ver_conce = false;

            } else {
                alert("Periodo Incompleto");
            }
            ;

        };
        $scope.verconce = function (fi, fe) {
            if ($scope.histoclinica_lacal != null && fi != null && fe != null) {

                $scope.fe_ingreso = fi;
                $scope.fe_alta = fe;
                $scope.lis_hist = false;
                $scope.lis_menu = false;
                $scope.periodo = false;
                $scope.anexo = false;
                $scope.ver_conce = true;

                $http.post('src/sgh/Concentimiento/php/sghListaConcent.php', {
                    op: 2,
                    idhc: $scope.histoclinica_lacal,
                    fi: fi,
                    fe: fe
                }).success(function (data) {
                    console.log(data);
                    if (data.error === "error") {
                        console.log(data);
                        $scope.Concentimiento = null;
                    } else {
                        $scope.Concentimiento = data;
                        $scope.posicion3 = Math.ceil(data.length / $scope.totalpaginas);
                    }
                });
            } else {
                alert("Periodo Incompleto");
            }
            ;

        };

        $scope.actuanexo = function () {
            $http.post('src/sgh/Anexos/php/sghListaAnexo.php', {
                op: 2,
                idhc: $scope.histoclinica_lacal,
                fi: $scope.fe_ingreso,
                fe: $scope.fe_alta
            }).success(function (data) {
                console.log(data);
                if (data.error === "error") {
                    console.log(data);
                    $scope.Concentimiento = null;
                } else {
                    $scope.Concentimiento = data;
                    $scope.posicion2 = Math.ceil(data.length / $scope.totalpaginas);
                }

            });
        }
        $scope.veranexos = function (fi, fe) {
            if ($scope.histoclinica_lacal != null && fi != null && fe != null) {
                $scope.fe_ingreso = fi;
                $scope.fe_alta = fe;
                $scope.lis_hist = false;
                $scope.lis_menu = false;
                $scope.periodo = false;
                $scope.anexo = true;
                $scope.actuanexo();
            } else {
                alert("Periodo Incompleto");
            }
            ;
        };

        $scope.accion_reporte = function (ruta) {
            if ($scope.op_reporte = "general") {
                $scope.repote(ruta);
            }

            if ($scope.op_reporte = "r_periodo") {
                $scope.repote_periodo(ruta);
            }

        }


        $scope.repote = function (ruta) {
            if ($scope.histoclinica_lacal != null) {
                frame.setAttribute("src", ruta + $scope.histoclinica_lacal)
            }
            console.log(ruta + $scope.histoclinica_lacal);
        };

        $scope.repote_periodo = function (ruta) {

            if ($scope.histoclinica_lacal != null && $scope.fe_alta != null && $scope.fe_ingreso != null) {
                frame.setAttribute("src", ruta + $scope.histoclinica_lacal + "&fi=" + $scope.fe_ingreso + "&fa=" + $scope.fe_alta)
            }
        };


        $scope.atras = function () {
            $scope.lis_hist = true;
            $scope.lis_menu = false;
            $scope.periodo = false;
            $scope.anexo = false;
        }
        $scope.atras2 = function () {
            $scope.lis_hist = false;
            $scope.lis_menu = false;
            $scope.periodo = true;
            $scope.anexo = false;
            $scope.ver_conce = false;
        }

        $scope.ver_reporte = true;
        $scope.ver_anexo = false;

        $scope.nuevo = function () {
            $scope.ver_reporte = false;
            $scope.ver_anexo = true;
        }

        $scope.cancelar = function () {
            angular.element("input[type='file']").val(null);
            $("#closemodal").click();
            $scope.actguarda = false;
            $scope.actuanexo();
            $scope.ver_reporte = true;
            $scope.ver_anexo = false;
        }

        $scope.actguarda = false;
        $scope.guardar = function () {
            $scope.actguarda = true;
            var file = $scope.file;
            upload.uploadFile(file, name).success(function (res) {
                $scope.text = res;

                if ($scope.text != "Solo Archivos pdf, png, jpg, gif") {
                    $http.post('src/sgh/Anexos/php/sghInserAnexo.php', {
                        op: 2,
                        hcl: $scope.histoclinica_lacal,
                        fecha: $scope.fe_alta,
                        usu: $scope.usuario,
                        ext: $scope.text
                    }).success(function (data) {
                        $scope.text = data.sgh_anexos_ingresa_pa;
                        $scope.mensaje = true;

                        setTimeout(function () {
                            $scope.mensaje = false;
                            $scope.$apply();
                            // $("#closemodal").click();
                            $scope.cancelar();
                        }, 1500);
                        console.log(data);
                    });
                } else {
                    $scope.actguarda = false;
                    $scope.text = res;
                    $scope.mensaje = true;
                    setTimeout(function () {
                        $scope.mensaje = false;
                        $scope.$apply();
                        angular.element("input[type='file']").val(null);
                        //$("#closemodal").click();
                        //$scope.actu();
                        $scope.actguarda = false;
                    }, 5000);
                }
                console.log(res);
            })
        }
    }])

    .directive('uploaderModel', ["$parse", function ($parse) {
        return {
            restrict: 'A',
            link: function (scope, iElement, iAttrs) {
                iElement.on("change", function (e) {
                    $parse(iAttrs.uploaderModel).assign(scope, iElement[0].files[0]);
                });
            }
        };
    }])

    .service('upload', ["$http", "$q", function ($http, $q) {
        this.uploadFile = function (file, name) {
            var deferred = $q.defer();
            var formData = new FormData();
            formData.append("name", name);
            formData.append("file", file);
            return $http.post("src/sgh/Anexos/php/Anexo_sube.php", formData,
                {
                    headers: {
                        "Content-type": undefined
                    },
                    transformRequest: angular.identity
                }
            )
                .success(function (res) {
                    deferred.resolve(res);
                })
                .error(function (msg, code) {
                    deferred.reject(msg);
                })
            return deferred.promise;
        }
    }])