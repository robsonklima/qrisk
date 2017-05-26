angular.module("qrisk").factory("fileUploadAPI", function($http, config) {
    
    var _buscarTodos = function () {
        return $http.get(config.baseUrl + 'fileupload.ctrl.php?acao=buscar_todos');
    }
    
    var _adicionar = function(file, descricao, id_usuario){
         var fd = new FormData();
         var uploadUrl = config.baseUrl + 'fileupload.ctrl.php?acao=adicionar';
         fd.append('file', file);
         fd.append('descricao', descricao);
         fd.append('id_usuario', id_usuario);
         
         return $http.post(uploadUrl, fd, {
             transformRequest: angular.identity,
             headers: {'Content-Type': undefined,'Process-Data': false}
         });
     }
    
    var _apagar = function (id) {
        return $http.post(config.baseUrl + 'fileupload.ctrl.php?acao=apagar', {recordId: id});
    }
    
    return {
        buscarTodos: _buscarTodos,
        adicionar: _adicionar,
        apagar: _apagar
        
    }; 
});