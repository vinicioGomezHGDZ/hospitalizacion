angular.module("censo", ['ui.router'])
    .controller('censoCtrl', ['$scope', '$http', '$stateParams', function ($scope, $http, $stateParams, ModalService) {

//variables de paginacion
        $scope.posicion = null;// guarda el total de items de la tabla
        $scope.pagina = 1; // variable de paginas a mostrar
        $scope.paginas = function (tipo) {
            if (tipo == 0 && $scope.pagina > 1) {
                $scope.pagina -= 1;
            }
            else if (tipo == 1 && $scope.pagina < $scope.posicion) {
                $scope.pagina += 1;
            }
        }

//variables de formulario
        $scope.mensaje = false; // mostrar mensaje de guardado
        $scope.ver_pacientes = false;
        $scope.ver_camas = false;
        $scope.agre_paciente = false;
        $scope.busca = true;
        $scope.busca_paciente = function () {
            $scope.paciente = null;
            $scope.search = "";
            $scope.busca = true;
            $scope.ver_pacientes = true;
            $scope.ver_camas = false;
            $scope.agre_paciente = false;
            $scope.datosAguardar = {};
            $scope.titulo = "Busqueda de paciente";// titulo del modal
            $http.post('src/sgh/censo/php/sghListarCenso.php', {op: '1'}).success(function (data) {
                if (data.error === "error") {
                }
                else {
                    $scope.paciente = data;
                    $scope.posicionp = Math.ceil(data.length / $scope.totalpaginas);
                }
                // console.log(data);
            });
        }
        if ($scope.sgh_v_user === undefined) {
            $scope.cerrarsecion();
        }

        $scope.seleccion_paciente = function (item) {
            console.log(item);
            $http.post('src/sgh/censo/php/sghListarCenso.php', {op: '5', codigo: item.hce_id_pk}).success(function (response) {
                console.log(response);
                if (response.status === 'success') {
                    //$scope.hce_id_pk = data[0].hce_id_pk;
                    $scope.hce_id_pk = item.hce_id_pk;
                    $scope.datos_paciente = item;
                    $("#closemodal").click();
                }
                else {
                    console.log('Ya existe paciente en hospitalización');
                }

            });
        };

        $scope.cama_paciente = function () {
            $scope.search = "";
            $scope.busca = true;
            $scope.ver_pacientes = false;
            $scope.ver_camas = true;
            $scope.agre_paciente = false;
            $scope.datosAguardar = {};

            $scope.titulo = "Asignación de cama";// titulo del modal
            $http.post('src/sgh/censo/php/sghListarCenso.php', {
                op: '3',
                serv: $scope.op_cargar
            }).success(function (data) {
                if (data.error === "error") {
                }
                else {
                    $scope.cama = data;
                    $scope.posicion = Math.ceil(data.length / $scope.totalpaginas);
                }
                console.log(data);
            });


        }

        $scope.activa_seleccion = function (op) {
            if (op === "DESOCUPADA") {
                return false;
            } else {
                return true;
            }
        };

        $scope.seleccion_cama = function (id) {
            $http.post('src/sgh/censo/php/sghListarCenso.php', {op: '4', codigo: id}).success(function (data) {
                if (data.error === "error") {
                }
                else {
                    $scope.cam_id_pk = data[0].cam_id_pk;

                    $scope.datos_cama = data[0].servicio + " Piso " + data[0].piso + " En la habitación " + data[0].habitacion + " Cama " + data[0].cam_codigo;
                    $("#closemodal").click();
                }
                // console.log(data);
            });
        };

        $scope.agrepaciente = function () {
            $scope.ver_pacientes = false;
            $scope.ver_camas = false;
            $scope.agre_paciente = true;
            $scope.busca = false;
            $scope.titulo = "Ingreso de nuevo paciente";// titulo del modal
            $scope.datosAguardar = {provisional: false, tid_id_fk: 2, pai_id_fk: 57, prv_id_fk: null};
            $scope.cargarSexo();
            $scope.cargarTipoIdentificacion();
            $scope.cargarPais();
            $scope.objProv = {
                nom_aux: null,
                ape_aux: null,
                cod_prov: null,
                anio_nac: null,
                mes_nac: null,
                dia_nac: null,
                control: null
            };
            $scope.cargarProvincia({pai_id_pk: 57, prv_codigo: 23});
            $scope.datosAguardar.prv_id_fk = 23;

        };

        $scope.cargarSexo = function () {
            $http.post('src/sgh/censo/php/sghListarCenso.php', {op: '6'}).success(function (data) {
                if (data.error === "error") {
                }
                else {
                    $scope.sexo = data;
                }
            });
        };

        $scope.cargarTipoIdentificacion = function () {
            $http.post('src/sgh/censo/php/sghListarCenso.php', {op: '8'}).success(function (data) {
                $scope.tipoIdentificaciones = data;
            })
        };

        $scope.cambiarTipoIdentificacion = function () {
            if (parseInt($scope.datosAguardar.tid_id_fk) === 6) {
                $scope.datosAguardar.provisional = true;
                $scope.selectProvincia({prv_codigo: $scope.datosAguardar.prv_id_fk});
                $scope.datosAguardar.per_numeroidentificacion = null;
            } else {
                $scope.datosAguardar.provisional = false;
                $scope.datosAguardar.per_numeroidentificacion = null;
            }
        };

        $scope.cargarPais = function () {
            $http.get('src/sgh/censo/php/getAllPais.php').success(function (data) {
                $scope.paises = data;
            });
        };

        $scope.cargarProvincia = function (item) {
            var prov = {pai_id_fk: item.pai_id_pk};
            $http.post('src/sgh/censo/php/getAllProvincia.php', prov).success(function (data) {
                $scope.provincias = data;
                $scope.generarCodProv(item.prv_codigo, 'pai_id_fk', item.pai_id_pk);
                // console.log(item.prv_codigo);
                // console.log(item.pai_id_pk);
                if (item.pai_id_pk !== 57) {
                    $scope.datosAguardar.prv_id_fk = $scope.provincias[0].prv_id_pk;
                }
            });
        };

        $scope.selectProvincia = function (item) {
            $scope.generarCodProv(parseInt(item.prv_codigo), 'prv_id_fk');
        };

        Number.prototype.pad = function (size) {
            var s = String(this);
            while (s.length < (size || 2)) {
                s = "0" + s;
            }
            return s;
        };

        $scope.generarCodProv = function (item, option, codigo_pais) {
            option = option || null;
            codigo_pais = codigo_pais || null;

            if ($scope.datosAguardar.provisional) {
                //verificar provisional es true
                switch (option) {
                    case 'per_nombres':
                        if (item) $scope.objProv.nom_aux = item.substr(0, 2);
                        var lastName = item.split(' ')[1];
                        if (lastName) {
                            $scope.objProv.nom_aux += lastName.substr(0, 1);
                            //$scope.objProv.num_hijo = lastName.substr(0, 1);
                        }
                        else {
                            $scope.objProv.nom_aux += '0';
                            //$scope.objProv.num_hijo = 0;
                        }
                        break;
                    case 'numero_hijo':
                        var nom_aux = $scope.objProv.nom_aux;
                        if (nom_aux.length === 3) $scope.objProv.nom_aux = $scope.objProv.nom_aux.substr(0, 2) + item;
                        break;
                    case 'per_apellidopaterno':
                        if (item) $scope.objProv.ape_aux = item.substr(0, 2) + '0';
                        break;
                    case 'per_apellidomaterno':
                        if ($scope.objProv.ape_aux.slice(-1) === '0') $scope.objProv.ape_aux = $scope.objProv.ape_aux.substr(0, 2);
                        if ($scope.objProv.ape_aux.length > 2) return;
                        if (item) {
                            $scope.objProv.ape_aux += item.substr(0, 1)
                        }
                        else {
                            $scope.objProv.ape_aux += '0'
                        }
                        break;
                    case 'pai_id_fk':
                        if (codigo_pais === 57) {
                            $scope.objProv.cod_prov = item;
                        } else {
                            $scope.objProv.cod_prov = '99';
                        }
                        break;
                    case 'prv_id_fk':
                        $scope.objProv.cod_prov = item.pad();
                        break;
                    case 'per_fechanacimiento':
                        if (item) {
                            $scope.objProv.anio_nac = String(item.getFullYear());
                            var mes_nac = item.getMonth() + 1;
                            $scope.objProv.mes_nac = mes_nac.pad();
                            $scope.objProv.dia_nac = item.getDate().pad();
                            $scope.objProv.control = $scope.objProv.anio_nac.substr(2, 1);
                        }
                        break;
                }
                //$scope.objProv.nomape = $scope.objProv.nom_aux + ($scope.objProv.ape_aux ? $scope.objProv.ape_aux : '');
                $scope.datosAguardar.per_numeroidentificacion = '';
                for (var item in $scope.objProv) {
                    $scope.datosAguardar.per_numeroidentificacion += $scope.objProv[item] ? String($scope.objProv[item]) : ''
                }
                //$scope.datosAguardar.per_numeroidentificacion = $scope.objProv.nomape;
            }
        };


        $scope.actguarda = false;
        $scope.verificarnmombres = function () {

            /*$http.post('src/sgh/censo/php/sghListarCenso.php', {
                op: '7',
                nombre: $scope.datosAguardar.per_nombres,
                apaterno: $scope.datosAguardar.per_apellidopaterno,
                amaterno: $scope.datosAguardar.per_apellidomaterno
            }).success(function (data) {
                if (data.error === "error") {
                    $scope.guardahistoria();
                }
                else {
                    $scope.confirmapaciente = true;
                    $scope.agre_paciente = false;
                    $scope.datos_paciente = data[0].persona;
                    $scope.datos_paciente_ci = data[0].per_numeroidentificacion;

                }
                console.log(data);
            }).error(function (data) {
                console.error(data);
            });*/
        };

        $scope.guardahistoria = function () {
            $scope.agre_paciente = true;
            $scope.confirmapaciente = false;

            $scope.datosAguardar.fecha_registro = {
                usu_id_fk: $scope.sgh_v_user.usu_id_pk,
                usu_login: $scope.sgh_v_user.usu_login
            };
            console.log($scope.datosAguardar);

            $http.post('src/sgh/censo/php/insertCensoJSON.php', $scope.datosAguardar)
                .success(function (data) {
                    console.log(data);
                    $scope.text = data.Mensaje;
                    $scope.type = data.Tipo;
                    $scope.mensaje = true;
                    setTimeout(function () {
                        $scope.mensaje = false;
                        $scope.actguarda = false;
                        $scope.$apply();
                        if (data.Estado === 1) {
                            $scope.confirmapaciente = true;
                            $scope.agre_paciente = false;
                            $scope.datos_paciente = $scope.datosAguardar.per_apellidopaterno + ' ' + $scope.datosAguardar.per_apellidomaterno + ' ' + $scope.datosAguardar.per_nombres;
                            $scope.datos_paciente_ci = $scope.datosAguardar.per_numeroidentificacion;


                            $scope.datosAguardar = {};
                            $scope.cancelar();
                            $scope.actguarda = true;
                        }
                    }, 2500);
                }).error(function (data) {
                console.error(data);
            });


            /*      $http.post('src/sgh/censo/php/sghInserCenso.php', {
                      op: 2,
                      usu: $scope.usuario,
                      hist: $scope.datosAguardar
                  }).success(function (data) {
                      $scope.text = data.sgh_historiaclinica_ingreso_pa;
                      $scope.mensaje = true;
                      $scope.datosAguardar = {};
                      setTimeout(function () {
                          $scope.mensaje = false;
                          $scope.actguarda = false;
                          $scope.$apply();
                          $scope.cancelar();
                      }, 2500);
                      console.log(data);
                  });*/
        };


// GUARDAR DATOS
        $scope.confirmapaciente = false;
        $scope.cancelar = function () {
            $("#closemodal").click();
            $scope.confirmapaciente = false;
            $scope.actguarda = false;
        };


        $scope.salir = function () {
            $("#closemodal").click();
            $scope.cerrar(1);

        };


////guardar
        $scope.cam_id_pk = null;
        $scope.hce_id_pk = null;
        $scope.guardar = function () {
            // $scope.actguarda=true;
            if ($scope.cam_id_pk === null || $scope.hce_id_pk === null) {
                $scope.mensaje = true;
                $scope.text = "Seleccione una Paciente o habitación";
                setTimeout(function () {
                    $scope.mensaje = false;
                    $scope.actguarda = false;
                    $scope.$apply();
                }, 2000);
            }
            else {
                $scope.estadocama = 1;
// $http.post('src/sgh/censo/php/sghListarCenso.php',{op:5,hce:$scope.hce_id_pk}).success(function(data){
// 	console.log(data);
                // if (data.error === "error") {
                $http.post('src/sgh/censo/php/sghInserCenso.php', {
                    op: 1,
                    hce: $scope.hce_id_pk,
                    cam: $scope.cam_id_pk,
                    usu: $scope.usuario,
                    est: $scope.estadocama
                }).success(function (data) {
                    $scope.text = data.sgh_censopaciente_ingreso_pa;
                    $scope.mensaje = true;
                    $scope.datosAguardar = {};
                    setTimeout(function () {
                        $scope.mensaje = false;
                        $scope.$apply();
                        $scope.cancelar();
                        $scope.car_paciente();
                        $scope.actguarda = false;
                    }, 1500);
                    console.log(data);

                });
//  	}else{
//      $scope.mensaje= true;
// 	 $scope.text = "Paciente ya hopitalizado";
// 	 setTimeout(function()
// 			 {
//                 $scope.actguarda=false;
// 				$scope.mensaje= false;
// 				$scope.$apply();
// 				$scope.datos_paciente=null;
// 				$scope.datos_cama="";
//    		  }, 2000);
//
// 	}
// });
            }
        }
//////////////////////////////////////////////////////
//EDICION DE datos//


    }]);
