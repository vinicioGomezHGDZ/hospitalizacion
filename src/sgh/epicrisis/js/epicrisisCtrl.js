angular.module("epicrisis",['ngRoute'])
.controller('epicrisisCtrl',['$scope','$http','$routeParams',function($scope,$http,$routeParams){
$scope.footer=false;
$scope.Fecha = new Date();
$scope.datosAguardar={
		  epi_altdef:false,
		  epi_altran:false,
		  epi_asinto:false,
		  epi_dislev:false,
		  epi_dismod:false,
		  epi_disgra:false,
		  epi_retaut:false,
		  epi_retnau:false,
		  epi_dme48h:false,
		  epi_dma48h:false,
		  epi_diadin:0,
			};
    if ($scope.sgh_v_user === undefined){$scope.cerrarsecion();}
//datos que estraigo de los campos para guardar
$scope.mensaje=false ;
//variables de paginacion

$scope.posicion=null;// guarda el total de items de la tabla
$scope.pagina=1; // variable de paginas a mostrar	
///////////////
$scope.act_voalresidente=function (op) {  
  
    if ($scope.usu_perfil === 'TRATANTE' || $scope.usu_perfil === 'RESIDENTE' ){
       
       if (op === true){return resestado=true;}
       else{return resestado=false;}

    }else{return resestado=true;  }
}

$scope.act_editaepi=function (op) {  
    if ($scope.usu_perfil === 'TRATANTE' || $scope.usu_perfil === 'RESIDENTE'){
       if (op === true){return resestado=true;}
       else{return resestado=false;}

    }else{return resestado=true;  }
}
// carga datos del medio
$scope.esresident=function(id) {

      $http.post('src/sgh/evolucion/php/sghListaEvoluciones.php',{op:4,codigo:$scope.usuario}).success(function (datar) {
      console.log(datar);
            if ( datar[0].pro_codigomsp === null){
                if (datar[0].pro_codigosenescyt === null)
          {$scope.msp="C.I " + datar[0].per_numeroidentificacion;}
                else
        {$scope.msp=datar[0].pro_codigosenescyt};
            }
            else{
                $scope.msp=datar[0].pro_codigomsp;
            }
                var profecional = datar[0].medico

               $http.post('src/sgh/epicrisis/php/sghInserEpicrisis.php',{op:10,codigo:id, respon:profecional,msp:$scope.msp,usu:$scope.usuario}).success(function(data){
                   console.log(data);
                   $scope.actu();

                });
        });
    }


//////////////
$scope.diasestadia=function(){
 $http.post('src/sgh/epicrisis/php/sghListaEpicrisis.php',{op:'6',idce:$scope.id_cen_pk}).success(function (data) {
       $scope.datosAguardar.epi_diaest = parseInt(data[0].dia);
       //console.log(data);
     }); 

}

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
   $http.post('src/sgh/epicrisis/php/sghListaEpicrisis.php',{op:'1',idhc:$scope.histoclinica}).success(function (data) {
       console.log(data);
        if (data.error === "error") {console.log(data);}
        else{
        $scope.epicrisis = data;
 		    $scope.posicion=Math.ceil(data.length / $scope.totalpaginas);
    	}
       $scope.diasestadia();

     });
    $http.get('src/sgh/cie10/php/sghListarc10.php').success(function (data) {
        $scope.datosc10 = data;
        $scope.posicion2=Math.ceil(data.length / $scope.totalpaginas);
    });
}
    $scope.agregac10=function (valor) {
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
    $scope.agregac10e=function (valor) {
        $scope.codigoe=valor;
        $scope.bc10e=false;
        $scope.b_buscare=true;
    }
    $scope.bc10e=false;
    $scope.b_buscare=true;
    $scope.buscac10e=function () {
        $scope.bc10e=true;
        $scope.b_buscare=true;
    }



if ($scope.histoclinica === null){
 // alert("Escoja un pacinete");
  window.location = "#/"
}else{
$scope.actu();
 $http.post('src/sgh/epicrisis/php/sghgetMedico.php',{op:1}).success(function (data) {
     // console.log(data);
     $scope.medico= data;
  });
}
 $scope. paginas = function(tipo)

{if (tipo == 0 && $scope.pagina  > 1 ){$scope.pagina-=1;}
 else if (tipo == 1 && $scope.pagina < $scope.posicion ){$scope.pagina+=1;}
}
// GUARDAR DATOS
    if ($scope.usu_perfil === 'ENFERMERA(O)' || $scope.usu_perfil === 'AUXILIAR DE ENFERMERÍA' ){$scope.admi=true}

$scope.cancelar = function(){
		  $("#closemodal").click()
			$scope.datosAguardar={
			  epi_altdef:false,
			  epi_altran:false,
			  epi_asinto:false,
			  epi_dislev:false,
			  epi_dismod:false,
			  epi_disgra:false,
			  epi_retaut:false,
			  epi_retnau:false,
			  epi_dme48h:false,
			  epi_dma48h:false,
			  epi_diadin:0,
			};
    	$scope.op="nuevo";
      $scope.titulo="Nuevo Registro";// titulo del modal
    	$scope.actu();
      $scope.cie10=[];
      $scope.cie10e=[];
      $scope.medico1=[];
     	$scope.c10_id_pk=0;
      $scope.c10_id_pke=0;
      $scope.codigo="";
      $scope.rec_op="add";
      $scope.c10nuevo=true;
      $scope.c10editar=false;
    $scope.c10nuevoe=true;
    $scope.c10editare=false;
}

$scope.resetGlobal = function(){
  $scope.datosAguardar={
    epi_altdef:false,
    epi_altran:false,
    epi_asinto:false,
    epi_dislev:false,
    epi_dismod:false,
    epi_disgra:false,
    epi_retaut:false,
    epi_retnau:false,
    epi_dme48h:false,
    epi_dma48h:false,
    epi_diadin:0,
  };
  $scope.op="nuevo";
  $scope.titulo="Nuevo Registro";// titulo del modal
  $scope.actu();
  $scope.cie10=[];
  $scope.cie10e=[];
  $scope.medico1=[];
   $scope.c10_id_pk=0;
  $scope.c10_id_pke=0;
  $scope.codigo="";
  $scope.rec_op="add";
  $scope.c10nuevo=true;
  $scope.c10editar=false;
$scope.c10nuevoe=true;
$scope.c10editare=false;
}

$scope.actguarda=false;
    //guardar epicrisis
    $http.post('src/sgh/epicrisis/php/sghListaEpicrisis.php?',{op:8,fecha:$scope.cen_fecha,hcl:$scope.histoclinica}).success(function (data) {
        // console.log(data);
        if (data.error != "error") {$scope.admi=true;}
    });

$scope.guardar = function()
  {	$scope.actguarda=true;
      $http.post('src/sgh/epicrisis/php/sghListaEpicrisis.php?',{op:7,fecha:$scope.cen_fecha,hcl:$scope.histoclinica}).success(function (data) {
          if (data.error === "error") {$scope.adm_id_pk=null;}
          else{
          $scope.adm_id_pk=data[0].adm_id_pk;
          }

          $http.post('src/sgh/epicrisis/php/sghInserEpicrisis.php',{res:$scope.datosAguardar, hcl:$scope.histoclinica, usu:$scope.usuario,op:1, codigo:$scope.adm_id_pk}).success(function(data){
               console.log(data);
              $scope.text = data.sgh_epicrisis_ingreso_pa;
              $scope.mensaje= true;
              setTimeout(function()
              {
                  $scope.dingreso();
                  $scope.degreso();
                  $scope.guardamedico();
              }, 1500);
          });

          setTimeout(function()
          {
              $scope.$apply();
              $scope.mensaje= false;
              $scope.actguarda=false;
              $scope.cancelar();
          }, 3000);
      });
  }

   // guarda cie10 ingreso
// guardar diagnosticos
$scope.dingreso=function(){
    $scope.tipo="INGRESO";
   if ($scope.cie10!= null){
       $http.post('src/sgh/epicrisis/php/sghInserEpicrisis.php',{c10:$scope.cie10 ,op:2,tip:$scope.tipo,usu:$scope.usuario}).success(function(data){console.log(data);});
   }

   }
$scope.degreso=function(){
    $scope.tipo="EGRESO";
   if ($scope.cie10!= null){
       $http.post('src/sgh/epicrisis/php/sghInserEpicrisis.php',{c10:$scope.cie10e ,op:2,tip:$scope.tipo,usu:$scope.usuario}).success(function(data){    console.log(data);});
   }
   }
////// GUARDAR MEDICO
$scope.guardamedico=function(){
  if ($scope.medico1 != null){
       $http.post('src/sgh/epicrisis/php/sghInserEpicrisis.php',{med:$scope.medico1 ,op:3,usu:$scope.usuario}).success(function(data)
         {  
          // console.log(data);
       });
    }
    }   

/////////////// datos de c10  diagnostico ingreso/////////////
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
	    if (data != "null"){
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
    $http.post('src/sgh/epicrisis/php/sghGetcie10.php',{codigo:$scope.codigo}).success(function(data){
  			 if (data != "null"){
   			 $scope.cie10[$scope.rec_codi]={c10_id_pk:data[0].c10_id_pk,
                                             c10_id: $scope.rec_codi,
                                             c10_nombre:data[0].c10_nombre,
                                             c10_codigo:data[0].c10_codigo,
                                             dia_resp:'true',
                                             dia_id_pk:$scope.dia_id_pk};
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
      $scope.tipo="INGRESO";
    $http.post('src/sgh/epicrisis/php/sghGetcie10.php',{codigo:$scope.codigo}).success(function(data){
      if (data != "null"){
            //alert("GUARDANDO ");
            $http.post('src/sgh/epicrisis/php/sghInserEpicrisis.php',{int_id_pk:$scope.int_id_pk, c10_id_pk:data[0].c10_id_pk,usu:$scope.usuario, dia_resp:'true',tip:$scope.tipo,op:6}).success(function(data)
              { 
                // console.log(data);
                $scope.cargac10();
              });
                
       }else
       {
       alert("Codigo cie10 no encontrado");
       }
    });
  $scope.codigo="";
 }

////diagnostico egreso cie 10 ////
$scope.cie10e = [];
$scope.codigoe="";
$scope.c10_id_pke=0;
$scope.c10nuevoe=true;
$scope.c10editare=false;
// acciones a tomar 
$scope.rec_ope="add";
$scope.c10_accione=function(){
  if ($scope.rec_ope === "add"){$scope.addc10e();} 
  if ($scope.rec_ope === "upd"){$scope.updcie10e();} 
}
$scope.ec10_accione=function(){

  if ($scope.rec_ope === "add"){$scope.nuevoc10e();} 
  if ($scope.rec_ope === "upd"){$scope.updcie10e();} 
}
//agregar datos en el array 
$scope.addc10e = function(){
    $http.post('src/sgh/epicrisis/php/sghGetcie10.php',{codigo:$scope.codigoe}).success(function(data){

			 if (data != "null"){
 			 $scope.cie10e.push({c10_id: $scope.c10_id_pke, c10_nombre:data[0].c10_nombre, c10_codigo:data[0].c10_codigo, dia_resp:'true', c10_id_pk:data[0].c10_id_pk});
 			 $scope.c10_id_pke=$scope.c10_id_pke+1;  
 			 }else{
			 alert("Codigo cie10 no encontrado");
			 }
	});
 $scope.codigoe="";
};
///cargar datos del array 
$scope.edic10e=function(id){
  $scope.rec_ope="upd";
  $scope.rec_codie=id;
  $scope.codigoe=$scope.cie10e[$scope.rec_codie].c10_codigo;
}
$scope.eedic10e=function(id,id_dia){
  $scope.rec_ope="upd";
  $scope.rec_codie=id;
  $scope.dia_id_pke=id_dia;
  $scope.codigoe=$scope.cie10e[ $scope.rec_codie].c10_codigo;
}
//editar datos  del array 
$scope.updcie10e=function(){

    $http.post('src/sgh/epicrisis/php/sghGetcie10.php',{codigo:$scope.codigoe}).success(function(data){
  			 if (data != "null"){
   			 $scope.cie10e[$scope.rec_codie]={
   			     c10_id_pk:data[0].c10_id_pk,
                 c10_id: $scope.rec_codi,
                 c10_nombre:data[0].c10_nombre,
                 c10_codigo:data[0].c10_codigo,
                 dia_resp:'true',
                 dia_id_pk:$scope.dia_id_pke};

  			 }else{
  			 alert("Codigo cie10 no encontrado");
  			 }
  	});
    $scope.codigo="";
    $scope.rec_ope="add";
}
// ELIMINAR DATOS DE ARRAY DE CIE 10
$scope.delec10e=function(){
 $scope.cie10e=[];
 $scope.c10_id_pke=0;
}
/// AGREGA NUEVO DIAGNOSTICO EN EDICION 
$scope.nuevoc10e=function(){

      $scope.tipo="EGRESO";
    $http.post('src/sgh/epicrisis/php/sghGetcie10.php',{codigo:$scope.codigoe}).success(function(data){
          // console.log(data);
          if (data != "null"){
          // console.log(data);
             $http.post('src/sgh/epicrisis/php/sghInserEpicrisis.php',{int_id_pk:$scope.int_id_pk,usu:$scope.usuario ,c10_id_pk:data[0].c10_id_pk, dia_resp:'true',tip:$scope.tipo,op:6}).success(function(data)
              { 
                // console.log(data);
                $scope.cargac10e();
              });
                
       }else
       {
       alert("Codigo cie10 no encontrado");
       }
    });
  $scope.codigoe="";
 }

///////////////  AGREGAR DATOS DE MEDICO /////
$scope.idmedi=0+"";
$scope.medi=false;
$scope.medico1 = [];
$scope.med_id_pk=0;
$scope.mednuevo=true;
$scope.mededitare=false;
$scope.buscar=function(){
$scope.medi=true;

}
$scope.medcancela=function(){
  $scope.medi=false;
  $scope.med_op="add";
  $scope.idmedi=0+"";
}
// acciones a tomar 
$scope.med_op="add";
$scope.med_accion=function(){
  if ($scope.med_op === "add"){$scope.addmed();} 
  if ($scope.med_op === "upd"){$scope.updmed();} 
}
$scope.med_accione=function(){
  if ($scope.med_op === "add"){$scope.nuevomed();} 
  if ($scope.med_op === "upd"){$scope.updmed();} 
}
//agregar datos en el array 
$scope.addmed = function(){
  $http.post('src/sgh/epicrisis/php/sghgetMedico.php',{op:2,codigo:$scope.idmedi}).success(function (data) {
       if ($scope.idmedi != 0){
       $scope.medico1.push({med_id: $scope.med_id_pk, per_nombres:data[0].per_nombres, per_apellidopaterno:data[0].per_apellidopaterno,per_apellidomaterno:data[0].per_apellidomaterno,esp_descripcion:data[0].esp_descripcion,pro_codigomsp:data[0].pro_codigomsp,med_period:"", pro_id_pk:data[0].pro_id_pk});
       $scope.med_id_pk = $scope.med_id_pk + 1;
       $scope.medi=false;
       $scope.idmedi=0+"";
       }else{
       alert("Medico no encontrado");
       }
       // console.log(data);
    });
   $scope.codigoe="";
};
///cargar datos del array 
$scope.edimed=function(id){
    $scope.medi=true;
  $scope.med_op="upd";
  $scope.med_id=id;
  $scope.idmedi=$scope.medico1[id].pro_id_pk+"";
  $scope.codmed=$scope.medico1[id].pro_id_pk;
  $scope.med_id_pk=$scope.medico1[id].med_id;

  $scope.med_period=$scope.medico1[id].med_period;
}
//editar datos  del array 
$scope.updmed=function(){

     $http.post('src/sgh/epicrisis/php/sghgetMedico.php',{op:2,codigo:$scope.codmed}).success(function (data) {
         // console.log(data);
         if ($scope.idmedi != ""){
            // alert("cambiando");

         $scope.medico1[$scope.med_id]={med_id:$scope.med_id, per_nombres:data[0].per_nombres, per_apellidopaterno:data[0].per_apellidopaterno, per_apellidomaterno:data[0].per_apellidomaterno,esp_descripcion:data[0].esp_descripcion,pro_codigomsp:data[0].pro_codigomsp, med_period:$scope.med_period, pro_id_pk:data[0].pro_id_pk};
         $scope.idmedi=0+"";
             // console.log($scope.medico1);
         }else{
         alert("Codigo cie10 no encontrado");
         }
      });
     $scope.med_op="add";
      $scope.medi=false;
}
// ELIMINAR DATOS DE ARRAY DE CIE 10
$scope.delemed=function(){
 $scope.medico1=[];
 $scope.med_id_pke=0;
}
/// AGREGA NUEVO DIAGNOSTICO EN EDICION 
$scope.nuevomed=function(){
        
      $http.post('src/sgh/epicrisis/php/sghgetMedico.php',{op:2,codigo:$scope.idmedi}).success(function (data) {

          if ($scope.idmedi != 0){
            $http.post('src/sgh/epicrisis/php/sghInserEpicrisis.php',{usu:$scope.usuario,int_id_pk:$scope.int_id_pk, med_period:"", pro_id_pk:data[0].pro_id_pk ,op:8}).success(function(data)
              { 

                $scope.cargamedico();
                // console.log(data);
              });
                
       }else
       {
       alert("Codigo cie10 no encontrado");
       }
    });
   $scope.medi=false;   
 }

//// Cargar De Datos imoreción
$scope.datos=false;
$scope.tabla=true;
$scope.regresar=true;
$scope.datosepi=function(id){
	$scope.datos=true;
     $scope.tabla=false;
     $http.post('src/sgh/epicrisis/php/sghListaEpicrisis.php',{op:2, codigo:id}).success(function (data) {
        $scope.datepi = data;
     }); 

      $http.post('src/sgh/epicrisis/php/sghListaEpicrisis.php',{op:3, codigo:id,tipo:'INGRESO'}).success(function (data) {
        $scope.c10ingreso = [];
          for (var i = 0 ; i < data.length ; i++) {
              $scope.c10_id_pk=i;
              $scope.c10ingreso.push({c10_id:$scope.c10_id_pk, c10_nombre:data[i].c10_nombre, c10_codigo:data[i].c10_codigo, dia_resp:$scope.com_string(data[i].dia_resp),dia_id_pk:data[i].dia_id_pk ,c10_id_pk:data[i].c10_id_pk});
          }
     });

         $http.post('src/sgh/epicrisis/php/sghListaEpicrisis.php',{op:3, codigo:id, tipo:'EGRESO'}).success(function (data) {
        $scope.c10egreso = [];
             for (var i = 0 ; i < data.length ; i++) {
                 $scope.c10_id_pk=i;
                 $scope.c10egreso.push({c10_id:$scope.c10_id_pk, c10_nombre:data[i].c10_nombre, c10_codigo:data[i].c10_codigo, dia_resp:$scope.com_string(data[i].dia_resp),dia_id_pk:data[i].dia_id_pk ,c10_id_pk:data[i].c10_id_pk});
             }

     }); 
    
           $http.post('src/sgh/epicrisis/php/sghListaEpicrisis.php',{op:4, codigo:id}).success(function (data) {
           $scope.datomedico = data;
           // console.log(data);
     }); 
    
	}

$scope.atras=function(){
  $scope.datos=false;
  $scope.regresar=true;
  $scope.tabla=true;

}

////Editar datos ///

    $scope.com_string=function(valor){if (valor == true) {return 'true'}else{return 'false'}};
$scope.cargac10=function(){
     $http.post('src/sgh/epicrisis/php/sghListaEpicrisis.php',{op:3, codigo:$scope.int_id_pk,tipo:'INGRESO'}).success(function (data) {
            if (data.error==='error'){$scope.cie10=[];}
            else{
             $scope.cie10=[];
             for (var i = 0 ; i < data.length ; i++) {
                $scope.c10_id_pk=i;
                $scope.cie10.push({c10_id:$scope.c10_id_pk, c10_nombre:data[i].c10_nombre, c10_codigo:data[i].c10_codigo, dia_resp:$scope.com_string(data[i].dia_resp), dia_id_pk:data[i].dia_id_pk ,c10_id_pk:data[i].c10_id_pk});
             }
            }
         //  console.log(data);
     });

}
$scope.cargac10e=function(){
     $http.post('src/sgh/epicrisis/php/sghListaEpicrisis.php',{op:3, codigo:$scope.int_id_pk,tipo:'EGRESO'}).success(function (data) {
         if (data.error==='error'){$scope.cie10e=[];}
         else {
             $scope.cie10e = [];
             for (var i = 0; i < data.length; i++) {
                 $scope.c10_id_pke = i;
                 $scope.cie10e.push({
                     c10_id: $scope.c10_id_pke,
                     c10_nombre: data[i].c10_nombre,
                     c10_codigo: data[i].c10_codigo,
                     dia_resp: $scope.com_string(data[i].dia_resp),
                     dia_id_pk: data[i].dia_id_pk,
                     c10_id_pk: data[i].c10_id_pk
                 });
             }
         }
           // console.log(data);
           });
}
$scope.cargamedico=function(){
$http.post('src/sgh/epicrisis/php/sghListaEpicrisis.php',{op:4, codigo:$scope.int_id_pk}).success(function (data) {
      $scope.medico1=[];
      for (var i = 0 ; i < data.length ; i++) {
         $scope.med_id_pk =i;
         $scope.medico1.push({med_id: $scope.med_id_pk, per_nombres:data[i].per_nombres, per_apellidopaterno:data[i].per_apellidopaterno, per_apellidomaterno:data[i].per_apellidomaterno, esp_descripcion:data[i].esp_descripcion,pro_codigomsp:data[i].pro_codigomsp, med_period:data[i].med_period, pro_id_pk:data[i].pro_id_pk, med_id_pk:data[i].med_id_pk });
      }
       // console.log(data);
    });
}

$scope.edita=function(codigo,fecha){
  if ($scope.edita_paciente === true)
  {
      $scope.opedi=10;
      $scope.opacrualiza=9;

  }else{
      $scope.opedi=5;
      $scope.opacrualiza=4;
  }

  $scope.titulo="Editar Registro";
  $scope.op="editar";
  $scope.solicitud=false;
  $scope.informe=false;
  $scope.opedicion=true;
  $scope.int_id_pk=codigo;
  $scope.c10nuevo=false;
  $scope.c10editar=true;
  $scope.c10nuevoe=false;
  $scope.c10editare=true;

  // LLENA DATOS DE EDICION
 $http.post('src/sgh/epicrisis/php/sghListaEpicrisis.php',{op:$scope.opedi,cen_fecha:$scope.cen_fecha, codigo:codigo,usu:$scope.usuario}).success(function (data) {
     if (data != "0")
      {  
        $scope.datosAguardar={
          epi_altdef:data[0].epi_altdef,
          epi_altran:data[0].epi_altran,
          epi_asinto:data[0].epi_asinto,
          epi_condic:data[0].epi_condic,
          epi_diadin:parseInt(data[0].epi_diadin),
          epi_diaest:parseInt(data[0].epi_diaest),
          epi_disgra:data[0].epi_disgra,
          epi_dislev:data[0].epi_dislev,
          epi_dismod:data[0].epi_dismod,
          epi_dma48h:data[0].epi_dma48h,
          epi_dme48h:data[0].epi_dme48h,
          epi_harexa:data[0].epi_harexa,
          epi_id_pk:data[0].epi_id_pk ,
          epi_recucl:data[0].epi_recucl,
          epi_reevco:data[0].epi_reevco,
          epi_retaut:data[0].epi_retaut,
          epi_retnau:data[0].epi_retnau,
          epi_rtrprt:data[0].epi_rtrprt,
          epi_respon:data[0].epi_respon,
          epi_rescmsp:data[0].epi_rescmsp,

        }
          $http.post('src/sgh/epicrisis/php/sghListaEpicrisis.php?',{op:9, fecha:fecha,hcl:$scope.histoclinica}).success(function (data) {
              console.log(data);
              if (data.error === "error") {
                  $scope.adm_id_pk = null;
              }
              else {
                  $scope.adm_id_pk = data[0].adm_id_pk;
              }
          });
          $scope.cargac10();
          $scope.cargac10e();
          $scope.cargamedico();
        $("#n").click();
      }
      else
      {
          alert("Lo Sentimos ya pasaron más de 24 horas");
       $scope.cancelar();
      }
     // console.log(data);
  });
}

$scope.editarc10=function(){
       $http.post('src/sgh/epicrisis/php/sghInserEpicrisis.php',{c10:$scope.cie10 ,op:5,usu:$scope.usuario}).success(function(data)
       { 
       // console.log(data);
       });
}
$scope.editarc10e=function(){
       $http.post('src/sgh/epicrisis/php/sghInserEpicrisis.php',{c10:$scope.cie10e ,op:5,usu:$scope.usuario}).success(function(data)
       { 
        // console.log(data);
       });
}
$scope.editamedico=function(){
    if ($scope.medico1 != null){
       $http.post('src/sgh/epicrisis/php/sghInserEpicrisis.php',{med:$scope.medico1 ,op:7,usu:$scope.usuario}).success(function(data)
         {  
          // console.log(data);
       });
    }
    } 

$scope.actualizar = function()
  {


          //guardar epicrisis
     $http.post('src/sgh/epicrisis/php/sghInserEpicrisis.php',{res:$scope.datosAguardar ,op:$scope.opacrualiza,codigo:$scope.adm_id_pk,usu:$scope.usuario}).success(function(data){
           $scope.text = data.sgh_epicrisis_ingreso_pa;
           $scope.mensaje= true;
           setTimeout(function(){
            $scope.mensaje= false;
            $scope.$apply();
            $scope.editarc10();
            $scope.editarc10e();
            $scope.editamedico();
            $("#can").click();
            $scope.cancelar();    
          },1500);

    });
          // setTimeout(function()
          // {
          //     $scope.$apply();
          //     $scope.mensaje= false;
          //     $scope.actguarda=false;
          //     $scope.cancelar();
          // }, 3000);

  }

}]);


