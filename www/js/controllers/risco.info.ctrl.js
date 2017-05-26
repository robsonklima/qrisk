angular.module("qrisk").controller("riscoInfoCtrl", function ($scope, $routeParams, $route, $mdDialog, $mdToast, $location, riscosAPI, riscosAnaliseAPI, projetosAPI) {
    $scope.pageTitle = "General risk analysis";
    var id_risco = $route.current.params.id;

    var buscarPorId = function() {
        riscosAPI.buscarPorId(id_risco).success(function (data) {
            if (data)
                $scope.risco = data;
            else
                $scope.error = "Unable to fetch the risks.";
        }).error(function (data, status) {
            $scope.error = "Unable to fetch the risks.";
        });
    };

    $scope.delItem = function (item) {
        var confirm = $mdDialog.confirm().textContent('Are you sure to delete this this analysis?')
            .ok('Sim').clickOutsideToClose(true).cancel('Cancel');

        $mdDialog.show(confirm).then(function() {
            riscosAnaliseAPI.apagar(item.id).success(function (data) {
                $scope.success = data;
                buscarAnaliseGeralRisco();
                buscarAnaliseDetalhadaRisco();
                buscarPorId(id_risco);
            }).error(function (data, status) {
                $scope.error = "Unable to delete this analysis.";
            });
        });
    };

    var buscarAnaliseGeralRisco = function() {
        riscosAnaliseAPI.buscarAnaliseGeralRisco(id_risco).success(function (data) {
            if (data) $scope.risco_analise_geral = data;
        }).error(function (data, status) {
            $scope.error = "Unable to fetch the general risk analysis.";
        });
    };

    var buscarAnaliseDetalhadaRisco = function() {
        riscosAnaliseAPI.buscarAnaliseDetalhadaRisco(id_risco).success(function (data) {
            if (data) $scope.risco_analise_detalhada = data;
        }).error(function (data, status) {
            $scope.error = "Unable to fetch the general risk analysis.";
        });
    };

    buscarPorId();
    buscarAnaliseGeralRisco();
    buscarAnaliseDetalhadaRisco();
});
