angular.module("qrisk").factory("usuariosAPI", function($http, config) {
  
    var _buscarTodos = function () {
        return $http.get(config.baseUrl + 'usuario.ctrl.php?acao=buscar_todos');
    }
    
    var _buscarUsuSemRec = function () {
        return $http.get(config.baseUrl + 'usuario.ctrl.php?acao=buscar_usu_sem_rec');
    }
    
    var _buscarPorId = function (id) {
        return $http.post(config.baseUrl + 'usuario.ctrl.php?acao=buscar_por_id', {id: id});
    }
    
    var _adicionar = function (item) {
        return $http.post(config.baseUrl + 'usuario.ctrl.php?acao=adicionar', item);
    }
    
    var _atualizar = function (item) {
        return $http.post(config.baseUrl + 'usuario.ctrl.php?acao=atualizar', item);
    }
    
    var _apagar = function (id) {
        return $http.post(config.baseUrl + 'usuario.ctrl.php?acao=apagar', {recordId: id});
    }
  
    return {
        buscarTodos: _buscarTodos,
        buscarUsuSemRec: _buscarUsuSemRec,
        buscarPorId: _buscarPorId,
        adicionar: _adicionar,
        atualizar: _atualizar,
        apagar: _apagar
    }; 
});