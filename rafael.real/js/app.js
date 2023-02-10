var app = angular.module("app", ['ngCookies','ui.router','oc.lazyLoad']);
app.controller('mainCrtl', function mainCrtl ($scope, $http, $window, $cookies,$cookieStore) {
$("#btn-login-light").click() ;
$scope.bool=function(valor){
  if (valor === 'false'){
    var bool = false;
  }else{var bool = true;}
return bool;  
}

$scope.histoclinica=null;
/// Variables general 
     $scope.item= -8; //cantidad de items a cargar 
     $scope.totalpaginas =8;
     $scope.goCats = false;
//  opciones de login 
  $scope.mensaje= false;
  $scope.cerrarsesion = function () {
        $cookies.remove('usuario');
        $cookies.remove('servicio');
        $cookies.remove('histoclinica');
        $cookies.remove('cama');
        $cookies.remove('op_cargar');
        $cookies.remove('medicina'); 
        $cookies.remove('usuario');
        $cookies.remove('id_cen_pk');
        $cookies.put("menu", false);
        $cookies.put("lis_pasien", true);
        $cookies.remove('entidad');
        location.reload();
        window.location = "index.html";
    };
  $scope.nusuario="";$scope.pasword="";

  $scope.inicioarsecion=function(){
    $http.post('php/sghCargaUsuario.php?',{op:1 , usu:$scope.nusuario, pas:$scope.pasword}).success(function (data) {
       console.log(data);
       $cookies.putObject("sgh_user", data);

       $scope.mensaje= true;
       $scope.text =data.Mensaje;
         setTimeout(function(){
            $scope.mensaje= false;
            $scope.$apply();
            },2000);

       if (data.Estado === 1 ) {
          
          $scope.sgh_user=$cookies.getObject('sgh_user');
        //  $scope.sgh_user=document.cookie.split('=')[1];
          $cookies.put("usuario", $scope.sgh_user.usu_id_pk);
          $cookies.put("entidad", $scope.sgh_user.eti_id_fk);
          $cookies.put("nom_perfil",$scope.sgh_user.usuario_apellido_nombre);
          $scope.usuario=$cookies.get('usuario');
          $scope.entidad=$cookies.get('entidad');
          $scope.nom_perfil=$cookies.get('nom_perfil');
          
          $http.post('php/sghCargaUsuario.php?',{op:2 , usu:$scope.usuario}).success(function (data) {
              console.log(data);
              $cookies.put("op_cargar",data[0].pfi_descripcion); 
              $scope.op_cargar=$cookies.get('op_cargar');
              if ($scope.op_cargar != null) { 
              if ($scope.op_cargar === "HOSPITALIZACION"){$("#ser").click();}
                  else{window.location = "index!.html"; $cookies.put("lis_pasien", true);$cookies.put("menu", false);}
               }
              else{alert($scope.op_cargar);}
          });
        }
      

    }); 

     }  
// seleccionar servicios cuando un usuario tiene acceso alos dos 
   $scope.servicios=function(op){
     if (op === 1) 
     {  
        var ser="MEDICINA INTERNA";    
        $cookies.put("op_cargar",ser);
        $scope.op_cargar=$cookies.get('op_cargar');
        $cookies.put("lis_pasien", true);$cookies.put("menu", false);
        window.location = "index!.html";
     }
     else
     {
        var ser="PEDIATRIA";            
        $cookies.put("op_cargar",ser);
        $scope.op_cargar=$cookies.get('op_cargar');
        $cookies.put("lis_pasien", true);$cookies.put("menu", false);
        window.location = "index!.html";
     }   

   }     

// Acción de ocultar pie de pagina al imprimir 
    $scope.footer=true;   
     $scope.ocpie=function(){$scope.footer=false;}
     $scope.mospie=function(){$scope.footer=true;}

/// cerrar datos de historia clinica de paciente 
 $scope.cerrar=function (){
        $cookies.remove('servicio');
        $cookies.remove('histoclinica');
        $cookies.remove('cama');
        $cookies.remove('menu');
        $cookies.remove('id_cen_pk');
        $cookies.put("menu", false);
        $scope.menu=$scope.bool($cookies.get('menu'));
        $cookies.put("lis_pasien", true);
        $scope.lis_pasien=$scope.bool($cookies.get('lis_pasien'));
    }

 $scope.heade=function(){$scope.medicina="templates/heade.html";$scope.menu=true;  $("#sidebar-collapse").click();}
 
/// accion a cargar menus 
    $scope.accion=function(fecha,idh,idc,ids,id_cen){
          $cookies.put("cen_fecha",fecha);
          $cookies.put("id_cen_pk",id_cen);
          $scope.id_cen_pk=$cookies.get('id_cen_pk');
          $scope.cen_fecha=$cookies.get('cen_fecha');
        if ($scope.op_cargar === "MEDICINA INTERNA")
        {
            $scope.cargar(idh,idc,ids);
            $cookies.put("medicina", "templates/medicina.html");
            $scope.medicina=$cookies.get('medicina');
           
        }
        if ($scope.op_cargar === "PEDIATRIA")
        {
           $scope.cargar(idh,idc,ids);
           $cookies.put("medicina", "templates/pediatria.html");
           $scope.medicina=$cookies.get('medicina'); 
          
        }
 }

/// cargar datos de pacientes en hospitalización
    $scope.car_paciente= function(){
         $http.post('src/sgh/listapacientes/php/sghlistarPacientes.php',{op:$scope.op_cargar}).success(function (data) {
         // console.log(data);
          if (data.error === "error"){ console.log(data)}
                else
                {
                $scope.pacientes = data;
                }
        });
    }
 
// cargar datos del paciente : servicio historia clinica, cama, activacion de menu 
 $scope.cargar=function(idh,idc,ids){
     $cookies.put("servicio", ids);
     $cookies.put("histoclinica", idh);
     $cookies.put("cama", idc);

     $scope.servicio=$cookies.get('servicio');
     $scope.histoclinica=$cookies.get('histoclinica');
     $scope.cama=$cookies.get('cama');
    
     $cookies.put("menu", true);
     $scope.menu=$scope.bool($cookies.get('menu'));

     $cookies.put("lis_pasien", false);
     $scope.lis_pasien=$scope.bool($cookies.get('lis_pasien'));
     /// cargo encabezado
     $scope.carga_encabezado();

  }
 
$scope.carga_encabezado=function () {
    $scope.Servicios=false;
  /// datos de paciente y encabezados de formularios
  if ($scope.histoclinica != null){
    $http.post('src/sgh/encabezado/php/SghgetEncabezado.php?',{codigo:$scope.id_cen_pk, op:1}).success(function (data) {
        console.log(data);
        if (data.error === "error") {}
        else{
        $scope.encabezado= data;
        if (data[0].per_sexo === 'M') {$scope.all=true;} else {$scope.all=false;}
        if (data[0].per_sexo === 'H') {$scope.all2=true;} else {$scope.all2=false;}
        }
    });
  }
 
/// cargar datos de alta de paciente en queestado queda cama
   $http.post('src/sgh/encabezado/php/SghgetEncabezado.php?',{op:2}).success(function (data) {
       // console.log(data);
        if (data.error === "error") {}
        else{
        $scope.estadocama=data;
        }
    }); 

} 
     $scope.servicio=$cookies.get('servicio');
     $scope.histoclinica=$cookies.get('histoclinica');
     $scope.cama=$cookies.get('cama');
     $scope.menu=$scope.bool($cookies.get('menu'));
     $scope.medicina=$cookies.get('medicina'); 
     $scope.usuario=$cookies.get('usuario');
     $scope.op_cargar=$cookies.get('op_cargar');
     $scope.lis_pasien=$scope.bool($cookies.get('lis_pasien'));
     $scope.id_cen_pk=$cookies.get('id_cen_pk');
     $scope.entidad=$cookies.get('entidad');
     $scope.sgh_user=$cookies.get('sgh_user');
     $scope.nom_perfil=$cookies.get('nom_perfil');
     $scope.cen_fecha=$cookies.get('cen_fecha');
     $scope.sgh_user=$cookies.getObject('sgh_user');
     console.log($cookieStore.get('sgh_user'));
     if ($scope.histoclinica ===  null){}else{$scope.carga_encabezado();}
      
     if ($scope.op_cargar === "LABORATORIO"){
           window.location = "#/resultados";
           $("#sidebar-collapse").click();
        }

     if ($scope.op_cargar === "ADMINISTRADOR")
        {
           $cookies.put("medicina", "templates/heade.html");
           $scope.medicina=$cookies.get('medicina');
           $cookies.put("lis_pasien", false);
           $cookies.put("histoclinica", null);
           $scope.lis_pasien=$scope.bool($cookies.get('lis_pasien'));
           $cookies.put("menu", true);
           $scope.menu=$scope.bool($cookies.get('menu'));
           window.location = "#/cie10";
      }else
      {
         if ($scope.op_cargar != null) { $scope.car_paciente();}
      }



// funcion de alta de paciente 
   $scope.verdef=false;
   $scope.defucion=false;
   $scope.datosAguardar={
            cen_def_48:null,
            cen_def48:null,
            cen_tipo:'EGRESO',
            cen_visible:false,
            ces_id_fk:""
        };
   $scope.acdef=function(op){
    
     if (op === true ) {$scope.verdef=true;}else{$scope.verdef=false;}   
   }
   $scope.cancelar = function(){
        $("#closemodal").click()
        $scope.datosAguardar={
            cen_def_48:null,
            cen_def48:null,
            cen_tipo:'EGRESO',
            cen_visible:false,
            ces_id_fk:""
        };
  }
  $scope.guardar = function(){
    
    $http.post('src/sgh/encabezado/php/SghgetEncabezado.php?',{op:3,fecha:$scope.cen_fecha,hcl:$scope.histoclinica}).success(function (data) {
       //console.log(data);
        if (data.error === "error") {
             $scope.text = "Para dar de alta, debes  realiza la epicrisis.";
             $scope.mensaje= true;
              setTimeout(function() 
                    {
              $scope.mensaje= false;
              $scope.$apply();
              }, 3000);
        }
        else{
        //alert("guardando alta de paciente");
        $http.post('src/sgh/encabezado/php/sghInserAltapaciente.php',{op:1,alta:$scope.datosAguardar, hcl:$scope.histoclinica, usu:$scope.usuario, cam:$scope.cama, cen:$scope.id_cen_pk}).success(function(data){ 
           console.log(data);
           $scope.text = data.sgh_altapaciente_ingreso_pa;
           $scope.mensaje= true;
           $scope.cerrar();
           setTimeout(function() 
                    {
              $scope.mensaje= false;
              $scope.cancelar();
              $scope.car_paciente($scope.op_cargar); 
              $scope.$apply();  
              }, 1500);
            //alert(data);
        });
        }
  });
}    
});




 app.directive('capitalize', function() {
    return {
        require: 'ngModel',
        link: function(scope, element, attrs, modelCtrl) {
            var capitalize = function(inputValue) {
                if (inputValue == undefined) inputValue = '';
                var capitalized = inputValue.toUpperCase();
                if (capitalized !== inputValue) {
                    modelCtrl.$setViewValue(capitalized);
                    modelCtrl.$render();
                }
                return capitalized;
            }
            modelCtrl.$parsers.push(capitalize);
            capitalize(scope[attrs.ngModel]); // capitalize initial value
        }
    };
});
