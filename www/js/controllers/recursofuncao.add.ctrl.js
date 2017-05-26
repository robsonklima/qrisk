angular.module("qrisk").controller("recursofuncaoAddCtrl", function ($scope, $mdToast, $location, recursosFuncaoAPI, statusAPI) {
    $scope.pageTitle = "Resources functions";

    $scope.addItem = function(item) {
        recursosFuncaoAPI.adicionar(item).success(function (data) {
            $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
            $location.path("/recursofuncao.get");
        }).error(function (data, status) {
            $scope.error = "Unable to add the function!";
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

    carregarStatus();
});
