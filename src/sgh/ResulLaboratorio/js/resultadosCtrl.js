angular.module("resultados",['ngRoute'])
.controller('resultadosCtrl',['$scope','$http','$routeParams','upload',function($scope,$http,$routeParams,upload){

$scope.Fecha = new Date();
$scope.tabla=true;
    if ($scope.sgh_v_user === undefined){$scope.cerrarsecion();}
$scope.activa=function(id){
		if (id === ""){	 $scope.otros=true;	}else{$scope.otros=false;}
}
/// Funciones  de convercion de char a bool
  $scope.bool=function(valor){

    if (valor === "t"){
      var bool = true;
    }else{var bool = false;}
  return bool;  
  }
    $scope.estado_colores=function (op) {

        if (op === 'URGENTE'){
            return $scope.myStyle={'background-color':'#F6CECE',color:'#190707'}
        }

    }
$scope.char=function(valor){

    if (valor === true){
      var bool = "true";
    }else{var bool = "false";}
  return bool;  
  }
//datos que estraigo de los campos para guardar
  $scope.mensaje=false ;
  $scope.cat=1;
//variables de paginacion
  $scope.posicion=null;// guarda el total de items de la tabla
  $scope.pagina=1; // variable de paginas a mostrar
//cargar datos con json
  $scope.tbac=0;
  $scope.cerva=0;
  $scope.histo=0;
  $scope.histoc=0;
  $scope.histor=0;
  $scope.histou=0;
  $scope.ima=0;
  $scope.micro=0;
  $scope.vih=0;
  $scope.lab=0;
  $scope.labc=0;
  $scope.labr=0;
  $scope.labu=0;
    $scope.actu=function(){
        $http.post('src/sgh/ResulLaboratorio/php/sghListaresultados.php',{op:'1'}).success(function (data) {
            console.log(data);
            if (data.error === 'error'){ $scope.tbac=0; $scope.bacteriologico=null;}
            else{
                $scope.bacteriologico = data;
                $scope.tbac=data.length;
            }
        });

        $http.post('src/sgh/ResulLaboratorio/php/sghListaresultados.php',{op:'2'}).success(function (data) {
            if (data.error === 'error'){ $scope.cerva=0; $scope.cervicovaginal=null;}
            else{
                $scope.cervicovaginal = data;
                $scope.cerva=data.length;
            }
        });

        $http.post('src/sgh/ResulLaboratorio/php/sghListaresultados.php',{op:'3'}).success(function (data) {
            if (data.error === 'error'){ $scope.histo=0; $scope.istopatologia =null;}
            else{
                $scope.istopatologia = data;
                $scope.histo=data.length;}
        });
        $http.post('src/sgh/ResulLaboratorio/php/sghListaresultados.php',{op:'9', prio:"CONTROL"}).success(function (data) {
            if (data.error === "error"){ $scope.histoc=0;}
            else{
                $scope.histoc=data.length;
            }
        });
        $http.post('src/sgh/ResulLaboratorio/php/sghListaresultados.php',{op:'9', prio:"RUTINA"}).success(function (data) {
            if (data.error === "error"){$scope.histor=0;}
            else{
                $scope.histor=data.length;
            }
        });
        $http.post('src/sgh/ResulLaboratorio/php/sghListaresultados.php',{op:'9', prio:"URGENTE"}).success(function (data) {
            if (data.error === "error"){$scope.histou=0;}
            else{
                $scope.histou=data.length;
            }
        });

        $http.post('src/sgh/ResulLaboratorio/php/sghListaresultados.php',{op:'4'}).success(function (data) {
            if (data.error === 'error'){$scope.ima=0;$scope.imagenologia=null;}
            else{
                $scope.imagenologia = data;
                $scope.ima=data.length;
            }//console.log(data);
        });
        $http.post('src/sgh/ResulLaboratorio/php/sghListaresultados.php',{op:'5'}).success(function (data) {
            if (data.error === "error"){ $scope.micro=0;$scope.microbiologia=null;}
            else{
                $scope.microbiologia = data;
                $scope.micro=data.length;
            }
        });
        $http.post('src/sgh/ResulLaboratorio/php/sghListaresultados.php',{op:'6'}).success(function (data) {
            if (data.error === "error"){ $scope.vih=0; $scope.vihsida=null;}
            else{
                $scope.vihsida = data;
                $scope.vih=data.length;
            }
        });
        $http.post('src/sgh/ResulLaboratorio/php/sghListaresultados.php',{op:'7'}).success(function (data) {
            if (data.error === "error"){ $scope.lab=0; $scope.laboratorio=null;}
            else{
                $scope.laboratorio = data;
                $scope.lab=data.length;
            }
        });
        $http.post('src/sgh/ResulLaboratorio/php/sghListaresultados.php',{op:'8', prio:"CONTROL"}).success(function (data) {
            if (data.error === "error"){ $scope.labc=0;}
            else{
                $scope.labc=data.length;
            }
        });
        $http.post('src/sgh/ResulLaboratorio/php/sghListaresultados.php',{op:'8', prio:"RUTINA"}).success(function (data) {
            if (data.error === "error"){ $scope.labr=0;}
            else{
                $scope.labr=data.length;
            }
        });
        $http.post('src/sgh/ResulLaboratorio/php/sghListaresultados.php',{op:'8', prio:"URGENTE"}).success(function (data) {
            if (data.error === "error"){$scope.labu=0;}
            else{
                $scope.labu=data.length;
            }
        });
    }
$scope.actu();
///// actualización automatica
$scope.resactualiza=function(){
  setTimeout(function() 
        {
          $scope.$apply();
          $scope.resactualiza();
          $scope.actu();
        }, 100000);
}    
$scope.resactualiza();
/// CARGAR DATOS DE BACTERIOLOGIA
$scope.bact=function(id){
  $scope.codigo=id;$scope.op=2;
  $http.post('src/sgh/bacteriologico/php/sghListaBacteriologico.php',{op:'2',codigo:id}).success(function (data) {
        $scope.datosAguardar ={
        bac_bk: data[0].bac_bk ,
        bac_cultivo: data[0].bac_cultivo ,
        bac_ada: data[0].bac_ada ,
        bac_psd: data[0].bac_psd ,
        bac_diag: data[0].bac_diag ,
        bac_control: data[0].bac_control ,
        bac_mes: data[0].bac_mes ,
        bac_esqtra: data[0].bac_esqtra, 
        bac_esputo: data[0].bac_esputo, 
        bac_otrom: data[0].bac_otrom ,
        bac_abando: data[0].bac_abando ,
        bac_recupe: data[0].bac_recupe, 
        bac_fracas: data[0].bac_fracas ,
        bac_recaid: data[0].bac_recaid ,
        bac_sr_bk: data[0].bac_sr_bk ,
        bac_tb_dr: data[0].bac_tb_dr ,
        bac_pvv: data[0].bac_pvv ,
        bac_diabetes: data[0].bac_diabetes, 
        bac_tb_otroe: data[0].bac_tb_otroe ,
        bac_emdesa: data[0].bac_emdesa ,
        bac_ppl: data[0].bac_ppl ,
        bac_tbdr: data[0].bac_tbdr,
        
      };
      console.log(data);
     });
  }
/// CARGAR DATOS DE HISTOPATOLOGIA
$scope.dhisto=function(id){
    $scope.codigo=id;$scope.op=4;
    $http.post('src/sgh/histopatologia/php/sghListaHistopatologia.php',{op:'2', codigo:id}).success(function (data) {
      $scope.datoshisto = {
      his_aborto:parseInt(data[0].his_aborto),
      his_cesare:parseInt(data[0].his_cesare),
      his_citolo:data[0].his_citolo,
      his_descri:data[0].his_descri,
      his_diu:$scope.bool(data[0].his_diu),
      his_endoce:$scope.bool(data[0].his_endoce),
      his_exocer:$scope.bool(data[0].his_exocer),
      his_fecha:data[0].his_fecha,
      his_fecto:data[0].his_fecto,
      his_gestac:parseInt(data[0].his_gestac),
      his_histop:data[0].his_histop,
      his_inrese:parseInt(data[0].his_inrese),
      his_ligadu:$scope.bool(data[0].his_ligadu),
      his_menarq:parseInt(data[0].his_menarq),
      his_menopa:parseInt(data[0].his_menopa),
      his_muestr:parseInt(data[0].his_muestr),
      his_muncer:$scope.bool(data[0].his_muncer),
      his_orainy:$scope.bool(data[0].his_orainy),
      his_otrant:$scope.bool(data[0].his_otrant),
      his_otrmat:$scope.bool(data[0].his_otrmat),
      his_partos:parseInt(data[0].his_partos),
      his_parvag:$scope.bool(data[0].his_parvag),
      his_priori:data[0].his_priori,
      his_rescli:data[0].his_rescli,
      his_terhor:$scope.bool(data[0].his_terhor),
      his_trqrec:data[0].his_trqrec,
      his_ultcit:data[0].his_ultcit,
      his_ultmes:data[0].his_ultmes,
      his_ultpar:data[0].his_ultpar,
      his_unesco:$scope.bool(data[0].his_unesco),

    };
    // console.log(data);
      });
    $http.post('src/sgh/histopatologia/php/sghListaHistopatologia.php',{op:'3', codigo:id}).success(function (data) {
    $scope.cie10=data; 
    //console.log(data);
     }); 
  }
/// CARGAR DATOS DE CERVICO VAGIAL
$scope.dcerva= function(id){
  $scope.codigo=id;
  $scope.op=3;
  $http.post('src/sgh/cervicovaginal/php/sghListaCervicoVaginal.php',{op:'2',codigo:id}).success(function (data) {
    $scope.datosAguardar = {

      ccv_anio:parseInt(data[0].ccv_anio),
      ccv_cacute:data[0].ccv_cacute ,
      ccv_citolo:data[0].ccv_citolo ,
      ccv_coniza:data[0].ccv_coniza ,
      ccv_cuatas:parseInt(data[0].ccv_cuatas),
      ccv_embara:data[0].ccv_embara ,
      ccv_fetomu:data[0].ccv_fetomu ,
      ccv_feulme:data[0].ccv_feulme ,
      ccv_hacuti:data[0].ccv_hacuti ,
      ccv_hister:data[0].ccv_hister ,
      ccv_inisex:parseInt(data[0].ccv_inisex),
      ccv_lactan:data[0].ccv_lactan,
      ccv_meses:parseInt(data[0].ccv_meses),
      ccv_numabo:parseInt(data[0].ccv_numabo),
      ccv_numpar:parseInt(data[0].ccv_numpar),
      ccv_planif:data[0].ccv_planif,
      ccv_radiot:data[0].ccv_radiot,
      ccv_result:data[0].ccv_result
    };
     }); 

  }
/// CARGAR DATOS DE MICRIBIOLOGICO
$scope.dmicro=function(id){
 $scope.codigo=id;$scope.op=5;
   $http.post('src/sgh/microbiologico/php/sghListaMicrobiologico.php',{op:'2',codigo:id}).success(function (data) {
    $scope.datosAguardar = {
          mic_antcli:data[0].mic_antcli,
          mic_antibi:data[0].mic_antibi,
          mic_caul:data[0].mic_caul ,
          mic_comimu:$scope.char(data[0].mic_comimu),
          mic_cuales:data[0].mic_cuales,
          mic_cultde:data[0].mic_cultde,
          mic_daepre:data[0].mic_daepre,
          mic_fecha:data[0].mic_fecha, 
          mic_infecc:data[0].mic_infecc,
          mic_intran:$scope.char(data[0].mic_intran),
          mic_obcerb:data[0].mic_obcerb,
          mic_otrlab:data[0].mic_otrlab,
          mic_proinv:data[0].mic_proinv,
          mic_recpor:data[0].mic_recpor,
          mic_sosdia:data[0].mic_sosdia,
          mic_urocul:data[0].mic_urocul

    };
     }); 
   }
/// CARGAR DATOS DE LABORATORIO 
$scope.labodatos=function(id){
  $scope.codigo=id;
  $scope.op=1;
  $http.post('src/sgh/laboratorio/php/SghgetLaboratorio.php',{op:'2', codigo:id}).success(function (data) {
      console.log(data);
      $scope.datoslaboratorio = data;
   }); 
  }

/// OCULTAR DATOS DE BACTERIOLOGIA
$scope.verbact=function(){
 $scope.vcerva=false;
 $scope.vbact=true;
 $scope.vhist=false;
 $scope.vmicro=false;
 $scope.vvih=false;
 $scope.vsla=false;
 $scope.tabla=false;
 $scope.vgre=false; 
  }
/// OCULTAR DATOS DE HISTOPATOLOGICO
$scope.verhisto=function(){
 $scope.vcerva=false;
 $scope.vbact=false;
 $scope.vhist=true;
 $scope.vmicro=false;
 $scope.vvih=false;
 $scope.vsla=false;
 $scope.tabla=false;
 $scope.vgre=false; 
  }
/// OCULTAR DATOS DE CEREVICO VAGINAL
$scope.vercerv=function(){
 $scope.vcerva=true;
 $scope.vbact=false;
 $scope.vhist=false;
 $scope.vmicro=false;
 $scope.vvih=false;
 $scope.vsla=false;
 $scope.tabla=false;
 $scope.vgre=false; 
  }
/// OCULTAR DATOS DE MICROBIOLOGICO
$scope.vermicro=function(){
 $scope.vcerva=false;
 $scope.vbact=false;
 $scope.vhist=false;
 $scope.vmicro=true;
 $scope.vvih=false;
 $scope.vsla=false;
 $scope.tabla=false;
 $scope.vgre=false; 
  }
/// OCULTAR DATOS DE VIH / CIDA
$scope.vervih=function(){
 $scope.vcerva=false;
 $scope.vbact=false;
 $scope.vhist=false;
 $scope.vmicro=false;
 $scope.vvih=true;
 $scope.vsla=false;
 $scope.tabla=false;
 $scope.vgre=false;

  }
// OCULTA DAATOS LABORATORIO
$scope.verlabo=function(){
 $scope.vcerva=false;
 $scope.vbact=false;
 $scope.vhist=false;
 $scope.vmicro=false;
 $scope.vvih=false;
 $scope.vsla=true;
 $scope.tabla=false; 
 $scope.vgre=false;
  }
$scope.regreesar=function(){ 
 $scope.tabla=true; 
 $scope.vcerva=false;
 $scope.vbact=false;
 $scope.vhist=false;
 $scope.vmicro=false;
 $scope.vvih=false;
 $scope.vsla=false;
 $scope.vgre=false;
 $scope.actu();
 }

$scope.garchvih=function(id){$scope.codigo=id;$scope.op=6;}
$scope. paginas = function(tipo)
{if (tipo == 0 && $scope.pagina  > 1 ){$scope.pagina-=1;}
 else if (tipo == 1 && $scope.pagina < $scope.posicion ){$scope.pagina+=1;}
} 

$scope.cancelar = function(){
        angular.element("input[type='file']").val(null);
        $("#closemodal").click();
         $scope.actu();
}
$scope.accion=function(){
  if ($scope.op === 1) {
    $scope.glaboratorio();
  }
   if ($scope.op === 2) {
    $scope.gbacteriologia();
  }
    if ($scope.op === 3) {
    $scope.gcervicovaginal();
  }
    if ($scope.op === 4) {
    $scope.ghistopatologia();
  }
    if ($scope.op === 5) {
    $scope.gmicrobiologia();
  }
    if ($scope.op === 6) {
    $scope.gvihsida();
  }

}
  /// guardar resultados
$scope.glaboratorio = function()
  {	
    var file = $scope.file;
    var codigo= $scope.codigo;
    var ruta = "src/sgh/laboratorio/php/sube_resul_laboratorio.php";
    upload.uploadFile(file, codigo,ruta).success(function(res)
    {
      $scope.text=res;
      if ($scope.text==="")
      {
         $http.post('src/sgh/laboratorio/php/sghInserLaboratorio.php',{id:$scope.codigo, op:3}) .success(function(data){ 
         $scope.text = data.sgh_solilaboratorio_ingreso_pa; 
         $scope.mensaje= true;
          
          setTimeout(function() 
          {
            $scope.mensaje= false;
            $scope.$apply();
           // $("#closemodal").click();
            $scope.cancelar();
            $scope.actu();
          }, 1500);
         console.log(data);
        });  
    }
    else { 
        $scope.text=res; 
         $scope.mensaje= true;
          setTimeout(function() 
          {
            $scope.mensaje= false;
            $scope.$apply();
            angular.element("input[type='file']").val(null);
            //$("#closemodal").click();
            //$scope.actu();
          }, 2500);
    }
    })
   }
$scope.gbacteriologia = function()
  { 
    var file = $scope.file;
    var codigo= $scope.codigo;
    var ruta = "src/sgh/bacteriologico/php/sube_res_bacteriologico.php";
    upload.uploadFile(file, codigo,ruta).success(function(res)
    {
      $scope.text=res;
      if ($scope.text==="")
      {
         $http.post('src/sgh/bacteriologico/php/sghInserBacteriologico.php',{id:$scope.codigo, op:2}) .success(function(data){ 
         $scope.text = data.sgh_bacteriologico_ingreso_pa; 
         $scope.mensaje= true;
          
          setTimeout(function() 
          {
            $scope.mensaje= false;
            $scope.$apply();
           // $("#closemodal").click();
            $scope.cancelar();
            $scope.actu();
          }, 1500);
         console.log(data);
        });  
    }
    else { 
        $scope.text=res;
         $scope.mensaje= true;
          setTimeout(function() 
          {
            $scope.mensaje= false;
            $scope.$apply();
            angular.element("input[type='file']").val(null);
          }, 2500);
    }
    })
   }
$scope.gcervicovaginal = function()
   { 
    var file = $scope.file;
    var codigo= $scope.codigo;
    var ruta = "src/sgh/cervicovaginal/php/sube_cervicovaginal.php";
    upload.uploadFile(file, codigo,ruta).success(function(res)
    {
      $scope.text=res;
      if ($scope.text==="")
      {
         $http.post('src/sgh/cervicovaginal/php/sghInserCervicoVaginal.php',{id:$scope.codigo, op:2}) .success(function(data){ 
         $scope.text = data.sgh_cervicovaginal_ingreso_pa; 
         $scope.mensaje= true;
          
          setTimeout(function() 
          {
            $scope.mensaje= false;
            $scope.$apply();
           // $("#closemodal").click();
            $scope.cancelar();
            $scope.actu();
          }, 1500);
         console.log(data);
        });  
    }
    else { 
        $scope.text=res;
         $scope.mensaje= true;
          setTimeout(function() 
          {
            $scope.mensaje= false;
            $scope.$apply();
            angular.element("input[type='file']").val(null);
          }, 2500);
    }
        console.log(res);
    })
   }
$scope.ghistopatologia = function()
  { 
    var file = $scope.file;
    var codigo= $scope.codigo;
    var ruta = "src/sgh/histopatologia/php/sube_histopatologia.php";
    upload.uploadFile(file, codigo,ruta).success(function(res)
    {
      $scope.text=res;
      if ($scope.text==="")
      {
         $http.post('src/sgh/histopatologia/php/sghInserHistopatologia.php',{id:$scope.codigo, op:3}) .success(function(data){ 
         $scope.text = data.sgh_histopatologia_ingreso_pa; 
         $scope.mensaje= true;
          
          setTimeout(function() 
          {
            $scope.mensaje= false;
            $scope.$apply();
           // $("#closemodal").click();
            $scope.cancelar();
            $scope.actu();
          }, 1500);
         console.log(data);
        });  
    }
    else { 
        $scope.text=res;
         $scope.mensaje= true;
          setTimeout(function() 
          {
            $scope.mensaje= false;
            $scope.$apply();
            angular.element("input[type='file']").val(null);
          }, 2500);
    }
    })
   }
$scope.gmicrobiologia = function()
  { 
    var file = $scope.file;
    var codigo= $scope.codigo;
    var ruta = "src/sgh/microbiologico/php/sube_microbiologia.php";
    upload.uploadFile(file, codigo,ruta).success(function(res)
    {
      $scope.text=res;
      if ($scope.text==="")
      {
         $http.post('src/sgh/microbiologico/php/sghInserMicrobiologico.php',{id:$scope.codigo, op:2}) .success(function(data){ 
         $scope.text = data.sgh_microbiologico_ingreso_pa; 
         $scope.mensaje= true;
          
          setTimeout(function() 
          {
            $scope.mensaje= false;
            $scope.$apply();
           // $("#closemodal").click();
            $scope.cancelar();
            $scope.actu();
          }, 1500);
         //console.log(data);
        });  
    }
    else { 
        $scope.text=res;
         $scope.mensaje= true;
          setTimeout(function() 
          {
            $scope.mensaje= false;
            $scope.$apply();
            angular.element("input[type='file']").val(null);
          }, 2500);
    }
    })
   }
$scope.gvihsida = function() {
    var file = $scope.file;
    var codigo = $scope.codigo;
    var ruta = "src/sgh/vihsida/php/sube_res_vihsida.php";
    upload.uploadFile(file, codigo, ruta).success(function (res) {
        $scope.text = res;
        if ($scope.text === "") {
            $http.post('src/sgh/vihsida/php/sghInserVihsida.php', {id: $scope.codigo, op: 2}).success(function (data) {
                $scope.text = data.sgh_vihsida_ingreso_pa;
                $scope.mensaje = true;

                setTimeout(function () {
                    $scope.mensaje = false;
                    $scope.$apply();
                    // $("#closemodal").click();
                    $scope.cancelar();
                    $scope.actu();
                }, 1500);
                console.log(data);
            });
        }
        else {
            $scope.text = res;
            $scope.mensaje = true;
            setTimeout(function () {
                $scope.mensaje = false;
                $scope.$apply();
                angular.element("input[type='file']").val(null);
            }, 2500);
        }
    })
}
}])

.directive('uploaderModel', ["$parse", function ($parse) {
  return {
    restrict: 'A',
    link: function (scope, iElement, iAttrs) 
    {
      iElement.on("change", function(e)
      {
        $parse(iAttrs.uploaderModel).assign(scope, iElement[0].files[0]);
      });
    }
  };
}])

.service('upload', ["$http", "$q", function ($http, $q) 
{
  this.uploadFile = function(file, codigo,ruta)
  {
    var deferred = $q.defer();
    var formData = new FormData();
    formData.append("codigo", codigo);
    formData.append("file", file);
    return $http.post(ruta, formData, 
     {
      headers: {
        "Content-type": undefined
      },
      transformRequest: angular.identity
    }

    )

    .success(function(res)
    {
      deferred.resolve(res);
    })
    .error(function(msg, code)
    {
      deferred.reject(msg);
    })
    return deferred.promise;
  } 

}])