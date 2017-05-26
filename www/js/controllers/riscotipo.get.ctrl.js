angular.module("qrisk").controller("riscoTipoGetCtrl", function ($scope, $mdDialog, $mdToast, $timeout, $rootScope, $http, riscosTipoAPI) {
	$scope.pageTitle = "Risk types";
    $scope.list = [];

    var getRiscosTipo = function() {
        riscosTipoAPI.buscarTodos().success(function (data) {
            $scope.list = data;
            $scope.currentPage = 1;
            $scope.entryLimit = 5;
            $scope.filteredItems = $scope.list.length;
            $scope.totalItems = $scope.list.length;

            if ($scope.filteredItems == 0) {
                $scope.error = "Your search returned no results.";
            }

            }).error(function (data, status) {
                $scope.error = "Unable to fetch the risk types.";
            });
    };

    $scope.delItem = function (item) {
        var confirm = $mdDialog.confirm()
            .textContent('Are you sure to delete this risk type?')
            .ok('Sim')
            .clickOutsideToClose(true)
            .cancel('Cancel');

        $mdDialog.show(confirm).then(function() {
            riscosTipoAPI.apagar(item.id).success(function (data) {
                $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
                getRiscosTipo();
            }).error(function (data, status) {
                $scope.error = "Unable to delete this risk type.";
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

    getRiscosTipo();
});
