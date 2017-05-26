angular.module("qrisk").controller("riscoAnaliseInfoCtrl", function ($scope, $routeParams, $rootScope, $route, $mdDialog, $mdToast, riscosAnaliseAPI) {
    $scope.pageTitle = "My reviews";
    $scope.nomeUsuario = $rootScope.globals.currentUser.nome;

    var buscarAnaliseDetalhadaRiscoPorUsuario = function() {
        riscosAnaliseAPI.buscarAnaliseDetalhadaRiscoPorUsuario($rootScope.globals.currentUser.id).success(function (data) {
            if (data) $scope.risco_analise_detalhada = data;
        }).error(function (data, status) {
            $scope.error = "Could not load detailed risk analysis.";
        });
    };

    $scope.delItem = function (item) {
        var confirm = $mdDialog.confirm()
            .textContent('Are you sure to delete this this review?')
            .ok('Sim')
            .clickOutsideToClose(true)
            .cancel('Cancelar');

        $mdDialog.show(confirm).then(function() {
            riscosAnaliseAPI.apagar(item.id).success(function (data) {
                $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
                buscarAnaliseDetalhadaRiscoPorUsuario();
            }).error(function (data, status) {
                $scope.error = "Unable to delete this the review.";
            });
        });
    };

    buscarAnaliseDetalhadaRiscoPorUsuario();
});
