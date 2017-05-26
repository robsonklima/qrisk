angular.module("qrisk").controller("projetoGetCtrl", function ($scope, $mdDialog, $mdToast, $timeout, $rootScope, $http, projetosAPI) {
	$scope.pageTitle = "Projects";
    $scope.list = [];

    var getProjetos = function() {
        projetosAPI.buscarTodos().success(function (data) {
            $scope.list = data;
            $scope.currentPage = 1;
            $scope.entryLimit = 5;
            $scope.filteredItems = $scope.list.length;
            $scope.totalItems = $scope.list.length;

            }).error(function (data, status) {
                $scope.error = "Unable to fetch the projects.";

            });
    };

    $scope.delItem = function (item) {
        var confirm = $mdDialog.confirm().textContent('Are you sure to delete this project?')
            .ok('Sim').clickOutsideToClose(true).cancel('Cancel');

        $mdDialog.show(confirm).then(function() {
            projetosAPI.apagar(item.id).success(function (data) {
                $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
                getProjetos();
            }).error(function (data, status) {
                $scope.error = "Unable to delete this project.";
            });
        });
    };

    $scope.setPage = function(pageNo) {
        $scope.currentPage = pageNo;
    };
    $scope.filter = function() {
        $timeout(function() {
            $scope.filteredItems = $scope.filtered.length;
        }, 10);
    };
    $scope.sort_by = function(predicate) {
        $scope.predicate = predicate;
        $scope.reverse = !$scope.reverse;
    };

    getProjetos();
});
