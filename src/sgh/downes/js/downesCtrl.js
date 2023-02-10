angular.module("downes",['ngRoute'])
.controller('downesCtrl',['$scope','$http','$routeParams',function($scope,$http,$routeParams,ModalService){

    if ($scope.sgh_v_user === undefined){$scope.cerrarsecion();}
$scope.Fecha = new Date();

	// array de estado 

$scope.datosAguardar={
scd_sibila:0,
scd_tiraje:0,
scd_frespi:0,
scd_frecar:0,
scd_ventil:0,
scd_cianos:0,
};//datos que estraigo de los campos para guardar
$scope.mensaje=false ;

//variables de paginacion

$scope.posicion=null;// guarda el total de items de la tabla
$scope.pagina=1; // variable de paginas a mostrar	 

//cargar datos con json
    
$scope.actu=function(){
   $http.post('src/sgh/downes/php/sghListaDownes.php',{op:1,idhc:$scope.histoclinica}).success(function (data) {
        if (data.error === "") {console.log(data);}else{
           $scope.downes = data;
 		    $scope.posicion=Math.ceil(data.length / $scope.totalpaginas);
        }
     }); 
}
if ($scope.histoclinica === null){
  //alert("Escoja un pacinete");
  window.location = "#/";
  $scope.actu();
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
		$("#closemodal").click();
      $scope.titulo="Nuevo Registro";// titulo del modal
      $scope.actu();
      $scope.op="nuevo";
      $scope.datosAguardar={scd_sibila:0,
scd_tiraje:0,
scd_frespi:0,
scd_frecar:0,
scd_ventil:0,
scd_cianos:0,};
    	}
$scope.actguarda=false;
$scope.guardar = function(){$scope.actguarda=true;
	$http.post('src/sgh/downes/php/sghInserDownes.php',{op:1,scd:$scope.datosAguardar, hcl:$scope.histoclinica, usu:$scope.usuario}).success(function(data){	
       $scope.text = data.sgh_dawnes_ingreso_pa;
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

$scope.edita=function(codigo){
  $scope.titulo="Editar Registro";
  $scope.op="editar";
  $scope.condi=false;
  // LLENA DATOS DE EDICION
   $http.post('src/sgh/downes/php/sghListaDownes.php',{op:2, codigo:codigo,usu:$scope.usuario}).success(function (data) {
     if (data != "0")
      {  
         $scope.datosAguardar={
            scd_sibila:parseInt(data[0].scd_sibila) ,
            scd_tiraje:parseInt(data[0].scd_tiraje) ,
            scd_frespi:parseInt(data[0].scd_frespi) ,
            scd_frecar:parseInt(data[0].scd_frecar) ,
            scd_ventil:parseInt(data[0].scd_ventil) ,
            scd_cianos:parseInt(data[0].scd_cianos),
            scd_total:data[0].scd_total,
            scd_id_pk:data[0].scd_id_pk,
                  }
         $("#n").click()
      }else
      {
          alert("Lo Sentimos, ya pasaron más de 24 horas");
      }
      console.log(data);
     });   
}
$scope.actualizar=function(){
  $http.post('src/sgh/downes/php/sghInserDownes.php',{op:2,scd:$scope.datosAguardar, usu:$scope.usuario}).success(function(data){
       $scope.text = data.sgh_dawnes_ingreso_pa;
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