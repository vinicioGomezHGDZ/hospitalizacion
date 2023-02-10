angular.module("histopatologia",['ngRoute'])
.controller('histopatologiaCtrl',['$scope','$http','$routeParams',function($scope,$http){
    if ($scope.sgh_v_user === undefined){$scope.cerrarsecion();}
$scope.Fecha = new Date();

    $scope.activa_desactiva=function(op) {
        if (op === "null") {return true;}
        else {return false;}
    }
$scope.datosAguardar={
     his_histop: false, 
     his_citolo: false, 
     his_endoce: false, 
     his_exocer: false, 
     his_parvag: false, 
     his_unesco: false, 
     his_muncer: false, 
     his_otrmat: false, 
     his_terhor: false, 
     his_otrant: false, 
     his_ligadu: false, 
     his_diu: false, 
     his_orainy: false, 
     his_menarq: 0, 
     his_menopa: 0, 
     his_inrese: 0, 
     his_gestac: 0, 
     his_partos: 0, 
     his_aborto: 0, 
     his_cesare: 0, 
     his_ultmes: null, 
     his_ultpar: null, 
     his_ultcit: null,
    mic_intran:false,
    mic_cuales:null,
    mic_comimu:false,
    mic_cual:null
};
//datos que estraigo de los campos para guardar
$scope.mensaje=false ;
$scope.cat=1;
//variables de paginacion

$scope.posicion=null;// guarda el total de items de l   a tabla
$scope.pagina=1; // variable de paginas a mostrar
//cargar datos con json

$scope.actu=function(){
   $http.post('src/sgh/histopatologia/php/sghListaHistopatologia.php',{op:'1',idhc:$scope.histoclinica}).success(function (data) {
   if (data.error === "error") {console.log(data);}else{
    $scope.histopatologia = data;
 		$scope.posicion=Math.ceil(data.length / $scope.totalpaginas);
      }
     });
    $http.get('src/sgh/cie10/php/sghListarc10.php').success(function (data) {
        $scope.datosc10 = data;
        console.log(data);
        $scope.posicion2=Math.ceil(data.length / $scope.totalpaginas);
    });

}
$scope.agregac10=function (valor) {
    $scope.codigo=valor;
    $scope.bc10=false;
    $scope.b_buscar=true;
}
$scope.bc10=false;
$scope.b_buscar=true;
$scope.buscac10=function () {
    $scope.bc10=true;
    $scope.b_buscar=true;
}
/////////////// cargar encabezado
if ($scope.histoclinica === null){
  //alert("Escoja un pacinete");
    window.location = "#/"
}else{
$scope.actu();		
}

///////////
$scope.regreesar=function(){ 
 $scope.datos=false;  
 $scope.tabla=true; 
 $scope.cancelar();
} 

$scope.tabla=true;
$scope.hist=function(id){
    //alert(id);

      $scope.datos=true;  
      $scope.tabla=false;  
    $http.post('src/sgh/histopatologia/php/sghListaHistopatologia.php',{op:'2',idhc:$scope.histoclinica, codigo:id}).success(function (data) {
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
      his_muestr:data[0].his_muestr,
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
    $scope.cargac10(id);


}

$scope.bool=function(valor){

  if (valor === "t"){
    var bool = true;
  }else{var bool = false;}
return bool;  
}


$scope. paginas = function(tipo)
{if (tipo == 0 && $scope.pagina  > 1 ){$scope.pagina-=1;}
 else if (tipo == 1 && $scope.pagina < $scope.posicion ){$scope.pagina+=1;}
}

// GUARDAR DATOS
$scope.cancelar = function(){
   // angular.element("input[type='file']").val(null);
      $scope.cie10 = [];
      $scope.datosAguardar={
             mic_intran:false,
             mic_cuales:null,
             mic_comimu:false,
             mic_cual:null,
             his_histop: false, 
             his_citolo: false, 
             his_endoce: false, 
             his_exocer: false, 
             his_parvag: false, 
             his_unesco: false, 
             his_muncer: false, 
             his_otrmat: false, 
             his_terhor: false, 
             his_otrant: false, 
             his_ligadu: false, 
             his_diu: false, 
             his_orainy: false, 
             his_menarq: 0, 
             his_menopa: 0, 
             his_inrese: 0, 
             his_gestac: 0, 
             his_partos: 0, 
             his_aborto: 0, 
             his_cesare: 0, 
             his_ultmes: null, 
             his_ultpar: null, 
             his_ultcit: null

      };        
        $("#closemodal").click()
		$scope.actu();
}



// GUARDAR DATOS
$scope.actguarda=false;
$scope.guardar = function(){$scope.actguarda=true;
        $http.post('src/sgh/histopatologia/php/sghInserHistopatologia.php',{op:1,hcl: $scope.histoclinica ,usu:$scope.usuario,cama:$scope.cama,mic:$scope.datosAguardar, eti:$scope.entidad}) .success(function(data){ 
         $scope.text = data.sgh_histopatologia_ingreso_pa;
         $scope.mensaje= true;
          
          setTimeout(function() 
          { $scope.dingreso();
            $scope.mensaje= false;$scope.actguarda=false;
            $scope.$apply();
           // $("#closemodal").click();
           $scope.cancelar();
          }, 2000);

         console.log(data);
        });  
     }
/////////////// datos de c10
    $scope.cie10 = [];

    $scope.c10_id_pk=0;
    $scope.c10nuevo=true;
    $scope.c10editar=false;
    // acciones a tomar
    $scope.rec_op="add";
    $scope.c10_accion=function(){
        if ($scope.rec_op === "add"){$scope.addc10();}
        if ($scope.rec_op === "upd"){$scope.updcie10();}
    }
    $scope.ec10_accion=function(){
        if ($scope.rec_op === "add"){$scope.nuevoc10();}
        if ($scope.rec_op === "upd"){$scope.updcie10();}
    }
    //agregar datos en el array
    $scope.addc10 = function(){
        $http.post('src/sgh/epicrisis/php/sghGetcie10.php',{codigo:$scope.codigo}).success(function(data){
            if (data != "null"){
                $scope.cie10.push({c10_id: $scope.c10_id_pk, c10_nombre:data[0].c10_nombre, c10_codigo:data[0].c10_codigo, dia_resp:'true', c10_id_pk:data[0].c10_id_pk});
                $scope.c10_id_pk=$scope.c10_id_pk+1;
            }else{
                alert("Codigo cie10 no encontrado");
            }
        });
        $scope.codigo="";
    };
    ///cargar datos del array
    $scope.edic10=function(id){
        $scope.rec_op="upd";
        $scope.rec_codi=id;
        $scope.codigo=$scope.cie10[ $scope.rec_codi].c10_codigo;
    }
    $scope.eedic10=function(id,id_dia){
        $scope.rec_op="upd";
        $scope.rec_codi=id;
        $scope.dia_id_pk=id_dia;
        $scope.codigo=$scope.cie10[ $scope.rec_codi].c10_codigo;
    }
    //editar datos  del array
    $scope.updcie10=function(id){
        $http.post('src/sgh/epicrisis/php/sghGetcie10.php',{codigo:$scope.codigo}).success(function(data){
            if (data != "null"){
                $scope.cie10[$scope.rec_codi]={c10_id_pk:data[0].c10_id_pk,c10_id: $scope.rec_codi, c10_nombre:data[0].c10_nombre, c10_codigo:data[0].c10_codigo, dia_resp:'true',dia_id_pk:$scope.dia_id_pk};
            }else{
                alert("Codigo cie10 no encontrado");
            }
        });
        $scope.codigo="";
        $scope.rec_op="add";
    }
    // ELIMINAR DATOS DE ARRAY DE CIE 10
    $scope.delec10=function(){
        $scope.cie10=[];
        $scope.c10_id_pk=0;
    }
    $scope.nuevoc10=function(){
        $http.post('src/sgh/epicrisis/php/sghGetcie10.php',{codigo:$scope.codigo}).success(function(data){
            if (data != "null"){

                $http.post('src/sgh/referencia/php/sghInserReferencia.php',{ref_id_pk:$scope.ref_id_pk , c10_id_pk:data[0].c10_id_pk, dia_resp:'true',op:5}).success(function(data)
                {
                    $scope.cargac10();
                    //console.log(data);
                });
            }else
            {
                alert("Codigo cie10 no encontrado");
            }
        });
    }
    $scope.com_string=function(valor){if (valor == true) {return 'true'}else{return 'false'}};
    $scope.cargac10=function(id){
        $http.post('src/sgh/histopatologia/php/sghListaHistopatologia.php',{op:3,codigo:id}).success(function (data) {
            $scope.cie10=[];
            for (var i = 0 ; i < data.length ; i++) {
                $scope.cie10.push({c10_id:i, c10_nombre:data[i].c10_nombre, c10_codigo:data[i].c10_codigo, dia_resp:$scope.com_string(data[i].dia_resp),dia_id_pk:data[i].dia_id_pk ,c10_id_pk:data[i].c10_id_pk});
            }
        });
    }

    $scope.dingreso=function(){
        if ($scope.cie10!= null){
            $http.post('src/sgh/histopatologia/php/sghInserHistopatologia.php',{c10:$scope.cie10 ,op:2}).success(function(data)
            {
            });
        }
    }

}])
/*
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
  this.uploadFile = function(file, name)
  {
    var deferred = $q.defer();
    var formData = new FormData();
    formData.append("name", name);
    formData.append("file", file);
      return $http.post("src/sgh/vihsida/php/sube_vihsertificado.php", formData,
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
}])*/