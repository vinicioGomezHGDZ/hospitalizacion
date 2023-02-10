angular.module("eventosadversos",['ngRoute'])
.controller('eventosadversosCtrl',['$scope','$http','$routeParams',function($scope,$http,$routeParams,ModalServicenew){
    if ($scope.sgh_v_user === undefined){$scope.cerrarsecion();}

$scope.Fecha = new Date();
$scope.combo={}; // variable donde se cargar el combo box
 	// array de estado
$scope.global=JSON.parse(localStorage.getItem("sgh_user"));
$scope.entidad=$scope.global.eta_id_pk;
$scope.datosAguardar={
    acp_ncorre:null,
    acp_npreve:null,
    acp_accion:null,
    fed_ocasio:null,
    fed_prodale:false,
    acp_acfuef:false

};//datos que estraigo de los campos para guardar
$scope.mensaje=false ;

//variables de paginacion

$scope.posicion=null;// guarda el total de items de la tabla
$scope.pagina=1; // variable de paginas a mostrar	 
$scope.tabla=true;
// convertir fecha
//acciones de visualizar datos 
$scope.ver=function(id){
$scope.tabla=false;
$scope.datos=true;

$scope.datosevento(id); 
}

$scope.regreesar=function(){ 
 $scope.datos=false;  
 $scope.tabla=true; 
 $scope.cancelar();
} 

$scope.datosevento=function(codigo){
  $http.post('src/sgh/eventosadversos/php/sghListaEventosadversos.php',{op:3, codigo:codigo}).success(function (data) {
           $scope.datosAguardar={
            acp_accion: data[0].acp_accion ,
            acp_accorr:data[0].acp_accorr,
            acp_acfuef:data[0].acp_acfuef,
            acp_acp_tipo:data[0].acp_acp_tipo,
            acp_descrip:data[0].acp_descrip,
            acp_feacor:new Date(data[0].acp_feacor),
            acp_fecha:new Date(data[0].acp_fecha),
            acp_fefire:(data[0].acp_fefire),
            acp_felim:new Date(data[0].acp_felim),
            acp_hallas:data[0].acp_hallas,
            acp_id_pk:data[0].acp_id_pk,
            acp_medica:data[0].acp_medica, 
            acp_ncorre:data[0].acp_ncorre,
            acp_npreve:data[0].acp_npreve,
            acp_nuacap:data[0].acp_nuacap,
            acp_por:data[0].acp_por,
            fed_desles:data[0].fed_desles,
            fed_fecha:data[0].fed_fecha,
            fed_id_pk:data[0].fed_id_pk,
            fed_medado:data[0].fed_medado,
            fed_ocasio:data[0].fed_ocasio,
            fed_prodale:data[0].fed_prodale,
            fed_relacon:data[0].fed_relacon,
            fed_tipcla:data[0].fed_tipcla,
        }
      });
}
//cargar datos con json
    
$scope.actu=function(){
   $http.post('src/sgh/eventosadversos/php/sghListaEventosadversos.php',{op:1,idhc:$scope.histoclinica}).success(function (data) {
        if (data.error === "error") {console.log(data);}else{
        $scope.eventosadversos = data;
 		    $scope.posicion=Math.ceil(data.length / $scope.totalpaginas);
        }
     }); 
}
if ($scope.histoclinica === null){
  //alert("Escoja un pacinete");
  window.location = "#/"
}else{
$scope.actu();
}
// paginacion de tabla
$scope. paginas = function(tipo)
  {
    if (tipo == 0 && $scope.pagina  > 1 )
      {
      $scope.pagina-=1;
      }
       else if (tipo == 1 && $scope.pagina < $scope.posicion )
       {
        $scope.pagina+=1;
      }

   }
// $scope.men=function(){$scope.mensaje= true;}

$scope.cancelar = function(){
       $scope.ver_fecha=true;

		$("#closemodal").click();
      $scope.titulo="Nuevo Registro";// titulo del modal
      $scope.actu();
      $scope.op="nuevo";
      $scope.datosAguardar={
         acp_ncorre:null,
         acp_npreve:null,
         acp_accion:null,
         fed_ocasio:null,
         fed_prodale:false,
         acp_acfuef:false,

      };
    	}
    $scope.actguarda=false;
$scope.guardar = function(){
    $scope.actguarda=true;
	$http.post('src/sgh/eventosadversos/php/sghInserEventosadversos.php',{op:1,tra:$scope.datosAguardar, hcl:$scope.histoclinica, usu:$scope.usuario, ser:$scope.servicio, eti:$scope.entidad}).success(function(data){	
       console.log('Datos a guardar: '+$scope.datosAguardar+ ' hcl: '+$scope.histoclinica+' usu: '+$scope.usuario+' servicio: '+$scope.servicio+' entidad: '+ $scope.entidad);
       $scope.text = data.sgh_eventosadversos_ingreso_pa;
			 $scope.mensaje= true;
			 
       setTimeout(function() 
				{
          $scope.mensaje= false;$scope.actguarda=false;
					$scope.$apply();
          $scope.cancelar();   
   		  }, 1500);
		//alert(data);
		console.log(data);
	});
	}
/////////////// Editar ///////
$scope.titulo="Nuevo Registro";// titulo del modal
$scope.op="nuevo";
$scope.accion=function(){
  if($scope.op === 'nuevo') { 
    $scope.guardar();
    }
  if($scope.op === 'editar') {
    $scope.actualizar();
  }
}
$scope.ver_fecha=true;
$scope.edita=function(codigo){
    $scope.ver_fecha=false;
  $scope.titulo="Editar Registro";
  $scope.op="editar";
  $scope.condi=false;
  // LLENA DATOS DE EDICION
   $http.post('src/sgh/eventosadversos/php/sghListaEventosadversos.php',{op:2, codigo:codigo, usu:$scope.usuario}).success(function (data) {
     if (data != "0")
      {  
         $scope.datosAguardar={
            acp_accion: data[0].acp_accion ,
            acp_accorr:data[0].acp_accorr,
            acp_acfuef:data[0].acp_acfuef,
            acp_acp_tipo:data[0].acp_acp_tipo,
            acp_descrip:data[0].acp_descrip,
            acp_feacor:new Date(data[0].acp_feacor),
            acp_fecha:new Date(data[0].acp_fecha),
            acp_fefire:(data[0].acp_fefire),
            acp_felim:new Date(data[0].acp_felim),
            acp_hallas:data[0].acp_hallas,
            acp_id_pk:data[0].acp_id_pk,
            acp_medica:data[0].acp_medica, 
            acp_ncorre:data[0].acp_ncorre,
            acp_npreve:data[0].acp_npreve,
            acp_nuacap:data[0].acp_nuacap,
            acp_por:data[0].acp_por,
            fed_desles:data[0].fed_desles,
            fed_fecha:data[0].fed_fecha,
            fed_id_pk:data[0].fed_id_pk,
            fed_medado:data[0].fed_medado,
            fed_ocasio:data[0].fed_ocasio,
            fed_prodale:data[0].fed_prodale,
            fed_relacon:data[0].fed_relacon,
            fed_tipcla:data[0].fed_tipcla,
            fed_fecha:new Date(data[0].fed_fecha),

        }
         $("#n").click()
      }else
      {
          alert("Lo Sentimos, ya pasaron más de 24 horas");
       $scope.cancelar();
      }
      console.log(data);
     });   
}
$scope.actualizar=function(){

  $http.post('src/sgh/eventosadversos/php/sghInserEventosadversos.php',{op:2,tra:$scope.datosAguardar,usu:$scope.usuario}).success(function(data){
       $scope.text = data.sgh_eventosadversos_ingreso_pa;
       $scope.mensaje= true;
       
       setTimeout(function() 
        {
          $scope.mensaje= false;
          $scope.$apply();
          $scope.cancelar();
        }, 1500);
    //alert(data);
    console.log(data);
  });

}

}]);
