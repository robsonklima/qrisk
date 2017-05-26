angular.module("qrisk").factory("demandasAPI", function($http, config) {
  
    var _buscarTodos = function () {
        return $http.get(config.baseUrl + 'demanda.ctrl.php?acao=buscar_todos');
    }
    
    var _buscarPorId = function (id) {
        return $http.post(config.baseUrl + 'demanda.ctrl.php?acao=buscar_por_id', {id: id});
    }
    
    var _buscarPorIdUsuario = function (id_usuario) {
        return $http.post(config.baseUrl + 'demanda.ctrl.php?acao=buscar_por_id_usuario', {id_usuario: id_usuario});
    }
    
    var _adicionar = function (item) {
        return $http.post(config.baseUrl + 'demanda.ctrl.php?acao=adicionar', item);
    }
    
    var _atualizar = function (item) {
        return $http.post(config.baseUrl + 'demanda.ctrl.php?acao=atualizar', item);
    }
    
    var _apagar = function (id) {
        return $http.post(config.baseUrl + 'demanda.ctrl.php?acao=apagar', {recordId: id});
    }
  
    return {
        buscarTodos: _buscarTodos,
        buscarPorId: _buscarPorId,
        buscarPorIdUsuario: _buscarPorIdUsuario,
        adicionar: _adicionar,
        atualizar: _atualizar,
        apagar: _apagar
    }; 
});