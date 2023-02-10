angular.module("interconsulta",['ngRoute'])
.controller('interconsultaCtrl',['$scope','$http','$routeParams','upload',function($scope,$http,$routeParams,upload){

    if ($scope.sgh_v_user === undefined){$scope.cerrarsecion();}
    if ($scope.usu_perfil === 'ENFERMERA(O)' || $scope.usu_perfil === 'AUXILIAR DE ENFERMERÍA' ){$scope.admi=true}

    $scope.idmedi=0+"";
$scope.Fecha = new Date();
$scope.solicitud=true;
$scope.informe=false;
$scope.datosAguardar={

	 		};
//datos que estraigo de los campos para guardar
$scope.mensaje=false ;
//variables de paginacion
$scope.posicion=null;// guarda el total de items de la tabla
$scope.pagina=1; // variable de paginas a mostrar	
/////////////// 
$scope.op="Solicitud";
$scope.correos=function(){
    alert("se a enviado un correo al medico");
$http.post('src/sgh/interconsulta/php/envio_de_correo.php',{idhc:$scope.histoclinica}).success(function (data) {
  console.log(data);   
}); 
}

//cargar datos con json
$scope.actu=function(){
   $http.post('src/sgh/interconsulta/php/sghListaInterconsulta.php',{op:'1',idhc:$scope.histoclinica}).success(function (data) {
       console.log(data);
        if (data.error === "error") {console.log(data);}
        else{
        $scope.interconsulta = data;
 		     $scope.posicion=Math.ceil(data.length / $scope.totalpaginas);
 	  	}
     });
    $http.get('src/sgh/cie10/php/sghListarc10.php').success(function (data) {
        $scope.datosc10 = data;
        console.log(data);
        $scope.posicion2=Math.ceil(data.length / $scope.totalpaginas);
    });
}
    $scope.agregac10=function (valor) {
        console.log(valor);
        $scope.codigo=valor;
        $scope.bc10=false;
        $scope.b_buscar=true;
    }
    $scope.bc10=false;
    $scope.b_buscar=true;
    $scope.buscac10=function () {
        $scope.bc10=true;
        $scope.b_buscar=true;
    }
if ($scope.histoclinica === null){window.location = "#/"}
else{$scope.actu();}

$scope.tabla=true;
$scope.intdatos=false;
$scope.regreesar=function(){ 
 $scope.intdatos=false;	
 $scope.tabla=true; 
}	

$scope. paginas = function(tipo)
{if (tipo == 0 && $scope.pagina  > 1 ){$scope.pagina-=1;}
 else if (tipo == 1 && $scope.pagina < $scope.posicion ){$scope.pagina+=1;}
}

// GUARDAR DATOS
$scope.cancelar = function(){
    $scope.idmedi=0+"";
	 $scope.op="Solicitud";
   $("#closemodal").click();
   $scope.opsol="nuevo";
	 $scope.actu();
   $scope.cie10=[];
 	 $scope.c10_id_pk=0;
 	 $scope.datosAguardar={};
   $scope.solicitud=true;
	 $scope.informe=false;
   $scope.opedicion=false;
   $scope.codigo="";
   $scope.rec_op="add";
   $scope.c10nuevo=true;
   $scope.c10editar=false;
   $scope.actguar=false;
	 }
	 $scope.actguar=false;
$scope.guardar = function()
  {
      $scope.actguar=true;
    //guardar epicrisis
     $http.post('src/sgh/interconsulta/php/sghInserInterconsulta.php',{int:$scope.datosAguardar, hcl:$scope.histoclinica, usu:$scope.usuario, cam:$scope.cama, op:1}).success(function(data){	
             $scope.text = data.sgh_interconsulta_ingreso_pa;
			 $scope.mensaje= true;
           
           setTimeout(function(){
            $scope.mensaje= false;
               $scope.$apply();
              $scope.cancelar();
             //$scope.correos();

           },1500);
          $scope.dingreso();
         console.log(data);
  });
	}

   // guarda cie10 ingreso
	$scope.dingreso=function(){
    console.log("El CIE10: ",$scope.cie10);
	 if ($scope.cie10!= null){
      console.log("El CIE10: ",$scope.cie10);
		   $http.post('src/sgh/interconsulta/php/sghInserInterconsulta.php',{c10:$scope.cie10 ,op:2,usu:$scope.usuario}).success(function(data){
	      });
    }
	}

/////////////// datos de c10 
$scope.cie10 = [];
$scope.codigo="";
$scope.c10_id_pk=0;
$scope.c10nuevo=true;
$scope.c10editar=false;

// acciones a tomar 
$scope.rec_op="add";
$scope.c10_accion=function(){
  if ($scope.rec_op === "add"){$scope.addc10();} 
  if ($scope.rec_op === "upd"){$scope.updcie10();} 
}
$scope.ec10_accion=function(){
  if ($scope.rec_op === "add"){$scope.nuevoc10();} 
  if ($scope.rec_op === "upd"){$scope.updcie10();} 
}
//agregar datos en el array 
$scope.addc10 = function(){
    $http.post('src/sgh/epicrisis/php/sghGetcie10.php',{codigo:$scope.codigo}).success(function(data){
       console.log(data);
        if (data !='null'){
 			 $scope.cie10.push({c10_id: $scope.c10_id_pk, c10_nombre:data[0].c10_nombre, c10_codigo:data[0].c10_codigo, dia_resp:'true', c10_id_pk:data[0].c10_id_pk});
 			 $scope.c10_id_pk=$scope.c10_id_pk+1;  
 			 }else{
			 alert("Codigo cie10 no encontrado");
			 }
	});
 $scope.codigo="";
};
///cargar datos del array 
$scope.edic10=function(id){
  $scope.rec_op="upd";
  $scope.rec_codi=id;
  $scope.codigo=$scope.cie10[ $scope.rec_codi].c10_codigo;
}

$scope.eedic10=function(id,id_dia){
  $scope.rec_op="upd";
  $scope.rec_codi=id;
  $scope.dia_id_pk=id_dia;
  $scope.codigo=$scope.cie10[ $scope.rec_codi].c10_codigo;
}

//editar datos  del array 
$scope.updcie10=function(id){
    console.log("Actualizar CIE10");
    $http.post('src/sgh/epicrisis/php/sghGetcie10.php',{codigo:$scope.codigo}).success(function(data){
      console.log(data);
  			 if (data != "null"){
   			 $scope.cie10[$scope.rec_codi]={c10_id_pk:data[0].c10_id_pk,c10_id: $scope.rec_codi, c10_nombre:data[0].c10_nombre, c10_codigo:data[0].c10_codigo, dia_resp:'true',dia_id_pk:$scope.dia_id_pk};
   			 }else{
  			 alert("Codigo cie10 no encontrado");
  			 }
  	});
    $scope.codigo="";
    $scope.rec_op="add";
}
// ELIMINAR DATOS DE ARRAY DE CIE 10
$scope.delec10=function(){
 $scope.cie10=[];
 $scope.c10_id_pk=0;
}
/// AGREGA NUEVO DIAGNOSTICO EN EDICION 
$scope.nuevoc10=function(){
  console.log("Nuevo CIE10");
    $http.post('src/sgh/epicrisis/php/sghGetcie10.php',{codigo:$scope.codigo}).success(function(data){
      console.log("Entro a cie10");
      if (data != "null"){
        console.log("Paso a CIE10 ");
            $http.post('src/sgh/interconsulta/php/sghInserInterconsulta.php',{int_id_pk:$scope.int_id_pk,c10_id_pk:data[0].c10_id_pk, dia_resp:'true',op:7,usu:$scope.usuario}).success(function(data)
              { 
                console.log("Cargo CIE10  ",data);
                $scope.cargac10();
              });
                
       }else
       {
       alert("Codigo cie10 no encontrado");
       }
    });
 }

 ////// cargar medico datos
 	$scope.busmed=function(){$scope.medi=true;}
     mds_sersol:"";
	$http.post('src/sgh/interconsulta/php/sghgetMedico.php',{op:1}).success(function (data) {
        $scope.medico= data; console.log(data);

    });
   /// cargar medico texto a guardar
	$scope.cargar=function(){
	$http.post('src/sgh/interconsulta/php/sghgetMedico.php',{op:2,codigo:$scope.idmedi}).success(function (data) {
        console.log(data);
	    $scope.medi=false;
        	 $scope.medico1= data;
        	 $scope.datosAguardar.med_id_fk=$scope.idmedi;
             $scope.datosAguardar.mds_medico=data[0].per_nombres+' '+  data[0].per_apellidomaterno;
     })
	}


/// VERIFICACION DE INFORME DE INTERCONSULTA 
  $scope.verinfo=function(id){
  $scope.solicitud=false;
  $scope.informe=true;
  $scope.op="Informe";
  $scope.id=id;
  $http.post('src/sgh/interconsulta/php/sghListaInterconsulta.php',{op:4,codigo:id}).success(function (data) {
       if (data === "0")
       {
		  $("#nuevo").click();
       }
       else
       {
       	alert("Ya se realizo un informe");
        $scope.cancelar();	
       }
  	 })
  }

$scope.ginforme=function(){
      $scope.actguar=true;
      $scope.actguarda=true;
      var file = $scope.file;
    if (file ===undefined){
       alert("Desea guardar sin adjuntar un  archivo");
        $scope.archi="no";
        $http.post('src/sgh/interconsulta/php/sghInserInterconsulta.php',{int:$scope.datosAguardar, hcl:$scope.histoclinica, usu:$scope.usuario, op:3, archivo:$scope.archi,id:$scope.id}).success(function(data){
            $scope.text = data.sgh_interconsulta_ingro_pa;
            $scope.mensaje= true;
            setTimeout(function(){
                $scope.mensaje= false;
                $scope.actguar=false;
                $scope.$apply();
                $scope.cancelar();
            },1500);
            $scope.dingreso();
            console.log(data);
        })
    }
    else{
    upload.uploadFile(file, name).success(function(res)
    {
        $scope.text=res;
        if ($scope.text==="Guardado")
        {

            $scope.archi="si";
            $scope.actguarda=false;
            $http.post('src/sgh/interconsulta/php/sghInserInterconsulta.php',{int:$scope.datosAguardar, hcl:$scope.histoclinica, usu:$scope.usuario, op:3, archivo:$scope.archi,id:$scope.id}).success(function(data){
                $scope.text = data.sgh_interconsulta_ingro_pa;
                $scope.mensaje= true;
                setTimeout(function(){
                   $scope.mensaje= false;$scope.actguar=false;
                   $scope.$apply();
                    $scope.cancelar();
                 },1500);
                  $scope.dingreso();
                console.log(data);
             })
        }
        else {
            $scope.actguarda=false;
            $scope.text=res;
            $scope.mensaje= true;
            $scope.actguar=false;
            setTimeout(function()
            {
                $scope.mensaje= false;
                $scope.$apply();
                angular.element("input[type='file']").val(null);
                //$("#closemodal").click();
                //$scope.actu();
                $scope.actguar=false;            $scope.actguarda=false;

            }, 5000);
        }
        console.log(res);
    })
    }
}

/// ver datos
$scope.datos=function(id){
 $scope.intdatos=true;	
 $scope.tabla=false; 
 $http.post('src/sgh/interconsulta/php/sghListaInterconsulta.php',{op:'6',codigo:id}).success(function (data) {
        $scope.datosoli = data;

 }); 
 $http.post('src/sgh/interconsulta/php/sghListaInterconsulta.php',{op:'2',codigo:id}).success(function (data) {
        $scope.datosinfor = data;
        if (data[0].int_archivo != null){
            $scope.archivo=true;
        }else{$scope.archivo=false;}
     console.log(data);
 }); 

 $http.post('src/sgh/interconsulta/php/sghListaInterconsulta.php',{op:'3',codigo:id}).success(function (data) {
        $scope.diasol = [];
     for (var i = 0 ; i < data.length ; i++) {
         $scope.c10_id_pk=i;
         $scope.diasol.push({c10_id:$scope.c10_id_pk, c10_nombre:data[i].c10_nombre, c10_codigo:data[i].c10_codigo, dia_resp:$scope.com_string(data[i].dia_resp),dia_id_pk:data[i].dia_id_pk ,c10_id_pk:data[i].c10_id_pk});
     }
  });

     $http.post('src/sgh/interconsulta/php/sghListaInterconsulta.php',{op:'5',codigo:id}).success(function (data) {
        $scope.diainfo = [];
         for (var i = 0 ; i < data.length ; i++) {
             $scope.c10_id_pk=i;
             $scope.diainfo.push({c10_id:$scope.c10_id_pk, c10_nombre:data[i].c10_nombre, c10_codigo:data[i].c10_codigo, dia_resp:$scope.com_string(data[i].dia_resp),dia_id_pk:data[i].dia_id_pk ,c10_id_pk:data[i].c10_id_pk});
             }
     });
}

////////// FUNCIONES DE EDICION DE DATOS /////////////////
$scope.opedicion=false;
$scope.opsol="nuevo";
$scope.accionsoli=function(){
  if($scope.opsol === 'nuevo') { 
    $scope.guardar();
    }
  if($scope.opsol === 'editar') {
    $scope.actualizarsol();
  }
}

$scope.editar=function(id){
$scope.op="";  
$scope.solicitud=false;
$scope.informe=false;
$scope.opedicion=true;
$scope.int_id_pk=id;
$scope.c10nuevo=false;
$scope.c10editar=true;
    $http.post('src/sgh/interconsulta/php/sghListaInterconsulta.php',{op:4,codigo:id}).success(function (data) {
        if (data === "0")
        {
            $scope.sol_edita=true;
        }
        else
        {
           $scope.sol_edita=false;
        }
        });
}
  // cargar datos de solicitud 
$scope.edisol=function(){
  // LLENA DATOS DE EDICION
   $http.post('src/sgh/interconsulta/php/sghListaInterconsulta.php',{op:7, codigo:$scope.int_id_pk,usu:$scope.usuario}).success(function (data) {
     if (data != "0")
      {   $scope.titulo="Editar Registro";
          $scope.op="Editando Solicitud";
          $scope.opsol='editar';
          $scope.condi=false;

        $scope.solicitud=true;
        $scope.opedicion=false;
        $scope.int_id_pk=data[0].int_id_pk;
          $scope.idmedi=0+"";
         $scope.datosAguardar={
              int_cuclia:data[0].int_cuclia,
              int_resexa:data[0].int_resexa,
              int_planes:data[0].int_planes,
              int_id_pk:data[0].int_id_pk,
              mds_sersol:data[0].mds_sersol,
              mds_grabed:data[0].mds_grabed,
              med_id_fk:data[0].med_id_fk,
              mds_id_pk:data[0].mds_id_pk,
              mds_medico:data[0].mds_medico
          }
          $scope.cargac10();

           $http.post('src/sgh/interconsulta/php/sghgetMedico.php',{op:2,codigo:$scope.datosAguardar.med_id_fk}).success(function (data) {
           $scope.medi=false;
           $scope.medico1= data;
     })
      }
      else
      {
          alert("Lo Sentimos, ya pasaron más de 24 horas");
      $("#can").click();
     // $scope.cancelar();
      }
     }); 
}
$scope.editarc10=function(){
       $http.post('src/sgh/interconsulta/php/sghInserInterconsulta.php',{c10:$scope.cie10, int:$scope.datosAguardar ,op:6,usu:$scope.usuario}).success(function(data)
       { 
        //console.log(data);
       });
}

$scope.actualizarsol = function()
  {
      $scope.actguar=true;
    //guardar epicrisis
     $http.post('src/sgh/interconsulta/php/sghInserInterconsulta.php',{int:$scope.datosAguardar ,op:4,usu:$scope.usuario}).success(function(data){
           $scope.text = data.sgh_interconsulta_ingreso_pa;
           $scope.mensaje= true;
           
           setTimeout(function(){
            $scope.mensaje= false;
            $scope.$apply();
            $scope.editarc10();
            $("#can").click();
            $scope.cancelar();    
          },1500);
          console.log(data); 
  });
  }
  // cargar datos de informe

  //// cargar datos deinforme
$scope.opsol="nuevo";
$scope.accioninform=function(){
  if($scope.opsol === 'nuevo') { 
    $scope.ginforme();
    }
  if($scope.opsol === 'editar') {
 
    $scope.actualizarinfor();
  }
}
$scope.infoarchivo=true;
$scope.ediinfor=function(){
    $scope.infoarchivo=false;
  // LLENA DATOS DE EDICION ///////

   $http.post('src/sgh/interconsulta/php/sghListaInterconsulta.php',{op:8, codigo:$scope.int_id_pk,usu:$scope.usuario}).success(function (data) {
     if (data != "0")
      {
          $scope.titulo="Editar Registro";
          $scope.op="Editando informe";
          $scope.opsol ='editar';
          $scope.condi=false;
        $scope.informe=true;
        $scope.opedicion=false;
        $scope.int_id_pk=data[0].int_id_pk;
         $scope.datosAguardar={
              int_cucint:data[0].int_cucint,
              int_plandia:data[0].int_plandia,
              int_pltrap:data[0].int_pltrap,
              int_recrcl:data[0].int_recrcl, 
              int_id_pk:data[0].int_id_pk,     
          }
          $scope.cargac10();
        
      }
      else
      {
       alert("Lo Sentimos ya pasaros +  de 24 horas");
      //$("#can").click();
      // $scope.cancelar();

      }
      console.log(data);
     }); 

}

$scope.actualizarinfor = function()
  {  $scope.actguar=true;
    //guardar epicrisis
     $http.post('src/sgh/interconsulta/php/sghInserInterconsulta.php',{int:$scope.datosAguardar ,op:5,usu:$scope.usuario}).success(function(data){
           $scope.text = data.sgh_interconsulta_ingreso_pa;
           $scope.mensaje= true;
           
           setTimeout(function(){
            $scope.mensaje= false;
            $scope.$apply();
            $scope.editarc10();
            $("#can").click();
            $scope.cancelar();    
          },1500);
         console.log(data);
  });
  }
  // cargar datos de c10

  $scope.com_string=function(valor){if (valor == true) {return 'true'}else{return 'false'}};
  $scope.cargac10=function(){
   $http.post('src/sgh/interconsulta/php/sghListaInterconsulta.php',{op:'3',codigo:$scope.int_id_pk}).success(function (data) {
              console.log("Carga CIE10: ",data);
             $scope.cie10=[];
             for (var i = 0 ; i < data.length ; i++) {
                $scope.c10_id_pk=i;
                $scope.cie10.push({c10_id:$scope.c10_id_pk, c10_nombre:data[i].c10_nombre, c10_codigo:data[i].c10_codigo, dia_resp:$scope.com_string(data[i].dia_resp),dia_id_pk:data[i].dia_id_pk ,c10_id_pk:data[i].c10_id_pk});
             }
           });

  }


}])


.directive('uploaderModel', ["$parse", function ($parse) {
    return {
        restrict: 'A',
        link: function (scope, iElement, iAttrs)
        {
            iElement.on("change", function(e)
            {
                $parse(iAttrs.uploaderModel).assign(scope, iElement[0].files[0]);
            });
        }
    };
}])

    .service('upload', ["$http", "$q", function ($http, $q)
    {
        this.uploadFile = function(file, name)
        {
            var deferred = $q.defer();
            var formData = new FormData();
            formData.append("name", name);
            formData.append("file", file);
            return $http.post("src/sgh/interconsulta/php/int_sube.php", formData,
                {
                    headers: {
                        "Content-type": undefined
                    },
                    transformRequest: angular.identity
                }
            )
                .success(function(res)
                {
                    deferred.resolve(res);
                })
                .error(function(msg, code)
                {
                    deferred.reject(msg);
                })
            return deferred.promise;
        }
    }])