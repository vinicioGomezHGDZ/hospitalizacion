angular.module("ingesta",['ngRoute'])
.controller('ingestaCtrl',['$scope','$http','$routeParams',function($scope,$http,$routeParams){
    if ($scope.sgh_v_user === undefined){$scope.cerrarsecion();}
$scope.Fecha = new Date();
$scope.datosAguardar={
    cie_fecha: null,
    cie_turno:"",
    cie_hora:timepicker1.value,
//    cie_cantcc:null,
//cie_clasep:null, 
 //   cie_cantccp:null,
 //   cie_canabs:null,
//cie_comoobtuvo:null,
 //   cie_cantcco:null,
 // cie_origen:null,
 //  cie_cantccot:null,
    
};
 $scope.inges=[];
 $scope.limpiar= function(){ $scope.inges=[];}
$scope.addingesta = function(){

     if ($scope.datosAguardar.cie_cantcc ===  null || $scope.datosAguardar.cie_cantccp ===  null || $scope.datosAguardar.cie_cantcco === null || $scope.datosAguardar.cie_cantccot === null)
     {
         alert("Los campos numericos no deben estar vacios");
     }
    else{

       $scope.inges.push({cie_hora: $scope.datosAguardar.cie_hora, 
                          cie_clase: $scope.datosAguardar.cie_clase,
                          cie_cantcc: $scope.datosAguardar.cie_cantcc,
                          cie_clasep: $scope.datosAguardar.cie_clasep,
                          cie_cantccp: $scope.datosAguardar.cie_cantccp,
                          cie_canabs: $scope.datosAguardar.cie_canabs,
                          cie_comoobtuvo: $scope.datosAguardar.cie_comoobtuvo,
                          cie_cantcco: $scope.datosAguardar.cie_cantcco,
                          cie_origen: $scope.datosAguardar.cie_origen,
                          cie_cantccot: $scope.datosAguardar.cie_cantccot});




             $scope.datosAguardar={
                 cie_hora:timepicker1.value,
                 cie_clase:null,
                 cie_cantcc:null,
                 cie_clasep:null,
                 cie_cantccp:null,
                 cie_canabs:null,
                 cie_comoobtuvo:null,
                 cie_cantcco:null,
                 cie_origen:null,
             };
             $scope.datosAguardar.cie_cantcc=0;
             $scope.datosAguardar.cie_cantccp=0;
             $scope.datosAguardar.cie_canabs=0;
             $scope.datosAguardar.cie_cantcco=0;
             $scope.datosAguardar.cie_cantccot=0;
}
      
};
//datos que estraigo de los campos para guardar
    $scope.datosAguardar.cie_cantcc=0;
    $scope.datosAguardar.cie_cantccp=0;
    $scope.datosAguardar.cie_canabs=0;
    $scope.datosAguardar.cie_cantcco=0;
    $scope.datosAguardar.cie_cantccot=0;
$scope.encabesado={};// cargo datos de la historai clinica
$scope.mensaje=false ;
//variables de paginacion

$scope.posicion=null;// guarda el total de items de la tabla
$scope.pagina=1; // variable de paginas a mostrar	 

//cargar datos con json
$scope.totaloral=0;
$scope.actu=function(){
   $http.post('src/sgh/ingesta/php/sghListaIngesta.php',{idhc:$scope.histoclinica}).success(function (data) {
        if (data.error === "error"){console.log(data)}
        else{
        $scope.ingesta = data;
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
///
 $scope.formp=true;
 $scope.forms=false;
$scope.atras= function (){
  $scope.formp=true;
  $scope.forms=false; 
  $scope.cancelar();
}

$scope.cargar=function(fecha){
  $scope.fecha=fecha;
  $scope.mañana();
  $scope.tarde();
  $scope.noche();
  $scope.formp=false;
  $scope.forms=true;    
} 

 $scope.mañana=function (){
  $scope.totaloral=0;
  $scope.totalparental=0;
  $scope.totalparecanab=0;
  $scope.totalorina=0;
  $scope.totalotros=0;
 

  $http.post('src/sgh/ingesta/php/sghgetIngesta.php',{fecha:$scope.fecha , idhc:$scope.histoclinica,tipo:'MAÑANA',OP:'1'}).success(function(data){  
       if (data.error === true) {$scope.oral={};}
        else{
      $scope.oral=data;
      for (var i = 0; i <=data.length-1; i++) {
         $scope.totaloral+=parseFloat(data [i].cie_cantcc);
      }}
      console.log(data);
    });

 $http.post('src/sgh/ingesta/php/sghgetIngesta.php',{fecha:$scope.fecha , idhc:$scope.histoclinica,tipo:'MAÑANA',OP:'2'}).success(function(data){  
       if (data.error === true) {$scope.parental={};}
        else{
      $scope.parental=data;
      for (var i = 0; i <=data.length-1; i++) {
          $scope.totalparental+=parseFloat(data[i].cie_cantcc);
          $scope.totalparecanab+=parseFloat(data[i].cie_canabs);
        }  }
              
    }); 
 $http.post('src/sgh/ingesta/php/sghgetIngesta.php',{fecha:$scope.fecha , idhc:$scope.histoclinica,tipo:'MAÑANA',OP:'3'}).success(function(data){  
       if (data.error === true) {$scope.orina={};}
        else{
      $scope.orina=data;
      for (var i = 0; i <=data.length-1; i++) {
      $scope.totalorina+=parseFloat(data[i].cie_cantcc);
      }      }
    }); 
 $http.post('src/sgh/ingesta/php/sghgetIngesta.php',{fecha:$scope.fecha , idhc:$scope.histoclinica,tipo:'MAÑANA',OP:'4'}).success(function(data){  
       if (data.error === true) {$scope.otros={};}
        else{
      $scope.otros=data;
      for (var i = 0; i <=data.length-1; i++) {
      $scope.totalotros+=parseFloat(data[i].cie_cantcc);
       }} 
    }); 
 }
 $scope.tarde=function (){
  $scope.totaloralt=0;
  $scope.totalparentalt=0;
  $scope.totalparecanabt=0;
  $scope.totalorinat=0;
  $scope.totalotrost=0;

  $http.post('src/sgh/ingesta/php/sghgetIngesta.php',{fecha:$scope.fecha , idhc:$scope.histoclinica,tipo:'TARDE',OP:'1'}).success(function(data){  
       if (data.error === true) {$scope.oralT={};}
        else{
          $scope.oralT=data;
      for (var i = 0; i <=data.length-1; i++) {
         $scope.totaloralt+=parseFloat(data [i].cie_cantcc);
      }}
          
    });

 $http.post('src/sgh/ingesta/php/sghgetIngesta.php',{fecha:$scope.fecha , idhc:$scope.histoclinica,tipo:'TARDE',OP:'2'}).success(function(data){  
      if (data.error === true) {$scope.parentalT={};}
        else{
          $scope.parentalT=data;
      for (var i = 0; i <=data.length-1; i++) {
          $scope.totalparentalt+=parseFloat(data[i].cie_cantcc);
          $scope.totalparecanabt+=parseFloat(data[i].cie_canabs);
        }   }   
    }); 
 $http.post('src/sgh/ingesta/php/sghgetIngesta.php',{fecha:$scope.fecha , idhc:$scope.histoclinica,tipo:'TARDE',OP:'3'}).success(function(data){  
      if (data.error === true) {$scope.orinaT={};}
        else{
          $scope.orinaT=data;
      for (var i = 0; i <=data.length-1; i++) {
      $scope.totalorinat+=parseFloat(data[i].cie_cantcc);
      }  }   
    }); 
 $http.post('src/sgh/ingesta/php/sghgetIngesta.php',{fecha:$scope.fecha , idhc:$scope.histoclinica,tipo:'TARDE',OP:'4'}).success(function(data){  
      if (data.error === true) {$scope.otrosT={};}
        else{
          $scope.otrosT=data;
      for (var i = 0; i <=data.length-1; i++) {
      $scope.totalotrost+=parseFloat(data[i].cie_cantcc);
       }    }  
    }); 
 }
 $scope.noche=function (){
  $scope.totaloralN=0;
  $scope.totalparentalN=0;
  $scope.totalparecanabN=0;
  $scope.totalorinaN=0;
  $scope.totalotrosN=0;

 $http.post('src/sgh/ingesta/php/sghgetIngesta.php',{fecha:$scope.fecha , idhc:$scope.histoclinica,tipo:'NOCHE',OP:'1'}).success(function(data){
      if (data.error === true) {$scope.oralN={};}
        else{
      $scope.oralN=data;
      for (var i = 0; i <=data.length-1; i++) {
         $scope.totaloralN+=parseFloat(data [i].cie_cantcc);
      }}    
    });
 $http.post('src/sgh/ingesta/php/sghgetIngesta.php',{fecha:$scope.fecha , idhc:$scope.histoclinica,tipo:'NOCHE',OP:'2'}).success(function(data){
       if (data.error === true) { $scope.parentalN={};}
        else{
      $scope.parentalN=data;
      for (var i = 0; i <=data.length-1; i++) {
          $scope.totalparentalN+=parseFloat(data[i].cie_cantcc);
          $scope.totalparecanabN+=parseFloat(data[i].cie_canabs);
        }
      }     
    }); 
 $http.post('src/sgh/ingesta/php/sghgetIngesta.php',{fecha:$scope.fecha , idhc:$scope.histoclinica,tipo:'NOCHE',OP:'3'}).success(function(data){  
       if (data.error === true) {$scope.orinaN={};}
        else{
      $scope.orinaN=data;
      for (var i = 0; i <=data.length-1; i++) {
      $scope.totalorinaN+=parseFloat(data[i].cie_cantcc);
      } 
    }  
    }); 
 $http.post('src/sgh/ingesta/php/sghgetIngesta.php',{fecha:$scope.fecha , idhc:$scope.histoclinica,tipo:'NOCHE',OP:'4'}).success(function(data){  
       if (data.error === true) {$scope.otrosN={};}
        else{
      $scope.otrosN=data;
      for (var i = 0; i <=data.length-1; i++) {
      $scope.totalotrosN+=parseFloat(data[i].cie_cantcc);
       }   
     }
    }); 
 }

 $scope. paginas = function(tipo)
{
	if (tipo == 0 && $scope.pagina  > 1 ){$scope.pagina-=1;}
	   else if (tipo == 1 && $scope.pagina < $scope.posicion ){$scope.pagina+=1;}
 }

 $scope.$watch('Busqueda', function() {

		if($scope.Busqueda == undefined) return;

		$scope.pagina=1;
		$scope.posicion=Math.ceil($scope.Busqueda.length / $scope.totalpaginas);	
});

// GUARDAR DATOS
$scope.cancelar = function(){
      /* var mañana*/
    $scope.datosAguardar.cie_hora=timepicker1.value;
    $scope.edi_ma_or=false;
    $scope.edi_ma_pa=false;
    $scope.edi_ma_ori=false;
    $scope.edi_ma_otr=false;
    $scope.edi_ma_tur=false;
  /* var tarde*/
    $scope.edi_ta_or=false;
    $scope.edi_ta_pa=false;
    $scope.edi_ta_ori=false;
    $scope.edi_ta_otr=false;
    $scope.edi_ta_tur=false; 
  /* var noche*/
    $scope.edi_na_or=false;
    $scope.edi_na_pa=false;
    $scope.edi_na_ori=false;
    $scope.edi_na_otr=false;
    $scope.edi_na_tur=false;
    $scope.inges=[];

       $("#closemodal").click()
      $scope.datosAguardar={
              cie_fecha: null,
              cie_hora:timepicker1.value,
              cie_clase:null,
              cie_cantcc:null,
              cie_clasep:null,
              cie_cantccp:null,
              cie_canabs:null,
              cie_comoobtuvo:null,
              cie_cantcco:null,
              cie_origen:null,
              cie_cantccot:null,cie_turno:"",
      };
      $scope.datosAguardar.cie_cantcc=0;
      $scope.datosAguardar.cie_cantccp=0;
      $scope.datosAguardar.cie_canabs=0;
      $scope.datosAguardar.cie_cantcco=0;
      $scope.datosAguardar.cie_cantccot=0;$scope.actguarda=false;
}
$scope.actguarda=false;
$scope.guardar = function(){$scope.actguarda=true;
    if  ($scope.inges.length === 0)
    {alert("Para Guardar, agregue un o más registro en la lista.");
    $scope.actguarda=false;}
    else{
      
   $http.post('src/sgh/ingesta/php/sghInserIngesta.php',{ing:$scope.datosAguardar,aing:$scope.inges,cama:$scope.cama, hcl:$scope.histoclinica, usu:$scope.usuario,op:'1'}).success(function(data){
       $scope.text = data.sgh_controlingesta_ingreso_pa;
			 $scope.mensaje= true;

      setTimeout(function() 
				{
          $scope.mensaje= false;$scope.actguarda=false;
          $scope.$apply();
           $scope.inges=[];
                    $scope.datosAguardar={
                        cie_fecha: null,
                        cie_hora:timepicker1.value,
                        cie_clase:null,
                        cie_cantcc:null,
                        cie_clasep:null,
                        cie_cantccp:null,
                        cie_canabs:null,
                        cie_comoobtuvo:null,
                        cie_cantcco:null,
                        cie_origen:null,
                        cie_cantccot:null,cie_turno:"",
                    };
                    $scope.datosAguardar.cie_cantcc=0;
                    $scope.datosAguardar.cie_cantccp=0;
                    $scope.datosAguardar.cie_canabs=0;
                    $scope.datosAguardar.cie_cantcco=0;
                    $scope.datosAguardar.cie_cantccot=0;
          $scope.actu();
   		  }, 1500);
		console.log(data);
	     }); 
   }
}

////// editar //////
  /* var mañana*/
    $scope.edi_ma_or=false;
    $scope.edi_ma_pa=false;
    $scope.edi_ma_ori=false;
    $scope.edi_ma_otr=false;
    $scope.edi_ma_tur=false;
  /* var tarde*/
    $scope.edi_ta_or=false;
    $scope.edi_ta_pa=false;
    $scope.edi_ta_ori=false;
    $scope.edi_ta_otr=false;
    $scope.edi_ta_tur=false; 
  /* var noche*/
    $scope.edi_na_or=false;
    $scope.edi_na_pa=false;
    $scope.edi_na_ori=false;
    $scope.edi_na_otr=false;
    $scope.edi_na_tur=false;      

$scope.editar=function(id,op){

  $http.post('src/sgh/ingesta/php/sghgetIngesta.php',{cen_fecha:$scope.cen_fecha,codigo:id,OP:'5'}).success(function(data){
       
       if (data.error != true)
      { 
    /* condiciones mañana*/  
        if (op === 'mo') {$scope.edi_ma_or=true; $scope.edi_ma_pa=false;$scope.edi_ma_ori=false;$scope.edi_ma_otr=false; $scope.edi_ma_tur=true;}
        if (op === 'mp') {$scope.edi_ma_pa=true; $scope.edi_ma_or=false;$scope.edi_ma_ori=false;$scope.edi_ma_otr=false; $scope.edi_ma_tur=true;}
        if (op === 'mor') {$scope.edi_ma_pa=false; $scope.edi_ma_or=false;$scope.edi_ma_ori=true;$scope.edi_ma_otr=false; $scope.edi_ma_tur=true;}
        if (op === 'motr') {$scope.edi_ma_pa=false; $scope.edi_ma_or=false;$scope.edi_ma_ori=false;$scope.edi_ma_otr=true; $scope.edi_ma_tur=true;}
    /* condiciones tarde*/  
        if (op === 'to') {$scope.edi_ta_or=true; $scope.edi_ta_pa=false;$scope.edi_ta_ori=false;$scope.edi_ta_otr=false; $scope.edi_ta_tur=true;}
        if (op === 'tp') {$scope.edi_ta_pa=true; $scope.edi_ta_or=false;$scope.edi_ta_ori=false;$scope.edi_ta_otr=false; $scope.edi_ta_tur=true;}
        if (op === 'tor') {$scope.edi_ta_pa=false; $scope.edi_ta_or=false;$scope.edi_ta_ori=true;$scope.edi_ta_otr=false; $scope.edi_ta_tur=true;}
        if (op === 'totr') {$scope.edi_ta_pa=false; $scope.edi_ta_or=false;$scope.edi_ta_ori=false;$scope.edi_ta_otr=true; $scope.edi_ta_tur=true;}
    /* condiciones noche*/  
        if (op === 'no') {$scope.edi_na_or=true; $scope.edi_na_pa=false;$scope.edi_na_ori=false;$scope.edi_na_otr=false; $scope.edi_na_tur=true;}
        if (op === 'np') {$scope.edi_na_pa=true; $scope.edi_na_or=false;$scope.edi_na_ori=false;$scope.edi_na_otr=false; $scope.edi_na_tur=true;}
        if (op === 'nor') {$scope.edi_na_pa=false; $scope.edi_na_or=false;$scope.edi_na_ori=true;$scope.edi_na_otr=false; $scope.edi_na_tur=true;}
        if (op === 'notr') {$scope.edi_na_pa=false; $scope.edi_na_or=false;$scope.edi_na_ori=false;$scope.edi_na_otr=true; $scope.edi_na_tur=true;}

    /*Carga datos*/    
         $scope.datosAguardar={
          cie_turno:data[0].cie_turno,
          cie_hora:data[0].cie_hora,
          cie_clase:data[0].cie_clase,
          cie_cantcc:parseInt(data[0].cie_cantcc),
          cie_canabs:parseInt(data[0].cie_canabs),
          cie_id_pk:data[0].cie_id_pk,
          };
         console.log(data);
        }
      else
      {
       alert("Lo Sentimos, ya pasaron más de 24 horas.");
       $scope.cancelar();
       console.log(data);
      }   
  });
}
$scope.actualizar=function(){
   $http.post('src/sgh/ingesta/php/sghInserIngesta.php',{ing:$scope.datosAguardar,cama:$scope.cama, hcl:$scope.histoclinica, usu:$scope.usuario,op:'2'}).success(function(data){
       $scope.cargar($scope.fecha);
       $scope.cancelar();
      });
    } 

}]);

