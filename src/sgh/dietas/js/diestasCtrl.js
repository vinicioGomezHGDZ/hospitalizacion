angular.module("dietas",['ngRoute'])
.controller('dietasCtrl',['$scope','$http','$routeParams',function($scope,$http,$routeParams,ModalService){

    if ($scope.sgh_user === undefined){$scope.cerrarsecion();}

$scope.Fecha = new Date();
$scope.combo={}; // variable donde se cargar el combo box

	// array de estado 

$scope.datosAguardar={};//datos que estraigo de los campos para guardar
$scope.mensaje=false ;

//variables de paginacion

$scope.posicion=null;// guarda el total de items de la tabla
$scope.pagina=1; // variable de paginas a mostrar	 

//cargar datos con json
    
$scope.actu=function(){
   $http.post('src/sgh/brander/php/sghListaBrander.php',{op:1,idhc:$scope.histoclinica}).success(function (data) {
        if (data.error === 'error') {console.log(data);}
        else
         { 
        $scope.brander = data;
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
		$("#closemodal").click();
      $scope.titulo="Nuevo Registro";// titulo del modal
      $scope.actu();
      $scope.op="nuevo";
      $scope.datosAguardar={};
    	}
    $scope.actguarda=false;
$scope.guardar = function(){
    $scope.actguarda=true;
	$http.post('src/sgh/brander/php/sghInserBrander.php',{op:1,tra:$scope.datosAguardar, hcl:$scope.histoclinica, usu:$scope.usuario, cam:$scope.cama}).success(function(data){	
       $scope.text = data.sgh_brander_ingreso_pa;
			 $scope.mensaje= true;
			 
       setTimeout(function() 
				{
          $scope.mensaje= false;
					$scope.$apply();
          $scope.cancelar();
                    $scope.actguarda=false;
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
    $scope.cancelar();
  }
}

$scope.edita=function(codigo){
  $scope.titulo="Editar Registro";
  $scope.op="editar";
  $scope.condi=false;
  // LLENA DATOS DE EDICION
   $http.post('src/sgh/brander/php/sghListaBrander.php',{op:2, codigo:codigo,usu:$scope.usuario}).success(function (data) {
     if (data != "0")
      {  
         $scope.datosAguardar={
             bra_percen:parseInt(data[0].bra_percen),
             bra_exphum:parseInt(data[0].bra_exphum),
             bra_activi:parseInt(data[0].bra_activi),
             bra_movili:parseInt(data[0].bra_movili),
             bra_nutric:parseInt(data[0].bra_nutric),
             bra_rilecu:parseInt(data[0].bra_rilecu),
             bra_califi:parseInt(data[0].bra_califi),
             bra_id_pk:data[0].bra_id_pk
        }
         $("#n").click()
      }else
      {
       alert("Lo Sentimos ya pasaros + de 24 horas");
      }
      console.log(data);
     });   
}
$scope.actualizar=function(){

  $http.post('src/sgh/brander/php/sghInserBrander.php',{op:2,tra:$scope.datosAguardar}).success(function(data){  
       $scope.text = data.sgh_brander_ingreso_pa;
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