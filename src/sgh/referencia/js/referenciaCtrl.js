angular.module("referencia",['ngRoute'])
.controller('referenciaCtrl',['$scope','$http','$routeParams',function($scope,$http,$routeParams){

$scope.Fecha = new Date();
$scope.otros=false;
	if ($scope.sgh_v_user === undefined){$scope.cerrarsesion();}
	if ($scope.usu_perfil === 'ENFERMERA(O)' || $scope.usu_perfil === 'AUXILIAR DE ENFERMERÍA' ){$scope.admi=true}

	$scope.verrefe=true;
$scope.vercontra=false;
$scope.opedicion=false;
$scope.search={
	ref_tiporef:'S'
};
$scope.titulo="Nuevo Registro";// titulo del modal
$scope.op="nuevo";
// activar boton de contra referencia
$scope.activa_desactiva=function(op) {
  if (op === 'S') {
    return true;
  } else {
    return false;

  }
}
///
$scope.reporte=function(codigo){
$http.post('src/sgh/referencia/php/reporte_referencia.php',{ref_id_pk:codigo}).success(function (data) {
        console.log(data);
  });

}
/////// CONTROL REFERENCIA //////////
	$scope.accion=function(){
		if($scope.op === 'nuevo') { 
		 $scope.guardar();
			}
		if($scope.op === 'editar') {
			$scope.actualizar();
		}
	}

	$scope.activa=function(id){
		
		if (id === "")
		{
		 $scope.otros=true;
		}else{$scope.otros=false;}
	}
	$scope.datosAguardar={med_id_fk:null};
	//datos que estraigo de los campos para guardar
	$scope.mensaje=false ;
	//variables de paginacion
	$scope.posicion=null;// guarda el total de items de la tabla
	$scope.pagina=1; // variable de paginas a mostrar

   /// cargar medico texto a guardar
	$scope.cargar=function(){
	$http.post('src/sgh/interconsulta/php/sghgetMedico.php',{op:3,codigo:$scope.usuario}).success(function (data) {
        	console.log(data);
        	 $scope.medi=false;
        	 $scope.datosAguardar.ref_medico=data[0].per_nombres +" "+ data[0].per_apellidopaterno;
        	 $scope.datosAguardar.ref_codmsp= data[0].pro_codigomsp;
        	 $scope.datosAguardar.med_id_fk=$scope.idmedi;
  	 })
	}
	//cargar datos con json
	$scope.actu=function(){
		 $http.post('src/sgh/referencia/php/sghListaReferencia.php',{op:'1',idhc:$scope.histoclinica}).success(function (data) {
		    if (data.error === "error") {console.log(data);}
			else{
				$scope.referencia = data;
				$scope.posicion=Math.ceil(data.length / $scope.totalpaginas);
			}
			//console.log(data);
			 });

	    $http.post('src/sgh/referencia/php/sghListaReferencia.php',{op:'3', codigo:$scope.entidad}).success(function (data) {
			$scope.orinsti = data;
			console.log(data);
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
	if ($scope.histoclinica === null){window.location = "#/" }else{$scope.actu();$scope.cargar();}


	// cargar institucion destino 
		$scope.inst_id="";
		$http.post('src/sgh/referencia/php/sghListaReferencia.php',{op:'5'}).success(function (data) {
		$scope.insti = data;
	//	console.log(data);
		});
		$scope.establecimiento=function(){
			var pos="";
			$scope.dtades(pos);
			}

		$scope.dtades= function(pos){
			$scope.posdes="";
		 $http.post('src/sgh/referencia/php/sghListaReferencia.php',{op:'4',inst:$scope.inst_id}).success(function (data) {
			$scope.destino = data;
			$scope.posdes=data[0].eti_id_pk;
			console.log(data)
		 });
			setTimeout(function(){
			 $scope.ins_de_fk=pos;					
		 	 $scope.$apply();
			 },900);
      	}
	/// Ver datos ///
	$scope.tabla=true;
	$scope.datos=false;
	$scope.regreesar=function(){$scope.datos=false;$scope.tabla=true; $scope.cancelar();}	
	$scope.datosrefe= function(id){
		$scope.tabla=false;
		$scope.datos=true;
		$http.post('src/sgh/referencia/php/sghListaReferencia.php',{op:'2',codigo:id}).success(function (data) {
				$scope.datosAguardar={
					ref_codmsp:data[0].ref_codmsp, 
					ref_espec:data[0].ref_espec,  
					ref_fecha:data[0].ref_fecha, 
					ref_halrel:data[0].ref_halrel,
					ref_justif:data[0].ref_justif,
					ref_medico:data[0].ref_medico,
					ref_motivo:data[0].ref_motivo,
					ref_rescuad:data[0].ref_rescuad,
					ref_servi:data[0].ref_servi,
					ref_tipo:data[0].ref_tipo,
					ref_trarea:data[0].ref_trarea, 
					ref_trarec:data[0].ref_trarec,
					ins_descripcion:data[0].ins_abreviacion,
					eta_descripcion:data[0].eta_descripcion,
			} 
  if (data[0].ref_motivo != 'LIMITADA CAPACIDAD RESOLUTIVAA' && data[0].ref_motivo != 'AUSENCIA TEMPORAL DEL PROFESIONAL' && data[0].ref_motivo != 'FALTA DE PROFECIONAL' && data[0].ref_motivo != 'SATURACIÓN DE CAPACIDAD INSTALADA') 
   {
	  $scope.verotros=true;
   }
    
			//console.log(data);
	}); 

		 $http.post('src/sgh/referencia/php/sghListaReferencia.php',{op:6, codigo:id}).success(function (data) {
					$scope.cie10=[];
						for (var i = 0 ; i < data.length ; i++) {
							$scope.cie10.push({c10_id:i ,c10_nombre:data[i].c10_nombre, c10_codigo:data[i].c10_codigo, dia_resp:data[i].dia_resp});
						}
					//console.log(data);
			});
	$scope.dcontra(id);	 
	}

	//paginacion
	$scope. paginas = function(tipo){if (tipo == 0 && $scope.pagina  > 1 ){$scope.pagina-=1;}else if (tipo == 1 && $scope.pagina < $scope.posicion ){$scope.pagina+=1;}}
	// GUARDAR DATOS
	$scope.cancelar = function(){
	    $scope.verrefe=true;
	    $scope.vercontra=false;
	    $scope.opedicion=false;
		//$scope.inst_id="";
		$scope.titulo="Nuevo Registro";// titulo del modal
		$scope.op="nuevo";
		$scope.op2="nuevo";
	  /// variavles de cie10
		$scope.cie10 = [];
		$scope.cie10c = [];
		$scope.codigo="";
		$scope.c10_id_pk=0;
		$scope.c10nuevo=true;
		$scope.c10editar=false;
	  // variabls de formulario
	    $scope.ins_de_fk="";
		$("#closemodal").click();
		$scope.actu();
        $scope.datosAguardar={med_id_fk:null};
		$scope.datoscontra={med_id_fk:null};
		$scope.idmedi="";
        $scope.cargar();
    }
    $scope.actguarda=false;
	$scope.guardar = function()
	 {	$scope.actguarda=true;
			//guardar referencia
			 $http.post('src/sgh/referencia/php/sghInserReferencia.php',{ref:$scope.datosAguardar, ins_or_fk:$scope.entidad , ins_de_fk:$scope.ins_de_fk,hcl:$scope.histoclinica, usu:$scope.usuario,op:1}).success(function(data){	
						$scope.text = data.sgh_referencia_ingreso_pa;
				        $scope.mensaje= true;
						setTimeout(function(){
							$scope.mensaje= false;$scope.actguarda=false;
							$scope.$apply();	
							$scope.dingreso();
							$scope.cancelar();			
						},1500);
					
					 console.log(data);
		});
	}

	// guarda cie10 ingreso
	  $scope.dingreso=function(){
	   if ($scope.cie10!= null){
		 $http.post('src/sgh/referencia/php/sghInserReferencia.php',{c10:$scope.cie10 ,op:2, usu:$scope.usuario}).success(function(data)
		 {	
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
        $http.post('src/sgh/epicrisis/php/sghGetcie10.php',{codigo:$scope.codigo}).success(function(data){
				if (data != "null"){

							$http.post('src/sgh/referencia/php/sghInserReferencia.php',{ref_id_pk:$scope.ref_id_pk , c10_id_pk:data[0].c10_id_pk, dia_resp:'true',op:5, usu:$scope.usuario}).success(function(data)
								{ 
									$scope.cargac10();
									//console.log(data);
								});
				 }else
				 {
				 alert("Codigo cie10 no encontrado");
				 }
			});
	 }

	$scope.cargac10=function(){
		 $http.post('src/sgh/referencia/php/sghListaReferencia.php',{op:6,codigo:$scope.ref_id_pk}).success(function (data) {
							 $scope.cie10=[];
							 for (var i = 0 ; i < data.length ; i++) {
								$scope.cie10.push({c10_id:i, c10_nombre:data[i].c10_nombre, c10_codigo:data[i].c10_codigo, dia_resp:$scope.com_string(data[i].dia_resp),dia_id_pk:data[i].dia_id_pk ,c10_id_pk:data[i].c10_id_pk});
							 }
						 });
		}

	/// EIDTAR DATOS ////
	$scope.editar=function(id,op){
		$scope.titulo=".";
		$scope.opedicion=true;
		$scope.verrefe=false;
		$scope.vercontra=false;
		$scope.ref_id_pk=id;
		$scope.c10nuevo=false;
		$scope.c10editar=true;
		if (op === 'S') {
		    $scope.desactiva_contrareferencia=true;
	    	$scope.desactiva_referencia=false;
	    	$scope.edirefe()
		}else
		{
		    $scope.desactiva_contrareferencia=false;
	    	$scope.desactiva_referencia=true;	
		}
		
	}

	$scope.edirefe=function(){
		$scope.titulo="Editando Registro";
		$scope.op="editar";
		$http.post('src/sgh/referencia/php/sghListaReferencia.php',{op:7, codigo:$scope.ref_id_pk,usu:$scope.usuario}).success(function (data) {
			console.log(data);
			$scope.inst_id=data[0].ins_id_pk+"";
			$scope.ins_or_fk=data[0].ins_or_fk;
			$scope.ref_id_pk=data[0].ref_id_pk;
			$scope.idmedi=data[0].ref_id_medico+"";
			$scope.dtades(data[0].ins_de_fk);
				if (data != "0")
				{
				$scope.opedicion=false;
				$scope.verrefe=true; 
				$scope.datosAguardar={
						ref_codmsp:data[0].ref_codmsp, 
						ref_espec:data[0].ref_espec,  
						ref_fecha:data[0].ref_fecha, 
						ref_halrel:data[0].ref_halrel,
						ref_justif:data[0].ref_justif,
						ref_medico:data[0].ref_medico,
						ref_motivo:data[0].ref_motivo,
						ref_rescuad:data[0].ref_rescuad,
						ref_servi:data[0].ref_servi,
						ref_tipo:data[0].ref_tipo,
						ref_trarea:data[0].ref_trarea, 
						ref_trarec:data[0].ref_trarec,
						ref_id_pk:data[0].ref_id_pk,
						med_id_fk:data[0].ref_id_medico
				}
				$scope.cargac10();
				$scope.verrefe=true;
				$scope.opedicion=false;    
			}
			else
				{
                 alert("Lo Sentimos, ya pasaron más de 24 horas");
				$("#can").click();
				$scope.cancelar();
				}
				//console.log(data);
		}); 
	}

	$scope.actualizar=function(){
		$http.post('src/sgh/referencia/php/sghInserReferencia.php',{ usu:$scope.usuario,ref:$scope.datosAguardar,ins_de_fk:$scope.ins_de_fk,ins_or_fk:$scope.entidad,op:3}).success(function(data){
							 $scope.text = data.sgh_referencia_ingreso_pa;
							 $scope.mensaje= true;
							 
							 setTimeout(function(){
								$scope.mensaje= false;
								$scope.$apply();
								$scope.editarc10();
								$("#can").click();
								$scope.cancelar();    
							},1500);
				//console.log(data); 
			});
		
	}
	$scope.editarc10=function(){
	 $http.post('src/sgh/referencia/php/sghInserReferencia.php',{c10:$scope.cie10 ,op:4 ,usu:$scope.usuario}).success(function(data)
						 {  
						//	console.log(data);
					 }); 
	}
/////// CONTROL CONTRAREFERENCIA ////
  $scope.op2="nuevo";
  
  $scope.accion2=function(){
			if($scope.op2 === 'nuevo') { 
			 $scope.guardar2();
				}
			if($scope.op2 === 'editar') {
				$scope.actualizar2();
			}
		}

 $scope.contra=function(id){

  $scope.verrefe=false;
  $scope.opedicion=false;
  $scope.vercontra=true;
  $scope.titulo="Nuevo Registro";
  $scope.datosAguardar.ref_id_pk=id;
  $http.post('src/sgh/referencia/php/sghListaReferencia.php',{op:8, codigo:id}).success(function (data) {


       if (data.error === "error")
       {
		   $("#n").click();
		   $http.post('src/sgh/referencia/php/sghListaReferencia.php',{op:'2',codigo:id}).success(function (data) {
		 // 	console.log(data);
		   	$scope.ins_or_fk = data[0].ins_de_fk;
		   	$scope.ins_de_fk = data[0].ins_or_fk;
			$scope.datosAguardar.ref_servi=data[0].ref_servi;
			$scope.datosAguardar.ref_espec=data[0].ref_espec;   
			$scope.datosAguardar.tin_abreviacion=data[0].tin_descripcion;
 		    $scope.datosAguardar.nin_descripcion=data[0].nin_descripcion;  
			$scope.carga_intituciones();
		  });
           $scope.cargar();
       }
       else
       {
       	alert("Ya se realizo una Contrareferencio o Referenciainversa");
        $scope.cancelar();	
       }
  	 });
  }
$scope.carga_intituciones=function () {
	   $http.post('src/sgh/referencia/php/sghListaReferencia.php',{op:'3',codigo:$scope.ins_or_fk}).success(function (data) {
			    	$scope.orinsti = data;
			    	//console.log(data);
		});
	   setTimeout(function(){
	   
		  $scope.$apply();
		  $http.post('src/sgh/referencia/php/sghListaReferencia.php',{op:'3', codigo:$scope.ins_de_fk}).success(function (data) {
					$scope.datosAguardar.ins_descripcion = data[0].ins_descripcion;
					$scope.datosAguardar.eta_descripcion = data[0].eta_descripcion;
					$scope.datosAguardar.tin_abreviacion=data[0].tin_descripcion;
 				    $scope.datosAguardar.nin_descripcion=data[0].nin_descripcion;
					//console.log(data);
		});	    		
    	},500);	
	 
}




 $scope.guardar2 = function()
	 {	$scope.actguarda=true;
			//guardar epicrisis
		$http.post('src/sgh/referencia/php/sghInserReferencia.php',{ref:$scope.datosAguardar, ins_or_fk: $scope.ins_or_fk ,ins_de_fk:$scope.ins_de_fk , hcl:$scope.histoclinica, usu:$scope.usuario, op:6}).success(function(data){	
		    $scope.text = data.sgh_referencia_ingreso_pa;
			$scope.mensaje= true;
    		setTimeout(function(){
				$scope.mensaje= false;$scope.actguarda=false;
			    $scope.$apply();
			    $scope.dingreso();
				$scope.cancelar();			
			},1500);
			
			//console.log(data);
		});
	}

$scope.edicrefe=function(){
	$scope.titulo="Editando Registro";
	$scope.op2="editar";
		$http.post('src/sgh/referencia/php/sghListaReferencia.php',{op:9, codigo:$scope.ref_id_pk,usu:$scope.usuario}).success(function (data) {
			//console.log(data);
			$scope.inst_id=data[0].ins_id_pk;
			$scope.ins_or_fk = data[0].ins_de_fk;
		   	$scope.ins_de_fk = data[0].ins_or_fk;
		   	$scope.ref_id_pk=data[0].ref_id_pk;
		   	$scope.idmedi=data[0].ref_id_medico+"";
				if (data != "0")
				{ 
				$scope.opedicion=false;
		        $scope.vercontra=true;
				$scope.datosAguardar={
						ref_codmsp:data[0].ref_codmsp, 
						ref_espec:data[0].ref_espec,  
						ref_fecha:data[0].ref_fecha, 
						ref_halrel:data[0].ref_halrel,
						ref_justif:data[0].ref_justif,
						ref_medico:data[0].ref_medico,
						ref_rescuad:data[0].ref_rescuad,
						ref_servi:data[0].ref_servi,
						ref_tipo:data[0].ref_tipo,
						ref_trarea:data[0].ref_trarea, 
						ref_trarec:data[0].ref_trarec,
						ins_de_fk:data[0].ins_de_fk,
						ref_id_pk:data[0].ref_id_pk,

				}
				$scope.cargac10c($scope.datosAguardar.ref_id_pk);
				$scope.carga_intituciones();
				$scope.vercontra=true;
				$scope.opedicion=false;
			}
			else
				{
				 alert("Lo Sentimos ya pasaros +  de 24 horas");
				$("#can").click();
				$scope.cancelar();
				}
				//console.log(data);
		}); 
	}


$scope.com_string=function(valor){if (valor == true) {return 'true'}else{return 'false'}};
$scope.cargac10c=function(id){
		$http.post('src/sgh/referencia/php/sghListaReferencia.php',{op:6,codigo:id}).success(function (data) {
		    $scope.cie10=[];
			  for (var i = 0 ; i < data.length ; i++) {
				$scope.cie10.push({c10_id:i, c10_nombre:data[i].c10_nombre, c10_codigo:data[i].c10_codigo, dia_resp:$scope.com_string(data[i].dia_resp),dia_id_pk:data[i].dia_id_pk ,c10_id_pk:data[i].c10_id_pk});
			 }
		});
	}
$scope.actualizar2=function(){
		$http.post('src/sgh/referencia/php/sghInserReferencia.php',{ref:$scope.datosAguardar,ins_or_fk:$scope.ins_or_fk, ins_de_fk:$scope.ins_de_fk,op:3, usu:$scope.usuario}).success(function(data){
							 $scope.text = data.sgh_referencia_ingreso_pa;
							 $scope.mensaje= true;
							 
							 setTimeout(function(){
								$scope.mensaje= false;
								$scope.$apply();
								$scope.editarc10();
								$("#can").click();
								$scope.cancelar();    
							},1500);
				//console.log(data); 
			});
		
	}
$scope.dcontra= function(id){
	    $scope.datoscontra={med_id_fk:null};
		$scope.tabla=false;
		$scope.datos=true;
	$http.post('src/sgh/referencia/php/sghListaReferencia.php',{op:10, codigo:id}).success(function (data) {
			//console.log(data);
			$scope.inst_id=data[0].ins_id_pk;
			$scope.ins_or_fk = data[0].ins_de_fk;
		   	$scope.ins_de_fk = data[0].ins_or_fk;
		   	$scope.ref_id_pk=data[0].ref_id_pk;
				$scope.datoscontra={
						ref_codmsp:data[0].ref_codmsp, 
						ref_espec:data[0].ref_espec,  
						ref_fecha:data[0].ref_fecha, 
						ref_halrel:data[0].ref_halrel,
						ref_justif:data[0].ref_justif,
						ref_medico:data[0].ref_medico,
						ref_rescuad:data[0].ref_rescuad,
						ref_servi:data[0].ref_servi,
						ref_tipo:data[0].ref_tipo,
						ref_trarea:data[0].ref_trarea, 
						ref_trarec:data[0].ref_trarec,
						ins_de_fk:data[0].ins_de_fk,
						ref_id_pk:data[0].ref_id_pk,
				}
			 $http.post('src/sgh/referencia/php/sghListaReferencia.php',{op:'3',codigo: $scope.ins_or_fk}).success(function (data) {
			    	$scope.corinsti = data;
			    	//console.log(data);
			});
			   setTimeout(function(){
				  $scope.$apply();
				  $http.post('src/sgh/referencia/php/sghListaReferencia.php',{op:'3', codigo: $scope.ins_de_fk}).success(function (data) {
							$scope.datoscontra.ins_descripcion = data[0].ins_descripcion;
							$scope.datoscontra.eta_descripcion = data[0].eta_descripcion;
				            $scope.datoscontra.tin_abreviacion=data[0].tin_descripcion;
 				            $scope.datoscontra.nin_descripcion=data[0].nin_descripcion;
							//console.log(data);
			});	    		
    	},500);		

		$http.post('src/sgh/referencia/php/sghListaReferencia.php',{op:6, codigo:$scope.ref_id_pk}).success(function (data) {
		    $scope.cie10c=data;
		   // console.log(data);
        });
     
    });    
} 

}]);

