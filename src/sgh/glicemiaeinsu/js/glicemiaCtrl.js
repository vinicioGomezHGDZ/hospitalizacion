
angular.module("glicemia",['ngRoute'])
.controller('glicemiaCtrl',['$scope','$http','$routeParams',function($scope,$http,$routeParams,ModalService){
	if ($scope.sgh_v_user === undefined){$scope.cerrarsecion();}
$scope.Fecha = new Date();
$scope.datosAguardar= {hgi_fecha:timepicker1.value};//datos que estraigo de los campos para guardar
$scope.mensaje=false ;  

//variables de paginacion
$scope.posicion=null;// guarda el total de items de la tabla
$scope.pagina=1; // variable de paginas a mostrar	 


// accios de guardar o editar
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
//cargar datos con json
$scope.actu=function(){
   $http.post('src/sgh/glicemiaeinsu/php/sghListarGlicemia.php',{op:1,idhc:$scope.histoclinica}).success(function (data) {
 		    
         if(data.error === "error"){console.log(data);} 	
         else	{
          $scope.glicemia = data;
 		  $scope.posicion=Math.ceil(data.length / $scope.totalpaginas);
     	}
     }); 
}
if ($scope.histoclinica === null){
 // alert("Escoja un pacinete");
  window.location = "#/"
}else{
$scope.actu();
}
 $scope. paginas = function(tipo){if (tipo == 0 && $scope.pagina  > 1 ){$scope.pagina-=1;}else if (tipo == 1 && $scope.pagina < $scope.posicion ){$scope.pagina+=1;}}

// GUARDAR DATOS
//$scope.men=function(){$scope.mensaje= true;}

$scope.cancelar = function(){
		$("#closemodal").click()
        $scope.datosAguardar={hgi_fecha:timepicker1.value,hgi_totadm:null};
    	$scope.actu();
    	$scope.op="nuevo";
    	}

	$scope.actguarda=false;
$scope.guardar = function(){
	$scope.actguarda=true;
 	$http.post('src/sgh/glicemiaeinsu/php/sghInserGlicemai.php',{op:1, gli:$scope.datosAguardar, hcl:$scope.histoclinica, usu:$scope.usuario, cam:$scope.cama }).success(function(data){	
       $scope.text = data.sgh_glicemia_ingreso_pa;
			 $scope.mensaje= true;
       setTimeout(function() 
		{
          $scope.mensaje= false;$scope.actguarda=false;
		 $scope.$apply();
         $scope.cancelar();
   	     }, 1500);
		//console.log(data);
	});
	}

//EDICION DE datos//

$scope.edita=function(codigo){
	$scope.titulo="Editar Registro";
	$scope.op="editar";
	// LLENA DATOS DE EDICION
  $http.post('src/sgh/glicemiaeinsu/php/sghListarGlicemia.php',{op:2,codigo:codigo,usu:$scope.usuario}).success(function (data) {

			if (data != "0")
      {  
         $scope.datosAguardar={
	    	hgi_fecha:timepicker1.value,
	    	hgi_glicem:parseInt(data[0].hgi_glicem),
	    	hgi_esquem:parseInt(data[0].hgi_esquem),
	    	hgi_espaco:parseInt(data[0].hgi_espaco),
			hgi_totadm:new Date(data[0].hgi_dia),
	    	hgi_obcerv:data[0].hgi_obcerv,
	    	hgi_id_pk:data[0].hgi_id_pk,
	    	}
         $("#n").click()
      }else
      {
          alert("Lo Sentimos, ya pasaron más de 24 horas");
       $scope.cancelar();
      }
	  // console.og(data);		 
	});
}
$scope.actualizar = function(){
	$http.post('src/sgh/glicemiaeinsu/php/sghInserGlicemai.php',{op:2, gli:$scope.datosAguardar,usu:$scope.usuario}).success(function(data){
 		   $scope.text = data.sgh_glicemia_ingreso_pa;	   
			 $scope.mensaje= true; 
			 setTimeout(function() 
			 {
				$scope.mensaje= false;
				$scope.$apply();
			    $("#closemodal").click();
				$scope.titulo="Nuevo Registro";
				$scope.op="nuevo";
				$scope.cancelar();
			 }, 1500);	
		//console.log(data);
	});
}
}]);
