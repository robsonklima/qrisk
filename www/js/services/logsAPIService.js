angular.module("qrisk").factory("logsAPI", function($http, config) {
  
    var _buscarTodos = function () {
        return $http.get(config.baseUrl + 'log.ctrl.php?acao=buscar_todos');
    }
    
    var _apagar = function (id_usuario) {
        return $http.post(config.baseUrl + 'log.ctrl.php?acao=apagar', {id_usuario: id_usuario});
    }
  
    return {
        buscarTodos: _buscarTodos,
        apagar: _apagar
    }; 
    
});