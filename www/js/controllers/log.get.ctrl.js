angular.module("qrisk").controller("logGetCtrl", function ($scope, $http, $mdDialog, $mdToast, $rootScope, logsAPI) {
	$scope.pageTitle = "Aplpication logs";
    $scope.list = [];

    var getLogs = function() {
        logsAPI.buscarTodos().success(function (data) {
            $scope.list = data;
            $scope.currentPage = 1;
            $scope.entryLimit = 5;
            $scope.filteredItems = $scope.list.length;
            $scope.totalItems = $scope.list.length;

            }).error(function (data, status) {

                $scope.error = "Unable to fetch the items.";
            });
    };

    $scope.setPage = function(pageNo) {
        $scope.currentPage = pageNo;
    };
    $scope.filter = function() {
        $timeout(function() {
            $scope.filteredItems = $scope.filtered.length;
        }, 1000);
    };
    $scope.sort_by = function(predicate) {
        $scope.predicate = predicate;
        $scope.reverse = !$scope.reverse;
    };

    $scope.delItems = function() {
        var confirm = $mdDialog.confirm()
            .textContent('Are you sure to delete the logs?')
            .ok('Sim')
            .clickOutsideToClose(true)
            .cancel('Cancel');

        $mdDialog.show(confirm).then(function() {
            logsAPI.apagar($rootScope.globals.currentUser.id).success(function (data) {
                $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
                getLogs();
            }).error(function (data, status) {
                $scope.error = "Unable to delete the items.";
            });
        });
    };

    getLogs();
});
