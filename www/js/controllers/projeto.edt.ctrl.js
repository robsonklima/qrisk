angular.module("qrisk").controller("projetoEdtCtrl", function ($scope, $mdToast, $routeParams, $route, $location, projetosAPI, statusAPI, riscosAPI) {
    $scope.pageTitle = "Projects";

    projetosAPI.buscarPorId($route.current.params.id).success(function(data, status) {
        $scope.projeto = data;
    });

    $scope.edtProjeto = function(item) {
        projetosAPI.atualizar(item).success(function(data) {
            $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
            $location.path("/projeto.get");
        }).error(function (data, status) {
            $scope.error = "Unable to update the project.";
        });
    };

    var carregarRiscos = function() {
        riscosAPI.buscarTodos().success(function (data) {
            if (data)
                $scope.riscos = data;
            else
                $scope.error = "Unable to fetch the risks.";
        }).error(function (data, status) {
            $scope.error = "Unable to fetch the risks.";
        });
    };

    var carregarStatus = function() {
        statusAPI.buscarTodos().success(function (data) {
            if (data)
                $scope.statuss = data;
            else
                $scope.error = "Unable to fetch the status.";
        }).error(function (data, status) {
            $scope.error = "Unable to fetch the status.";
        });
    };

    carregarRiscos();
    carregarStatus();
});
