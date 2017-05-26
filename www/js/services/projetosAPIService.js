angular.module("qrisk").factory("projetosAPI", function($http, config) {
  
    var _buscarTodos = function () {
        return $http.get(config.baseUrl + 'projeto.ctrl.php?acao=buscar_todos');
    }
    
    var _buscarPorId = function (id) {
        return $http.post(config.baseUrl + 'projeto.ctrl.php?acao=buscar_por_id', {id: id});
    }
    
    var _buscarTodosPorIdRisco = function (id_risco) {
        return $http.post(config.baseUrl + 'projeto.ctrl.php?acao=buscar_todos_por_id_risco', {id_risco: id_risco});
    }
    
    var _buscarTodosPorIdUsuario = function (id_usuario) {
        return $http.post(config.baseUrl + 'projeto.ctrl.php?acao=buscar_todos_por_id_usuario', {id_usuario: id_usuario});
    }
    
    var _buscarRiscosPorIdProjeto = function (id) {
        return $http.post(config.baseUrl + 'projeto.ctrl.php?acao=buscar_riscos_por_id_projeto', {id: id});
    }
    
    var _adicionar = function (item) {
        return $http.post(config.baseUrl + 'projeto.ctrl.php?acao=adicionar', item);
    }
    
    var _atualizar = function (item) {
        return $http.post(config.baseUrl + 'projeto.ctrl.php?acao=atualizar', item);
    }
    
    var _apagar = function (id) {
        return $http.post(config.baseUrl + 'projeto.ctrl.php?acao=apagar', {recordId: id});
    }
    
    return {
        buscarTodos: _buscarTodos,
        buscarTodosPorIdRisco: _buscarTodosPorIdRisco,
        buscarTodosPorIdUsuario: _buscarTodosPorIdUsuario,
        buscarRiscosPorIdProjeto: _buscarRiscosPorIdProjeto,
        buscarPorId: _buscarPorId,
        adicionar: _adicionar,
        atualizar: _atualizar,
        apagar: _apagar
    }; 
    
});