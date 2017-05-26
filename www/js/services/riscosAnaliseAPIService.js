angular.module("qrisk").factory("riscosAnaliseAPI", function($http, config) {
  
    var _buscarRiscosDispAnalise = function (id) {
        return $http.post(config.baseUrl + 'riscoanalise.ctrl.php?acao=buscar_riscos_disp_analise', {id_usuario: id});
    }
    
    var _buscarPorId = function (id) {
        return $http.post(config.baseUrl + 'riscoanalise.ctrl.php?acao=buscar_por_id', {id: id});
    }
    
    var _adicionar = function (item) {
        return $http.post(config.baseUrl + 'riscoanalise.ctrl.php?acao=adicionar', item);
    }
    
    var _apagar = function (id) {
        return $http.post(config.baseUrl + 'riscoanalise.ctrl.php?acao=apagar', {recordId: id});
    }
      
    // Combos
    var _buscarTipoCusto = function () {
        return $http.get(config.baseUrl + 'riscoanalise.ctrl.php?acao=buscar_tipo_custo');
    }
    
    var _buscarTipoCronograma = function () {
        return $http.get(config.baseUrl + 'riscoanalise.ctrl.php?acao=buscar_tipo_cronograma');
    }
    
    var _buscarTipoEscopo = function () {
        return $http.get(config.baseUrl + 'riscoanalise.ctrl.php?acao=buscar_tipo_escopo');
    }
    
    var _buscarTipoQualidade = function () {
        return $http.get(config.baseUrl + 'riscoanalise.ctrl.php?acao=buscar_tipo_qualidade');
    }
    
    var _buscarTipoProbabilidade = function () {
        return $http.get(config.baseUrl + 'riscoanalise.ctrl.php?acao=buscar_tipo_probabilidade');
    }
    // Combos
    
    var _buscarAnaliseGeralRisco = function (id) {
        return $http.post(config.baseUrl + 'riscoanalise.ctrl.php?acao=buscar_analise_geral_risco', {id: id});
    }
    
    var _buscarAnaliseDetalhadaRisco = function (id) {
        return $http.post(config.baseUrl + 'riscoanalise.ctrl.php?acao=buscar_analise_detalhada_risco', {id: id});
    }
    
    var _buscarAnaliseDetalhadaRiscoPorUsuario = function (id) {
        return $http.post(config.baseUrl + 'riscoanalise.ctrl.php?acao=buscar_analise_detalhada_risco_por_usuario', {id: id});
    }
    
    var _buscarAnaliseProjeto = function (id) {
        return $http.post(config.baseUrl + 'riscoanalise.ctrl.php?acao=buscar_analise_projeto', {id: id});
    }
    
    var _buscarValoresEsperadosPorIdProj = function (id) {
        return $http.post(config.baseUrl + 'riscoanalise.ctrl.php?acao=buscar_valores_esperados_por_id_proj', {id: id});
    }
    
    var _buscarRiscosMaisCriticos = function () {
        return $http.post(config.baseUrl + 'riscoanalise.ctrl.php?acao=buscar_riscos_mais_criticos');
    }
    
    return {
        buscarRiscosDispAnalise: _buscarRiscosDispAnalise,
        buscarPorId: _buscarPorId,
        buscarTipoCusto: _buscarTipoCusto,
        buscarTipoCronograma: _buscarTipoCronograma,
        buscarTipoEscopo: _buscarTipoEscopo,
        buscarTipoQualidade: _buscarTipoQualidade,
        buscarTipoProbabilidade: _buscarTipoProbabilidade,
        buscarAnaliseGeralRisco: _buscarAnaliseGeralRisco,
        buscarAnaliseDetalhadaRisco: _buscarAnaliseDetalhadaRisco,
        buscarAnaliseDetalhadaRiscoPorUsuario: _buscarAnaliseDetalhadaRiscoPorUsuario,
        buscarAnaliseProjeto: _buscarAnaliseProjeto,
        buscarValoresEsperadosPorIdProj: _buscarValoresEsperadosPorIdProj,
        buscarRiscosMaisCriticos: _buscarRiscosMaisCriticos,
        adicionar: _adicionar,
        apagar: _apagar
    }; 
});