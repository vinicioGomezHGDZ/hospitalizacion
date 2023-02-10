angular.module("dietas",['ngRoute'])



.controller('dietasCtrl',['$scope','$http','$routeParams',function($scope,$http,$routeParams,ModalService){

    if ($scope.sgh_v_user === undefined){$scope.cerrarsecion();}
    if ($scope.usu_perfil != 'NUTRICIÓN'){$scope.admi=true}
$scope.Fecha = new Date();
$scope.combo={}; // variable donde se cargar el combo box

	// array de estado 


    $scope.datosAguardar={
    };
$scope.mensaje=false ;

//variables de paginacion

$scope.posicion=null;// guarda el total de items de la tabla
$scope.pagina=1; // variable de paginas a mostrar	 

//cargar datos con json
    
$scope.actu=function(){
   $http.post('src/sgh/dietas/php/sghListadietas.php',{op:1,idhc:$scope.histoclinica}).success(function (data) {

       if (data.error === 'error') {console.log(data);}
        else
        {
            $scope.brander = data;
            $scope.posicion=Math.ceil(data.length / $scope.totalpaginas);
        }
    });
    $http.post('src/sgh/dietas/php/sghListadietas.php',{op:3,idhc:$scope.histoclinica}).success(function (data) {
        if (data.error === 'error') {console.log(data);}
        else
        {
            $scope.dieta = [];
            for($i=0; $i<data.length ; $i++) {
                $scope.dieta.push({die_id_fk: data[$i].die_id_pk, did_obce: "", die_descrip: data[$i].die_descrip,die_res:false});
            }

            // console.log(data);
        }
    });

}
if ($scope.histoclinica === null){
  //alert("Escoja un pacinete");
  window.location = "#/"
}else{
$scope.actu();
}
    $scope.de_dieta=[];
/// gargado de array de dietas


$scope.limpia=function () {
    $scope.de_dieta=[];
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
      $scope.de_dieta=[];
    $scope.gua=true;
    $scope.deop=false;
    $scope.verdietas=true;
    $scope.verelima=false;
    $scope.veradieta=false; $scope.reportevisa=false;
    }
    $scope.actguarda=false;
$scope.guardar = function(){
    $scope.actguarda=true;
	$http.post('src/sgh/dietas/php/sghInserdietas.php',{op:1,die:$scope.dieta, hcl:$scope.histoclinica, usu:$scope.usuario, cam:$scope.cama}).success(function(data){
       $scope.text = data.sgh_dieta_detalle_ingreso_pa;
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
$scope.titulo="Nuevo Registro de Pedido de dietas";// titulo del modal
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
    $scope.verdietas=true;
    $scope.verelima=false;
    $scope.veradieta=false;
$scope.editar=function (fecha) {
    $scope.op='editar';
    $scope.verdietas = true;
    $scope.veradieta=false;
    $scope.reportevisa=false;
    $scope.titulo = 'Editando Pedido de dieta';
    //$scope.dieta=[];
    $http.post('src/sgh/dietas/php/sghListadietas.php',{op:2,idhc:$scope.histoclinica,fe:fecha}).success(function (data) {
        if (data.error === 'error') {console.log(data);}
        else
        {
            $scope.dieta = [];
            for($i=0; $i<data.length ; $i++) {
                $scope.dieta.push({did_id_pk: data[$i].did_id_pk, did_obce:data[$i].did_obce, die_descrip: data[$i].die_descrip,did_res:data[$i].did_res});
            }

        }
    });
}
    $scope.gua=true;
    $scope.deop=false;
$scope.ver=function (fecha) {
    $scope.verdietas = true;
    $scope.gua=false;
    $scope.deop=true;
    $scope.reportevisa=false;
    $scope.titulo = 'Pedido de dieta';
    $http.post('src/sgh/dietas/php/sghListadietas.php',{op:2,idhc:$scope.histoclinica,fe:fecha}).success(function (data) {
        if (data.error === 'error') {console.log(data);}
        else
        {
            $scope.dieta = [];
            for($i=0; $i<data.length ; $i++) {
                $scope.dieta.push({did_id_pk: data[$i].did_id_pk, did_obce:data[$i].did_obce, die_descrip: data[$i].die_descrip,did_res:data[$i].did_res});
            }
            console.log(data);
        }
    });
}
$scope.actualizar=function(){
    $http.post('src/sgh/dietas/php/sghInserdietas.php',{op:2,die:$scope.dieta, usu:$scope.usuario}).success(function(data){
       $scope.text = data.sgh_dieta_detalle_ingreso_pa;
       $scope.mensaje= true;
       setTimeout(function()
        {
          $scope.mensaje= false;
          $scope.$apply();
          $scope.cancelar();
        }, 1500);
    console.log(data);
  });

}

    $scope.nuevoresgistro=function () {
        $scope.titulo="Nuevo Registro de Pedido de dietas";// titulo del modal
        $scope.gua=true;
        $scope.deop=false;
        $scope.verdietas=true;
        $scope.verelima=false;
        $scope.veradieta=false;
        $scope.reportevisa=false;
        $scope.actu();
    }
    $scope.fechar=null;
/////////////// dietas ///
$scope.agre_dieta=function () {
        $scope.titulo="Nuevo Registro de dieta";// titulo del modal
        $scope.verdietas=false;
        $scope.verelima=false;
        $scope.veradieta=true;
        $scope.reportevisa=false;
    }
    $scope.reportevisa=false;
   $scope.fechar=null;
$scope.grepor=function (f) {
    if (f !=null){
        $scope.reportevisa=true;
        frame.setAttribute("src", "src/sgh/dietas/php/reporte_dietas.php?f="+f)

    }else {
        alert("Sin Fecha");
    }

}
}]);
