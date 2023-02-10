angular.module("imagenologia",['ngRoute'])
.controller('imagenologiaCtrl',['$scope','$http','$routeParams','upload',function($scope,$http,$routeParams,upload){

$scope.Fecha = new Date();
    if ($scope.sgh_v_user === undefined){$scope.cerrarsecion();}

$scope.datosAguardar={
     ima_fecmu:new Date(),
     ima_radior: false, ima_tomogr: false, ima_resona: false, ima_ecogra: false, ima_preced: false, ima_mamoga: false, ima_otros: false, ima_puemov: false, ima_pureve: false, ima_meprex: false, ima_toraca: false
			};
$scope.diagnostico={
              predef:null,
        predef2:null,
        predef3:null,
        predef4:null,
        predef5:null,
        predef6:null,
};  

//datos que estraigo de los campos para guardar
$scope.mensaje=false ;
$scope.cat=1;
//variables de paginacion

$scope.posicion=null;// guarda el total de items de la tabla
$scope.pagina=1; // variable de paginas a mostrar
//cargar datos con json

$scope.actu=function(){
   $http.post('src/sgh/imagenologia/php/sghListaImagenologia.php',{op:'1',idhc:$scope.histoclinica}).success(function (data) {
    if (data.error === "error") {console.log(data);}else{
    $scope.imagenologia = data;
 		$scope.posicion=Math.ceil(data.length / $scope.totalpaginas);
 		  }
   }); 

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
$scope.image=function(id){
    //alert(id);
      $scope.datos=true;  
      $scope.tabla=false;  
    $http.post('src/sgh/imagenologia/php/sghListaImagenologia.php',{op:'2',idhc:$scope.histoclinica, codigo:id}).success(function (data) {
   $scope.datosAguardar = {
      ima_descri:data[0].ima_descri,
      ima_ecogra:data[0].ima_ecogra,
      ima_fecha:data[0].ima_fecha,
      ima_fecmu:data[0].ima_fecmu,
      ima_mamoga:data[0].ima_mamoga,
      ima_meprex:data[0].ima_meprex,
      ima_motsol:data[0].ima_motsol,
      ima_otros:data[0].ima_otros,
      ima_priori:data[0].ima_priori,
      ima_proced:data[0].ima_proced,
      ima_puemov:data[0].ima_puemov,
      ima_pureve:data[0].ima_pureve,
      ima_radior:data[0].ima_radior,
      ima_rescli:data[0].ima_rescli,
      ima_resona:data[0].ima_resona,
      ima_tomogr:data[0].ima_tomogr,
      ima_toraca:data[0].ima_toraca
    };

    console.log(data);
      });
    $http.post('src/sgh/imagenologia/php/sghListaImagenologia.php',{op:'3', codigo:id}).success(function (data) {
    $scope.cie10=data; 

    console.log(data);
     }); 

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
      $scope.cie102=false;
      $scope.cie103=false;
      $scope.cie104=false;
      $scope.cie105=false;
      $scope.cie106=false;
      $scope.detalle={};
      $scope.detalle2={};
      $scope.detalle3={};
      $scope.detalle4={};
      $scope.detalle5={};
      $scope.detalle6={};
      $scope.codigo=null;
      $scope.codigo2=null;
      $scope.codigo3=null;
      $scope.codigo4=null;
      $scope.codigo5=null;
      $scope.codigo6=null;
      
      $scope.diagnostico={
                predef:null,
                predef2:null,
                predef3:null,
                predef4:null,
                predef5:null,
                predef6:null,
      }; 

     $("#closemodal").click()
		 $scope.actu();
     $scope.datosAguardar={
     ima_fecmu:new Date(),
     ima_radior: false, ima_tomogr: false, ima_resona: false, ima_ecogra: false, ima_preced: false, ima_mamoga: false, ima_otros: false, ima_puemov: false, ima_pureve: false, ima_meprex: false, ima_toraca: false
      };
		
}



// GUARDAR DATOS

$scope.guardar = function(){
        $http.post('src/sgh/imagenologia/php/sghInserImagenologia.php',{op:1,hcl: $scope.histoclinica ,usu:$scope.usuario,cama:$scope.cama, ima:$scope.datosAguardar, eti:$scope.entidad}) .success(function(data){ 
         $scope.text = data.sgh_imagenologia_ingreso_pa;
         $scope.mensaje= true;
          
          setTimeout(function() 
          {
            $scope.mensaje= false;
            $scope.$apply();
           // $("#closemodal").click();
           //$scope.cancelar();
          }, 2000);
          $scope.dingreso();
         console.log(data);
        });  
     }

$scope.dingreso=function(){
   $scope.ingreso="INGRESO";
  //alert("diagnostico");
   if ($scope.codigo != null && $scope.detalle != null){
      $http.post('src/sgh/imagenologia/php/sghInserImagenologia.php',{resp:$scope.diagnostico.predef, c10:$scope.detalle, tip:$scope.ingreso ,op:2}).success(function(data)
       {
       console.log(data); 
     });
        }
  
    if ($scope.codigo2 != null && $scope.detalle2 != null ){
    
            $http.post('src/sgh/imagenologia/php/sghInserImagenologia.php',{resp:$scope.diagnostico.predef2, c10:$scope.detalle2, tip:$scope.ingreso , op:2}).success(function(data)
          { 
         });
      }
    if ($scope.codigo3 != null && $scope.detalle3 != null){
     
      
           $http.post('src/sgh/imagenologia/php/sghInserImagenologia.php',{resp:$scope.diagnostico.predef3, c10:$scope.detalle3, tip:$scope.ingreso ,op:2}).success(function(data)
             {  
           });

    }
    if ($scope.codigo4 != null  && $scope.detalle4 != null ){
            $http.post('src/sgh/imagenologia/php/sghInserImagenologia.php',{resp:$scope.diagnostico.predef4, c10:$scope.detalle4, tip:$scope.ingreso ,op:2}).success(function(data)
           {  
         });

     
    }
    if ($scope.codigo5 != null  && $scope.detalle5 != null){
          $http.post('src/sgh/imagenologia/php/sghInserImagenologia.php',{resp:$scope.diagnostico.predef5, c10:$scope.detalle5, tip:$scope.ingreso ,op:2}).success(function(data)
           {  
         });
    }
    if ($scope.codigo6 != null && $scope.detalle6 != null ){
          $http.post('src/sgh/imagenologia/php/sghInserImagenologia.php',{resp:$scope.diagnostico.predef6, c10:$scope.detalle6, tip:$scope.ingreso ,op:2}).success(function(data)
           {  
         });
    }
  }
   //////////////////////////////
    $scope.cie102=false;
  $scope.cie103=false;
  $scope.cie104=false;
  $scope.cie105=false;
  $scope.cie106=false;

  
$scope.cie10 =function(c10,op){
  ////ingreso 
  if (op==1){
  $http.get('src/sgh/anamnesis/php/sghGetcie10.php?c='+ c10).success(function(data){
       if (data != "null"){
        $scope.detalle=data;
        $scope.cie102=true;
       }else{
       alert("Codigo cie10 no encontrado");
       }
  });
  }
  if (op==2){
  $http.get('src/sgh/anamnesis/php/sghGetcie10.php?c='+ c10).success(function(data){
       if (data !=  "null"){
          $scope.detalle2=data;
       $scope.cie103=true;
       }else{
       alert("Codigo cie10 no encontrado");
       }
  });
  }
  if (op==3){
  $http.get('src/sgh/anamnesis/php/sghGetcie10.php?c='+ c10).success(function(data){
      
       if (data !=  "null"){
           $scope.detalle3=data;
        $scope.cie104=true;}
        else{
       alert("Codigo cie10 no encontrado");
      
       }
  });
  }
  if (op==4){
  $http.get('src/sgh/anamnesis/php/sghGetcie10.php?c='+ c10).success(function(data){
        if (data !=  "null"){
         $scope.detalle4=data;
             $scope.cie105=true;
       }
       else {alert("Codigo cie10 no encontrado");
       }
  });
  }
  if (op==5){
  $http.get('src/sgh/anamnesis/php/sghGetcie10.php?c='+ c10).success(function(data){
       
        if (data !=  "null"){
          $scope.detalle5=data;
          $scope.cie106=true;}else{
       alert("Codigo cie10 no encontrado");
       }
  });
  }
  if (op==6){
  $http.get('src/sgh/anamnesis/php/sghGetcie10.php?c='+ c10).success(function(data){
       
        if (data !=  "null"){
        $scope.detalle6=data;
       $scope.cie107=true;}else{  
        alert("Codigo cie10 no encontrado");
       }
  });
  }
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
  this.uploadFile = function(file, name)
  {
    var deferred = $q.defer();
    var formData = new FormData();
    formData.append("name", name);
    formData.append("file", file);
    return $http.post("src/sgh/imagenologia/php/con_sube.php", formData,
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