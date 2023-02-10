angular.module("rehabi",['ngRoute'])
.controller('rehabiCtrl',['$scope','$http','$routeParams',function($scope,$http,$routeParams){

	if ($scope.sgh_v_user === undefined){$scope.cerrarsecion();}
$scope.Fecha = new Date();
$scope.datosAguardar={
 mfr_horari:null,
 mfr_turnmt:null,
};
//datos que estraigo de los campos para guardar
$scope.encabesado={};// cargo datos de la historai clinica
$scope.mensaje=false ;
//variables de paginacion

$scope.posicion=null;// guarda el total de items de la tabla
$scope.pagina=1; // variable de paginas a mostrar	
/////////////// 
$scope.titulo="Nueva Rehabilitación";// titulo del modal
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
$scope.totaloral=0;
$scope.actu=function(){
   $http.post('src/sgh/rehabilitacion/php/sghListaRehabilitacion.php',{op:1,idhc:$scope.histoclinica}).success(function (data) {
		if (data.error === "error") {console.log(data);} 
		else
		{       
        $scope.rehabi = data;
 		$scope.posicion=Math.ceil(data.length / $scope.totalpaginas);
      	}
      	console.log(data);
     }); 
}
if ($scope.histoclinica === null){
  //alert("Escoja un pacinete");
  window.location = "#/"
}else{
$scope.actu();
}
///
 $scope.formp=true;
 $scope.forms=false;

// Cargar encabesado
$scope. paginas = function(tipo)
{if (tipo == 0 && $scope.pagina  > 1 ){$scope.pagina-=1;}
 else if (tipo == 1 && $scope.pagina < $scope.posicion ){$scope.pagina+=1;}
}

// GUARDAR DATOS
$scope.cancelar = function(){
	    $scope.titulo="Nueva Rehabilitación";// titulo del modal
		$scope.op="nuevo";
		$("#closemodal").click()
		$scope.datosAguardar={
		    mfr_horari:null,
 			mfr_turnmt:null,
			};
    	}
 $scope.actguarda=false;
$scope.guardar = function(){ $scope.actguarda=true;
	if ($scope.datosAguardar.mfr_horari == null || $scope.datosAguardar.mfr_turnmt == null ){
		$scope.text = "Complete datos";
		$scope.mensaje= true;
 		setTimeout(function() 
				{
          $scope.mensaje= false; $scope.actguarda=false;
		  $scope.$apply();
           
   		  }, 1500);
	}
	else
	{
	  //alert("datos llenos");
	  $http.post('src/sgh/rehabilitacion/php/sghInserRehabilitacion.php',{op:1,reha:$scope.datosAguardar, hcl:$scope.histoclinica, usu:$scope.usuario}).success(function(data){	
       $scope.text = data.sgh_reahbilitacion_ingreso_pa;
			 $scope.mensaje= true;
			 
      setTimeout(function() 
				{
          $scope.mensaje= false;
			$scope.$apply();
            $scope.cancelar();
          $scope.actu();
   		  }, 1500);
		
	     });
	   }
	}

//////////////////////////////////////////////////////

$scope.fechas=function(codigo){
 	$http.post('src/sgh/rehabilitacion/php/sghListaRehabilitacion.php',{op:2, codigo:codigo}).success(function (data) {
		 $scope.horario=data;
	});
}
 $scope.mensaje2= false; 
$scope.guardavisista= function(codigo){
$http.post('src/sgh/rehabilitacion/php/sghInserRehabilitacion.php',{op:3, id:codigo,usu:$scope.usuario}).success(function(data){

		   $scope.text2 = data.sgh_horario_ingreso_pa;	   
			$scope.datosAguardar={};
			 $scope.mensaje2= true; 
			 setTimeout(function() 
			 {
				$scope.mensaje2= false;				
				$scope.$apply();
			 }, 1500);	
			 console.log(data);
	});
}
$scope.edita=function(codigo){
  $scope.titulo="Editar Rehabilitación";
  $scope.op="editar";
  $scope.id=codigo;
  // LLENA DATOS DE EDICION
  $http.post('src/sgh/rehabilitacion/php/sghListaRehabilitacion.php',{op:3,codigo:codigo,fech:$scope.Fecha,usu:$scope.usuario}).success(function (data) {
     console.log(data);
     if (data != "0")
      {  
      	$scope.datosAguardar={
      		mfr_di_pk:data[0].mfr_di_pk,
			mfr_diagno:data[0].mfr_diagno,
			mfr_fecha:new Date(data[0].mfr_fecha),
			mfr_horari:data[0].mfr_horari,
			mfr_turnmt:data[0].mfr_turnmt,
			mer_terapi:data[0].mer_terapi,
         };
         $("#n").click()
      }else{
         alert("Lo Sentimos, ya pasaron más de 24 horas");
       $scope.cancelar();
      }
      
     });   
}
$scope.actualizar=function(){
	  $http.post('src/sgh/rehabilitacion/php/sghInserRehabilitacion.php',{op:2,reha:$scope.datosAguardar, hcl:$scope.histoclinica, usu:$scope.usuario}).success(function(data){	
       $scope.text = data.sgh_reahbilitacion_ingreso_pa;		
       $scope.mensaje= true;
			setTimeout(function(){
				$scope.mensaje= false;
				$scope.$apply();
				$scope.cancelar();
          		$scope.actu();   
			},1500);
				//console.log(data); 
		});
		
	}
}]);

