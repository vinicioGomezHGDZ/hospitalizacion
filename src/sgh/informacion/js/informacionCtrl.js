angular.module("informa",['ngRoute'])
.controller('informaCtrl',['$scope','$http','$routeParams',function($scope,$http,$routeParams){
	if ($scope.sgh_v_user === undefined){$scope.cerrarsecion();}

$scope.Fecha = new Date();
$scope.getpun={};
$scope.datosAguardar={
	inp_llamar:"911",
	inp_aseo: null,
 inp_fpcita: null,
 inp_llamar: null
};//datos que estraigo de los campos para guardar
$scope.mensaje=false ;
//variables de paginacion

$scope.posicion=null;// guarda el total de items de la tabla
$scope.pagina=1; // variable de paginas a mostrar	 

/// Accion si edita o guarda registro 
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
   $http.post('src/sgh/informacion/php/sghListaInformacion.php',{idhc:$scope.histoclinica , op:1}).success(function (data) {
        if (data.error === "error") {console.log(data);}
        else{	
        $scope.informacion = data;
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

 $scope. paginas = function(tipo) {if (tipo == 0 && $scope.pagina  > 1 ){$scope.pagina-=1;}else if (tipo == 1 && $scope.pagina < $scope.posicion ){$scope.pagina+=1;}}

// GUARDAR DATOS
$scope.cancelar = function(){
		    $("#closemodal").click();
		     $scope.titulo="Nuevo Registro";
			 $scope.op="nuevo";
             $scope.actu();
             $scope.datosAguardar={
	           inp_cuides :null,
	           inp_aseo: null,
	           inp_reposo: null,
	           inp_alimen: null,
	           inp_ldhace: null,
	           inp_indica: null,
	           inp_fpcita: null,
	           inp_llamar: null
	         };
    	}
$scope.actguarda=false;
$scope.guardar = function(){$scope.actguarda=true;
  $http.post('src/sgh/informacion/php/sghInserInformacion.php',{inf:$scope.datosAguardar, hcl:$scope.histoclinica, usu:$scope.usuario, op:1}).success(function(data){	
       $scope.text = data.sgh_informacion_ingreso_pa;
			 $scope.mensaje= true;
         setTimeout(function() 
	    	{
             $scope.mensaje= false;$scope.actguarda=false;
			 $scope.$apply();
             $scope.cancelar();
   		  }, 1500);
	     });
	   }
/// edicón de datos 

$scope.edita=function(codigo){
	$scope.titulo="Editar Registro";
	$scope.op="editar";

// LLENA DATOS DE EDICION
$http.post('src/sgh/informacion/php/sghListaInformacion.php',{op:2, codigo:codigo,usu:$scope.usuario}).success(function (data) {

     if (data != "0")
      {  
            $scope.datosAguardar={
				inp_alimen:data[0].inp_alimen, 
				inp_aseo:data[0].inp_aseo, 
				inp_cuides:data[0].inp_cuides, 
				inp_fecha:new Date(data[0].inp_fecha),
				inp_fpcita:new Date(data[0].inp_fpcita),
				inp_id_pk:data[0].inp_id_pk,
				inp_indica:data[0].inp_indica, 
				inp_ldhace:data[0].inp_ldhace, 
				inp_llamar:parseInt(data[0].inp_llamar),
				inp_reposo:data[0].inp_reposo, 
            }

            $("#n").click();
      }
      else
      {
          alert("Lo Sentimos ya pasaron más de 24 horas");
       $scope.cancelar();
      }
	});
}
$scope.actualizar = function(){
$http.post('src/sgh/informacion/php/sghInserInformacion.php',{inf:$scope.datosAguardar, op:2,usu:$scope.usuario}).success(function(data){

		   $scope.text = data.sgh_informacion_ingreso_pa;	   
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

////////////////// ver datos e imprimir //////// 

$scope.tabla=true;
$scope.datos=false;
$scope.formulario=true;
$scope.cabesera=false;	
$scope.regreesar=function(){
	$scope.cancelar();
	$scope.tabla=true;
    $scope.datos=false;
    $scope.formulario=true;
	$scope.cabesera=false;
}

/// 
$scope.verdatos=function(id){
	$scope.tabla=false;
	$scope.datos=true;
	$http.post('src/sgh/informacion/php/sghListaInformacion.php',{op:3, codigo:id}).success(function (data) {

	        $scope.datosAguardar={
				inp_alimen:data[0].inp_alimen, 
				inp_aseo:data[0].inp_aseo, 
				inp_cuides:data[0].inp_cuides, 
				inp_fecha:new Date(data[0].inp_fecha),
				inp_fpcita:new Date(data[0].inp_fpcita),
				inp_id_pk:data[0].inp_id_pk,
				inp_indica:data[0].inp_indica, 
				inp_ldhace:data[0].inp_ldhace, 
				inp_llamar:parseInt(data[0].inp_llamar),
				inp_reposo:data[0].inp_reposo,
				per_nombres:data[0].per_nombres,
				per_apellidopaterno:data[0].per_apellidopaterno,
				per_apellidomaterno:data[0].per_apellidomaterno,	

    		}
      sconsole.log(data);
	});
} 
$scope.imprimir=function(id){
	$scope.tabla=false;
	$scope.formulario=false;
    $scope.datos=true;
    $scope.cabesera=true;
	$scope.verdatos(id);
	 $("#ocfooter").click();
	 $("#ocfooter").click();
	 setTimeout(function() 
		{
				$scope.mensaje= false;
				$scope.$apply();
	 		   //$("#print").click();

	    }, 500);
	    	
	 setTimeout(function() 
		{
				$scope.$apply();
	 		    $scope.regreesar();
	 		     $("#mofooter").click();
	 		     $("#mofooter").click();
	    }, 1000);	
}
}]);

