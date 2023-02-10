angular.module("sigvit", ['ngRoute'])
    .controller('sigvitCtrl', ['$scope', '$http', '$routeParams', function ($scope, $http, $routeParams) {
        $scope.Fecha = new Date();
        $scope.diaint = 0;
        $scope.condi = true;
        $scope.guar = true;
        $scope.activa = "readonly";

        if ($scope.sgh_v_user === undefined) {
            $scope.cerrarsecion();
        }
        $scope.tiposignos = true;
        $scope.actisvt = false;
        $scope.actitempe = false;
        $scope.signosvitales = function () {
            $scope.tiposignos = false;
            $scope.actisvt = true;
            $scope.datosAguardar.svd_opingreso = true;
        }
        $scope.temperatura = function () {
            $scope.tiposignos = false;
            $scope.actitempe = true;
            $scope.datosAguardar.svd_opingreso = false;
        }

        //cargar datos de estado en combo

        $scope.datosAguardar = {
            cdp_fpalta: null,
            cdp_fopera: null,
            cdp_fuoper: null,
            svd_aseo: false,
            svd_banio: false,
            svd_camson: null,
            svd_parent: 0,
            svd_viaora: 0,
            svd_orina: 0,
            svd_drenaj: 0,
            svd_otros: 0, svd_peso: 0, svd_talla: 0,
            svd_fcha: new Date()

        };//datos que estraigo de los campos para guardar
        $scope.mensaje = false;

//variables de paginacion

        $scope.posicion = null;// guarda el total de items de la tabla
        $scope.pagina = 1; // variable de paginas a mostrar
        $scope.paginas = function (tipo) {
            if (tipo == 0 && $scope.pagina > 1) {
                $scope.pagina -= 1;
            } else if (tipo == 1 && $scope.pagina < $scope.posicion) {
                $scope.pagina += 1;
            }
        }
        $scope.posicion1 = null;// guarda el total de items de la tabla
        $scope.pagina1 = 1; // variable de paginas a mostrar
        $scope.paginas1 = function (tipo) {
            if (tipo == 0 && $scope.pagina1 > 1) {
                $scope.pagina1 -= 1;
            } else if (tipo == 1 && $scope.pagina1 < $scope.posicion1) {
                $scope.pagina1 += 1;
            }
        }
/// conteo de dias
        $scope.diasestadia = function () {
            $http.post('src/sgh/epicrisis/php/sghListaEpicrisis.php', {
                op: '6',
                idce: $scope.id_cen_pk
            }).success(function (data) {

                $scope.diases = parseInt(data[0].dia);


                //console.log(data);
            });

        }
/// funcion que geera datos estadisticos de grafico
        $scope.gracondi = function (fecha) {
            $scope.mañana = function () {
                $scope.totaloral = 0;
                $scope.totalparental = 0;
                $scope.totalparecanab = 0;
                $scope.totalorina = 0;
                $scope.totalotros = 0;


                $http.post('src/sgh/ingesta/php/sghgetIngesta.php', {
                    fecha: $scope.fecha,
                    idhc: $scope.histoclinica,
                    tipo: 'MAÑANA',
                    OP: '1'
                }).success(function (data) {
                    if (data.error === true) {
                        $scope.oral = {};
                    } else {
                        $scope.oral = data;
                        for (var i = 0; i <= data.length - 1; i++) {
                            $scope.totaloral += parseInt(data [i].cie_cantcc);
                        }
                    }
                    console.log(data);
                });

                $http.post('src/sgh/ingesta/php/sghgetIngesta.php', {
                    fecha: $scope.fecha,
                    idhc: $scope.histoclinica,
                    tipo: 'MAÑANA',
                    OP: '2'
                }).success(function (data) {
                    if (data.error === true) {
                        $scope.parental = {};
                    } else {
                        $scope.parental = data;
                        for (var i = 0; i <= data.length - 1; i++) {
                            $scope.totalparental += parseInt(data[i].cie_cantcc);
                            $scope.totalparecanab += parseInt(data[i].cie_canabs);
                        }
                    }

                });
                $http.post('src/sgh/ingesta/php/sghgetIngesta.php', {
                    fecha: $scope.fecha,
                    idhc: $scope.histoclinica,
                    tipo: 'MAÑANA',
                    OP: '3'
                }).success(function (data) {
                    if (data.error === true) {
                        $scope.orina = {};
                    } else {
                        $scope.orina = data;
                        for (var i = 0; i <= data.length - 1; i++) {
                            $scope.totalorina += parseInt(data[i].cie_cantcc);
                        }
                    }
                });
                $http.post('src/sgh/ingesta/php/sghgetIngesta.php', {
                    fecha: $scope.fecha,
                    idhc: $scope.histoclinica,
                    tipo: 'MAÑANA',
                    OP: '4'
                }).success(function (data) {
                    if (data.error === true) {
                        $scope.otros = {};
                    } else {
                        $scope.otros = data;
                        for (var i = 0; i <= data.length - 1; i++) {
                            $scope.totalotros += parseInt(data[i].cie_cantcc);
                        }
                    }
                });
            }
            $scope.tarde = function () {
                $scope.totaloralt = 0;
                $scope.totalparentalt = 0;
                $scope.totalparecanabt = 0;
                $scope.totalorinat = 0;
                $scope.totalotrost = 0;

                $http.post('src/sgh/ingesta/php/sghgetIngesta.php', {
                    fecha: $scope.fecha,
                    idhc: $scope.histoclinica,
                    tipo: 'TARDE',
                    OP: '1'
                }).success(function (data) {
                    if (data.error === true) {
                        $scope.oralT = {};
                    } else {
                        $scope.oralT = data;
                        for (var i = 0; i <= data.length - 1; i++) {
                            $scope.totaloralt += parseInt(data [i].cie_cantcc);
                        }
                    }

                });

                $http.post('src/sgh/ingesta/php/sghgetIngesta.php', {
                    fecha: $scope.fecha,
                    idhc: $scope.histoclinica,
                    tipo: 'TARDE',
                    OP: '2'
                }).success(function (data) {
                    if (data.error === true) {
                        $scope.parentalT = {};
                    } else {
                        $scope.parentalT = data;
                        for (var i = 0; i <= data.length - 1; i++) {
                            $scope.totalparentalt += parseInt(data[i].cie_cantcc);
                            $scope.totalparecanabt += parseInt(data[i].cie_canabs);
                        }
                    }
                });
                $http.post('src/sgh/ingesta/php/sghgetIngesta.php', {
                    fecha: $scope.fecha,
                    idhc: $scope.histoclinica,
                    tipo: 'TARDE',
                    OP: '3'
                }).success(function (data) {
                    if (data.error === true) {
                        $scope.orinaT = {};
                    } else {
                        $scope.orinaT = data;
                        for (var i = 0; i <= data.length - 1; i++) {
                            $scope.totalorinat += parseInt(data[i].cie_cantcc);
                        }
                    }
                });
                $http.post('src/sgh/ingesta/php/sghgetIngesta.php', {
                    fecha: $scope.fecha,
                    idhc: $scope.histoclinica,
                    tipo: 'TARDE',
                    OP: '4'
                }).success(function (data) {
                    if (data.error === true) {
                        $scope.otrosT = {};
                    } else {
                        $scope.otrosT = data;
                        for (var i = 0; i <= data.length - 1; i++) {
                            $scope.totalotrost += parseInt(data[i].cie_cantcc);
                        }
                    }
                });
            }
            $scope.noche = function () {
                $scope.totaloralN = 0;
                $scope.totalparentalN = 0;
                $scope.totalparecanabN = 0;
                $scope.totalorinaN = 0;
                $scope.totalotrosN = 0;

                $http.post('src/sgh/ingesta/php/sghgetIngesta.php', {
                    fecha: $scope.fecha,
                    idhc: $scope.histoclinica,
                    tipo: 'NOCHE',
                    OP: '1'
                }).success(function (data) {
                    if (data.error === true) {
                        $scope.oralN = {};
                    } else {
                        $scope.oralN = data;
                        for (var i = 0; i <= data.length - 1; i++) {
                            $scope.totaloralN += parseInt(data [i].cie_cantcc);
                        }
                    }
                });
                $http.post('src/sgh/ingesta/php/sghgetIngesta.php', {
                    fecha: $scope.fecha,
                    idhc: $scope.histoclinica,
                    tipo: 'NOCHE',
                    OP: '2'
                }).success(function (data) {
                    if (data.error === true) {
                        $scope.parentalN = {};
                    } else {
                        $scope.parentalN = data;
                        for (var i = 0; i <= data.length - 1; i++) {
                            $scope.totalparentalN += parseInt(data[i].cie_cantcc);
                            $scope.totalparecanabN += parseInt(data[i].cie_canabs);
                        }
                    }
                });
                $http.post('src/sgh/ingesta/php/sghgetIngesta.php', {
                    fecha: $scope.fecha,
                    idhc: $scope.histoclinica,
                    tipo: 'NOCHE',
                    OP: '3'
                }).success(function (data) {
                    if (data.error === true) {
                        $scope.orinaN = {};
                    } else {
                        $scope.orinaN = data;
                        for (var i = 0; i <= data.length - 1; i++) {
                            $scope.totalorinaN += parseInt(data[i].cie_cantcc);
                        }
                    }
                });
                $http.post('src/sgh/ingesta/php/sghgetIngesta.php', {
                    fecha: $scope.fecha,
                    idhc: $scope.histoclinica,
                    tipo: 'NOCHE',
                    OP: '4'
                }).success(function (data) {
                    if (data.error === true) {
                        $scope.otrosN = {};
                    } else {
                        $scope.otrosN = data;
                        for (var i = 0; i <= data.length - 1; i++) {
                            $scope.totalotrosN += parseInt(data[i].cie_cantcc);
                        }
                    }
                });
            }
        }

///// funcion para cargar datos de BALANCE HÍDRICO
        $scope.mañana = function () {
            $scope.totaloral = 0;
            $scope.totalparental = 0;
            $scope.totalparecanab = 0;
            $scope.totalorina = 0;
            $scope.totalotros = 0;


            $http.post('src/sgh/ingesta/php/sghgetIngesta.php', {
                fecha: $scope.fecha,
                idhc: $scope.histoclinica,
                tipo: 'MAÑANA',
                OP: '1'
            }).success(function (data) {
                if (data.error === true) {
                    $scope.oral = {};
                } else {
                    $scope.oral = data;
                    for (var i = 0; i <= data.length - 1; i++) {
                        $scope.totaloral += parseFloat(data [i].cie_cantcc);
                    }
                }
                console.log(data);
            });

            $http.post('src/sgh/ingesta/php/sghgetIngesta.php', {
                fecha: $scope.fecha,
                idhc: $scope.histoclinica,
                tipo: 'MAÑANA',
                OP: '2'
            }).success(function (data) {
                if (data.error === true) {
                    $scope.parental = {};
                } else {
                    $scope.parental = data;
                    for (var i = 0; i <= data.length - 1; i++) {
                        $scope.totalparental += parseFloat(data[i].cie_cantcc);
                        $scope.totalparecanab += parseFloat(data[i].cie_canabs);
                    }
                }

            });
            $http.post('src/sgh/ingesta/php/sghgetIngesta.php', {
                fecha: $scope.fecha,
                idhc: $scope.histoclinica,
                tipo: 'MAÑANA',
                OP: '3'
            }).success(function (data) {
                if (data.error === true) {
                    $scope.orina = {};
                } else {
                    $scope.orina = data;
                    for (var i = 0; i <= data.length - 1; i++) {
                        $scope.totalorina += parseFloat(data[i].cie_cantcc);
                    }
                }
            });
            $http.post('src/sgh/ingesta/php/sghgetIngesta.php', {
                fecha: $scope.fecha,
                idhc: $scope.histoclinica,
                tipo: 'MAÑANA',
                OP: '4'
            }).success(function (data) {
                if (data.error === true) {
                    $scope.otros = {};
                } else {
                    $scope.otros = data;
                    for (var i = 0; i <= data.length - 1; i++) {
                        $scope.totalotros += parseFloat(data[i].cie_cantcc);
                    }
                }
            });
        }
        $scope.tarde = function () {
            $scope.totaloralt = 0;
            $scope.totalparentalt = 0;
            $scope.totalparecanabt = 0;
            $scope.totalorinat = 0;
            $scope.totalotrost = 0;

            $http.post('src/sgh/ingesta/php/sghgetIngesta.php', {
                fecha: $scope.fecha,
                idhc: $scope.histoclinica,
                tipo: 'TARDE',
                OP: '1'
            }).success(function (data) {
                if (data.error === true) {
                    $scope.oralT = {};
                } else {
                    $scope.oralT = data;
                    for (var i = 0; i <= data.length - 1; i++) {
                        $scope.totaloralt += parseFloat(data [i].cie_cantcc);
                    }
                }

            });

            $http.post('src/sgh/ingesta/php/sghgetIngesta.php', {
                fecha: $scope.fecha,
                idhc: $scope.histoclinica,
                tipo: 'TARDE',
                OP: '2'
            }).success(function (data) {
                if (data.error === true) {
                    $scope.parentalT = {};
                } else {
                    $scope.parentalT = data;
                    for (var i = 0; i <= data.length - 1; i++) {
                        $scope.totalparentalt += parseFloat(data[i].cie_cantcc);
                        $scope.totalparecanabt += parseFloat(data[i].cie_canabs);
                    }
                }
            });
            $http.post('src/sgh/ingesta/php/sghgetIngesta.php', {
                fecha: $scope.fecha,
                idhc: $scope.histoclinica,
                tipo: 'TARDE',
                OP: '3'
            }).success(function (data) {
                if (data.error === true) {
                    $scope.orinaT = {};
                } else {
                    $scope.orinaT = data;
                    for (var i = 0; i <= data.length - 1; i++) {
                        $scope.totalorinat += parseFloat(data[i].cie_cantcc);
                    }
                }
            });
            $http.post('src/sgh/ingesta/php/sghgetIngesta.php', {
                fecha: $scope.fecha,
                idhc: $scope.histoclinica,
                tipo: 'TARDE',
                OP: '4'
            }).success(function (data) {
                if (data.error === true) {
                    $scope.otrosT = {};
                } else {
                    $scope.otrosT = data;
                    for (var i = 0; i <= data.length - 1; i++) {
                        $scope.totalotrost += parseFloat(data[i].cie_cantcc);
                    }
                }
            });
        }
        $scope.noche = function () {
            $scope.totaloralN = 0;
            $scope.totalparentalN = 0;
            $scope.totalparecanabN = 0;
            $scope.totalorinaN = 0;
            $scope.totalotrosN = 0;

            $http.post('src/sgh/ingesta/php/sghgetIngesta.php', {
                fecha: $scope.fecha,
                idhc: $scope.histoclinica,
                tipo: 'NOCHE',
                OP: '1'
            }).success(function (data) {
                if (data.error === true) {
                    $scope.oralN = {};
                } else {
                    $scope.oralN = data;
                    for (var i = 0; i <= data.length - 1; i++) {
                        $scope.totaloralN += parseFloat(data [i].cie_cantcc);
                    }
                }
            });
            $http.post('src/sgh/ingesta/php/sghgetIngesta.php', {
                fecha: $scope.fecha,
                idhc: $scope.histoclinica,
                tipo: 'NOCHE',
                OP: '2'
            }).success(function (data) {
                if (data.error === true) {
                    $scope.parentalN = {};
                } else {
                    $scope.parentalN = data;
                    for (var i = 0; i <= data.length - 1; i++) {
                        $scope.totalparentalN += parseFloat(data[i].cie_cantcc);
                        $scope.totalparecanabN += parseFloat(data[i].cie_canabs);
                    }
                }
            });
            $http.post('src/sgh/ingesta/php/sghgetIngesta.php', {
                fecha: $scope.fecha,
                idhc: $scope.histoclinica,
                tipo: 'NOCHE',
                OP: '3'
            }).success(function (data) {
                if (data.error === true) {
                    $scope.orinaN = {};
                } else {
                    $scope.orinaN = data;
                    for (var i = 0; i <= data.length - 1; i++) {
                        $scope.totalorinaN += parseFloat(data[i].cie_cantcc);
                    }
                }
            });
            $http.post('src/sgh/ingesta/php/sghgetIngesta.php', {
                fecha: $scope.fecha,
                idhc: $scope.histoclinica,
                tipo: 'NOCHE',
                OP: '4'
            }).success(function (data) {
                if (data.error === true) {
                    $scope.otrosN = {};
                } else {
                    $scope.otrosN = data;
                    for (var i = 0; i <= data.length - 1; i++) {
                        $scope.totalotrosN += parseFloat(data[i].cie_cantcc);
                    }
                }
            });
        }

        $scope.balance = function (fecha) {
            $scope.fecha = fecha;
            if (fecha === undefined) {
                alert("Seleccione fecha");
            } else {
                $scope.mañana();
                $scope.tarde();
                $scope.noche();
                setTimeout(function () {
                    $scope.datosAguardar.svd_parent = $scope.totalparecanab + $scope.totalparecanabt + $scope.totalparecanabN;
                    $scope.datosAguardar.svd_viaora = $scope.totaloral + $scope.totaloralt + $scope.totaloralN;
                    $scope.datosAguardar.svd_orina = $scope.totalorina + $scope.totalorinat + $scope.totalorinaN;
                    $scope.datosAguardar.svd_otros = $scope.totalotros + $scope.totalotrost + $scope.totalotrosN;
                }, 1000);
            }
        }

        /// funcin para visualizar dotos de signos vitales o grafico
        $scope.svtotal = true;
        $scope.svpultem = false;
        ///   $scope.opciones=0+"";
        $scope.opciones = "0";
        $scope.ver_daots_sv_gra = function (op) {
            if (op === "1") {
                $scope.svtotal = false;
                $scope.svpultem = true;
            } else {
                $scope.svtotal = true;
                $scope.svpultem = false;
            }
        }

//cargar datos con json
        $scope.actu = function () {
            $http.post('src/sgh/signosvitales/php/sghListaSignosVitales.php', {
                op: 1,
                idhc: $scope.histoclinica
            }).success(function (data) {
                if (data.error === "error") {
                    console.log(data);
                } else {
                    $scope.sigvita = data;
                    $scope.posicion = Math.ceil(data.length / $scope.totalpaginas);
                    $scope.diaint = data.length;
                    console.log(data);
                    $scope.diasestadia();
                }
            });

            $http.post('src/sgh/signosvitales/php/sghListaSignosVitales.php', {
                op: 4,
                idhc: $scope.histoclinica
            }).success(function (data) {
                if (data.error === "error") {
                    console.log(data);
                } else {
                    $scope.graf = data;
                    $scope.posicion1 = Math.ceil(data.length / $scope.totalpaginas);

                }
                console.log(data);
            });
        }

        if ($scope.histoclinica === null) {
            // alert("Escoja un pacinete");
            window.location = "#/"
        } else {
            $scope.actu();
        }

// GUARDAR DATOS
        $scope.cancelar = function () {
            $scope.tiposignos = true;
            $scope.actisvt = false;
            $scope.actitempe = false;
            $("#closemodal").click()
            $scope.condi = true;
            $scope.guar = true;
            $scope.actu();

            $scope.datosAguardar = {
                cdp_fpalta: null,
                cdp_fopera: null,
                cdp_fuoper: null,
                svd_aseo: false,
                svd_banio: false,
                svd_camson: null,
                svd_parent: 0,
                svd_viaora: 0,
                svd_orina: 0,
                svd_drenaj: 0,
                svd_otros: 0,
                svd_peso: 0,
                svd_talla: 0
            };
        }
        $scope.actguarda = false;
        $scope.guardar = function () {
            $scope.actguarda = true;

            $http.post('src/sgh/signosvitales/php/sghInserSignosVitales.php', {
                cam: $scope.cama,
                op: 1,
                sgv: $scope.datosAguardar,
                hcl: $scope.histoclinica,
                usu: $scope.usuario,
                diant: $scope.diases
            }).success(function (data) {
                $scope.text = data.sgh_sigvitalesdia_ingreso_pa;
                $scope.mensaje = true;
                $scope.actguarda = false;
                console.log(data);

                setTimeout(function () {
                    $scope.mensaje = false;
                    $scope.$apply();
                    $scope.cancelar();
                }, 1500);
                //alert(data);
            });
        }

        ////// Edición/////////////////

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
        $scope.edita = function (codigo) {
            $scope.titulo = "Editar Registro";
            $scope.op = "editar";
            $scope.id = codigo;
            $scope.condi = false;
            $scope.tiposignos = false;
            $scope.actisvt = true;

            $scope.datosAguardar = [];
            // LLENA DATOS DE EDICION
            $http.post('src/sgh/signosvitales/php/sghListaSignosVitales.php', {
                op: 2,
                codigo: codigo,
                fech: $scope.Fecha,
                usu: $scope.usuario
            }).success(function (data) {
                if (data !== "0") {


                    $scope.datosAguardar = {
                        svd_actfis: data[0].svd_actfis,
                        svd_aseo: data[0].svd_aseo,
                        svd_banio: data[0].svd_banio,
                        svd_camson: data[0].svd_camson,
                        svd_diante: data[0].svd_diante,
                        svd_dieadm: data[0].svd_dieadm,
                        svd_drenaj: parseFloat(data[0].svd_drenaj),
                        svd_freres: parseFloat(data[0].svd_freres),
                        svd_numcom: parseInt(data[0].svd_numcom),
                        svd_numdep: parseInt(data[0].svd_numdep),
                        svd_numicc: parseInt(data[0].svd_numicc),
                        svd_orina: parseFloat(data[0].svd_orina),
                        svd_otros: parseFloat(data[0].svd_otros),
                        svd_parent: parseFloat(data[0].svd_parent),
                        svd_peso: parseFloat(data[0].svd_peso),
                        svd_predia: parseFloat(data[0].svd_predia),
                        svd_presis: parseFloat(data[0].svd_presis),
                        svd_pulos: parseFloat(data[0].svd_pulso),
                        svd_recvia: data[0].svd_recvia,
                        svd_satoxi: data[0].svd_satoxi,
                        svd_temper: parseFloat(data[0].svd_tempe),
                        svd_toteli: data[0].svd_toteli,
                        svd_toting: data[0].svd_toting,
                        svd_viaora: parseFloat(data[0].svd_viaora),
                        svd_id_pk: data[0].svd_id_pk,
                        cdp_id_med: data[0].svd_pulso,
                        svd_fcha: new Date(data[0].svd_fecha),
                        svd_talla: parseFloat(data[0].svd_talla),
                        svd_perabdo: data[0].svd_perabdo
                    }
                    $("#n").click()
                    console.log(data);
                } else {
                    alert("Lo Sentimos, ya pasaron más de 24 horas");
                    $scope.cancelar();
                }
                //console.log(data);
            });
        }
        $scope.actualizar = function () {

            $http.post('src/sgh/signosvitales/php/sghInserSignosVitales.php', {
                sgv: $scope.datosAguardar,
                op: 2,
                usu: $scope.usuario
            }).success(function (data) {
                $scope.text = data.sgh_sigvitalesdia_ingreso_pa;
                $scope.mensaje = true;
                //console.log(data);
                setTimeout(function () {
                    $scope.mensaje = false;
                    $scope.$apply();
                    $scope.cancelar();
                    $scope.op = "nuevo";
                    $scope.condi = true;
                }, 1500);
                //alert(data);
            });
        }

        $scope.ver = function (codigo) {
            $scope.condi = false;
            $scope.guar = false;
            $scope.tiposignos = false;
            $scope.actisvt = true;
            $http.post('src/sgh/signosvitales/php/sghListaSignosVitales.php', {
                op: 3,
                codigo: codigo
            }).success(function (data) {
                $scope.datosAguardar = {
                    svd_actfis: data[0].svd_actfis,
                    svd_aseo: data[0].svd_aseo,
                    svd_banio: data[0].svd_banio,
                    svd_camson: data[0].svd_camson,
                    svd_diante: data[0].svd_diante,
                    svd_dieadm: data[0].svd_dieadm,
                    svd_drenaj: parseFloat(data[0].svd_drenaj),
                    svd_freres: parseFloat(data[0].svd_freres),
                    svd_numcom: parseInt(data[0].svd_numcom),
                    svd_numdep: parseInt(data[0].svd_numdep),
                    svd_numicc: parseInt(data[0].svd_numicc),
                    svd_orina: parseFloat(data[0].svd_orina),
                    svd_otros: parseFloat(data[0].svd_otros),
                    svd_parent: parseFloat(data[0].svd_parent),
                    svd_peso: parseFloat(data[0].svd_peso),
                    svd_talla: parseFloat(data[0].svd_talla),
                    svd_predia: parseFloat(data[0].svd_predia),
                    svd_presis: parseFloat(data[0].svd_presis),
                    svd_pulos: parseFloat(data[0].svd_pulso),
                    svd_recvia: data[0].svd_recvia,
                    svd_satoxi: data[0].svd_satoxi,
                    svd_temper: parseFloat(data[0].svd_tempe),
                    svd_toteli: data[0].svd_toteli,
                    svd_toting: data[0].svd_toting,
                    svd_viaora: parseFloat(data[0].svd_viaora),
                    svd_id_pk: data[0].svd_id_pk,
                    cdp_id_med: data[0].svd_pulso,

                }
                console.log(data);
                $("#n").click();

            });

        }
////////////// puevade validacion
    }]);
