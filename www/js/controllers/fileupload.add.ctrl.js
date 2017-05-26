angular.module("qrisk").controller("fileUploadAddCtrl", function ($scope, $mdToast, fileUploadAPI, $rootScope, config, $route, $location) {
    $scope.pageTitle = "XML Import";

    $scope.uploadFile = function(){
        var file = $scope.file;
        var descricao = $scope.descricao;
        fileUploadAPI.adicionar(file, descricao, $rootScope.globals.currentUser.id).success(function (data) {
            $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
            $location.path("/fileupload.get");
        }).error(function (data, status) {
              $scope.error = "Unable to add the file!";
        });
    };

});
