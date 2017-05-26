angular.module("qrisk").controller("projetoAddCtrl", function ($scope, $mdToast, $rootScope, $location, earCatsAPI, projetosAPI, statusAPI, riscosAPI) {
    $scope.pageTitle = "Projects";

    $scope.projeto = {};
    $scope.projeto.id_usuario = $rootScope.globals.currentUser.id;

    $scope.addItem = function(item) {
        projetosAPI.adicionar(item).success(function (data) {
            $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
            $location.path("/projeto.get");
        }).error(function (data, status) {
            $scope.error = "Unable to add the project!";
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
