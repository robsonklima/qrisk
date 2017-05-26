angular.module("qrisk").factory("riscosDemandaAPI", function($http, config) {
  
    var _marcarRiscoDemandaProblema = function (id_risco, id_demanda, valor) {
        return $http.post(config.baseUrl + 'riscodemanda.ctrl.php?acao=marcar_risco_demanda_problema', 
                          {id_risco: id_risco, id_demanda: id_demanda, valor: valor});
    }
    
    return {
        marcarRiscoDemandaProblema: _marcarRiscoDemandaProblema
    }; 
});