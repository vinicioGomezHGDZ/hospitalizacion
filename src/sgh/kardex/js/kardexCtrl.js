angular.module("kardex",['ngRoute'])
.controller('kardexCtrl',['$scope','$http',function($scope,$http){
    if ($scope.sgh_v_user === undefined){$scope.cerrarsecion();}
//variables de paginacion
$scope.posicionmedi=null;// guarda el total de items de la tabla
$scope.paginamedi=1; // variable de paginas a mostrar  
    $scope.datosAguardar=null;
////Control de Medicamentos//////////
$scope.nuevo=false;
$scope.agrega=true;
$scope.medicombo= 0+"";
$scope.cargamedicamento=function () {
    $http.post('src/sgh/kardex/php/sghListakardex.php',{op:3,codigo:$scope.medicombo}).success(function (data) {
        if (data.error === true) {}else{
            $scope.dotosmedicamentos = data;
        }

    });
}
// colores a kardes
    $scope.estado_colores=function (fecha) {

        if (fecha >= $scope.cen_fecha){

             return $scope.myStyle={'background-color':'#CEF6CE',color:'#190707'}

            }
        else{
            return $scope.myStyle={'background-color':'#FFFFFF',color:'#190707'}
        }

    }
/// Accion si edita o guarda registro 
$scope.titulo="Nuevo Registro";// titulo del modal
$scope.op="nuevo";
$scope.accion=function(){
  if($scope.op === 'nuevo') { 
    $scope.medicina();
    }
  if($scope.op === 'editar') {
    $scope.actualizar();
  }
}
$scope.nmedi = function(){
$scope.nuevo=true;   
$scope.agrega=false;   
}

$scope.canmedi = function(){
    $scope.ver_nuevo=true;
    $scope.eliminar=false;
    $scope.nuevo=false;
    $scope.agrega=true;
    $scope.medicinaguardar={};
    $scope.medicombo=0+"";
    $scope.op="nuevo";
    $scope.datosAguardar=null;//datos que estraigo de los campos para guardar
}
// paginacion de medicamentos
 $scope. pagimedi = function(tipo)
{if (tipo == 0 && $scope.paginamedi  > 1 )
    {$scope.paginamedi-=1;}else if (tipo == 1 && $scope.paginamedi < $scope.posicionmedi)
     {$scope.paginamedi+=1;}}

// LISTAR MEDICAMENTOS

$scope.medi=function(){
      $http.post('src/sgh/kardex/php/sghListakardex.php',{op:1,hcl:$scope.histoclinica}).success(function (data) {
           if (data.error === "error") {}else{
           $scope.medica = data;
            $scope.posicionmedi=Math.ceil(data.length / $scope.totalpaginas);
           }

         });

      $http.post('src/sgh/kardex/php/sghListakardex.php',{op:2,fecha:$scope.cen_fecha,hcl:$scope.histoclinica}).success(function (data) {
            $scope.medica_lista= data;

         });  
    }
 if ($scope.histoclinica === null){
  window.location = "#/"
}else{   
 $scope.medi();
}
//GUARDAR MEDICAMENTO
    $scope.actguarda=false;
$scope.medicina = function(){$scope.actguarda=true;
    $http.post('src/sgh/kardex/php/sghInserkardex.php',{op:1 ,med:$scope.medicinaguardar, hcl:$scope.histoclinica, usu:$scope.usuario}).success(function(data){
       console.log(data);
       $scope.text = data.sgh_kardex_inreso_pa;
       $scope.mensaje= true;
       
       setTimeout(function() 
        {
          $scope.mensaje= false;$scope.actguarda=false;
          $scope.$apply();
          //$("#closemodal").click();
           $scope.medi();
           $scope.canmedi();
        }, 1000);

  });
  }
//cargar datos de editar

$scope.edita=function(){
  $scope.titulo="Editar Registro";
  $scope.op="editar";

  if ($scope.medicombo == ""){
      $scope.text = "Seleccione un Medicamento";
      $scope.mensaje= true; 
       setTimeout(function() 
       {
        $scope.mensaje= false;
        $scope.$apply();
        $scope.medi();
        $scope.canmedi();
       }, 1500);
  }
  else{
    $scope.nmedi();
  // LLENA DATOS DE EDICION
  $http.get('src/sgh/kardex/php/sghGetKardex.php?c='+ $scope.medicombo).success(function(data){
     $scope.medicinaguardar={
        kar_medica: data[0].kar_medica
           };

  });
  }
}

 //atualizar 
$scope.actualizar = function(){

$http.post('src/sgh/kardex/php/sghInserkardex.php',{op:2,med:$scope.medicinaguardar,id:$scope.medicombo,usu:$scope.usuario}).success(function(data){
console.log(data);
       $scope.text = data.sgh_kardex_edita_pa;
       $scope.datosAguardar=null;
       $scope.mensaje= true; 
       setTimeout(function() 
       {
        $scope.mensaje= false;
        $scope.$apply();
        $scope.medi();

        $scope.canmedi();
       }, 1000);  
    
  });
}

/////////////////////////// administracion control////////////
$scope.limpia=function () {

    $scope.datosAguardar=null;
}
$scope.Fecha = new Date();
$scope.administracion = {};// Variable para cargar los datos de los puntos
$scope.encabesado={};// cargo datos de la historai clinica
$scope.mensaje=false ;

//variables de paginacion
    $scope.posicion=null;// guarda el total de items de la tabla
    $scope.pagina=1; // variable de paginas a mostrar

    $scope.paginas = function(tipo){

        if (tipo == 0 && $scope.pagina  > 1 ){$scope.pagina-=1;}else if (tipo == 1 && $scope.pagina < $scope.posicion ){$scope.pagina+=1;}
    }

    $scope.$watch('Busqueda', function() {

        if($scope.Busqueda == undefined) return;

        $scope.pagina=1;
        $scope.posicion=Math.ceil($scope.Busqueda.length / $scope.totalpaginas);
    });


//cargar datos con json
$scope.admi=function(codigo,medi){
     $scope.medicamento=medi;

    $scope.pagina=1;
    $http.get('src/sgh/kardex/php/sghListarAdministra.php?c='+ codigo).success(function(data){
        if (data.err === true) {
            $scope.administracion={};
        }else{
            $scope.administracion=data;
            $scope.posicion=Math.ceil(data.length / $scope.totalpaginas);
        }


  });
}

$scope.filter="";


// GUARDAR DATOS
$scope.cancelar = function(){
		$("#closemodal").click()
      $scope.datosAguardar=null;//datos que estraigo de los campos para guardar
      $scope.medicombo=0+"";
      $scope.canmedi();
      $scope.filter="";
    	}
$scope.actguarda=false;
$scope.guardar = function(){

    $scope.actguarda=true;
 if ($scope.medicombo === '0'){
     $scope.actguarda=false;
      $scope.text = "Seleccione un Medicamento";
      $scope.mensaje= true;

       setTimeout(function() 
       {
        $scope.mensaje= false;
        $scope.$apply();

        $scope.canmedi();
       }, 1500);
  }
  else{
    if ($scope.datosAguardar === null){
        $scope.actguarda=false;
        $scope.text = "Seleccione un horario";
        $scope.mensaje= true;

        setTimeout(function()
        {
            $scope.mensaje= false;
            $scope.$apply();
        }, 1500);

    }
    else {
        $http.post('src/sgh/kardex/php/sghInserAdministra.php',{op:1, adm:$scope.datosAguardar,fecha:$scope.hda_fecha, usu:$scope.usuario, fk:$scope.medicombo}).success(function(data){
            console.log(data);
            $scope.text = data.sgh_administracion_ingreso_pa;
            $scope.mensaje= true;
            $scope.datosAguardar=null;//datos que estraigo de los campos para guardar
            $scope.canmedi();
            $scope.actguarda=false;
           setTimeout(function()
                    {
              $scope.mensaje= false;
              $scope.actguarda=false;
                $scope.$apply();
             //$("#closemodal").click();
              }, 1500);

        });
    }
}
	}
$scope.activaadmin=function (op) {
    if (op === true){return true}else{return false}
}
$scope.administrada=function (id,obc) {

     $http.post('src/sgh/kardex/php/sghInserAdministra.php',{op:2, hda_obcerv:obc, id:id,usu:$scope.usuario}).success(function(data){

    });
}

$scope.ver_nuevo=true;
$scope.eliminar=false;

$scope.ver_modaleli=function (id,id_me) {
    $scope.hda_id_pk=id;
    $scope.kar_id_pk=id_me;

    $scope.ver_nuevo=false;
    $scope.eliminar=true;
}
$scope.con_elimina=function () {
    $http.post('src/sgh/kardex/php/sghInserAdministra.php',{op:3, id:$scope.hda_id_pk, usu:$scope.usuario}).success(function(data){

        console.log(data);
        $scope.text = data.sgh_administracion_ingreso_pa;
        $scope.mensaje= true;
        $scope.actguarda=false;
        setTimeout(function()
        {
            $scope.mensaje= false;
            $scope.actguarda=false;
            $scope.$apply();
            $("#closemodal").click();
            $scope.cancelar();
            $scope.admi($scope.kar_id_pk);
        }, 1500);
    });
}

}]);