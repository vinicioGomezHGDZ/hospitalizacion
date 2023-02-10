angular.module("escalageriatrica",['ngRoute'])
.controller('escalageriatricaCtrl',['$scope','$http','$routeParams',function($scope,$http,$routeParams){
	if ($scope.sgh_v_user === undefined){$scope.cerrarsesion();}
$scope.Fecha = new Date();
$scope.tamizaje={
           dificultadvisual: null, 
           dificultadauditiva: null, 
           levandtayanda: null, 
           perdidadeorina: null, 
           perdidadepeso: null, 
           perdidadememoria: null, 
           sientetriste: null, 
           puedebaniarse: null, 
           saledecompras: null, 
           vivesolo: null 	 		  
           }  
$scope.ActividadesBasicas={
           sebasolo:null, 
           vistedesviste:null, 
           cuidapariencia:null, 
           utilizainodoro:null, 
           controlaesfinteres:null, 
           setraslada:null, 
           camina:null, 
           sealimenta:null
 
         };
$scope.ActividadesInstrumental={
    usatelefono: null, 
    transporte: null, 
    vadecompras: null, 
    preparacomida: null, 
    controlamedicamentos: null,
    manejadinero: null 
  }    
$scope.datosAguardar={
    esg_sabfec: 0, esg_apnobj: 0, esg_renual: 0, esg_tompap: 0, esg_repser: 0, esg_copdib: 0,esg_viveco: 0, esg_reconso: 0, esg_apreso: 0
  }
$scope.depresion={
    mejorqueusted: null, sienesperanza: null, llenodeenergia: null, sienteinutil: null, creequesmaravilloso: null, problemasmemoria: null, prefierestarencasa: null, sesientedesamparado: null, sesientegeliz: null, preocupado: null, buenanimo: null, seaburre: null, vidavacia: null, actividadesinteres: null, estasatisfecho: null
   }           
$scope.nutricional={
	disminucioningesta: null, movilidad: null, enfermedadaguda: null, problemaspsicologico: null, perdidadepeso: 0, masacorporal: 0
	}

//datos que estraigo de los campos para guardar
$scope.mensaje=false ;

//variables de paginacion

$scope.posicion=null;// guarda el total de items de la tabla
$scope.pagina=1; // variable de paginas a mostrar	
/////////////// 
//cargar datos con json
$scope.actu=function(){
   $http.post('src/sgh/escalageriatrica/php/sghListaEscalageriatrica.php',{op:'1',idhc:$scope.histoclinica}).success(function (data) {
       if (data.error ==="error") {console.log(data);}
       else{
        $scope.escala = data;
 		$scope.posicion=Math.ceil(data.length / $scope.totalpaginas);
 		console.log(data);
 	  }
     }); 
}
if ($scope.histoclinica === null){
  //alert("Escoja un pacinete");
  window.location = "#/";
}else{
$scope.actu();
}
//// función convertir a boolean
$scope.bool=function(valor){

	if (valor === "t"){
		var bool = true;
	}else{var bool = false;}
   return bool;	
}
$scope.gua=true;
$scope.desactivar=false;

$scope.esg=function(id){
 	 $scope.gua=false;
 	 $scope.desactivar=true;	
	 //$scope.tabla=false;

	$http.post('src/sgh/escalageriatrica/php/sghListaEscalageriatrica.php',{codigo:id , op:'2'}).success(function(data)
		{
			$scope.datosAguardar={
			    esg_sabfec: parseInt(data[0].esg_sabfec), 
			    esg_apnobj: parseInt(data[0].esg_apnobj), 
			    esg_renual: parseInt(data[0].esg_renual), 
			    esg_tompap: parseInt(data[0].esg_tompap), 
			    esg_repser: parseInt(data[0].esg_repser), 
			    esg_copdib: parseInt(data[0].esg_copdib),
			    esg_viveco: parseInt(data[0].esg_viveco), 
			    esg_reconso: parseInt(data[0].esg_reconso), 
			    esg_apreso: parseInt(data[0].esg_apreso)
			 };
	   
	         $("#n").click()
	 	    //    console.log(data);
		});
	$http.post('src/sgh/escalageriatrica/php/sghListaEscalageriatrica.php',{codigo:id , op:'3',punt:'TAMIZAJE'}).success(function(data)
		{
			   $scope.tamizaje={
			   	    dificultadauditiva:data[0].pat_result,			
					dificultadvisual:data[1].pat_result,			
					levandtayanda:data[2].pat_result,			
					perdidadememoria:data[3].pat_result,			
					perdidadeorina:data[4].pat_result,			
					perdidadepeso:data[5].pat_result,			
					puedebaniarse:data[6].pat_result,			
					saledecompras:data[7].pat_result,			
					sientetriste:data[8].pat_result,			
					vivesolo:data[9].pat_result			
			   };
			//  console.log(data);
	    });
	$http.post('src/sgh/escalageriatrica/php/sghListaEscalageriatrica.php',{codigo:id , op:'3',punt:'ACTIVIDADES BÁSICAS'}).success(function(data)
		{
			$scope.ActividadesBasicas={
					camina:data[0].pat_result,
					controlaesfinteres:data[1].pat_result,
					cuidapariencia:data[2].pat_result,
					sealimenta:data[3].pat_result,
					sebasolo:data[4].pat_result,
					setraslada:data[5].pat_result,
					utilizainodoro:data[6].pat_result,
					vistedesviste:data[7].pat_result,
		         };
			  //console.log(data);
	    });
	$http.post('src/sgh/escalageriatrica/php/sghListaEscalageriatrica.php',{codigo:id , op:'3',punt:'ACTIVIDADES INSTRUMENTAL'}).success(function(data)
		{
			$scope.ActividadesInstrumental={
			        controlamedicamentos:data[0].pat_result,
					manejadinero:data[1].pat_result, 
					preparacomida:data[2].pat_result,
					transporte:data[3].pat_result,
					usatelefono:data[4].pat_result,
					vadecompras:data[5].pat_result,

			  } 
		 console.log(data);
	    });
	$http.post('src/sgh/escalageriatrica/php/sghListaEscalageriatrica.php',{codigo:id , op:'3',punt:'DEPRESIÓN'}).success(function(data)
		{
			$scope.depresion={
				actividadesinteres:data[0].pat_result,
				buenanimo:data[1].pat_result,
				creequesmaravilloso:data[2].pat_result,
				estasatisfecho:data[3].pat_result,
				llenodeenergia:data[4].pat_result,
				mejorqueusted:data[5].pat_result,
				prefierestarencasa:data[6].pat_result,
				preocupado:data[7].pat_result,
				problemasmemoria:data[8].pat_result,
				seaburre:data[9].pat_result,
				sesientedesamparado:data[10].pat_result,
				sesientegeliz:data[11].pat_result,
				sienesperanza:data[12].pat_result,
				sienteinutil:data[13].pat_result,
				vidavacia:data[14].pat_result,

			   }  
			  //console.log(data);
	    });
	$http.post('src/sgh/escalageriatrica/php/sghListaEscalageriatrica.php',{codigo:id , op:'3',punt:'NUTRICIONAL'}).success(function(data)
		{
			$scope.nutricional={
				disminucioningesta: data[0].pat_result, 
				enfermedadaguda: data[1].pat_result, 
				masacorporal:parseInt(data[2].pat_result),
				movilidad: data[3].pat_result, 
				perdidadepeso:parseInt(data[4].pat_result), 
				problemaspsicologico: data[5].pat_result, 

					}
			 // console.log(data);
	    });

}


$scope.nuevoesg=function () {
   $http.post('src/sgh/escalageriatrica/php/sghListaEscalageriatrica.php',{op:4,idhc:$scope.histoclinica}).success(function(data){	
      var id =data[0].esg_id_pk;
        
        $http.post('src/sgh/escalageriatrica/php/sghListaEscalageriatrica.php',{codigo:id , op:'2'}).success(function(data)
		  {
			$scope.datosAguardar={
			    esg_sabfec: parseInt(data[0].esg_sabfec), 
			    esg_apnobj: parseInt(data[0].esg_apnobj), 
			    esg_renual: parseInt(data[0].esg_renual), 
			    esg_tompap: parseInt(data[0].esg_tompap), 
			    esg_repser: parseInt(data[0].esg_repser), 
			    esg_copdib: parseInt(data[0].esg_copdib),
			    esg_viveco: parseInt(data[0].esg_viveco), 
			    esg_reconso: parseInt(data[0].esg_reconso), 
			    esg_apreso: parseInt(data[0].esg_apreso),
			};
		//console.log(data);    
		});
	    $http.post('src/sgh/escalageriatrica/php/sghListaEscalageriatrica.php',{codigo:id , op:'3',punt:'TAMIZAJE'}).success(function(data)
			{
				   $scope.tamizaje={
				   	    dificultadauditiva:data[0].pat_result,
						dificultadvisual:data[1].pat_result,
						levandtayanda:data[2].pat_result,
						perdidadememoria:data[3].pat_result,
						perdidadeorina:data[4].pat_result,
						perdidadepeso:data[5].pat_result,
						puedebaniarse:data[6].pat_result,
						saledecompras:data[7].pat_result,
						sientetriste:data[8].pat_result,
						vivesolo:data[9].pat_result
				   };
				  //console.log(data);
		    });
		$http.post('src/sgh/escalageriatrica/php/sghListaEscalageriatrica.php',{codigo:id , op:'3',punt:'ACTIVIDADES BÁSICAS'}).success(function(data)
			{
				$scope.ActividadesBasicas={
					camina:data[0].pat_result,
					controlaesfinteres:data[1].pat_result,
					cuidapariencia:data[2].pat_result,
					sealimenta:data[3].pat_result,
					sebasolo:data[4].pat_result,
					setraslada:data[5].pat_result,
					utilizainodoro:data[6].pat_result,
					vistedesviste:data[7].pat_result,
			         };
				 //console.log(data);
		    });
		$http.post('src/sgh/escalageriatrica/php/sghListaEscalageriatrica.php',{codigo:id , op:'3',punt:'ACTIVIDADES INSTRUMENTAL'}).success(function(data){
				console.log(data);
				$scope.ActividadesInstrumental={
				        controlamedicamentos:data[0].pat_result,
						manejadinero:data[1].pat_result, 
						preparacomida:data[2].pat_result,
						transporte:data[3].pat_result,
						usatelefono:data[4].pat_result,
						vadecompras:data[5].pat_result,

				  }

		  });
		$http.post('src/sgh/escalageriatrica/php/sghListaEscalageriatrica.php',{codigo:id , op:'3',punt:'DEPRESIÓN'}).success(function(data)
			{
				$scope.depresion={
					actividadesinteres:data[0].pat_result,
					buenanimo:data[1].pat_result,
					creequesmaravilloso:data[2].pat_result,
					estasatisfecho:data[3].pat_result,
					llenodeenergia:data[4].pat_result,
					mejorqueusted:data[5].pat_result,
					prefierestarencasa:data[6].pat_result,
					preocupado:data[7].pat_result,
					problemasmemoria:data[8].pat_result,
					seaburre:data[9].pat_result,
					sesientedesamparado:data[10].pat_result,
					sesientegeliz:data[11].pat_result,
					sienesperanza:data[12].pat_result,
					sienteinutil:data[13].pat_result,
					vidavacia:data[14].pat_result,

				   }
				 // console.log(data);
		    });
		$http.post('src/sgh/escalageriatrica/php/sghListaEscalageriatrica.php',{codigo:id , op:'3',punt:'NUTRICIONAL'}).success(function(data)
			{
				$scope.nutricional={
					disminucioningesta: data[0].pat_result,
					enfermedadaguda: data[1].pat_result,
					masacorporal:parseInt(data[2].pat_result),
					movilidad: data[3].pat_result,
					perdidadepeso:parseInt(data[4].pat_result),
					problemaspsicologico: data[5].pat_result,

						}
				// console.log(data);
		    });
		//console.log(data);

  });
}

$scope. paginas = function(tipo)
{if (tipo == 0 && $scope.pagina  > 1 ){$scope.pagina-=1;}
 else if (tipo == 1 && $scope.pagina < $scope.posicion ){$scope.pagina+=1;}
}

// GUARDAR DATOS
$scope.cancelar = function(){
		$("#closemodal").click()
	    $scope.actu();
	    $scope.desactivar=false;
	    $scope.ver=false;		
		$scope.tamizaje={
		           dificultadvisual: null, 
		           dificultadauditiva: null, 
		           levandtayanda: null, 
		           perdidadeorina: null, 
		           perdidadepeso: null, 
		           perdidadememoria: null, 
		           sientetriste: null, 
		           puedebaniarse: null, 
		           saledecompras: null, 
		           vivesolo: null 	 		  
		           }  
		$scope.ActividadesBasicas={
		           dificultadvisual:null, 
		           vistedesviste:null, 
		           cuidapariencia:null, 
		           utilizainodoro:null, 
		           controlaesfinteres:null, 
		           setraslada:null, 
		           camina:null, 
		           sealimenta:null
		 
		         };
		$scope.ActividadesInstrumental={
		     usatelefono: null, transporte: null, vadecompras: null, preparacomida: null, controlamedicamentos: null, manejadinero: null 
		  }    
		$scope.datosAguardar={
		    esg_sabfec: 0, esg_apnobj: 0, esg_renual: 0, esg_tompap: 0, esg_repser: 0, esg_copdib: 0,esg_viveco: 0, esg_reconso: 0, esg_apreso: 0
		  }
		$scope.depresion={
		    mejorqueusted: null, sienesperanza: null, llenodeenergia: null, sienteinutil: null, creequesmaravilloso: null, problemasmemoria: null, prefierestarencasa: null, sesientedesamparado: null, sesientegeliz: null, preocupado: null, buenanimo: null, seaburre: null, vidavacia: null, actividadesinteres: null, estasatisfecho: null
		   }           
		$scope.nutricional={
			disminucioningesta: null, movilidad: null, enfermedadaguda: null, problemaspsicologico: null, perdidadepeso: 0, masacorporal: 0
			}
		$scope.gua=true;	
    };
// guardar imtes de escala geriatrica ///
	$scope.items= function (){
	$http.post('src/sgh/escalageriatrica/php/sghInserEscalageriatrica.php',{items:$scope.tamizaje,pun:"TAMIZAJE",op:2, usu:$scope.usuario}).success(function(data){
	        // console.log(data);
	    });
	$http.post('src/sgh/escalageriatrica/php/sghInserEscalageriatrica.php',{items:$scope.ActividadesBasicas,pun:"ACTIVIDADES BÁSICAS",op:2, usu:$scope.usuario}).success(function(data){
	         //console.log(data);
	    });
	$http.post('src/sgh/escalageriatrica/php/sghInserEscalageriatrica.php',{items:$scope.ActividadesInstrumental,pun:"ACTIVIDADES INSTRUMENTAL",op:2, usu:$scope.usuario}).success(function(data){
	         console.log(data);
	    });
	$http.post('src/sgh/escalageriatrica/php/sghInserEscalageriatrica.php',{items:$scope.depresion,pun:"DEPRESIÓN",op:2, usu:$scope.usuario}).success(function(data){
	      //   console.log(data);
	    });
	$http.post('src/sgh/escalageriatrica/php/sghInserEscalageriatrica.php',{items:$scope.nutricional,pun:"NUTRICIONAL",op:2, usu:$scope.usuario}).success(function(data){
	        // console.log(data);
	    });
	}
$scope.actguarda=false;
$scope.guardar = function()
  {	$scope.actguarda=true;
    // guardar epicrisis
    // alert("guardadno");
     $http.post('src/sgh/escalageriatrica/php/sghInserEscalageriatrica.php',{esg:$scope.datosAguardar, hcl:$scope.histoclinica, usu:$scope.usuario,op:1}).success(function(data){	
             $scope.text = data.sgh_escalageriatrica_ingreso_pa;
			 $scope.mensaje= true;

           setTimeout(function(){
            $scope.mensaje= false;$scope.actguarda=false;
			$scope.$apply();
           // $scope.actu();
            $scope.cancelar();			
   		  	},1500);
        	$scope.items();	
            console.log(data);
    });
 }
 

}]);

