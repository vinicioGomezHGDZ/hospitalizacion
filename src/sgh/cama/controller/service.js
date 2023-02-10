angular.module("camas",[])
.factory("getAll_camaFactory",["$http", function($http){
    var getData = {};
    getData.get = function(){
        return $http.post("src/sgh/cama/model/getAll.php",
            {
                "cam_visible_valor":null
            });
    };
    return getData;
}])
.factory("getAll_tipocamaFactory",["$http", function($http){
    var getData = {};
    getData.get = function(){
        return $http.get("src/sgh/tipocama/model/getAll.php");
    };
    return getData;
}])
.factory("iu_camaFactory",["$http", function($http){
    var getData = {};
    getData.post = function(getData){
        return $http.post("src/sgh/cama/model/insert_update.php",getData)
            .success(function(response){
                getData = response;
        });
    };
    return getData;
}])
.factory("deleteById_camaFactory",["$http", function($http){
    var getData = {};
    getData.post = function(getData){
        return $http.post("src/sgh/cama/model/deleteByID.php",
            {
                cam_id_pk: getData.cam_id_pk
            }).success(function(response){
            getData = response;
        });
    };
    return getData;
}]);


