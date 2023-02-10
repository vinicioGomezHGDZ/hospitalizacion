angular.module("cervicovaginal",['ngRoute'])
.controller('cervicovaginalCtrl',['$scope','$http','$routeParams',function($scope,$http,$routeParams){

$scope.Fecha = new Date();
    $scope.activa_desactiva=function(op) {
        if (op === "null") {return true;}
        else {return false;}
    }
$scope.activa=function(id){
	//alert(id);
	if (id === "")
	{
	 $scope.otros=true;
	}else{$scope.otros=false;}
}

    if ($scope.sgh_v_user === undefined){$scope.cerrarsecion();}
    $scope.dcerva= function(id){

        $scope.tabla=false;
        $scope.anadatos=true;
        $scope.codigo=id;
        $scope.op=3;
        $http.post('src/sgh/cervicovaginal/php/sghListaCervicoVaginal.php',{op:'2',codigo:id}).success(function (data) {
            console.log(data);
            $scope.datosAguardar = {
                ccv_anio:parseInt(data[0].ccv_anio),
                ccv_cacute:data[0].ccv_cacute ,
                ccv_citolo:data[0].ccv_citolo ,
                ccv_coniza:data[0].ccv_coniza ,
                ccv_cuatas:parseInt(data[0].ccv_cuatas),
                ccv_embara:data[0].ccv_embara ,
                ccv_fetomu:new Date(data[0].ccv_fetomu) ,
                ccv_feulme:new Date(data[0].ccv_feulme) ,
                ccv_hacuti:data[0].ccv_hacuti ,
                ccv_hister:data[0].ccv_hister ,
                ccv_inisex:parseInt(data[0].ccv_inisex),
                ccv_lactan:data[0].ccv_lactan,
                ccv_meses:parseInt(data[0].ccv_meses),
                ccv_numabo:parseInt(data[0].ccv_numabo),
                ccv_numpar:parseInt(data[0].ccv_numpar),
                ccv_planif:data[0].ccv_planif,
                ccv_radiot:data[0].ccv_radiot,
                ccv_result:data[0].ccv_result
            };
        });

    }
    $scope.regreesar=function () {
        $scope.tabla=true;
        $scope.anadatos=false;
        $scope.cancelar();
    }
$scope.datosAguardar={
ccv_feulme: null, 
 ccv_embara: false, 
 ccv_lactan: false, 
 ccv_planif: null, 
 ccv_numpar: 0, 
 ccv_numabo: 0, 
 ccv_inisex: 0, 
 ccv_cacute: false, 
 ccv_coniza: false, 
 ccv_hister: false, 
 ccv_radiot: false, 
 ccv_citolo: false, 
 ccv_cuatas: 0, 
 ccv_hacuti: 0, 
 ccv_anio: 0, 
 ccv_meses: 0
			};

//datos que estraigo de los campos para guardar
$scope.mensaje=false ;
$scope.cat=1;
//variables de paginacion

$scope.posicion=null;// guarda el total de items de la tabla
$scope.pagina=1; // variable de paginas a mostrar
//cargar datos con json

$scope.actu=function(){
   $http.post('src/sgh/cervicovaginal/php/sghListaCervicoVaginal.php',{op:'1',idhc:$scope.histoclinica}).success(function (data) {
    if (data.error === "error") {console.log(data);}else{
    $scope.cervicovaginal = data;
 		$scope.posicion=Math.ceil(data.length / $scope.totalpaginas);}
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

$scope.tabla=true;
$scope. paginas = function(tipo)
{if (tipo == 0 && $scope.pagina  > 1 ){$scope.pagina-=1;}
 else if (tipo == 1 && $scope.pagina < $scope.posicion ){$scope.pagina+=1;}
}

// GUARDAR DATOS
$scope.cancelar = function(){
      // angular.element("input[type='file']").val(null);
		    
        $("#closemodal").click()
		    $scope.actu();
        $scope.datosAguardar={
            ccv_feulme: null, 
             ccv_embara: false, 
             ccv_lactan: false, 
             ccv_planif: null, 
             ccv_numpar: 0, 
             ccv_numabo: 0, 
             ccv_inisex: 0, 
             ccv_cacute: false, 
             ccv_coniza: false, 
             ccv_hister: false, 
             ccv_radiot: false, 
             ccv_citolo: false, 
             ccv_cuatas: 0, 
             ccv_hacuti: 0, 
             ccv_anio: 0, 
             ccv_meses: 0
          };		
		
}

$scope.activa=function(id){
  if (id === "0")
  {
   $scope.otros=true;
   
  }else{$scope.otros=false;
    $scope.datosAguardar.vih_otros=null;
  }
}

// GUARDAR DATOS
$scope.actguarda=false;
$scope.guardar = function(){
  $scope.actguarda=true;
        $http.post('src/sgh/cervicovaginal/php/sghInserCervicoVaginal.php',{op:1,hcl: $scope.histoclinica ,usu:$scope.usuario,eti:$scope.entidad,cev:$scope.datosAguardar}) .success(function(data){ 
         $scope.text = data.sgh_cervicovaginal_ingreso_pa;
         $scope.mensaje= true;
          
          setTimeout(function() 
          {
            $scope.mensaje= false;$scope.actguarda=false;
            $scope.$apply();
           // $("#closemodal").click();
            $scope.cancelar();
          }, 1500);
         console.log(data);
        });  
     }

}])
