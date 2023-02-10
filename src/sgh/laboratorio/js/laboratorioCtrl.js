angular.module("laboratorio",['ngRoute'])
.controller('laboratorioCtrl',['$scope','$http','$routeParams',function($scope,$http,$routeParams){
    if ($scope.sgh_v_user === undefined){$scope.cerrarsecion();}
$scope.Fecha = new Date();
    $scope.activa_desactiva=function(op) {
        if (op === "null") {return true;}
        else {return false;}
    }
$scope.activa=function(id){
	//alert(id);
	if (id === ""){$scope.otros=true;	}else{$scope.otros=false;}}

$scope.datosAguardar={
			};
$scope.datoslaboratorio={
	lab_fecmu: $scope.Fecha,
    lab_priori:""
};			

//datos que estraigo de los campos para guardar
$scope.mensaje=false ;
$scope.cat=1;
//variables de paginacion

$scope.posicion=null;// guarda el total de items de la tabla
$scope.pagina=1; // variable de paginas a mostrar
//cargar datos con json

$scope.actu=function(){
   $http.post('src/sgh/laboratorio/php/sghListaLaboratorio.php',{op:'1', idhc:$scope.histoclinica}).success(function (data) {
    if (data.error === "error") {console.log(data);}
    else{
    $scope.laboratorio = data;
 		$scope.posicion=Math.ceil(data.length / $scope.totalpaginas);
 		}
    console.log(data);
     }); 

   	 $http.post('src/sgh/laboratorio/php/SghgetLaboratorio.php',{op:'1', cat:'1'}).success(function (data) {
      if (data.error === "error") {console.log(data);}
    else{ 
        $scope.hematologia = data;
 		}
     }); 
     
     $http.post('src/sgh/laboratorio/php/SghgetLaboratorio.php',{op:'1', cat:'5'}).success(function (data) {
      if (data.error === "error") {console.log(data);}
    else{  
      $scope.serologia = data;
 		}
     }); 
     $http.post('src/sgh/laboratorio/php/SghgetLaboratorio.php',{op:'1', cat:'2'}).success(function (data) {
        if (data.error === "error") {console.log(data);}
    else{
      $scope.uroanalisis = data;
 		  }
     }); 
     $http.post('src/sgh/laboratorio/php/SghgetLaboratorio.php',{op:'1', cat:'4'}).success(function (data) {
       if (data.error === "error") {console.log(data);}
      else{
      $scope.coprologico = data;
       }	  	
     });
      $http.post('src/sgh/laboratorio/php/SghgetLaboratorio.php',{op:'1', cat:'3'}).success(function (data) {
        if (data.error === "error") {console.log(data);}
    else{
      $scope.quimica = data;
 		  }
     });
      $http.post('src/sgh/laboratorio/php/SghgetLaboratorio.php',{op:'1', cat:'6'}).success(function (data) {
       if (data.error === "error") {console.log(data);}
    else{
        $scope.bacterio = data;
 	  	}
     }); 

    $http.post('src/sgh/laboratorio/php/SghgetLaboratorio.php',{op:'1', cat:'7'}).success(function (data) {
       if (data.error === "error") {console.log(data);}
      else{
         $scope.sangre = data;
        }
     }); 
      $http.post('src/sgh/laboratorio/php/SghgetLaboratorio.php',{op:'1', cat:'8'}).success(function (data) {
       if (data.error === "error") {console.log(data);}
       else{
      $scope.orina = data;
        }
     }); 
    $http.post('src/sgh/laboratorio/php/SghgetLaboratorio.php',{op:'1', cat:'9'}).success(function (data) {
      if (data.error === "error") {console.log(data);}
       else{
      $scope.heces = data;
        }
     });
     $http.post('src/sgh/laboratorio/php/SghgetLaboratorio.php',{op:'1', cat:'10'}).success(function (data) {
      if (data.error === "error") {console.log(data);}
      else{
      $scope.estudioliquido = data;
        }
     });
}
/////////////// cargar encabezado
if ($scope.histoclinica === null){
  //alert("Escoja un pacinete");
  window.location = "#/"
}else{
$scope.actu	();		
}

///////////
$scope.rutina=true;
$scope.urge=false;
$scope.nusol=true;
$scope.urgente=function(){
if ($scope.datoslaboratorio.lab_priori === 'URGENTE'){ $scope.urge=true; $scope.rutina=false;}else{$scope.urge=false;$scope.rutina=true;}
}

$scope. paginas = function(tipo)
{if (tipo == 0 && $scope.pagina  > 1 ){$scope.pagina-=1;}
 else if (tipo == 1 && $scope.pagina < $scope.posicion ){$scope.pagina+=1;}
}
 $scope.titulo="Nueva Solicitud de laboratorio ";
// GUARDAR DATOS
$scope.cancelar = function(){
		    $("#closemodal").click()
		    $scope.actu();
$scope.datosAguardar={};
$scope.datoslaboratorio={
  lab_fecmu: $scope.Fecha,
    lab_priori:""
};      
	
		$scope.nusol=true;
     $scope.vsla=false;
      $scope.titulo="Nueva Solicitud de laboratorio ";
	    	  }
	    	  $scope.actguarda=false;
$scope.guardar = function()
  {	$scope.actguarda=true;
    //guardar laboratorio
      if ($scope.datoslaboratorio.lab_priori === "" )
      {
          $scope.text = "Seleccionar Prioridad";
          setTimeout(function(){
              $scope.mensaje= false;$scope.actguarda=false;
              $scope.$apply();
          },1500);
      }
      else {
     $http.post('src/sgh/laboratorio/php/sghInserLaboratorio.php',{lab:$scope.datoslaboratorio, hcl:$scope.histoclinica, usu:$scope.usuario, cama:$scope.cama, eti:$scope.entidad ,op:1}).success(function(data){	
             $scope.text = data.sgh_solilaboratorio_ingreso_pa;
			 $scope.mensaje= true;
           
           setTimeout(function(){
            $scope.mensaje= false;
			$scope.$apply();
			$scope.examen();
            $scope.cancelar();

   		  	},1500);
         console.log(data);
    });
      }
   }

$scope.examen=function(){
/// GUARDADO EXAMENES
     $http.post('src/sgh/laboratorio/php/sghInserLaboratorio.php',{lab:$scope.datosAguardar ,op:2}).success(function(data){	

        // console.log(data);
    }); 
}

$scope.labodatos=function(id){
      $scope.titulo="Solicitudes a realizar";
      $scope.nusol=false;
      $scope.vsla=true;
     $http.post('src/sgh/laboratorio/php/SghgetLaboratorio.php',{op:'2', codigo:id}).success(function (data) {
        $scope.datoslaboratorio = data;
         console.log(data);
     }); 

}

}]);

