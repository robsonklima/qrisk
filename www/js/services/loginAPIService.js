angular.module("qrisk").factory("loginAPI", function ($http, $rootScope, $cookieStore, $location, $timeout, Base64, config) {
        var service = {};

        service.Login = function (username, password, callback) {
            var response = $http.post(config.baseUrl + 'login.ctrl.php',
                {login: username, senha: password}).success(function(data, status) {
                    if (data) {
                        callback(response, data);
                    } else {
                        response.success = false;
                        response.message = 'Password or username incorrect! ';
                        callback(response);
                    }
                });
        };

        service.SetCredentials = function (id, nome, username, password, id_usuario_perfil, id_status) {
            var authdata = Base64.encode(username + ':' + password);

            $rootScope.globals = {
                currentUser: {
                    id: id, nome: nome, username: username, id_usuario_perfil: id_usuario_perfil,
                    id_status: id_status, authdata: authdata
                }
            };

            $http.defaults.headers.common['Authorization'] = 'Basic ' + authdata; // jshint ignore:line
            $cookieStore.put('globals', $rootScope.globals);
        };

        service.ClearCredentials = function () {
            $rootScope.globals = {};
            $cookieStore.remove('globals');
            $http.defaults.headers.common.Authorization = 'Basic ';
        };

        return service;
    });
