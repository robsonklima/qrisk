angular.module("qrisk").controller("projetoInfoCtrl", function ($scope, $routeParams, $route, $location, projetosAPI, riscosAPI, riscosAnaliseAPI) {
    $scope.pageTitle = "General analysis of the project";

    projetosAPI.buscarPorId($route.current.params.id).success(function(data, status) {
        $scope.projeto = data;
    });

    riscosAPI.buscarRiscosPorIdProjeto($route.current.params.id).success(function(data, status) {
        $scope.riscos = data;
    });

    var buscarAnaliseProjeto = function() {
        riscosAnaliseAPI.buscarAnaliseProjeto($route.current.params.id).success(function(data, status) {
            if (data)
                $scope.projeto_analise = data;
            else
                $scope.error = "Unable to fetch the project data.";
        }).error(function (data, status) {
            $scope.error = "Unable to fetch the project data.";
        });
    };

    riscosAnaliseAPI.buscarValoresEsperadosPorIdProj($route.current.params.id).success(function(data, status) {
        $scope.valor_esperado = data;
    });

    buscarAnaliseProjeto();
});
