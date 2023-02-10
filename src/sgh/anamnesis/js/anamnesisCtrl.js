angular.module("anamnesis", ['ngRoute'])
    .controller('anamnesisCtrl', ['$scope', '$http', '$routeParams', function ($scope, $http, $routeParams) {
        if ($scope.sgh_v_user === undefined) {
            $scope.cerrarsecion();
        }
        $scope.Fecha = new Date();
        $scope.titulo = "OPCIONES DE INGRESO";
///acciones a tomar segun perfil//
        $scope.perfiles = true;
        $scope.consulta_activa = false;
        $scope.sigv_activa = false;
        $scope.ver_fecha = true;
        $scope.signosvitales = function () {
            $scope.sigv_activa = true;
            $scope.perfiles = false;
            $scope.consulta_activa = false;
            $scope.titulo = "Ingreso de Signos Vitales";// titulo del modal
        }
        $scope.consulta = function () {
            $scope.consulta_activa = true;
            $scope.perfiles = false;
            $scope.sigv_activa = false;
            $scope.titulo = "Nuevo Registro";// titulo del modal
            $scope.op = "nuevo";
            $scope.cnuevo();
        }
        $scope.boton_sigv = true;
        $scope.boton_ana = true;
        $scope.activa_perfiles = function () {
            $http.post('src/sgh/anamnesis/php/sghListaAnamnesis.php', {
                op: '8',
                fecha: $scope.cen_fecha,
                idhc: $scope.histoclinica
            }).success(function (data) {
                if (data.error === "error") {
                    $scope.boton_sigv = false;
                    $scope.boton_ana = true;
                } else {
                    $http.post('src/sgh/anamnesis/php/sghListaAnamnesis.php', {
                        op: '9',
                        fecha: $scope.cen_fecha,
                        idhc: $scope.histoclinica
                    }).success(function (data) {
                        if (data.error === "error") {
                            $scope.boton_sigv = true;
                            $scope.boton_ana = true;
                        } else {
                            $scope.boton_sigv = true;
                            $scope.boton_ana = false;
                        }

                    });
                }
                console.log(data);
            });
        }

////////////////// anamnesis////////////////////////
        $scope.accion = function () {
            if ($scope.op === 'nuevo') {
                $scope.guardar();
            }
            if ($scope.op === 'editar') {
                $scope.actualizar();
            }
        }
        $scope.datosAguardar = {
            ana_menarq: 0,
            ana_menopa: 0,
            ana_ciclos: null,
            ana_vidasex: false,
            ana_gesta: null,
            ana_paros: 0,
            ana_aborto: 0,
            ana_cesarea: 0,
            ana_hijosv: 0,
            ana_fum: null,
            ana_fup: null,
            ana_fuc: null,
            ana_biopsia: false,
            ana_mepfam: null,
            ana_terhor: false,
            ana_colcop: false,
            ana_mamogr: false,
            siv_prarta: '0',
            siv_frecar: '0',
            siv_freres: '0',
            siv_tempvo: '0',
            siv_temper: '0',
            siv_peso: '0',
            siv_talla: '0',
            siv_percef: '0',
            ana_fecha: null,
        };
        $scope.items = [
            {abdomen: null},
            {axilas: null},
            {boca: null},
            {cabeza: null},
            {cardio: null},
            {cardiorev: null},
            {columna: null},
            {cuello: null},
            {digestivo: null},
            {digestivorev: null},
            {endocrine: null},
            {endocrino: null},
            {genital: null},
            {genitales: null},
            {hemo: null},
            {hemorev: null},
            {ingle: null},
            {miembroi: null},
            {miembros: null},
            {musculo: null},
            {musculos: null},
            {nariz: null},
            {nervioso: null},
            {neurologico: null},
            {oidos: null},
            {ojos: null},
            {organos: null},
            {organosrev: null},
            {orofaringe: null},
            {piel: null},
            {respiratorio: null},
            {respiratoriorev: null},
            {torax: null},
            {urinario: null},
            {urinariorev: null},
        ];
//datos que estraigo de los campos para guardar
        $scope.mensaje = false;
//variables de paginacion
        $scope.posicion = null;// guarda el total de items de la tabla
        $scope.pagina = 1; // variable de paginas a mostrar
/////////////// 

//cargar datos con json
        $scope.actu = function () {
            $http.post('src/sgh/anamnesis/php/sghListaAnamnesis.php', {
                op: '1',
                idhc: $scope.histoclinica
            }).success(function (data) {
                if (data.error === "error") {
                    console.log(data)
                } else {
                    $scope.anamnesis = data;
                    $scope.posicion = Math.ceil(data.length / $scope.totalpaginas);
                }
            });
            $http.get('src/sgh/cie10/php/sghListarc10.php').success(function (data) {
                $scope.datosc10 = data;
                //	console.log(data);
                $scope.posicion2 = Math.ceil(data.length / $scope.totalpaginas);
            });
        }
        $scope.agregac10 = function (valor) {
            $scope.codigo = valor;
            $scope.bc10 = false;
            $scope.b_buscar = true;
        }
        $scope.bc10 = false;
        $scope.b_buscar = true;

        $scope.buscac10 = function () {
            $scope.bc10 = true;
            $scope.b_buscar = true;
        }
        if ($scope.histoclinica === null) {
            window.location = "#/"
        } else {
            $scope.actu();
        }

        $scope.tabla = true;
        $scope.ana = function (id) {
            $scope.ana_id_pk = id;
            $scope.anadatos = true;
            $scope.tabla = false;

            $http.post('src/sgh/anamnesis/php/sghListaAnamnesis.php', {codigo: id, op: '2'}).success(function (data) {
                $scope.anamnesis = data;
                //console.log(data);
            });
            $http.post('src/sgh/anamnesis/php/sghListaAnamnesis.php', {codigo: id, op: '3'}).success(function (data) {
                $scope.respuestas = data;
                //console.log(data);
            });
            $http.post('src/sgh/anamnesis/php/sghListaAnamnesis.php', {codigo: id, op: '4'}).success(function (data) {
                $scope.singnosvitales = data;
                //console.log(data);
            });
            $scope.cargac10();

        }
        $scope.regreesar = function () {
            $scope.anadatos = false;
            $scope.tabla = true;
            $scope.cancelar();
        }

        $scope.paginas = function (tipo) {
            if (tipo == 0 && $scope.pagina > 1) {
                $scope.pagina -= 1;
            } else if (tipo == 1 && $scope.pagina < $scope.posicion) {
                $scope.pagina += 1;
            }
        }

// GUARDAR DATOS
        $scope.cancelar = function () {
            $scope.ver_fecha = true;
            $("#closemodal").click()
            $scope.titulo = "OPCIONES DE INGRESO";
            ///acciones a tomar//
            $scope.perfiles = true;
            $scope.consulta_activa = false;
            $scope.sigv_activa = false;
            $scope.op1 = "nuevo";
            $scope.op = "nuevo";
            $scope.actu();
            $scope.cie10 = [];
            $scope.codigo = "";
            $scope.c10_id_pk = 0;
            $scope.c10nuevo = true;
            $scope.c10editar = false;
            $scope.datosAguardar = {
                ana_menarq: 0,
                ana_menopa: 0,
                ana_ciclos: null,
                ana_vidasex: false,
                ana_gesta: null,
                ana_paros: 0,
                ana_aborto: 0,
                ana_cesarea: 0,
                ana_hijosv: 0,
                ana_fum: null,
                ana_fup: null,
                ana_fuc: null,
                ana_biopsia: false,
                ana_mepfam: null,
                ana_terhor: false,
                ana_colcop: false,
                ana_mamogr: false,
                ana_fecha: null,
                siv_prarta: 0,
                siv_frecar: 0,
                siv_freres: 0,
                siv_tempvo: 0,
                siv_temper: 0,
                siv_pes: 0,
                siv_talla: 0,
                siv_percef: 0,

            };
            $scope.items = [
                {abdomen: null},
                {axilas: null},
                {boca: null},
                {cabeza: null},
                {cardio: null},
                {cardiorev: null},
                {columna: null},
                {cuello: null},
                {digestivo: null},
                {digestivorev: null},
                {endocrine: null},
                {endocrino: null},
                {genital: null},
                {genitales: null},
                {hemo: null},
                {hemorev: null},
                {ingle: null},
                {miembroi: null},
                {miembros: null},
                {musculo: null},
                {musculos: null},
                {nariz: null},
                {nervioso: null},
                {neurologico: null},
                {oidos: null},
                {ojos: null},
                {organos: null},
                {organosrev: null},
                {orofaringe: null},
                {piel: null},
                {respiratorio: null},
                {respiratoriorev: null},
                {torax: null},
                {urinario: null},
                {urinariorev: null},
            ];
        }
        $scope.actguarda = false;
        $scope.guardar = function () {
            $scope.actguarda = true;
            //guardar epicrisis
            //console.log(angular.toJson({ana:$scope.datosAguardar,items:$scope.items,hcl:$scope.histoclinica, usu:$scope.usuario,op:1}));
            $http.post('src/sgh/anamnesis/php/sghInserAnamnesis.php', {
                ana: $scope.datosAguardar,
                items: $scope.items,
                hcl: $scope.histoclinica,
                usu: $scope.usuario,
                op: 1
            }).success(function (data) {
                $scope.text = data.sgh_anamnesis_ingreso_pa;
                $scope.mensaje = true;
                $scope.dingreso();
                setTimeout(function () {
                    $scope.mensaje = false;
                    $scope.$apply();
                    $scope.cancelar();
                    $scope.actguarda = false;
                }, 1500);
                console.log(data);
            });
        }


        $scope.guardar_signosvitales = function () {
            //guardar epicrisis
            $http.post('src/sgh/anamnesis/php/sghInserAnamnesis.php', {
                ana: $scope.datosAguardar,
                hcl: $scope.histoclinica,
                usu: $scope.usuario,
                op: 3
            }).success(function (data) {
                $scope.text = data.sgh_anamnesis_ingreso_pa;
                $scope.mensaje = true;
                $scope.dingreso();
                setTimeout(function () {
                    $scope.mensaje = false;
                    $scope.$apply();
                    $scope.cancelar();
                }, 1500);
                console.log(data);
            });
        }

// guarda cie10 ingreso
        $scope.dingreso = function () {
            if ($scope.cie10 != null) {
                $http.post('src/sgh/anamnesis/php/sghInserAnamnesis.php', {
                    c10: $scope.cie10,
                    op: 2,
                    usu: $scope.usuario
                }).success(function (data) {
                    console.log(data);
                });
            }
        }

/////////////// datos de c10 
        $scope.cie10 = [];
        $scope.codigo = "";
        $scope.c10_id_pk = 0;
        $scope.c10nuevo = true;
        $scope.c10editar = false;
        $scope.limpia = function () {
            $scope.cie10 = [];
        }
// acciones a tomar 
        $scope.rec_op = "add";
        $scope.c10_accion = function () {
            if ($scope.rec_op === "add") {
                $scope.addc10();
            }
            if ($scope.rec_op === "upd") {
                $scope.updcie10();
            }
        }
        $scope.ec10_accion = function () {
            if ($scope.rec_op === "add") {
                $scope.nuevoc10();
            }
            if ($scope.rec_op === "upd") {
                $scope.updcie10();
            }
        }
//agregar datos en el array 
        $scope.addc10 = function () {
            $http.post('src/sgh/epicrisis/php/sghGetcie10.php', {codigo: $scope.codigo}).success(function (data) {
                if (data != "null") {
                    $scope.cie10.push({
                        c10_id: $scope.c10_id_pk,
                        c10_nombre: data[0].c10_nombre,
                        c10_codigo: data[0].c10_codigo,
                        dia_resp: 'true',
                        c10_id_pk: data[0].c10_id_pk
                    });
                    $scope.c10_id_pk = $scope.c10_id_pk + 1;
                } else {
                    alert("Codigo cie10 no encontrado");
                }
            });
            $scope.codigo = "";
        };
///cargar datos del array 
        $scope.edic10 = function (id) {
            $scope.rec_op = "upd";
            $scope.rec_codi = id;
            $scope.codigo = $scope.cie10[$scope.rec_codi].c10_codigo;
        }

        $scope.eedic10 = function (id, id_dia) {
            $scope.rec_op = "upd";
            $scope.rec_codi = id;
            $scope.dia_id_pk = id_dia;
            $scope.codigo = $scope.cie10[$scope.rec_codi].c10_codigo;
        }

//editar datos  del array 
        $scope.updcie10 = function (id) {
            $http.get('src/sgh/anamnesis/php/sghGetcie10.php?c=' + $scope.codigo).success(function (data) {
                if (data != "null") {
                    $scope.cie10[$scope.rec_codi] = {
                        c10_id_pk: data[0].c10_id_pk,
                        c10_id: $scope.rec_codi,
                        c10_nombre: data[0].c10_nombre,
                        c10_codigo: data[0].c10_codigo,
                        dia_resp: 'true',
                        dia_id_pk: $scope.dia_id_pk
                    };
                } else {
                    alert("Codigo cie10 no encontrado");
                }
            });
            $scope.codigo = "";
            $scope.rec_op = "add";
        }
// ELIMINAR DATOS DE ARRAY DE CIE 10
        $scope.delec10 = function () {
            $scope.cie10 = [];
            $scope.c10_id_pk = 0;
        }
/// cargar datos de nuevo registro ///
        $scope.cnuevo = function () {
            $http.post('src/sgh/anamnesis/php/sghListaAnamnesis.php', {
                op: '6',
                idhc: $scope.histoclinica
            }).success(function (data) {
                console.log(data);
                if (data.error === "error") {
                    console.log(data)
                } else {
                    $http.post('src/sgh/anamnesis/php/sghListaAnamnesis.php', {
                        op: '4',
                        codigo: data[0].ana_id_pk
                    }).success(function (data) {
                        $scope.datosAguardar.siv_id_pk = data[0].siv_id_pk;
                        $scope.datosAguardar.siv_frecar = data[0].siv_frecar;
                        $scope.datosAguardar.siv_freres = data[0].siv_freres;
                        $scope.datosAguardar.siv_percef = data[0].siv_percef;
                        $scope.datosAguardar.siv_peso = data[0].siv_peso;
                        $scope.datosAguardar.siv_prarta = data[0].siv_prarta;
                        $scope.datosAguardar.siv_talla = data[0].siv_talla;
                        $scope.datosAguardar.siv_temper = data[0].siv_temper;
                        $scope.datosAguardar.siv_tempvo = data[0].siv_tempvo;
                        $scope.datosAguardar.ana_id_pk = data[0].ana_id_pk;
                        $scope.datosAguardar.ana_fecha = null;
                    });
                    $scope.datosAguardar.ana_id_pk = data[0].ana_id_pk;

                    $scope.datosAguardar = {
                        ana_aborto: parseInt(data[1].ana_aborto),
                        ana_antfam: data[1].ana_antfam,
                        ana_biopsia: data[1].ana_biopsia,
                        ana_cesarea: parseInt(data[1].ana_cesarea),
                        ana_ciclos: parseInt(data[1].ana_ciclos),
                        ana_colcop: parseInt(data[1].ana_colcop),
                        ana_desant: data[1].ana_desant,
                        ana_fuc: null,
                        ana_fum: null,
                        ana_fup: null,
                        ana_gesta: parseInt(data[1].ana_gesta),
                        ana_hijosv: parseInt(data[1].ana_hijosv),
                        ana_mamogr: data[1].ana_mamogr,
                        ana_menarq: parseInt(data[1].ana_menarq),
                        ana_menopa: parseInt(data[1].ana_menopa),
                        ana_mepfam: parseInt(data[1].ana_mepfam),
                        ana_paros: parseInt(data[1].ana_paros),
                        ana_terhor: data[1].ana_terhor,
                        ana_vidasex: data[1].ana_vidasex,
                        ana_desrev: data[1].ana_desrev,

                    }
                }
            });
        }
/// AGREGA NUEVO DIAGNOSTICO EN EDICION 
        $scope.nuevoc10 = function () {
            $http.get('src/sgh/anamnesis/php/sghGetcie10.php?c=' + $scope.codigo).success(function (data) {
                if (data != "null") {

                    $http.post('src/sgh/anamnesis/php/sghInserAnamnesis.php', {
                        usu: $scope.usuario,
                        ana_id_pk: $scope.ana_id_pk,
                        c10_id_pk: data[0].c10_id_pk,
                        dia_resp: 'true',
                        op: 9
                    }).success(function (data) {
                        //console.log(data);
                        $scope.cargac10();
                    });

                } else {
                    alert("Codigo cie10 no encontrado");
                }
            });
        }

///editar datos // 

        $scope.editar = function (codigo, usuario) {

            if ($scope.edita_paciente === true) {
                $scope.opedi = 10;
                $scope.usu = usuario;

            } else {
                $scope.opedi = 7;
                $scope.usu = $scope.usuario;
            }

            $scope.titulo = "Editar Registro";
            $scope.op = "editar";
            $scope.ana_id_pk = codigo;
            $scope.condi = false;
            $scope.c10nuevo = false;
            $scope.c10editar = true;
            $scope.consulta_activa = true;
            $scope.perfiles = false;
            $scope.sigv_activa = false;
            // LLENA DATOS DE EDICION
            $scope.ver_fecha = false;
            $http.post('src/sgh/anamnesis/php/sghListaAnamnesis.php', {
                op: $scope.opedi,
                codigo: codigo,
                fecha: $scope.cen_fecha
            }).success(function (data) {
                console.log(data);
                if (data != "0") {
                    console.log(data);
                    $scope.datosAguardar = {
                        ana_aborto: parseInt(data[0].ana_aborto),
                        ana_antfam: data[0].ana_antfam,
                        ana_biopsia: data[0].ana_biopsia,
                        ana_cesarea: parseInt(data[0].ana_cesarea),
                        ana_ciclos: parseInt(data[0].ana_ciclos),
                        ana_colcop: data[0].ana_colcop,
                        ana_desant: data[0].ana_desant,
                        ana_desrev: data[0].ana_desrev,
                        ana_enfpra: data[0].ana_enfpra,
                        ana_exafis: data[0].ana_exafis,
                        ana_fecha: new Date(data[0].ana_fecha),
                        ana_fuc: null,
                        ana_fum: null,
                        ana_fup: null,
                        ana_gesta: parseInt(data[0].ana_gesta),
                        ana_hijosv: parseInt(data[0].ana_hijosv),
                        ana_id_pk: data[0].ana_id_pk,
                        ana_mamogr: data[0].ana_mamogr,
                        ana_menarq: parseInt(data[0].ana_menarq),
                        ana_menopa: parseInt(data[0].ana_menopa),
                        ana_mepfam: data[0].ana_mepfam,
                        ana_motivo: data[0].ana_motivo,
                        ana_paros: parseInt(data[0].ana_paros),
                        ana_plantr: data[0].ana_plantr,
                        ana_terhor: data[0].ana_terhor,
                        ana_vidasex: data[0].ana_vidasex,
                        siv_id_pk: data[0].siv_id_pk,
                        siv_frecar: data[0].siv_frecar,
                        siv_freres: data[0].siv_freres,
                        siv_percef: data[0].siv_percef,
                        siv_peso: data[0].siv_peso,
                        siv_prarta: data[0].siv_prarta,
                        siv_talla: data[0].siv_talla,
                        siv_temper: data[0].siv_temper,
                        siv_tempvo: data[0].siv_tempvo,
                    };
                    $http.post('src/sgh/anamnesis/php/sghListaAnamnesis.php', {
                        codigo: codigo,
                        op: '3'
                    }).success(function (data) {
                        console.log(data);
                        $scope.items = [
                            {abdomen: data[0].pat_result, pat_id_pk: data[0].pat_id_pk},
                            {axilas: data[1].pat_result, pat_id_pk: data[1].pat_id_pk},
                            {boca: data[2].pat_result, pat_id_pk: data[2].pat_id_pk},
                            {cabeza: data[3].pat_result, pat_id_pk: data[3].pat_id_pk},
                            {cardio: data[4].pat_result, pat_id_pk: data[4].pat_id_pk},
                            {cardiorev: data[5].pat_result, pat_id_pk: data[5].pat_id_pk},
                            {columna: data[6].pat_result, pat_id_pk: data[6].pat_id_pk},
                            {cuello: data[7].pat_result, pat_id_pk: data[7].pat_id_pk},
                            {digestivo: data[8].pat_result, pat_id_pk: data[8].pat_id_pk},
                            {digestivorev: data[9].pat_result, pat_id_pk: data[9].pat_id_pk},
                            {endocrine: data[10].pat_result, pat_id_pk: data[10].pat_id_pk},
                            {endocrino: data[11].pat_result, pat_id_pk: data[11].pat_id_pk},
                            {genital: data[12].pat_result, pat_id_pk: data[12].pat_id_pk},
                            {genitales: data[13].pat_result, pat_id_pk: data[13].pat_id_pk},
                            {hemo: data[14].pat_result, pat_id_pk: data[14].pat_id_pk},
                            {hemorev: data[15].pat_result, pat_id_pk: data[15].pat_id_pk},
                            {ingle: data[16].pat_result, pat_id_pk: data[16].pat_id_pk},
                            {miembroi: data[17].pat_result, pat_id_pk: data[17].pat_id_pk},
                            {miembros: data[18].pat_result, pat_id_pk: data[18].pat_id_pk},
                            {musculo: data[19].pat_result, pat_id_pk: data[19].pat_id_pk},
                            {musculos: data[20].pat_result, pat_id_pk: data[20].pat_id_pk},
                            {nariz: data[21].pat_result, pat_id_pk: data[21].pat_id_pk},
                            {nervioso: data[22].pat_result, pat_id_pk: data[22].pat_id_pk},
                            {neurologico: data[23].pat_result, pat_id_pk: data[23].pat_id_pk},
                            {oidos: data[24].pat_result, pat_id_pk: data[24].pat_id_pk},
                            {ojos: data[25].pat_result, pat_id_pk: data[25].pat_id_pk},
                            {organos: data[26].pat_result, pat_id_pk: data[26].pat_id_pk},
                            {organosrev: data[27].pat_result, pat_id_pk: data[27].pat_id_pk},
                            {orofaringe: data[28].pat_result, pat_id_pk: data[28].pat_id_pk},
                            {piel: data[29].pat_result, pat_id_pk: data[29].pat_id_pk},
                            {respiratorio: data[30].pat_result, pat_id_pk: data[30].pat_id_pk},
                            {respiratoriorev: data[31].pat_result, pat_id_pk: data[31].pat_id_pk},
                            {torax: data[32].pat_result, pat_id_pk: data[32].pat_id_pk},
                            {urinario: data[33].pat_result, pat_id_pk: data[33].pat_id_pk},
                            {urinariorev: data[34].pat_result, pat_id_pk: data[34].pat_id_pk},
                        ];
                        //console.log(data);
                    });
                    $scope.cargac10();
                    $("#n").click()
                } else {
                    alert("Lo Sentimos, ya pasaron más de 24 horas");
                    $scope.cancelar();
                }
            });
        }
        $scope.actualizar = function () {
//guardar epicrisis
            $http.post('src/sgh/anamnesis/php/sghInserAnamnesis.php', {
                usu: $scope.usuario,
                ana: $scope.datosAguardar,
                items: $scope.items,
                usu: $scope.usu,
                op: 5
            }).success(function (data) {
                $scope.text = data.sgh_anamnesis_ingreso_pa;
                $scope.mensaje = true;

                setTimeout(function () {
                    $scope.editarc10();
                    $scope.mensaje = false;
                    $scope.$apply();
                    $scope.cancelar();
                }, 1500);
                console.log(data);
            });

        }
        $scope.editarc10 = function () {
            if ($scope.cie10 != null) {
                $http.post('src/sgh/anamnesis/php/sghInserAnamnesis.php', {
                    usu: $scope.usuario,
                    c10: $scope.cie10,
                    op: 6
                }).success(function (data) {
                    console.log(data);

                });
            }
        }

        $scope.com_string = function (valor) {
            if (valor == true) {
                return 'true'
            } else {
                return 'false'
            }
        };
        $scope.eeliminarc10 = function (id_c10) {

            $http.post('src/sgh/anamnesis/php/sghInserAnamnesis.php', {
                op: 10,
                Codigo: id_c10,
                usu: $scope.usuario
            }).success(function (data) {
                console.log(data);
                $scope.cargac10();
                alert(data.sgh_anamnesis_elimina_pa);
            });
        };

        $scope.cargac10 = function () {
            $http.post('src/sgh/anamnesis/php/sghListaAnamnesis.php', {
                op: '5',
                codigo: $scope.ana_id_pk
            }).success(function (data) {
                console.log(data);
                if (data.erro === 'error') {
                    $scope.cie10 = []
                } else {
                    $scope.cie10 = [];
                    for (var i = 0; i < data.length; i++) {
                        $scope.c10_id_pk = i;
                        $scope.cie10.push({
                            c10_id: $scope.c10_id_pk,
                            c10_nombre: data[i].c10_nombre,
                            c10_codigo: data[i].c10_codigo,
                            dia_resp: $scope.com_string(data[i].dia_resp),
                            dia_id_pk: data[i].dia_id_pk,
                            c10_id_pk: data[i].c10_id_pk,
                            dad_id_pk: data[i].dad_id_pk
                        });
                    }
                }
            });

        }
    }]);

