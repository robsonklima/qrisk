angular.module("qrisk").factory("riscosAPI", function($http, config) {
  
    var _buscarTodos = function () {
        return $http.get(config.baseUrl + 'risco.ctrl.php?acao=buscar_todos');
    }
    
    var _buscarPorId = function (id) {
        return $http.post(config.baseUrl + 'risco.ctrl.php?acao=buscar_por_id', {id: id});
    }
    
    var _buscarPorIdRiscoEIdProjeto = function (id_risco, id_projeto) {
        return $http.post(config.baseUrl + 'risco.ctrl.php?acao=buscar_por_id_risco_e_id_projeto', {
            id_risco: id_risco, id_projeto: id_projeto
        });
    }
    
    var _buscarRiscosPorIdProjeto = function (id) {
        return $http.post(config.baseUrl + 'risco.ctrl.php?acao=buscar_riscos_por_id_projeto', {id: id});
    }
    
    var _buscarGraficoRiscosPorCategorias = function () {
        return $http.get(config.baseUrl + 'risco.ctrl.php?acao=buscar_grafico_riscos_por_categorias');
    }
    
    var _buscarGraficoRiscosPorProjetos = function () {
        return $http.get(config.baseUrl + 'risco.ctrl.php?acao=buscar_grafico_riscos_por_projetos');
    }
    
    var _buscarGraficoRiscosPorDemandas = function () {
        return $http.get(config.baseUrl + 'risco.ctrl.php?acao=buscar_grafico_riscos_por_demandas');
    }
    
    var _buscarGraficoProblemasPorProjetos = function () {
        return $http.get(config.baseUrl + 'risco.ctrl.php?acao=buscar_grafico_problemas_por_projetos');
    }
    
    var _buscarGraficoProblemasPorDemandas = function () {
        return $http.get(config.baseUrl + 'risco.ctrl.php?acao=buscar_grafico_problemas_por_demandas');
    }
    
    var _adicionar = function (item) {
        return $http.post(config.baseUrl + 'risco.ctrl.php?acao=adicionar', item);
    }
    
    var _atualizar = function (item) {
        return $http.post(config.baseUrl + 'risco.ctrl.php?acao=atualizar', item);
    }
    
    var _apagar = function (id) {
        return $http.post(config.baseUrl + 'risco.ctrl.php?acao=apagar', {recordId: id});
    }
    
    return {
        buscarTodos: _buscarTodos,
        buscarPorId: _buscarPorId,
        buscarRiscosPorIdProjeto: _buscarRiscosPorIdProjeto,
        buscarPorIdRiscoEIdProjeto: _buscarPorIdRiscoEIdProjeto,
        buscarGraficoRiscosPorCategorias: _buscarGraficoRiscosPorCategorias,
        buscarGraficoRiscosPorProjetos: _buscarGraficoRiscosPorProjetos,
        buscarGraficoRiscosPorDemandas: _buscarGraficoRiscosPorDemandas,
        buscarGraficoProblemasPorProjetos: _buscarGraficoProblemasPorProjetos,
        buscarGraficoProblemasPorDemandas: _buscarGraficoProblemasPorDemandas,
        adicionar: _adicionar,
        atualizar: _atualizar,
        apagar: _apagar
    }; 
});