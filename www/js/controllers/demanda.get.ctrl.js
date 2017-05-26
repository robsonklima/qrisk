angular.module("qrisk").controller("demandaGetCtrl", function ($scope, $mdDialog, $mdToast, $timeout, $rootScope, $http, demandasAPI) {
	$scope.pageTitle = "Activities of projects";
    $scope.list = [];

    var getDemandas = function() {
        demandasAPI.buscarTodos().success(function (data) {
            $scope.list = data;
            $scope.currentPage = 1;
            $scope.entryLimit = 5;
            $scope.filteredItems = $scope.list.length;
            $scope.totalItems = $scope.list.length;

            }).error(function (data, status) {
                $scope.error = "Unable to fetch the activities.";
            });
    };

    $scope.delItem = function (item) {
        var confirm = $mdDialog.confirm().textContent('Are you sure to delte this activity?')
            .ok('Sim').clickOutsideToClose(true).cancel('Cancel');

        $mdDialog.show(confirm).then(function() {
            demandasAPI.apagar(item.id).success(function (data) {
                $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
                getDemandas();
            }).error(function (data, status) {
                $scope.error = "Unable to fetch the activity.";
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

    getDemandas();
});
