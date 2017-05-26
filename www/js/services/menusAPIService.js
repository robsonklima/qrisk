angular.module("qrisk").factory("menusAPI", function($http, config) {
  
    var _buscarTodos = function () {
        return $http.get(config.baseUrl + 'menu.ctrl.php?acao=buscar_todos');
    }
    
    var _buscarPorId = function (id) {
        return $http.post(config.baseUrl + 'menu.ctrl.php?acao=buscar_por_id', {id: id});
    }
    
    var _buscarPorIdUsuarioPerfil = function (id_usuario_perfil) {
        return $http.post(config.baseUrl + 'menu.ctrl.php?acao=buscar_por_id_usuario_perfil', {id_usuario_perfil: id_usuario_perfil});
    }
    
    var _adicionar = function (item) {
        return $http.post(config.baseUrl + 'menu.ctrl.php?acao=adicionar', item);
    }
    
    var _atualizar = function (item) {
        return $http.post(config.baseUrl + 'menu.ctrl.php?acao=atualizar', item);
    }
    
    var _apagar = function (id) {
        return $http.post(config.baseUrl + 'menu.ctrl.php?acao=apagar', {recordId: id});
    }
  
    return {
        buscarTodos: _buscarTodos,
        buscarPorId: _buscarPorId,
        buscarPorIdUsuarioPerfil: _buscarPorIdUsuarioPerfil,
        adicionar: _adicionar,
        atualizar: _atualizar,
        apagar: _apagar
    }; 
    
});