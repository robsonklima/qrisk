angular.module("qrisk").factory("riscosProjetoAPI", function($http, config) {
  
    var _marcarRiscoProjetoProblema = function (id_risco, id_projeto, valor) {
        return $http.post(config.baseUrl + 'riscoprojeto.ctrl.php?acao=marcar_risco_projeto_problema', 
                          {id_risco: id_risco, id_projeto: id_projeto, valor: valor});
    }
    
    return {
        marcarRiscoProjetoProblema: _marcarRiscoProjetoProblema
    }; 
});