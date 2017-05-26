angular.module("qrisk").controller("loginCtrl", function ($scope, $rootScope, $location, loginAPI) {
        loginAPI.ClearCredentials();
        
        $rootScope.showInclude = false;
        
        $scope.login = function () {
            loginAPI.Login($scope.username, $scope.password, function (response, data) {
                if (response.success) {
                    loginAPI.SetCredentials(data.id, data.nome, $scope.username, $scope.password, 
                                            data.id_usuario_perfil, data.id_status);
                    $location.path('/dashboard');   
                } else {
                    $scope.error = response.message;
                }
            });
        };
    });