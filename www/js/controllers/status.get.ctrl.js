angular.module("qrisk").controller("statusGetCtrl", function ($scope, $mdDialog, $mdToast, $timeout, $rootScope, $http, statusAPI) {
	$scope.pageTitle = "Status";
    $scope.list = [];

    var getStatus = function() {
        statusAPI.buscarTodos().success(function (data) {
            $scope.list = data;
            $scope.currentPage = 1;
            $scope.entryLimit = 5;
            $scope.filteredItems = $scope.list.length;
            $scope.totalItems = $scope.list.length;

            }).error(function (data, status) {

                $scope.error = "Unable to fetch the status.";
            });
    };

    $scope.delItem = function (item) {
        var confirm = $mdDialog.confirm()
            .textContent('Are you sure to delete this this status?')
            .ok('Sim')
            .clickOutsideToClose(true)
            .cancel('Cancelar');

        $mdDialog.show(confirm).then(function() {
            statusAPI.apagar(item.id).success(function (data) {
                $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
                getStatus();
            }).error(function (data, status) {
                $scope.error = "Unable to delete this status.";
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

    getStatus();
});
