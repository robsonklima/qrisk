angular.module("qrisk").controller("menuGetCtrl", function ($scope, $mdDialog, $mdToast, $timeout, $rootScope, $http, menusAPI) {
	$scope.pageTitle = "Application menus";
    $scope.list = [];

    var getMenus = function() {
        menusAPI.buscarTodos().success(function (data) {
            $scope.list = data;
            $scope.currentPage = 1;
            $scope.entryLimit = 5;
            $scope.filteredItems = $scope.list.length;
            $scope.totalItems = $scope.list.length;

            }).error(function (data, status) {

                $scope.error = "Unable to fetch the menus.";
            });
    };

    $scope.delItem = function (item) {
        var confirm = $mdDialog.confirm()
            .textContent('Are you sure to delete the menu?')
            .ok('Sim')
            .clickOutsideToClose(true)
            .cancel('Cancel');

        $mdDialog.show(confirm).then(function() {
            menusAPI.apagar(item.id).success(function (data) {
                $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
                getMenus();
            }).error(function (data, status) {
                $scope.error = "Unable to delete the menu.";
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

    getMenus();
});
