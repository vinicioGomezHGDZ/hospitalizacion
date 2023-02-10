var app = angular.module('app', ['ngCookies', 'ui.router', 'oc.lazyLoad', 'ngProgress', 'angular.filter', 'ui.select', 'ngSanitize']);
app.controller('mainCrtl', function mainCrtl($scope, $http, $window, $cookies, ngProgressFactory) {

    $scope.progressbar = ngProgressFactory.createInstance();
    $scope.progressbar.setParent(document.getElementById('contained'));
    $scope.progressbar.setAbsolute();
    $scope.progressbar.setColor('firebrick');
    $scope.progressbar.setHeight('2px');

    $('#btn-login-light').click();

    $scope.variables = function () {
        //console.log('variables');
        $scope.lis_pasien = $scope.bool(localStorage.getItem('lis_pasien'));
        $scope.opciones = $scope.boolmenu(localStorage.getItem('opciones'));
        $scope.menuheader = $scope.bool(localStorage.getItem('menuheader'));
        //console.log('menuheader',$scope.menuheader);
        $scope.menu_cargaras = JSON.parse(localStorage.getItem('menu_cargaras'));
        //console.log('menu_cargaras',$scope.menu_cargaras);
        $scope.menu_sub = JSON.parse(localStorage.getItem('menu_sub'));
        $scope.admi = $scope.bool(localStorage.getItem('admi'));
        $scope.op_cargar = localStorage.getItem('op_cargar');
        $scope.esp_id_pk = localStorage.getItem('esp_id_pk');
        //console.log('esp_id_pk', $scope.esp_id_pk);
        $scope.mod_id_pk = localStorage.getItem('mod_id_pk');
        //console.log('mod_id_pk', $scope.mod_id_pk);
        $scope.usuario = localStorage.getItem('usuario');
        $scope.entidad = localStorage.getItem('entidad');
        $scope.menu = $scope.bool(localStorage.getItem('menu'));
        //console.log('menu',$scope.menu);
        $scope.servicio = localStorage.getItem('servicio');
        $scope.id_cen_pk = localStorage.getItem('id_cen_pk');
        $scope.cen_fecha = localStorage.getItem('cen_fecha');
        $scope.histoclinica = localStorage.getItem('histoclinica');
        $scope.cama = localStorage.getItem('cama');
        $scope.sgh_v_user = JSON.parse(localStorage.getItem('sgh_user'));
        $scope.usu_perfil = localStorage.getItem('usu_perfil');
        $scope.nombre_perfil = localStorage.getItem('nombre_perfil');

        $scope.all = $scope.bool(localStorage.getItem('all'));
        $scope.all2 = $scope.bool(localStorage.getItem('all2'));

        $scope.opcion_servicios = $scope.boolmenu(localStorage.getItem('opcion_servicios'));
        $scope.opcion_mensajeserivio = $scope.bool(localStorage.getItem('opcion_mensajeserivio'));
        $scope.edita_paciente = $scope.bool(localStorage.getItem('edita_paciente'));


    }

    $scope.bool = function (valor) {
        if (valor === 'true') {
            var bool = true;
        } else {
            var bool = false;
        }
        return bool;
    }

    $scope.boolmenu = function (valor) {
        if (valor === 'false') {
            var boolm = false;
        } else {
            var boolm = true;
        }

        return boolm;
    }

    //$scope.variables();


    $scope.cargarServicios = function () {
        //// opciones de menu
        $http.post('src/sgh/listapacientes/php/listarServicios.php').success(function (data) {
            if (data.error === 'error') {
            } else {
                $scope.menu_servicios = data;
            }
        });
        // $http.post('php/sghCargaUsuario.php?', {op: 3}).success(function (data) {
        //     if (data.error === 'error') {
        //     }
        //     else {
        //         $scope.menu_servicios = data;
        //     }
        // });
    }

    $scope.seleccionarServicio = function (op, ser) {
        console.log('Seleccionar servicios');
        //localStorage.setItem('mod_id_pk', op);
        localStorage.setItem('esp_id_pk', op);
        localStorage.setItem('op_cargar', ser);
        localStorage.setItem('lis_pasien', true);
        localStorage.setItem('opciones', false);
        console.log('opciones', localStorage.getItem('opciones'));
        localStorage.setItem('menuheader', true);


        $scope.variables();
        $scope.cerrar(1);
        //cargar menú por servicio
        console.log('esp_id_pk',$scope.esp_id_pk);
        $http.post('php/sghCargaUsuario.php?', {op: 4, codigo: $scope.esp_id_pk}).success(function (data) {
            //console.log('servicios',data);
            if (data.error === 'error') {
            } else {
                $scope.menu_cargaras = data;
                localStorage.setItem('menu_cargaras',JSON.stringify(data));
                $http.post('php/sghCargaUsuario.php?', {op: 5, codigo: $scope.esp_id_pk}).success(function (data) {

                    if (data.error === 'error') {
                    } else {
                        $scope.menu_sub = data;
                        localStorage.setItem('menu_sub',JSON.stringify(data));
                    }
                });
            }
        });
    };

    if ($scope.mod_id_pk !== undefined) {
        console.log('cargar servicios si no tiene menú');
        localStorage.setItem('menuheader', true);


        $http.post('php/sghCargaUsuario.php?', {op: 4, codigo: $scope.mod_id_pk}).success(function (data) {
            if (data.error === 'error') {

            } else {
                $scope.menu_cargaras = data;
                $http.post('php/sghCargaUsuario.php?', {op: 5, codigo: $scope.mod_id_pk}).success(function (data) {
                    if (data.error === 'error') {

                    } else {
                        $scope.menu_sub = data;
                    }
                });
            }
        });
    }

    $scope.mostrarServicios = function () {
        console.log('cargar servicios');
        localStorage.setItem('opciones', true);

        localStorage.setItem('lis_pasien', false);
        //localStorage.setItem('menu', false);
        $scope.variables();
    }

/// Variables general 
    $scope.item = -8; //cantidad de items a cargar
    $scope.totalpaginas = 8;
    $scope.goCats = false;

//  opciones de login 
    $scope.mensaje = false;
    $scope.cerrarsesion = function () {
        $cookies.remove('histoclinica');
        $cookies.remove('cama');
        $cookies.remove('sgh_user', {path: '/'});
        localStorage.removeItem('mod_id_pk');
        localStorage.removeItem('usuario');
        localStorage.removeItem('servicio');
        localStorage.removeItem('op_cargar');
        localStorage.removeItem('id_cen_pk');
        localStorage.removeItem('menu', false);
        localStorage.setItem('lis_pasien', false);
        localStorage.setItem('opciones', true);

        localStorage.removeItem('entidad');
        localStorage.removeItem('usu_perfil');
        localStorage.removeItem('opcion_servicios');
        localStorage.removeItem('opcion_mensajeserivio');

        localStorage.setItem('edita_paciente', false);

        location.reload();
        window.location = '/sgh/#!/signin';
    };

    $scope.caseState = function (state) {
        var result = {};
        var type = null;
        var head = null;
        switch (state) {
            case 1:
                type = 'success';
                head = 'Correcto!';
                break;
            case 2:
                type = 'info';
                head = 'Información!';
                break;
            case 3:
                type = 'warning';
                head = 'Advertencia!';
                break;
            default:
                type = 'error';
                head = 'Error!';
        }
        result.type = type;
        result.head = head;
        return result;
    };

    $scope.changePassword = function () {
        swal({
                title: 'Cambiar contraseña',
                text: 'Ingrese su nueva contraseña',
                type: 'input',
                inputType: 'password',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Confirmar',
                closeOnConfirm: false,
                inputPlaceholder: 'Contraseña'
            },
            function (inputValue) {
                if (inputValue === false) return false;

                if (inputValue === '') {
                    swal.showInputError('Es obligatorio el campo!');
                    return false
                }
                $scope.setPassword(inputValue);
                // swal('Nice!', 'You wrote: ' + inputValue, 'success');
            });
    };

    $scope.setPassword = function (inputValue) {
        $http.post('../sgh_ws/public/sgadm/usuario/saveByID', {
            'usu_id_pk': $scope.sgh_v_user.usu_id_pk,
            'usu_login': $scope.sgh_v_user.usu_login,
            'usu_password': inputValue,
            'fecha_modificacion':
                {
                    'usu_id_fk': $scope.sgh_v_user.usu_id_pk,
                    'usu_login': $scope.sgh_v_user.usu_login

                }
        }).then(function (response) {
            var res = response.data;
            var state = $scope.caseState(res.Estado);
            if (!res.Mensaje) {
                swal('Error', res, 'error');
            } else {
                swal(state.head, res.Mensaje, state.type);
            }
        }, function (error, response) {
            var res = response.data;
            swal('Error', res, 'error');
        })
    };

    // INCIO SESION
    //$scope.menu = null;
    $scope.sgh_v_user = JSON.parse(localStorage.getItem('sgh_user'));
    console.log('sgh_v_user', $scope.sgh_v_user);

    // $scope.leecuki = function () {
    //     setTimeout(function () {
    //         $scope.sgh_v_user = JSON.parse(localStorage.getItem('sgh_user'));;
    //         if ($scope.sgh_v_user === undefined) {
    //             $scope.cerrarsesion();
    //         }
    //         $scope.leecuki();
    //     }, 100500);
    // }
    // $scope.leecuki();


   /* if ($scope.menu === undefined) {
        console.log('menu undefined');
        localStorage.setItem('opciones', true);

        localStorage.setItem('lis_pasien', false);
        localStorage.setItem('menu', false);
    }*/
    if ($scope.sgh_v_user === undefined) {
        $scope.cerrarsesion();
    } else {

        localStorage.setItem('usuario', $scope.sgh_v_user.usu_id_pk);
        localStorage.setItem('entidad', $scope.sgh_v_user.eta_id_pk);
        localStorage.setItem('mod_id_pk', $scope.sgh_v_user.mod_id_fk);
        localStorage.setItem('nombre_perfil', $scope.sgh_v_user.usuario_apellido_nombre);

        $scope.mostrarServicios();
        $scope.variables();

        /* $http.post('php/sghCargaUsuario.php', {
             op: 2,
             usu: $scope.usuario,
             mod: $scope.sgh_v_user.mod_id_fk
         }).success(function (data) {
             console.log('data',data);
             if (data.error !== 'error') {
                 localStorage.setItem('usu_perfil', data[0].pfi_descripcion);
                 console.log('opcion 2');
                 if (data[0].pfi_descripcion === 'TRATANTE') {
                     $cookies.put('edita_boton', false);
                     $scope.edita_boton = $scope.boolmenu(localStorage.getItem('edita_boton'));
                     $scope.variables();
                 } else {
                     $cookies.put('edita_boton', true);
                     $scope.edita_boton = $scope.boolmenu(localStorage.getItem('edita_boton'));

                 }
                 $scope.usu_perfil = localStorage.getItem('usu_perfil');


                 if ($scope.usu_perfil === 'LABORATORIO') {
                  /!*   $cookies.put('opciones', false);
                     $cookies.put('lis_pasien', false);
                     $cookies.put('menu', false);

                     localStorage.setItem('opcion_servicios', false);
                     localStorage.setItem('opcion_mensajeserivio', true);


                     $('#sidebar-collapse').click();
                     window.location = '#/resultados';*!/
                 }
                 else {
                     console.log('pfi_id_fk',$scope.sgh_v_user.pfi_id_fk);
                     $http.post('php/sghCargaUsuario.php?', {
                         op: 6,
                         codigo: $scope.sgh_v_user.pfi_id_fk
                     }).success(function (data) {

                         console.log(data);
                         if (data.error === 'error') {
                         }
                         else {
                             console.log('opcion 6');
                             localStorage.setItem('menuheader', false);
                             localStorage.setItem('opciones', false);

                             localStorage.setItem('lis_pasien', false);
                             localStorage.setItem('histoclinica', null);
                             localStorage.setItem('menu', true);

                             localStorage.setItem('opcion_servicios', false);
                             localStorage.setItem('opcion_mensajeserivio', true);
                             $scope.variables();
                             $scope.menu_cargaras = data;
                             $http.post('php/sghCargaUsuario.php?', {
                                 op: 7,
                                 codigo: $scope.sgh_v_user.pfi_id_fk
                             }).success(function (data) {

                                 if (data.error === 'error') {

                                 }
                                 else {
                                     console.log('opcion 7')
                                     $scope.menu_sub = data;
                                 }
                             });
                         }

                     }).error(function (data) {
                         console.error(data);
                     });
                 }
             }
         });*/
    }

/// cerrar datos de historia clinica de paciente
    $scope.cerrar = function (op) {
        if (op === 1) {
            localStorage.removeItem('servicio');
            localStorage.removeItem('histoclinica');
            localStorage.removeItem('cama');
            localStorage.removeItem('menu');
            localStorage.removeItem('id_cen_pk');
            localStorage.removeItem('cen_fecha');
            localStorage.setItem('menu', false);
            localStorage.setItem('lis_pasien', true);
            localStorage.setItem('edita_paciente', false);
            $scope.variables();
            //$scope.car_paciente();
            $scope.car_paciente_grupo();
            window.location = '#/';
        }
    }

/// accion a cargar menus
    $scope.verhistoria = function (idh) {
        localStorage.setItem('menu', true);
        localStorage.setItem('lis_pasien', false);
        localStorage.setItem('edita_paciente', true);
        $scope.edita_pas = false;
        localStorage.setItem('admi', true);
        //$cookies.put('histoclinica', idh, {'path': '/'});
        localStorage.setItem('histoclinica', idh);
        $scope.variables();
        /// cargo encabezado
        $scope.carga_encabezado();
    }

    $scope.accion = function (fecha, idh, idc, ids, id_cen) {
        localStorage.setItem('cen_fecha', fecha);
        localStorage.setItem('id_cen_pk', id_cen);
        localStorage.setItem('servicio', ids);
        localStorage.setItem('menu', true);
        localStorage.setItem('lis_pasien', false);
        localStorage.setItem('admi', false);
        localStorage.setItem('histoclinica', idh);
        localStorage.setItem('cama', idc);

        //$cookies.put('histoclinica', idh, {'path': '/'});
        //$cookies.put('cama', idc, {'path': '/'});
        $scope.variables();
        /// cargo encabezado
        $scope.carga_encabezado();
    }
/// color paciente
    $scope.estado_colores = function (op) {
        //console.log(op);
        if (op === true) {
            return $scope.myStyle = {'background-color': '#CEF6CE', color: '#190707'}
        } else {
            return $scope.myStyle = {'background-color': '#F6CECE', color: '#190707'}
        }
    }
/// cargar datos de pacientes en hospitalización
    $scope.car_paciente = function () {
        $scope.pacientes = [];
        $http.post('src/sgh/listapacientes/php/sghlistarPacientes.php', {
            op: 1,
            opcarga: $scope.op_cargar
        }).success(function (data) {
            console.log(data);
            if (data.error === 'error') {
                $scope.pacientes = [];
            } else {

                $scope.pac = data;
                var a = 0;
                var i = 0;
                var c = '';
                var cc = '';
                do {
                    $http.post('src/sgh/listapacientes/php/sghlistarPacientes.php', {
                        op: 2,
                        hcl: data[i].hce_id_pk,
                        fecha: data[i].cen_fecha
                    }).success(function (data2) {

                        if (data2.error === 'error') {
                            cc = 0;
                            c = true;
                        } else {
                            cc = data2.length;
                            c = false;
                        }
                        $scope.pacientes.push({
                            Num: cc,
                            color: c,
                            cen_fecha: $scope.pac[a].cen_fecha,
                            piso: $scope.pac[a].piso,
                            per_numeroidentificacion: $scope.pac[a].per_numeroidentificacion,
                            paciente: $scope.pac[a].paciente,
                            hce_id_pk: $scope.pac[a].hce_id_pk,
                            cam_id_pk: $scope.pac[a].cam_id_pk,
                            tca_id_pk: $scope.pac[a].tca_id_pk,
                            cen_id_pk: $scope.pac[a].cen_id_pk,
                            cam_codigo: $scope.pac[a].cam_codigo
                        });
                        a++;
                    });
                    i++;
                }
                while (i < data.length);

            }
        });
    };

    //cargar listado por grupo
    $scope.car_paciente_grupo = function () {
//        console.log($scope.op_cargar);
        $scope.progressbar.start();
        $http.post('src/sgh/listapacientes/php/sghlistarPacientes.php', {
            op: 1,
            opcarga: $scope.op_cargar
        }).success(function (data) {
            //console.log(angular.toJson(data));
            $scope.pacientes_grupo = data;
            $scope.progressbar.complete();
            if (data.hasOwnProperty('error')) {
                $scope.pacientes_grupo = [];
            }
        }).error(function (data) {
            $scope.progressbar.reset();
            $scope.pacientes_grupo = [];
        });
    };

    $scope.carga_encabezado = function () {
/// datos de paciente y encabezados de formularios
        if ($scope.histoclinica !== null) {

            $http.post('src/sgh/encabezado/php/SghgetEncabezado.php?', {
                codigo: $scope.histoclinica,
                op: 1
            }).success(function (data) {
                // console.log(data);
                if (data.error === 'error') {
                } else {
                    $scope.encabezado = data;

                    if (data[0].per_sexo === 'F') {
                        $cookies.put('all', false);
                        $scope.variables();
                    } else {
                        $cookies.put('all', true);
                        $scope.variables();
                    }
                    if (data[0].per_sexo === 'M') {
                        $cookies.put('all2', false);
                        $scope.variables();
                    } else {
                        $cookies.put('all2', true);
                        $scope.variables();
                    }
                }

            });
        }
/// cargar datos de alta de paciente en queestado queda cama
        $http.post('src/sgh/encabezado/php/SghgetEncabezado.php?', {op: 2}).success(function (data) {

            if (data.error === 'error') {
            } else {
                $scope.estadocama = data;
            }
        });

    }


// funcion de alta de paciente
    $scope.verdef = false;
    $scope.defucion = false;
    $scope.ver_camas = false;
    $scope.transferencia = false;
    $scope.cambio = false;
//variables de paginacion
    $scope.posicion = null;// guarda el total de items de la tabla
    $scope.pagina = 1; // variable de paginas a mostrar

    $scope.op = 'alta';
    $scope.nboton = 'Dar de alta';

    $scope.datosAguardar = {
        cen_def_48: null,
        cen_def48: null,
        cen_tipo: 'EGRESO',
        cen_visible: false,
        // ces_id_fk:'',
        // cam_id_pk:undefined,
    };

    //acicones de defuncio o egreso normal
    $scope.acdef = function (op) {
        if (op === true) {
            $scope.datosAguardar.cen_tipo = 'DEFUNCION';
            $scope.verdef = true;
        } else {
            $scope.datosAguardar.cen_tipo = 'EGRESO';
            $scope.verdef = false;
        }
    }

    // opciones de busqueda da camas para transferir de cama al paciente
    $scope.actra = function (op) {
        if (op === true) {
            $scope.op = 'transferencia';
            $scope.nboton = 'Transferir';
            $scope.ver_camas = true;

            $scope.cambio = false;
            $http.post('src/sgh/encabezado/php/SghgetEncabezado.php', {op: '4'}).success(function (data) {
                if (data.error === 'error') {
                } else {
                    $scope.cama_tabla = data;
                    $scope.posicion = Math.ceil(data.length / $scope.totalpaginas);
                }

            });
        } else {
            $scope.ver_camas = false;
            $scope.op = 'alta'
            $scope.nboton = 'Dar de alta';
            ;
        }

    }
    // opciones de busqueda de camas para cambiar de cama al paciente
    $scope.accambio = function (op) {
        if (op === true) {
            $scope.op = 'cambio_cama';
            $scope.nboton = 'Cambiar de cama';
            $scope.transferencia = false;
            $scope.ver_camas = true;

            $http.post('src/sgh/encabezado/php/SghgetEncabezado.php', {
                op: '5',
                serv: $scope.op_cargar
            }).success(function (data) {
                if (data.error === 'error') {
                } else {
                    $scope.cama_tabla = data;
                    $scope.posicion = Math.ceil(data.length / $scope.totalpaginas);
                }

            });
        } else {
            $scope.ver_camas = false;
            $scope.op = 'alta'
            $scope.nboton = 'Dar de alta';
            ;
        }

    }
    // acciones de guardado de alta de paciente

    $scope.acciong = function () {
        if ($scope.op === 'alta') {
            $scope.guardar();
        }
        if ($scope.op === 'transferencia') {
            $scope.gtransferecnia();
        }
        if ($scope.op === 'cambio_cama') {
            $scope.gcambiodecama();
        }

    }

    $scope.paginas = function (tipo) {
        if (tipo == 0 && $scope.pagina > 1) {
            $scope.pagina -= 1;
        } else if (tipo == 1 && $scope.pagina < $scope.posicion) {
            $scope.pagina += 1;
        }
    }

    $scope.seleccion_cama = function (id) {
        $http.post('src/sgh/censo/php/sghListarCenso.php', {op: '4', codigo: id}).success(function (data) {
            $scope.datosAguardar.cam_id_pk = data[0].cam_id_pk;
            if (data.error === 'error') {
            } else {
                $scope.datos_cama = data[0].servicio + ' PISO ' + data[0].piso + ' EN LA HABITACIÓN ' + data[0].habitacion + ' CAMA ' + data[0].cam_codigo;
            }

        });
    }

    $scope.activa_seleccion = function (op) {
        if (op === 'DESOCUPADA') {
            return false;
        } else {
            return true;
        }
    }

    $scope.cancelar = function () {
        $scope.verdef = false;
        $scope.defucion = false;
        $scope.ver_camas = false;
        $scope.transferencia = false;
        $scope.cambio = false;
        $scope.op = 'alta';
        $scope.nboton = 'Dar de alta';
        $scope.datos_cama = '';
        $('#closemodal').click()
        $scope.datosAguardar = {
            cen_def_48: null,
            cen_def48: null,
            cen_tipo: 'EGRESO',
            cen_visible: false,
            ces_id_fk: ''
        };
    }
    // guardar alta de paciente
    $scope.guardar = function () {
        $http.post('src/sgh/encabezado/php/SghgetEncabezado.php?', {
            op: 3,
            fecha: $scope.cen_fecha,
            hcl: $scope.histoclinica
        }).success(function (data) {

            if (data.error === 'error') {
                $scope.text = 'Para dar de alta, debes  realiza la epicrisis.';
                $scope.mensaje = true;
                setTimeout(function () {
                    $scope.mensaje = false;
                    $scope.$apply();
                }, 3000);
            } else {
                //alert('guardando alta de paciente');


                $http.post('src/sgh/encabezado/php/sghInserAltapaciente.php', {
                    op: 1,
                    alta: $scope.datosAguardar,
                    hcl: $scope.histoclinica,
                    usu: $scope.usuario,
                    cam: $scope.cama,
                    cen: $scope.id_cen_pk
                }).success(function (data) {

                    $scope.text = data.sgh_altapaciente_ingreso_pa;
                    $scope.mensaje = true;
                    $scope.cerrar(1);
                    setTimeout(function () {
                        $scope.mensaje = false;
                        $scope.cancelar();
                        $scope.$apply();
                    }, 1500);
                    //alert(data);
                });
            }
        });
    }
// guardar transferencia
    $scope.gtransferecnia = function () {
        $http.post('src/sgh/encabezado/php/sghInserAltapaciente.php', {
            op: 2,
            alta: $scope.datosAguardar,
            hcl: $scope.histoclinica,
            cam: $scope.cama,
            fecha: $scope.cen_fecha,
            usu: $scope.usuario,
            cen: $scope.id_cen_pk
        }).success(function (data) {

            $scope.text = data.sgh_altapaciente_ingreso_pa;
            $scope.mensaje = true;

            setTimeout(function () {
                $scope.mensaje = false;
                $scope.cancelar();
                $scope.cerrar(1);

                $scope.$apply();
            }, 1500);
            // alert(data);
        });
    }
// guardar cambio de cama

    $scope.gcambiodecama = function () {
        if ($scope.datosAguardar.cam_id_pk === undefined) {
            alert('Seleccione cama.');
        } else {
            $http.post('src/sgh/encabezado/php/sghInserAltapaciente.php', {
                op: 3,
                alta: $scope.datosAguardar,
                hcl: $scope.histoclinica,
                cam: $scope.cama,
                fecha: $scope.cen_fecha,
                usu: $scope.usuario,
                cen: $scope.id_cen_pk
            }).success(function (data) {

                $scope.text = data.sgh_altapaciente_ingreso_pa;
                $scope.mensaje = true;

                setTimeout(function () {
                    $scope.mensaje = false;
                    $scope.cancelar();
                    $scope.cerrar(1);

                    $scope.$apply();
                }, 1500);
                // alert(data);
            });

        }
    }

// cargas de perfiles
    if ($scope.histoclinica === null) {
    } else {
        $scope.carga_encabezado();
    }

    if ($scope.usu_perfil === 'LABORATORIO') {
        window.location = '#/resultados';
        $('#sidebar-collapse').click();
    }
    if ($scope.usu_perfil === 'INTERCONSULTAS') {
        window.location = '#/sinterconsulta';
        $('#sidebar-collapse').click();
    }
    if ($scope.usu_perfil === 'ADMINISTRADOR') {
     /*   $cookies.put('medicina', 'templates/heade.html');
        $scope.medicina = localStorage.getItem('medicina');
        $cookies.put('lis_pasien', false);
        $cookies.put('histoclinica', null);
        $scope.lis_pasien = $scope.bool(localStorage.getItem('lis_pasien'));
        $cookies.put('menu', true);
        //$scope.menu = $scope.bool(localStorage.getItem('menu'));*/
    } else {
        if ($scope.op_cargar !== null) {
            //$scope.car_paciente();
            $scope.car_paciente_grupo();
        }
    }

    $scope.edita_pas = false;

    $scope.cancela_editar_historias = function () {
        $scope.edita_pas = false;
        $scope.lis_pasien = true;
    }

    $scope.editar_historias = function () {
        console.log('editar_historia');
        $scope.edita_pas = true;
        $scope.lis_pasien = false;

        $http.post('src/sgh/historiasclinicas/php/sghlistarhistorias.php').success(function (data) {
            // console.log(data);
            if (data.error === 'error') {
            } else {
                $scope.historia = data;
            }
        });
    }
    if ($scope.edita_paciente === true) {
        localStorage.setItem('admi', true);
        $scope.variables();
    } else {
        localStorage.setItem('admi', false);
        $scope.variables();
    }

});

app.directive('capitalize', function () {
    return {
        require: 'ngModel',
        link: function (scope, element, attrs, modelCtrl) {
            modelCtrl.$parsers.push(function (input) {
                return input ? input.toUpperCase() : '';
            });
            element.css('text-transform', 'uppercase');
        }
    };
});
