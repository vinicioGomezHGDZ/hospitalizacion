angular.module("adulto",['ngRoute'])
.controller('adultoCtrl',['$scope','$http','$routeParams',function($scope,$http,$routeParams){
$scope.Fecha = new Date();
    $scope.limpia=function () {$scope.cie10 = [];}
//////////// 
$scope.titulo="OPCIONES DE INGRESO";
///acciones a tomar segun perfil//
$scope.perfiles=true;
$scope.consulta_activa=false;
$scope.sigv_activa=false;
$scope.signosvitales=function(){
		$scope.sigv_activa=true;
		$scope.perfiles=false;
		$scope.consulta_activa=false;
		$scope.titulo="Ingreso de Signos Vitales";// titulo del modal
}
$scope.consulta=function(){
		$scope.consulta_activa=true;
		$scope.perfiles=false;
		$scope.sigv_activa=false;
		$scope.titulo="Nuevo Registro";// titulo del modal
		$scope.op="nuevo";
	    $scope.cnuevo();		
}
$scope.cnuevo=function(){
 $http.post('src/sgh/adultomayor/php/sghListaAdultomayor.php',{op:'10',idhc:$scope.histoclinica}).success(function (data) {

        if (data.error ==="error") {console.log(data)}
        else
        {
          $http.post('src/sgh/adultomayor/php/sghListaAdultomayor.php',{codigo:data[0].aam_id_pk , op:'7'}).success(function(data){
		    $scope.datosAguardar.siv_id_pk=data[0].siv_id_pk;
		    $scope.datosAguardar.siv_defaud=data[0].siv_defaud;
		    $scope.datosAguardar.siv_defvis=data[0].siv_defvis;
		    $scope.datosAguardar.siv_freres=data[0].siv_freres;
		    $scope.datosAguardar.siv_imc=data[0].siv_imc;
			$scope.datosAguardar.siv_levand=data[0].siv_levand;
			$scope.datosAguardar.siv_peinor=data[0].siv_peinor;
			$scope.datosAguardar.siv_pemere=data[0].siv_pemere;
			$scope.datosAguardar.siv_percad=data[0].siv_percad;
			$scope.datosAguardar.siv_percint=data[0].siv_percint;
			$scope.datosAguardar.siv_perpan=data[0].siv_perpan;
			$scope.datosAguardar.siv_perpes=data[0].siv_perpes;
			$scope.datosAguardar.siv_peso=data[0].siv_peso;
			$scope.datosAguardar.siv_prarta=data[0].siv_prarta;
			$scope.datosAguardar.siv_prarte=data[0].siv_prarte;
			$scope.datosAguardar.siv_pubaso=data[0].siv_pubaso;
			$scope.datosAguardar.siv_pulso=data[0].siv_pulso;
			$scope.datosAguardar.siv_sacoso=data[0].siv_sacoso;
			$scope.datosAguardar.siv_talla=data[0].siv_talla;
			$scope.datosAguardar.siv_temper=data[0].siv_temper;
			$scope.datosAguardar.siv_triste=data[0].siv_triste;
			$scope.datosAguardar.siv_vivsol=data[0].siv_vivsol;
   		 }); 
       	 $scope.datosAguardar.aam_id_pk=data[0].aam_id_pk;
       	 $scope.datosAguardar.aam_antepe=data[1].aam_antepe;
       	 $scope.datosAguardar.aam_antfam=data[1].aam_antfam;
    $http.post('src/sgh/adultomayor/php/sghListaAdultomayor.php',{codigo:data[1].aam_id_pk , op:'3'}).success(function(data)
	 	{
	 		if (data.error != "error") {
			   $scope.items=[
			     {vision:data[104].pat_result, pat_id_pk:data[104].pat_id_pk}, 
			     {genitourinario:data[51].pat_result,pat_id_pk:data[51].pat_id_pk},
			     {audision:data[15].pat_result, pat_id_pk:data[15].pat_id_pk}, 
			     {rasmusculo:data[90].pat_result, pat_id_pk:data[90].pat_id_pk},
			     {olfatogusto:data[73].pat_result, pat_id_pk:data[73].pat_id_pk},
			     {endocriono10:data[48].pat_result, pat_id_pk:data[48].pat_id_pk},
			     {reacsirespitatorio:data[93].pat_result, pat_id_pk:data[93].pat_id_pk},
			     {hemolinfatico:data[53].pat_result, pat_id_pk:data[53].pat_id_pk},
			     {reacsicardiovascular:data[91].pat_result, pat_id_pk:data[91].pat_id_pk},
			     {nervioso:data[68].pat_result, pat_id_pk:data[68].pat_id_pk},
			     {reacsidigestivo:data[92].pat_result, pat_id_pk:data[92].pat_id_pk},
			     {caidas:$scope.bool(data[19].pat_result), pat_id_pk:data[19].pat_id_pk},
			     {dismovilidad:$scope.bool(data[41].pat_result), pat_id_pk:data[41].pat_id_pk},
			     {perdidapeso:$scope.bool(data[83].pat_result), pat_id_pk:data[83].pat_id_pk},
			     {astenia:$scope.bool(data[14].pat_result), pat_id_pk:data[14].pat_id_pk},
			     {desorientacion:$scope.bool(data[34].pat_result), pat_id_pk:data[34].pat_id_pk},
			     {alteracion:$scope.bool(data[7].pat_result), pat_id_pk:data[7].pat_id_pk},
			     {inmunoizaciones:data[59].pat_result, pat_id_pk:data[59].pat_id_pk},
			     {actividadrecreativa:data[1].pat_result, pat_id_pk:data[1].pat_id_pk},
			     {higienegeneral:data[55].pat_result, pat_id_pk:data[55].pat_id_pk},
			     {controlessalud:data[26].pat_result, pat_id_pk:data[26].pat_id_pk},
			     {higieneoral:data[56].pat_result, pat_id_pk:data[56].pat_id_pk},
			     {alergias:data[5].pat_result, pat_id_pk:data[5].pat_id_pk},
			     {ejercicios:data[44].pat_result, pat_id_pk:data[44].pat_id_pk},
			     {otros:data[79].pat_result, pat_id_pk:data[79].pat_id_pk},
			     {alimentacion:data[6].pat_result, pat_id_pk:data[6].pat_id_pk},
			     {tabaquismo:$scope.bool(data[97].pat_result), pat_id_pk:data[97].pat_id_pk},
			     {alcoholismo:$scope.bool(data[4].pat_result), pat_id_pk:data[4].pat_id_pk},
			     {adicciones:$scope.bool(data[2].pat_result), pat_id_pk:data[2].pat_id_pk},
			     {otrohabito:$scope.bool(data[78].pat_result), pat_id_pk:data[78].pat_id_pk},
			     {demartologico:$scope.bool(data[33].pat_result), pat_id_pk:data[33].pat_id_pk},
			     {visuales:$scope.bool(data[105].pat_result), pat_id_pk:data[105].pat_id_pk},
			     {otorrino:$scope.bool(data[76].pat_result), pat_id_pk:data[76].pat_id_pk},
			     {estomatologicos:$scope.bool(data[49].pat_result), pat_id_pk:data[49].pat_id_pk},
			     {endocrinos:$scope.bool(data[48].pat_result), pat_id_pk:data[48].pat_id_pk},
			     {cardio:$scope.bool(data[20].pat_result), pat_id_pk:data[20].pat_id_pk},
			     {infecciosos:$scope.bool(data[58].pat_result), pat_id_pk:data[58].pat_id_pk},
			     {hemolinfaticos:$scope.bool(data[54].pat_result), pat_id_pk:data[54].pat_id_pk},
			     {urologicos:$scope.bool(data[102].pat_result), pat_id_pk:data[102].pat_id_pk},
			     {neurologicos:$scope.bool(data[69].pat_result), pat_id_pk:data[69].pat_id_pk},
			     {psiquiatricos:$scope.bool(data[89].pat_result), pat_id_pk:data[89].pat_id_pk},
			     {musculoesqueletico:$scope.bool(data[64].pat_result), pat_id_pk:data[64].pat_id_pk},
	             {digestivos:$scope.bool(data[39].pat_result), pat_id_pk:data[39].pat_id_pk},
	             {respiratorios:$scope.bool(data[95].pat_result), pat_id_pk:data[95].pat_id_pk},
	             {oncologicos:$scope.bool(data[74].pat_result), pat_id_pk:data[74].pat_id_pk},
	             {menopausia:data[61].pat_result, pat_id_pk:data[61].pat_id_pk},
	             {mamografia:data[60].pat_result, pat_id_pk:data[60].pat_id_pk},
	             {citologia:data[24].pat_result, pat_id_pk:data[24].pat_id_pk},
	             {embarazos:data[45].pat_result, pat_id_pk:data[45].pat_id_pk},
	             {partos:data[82].pat_result, pat_id_pk:data[82].pat_id_pk},
	             {cesareas:data[23].pat_result, pat_id_pk:data[23].pat_id_pk},
	             {tehormonal:data[98].pat_result, pat_id_pk:data[98].pat_id_pk},
	             {prostatica:data[87].pat_result, pat_id_pk:data[87].pat_id_pk},
	             {terapiahor:data[99].pat_result, pat_id_pk:data[99].pat_id_pk},
	             {aines:$scope.bool(data[3].pat_result), pat_id_pk:data[3].pat_id_pk},
	             {analgesicos:$scope.bool(data[9].pat_result), pat_id_pk:data[9].pat_id_pk},
	             {antidiabeticos:$scope.bool(data[12].pat_result), pat_id_pk:data[12].pat_id_pk},
	             {antihipertensivos:$scope.bool(data[13].pat_result), pat_id_pk:data[13].pat_id_pk},
	             {anticuagulantes:$scope.bool(data[11].pat_result), pat_id_pk:data[11].pat_id_pk},
	             {psicofarmacos:$scope.bool(data[88].pat_result), pat_id_pk:data[88].pat_id_pk},
	             {antibioticos:$scope.bool(data[10].pat_result), pat_id_pk:data[10].pat_id_pk},
	             {otrofarcologico:$scope.bool(data[77].pat_result), pat_id_pk:data[77].pat_id_pk},
	             {prescritores:data[86].pat_result, pat_id_pk:data[86].pat_id_pk},
	             {cardiopatias:data[21].pat_result, pat_id_pk:data[21].pat_id_pk},
	             {tuberculosis:data[101].pat_result, pat_id_pk:data[101].pat_id_pk},
	             {diabetes:data[36].pat_result, pat_id_pk:data[36].pat_id_pk},
	             {violencia:data[103].pat_result, pat_id_pk:data[103].pat_id_pk},
	             {hipertencion:data[57].pat_result, pat_id_pk:data[57].pat_id_pk},
	             {sindrome:data[96].pat_result, pat_id_pk:data[96].pat_id_pk},
	             {neoplasia:data[67].pat_result, pat_id_pk:data[67].pat_id_pk},
	             {otrosantecedentes:data[80].pat_result, pat_id_pk:data[80].pat_id_pk},
	             {parkinson:data[81].pat_result, pat_id_pk:data[81].pat_id_pk},
	             {alzheimer:data[8].pat_result, pat_id_pk:data[8].pat_id_pk},
	             {pifi:data[85].pat_result, pat_id_pk:data[85].pat_id_pk},
	             {oidos:data[71].pat_result, pat_id_pk:data[71].pat_id_pk},
	             {cuello:data[27].pat_result, pat_id_pk:data[27].pat_id_pk},
	             {abdomen:data[0].pat_result, pat_id_pk:data[0].pat_id_pk},
	             {msuperiores:data[63].pat_result, pat_id_pk:data[63].pat_id_pk},
	             {columna:data[25].pat_result, pat_id_pk:data[25].pat_id_pk}, 
	             {axilamama:data[16].pat_result, pat_id_pk:data[16].pat_id_pk},
	             {boca:data[17].pat_result, pat_id_pk:data[17].pat_id_pk},
	             {cabeza:data[18].pat_result, pat_id_pk:data[18].pat_id_pk},
	             {ojos:data[72].pat_result, pat_id_pk:data[72].pat_id_pk}, 
	             {nariz: data[66].pat_result, pat_id_pk:data[66].pat_id_pk}, 
	             {torax: data[100].pat_result, pat_id_pk:data[100].pat_id_pk}, 
	             {perine: data[84].pat_result, pat_id_pk:data[84].pat_id_pk}, 
	             {minferiores: data[62].pat_result, pat_id_pk:data[62].pat_id_pk}, 
	             {genito: data[50].pat_result, pat_id_pk:data[50].pat_id_pk}, 
	             {cardiovascular: data[22].pat_result, pat_id_pk:data[22].pat_id_pk}, 
	             {orgsentidos: data[75].pat_result, pat_id_pk:data[75].pat_id_pk}, 
	             {endocrio: data[47].pat_result, pat_id_pk:data[47].pat_id_pk}, 
	             {neurologio: data[70].pat_result, pat_id_pk:data[70].pat_id_pk}, 
	             {hemolinf: data[52].pat_result, pat_id_pk:data[52].pat_id_pk}, 
	             {musculos: data[65].pat_result, pat_id_pk:data[65].pat_id_pk}, 
	             {digestivo: data[38].pat_result, pat_id_pk:data[38].pat_id_pk}, 
	             {respiratorio:data[94].pat_result, pat_id_pk:data[94].pat_id_pk},
	             {dincontinencia:$scope.bool(data[40].pat_result), pat_id_pk:data[40].pat_id_pk}, 
	             {dulcera: $scope.bool(data[43].pat_result), pat_id_pk:data[43].pat_id_pk}, 
	             {ddelirio: $scope.bool(data[29].pat_result), pat_id_pk:data[29].pat_id_pk}, 
	             {ddepresion: $scope.bool(data[31].pat_result), pat_id_pk:data[31].pat_id_pk}, 
	             {dfragilidad: $scope.bool(data[35].pat_result), pat_id_pk:data[35].pat_id_pk}, 
	             {ddismovilidad: $scope.bool(data[32].pat_result), pat_id_pk:data[32].pat_id_pk}, 
	             {dcaida: $scope.bool(data[28].pat_result), pat_id_pk:data[28].pat_id_pk}, 
	             {dmalnutricion: $scope.bool(data[42].pat_result), pat_id_pk:data[42].pat_id_pk}, 
	             {ddemencia: $scope.bool(data[30].pat_result), pat_id_pk:data[30].pat_id_pk},
	             {diatrogenia:$scope.bool(data[37].pat_result), pat_id_pk:data[37].pat_id_pk},
	            ];
            }
            else
            	{console.log(data);}
		});

 		}	
     }); 
}
$scope.boton_sigv=true; $scope.boton_ana=true;
$scope.activa_perfiles= function(){
$http.post('src/sgh/adultomayor/php/sghListaAdultomayor.php',{op:'8',fecha:$scope.cen_fecha,idhc:$scope.histoclinica}).success(function (data) {
     // console.log(data);	
        if (data.error ==="error") {$scope.boton_sigv=false; $scope.boton_ana=true;}
        else{
        	$http.post('src/sgh/adultomayor/php/sghListaAdultomayor.php',{op:'9',fecha:$scope.cen_fecha,idhc:$scope.histoclinica}).success(function (data) {
				if (data.error ==="error"){$scope.boton_sigv=true; $scope.boton_ana=true;}
         		else{$scope.boton_sigv=true; $scope.boton_ana=false;}
				//console.log(data);
        	});

         } 
        
     }); 	
}
/// signos virtales ingreso
$scope.guardar_signosvitales = function()
  {	
    //guardar epicrisis
     $http.post('src/sgh/adultomayor/php/sghInserAdultomayor.php',{ana:$scope.datosAguardar,hcl:$scope.histoclinica, usu:$scope.usuario,op:3}).success(function(data){	
             $scope.text = data.sgh_adulto_ingreso_pa;
 			 $scope.mensaje= true;
             $scope.dingreso();
           setTimeout(function(){
            $scope.mensaje= false;
			$scope.$apply();
            $scope.cancelar();
   		  	},1500);
         console.log(data);
  });
	}

////adulto mayor ingreso
$scope.datosAguardar={siv_imc:null, siv_percint:null,siv_percad:null,siv_perpan:null};
$scope.items=[
		     {vision:null}, 
		     {genitourinario:null},
		     {audision:null}, 
		     {rasmusculo:null},
		     {olfatogusto:null},
		     {endocriono10:null},
		     {reacsirespitatorio:null},
		     {hemolinfatico:null},
		     {reacsicardiovascular:null},
		     {nervioso:null},
		     {reacsidigestivo:null},
		     {caidas:null},
		     {dismovilidad:null},
		     {perdidapeso:false},
		     {astenia:false},
		     {desorientacion:false},
		     {alteracion:false},
		     {inmunoizaciones:null},
		     {actividadrecreativa:null},
		     {higienegeneral:null},
		     {controlessalud:null},
		     {higieneoral:null},
		     {alergias:null},
		     {ejercicios:null},
		     {otros:null},
		     {alimentacion:null},
		     {tabaquismo:false},
		     {alcoholismo:false},
		     {adicciones:false},
		     {otrohabito:false},
		     {demartologico:false},
		     {visuales:false},
		     {otorrino:false},
		     {estomatologicos:false},
		     {endocrinos:false},
		     {cardio:false},
		     {infecciosos:false},
		     { hemolinfaticos:false},
		     {urologicos:false},
		     {neurologicos:false},
		     {psiquiatricos:false},
		     {musculoesqueletico:false},
             {digestivos:false},
             {respiratorios:false},
             {oncologicos:false},
             {menopausia:null},
             {mamografia:null},
             {citologia:null},
             {embarazos:null},
             {partos:null},
             {cesareas:null},
             {tehormonal:null},
             {prostatica:null},
             {terapiahor:null},
             {aines:false},
             {analgesicos:false},
             {antidiabeticos:false},
             {antihipertensivos:false},
             {anticuagulantes:false},
             {psicofarmacos:false},
             {antibioticos:false},
             {otrofarcologico:false},
             {prescritores:null},
             {cardiopatias:null},
             {tuberculosis:null},
             {diabetes:null},
             {violencia:null},
             {hipertencion:null},
             {sindrome:null},
             {neoplasia:null},
             {otrosantecedentes:null},
             {parkinson:null},
             {alzheimer:null},
             {pifi:null},
             {oidos:null},
             {cuello:null},
             {abdomen:null},
             {msuperiores:null},
             {columna:null}, 
             {axilamama:null},
             {boca:null},
             {cabeza:null},
             {ojos:null}, 
             {nariz: null}, 
             {torax: null}, 
             {perine: null}, 
             {minferiores: null}, 
             {genito: null}, 
             {cardiovascular: null}, 
             {orgsentidos: null}, 
             {endocrio: null}, 
             {neurologio: null}, 
             {hemolinf: null}, 
             {musculos: null}, 
             {digestivo: null}, 
             {respiratorio:null},
             {dincontinencia: false}, 
             {dulcera: false}, 
             {ddelirio: false}, 
             {ddepresion: false}, 
             {dfragilidad: false}, 
             {ddismovilidad: false}, 
             {dcaida: false}, 
             {dmalnutricion: false}, 
             {ddemencia: false},
             {diatrogenia:false},
             
            ];
// accion de guardar o edicion //
$scope.accion=function(){
  if($scope.op === 'nuevo') { 
    $scope.guardar();
    }
  if($scope.op === 'editar') {
    $scope.actualizar();
  }
} 

//datos que estraigo de los campos para guardar
$scope.mensaje=false ;
$scope.gua=true;
//variables de paginacion

$scope.posicion=null;// guarda el total de items de la tabla
$scope.pagina=1; // variable de paginas a mostrar
/////////////// 
//cargar datos con json
$scope.actu=function(){
   $http.post('src/sgh/adultomayor/php/sghListaAdultomayor.php',{op:'1',idhc:$scope.histoclinica}).success(function (data) {
         if (data.error === "error") {
			alert("Error al cargar Adulto Mayor");
			console.log(data);
		}
         else{
          $scope.epicrisis = data;
 		  $scope.posicion=Math.ceil(data.length / $scope.totalpaginas);
 		}//console.log(data); 
     });

	$http.get('src/sgh/cie10/php/sghListarc10.php').success(function (data) {
		$scope.datosc10 = data;
		//console.log(data);
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
if ($scope.sgh_v_user === undefined){$scope.cerrarsecion();}

if ($scope.histoclinica === null){
  //alert("Escoja un pacinete");
  window.location = "#/";
}else{
$scope.actu();
}
$scope.tabla=true;

$scope.bool=function(valor){

	if (valor === "t"){
		var bool = true;
	}else{var bool = false;}
return bool;	
}

$scope.ver=function(id){
$scope.tabla=false;
$scope.datos=true;
$scope.ana(id);	
}
///cargar datos cie 10 //
$scope.com_string=function(valor){if (valor == true) {return 'true'}else{return 'false'}};
$scope.cargac10=function(){
   $http.post('src/sgh/adultomayor/php/sghListaAdultomayor.php',{op:'5',codigo:$scope.ana_id_pk}).success(function (data) {
            //console.log(data);
       if (data.erro==='error'){$scope.cie10=[]}
       else {
           $scope.cie10 = [];
           for (var i = 0; i < data.length; i++) {
               $scope.c10_id_pk = i;
               $scope.cie10.push({
                   c10_id: $scope.c10_id_pk,
                   c10_nombre: data[i].c10_nombre,
                   c10_codigo: data[i].c10_codigo,
                   dia_resp: $scope.com_string(data[i].dia_resp),
                   dia_id_pk: data[i].dia_id_pk,
                   descrip: data[i].dia_descrip,
                   c10_id_pk: data[i].c10_id_pk
               });
           }
      	 }
           });
  }
 /// ver datos adulto mayor
$scope.ana=function(id){
$scope.ana_id_pk=id;
 $http.post('src/sgh/adultomayor/php/sghListaAdultomayor.php',{codigo:id , op:'2'}).success(function(data)
	{
		//console.log(data);
    $scope.datosAguardar={
		    aam_id_pk:data[0].aam_id_pk, 	
			aam_antepe:data[0].aam_antepe,
			aam_antfam:data[0].aam_antfam,
			aam_enferm:data[0].aam_enferm,
			aam_esgene:data[0].aam_esgene,
			aam_exafis:data[0].aam_exafis,
			aam_fecha:data[0].aam_fecha,
			aam_inform:data[0].aam_inform,
			aam_meqrec:data[0].aam_meqrec,
			aam_motivo:data[0].aam_motivo,
			aam_prudia:data[0].aam_prudia,
			aam_reacsi:data[0].aam_reacsi,
			aam_respon:data[0].aam_respon,
			aam_trata:data[0].aam_trata,
   	 }
       $http.post('src/sgh/adultomayor/php/sghListaAdultomayor.php',{codigo:id , op:'7'}).success(function(data)
	       {
	       
		    $scope.datosAguardar.siv_id_pk=data[0].siv_id_pk;
		    $scope.datosAguardar.siv_defaud=data[0].siv_defaud;
		    $scope.datosAguardar.siv_defvis=data[0].siv_defvis;
		    $scope.datosAguardar.siv_freres=data[0].siv_freres;
		    $scope.datosAguardar.siv_imc=data[0].siv_imc;
			$scope.datosAguardar.siv_levand=data[0].siv_levand;
			$scope.datosAguardar.siv_peinor=data[0].siv_peinor;
			$scope.datosAguardar.siv_pemere=data[0].siv_pemere;
			$scope.datosAguardar.siv_percad=data[0].siv_percad;
			$scope.datosAguardar.siv_percint=data[0].siv_percint;
			$scope.datosAguardar.siv_perpan=data[0].siv_perpan;
			$scope.datosAguardar.siv_perpes=data[0].siv_perpes;
			$scope.datosAguardar.siv_peso=data[0].siv_peso;
			$scope.datosAguardar.siv_prarta=data[0].siv_prarta;
			$scope.datosAguardar.siv_prarte=data[0].siv_prarte;
			$scope.datosAguardar.siv_pubaso=data[0].siv_pubaso;
			$scope.datosAguardar.siv_pulso=data[0].siv_pulso;
			$scope.datosAguardar.siv_sacoso=data[0].siv_sacoso;
			$scope.datosAguardar.siv_talla=data[0].siv_talla;
			$scope.datosAguardar.siv_temper=data[0].siv_temper;
			$scope.datosAguardar.siv_triste=data[0].siv_triste;
			$scope.datosAguardar.siv_vivsol=data[0].siv_vivsol;
   		}); 
     
	});
 $http.post('src/sgh/adultomayor/php/sghListaAdultomayor.php',{codigo:id , op:'3'}).success(function(data)
	{
    $scope.items={
        abdomen:data[0].pat_result,
		actividadrecreativa:data[1].pat_result,
		adicciones:$scope.bool(data[ 2].pat_result),
		aines:$scope.bool(data[3 ].pat_result),
		alcoholismo:$scope.bool(data[4].pat_result),
		alergias:data[5].pat_result,
		alimentacion:data[6].pat_result,
		alteracion:$scope.bool(data[7].pat_result),
		alzheimer:data[8].pat_result,
		analgesicos:$scope.bool(data[9].pat_result),
		antibioticos:$scope.bool(data[10].pat_result),
		anticuagulantes:$scope.bool(data[11].pat_result),
		antidiabeticos:$scope.bool(data[12].pat_result),
		antihipertensivos:$scope.bool(data[13].pat_result),
		astenia:$scope.bool(data[14].pat_result),
		audision:data[15].pat_result, 
		axilamama:data[16].pat_result,
		boca:data[17].pat_result,
		cabeza:data[18].pat_result,
		caidas:$scope.bool(data[19].pat_result),
		cardio:$scope.bool(data[20].pat_result),
		cardiopatias:data[21].pat_result,
		cardiovascular: data[22].pat_result, 
		cesareas:data[23].pat_result,
		citologia:data[24].pat_result,
		columna:data[25].pat_result, 
		controlessalud:data[26].pat_result,
		cuello:data[27].pat_result,
		dcaida: $scope.bool(data[28].pat_result), 
		ddelirio: $scope.bool(data[29].pat_result), 
		ddemencia: $scope.bool(data[30].pat_result),
		ddepresion: $scope.bool(data[31].pat_result), 
		ddismovilidad: $scope.bool(data[32].pat_result), 
		demartologico:$scope.bool(data[33].pat_result),
		desorientacion:$scope.bool(data[34].pat_result),
		dfragilidad: $scope.bool(data[35].pat_result), 
		diabetes:data[36].pat_result,
		diatrogenia:$scope.bool(data[37].pat_result),
		digestivo: data[38].pat_result, 
		digestivos:$scope.bool(data[39].pat_result),
		dincontinencia: $scope.bool(data[40].pat_result), 
		dismovilidad:$scope.bool(data[41].pat_result),
		dmalnutricion: $scope.bool(data[42].pat_result), 
		dulcera: $scope.bool(data[43].pat_result), 
		ejercicios:data[44].pat_result,
		embarazos:data[45].pat_result,
		endocrinos:$scope.bool(data[46].pat_result),
		endocrio: data[47].pat_result, 
		endocriono10:data[48].pat_result,
		estomatologicos:$scope.bool(data[49].pat_result),
		genito: data[50].pat_result, 
		genitourinario:data[51].pat_result,
		hemolinf: data[52].pat_result, 
		hemolinfatico:data[53].pat_result,
		hemolinfaticos:$scope.bool(data[54].pat_result),
		higienegeneral:data[55].pat_result,
		higieneoral:data[56].pat_result,
		hipertencion:data[57].pat_result,
		infecciosos:$scope.bool(data[58].pat_result),
		inmunoizaciones:data[59].pat_result,
		mamografia:data[60].pat_result,
		menopausia:data[61].pat_result,
		minferiores: data[62].pat_result, 
		msuperiores:data[63].pat_result,
		musculoesqueletico:$scope.bool(data[64].pat_result),
		musculos: data[65].pat_result, 
		nariz: data[66].pat_result, 
		neoplasia:data[67].pat_result,
		nervioso:data[68].pat_result,
		neurologicos:$scope.bool(data[69].pat_result),
		neurologio: data[70].pat_result, 
		oidos:data[71].pat_result,
		ojos:data[72].pat_result, 
		olfatogusto:data[73].pat_result,
		oncologicos:$scope.bool(data[74].pat_result),
		orgsentidos: data[75].pat_result, 
		otorrino:$scope.bool(data[76].pat_result),
		otrofarcologico:$scope.bool(data[77].pat_result),
		otrohabito:$scope.bool(data[78].pat_result),
		otros:data[79].pat_result,
		otrosantecedentes:data[80].pat_result,
		parkinson:data[81].pat_result,
		partos:data[82].pat_result,
		perdidapeso:$scope.bool(data[83].pat_result),
		perine: data[84].pat_result, 
		pifi:data[85].pat_result,
		prescritores:data[86].pat_result,
		prostatica:data[87].pat_result,
		psicofarmacos:$scope.bool(data[88].pat_result),
		psiquiatricos:$scope.bool(data[89].pat_result),
		rasmusculo:data[90].pat_result,
		reacsicardiovascular:data[91].pat_result,
		reacsidigestivo:data[92].pat_result,
		reacsirespitatorio:data[93].pat_result,
		respiratorio: data[94].pat_result, 
		respiratorios:$scope.bool(data[95].pat_result),
		sindrome:data[96].pat_result,
		tabaquismo:$scope.bool(data[97].pat_result),
		tehormonal:data[98].pat_result,
		terapiahor:data[99].pat_result,
		torax: data[100].pat_result, 
		tuberculosis:data[101].pat_result,
		urologicos:$scope.bool(data[102].pat_result),
		violencia:data[103].pat_result,
		vision:data[104].pat_result, 
		visuales:$scope.bool(data[105].pat_result)
      }; 
 //	console.log(data);
	});
$scope.cargac10();
}
$scope.regreesar=function(){ 
 $scope.datos=false;	
 $scope.tabla=true; 
 $scope.cancelar();
}	

$scope. paginas = function(tipo)
{if (tipo == 0 && $scope.pagina  > 1 ){$scope.pagina-=1;}
 else if (tipo == 1 && $scope.pagina < $scope.posicion ){$scope.pagina+=1;}
}

// GUARDAR DATOS
$scope.cancelar = function(){
		    $("#closemodal").click()
		    $scope.titulo="OPCIONES DE INGRESO";
			///acciones a tomar segun perfil//
			$scope.perfiles=true;
			$scope.consulta_activa=false;
			$scope.sigv_activa=false;
			$scope.op="nuevo";
		    $scope.gua=true;
		    $scope.cie10 = [];
			$scope.codigo="";
			$scope.c10_id_pk=0;
			$scope.c10nuevo=true;
			$scope.c10
				=false;
	$scope.datosAguardar={siv_imc:null, siv_percint:null,siv_percad:null,siv_perpan:null};
	$scope.actguarda=false;
			$scope.actu();
$scope.items=[
		     {vision:null}, 
		     {genitourinario:null},
		     {audision:null}, 
		     {rasmusculo:null},
		     {olfatogusto:null},
		     {endocriono10:null},
		     {reacsirespitatorio:null},
		     {hemolinfatico:null},
		     {reacsicardiovascular:null},
		     {nervioso:null},
		     {reacsidigestivo:null},
		     {caidas:null},
		     {dismovilidad:null},
		     {perdidapeso:false},
		     {astenia:false},
		     {desorientacion:false},
		     {alteracion:false},
		     {inmunoizaciones:null},
		     {actividadrecreativa:null},
		     {higienegeneral:null},
		     {controlessalud:null},
		     {higieneoral:null},
		     {alergias:null},
		     {ejercicios:null},
		     {otros:null},
		     {alimentacion:null},
		     {tabaquismo:false},
		     {alcoholismo:false},
		     {adicciones:false},
		     {otrohabito:false},
		     {demartologico:false},
		     {visuales:false},
		     {otorrino:false},
		     {estomatologicos:false},
		     {endocrinos:false},
		     {cardio:false},
		     {infecciosos:false},
		     { hemolinfaticos:false},
		     {urologicos:false},
		     {neurologicos:false},
		     {psiquiatricos:false},
		     {musculoesqueletico:false},
             {digestivos:false},
             {respiratorios:false},
             {oncologicos:false},
             {menopausia:null},
             {mamografia:null},
             {citologia:null},
             {embarazos:null},
             {partos:null},
             {cesareas:null},
             {tehormonal:null},
             {prostatica:null},
             {terapiahor:null},
             {aines:false},
             {analgesicos:false},
             {antidiabeticos:false},
             {antihipertensivos:false},
             {anticuagulantes:false},
             {psicofarmacos:false},
             {antibioticos:false},
             {otrofarcologico:false},
             {prescritores:null},
             {cardiopatias:null},
             {tuberculosis:null},
             {diabetes:null},
             {violencia:null},
             {hipertencion:null},
             {sindrome:null},
             {neoplasia:null},
             {otrosantecedentes:null},
             {parkinson:null},
             {alzheimer:null},
             {pifi:null},
             {oidos:null},
             {cuello:null},
             {abdomen:null},
             {msuperiores:null},
             {columna:null}, 
             {axilamama:null},
             {boca:null},
             {cabeza:null},
             {ojos:null}, 
             {nariz: null}, 
             {torax: null}, 
             {perine: null}, 
             {minferiores: null}, 
             {genito: null}, 
             {cardiovascular: null}, 
             {orgsentidos: null}, 
             {endocrio: null}, 
             {neurologio: null}, 
             {hemolinf: null}, 
             {musculos: null}, 
             {digestivo: null}, 
             {respiratorio:null},
             {dincontinencia: false}, 
             {dulcera: false}, 
             {ddelirio: false}, 
             {ddepresion: false}, 
             {dfragilidad: false}, 
             {ddismovilidad: false}, 
             {dcaida: false}, 
             {dmalnutricion: false}, 
             {ddemencia: false},
             {diatrogenia:false},
             
          ];
}
	$scope.actguarda=false;
$scope.guardar = function() {
	$scope.actguarda=true;
     $http.post('src/sgh/adultomayor/php/sghInserAdultomayor.php',{items:$scope.items,ana:$scope.datosAguardar, hcl:$scope.histoclinica, usu:$scope.usuario,op:1}).success(function(data){	
             $scope.text = data.sgh_adulto_ingreso_pa;
			 $scope.mensaje= true;
            
            setTimeout(function(){
           	$scope.dingreso();
            $scope.mensaje= false;
			$scope.$apply();
            $scope.cancelar();			
   		  	},1500);
         //console.log(data);
    });
 }
// guarda cie10 ingreso
	$scope.dingreso=function(){
	 if ($scope.cie10!= null){
		   $http.post('src/sgh/adultomayor/php/sghInserAdultomayor.php',{c10:$scope.cie10 ,op:2, usu:$scope.usuario}).success(function(data)
       {
       		console.log(data);	
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
			// console.log(data);
			 if (data != "null"){
 			 $scope.cie10.push({c10_id: $scope.c10_id_pk, c10_nombre:data[0].c10_nombre, c10_codigo:data[0].c10_codigo, dia_resp:'true',descrip:'' ,c10_id_pk:data[0].c10_id_pk});
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
  $http.get('src/sgh/adultomayor/php/sghGetcie10.php?c='+ $scope.codigo).success(function(data){
  			 if (data != "null"){
   			 $scope.cie10[$scope.rec_codi]={c10_id_pk:data[0].c10_id_pk,c10_id: $scope.rec_codi, c10_nombre:data[0].c10_nombre, c10_codigo:data[0].c10_codigo, dia_resp:'true',descrip:'',dia_id_pk:$scope.dia_id_pk};
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
      $http.get('src/sgh/adultomayor/php/sghGetcie10.php?c='+ $scope.codigo).success(function(data){
      	//console.log(data);
      if (data != "null"){
	          $http.post('src/sgh/adultomayor/php/sghInserAdultomayor.php',{ usu:$scope.usuario,aam_id_pk:$scope.ana_id_pk,c10_id_pk:data[0].c10_id_pk, dia_resp:'true',descrip:'', op:9}).success(function(data)
              { 
              	console.log(data);
                $scope.cargac10();
              });
                
       }else
       {
       alert("Codigo cie10 no encontrado");
       }
    });
 }
/////////////edicin c10 /////////////////// 
$scope.editarc10=function(){
	 if ($scope.cie10!= null){
		   $http.post('src/sgh/adultomayor/php/sghInserAdultomayor.php',{ usu:$scope.usuario,c10:$scope.cie10 ,op:6}).success(function(data)
       {
       		//console.log(data);	
	   });
      	}
	}	

// ver datos de editar adulto mayor
$scope.editar=function(id){
    if ($scope.edita_paciente === true)
    {
        $scope.opedi=11;

    }else{
        $scope.opedi=6;
    }
$scope.ana_id_pk=id;
$scope.titulo="Editar Registro";
$scope.op="editar";
$scope.condi=false;
$scope.c10nuevo=false;
$scope.c10editar=true;
$scope.perfiles=false;
$scope.consulta_activa=true;
$scope.sigv_activa=false;
$http.post('src/sgh/adultomayor/php/sghListaAdultomayor.php',{codigo:id , op:$scope.opedi,usu:$scope.usuario}).success(function(data)
	{
		if (data != "0")
      {  
       $scope.datosAguardar={
		    aam_id_pk:data[0].aam_id_pk, 	
			aam_antepe:data[0].aam_antepe,
			aam_antfam:data[0].aam_antfam,
			aam_enferm:data[0].aam_enferm,
			aam_esgene:data[0].aam_esgene,
			aam_exafis:data[0].aam_exafis,
			aam_fecha:data[0].aam_fecha,
			aam_inform:data[0].aam_inform,
			aam_meqrec:data[0].aam_meqrec,
			aam_motivo:data[0].aam_motivo,
			aam_prudia:data[0].aam_prudia,
			aam_reacsi:data[0].aam_reacsi,
			aam_respon:data[0].aam_respon,
			aam_trata:data[0].aam_trata,
   	       }
   	       // Cargando signos vitales
       
       $http.post('src/sgh/adultomayor/php/sghListaAdultomayor.php',{codigo:id , op:'7'}).success(function(data)
	       {
	       
		    $scope.datosAguardar.siv_id_pk=data[0].siv_id_pk;
		    $scope.datosAguardar.siv_defaud=data[0].siv_defaud;
		    $scope.datosAguardar.siv_defvis=data[0].siv_defvis;
		    $scope.datosAguardar.siv_freres=data[0].siv_freres;
		    $scope.datosAguardar.siv_imc=data[0].siv_imc;
			$scope.datosAguardar.siv_levand=data[0].siv_levand;
			$scope.datosAguardar.siv_peinor=data[0].siv_peinor;
			$scope.datosAguardar.siv_pemere=data[0].siv_pemere;
			$scope.datosAguardar.siv_percad=data[0].siv_percad;
			$scope.datosAguardar.siv_percint=data[0].siv_percint;
			$scope.datosAguardar.siv_perpan=data[0].siv_perpan;
			$scope.datosAguardar.siv_perpes=data[0].siv_perpes;
			$scope.datosAguardar.siv_peso=data[0].siv_peso;
			$scope.datosAguardar.siv_prarta=data[0].siv_prarta;
			$scope.datosAguardar.siv_prarte=data[0].siv_prarte;
			$scope.datosAguardar.siv_pubaso=data[0].siv_pubaso;
			$scope.datosAguardar.siv_pulso=data[0].siv_pulso;
			$scope.datosAguardar.siv_sacoso=data[0].siv_sacoso;
			$scope.datosAguardar.siv_talla=data[0].siv_talla;
			$scope.datosAguardar.siv_temper=data[0].siv_temper;
			$scope.datosAguardar.siv_triste=data[0].siv_triste;
			$scope.datosAguardar.siv_vivsol=data[0].siv_vivsol;
   		});  
       // cargando puntos 
	    $http.post('src/sgh/adultomayor/php/sghListaAdultomayor.php',{codigo:id , op:'3'}).success(function(data)
	 	{
		   $scope.items=[
		     {vision:data[104].pat_result, pat_id_pk:data[104].pat_id_pk}, 
		     {genitourinario:data[51].pat_result,pat_id_pk:data[51].pat_id_pk},
		     {audision:data[15].pat_result, pat_id_pk:data[15].pat_id_pk}, 
		     {rasmusculo:data[90].pat_result, pat_id_pk:data[90].pat_id_pk},
		     {olfatogusto:data[73].pat_result, pat_id_pk:data[73].pat_id_pk},
		     {endocriono10:data[48].pat_result, pat_id_pk:data[48].pat_id_pk},
		     {reacsirespitatorio:data[93].pat_result, pat_id_pk:data[93].pat_id_pk},
		     {hemolinfatico:data[53].pat_result, pat_id_pk:data[53].pat_id_pk},
		     {reacsicardiovascular:data[91].pat_result, pat_id_pk:data[91].pat_id_pk},
		     {nervioso:data[68].pat_result, pat_id_pk:data[68].pat_id_pk},
		     {reacsidigestivo:data[92].pat_result, pat_id_pk:data[92].pat_id_pk},
		     {caidas:$scope.bool(data[19].pat_result), pat_id_pk:data[19].pat_id_pk},
		     {dismovilidad:$scope.bool(data[41].pat_result), pat_id_pk:data[41].pat_id_pk},
		     {perdidapeso:$scope.bool(data[83].pat_result), pat_id_pk:data[83].pat_id_pk},
		     {astenia:$scope.bool(data[14].pat_result), pat_id_pk:data[14].pat_id_pk},
		     {desorientacion:$scope.bool(data[34].pat_result), pat_id_pk:data[34].pat_id_pk},
		     {alteracion:$scope.bool(data[7].pat_result), pat_id_pk:data[7].pat_id_pk},
		     {inmunoizaciones:data[59].pat_result, pat_id_pk:data[59].pat_id_pk},
		     {actividadrecreativa:data[1].pat_result, pat_id_pk:data[1].pat_id_pk},
		     {higienegeneral:data[55].pat_result, pat_id_pk:data[55].pat_id_pk},
		     {controlessalud:data[26].pat_result, pat_id_pk:data[26].pat_id_pk},
		     {higieneoral:data[56].pat_result, pat_id_pk:data[56].pat_id_pk},
		     {alergias:data[5].pat_result, pat_id_pk:data[5].pat_id_pk},
		     {ejercicios:data[44].pat_result, pat_id_pk:data[44].pat_id_pk},
		     {otros:data[79].pat_result, pat_id_pk:data[79].pat_id_pk},
		     {alimentacion:data[6].pat_result, pat_id_pk:data[6].pat_id_pk},
		     {tabaquismo:$scope.bool(data[97].pat_result), pat_id_pk:data[97].pat_id_pk},
		     {alcoholismo:$scope.bool(data[4].pat_result), pat_id_pk:data[4].pat_id_pk},
		     {adicciones:$scope.bool(data[2].pat_result), pat_id_pk:data[2].pat_id_pk},
		     {otrohabito:$scope.bool(data[78].pat_result), pat_id_pk:data[78].pat_id_pk},
		     {demartologico:$scope.bool(data[33].pat_result), pat_id_pk:data[33].pat_id_pk},
		     {visuales:$scope.bool(data[105].pat_result), pat_id_pk:data[105].pat_id_pk},
		     {otorrino:$scope.bool(data[76].pat_result), pat_id_pk:data[76].pat_id_pk},
		     {estomatologicos:$scope.bool(data[49].pat_result), pat_id_pk:data[49].pat_id_pk},
		     {endocrinos:$scope.bool(data[48].pat_result), pat_id_pk:data[48].pat_id_pk},
		     {cardio:$scope.bool(data[20].pat_result), pat_id_pk:data[20].pat_id_pk},
		     {infecciosos:$scope.bool(data[58].pat_result), pat_id_pk:data[58].pat_id_pk},
		     {hemolinfaticos:$scope.bool(data[54].pat_result), pat_id_pk:data[54].pat_id_pk},
		     {urologicos:$scope.bool(data[102].pat_result), pat_id_pk:data[102].pat_id_pk},
		     {neurologicos:$scope.bool(data[69].pat_result), pat_id_pk:data[69].pat_id_pk},
		     {psiquiatricos:$scope.bool(data[89].pat_result), pat_id_pk:data[89].pat_id_pk},
		     {musculoesqueletico:$scope.bool(data[64].pat_result), pat_id_pk:data[64].pat_id_pk},
             {digestivos:$scope.bool(data[39].pat_result), pat_id_pk:data[39].pat_id_pk},
             {respiratorios:$scope.bool(data[95].pat_result), pat_id_pk:data[95].pat_id_pk},
             {oncologicos:$scope.bool(data[74].pat_result), pat_id_pk:data[74].pat_id_pk},
             {menopausia:data[61].pat_result, pat_id_pk:data[61].pat_id_pk},
             {mamografia:data[60].pat_result, pat_id_pk:data[60].pat_id_pk},
             {citologia:data[24].pat_result, pat_id_pk:data[24].pat_id_pk},
             {embarazos:data[45].pat_result, pat_id_pk:data[45].pat_id_pk},
             {partos:data[82].pat_result, pat_id_pk:data[82].pat_id_pk},
             {cesareas:data[23].pat_result, pat_id_pk:data[23].pat_id_pk},
             {tehormonal:data[98].pat_result, pat_id_pk:data[98].pat_id_pk},
             {prostatica:data[87].pat_result, pat_id_pk:data[87].pat_id_pk},
             {terapiahor:data[99].pat_result, pat_id_pk:data[99].pat_id_pk},
             {aines:$scope.bool(data[3].pat_result), pat_id_pk:data[3].pat_id_pk},
             {analgesicos:$scope.bool(data[9].pat_result), pat_id_pk:data[9].pat_id_pk},
             {antidiabeticos:$scope.bool(data[12].pat_result), pat_id_pk:data[12].pat_id_pk},
             {antihipertensivos:$scope.bool(data[13].pat_result), pat_id_pk:data[13].pat_id_pk},
             {anticuagulantes:$scope.bool(data[11].pat_result), pat_id_pk:data[11].pat_id_pk},
             {psicofarmacos:$scope.bool(data[88].pat_result), pat_id_pk:data[88].pat_id_pk},
             {antibioticos:$scope.bool(data[10].pat_result), pat_id_pk:data[10].pat_id_pk},
             {otrofarcologico:$scope.bool(data[77].pat_result), pat_id_pk:data[77].pat_id_pk},
             {prescritores:data[86].pat_result, pat_id_pk:data[86].pat_id_pk},
             {cardiopatias:data[21].pat_result, pat_id_pk:data[21].pat_id_pk},
             {tuberculosis:data[101].pat_result, pat_id_pk:data[101].pat_id_pk},
             {diabetes:data[36].pat_result, pat_id_pk:data[36].pat_id_pk},
             {violencia:data[103].pat_result, pat_id_pk:data[103].pat_id_pk},
             {hipertencion:data[57].pat_result, pat_id_pk:data[57].pat_id_pk},
             {sindrome:data[96].pat_result, pat_id_pk:data[96].pat_id_pk},
             {neoplasia:data[67].pat_result, pat_id_pk:data[67].pat_id_pk},
             {otrosantecedentes:data[80].pat_result, pat_id_pk:data[80].pat_id_pk},
             {parkinson:data[81].pat_result, pat_id_pk:data[81].pat_id_pk},
             {alzheimer:data[8].pat_result, pat_id_pk:data[8].pat_id_pk},
             {pifi:data[85].pat_result, pat_id_pk:data[85].pat_id_pk},
             {oidos:data[71].pat_result, pat_id_pk:data[71].pat_id_pk},
             {cuello:data[27].pat_result, pat_id_pk:data[27].pat_id_pk},
             {abdomen:data[0].pat_result, pat_id_pk:data[0].pat_id_pk},
             {msuperiores:data[63].pat_result, pat_id_pk:data[63].pat_id_pk},
             {columna:data[25].pat_result, pat_id_pk:data[25].pat_id_pk}, 
             {axilamama:data[16].pat_result, pat_id_pk:data[16].pat_id_pk},
             {boca:data[17].pat_result, pat_id_pk:data[17].pat_id_pk},
             {cabeza:data[18].pat_result, pat_id_pk:data[18].pat_id_pk},
             {ojos:data[72].pat_result, pat_id_pk:data[72].pat_id_pk}, 
             {nariz: data[66].pat_result, pat_id_pk:data[66].pat_id_pk}, 
             {torax: data[100].pat_result, pat_id_pk:data[100].pat_id_pk}, 
             {perine: data[84].pat_result, pat_id_pk:data[84].pat_id_pk}, 
             {minferiores: data[62].pat_result, pat_id_pk:data[62].pat_id_pk}, 
             {genito: data[50].pat_result, pat_id_pk:data[50].pat_id_pk}, 
             {cardiovascular: data[22].pat_result, pat_id_pk:data[22].pat_id_pk}, 
             {orgsentidos: data[75].pat_result, pat_id_pk:data[75].pat_id_pk}, 
             {endocrio: data[47].pat_result, pat_id_pk:data[47].pat_id_pk}, 
             {neurologio: data[70].pat_result, pat_id_pk:data[70].pat_id_pk}, 
             {hemolinf: data[52].pat_result, pat_id_pk:data[52].pat_id_pk}, 
             {musculos: data[65].pat_result, pat_id_pk:data[65].pat_id_pk}, 
             {digestivo: data[38].pat_result, pat_id_pk:data[38].pat_id_pk}, 
             {respiratorio:data[94].pat_result, pat_id_pk:data[94].pat_id_pk},
             {dincontinencia:$scope.bool(data[40].pat_result), pat_id_pk:data[40].pat_id_pk}, 
             {dulcera: $scope.bool(data[43].pat_result), pat_id_pk:data[43].pat_id_pk}, 
             {ddelirio: $scope.bool(data[29].pat_result), pat_id_pk:data[29].pat_id_pk}, 
             {ddepresion: $scope.bool(data[31].pat_result), pat_id_pk:data[31].pat_id_pk}, 
             {dfragilidad: $scope.bool(data[35].pat_result), pat_id_pk:data[35].pat_id_pk}, 
             {ddismovilidad: $scope.bool(data[32].pat_result), pat_id_pk:data[32].pat_id_pk}, 
             {dcaida: $scope.bool(data[28].pat_result), pat_id_pk:data[28].pat_id_pk}, 
             {dmalnutricion: $scope.bool(data[42].pat_result), pat_id_pk:data[42].pat_id_pk}, 
             {ddemencia: $scope.bool(data[30].pat_result), pat_id_pk:data[30].pat_id_pk},
             {diatrogenia:$scope.bool(data[37].pat_result), pat_id_pk:data[37].pat_id_pk},
            ];
		});
        $scope.cargac10();
        $("#n").click()
       }

 	else
 	{
 	   alert("Lo Sentimos, ya pasaron más de 24 horas");
       $scope.cancelar();
 	}
});

}

/// guardar datos de edicion //
$scope.actualizar=function(){
	$scope.actguarda=true;
     $http.post('src/sgh/adultomayor/php/sghInserAdultomayor.php',{ usu:$scope.usuario,items:$scope.items,usu:$scope.usuario,ana:$scope.datosAguardar,op:5}).success(function(data){
             $scope.text = data.sgh_adulto_ingreso_pa;
			 $scope.mensaje= true;
           setTimeout(function(){
           	$scope.editarc10();
            $scope.mensaje= false;
			$scope.$apply();
            $scope.cancelar();			
   		  	},1500);
         console.log(data);
    });
}

}]);

