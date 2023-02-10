// Creación del módulo
app
    .run(['$rootScope','$state','$stateParams','$cookies',
    function ($rootScope,$state,$stateParams,$cookies) {

        $rootScope.cerrarsesion = function () {
            $cookies.remove('histoclinica');
            $cookies.remove('cama');
            $cookies.remove('sgh_user', {path: '/'});
            localStorage.removeItem("mod_id_pk");
            localStorage.removeItem('usuario');
            localStorage.removeItem('servicio');
            localStorage.removeItem('op_cargar');
            localStorage.removeItem('id_cen_pk');
            localStorage.removeItem("menu", false);
            localStorage.setItem("lis_pasien", false);
            localStorage.setItem("opciones", true);
            localStorage.removeItem('entidad');
            localStorage.removeItem('usu_perfil');
            localStorage.removeItem('opcion_servicios');
            localStorage.removeItem('opcion_mensajeserivio');

            localStorage.setItem("edita_paciente", false);

            location.reload();
            window.location = "/sgh/#!/signin";
        };

        $rootScope.$on('$stateChangeSuccess',function(event,toState){
            console.log('state success');
            $rootScope.sgh_v_user = $cookies.getObject('sgh_user');
            if ($rootScope.sgh_v_user === undefined) {
                $rootScope.cerrarsesion();
            }
        })

    }])
    .config(['$stateProvider', '$urlRouterProvider',function($stateProvider, $urlRouterProvider) {

        // For unmatched routes
        $urlRouterProvider.otherwise('/');

        // Application routes
        $stateProvider

           .state('inicio', {
                url: '/',
                templateUrl: 'src/inicio.html'
            })
            .state("cie10",{
                url:"/cie10",
                controller:"c10Ctrl",
                templateUrl:"src/sgh/cie10/cie10.html",
                resolve:{
                    cie10: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"cie10",
                                files:["src/sgh/cie10/js/c10Ctrl.js"]
                            }
                        )
                    }
                }
            })//fin state cie10

            .state("catcl",{
                url:"/catcl",
                controller:"catclCtrl",
                templateUrl:"src/sgh/catcola/catcola.html",
                resolve:{
                    catcl: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"catcl",
                                files:["src/sgh/catcola/js/catcolaCtrl.js"]
                            }
                        )
                    }
                }
            })//fin state categoria
            .state("catlb",{
                url:"/catlb",
                controller:"catlbCtrl",
                templateUrl:"src/sgh/catlabo/catlabo.html",
                resolve:{
                    catlb: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"catlb",
                                files:["src/sgh/catlabo/js/catlaboCtrl.js"]
                            }
                        )
                    }
                }
            })//fin state cat labo 
            

            .state("evolucion",{
                url:"/evolucion",
                controller:"evolucionCtrl",
                templateUrl:"src/sgh/evolucion/Evolucion.html",
                resolve:{
                    evolucion: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"evolucion",
                                files:["src/sgh/evolucion/js/evolucionCtrl.js"]
                            }
                        )
                    }
                }
            })//fin state cat evolucion 

             .state("exacl",{
                url:"/exacl",
                controller:"exaclCtrl",
                templateUrl:"src/sgh/exacola/exacola.html",
                resolve:{
                    exacl: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"exacl",
                                files:["src/sgh/exacola/js/exacolaCtrl.js"]
                            }
                        )
                    }
                }
            })//fin state examen con labo 

             .state("exalb",{
                url:"/exalb",
                controller:"exalbCtrl",
                templateUrl:"src/sgh/exalabo/exalabo.html",
                resolve:{
                    exalb: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"exalb",
                                files:["src/sgh/exalabo/js/exalaboCtrl.js"]
                            }
                        )
                    }
                }
            })//fin state examen labo

            .state("glicemia",{
                url:"/glicemia",
                controller:"glicemiaCtrl",
                templateUrl:"src/sgh/glicemiaeinsu/glicemia.html",
                resolve:{
                    glicemia: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"glicemia",
                                files:["src/sgh/glicemiaeinsu/js/glicemiaCtrl.js"]
                            }
                        )
                    }
                }
            })//fin state glicemia

            .state("graf",{
                url:"/graf",
                controller:"grafCtrl",
                templateUrl:"src/sgh/grafico/grafi.html",
                resolve:{
                    graf: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"graf",
                                files:["src/sgh/grafico/js/grafiCtrl.js"]
                            }
                        )
                    }
                }
            })//fin state graficos

             .state("item",{
                url:"/item",
                controller:"itemCtrl",
                templateUrl:"src/sgh/items/item.html",
                resolve:{
                    item: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"item",
                                files:["src/sgh/items/js/itemCtrl.js"]
                            }
                        )
                    }
                }
            })//fin state items 
             
                          
               .state("punto",{
                url:"/punto",
                controller:"puntoCtrl",
                templateUrl:"src/sgh/punform/punform.html",
                resolve:{
                    punto: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"punto",
                                files:["src/sgh/punform/js/puntforCtrl.js"]
                            }
                        )
                    }
                }
           })//fin state puntos formularios 

               
           .state("sigvit",{
                url:"/sigvit",
                controller:"sigvitCtrl",
                templateUrl:"src/sgh/signosvitales/Signosvitales.html",
                resolve:{
                    sigvit: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"sigvit",
                                files:["src/sgh/signosvitales/js/signosvitalesCtrl.js"]
                            }
                        )
                    }
                }
            })//fin state signos vitales
           .state("condi",{
                url:"/condi",
                controller:"condiCtrl",
                templateUrl:"src/sgh/signosvitales/condicion.html",
                resolve:{
                    condi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"condi",
                                files:["src/sgh/signosvitales/js/condicionCtrl.js"]
                            }
                        )
                    }
                }
            })//fin state condicion
          .state("concent",{
                url:"/concent",
                controller:"concentCtrl",
                templateUrl:"src/sgh/Concentimiento/Concent.html",
                resolve:{
                    concent: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"evolucion",
                                files:["src/sgh/Concentimiento/js/ConcentCtrl.js"]
                            }
                        )
                    }
                }
            })//fin state condicion
           .state("kardex",{
                url:"/kardex",
                controller:"kardexCtrl",
                templateUrl:"src/sgh/kardex/kardex.html",
                resolve:{
                    kardex: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"kardex",
                                files:["src/sgh/kardex/js/kardexCtrl.js"]
                            }
                        )
                    }
                }
            })//fin state kardex

           .state("informa",{
                url:"/informa",
                controller:"informaCtrl",
                templateUrl:"src/sgh/informacion/informacion.html",
                resolve:{
                    informa: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"informa",
                                files:["src/sgh/informacion/js/informacionCtrl.js"]
                            }
                        )
                    }
                }
            })//fin state condicion

           .state("ingesta",{
                url:"/ingesta",
                controller:"ingestaCtrl",
                templateUrl:"src/sgh/ingesta/ingesta.html",
                resolve:{
                    ingesta: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"ingesta",
                                files:["src/sgh/ingesta/js/ingestaCtrl.js"]
                            }
                        )
                    }
                }
            })//fin state condicion

           .state("rehabi",{
                url:"/rehabi",
                controller:"rehabiCtrl",
                templateUrl:"src/sgh/rehabilitacion/rehabilitacion.html",
                resolve:{
                    rehabi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"rehabi",
                                files:["src/sgh/rehabilitacion/js/rehabilitacionCtrl.js"]
                            }
                        )
                    }
                }
            })//fin state condicion

            .state("epicrisis",{
                url:"/epicrisis",
                controller:"epicrisisCtrl",
                templateUrl:"src/sgh/epicrisis/epicrisis.html",
                resolve:{
                    epicrisis: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"epicrisis",
                                files:["src/sgh/epicrisis/js/epicrisisCtrl.js"]
                            }
                        )
                    }
                }
            })//fin state epicrisis

             .state("anamnesis",{
                url:"/anamnesis",
                controller:"anamnesisCtrl",
                templateUrl:"src/sgh/anamnesis/anamnesis.html",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"anamnesis",
                                files:["src/sgh/anamnesis/js/anamnesisCtrl.js"]
                            }
                        )
                    }
                }
            })//fin state Anamnesis
          
             .state("referencia",{
                url:"/referencia   ",
                controller:"referenciaCtrl",
                templateUrl:"src/sgh/referencia/referencia.html",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"referencia",
                                files:["src/sgh/referencia/js/referenciaCtrl.js"]
                            }
                        )
                    }
                }
            })//fin state Referencia
          
            .state("interconsulta",{
                url:"/interconsulta   ",
                controller:"interconsultaCtrl",
                templateUrl:"src/sgh/interconsulta/interconsulta.html",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"interconsulta",
                                files:["src/sgh/interconsulta/js/interconsultaCtrl.js"]
                            }
                        )
                    }
                }
            })//fin state Interconsulta

             .state("adulto",{
                url:"/adulto   ",
                controller:"adultoCtrl",
                templateUrl:"src/sgh/adultomayor/adultomayor.html",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"adulto",
                                files:["src/sgh/adultomayor/js/adultomayorCtrl.js"]
                            }
                        )
                    }
                }
            })//fin state Atencion a adulto mayor

            .state("escalageriatrica",{
                url:"/escalageriatrica",
                controller:"escalageriatricaCtrl",
                templateUrl:"src/sgh/escalageriatrica/escalageriatrica.html",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"escalageriatrica",
                                files:["src/sgh/escalageriatrica/js/escalageriatricaCtrl.js"]
                            }
                        )
                    }
                }
            })//fin de escala geriatrica

            .state("laboratorio",{
                url:"/laboratorio",
                controller:"laboratorioCtrl",
                templateUrl:"src/sgh/laboratorio/laboratorio.html",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"laboratorio",
                                files:["src/sgh/laboratorio/js/laboratorioCtrl.js"]
                            }
                        )
                    }
                }
            })//fin laboratorio clinico
            .state("bacteriologico",{
                url:"/bacteriologico",
                controller:"bacteriologicoCtrl",
                templateUrl:"src/sgh/bacteriologico/bacteriologico.html",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"bacteriologico",
                                files:["src/sgh/bacteriologico/js/bacteriologicoCtrl.js"]
                            }
                        )
                    }
                }
            })//fin bacteriologico de tuberculosis   

            .state("resultados",{
                url:"/resultados",
                controller:"resultadosCtrl",
                templateUrl:"src/sgh/ResulLaboratorio/resultados.html",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"resultados",
                                files:["src/sgh/ResulLaboratorio/js/resultadosCtrl.js"]
                            }
                        )                                                                                                                    
                    }
                }
            })//fin de laboratorio respuestas

            .state("vihsida",{
                url:"/vihsida",
                controller:"vihsidaCtrl",
                templateUrl:"src/sgh/vihsida/vihsida.html",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"vihsida",
                                files:["src/sgh/vihsida/js/vihsidaCtrl.js"]
                            }
                        )                                                                                                                    
                    }
                }
            })//fin de solicitud de vihsida   

            .state("cervicovaginal",{
                url:"/cervicovaginal",
                controller:"cervicovaginalCtrl",
                templateUrl:"src/sgh/cervicovaginal/cervicovaginal.html",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"cervicovaginal",
                                files:["src/sgh/cervicovaginal/js/cervicovaginalCtrl.js"]
                            }
                        )                                                                                                                    
                    }
                }
            })//fin de solicitud de cervico vaginal   

            .state("microbiologico",{
                url:"/microbiologico",
                controller:"microbiologicoCtrl",
                templateUrl:"src/sgh/microbiologico/microbiologico.html",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"microbiologico",
                                files:["src/sgh/microbiologico/js/microbiologicoCtrl.js"]
                            }
                        )                                                                                                                    
                    }
                }
            })//fin de solicitud de orden de pedido de examen microbiológico  
            .state("histopatologia",{
                url:"/histopatologia",
                controller:"histopatologiaCtrl",
                templateUrl:"src/sgh/histopatologia/histopatologia.html",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"histopatologia",
                                files:["src/sgh/histopatologia/js/histopatologiaCtrl.js"]
                            }
                        )                                                                                                                    
                    }
                }
            })//fin de solicitud de orden de pedido de examen microbiológico    

            .state("imagenologia",{
                url:"/imagenologia",
                controller:"imagenologiaCtrl",
                templateUrl:"src/sgh/imagenologia/imagenologia.html",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"imagenologia",
                                files:["src/sgh/imagenologia/js/imagenologiaCtrl.js"]
                            }
                        )                                                                                                                    
                    }
                }
            })//fin de solicitud de orden de pedido de examen microbiológico 

            .state("transferencia",{
                url:"/transferencia",
                controller:"transferenciaCtrl",
                templateUrl:"src/sgh/trasferenciadepaciente/transferencia.html",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"transferencia",
                                files:["src/sgh/trasferenciadepaciente/js/transferenciaCtrl.js"]
                            }
                        )                                                                                                                    
                    }
                }
            })//fin de transferencia de pacientes     

            .state("brander",{
                url:"/brander",
                controller:"branderCtrl",
                templateUrl:"src/sgh/brander/brander.html",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"brander",
                                files:["src/sgh/brander/js/branderCtrl.js"]
                            }
                        )                                                                                                                    
                    }
                }
            })//fin de escala de brander modificada 

            .state("reconcilacion",{
                url:"/reconcilacion",
                controller:"reconcilacionCtrl",
                templateUrl:"src/sgh/reconcilacion/reconcilacion.html",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"reconciliacion",
                                files:["src/sgh/reconcilacion/js/reconcilacionCtrl.js"]
                            }
                        )                                                                                                                    
                    }
                }
            })//fin de escala de brander modificada 

            .state("downton",{
                url:"/downton",
                controller:"downtonCtrl",
                templateUrl:"src/sgh/downton/downton.html",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"downton",
                                files:["src/sgh/downton/js/downtonCtrl.js"]
                            }
                        )                                                                                                                    
                    }
                }
            })//fin de escala de brander modificada 

            .state("wells",{
                url:"/wells",
                controller:"wellsCtrl",
                templateUrl:"src/sgh/wells/wells.html",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"wells",
                                files:["src/sgh/wells/js/wellsCtrl.js"]
                            }
                        )                                                                                                                    
                    }
                }
            })//fin de escala de wells

            .state("eventosadversos",{
                url:"/eventosadversos",
                controller:"eventosadversosCtrl",
                templateUrl:"src/sgh/eventosadversos/eventosadversos.html",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"eventosadversos",
                                files:["src/sgh/eventosadversos/js/eventosadversosCtrl.js"]
                            }
                        )                                                                                                                    
                    }
                }
            })//fin de formulario de notificaciónd de eventos adversos

            .state("prevenciondecaidas",{
                url:"/prevenciondecaidas",
                controller:"prevenciondecaidasCtrl",
                templateUrl:"src/sgh/prevenciocaidas/prevenciondecaidas.html",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"prevenciodecaidas",
                                files:["src/sgh/prevenciocaidas/js/prevenciondecaidasCtrl.js"]
                            }
                        )                                                                                                                    
                    }
                }
            })//fin de formulario de prevenciodecaidas

            .state("downes",{
                url:"/downes",
                controller:"downesCtrl",
                templateUrl:"src/sgh/downes/downes.html",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"downes",
                                files:["src/sgh/downes/js/downesCtrl.js"]
                            }
                        )                                                                                                                    
                    }
                }
            })//fin de formulario score downes

            .state("problemas",{
                url:"/problemas",
                controller:"problemasCtrl",
                templateUrl:"src/sgh/problemas/problemas.html",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"problemas",
                                files:["src/sgh/problemas/js/problemasCtrl.js"]
                            }
                        )                                                                                                                    
                    }
                }
            })//fin de formulario 

            .state("perfil",{
                url:"/perfil",
                controller:"perfilCtrl",
                templateUrl:"src/sgh/perfil/perfil.html",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"perfil",
                                files:["src/sgh/perfil/js/perfilCtrl.js"]
                            }
                        )                                                                                                                    
                    }
                }
            })//fin de perfil

             .state("admision",{
                url:"/admision",
                controller:"admisionCtrl",
                templateUrl:"src/sgh/admision/admision.html",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"admision",
                                files:["src/sgh/admision/js/admisionCtrl.js"]
                            }
                        )                                                                                                                    
                    }
                }
            })//fin de admisiones
            .state("reporte",{
                url:"/reporte/:id",
                controller:"reportCtrl",
                templateUrl:"src/sgh/referencia/reportes.php",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"repoter",
                                files:["src/sgh/referencia/js/reportCtrl.js"]
                            }
                        )
                    }
                }
            })//fin de reportes referencias

            .state("censo",{
                url:"/censo",
                controller:"censoCtrl",
                templateUrl:"src/sgh/censo/censo.html",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"censo",
                                files:[
                                    //"js/lib/bootstrap.css",
                                    "src/sgh/censo/js/censoCtrl.js"
                                ]
                            }
                        )
                    }
                }
            })//fin de censo

            .state("repicrisis",{
                url:"/repicrisis/:id",
                controller:"repicrisisCtrl",
                templateUrl:"src/sgh/epicrisis/repicrisis.php",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"repicrisis",
                                files:["src/sgh/epicrisis/js/repicrisisCtrl.js"]
                            }
                        )
                    }
                }
            })//fin de reporte epicrisis*/

            .state("reinformacion",{
                url:"/reinformacion/:id",
                controller:"reinformacionCtrl",
                templateUrl:"src/sgh/informacion/reportes.php",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"reinformacion",
                                files:["src/sgh/informacion/js/reinformacionCtrl.js"]
                            }
                        )
                    }
                }
            })//fin de reportes referencias

            .state("sinterconsulta",{
                url:"/sinterconsulta",
                controller:"interconsultaSCtrl",
                templateUrl:"src/sgh/Sinterconsultas/Sinterconsulta.html",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"interconsultaS",
                                files:["src/sgh/Sinterconsultas/js/interconsultaSCtrl.js"]
                            }
                        )
                    }
                }
            })// Solicitud de interconsulta

            .state("reinterconsulta",{
                url:"/reinterconsulta/:id",
                controller:"repinterconCtrl",
                templateUrl:"src/sgh/interconsulta/rintercons.php",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"reinterconsulta",
                                files:["src/sgh/interconsulta/js/repinterconCtrl.js"]
                            }
                        )
                    }
                }
            })//fin de reportes referencias

           .state("citamedica",{
                url:"/citamedica",
                controller:"citamedicaCtrl",
                templateUrl:"src/sgh/citamedica/citamedica.html",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"citamedica",
                                files:["src/sgh/citamedica/js/citamedicaCtrl.js"]
                            }
                        )
                    }
                }
            })//fin de cita medic

            .state("reventoadverso",{
                url:"/reventoadverso/:id",
                controller:"reventoadversoCtrl",
                templateUrl:"src/sgh/eventosadversos/reventoadverso.php",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"reventoadverso",
                                files:["src/sgh/eventosadversos/js/reventoadversoCtrl.js"]
                            }
                        )
                    }
                }
            })//fin de reportes eventos adversos

            .state("tipocama",{
                url:"/tipocama",
                controller:"tipocamaCtrl",
                templateUrl:"src/sgh/tipo_cama/tipocama.html",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"tipocama",
                                files:["src/sgh/tipo_cama/js/tipocamaCtrl.js"]
                            }
                        )
                    }
                }
            })//fin tipo cama

            .state("cama",{
                url:"/cama",
                controller:"camaCtrl",
                templateUrl:"src/sgh/cama/cama.html",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"cama",
                                files:[
                                    "src/sgh/cama/js/camaCtrl.js",
                                    "js/lib/ui-bootstrap-tpls.js"
                                ]
                            }
                        )
                    }
                }
            })//fin  cama

            .state("censo_dia",{
                url:"/censo_dia",
                controller:"censo_diaCtrl",
                templateUrl:"src/sgh/censo_dia/censo_dia.html",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"censo_dia",
                                files:[
                                    "src/sgh/censo_dia/js/censo_diaCtrl.js"
                                ]
                            }
                        )
                    }
                }
            })//fin de censo diario

            .state("repote",{
                url:"/repote/:id/:ruta",
                controller:"repadultoCtrl",
                templateUrl:"src/sgh/interconsulta/rintercons.php",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"repote",
                                files:["src/sgh/adultomayor/js/repadultoCtrl.js"]
                            }
                        )
                    }
                }
            })//fin de reportes general

            .state("listahistorias",{
                url:"/listahistorias",
                controller:"listahistoriasCtrl",
                templateUrl:"src/sgh/historiasclinicas/listahistorias.html",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"listahistorias",
                                files:["src/sgh/historiasclinicas/js/listahistoriasCtrl.js"]
                            }
                        )
                    }
                }
            })//fin de reportes general

            .state("dietas",{
                url:"/dietas",
                controller:"dietasCtrl",
                templateUrl:"src/sgh/dietas/dietas.html",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"dietas",
                                files:["src/sgh/dietas/js/dietasCtrl.js"]
                            }
                        )
                    }
                }
            })//fin de reportes general


            .state("listadieta",{
                url:"/listadieta",
                controller:"listadietaCtrl",
                templateUrl:"src/sgh/listadieta/listadieta.html",
                resolve:{
                    anamnesisi: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"listahistorias",
                                files:["src/sgh/listadieta/js/listadietaCtrl.js"]
                            }
                        )
                    }
                }
            })//fin de reportes general

            .state("anexos",{
                url:"/anexos",
                controller:"anexoCtrl",
                templateUrl:"src/sgh/Anexos/anexos.html",
                resolve:{
                    concent: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"evolucion",
                                files:["src/sgh/Anexos/js/AnexoCtrl.js"]
                            }
                        )
                    }
                }
            })//fin de subir anexos

            .state("dicom",{
                url:"/dicom",
                controller:"dicomCtrl",
                templateUrl:"src/sgh/dicom/listaDicom.html",
                resolve:{
                    concent: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"dicom",
                                files:["src/sgh/dicom/js/dicomCtrl.js"]
                            }
                        )
                    }
                }
            })//fin de dicom

           .state("rconcicion",{
                url:"/rconcicion",
                controller:"condicionCtrl",
                templateUrl:"src/sgh/r_condipaciente/condicionpaciente.html",
                resolve:{
                    concent: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"condcion",
                                files:["src/sgh/r_condipaciente/js/condicionCtrl.js"]
                            }
                        )
                    }
                }
            })//fin de reporte de condiciòn del paciente
         .state("produccion",{
                url:"/produccion",
                controller:"produccionCtrl",
                templateUrl:"src/sgh/produccion/produccion.html",
                resolve:{
                    concent: function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:"produccion",
                                files:["src/sgh/produccion/js/produccionCtrl.js"]
                            }
                        )
                    }
                }
            })
   }
]);
