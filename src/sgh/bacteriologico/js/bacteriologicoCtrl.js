angular.module("bacteriologico",['ngRoute'])
.controller('bacteriologicoCtrl',['$scope','$http','$routeParams',function($scope,$http,$routeParams){
	if ($scope.sgh_v_user === undefined){$scope.cerrarsecion();}

$scope.Fecha = new Date();
	$scope.activa_desactiva=function(op) {
		if (op === "null") {return true;}
		else {return false;}
	}
$scope.datosAguardar={
	          bac_bk: false, 
	 		  bac_cultivo: false, 
	 		  bac_ada: false, 
	 		  bac_psd: null, 
	 		  bac_diag: false, 
	 		  bac_control: false, 
	 		  bac_mes: null, 
	 		  bac_esqtra: null, 
	 		  bac_esputo: false, 
	 		  bac_otrom: null, 
	 		  bac_abando: false, 
	 		  bac_recupe: false, 
	 		  bac_fracas: false, 
	 		  bac_recaid: false, 
	 		  bac_sr_bk: false, 
	 		  bac_tb_dr: null, 
	 		  bac_pvv: false, 
	 		  bac_diabetes: false, 
	 		  bac_tb_otroe: null, 
	 		  bac_emdesa: false, 
	 		  bac_ppl: false, 
	 		  bac_tbdr: null
			};

//datos que estraigo de los campos para guardar
$scope.mensaje=false ;
//variables de paginacion

$scope.posicion=null;// guarda el total de items de la tabla
$scope.pagina=1; // variable de paginas a mostrar
//cargar datos con json

$scope.actu=function(){
   $http.post('src/sgh/bacteriologico/php/sghListaBacteriologico.php',{op:'1',idhc:$scope.histoclinica}).success(function (data) {
    	if (data.error === "error") {console.log(data);}
    	else{	
        $scope.bacteriologico = data;
 		$scope.posicion=Math.ceil(data.length / $scope.totalpaginas);
 		}
 		console.log(data);
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

$scope.g=true;
$scope.bact=function(id){
 $scope.g=false;
 $http.post('src/sgh/bacteriologico/php/sghListaBacteriologico.php',{op:'2',codigo:id,usu:$scope.usuario}).success(function (data) {
        $scope.datosAguardar ={
        	  bac_bk: data[0].bac_bk ,
			  bac_cultivo: data[0].bac_cultivo ,
			  bac_ada: data[0].bac_ada ,
			  bac_psd: data[0].bac_psd ,
			  bac_diag: data[0].bac_diag ,
			  bac_control: data[0].bac_control ,
			  bac_mes: data[0].bac_mes ,
			  bac_esqtra: data[0].bac_esqtra, 
			  bac_esputo: data[0].bac_esputo, 
			  bac_otrom: data[0].bac_otrom ,
			  bac_abando: data[0].bac_abando ,
			  bac_recupe: data[0].bac_recupe, 
			  bac_fracas: data[0].bac_fracas ,
			  bac_recaid: data[0].bac_recaid ,
			  bac_sr_bk: data[0].bac_sr_bk ,
			  bac_tb_dr: data[0].bac_tb_dr ,
			  bac_pvv: data[0].bac_pvv ,
			  bac_diabetes: data[0].bac_diabetes, 
			  bac_tb_otroe: data[0].bac_tb_otroe ,
			  bac_emdesa: data[0].bac_emdesa ,
			  bac_ppl: data[0].bac_ppl ,
			  bac_tbdr: data[0].bac_tbdr,
        
	 		};
 	 		console.log(data);
     });
	 $("#n").click();
}

$scope.regreesar=function(){ 
 $scope.anadatos=false;	
 $scope.tabla=true; 
}	

$scope. paginas = function(tipo)
{if (tipo == 0 && $scope.pagina  > 1 ){$scope.pagina-=1;}
 else if (tipo == 1 && $scope.pagina < $scope.posicion ){$scope.pagina+=1;}
}

// GUARDAR DATOS
$scope.cancelar = function(){
		    $("#closemodal").click()
$scope.actu(); 	
$scope.g=true;	 
$scope.datosAguardar={
	 		  bac_bk: false, 
	 		  bac_cultivo: false, 
	 		  bac_ada: false, 
	 		  bac_psd: null, 
	 		  bac_diag: false, 
	 		  bac_control: false, 
	 		  bac_mes: null, 
	 		  bac_esqtra: null, 
	 		  bac_esputo: false, 
	 		  bac_otrom: null, 
	 		  bac_abando: false, 
	 		  bac_recupe: false, 
	 		  bac_fracas: false, 
	 		  bac_recaid: false, 
	 		  bac_sr_bk: false, 
	 		  bac_tb_dr: null, 
	 		  bac_pvv: false, 
	 		  bac_diabetes: false, 
	 		  bac_tb_otroe: null, 
	 		  bac_emdesa: false, 
	 		  bac_ppl: false, 
	 		  bac_tbdr: null

			};		
	    	  }
	$scope.actguarda=false;
$scope.guardar = function()
  {	$scope.actguarda=true;
     $http.post('src/sgh/bacteriologico/php/sghInserBacteriologico.php',{bac:$scope.datosAguardar, hcl:$scope.histoclinica, usu:$scope.usuario,op:1,eti:$scope.entidad}).success(function(data){	
             $scope.text = data.sgh_bacteriologico_ingreso_pa;
			 $scope.mensaje= true;
           
           setTimeout(function(){
            $scope.mensaje= false;
			$scope.$apply();
            $scope.cancelar();
			   $scope.actguarda=false;
   		  	},1500);
         console.log(data);
    });
   }

}]);

