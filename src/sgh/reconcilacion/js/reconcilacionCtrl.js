angular.module("reconcilacion", ['ngRoute'])
    .controller('reconcilacionCtrl', ['$scope', '$http', '$routeParams', function ($scope, $http, $routeParams, ModalService) {

        if ($scope.sgh_v_user === undefined) {
            $scope.cerrarsecion();
        }
        $scope.Fecha = new Date();
        $scope.combo = {}; // variable donde se cargar el combo box

        // array de estado

        $scope.datosAguardar = {};//datos que estraigo de los campos para guardar
        $scope.mensaje = false;

//variables de paginacion

        $scope.posicion = null;// guarda el total de items de la tabla
        $scope.pagina = 1; // variable de paginas a mostrar

/// llenar datos de medicamento que estaba recibiendo en ultimo mes

        $scope.medrecibe = [];

        $scope.medicamento = '';
        $scope.dosis = '';
        $scope.frecuencia = '';
        $scope.paraque = '';
        $scope.porcuantotiempo = '';
        $scope.comolotoma = '';
        $scope.quienseloreceto = '';
        $scope.continuar = '';
        $scope.id_pk = 0;

// acciones a tomar 
        $scope.rec_op = "add";

        $scope.rec_accion = function () {
            if ($scope.rec_op === "add") {
                $scope.addmedrecibe();
            }
            if ($scope.rec_op === "upd") {
                $scope.updmedrecibe();
            }
        }
//agregar datos en el array 
        $scope.addmedrecibe = function () {
            $scope.medrecibe.push({
                mum_id_pk: $scope.id_pk,
                mum_medica: $scope.medicamento,
                mum_dosis: $scope.dosis,
                mum_frecue: $scope.frecuencia,
                mum_paraq: $scope.paraque,
                mum_xcuati: $scope.porcuantotiempo,
                mum_comtom: $scope.comolotoma,
                mum_quirec: $scope.quienseloreceto,
                mum_condes: $scope.continuar
            });
            $scope.medicamento = '';
            $scope.dosis = '';
            $scope.frecuencia = '';
            $scope.paraque = '';
            $scope.porcuantotiempo = '';
            $scope.comolotoma = '';
            $scope.quienseloreceto = '';
            $scope.continuar = '';
            $scope.id_pk = $scope.id_pk + 1;
        };
///cargar datos del array 
        $scope.edimedrecibe = function (id) {
            $scope.rec_op = "upd";
            $scope.rec_codi = id;
            $scope.medicamento = $scope.medrecibe[id].mum_medica;
            $scope.dosis = $scope.medrecibe[id].mum_dosis;
            $scope.frecuencia = $scope.medrecibe[id].mum_frecue;
            $scope.paraque = $scope.medrecibe[id].mum_paraq;
            $scope.porcuantotiempo = $scope.medrecibe[id].mum_xcuati;
            $scope.comolotoma = $scope.medrecibe[id].mum_comtom;
            $scope.quienseloreceto = $scope.medrecibe[id].mum_quirec;
            $scope.continuar = $scope.medrecibe[id].mum_condes;
        }
//editar datos  del array 
        $scope.updmedrecibe = function (id) {
            $scope.medrecibe[$scope.rec_codi] = {
                mum_id_pk: $scope.rec_codi,
                mum_medica: $scope.medicamento,
                mum_dosis: $scope.dosis,
                mum_frecue: $scope.frecuencia,
                mum_paraq: $scope.paraque,
                mum_xcuati: $scope.porcuantotiempo,
                mum_comtom: $scope.comolotoma,
                mum_quirec: $scope.quienseloreceto,
                mum_condes: $scope.continuar
            }
            $scope.medicamento = '';
            $scope.dosis = '';
            $scope.frecuencia = '';
            $scope.paraque = '';
            $scope.porcuantotiempo = '';
            $scope.comolotoma = '';
            $scope.quienseloreceto = '';
            $scope.continuar = '';
            $scope.rec_op = "add";
        }

/// llenar datos demedicamentos durante la hospitalización
        $scope.medhospital = [];

        $scope.mph_medicamento = '';
        $scope.mph_dosis = '';
        $scope.mph_frecuencia = '';
        $scope.mph_via = '';
        $scope.mph_discre = '';
        $scope.mph_meqcam = '';
        $scope.mph_id_pk = 0;
        $scope.hos_op = "add";

        $scope.hos_accion = function () {
            if ($scope.hos_op === "add") {
                $scope.addmedhospi();
            }
            if ($scope.hos_op === "upd") {
                $scope.updmedhospi();
            }
        }
//agregar datos en el array 
        $scope.addmedhospi = function () {

            $scope.medhospital.push({
                mph_id_pk: $scope.mph_id_pk,
                mph_medica: $scope.mph_medicamento,
                mph_dosis: $scope.mph_dosis,
                mph_frecue: $scope.mph_frecuencia,
                mph_via: $scope.mph_via,
                mph_discre: $scope.mph_discre,
                mph_meqcam: $scope.mph_meqcam
            });

            $scope.mph_medicamento = '';
            $scope.mph_dosis = '';
            $scope.mph_frecuencia = '';
            $scope.mph_via = '';
            $scope.mph_discre = '';
            $scope.mph_meqcam = '';
            $scope.mph_id_pk = $scope.mph_id_pk + 1;
        };
///cargar datos del array 
        $scope.edimedhospi = function (id) {
            $scope.hos_op = "upd";
            $scope.hos_codi = id;
            $scope.mph_medicamento = $scope.medhospital[id].mph_medica;
            $scope.mph_dosis = $scope.medhospital[id].mph_dosis;
            $scope.mph_frecuencia = $scope.medhospital[id].mph_frecue;
            $scope.mph_via = $scope.medhospital[id].mph_via;
            $scope.mph_discre = $scope.medhospital[id].mph_discre;
            $scope.mph_meqcam = $scope.medhospital[id].mph_meqcam;
        }
//editar datos  del array 
        $scope.updmedhospi = function (id) {
            $scope.medhospital[$scope.hos_codi] = {
                mph_id_pk: $scope.hos_codi,
                mph_medica: $scope.mph_medicamento,
                mph_dosis: $scope.mph_dosis,
                mph_frecue: $scope.mph_frecuencia,
                mph_via: $scope.mph_via,
                mph_discre: $scope.mph_discre,
                mph_meqcam: $scope.mph_meqcam
            }
            $scope.mph_medicamento = '';
            $scope.mph_dosis = '';
            $scope.mph_frecuencia = '';
            $scope.mph_via = '';
            $scope.mph_discre = '';
            $scope.mph_meqcam = '';
            $scope.hos_op = "add";
        }

/// llenar datos demedicamentos prescritos para la alta médica
        $scope.medalta = [];

        $scope.mpa_medica = '';
        $scope.mpa_dosis = '';
        $scope.mpa_frecuencia = '';
        $scope.mpa_via = '';
        $scope.mpa_recome = '';
        $scope.mpa_id_pk = 0;
        $scope.alt_op = "add";

        $scope.alt_accion = function () {
            if ($scope.alt_op === "add") {
                $scope.addmedalta();
            }
            if ($scope.alt_op === "upd") {
                $scope.updmedalta();
            }
        }
//agregar datos en el array 
        $scope.addmedalta = function () {

            $scope.medalta.push({
                mpa_id_pk: $scope.mpa_id_pk,
                mpa_medica: $scope.mpa_medica,
                mpa_dosis: $scope.mpa_dosis,
                mpa_frecue: $scope.mpa_frecuencia,
                mpa_via: $scope.mpa_via,
                mpa_recome: $scope.mpa_recome
            });

            $scope.mpa_medica = '';
            $scope.mpa_dosis = '';
            $scope.mpa_frecuencia = '';
            $scope.mpa_via = '';
            $scope.mpa_recome = '';
            $scope.mpa_id_pk = $scope.mpa_id_pk + 1;
        };
///cargar datos del array 
        $scope.edimedalta = function (id) {
            $scope.alt_op = "upd";
            $scope.alt_codi = id;

            $scope.mpa_medica = $scope.medalta[id].mpa_medica;
            $scope.mpa_dosis = $scope.medalta[id].mpa_dosis;
            $scope.mpa_frecuencia = $scope.medalta[id].mpa_frecue;
            $scope.mpa_via = $scope.medalta[id].mpa_via;
            $scope.mpa_recome = $scope.medalta[id].mpa_recome;

        }
//editar datos  del array 
        $scope.updmedalta = function (id) {
            $scope.medalta[$scope.alt_codi] = {
                mpa_id_pk: $scope.alt_codi,
                mpa_medica: $scope.mpa_medica,
                mpa_dosis: $scope.mpa_dosis,
                mpa_frecue: $scope.mpa_frecuencia,
                mpa_via: $scope.mpa_via,
                mpa_recome: $scope.mpa_recome
            }

            $scope.mpa_medica = '';
            $scope.mpa_dosis = '';
            $scope.mpa_frecuencia = '';
            $scope.mpa_via = '';
            $scope.mpa_recome = '';
            $scope.alt_op = "add";
        }


//cargar datos con json

        $scope.actu = function () {
            $http.post('src/sgh/reconcilacion/php/sghListaReconcilacion.php', {
                op: 1,
                idhc: $scope.histoclinica
            }).success(function (data) {
                if (data.error === "error") {
                    console.log(data);
                } else {
                    $scope.reconcilacion = data;
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


        $scope.paginas = function (tipo) {
            if (tipo == 0 && $scope.pagina > 1) {
                $scope.pagina -= 1;
            } else if (tipo == 1 && $scope.pagina < $scope.posicion) {
                $scope.pagina += 1;
            }

        }
// $scope.men=function(){$scope.mensaje= true;}

        $scope.cancelar = function () {
            $("#closemodal").click();
            $scope.titulo = "Nuevo Registro";// titulo del modal
            $scope.actu();
            $scope.op = "nuevo";
            $scope.datosAguardar = {};
            $scope.medalta = [];
            $scope.medrecibe = [];
            $scope.medhospital = [];
            $scope.medalta = [];
            $scope.rec_editar = false;
            $scope.rec_nuevo = true;
            $scope.ver_vecha = true;

        }
        $scope.actguarda = false;
        $scope.guardar = function () {
            $scope.actguarda = true;
            $http.post('src/sgh/reconcilacion/php/sghInserReconcilacion.php', {
                op: 1,
                rec: $scope.datosAguardar,
                hcl: $scope.histoclinica,
                usu: $scope.usuario,
                ser: $scope.servicio
            }).success(function (data) {
                console.log(data);
                $scope.text = data.sgh_reconciliacion_ingreso_pa;
                $scope.mensaje = true;
                setTimeout(function () {
                    $scope.$apply();
                    $scope.gmedrecibiendo();
                    $scope.gmedhospitalizado();
                    $scope.gmedalta();
                    $scope.actguarda = false;
                }, 1500);

                setTimeout(function () {

                    $scope.$apply();
                    $scope.mensaje = false;
                    $scope.cancelar();
                }, 2500)
            });
        }

        $scope.gmedrecibiendo = function () {
            $http.post('src/sgh/reconcilacion/php/sghInserReconcilacion.php', {
                op: 2,
                mer: $scope.medrecibe,
                usu: $scope.usuario
            }).success(function (data) {
            });
        }
        $scope.gmedhospitalizado = function () {
            $http.post('src/sgh/reconcilacion/php/sghInserReconcilacion.php', {
                op: 3,
                meh: $scope.medhospital,
                usu: $scope.usuario
            }).success(function (data) {
            });
        }
        $scope.gmedalta = function () {
            $http.post('src/sgh/reconcilacion/php/sghInserReconcilacion.php', {
                op: 4,
                mea: $scope.medalta,
                usu: $scope.usuario
            }).success(function (data) {
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
        $scope.ver_vecha = true;
        $scope.edita = function (codigo) {
            $scope.ver_vecha = false;
            $scope.titulo = "Editar Registro";
            $scope.op = "editar";
            $scope.condi = false;
            $scope.rec_editar = true;
            $scope.rec_nuevo = false;
            $scope.frm_id_pk = codigo;

            console.log({
                op: 2,
                codigo: codigo,
                usu: $scope.usuario,
                fecha: $scope.cen_fecha
            });

            // LLENA DATOS DE EDICION
            $http.post('src/sgh/reconcilacion/php/sghListaReconcilacion.php', {
                op: 2,
                codigo: codigo,
                usu: $scope.usuario,
                fecha: $scope.cen_fecha
            }).success(function (data) {
                if (data != "0") {
                    $http.post('src/sgh/reconcilacion/php/sghListaReconcilacion.php', {
                        op: 3,
                        codigo: codigo
                    }).success(function (data1) {
                        $scope.medrecibe = data1;
                    });
                    $http.post('src/sgh/reconcilacion/php/sghListaReconcilacion.php', {
                        op: 4,
                        codigo: codigo
                    }).success(function (data1) {
                        $scope.medhospital = data1;
                    });
                    $http.post('src/sgh/reconcilacion/php/sghListaReconcilacion.php', {
                        op: 5,
                        codigo: codigo
                    }).success(function (data1) {
                        $scope.medalta = data1;
                    });

                    $scope.datosAguardar = {
                        frm_cual: data[0].frm_cual,
                        frm_dondia: data[0].frm_dondia,
                        frm_emblac: data[0].frm_emblac,
                        frm_enfcro: data[0].frm_enfcro,
                        frm_faencr: data[0].frm_faencr,
                        frm_fecha: data[0].frm_fecha,
                        frm_fitote: data[0].frm_fitote,
                        frm_fueinf: data[0].frm_fueinf,
                        frm_habito: data[0].frm_habito,
                        frm_id_pk: data[0].frm_id_pk,
                        frm_intqui: data[0].frm_intqui,
                        frm_medent: data[0].frm_medent,
                        frm_medrev: data[0].frm_medrev,
                        frm_motate: data[0].frm_motate,
                        frm_obmeho: data[0].frm_obmeho,
                        frm_obmeul: data[0].frm_obmeul,
                        frm_peso: parseInt(data[0].frm_peso),
                        frm_quifar: data[0].frm_quifar,
                        frm_suspel: data[0].frm_suspel,
                        frm_viaje: data[0].frm_viaje,
                        frm_fecha: new Date(data[0].frm_fecha),

                    }
                    $("#n").click()
                } else {
                    alert("Lo Sentimos, ya pasaron más de 24 horas");
                    $scope.cancelar();
                }
            });
        }
        $scope.actualizar = function () {
            $scope.actguarda = true;
            $http.post('src/sgh/reconcilacion/php/sghInserReconcilacion.php', {
                op: 5,
                rec: $scope.datosAguardar,
                usu: $scope.usuario
            }).success(function (data) {
                $scope.text = data.sgh_reconciliacion_ingreso_pa;
                $scope.mensaje = true;
                setTimeout(function () {
                    $scope.mensaje = false;
                    $scope.$apply();
                    $scope.actguarda = false;
                    $scope.cancelar();
                }, 1500);
                console.log(data);
            });
        }

/////////////////////////////////////////////////////////////////
        $scope.rec_editar = false;
        $scope.rec_nuevo = true;

/// llenar datos de medicamento que estaba recibiendo en ultimo mes

// acciones a tomar 
        $scope.ed_rec_op = "add";

        $scope.edita_rec_accion = function () {
            if ($scope.ed_rec_op === "add") {
                $scope.edgmedrecibiendo();
            }
            if ($scope.ed_rec_op === "upd") {
                $scope.edupdmedrecibe();
            }
        }
///cargar datos del array 
        $scope.ededimedrecibe = function (id) {
            $scope.ed_rec_op = "upd";
            $http.post('src/sgh/reconcilacion/php/sghListaReconcilacion.php', {
                op: 7,
                codigo: id
            }).success(function (data1) {

                $scope.rec_codi = data1[0].mum_id_pk;
                $scope.medicamento = data1[0].mum_medica;
                $scope.dosis = data1[0].mum_dosis;
                $scope.frecuencia = data1[0].mum_frecue;
                $scope.paraque = data1[0].mum_paraq;
                $scope.porcuantotiempo = data1[0].mum_xcuati;
                $scope.comolotoma = data1[0].mum_comtom;
                $scope.quienseloreceto = data1[0].mum_quirec;
                $scope.continuar = data1[0].mum_condes;

            });
        }
// guardar nuevo edicion de recibidos anteriormente
        $scope.edgmedrecibiendo = function () {
            $http.post('src/sgh/reconcilacion/php/sghInserReconcilacion.php', {
                usu: $scope.usuario,
                op: 9,
                frm_id_pk: $scope.frm_id_pk,
                mum_id_pk: $scope.rec_codi,
                mum_medica: $scope.medicamento,
                mum_dosis: $scope.dosis,
                mum_frecue: $scope.frecuencia,
                mum_paraq: $scope.paraque,
                mum_xcuati: $scope.porcuantotiempo,
                mum_comtom: $scope.comolotoma,
                mum_quirec: $scope.quienseloreceto,
                mum_condes: $scope.continuar
            }).success(function (data) {
                $http.post('src/sgh/reconcilacion/php/sghListaReconcilacion.php', {
                    op: 3,
                    codigo: $scope.datosAguardar.frm_id_pk
                }).success(function (data1) {
                    $scope.medrecibe = data1;
                });
                $scope.rec_codi = '';
                $scope.medicamento = '';
                $scope.dosis = '';
                $scope.frecuencia = '';
                $scope.paraque = '';
                $scope.porcuantotiempo = '';
                $scope.comolotoma = '';
                $scope.quienseloreceto = '';
                $scope.continuar = '';
            });
        }
//editar datos  del array 
        $scope.edupdmedrecibe = function () {
            if ($scope.rec_codi === '') {
            } else {
                $http.post('src/sgh/reconcilacion/php/sghInserReconcilacion.php', {
                    usu: $scope.usuario,
                    op: 6,
                    mum_id_pk: $scope.rec_codi,
                    mum_medica: $scope.medicamento,
                    mum_dosis: $scope.dosis,
                    mum_frecue: $scope.frecuencia,
                    mum_paraq: $scope.paraque,
                    mum_xcuati: $scope.porcuantotiempo,
                    mum_comtom: $scope.comolotoma,
                    mum_quirec: $scope.quienseloreceto,
                    mum_condes: $scope.continuar
                }).success(function (data) {
                    $http.post('src/sgh/reconcilacion/php/sghListaReconcilacion.php', {
                        op: 3,
                        codigo: $scope.datosAguardar.frm_id_pk
                    }).success(function (data1) {
                        $scope.medrecibe = data1;
                    });
                    $scope.rec_codi = '';
                    $scope.medicamento = '';
                    $scope.dosis = '';
                    $scope.frecuencia = '';
                    $scope.paraque = '';
                    $scope.porcuantotiempo = '';
                    $scope.comolotoma = '';
                    $scope.quienseloreceto = '';
                    $scope.continuar = '';
                    $scope.ed_rec_op = "add";
                });
            }
        }

/// llenar datos demedicamentos durante la hospitalización
        $scope.edi_hos_op = "add";
        $scope.edita_hos_accion = function () {
            if ($scope.edi_hos_op === "add") {
                $scope.edaddmedhospi();
            }
            if ($scope.edi_hos_op === "upd") {
                $scope.edupdmedhospi();
            }
        }
//agregar datos en el array 
        $scope.edaddmedhospi = function () {
            $http.post('src/sgh/reconcilacion/php/sghInserReconcilacion.php', {
                usu: $scope.usuario,
                op: 10,
                frm_id_pk: $scope.frm_id_pk,
                mph_id_pk: $scope.hos_codi,
                mph_medica: $scope.mph_medicamento,
                mph_dosis: $scope.mph_dosis,
                mph_frecue: $scope.mph_frecuencia,
                mph_via: $scope.mph_via,
                mph_discre: $scope.mph_discre,
                mph_meqcam: $scope.mph_meqcam
            }).success(function (data) {
                $http.post('src/sgh/reconcilacion/php/sghListaReconcilacion.php', {
                    op: 4,
                    codigo: $scope.datosAguardar.frm_id_pk
                }).success(function (data1) {
                    $scope.medhospital = data1;
                });
                $scope.hos_codi = '';
                $scope.mph_medicamento = '';
                $scope.mph_dosis = '';
                $scope.mph_frecuencia = '';
                $scope.mph_via = '';
                $scope.mph_discre = '';
                $scope.mph_meqcam = '';
            });
        };
///cargar datos del array  
        $scope.ededimedhospi = function (id) {
            $scope.edi_hos_op = "upd";
            $http.post('src/sgh/reconcilacion/php/sghListaReconcilacion.php', {
                op: 8,
                codigo: id
            }).success(function (data1) {

                $scope.hos_codi = data1[0].mph_id_pk;
                $scope.mph_medicamento = data1[0].mph_medica;
                $scope.mph_dosis = data1[0].mph_dosis;
                $scope.mph_frecuencia = data1[0].mph_frecue;
                $scope.mph_via = data1[0].mph_via;
                $scope.mph_discre = data1[0].mph_discre;
                $scope.mph_meqcam = data1[0].mph_meqcam;

            });

        }
//editar datos  del array 
        $scope.edupdmedhospi = function () {
            if ($scope.hos_codi === '') {
            } else {
                $http.post('src/sgh/reconcilacion/php/sghInserReconcilacion.php', {
                    usu: $scope.usuario,
                    op: 7,
                    mph_id_pk: $scope.hos_codi,
                    mph_medica: $scope.mph_medicamento,
                    mph_dosis: $scope.mph_dosis,
                    mph_frecue: $scope.mph_frecuencia,
                    mph_via: $scope.mph_via,
                    mph_discre: $scope.mph_discre,
                    mph_meqcam: $scope.mph_meqcam
                }).success(function (data) {
                    $http.post('src/sgh/reconcilacion/php/sghListaReconcilacion.php', {
                        op: 4,
                        codigo: $scope.datosAguardar.frm_id_pk
                    }).success(function (data1) {
                        $scope.medhospital = data1;
                    });
                    $scope.hos_codi = '';
                    $scope.mph_medicamento = '';
                    $scope.mph_dosis = '';
                    $scope.mph_frecuencia = '';
                    $scope.mph_via = '';
                    $scope.mph_discre = '';
                    $scope.mph_meqcam = '';
                    $scope.edi_hos_op = "add";
                });
            }

        }
        $scope.edi_alt_op = "add"
/// llenar datos demedicamentos prescritos para la alta médica
        $scope.edita_alt_accion = function () {

            if ($scope.edi_alt_op === "add") {
                $scope.edaddmedalta();
            }
            if ($scope.edi_alt_op === "upd") {
                $scope.edupdmedalta();
            }
        }
//agregar datos en el array 
        $scope.edaddmedalta = function () {
            $http.post('src/sgh/reconcilacion/php/sghInserReconcilacion.php', {
                usu: $scope.usuario,
                op: 11,
                frm_id_pk: $scope.frm_id_pk,
                mpa_id_pk: $scope.alt_codi,
                mpa_medica: $scope.mpa_medica,
                mpa_dosis: $scope.mpa_dosis,
                mpa_frecue: $scope.mpa_frecuencia,
                mpa_via: $scope.mpa_via,
                mpa_recome: $scope.mpa_recome
            }).success(function (data) {
                $http.post('src/sgh/reconcilacion/php/sghListaReconcilacion.php', {
                    op: 5,
                    codigo: $scope.datosAguardar.frm_id_pk
                }).success(function (data1) {
                    $scope.medalta = data1;
                });
                $scope.alt_codi = '';
                $scope.mpa_medica = '';
                $scope.mpa_dosis = '';
                $scope.mpa_frecuencia = '';
                $scope.mpa_via = '';
                $scope.mpa_recome = '';
            });
        };
///cargar datos del array 
        $scope.ededimedalta = function (id) {
            $scope.edi_alt_op = "upd";
            $http.post('src/sgh/reconcilacion/php/sghListaReconcilacion.php', {
                op: 9,
                codigo: id
            }).success(function (data1) {
                $scope.alt_codi = data1[0].mpa_id_pk;
                $scope.mpa_medica = data1[0].mpa_medica;
                $scope.mpa_dosis = data1[0].mpa_dosis;
                $scope.mpa_frecuencia = data1[0].mpa_frecue;
                $scope.mpa_via = data1[0].mpa_via;
                $scope.mpa_recome = data1[0].mpa_recome;
            });
        }
//editar datos  del array 
        $scope.edupdmedalta = function () {
            if ($scope.alt_codi === '') {
            } else {
                $http.post('src/sgh/reconcilacion/php/sghInserReconcilacion.php', {
                    usu: $scope.usuario,
                    op: 8,
                    mpa_id_pk: $scope.alt_codi,
                    mpa_medica: $scope.mpa_medica,
                    mpa_dosis: $scope.mpa_dosis,
                    mpa_frecue: $scope.mpa_frecuencia,
                    mpa_via: $scope.mpa_via,
                    mpa_recome: $scope.mpa_recome
                }).success(function (data) {
                    $http.post('src/sgh/reconcilacion/php/sghListaReconcilacion.php', {
                        op: 5,
                        codigo: $scope.datosAguardar.frm_id_pk
                    }).success(function (data1) {
                        $scope.medalta = data1;
                    });
                    $scope.alt_codi = '';
                    $scope.mpa_medica = '';
                    $scope.mpa_dosis = '';
                    $scope.mpa_frecuencia = '';
                    $scope.mpa_via = '';
                    $scope.mpa_recome = '';
                    $scope.edi_alt_op = "add"
                });
            }
        }


///// Visualizar datos de recociliacion //////
        $scope.tabla = true;
        $scope.regreesar = function () {
            $scope.datos = false;
            $scope.tabla = true;
            $scope.cancelar();
        }

        $scope.verdatos = function (codigo) {
            $scope.datos = true;
            $scope.tabla = false;
            $http.post('src/sgh/reconcilacion/php/sghListaReconcilacion.php', {
                op: 6,
                codigo: codigo
            }).success(function (data) {
                $scope.datosAguardar = {
                    frm_cual: data[0].frm_cual,
                    frm_dondia: data[0].frm_dondia,
                    frm_emblac: data[0].frm_emblac,
                    frm_enfcro: data[0].frm_enfcro,
                    frm_faencr: data[0].frm_faencr,
                    frm_fecha: data[0].frm_fecha,
                    frm_fitote: data[0].frm_fitote,
                    frm_fueinf: data[0].frm_fueinf,
                    frm_habito: data[0].frm_habito,
                    frm_id_pk: data[0].frm_id_pk,
                    frm_intqui: data[0].frm_intqui,
                    frm_medent: data[0].frm_medent,
                    frm_medrev: data[0].frm_medrev,
                    frm_motate: data[0].frm_motate,
                    frm_obmeho: data[0].frm_obmeho,
                    frm_obmeul: data[0].frm_obmeul,
                    frm_peso: parseInt(data[0].frm_peso),
                    frm_quifar: data[0].frm_quifar,
                    frm_suspel: data[0].frm_suspel,
                    frm_viaje: data[0].frm_viaje,
                }
            });

            $http.post('src/sgh/reconcilacion/php/sghListaReconcilacion.php', {
                op: 3,
                codigo: codigo
            }).success(function (data) {
                $scope.medrecibe = data;
            });
            $http.post('src/sgh/reconcilacion/php/sghListaReconcilacion.php', {
                op: 4,
                codigo: codigo
            }).success(function (data1) {
                $scope.medhospital = data1;
            });
            $http.post('src/sgh/reconcilacion/php/sghListaReconcilacion.php', {
                op: 5,
                codigo: codigo
            }).success(function (data1) {
                $scope.medalta = data1;
            });
        }
    }]);

