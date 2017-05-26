angular.module("qrisk").controller("demandaAddCtrl", function ($scope, $mdToast, $rootScope, $location, demandasAPI, projetosAPI, recursosAPI, riscosAPI, statusAPI) {
    $scope.pageTitle = "Activities of projects";

    $scope.demanda = {};
    $scope.demanda.id_usuario = $rootScope.globals.currentUser.id;

    $scope.addItem = function(item) {
        demandasAPI.adicionar(item).success(function (data) {
            $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));

            console.log(data);

            $location.path("/demanda.get");
        }).error(function (data, status) {
            $scope.error = "Unable to add activity!";
        });
    };

    var carregarProjetos = function() {
        projetosAPI.buscarTodos().success(function (data) {
            if (data)
                $scope.projetos = data;
            else
                $scope.error = "Unable to fetch the projects.";
        }).error(function (data, status) {
            $scope.error = "Unable to fetch the projects.";
        });
    };

    var carregarRecursos = function() {
        recursosAPI.buscarTodos().success(function (data) {
            if (data)
                $scope.recursos = data;
            else
                $scope.error = "Unable to fetch the resources.";
        }).error(function (data, status) {
            $scope.error = "Unable to fetch the resources.";
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

	carregarProjetos();
    carregarRecursos();
    carregarRiscos();
    carregarStatus();
});
