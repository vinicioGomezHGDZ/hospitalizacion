angular.module("problemas",['ngRoute'])
.controller('problemasCtrl',['$scope','$http','$routeParams',function($scope,$http,$routeParams,ModalService){

    if ($scope.sgh_v_user === undefined){$scope.cerrarsecion();}
$scope.Fecha = new Date();
$scope.combo={}; // variable donde se cargar el combo box

	// array de estado 

$scope.datosAguardar={pbl_edad:$scope.pbl_edad};//datos que estraigo de los campos para guardar
$scope.mensaje=false ;

//variables de paginacion

$scope.posicion=null;// guarda el total de items de la tabla
$scope.pagina=1; // variable de paginas a mostrar	 

//cargar datos con json
    
$scope.actu=function(){
   $http.post('src/sgh/problemas/php/sghListaProblemas.php',{op:1,idhc:$scope.histoclinica}).success(function (data) {
       if (data.error === "error") {console.log(data);}else{
        $scope.problemas = data;
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
    if (tipo == 0 && $scope.pagina  > 1 ) {$scope.pagina-=1;}
    else if (tipo == 1 && $scope.pagina < $scope.posicion ) {$scope.pagina+=1;}

   }
// $scope.men=function(){$scope.mensaje= true;}

$scope.cancelar = function(){
     $scope.actu();
		 $("#closemodal").click();
      $scope.titulo="Nuevo Registro";// titulo del modal
      $scope.op="nuevo";
      $scope.datosAguardar={};
     
    	}
$scope.actguarda=false;
$scope.guardar = function(){$scope.actguarda=true;
	$http.post('src/sgh/problemas/php/sghInserProblemas.php',{op:1,scd:$scope.datosAguardar, hcl:$scope.histoclinica, usu:$scope.usuario}).success(function(data){	
       $scope.text = data.sgh_problemas_ingreso_pa;
			 $scope.mensaje= true;
			 
       setTimeout(function() 
				{
          $scope.mensaje= false;$scope.actguarda=false;
					$scope.$apply();
          $scope.cancelar(); 
           $scope.actu();  
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
   $http.post('src/sgh/problemas/php/sghListaProblemas.php',{op:2, codigo:codigo,usu:$scope.usuario}).success(function (data) {
     if (data != "0")
      {  
         $scope.datosAguardar={
            pbl_edad:data[0].pbl_edad,
            pbl_fecini:new Date(data[0].pbl_fecini),
            pbl_fecdet:new Date(data[0].pbl_fecdet),
            pbl_antece:data[0].pbl_antece,
            pbl_actpasi:data[0].pbl_actpasi,
            pbl_sindro:data[0].pbl_sindro,
            pbl_id_pk:data[0].pbl_id_pk,
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
  $http.post('src/sgh/problemas/php/sghInserProblemas.php',{op:2,scd:$scope.datosAguardar,usu:$scope.usuario}).success(function(data){
       $scope.text = data.sgh_problemas_ingreso_pa;
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