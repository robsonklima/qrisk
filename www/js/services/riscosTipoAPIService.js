angular.module("qrisk").factory("riscosTipoAPI", function($http, config) {
  
    var _buscarTodos = function () {
        return $http.get(config.baseUrl + 'riscotipo.ctrl.php?acao=buscar_todos');
    }
    
    var _buscarPorId = function (id) {
        return $http.post(config.baseUrl + 'riscotipo.ctrl.php?acao=buscar_por_id', {id: id});
    }
    
    var _adicionar = function (item) {
        return $http.post(config.baseUrl + 'riscotipo.ctrl.php?acao=adicionar', item);
    }
    
    var _atualizar = function (item) {
        return $http.post(config.baseUrl + 'riscotipo.ctrl.php?acao=atualizar', item);
    }
    
    var _apagar = function (id) {
        return $http.post(config.baseUrl + 'riscotipo.ctrl.php?acao=apagar', {recordId: id});
    }
  
    return {
        buscarTodos: _buscarTodos,
        buscarPorId: _buscarPorId,
        adicionar: _adicionar,
        atualizar: _atualizar,
        apagar: _apagar
    }; 
});