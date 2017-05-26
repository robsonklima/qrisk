angular.module("qrisk").controller("dashboardCtrl", function ($scope, $mdToast, $routeParams, $rootScope, $route, riscosAPI, riscosAnaliseAPI) {
    $scope.pageTitle = "Dashboard";
    $scope.nomeUsuario = $rootScope.globals.currentUser.nome;
    
    riscosAnaliseAPI.buscarRiscosMaisCriticos().success(function(data, status) {
        $scope.riscos = data;
    });
    
    $scope.riscos_por_categorias = {};
    riscosAPI.buscarGraficoRiscosPorCategorias().success(function(data, status) {
        $scope.riscos_por_categorias = data;
    });
    
    $scope.riscos_por_demandas = {};
    riscosAPI.buscarGraficoRiscosPorDemandas().success(function(data, status) {
        $scope.riscos_por_demandas = data;
    });
    
    $scope.riscos_por_projetos = {};
    riscosAPI.buscarGraficoRiscosPorProjetos().success(function(data, status) {
        $scope.riscos_por_projetos = data;
    });
    
    $scope.problemas_por_projetos = {};
    riscosAPI.buscarGraficoProblemasPorProjetos().success(function(data, status) {
        $scope.problemas_por_projetos = data;
    });
    
    $scope.problemas_por_demandas = {};
    riscosAPI.buscarGraficoProblemasPorDemandas().success(function(data, status) {
        $scope.problemas_por_demandas = data;
    });
});