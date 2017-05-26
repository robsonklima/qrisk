angular.module("qrisk").config(function ($routeProvider, $httpProvider) {
    
    // evita cache do navegador
    delete $httpProvider.defaults.headers.common['X-Requested-With'];
	
    // login
    $routeProvider.when("/login", {
       templateUrl: "view/login.html",
       controller: "loginCtrl"
    });
    
    // dashboard
    $routeProvider.when("/dashboard", {
       templateUrl: "view/dashboard.html",
       controller: "dashboardCtrl"
    });
    
    // get
    $routeProvider.when("/earcat.get", {
       templateUrl: "view/earcat.get.html",
       controller: "earCatGetCtrl"
    });
    $routeProvider.when("/projeto.get", {
       templateUrl: "view/projeto.get.html",
       controller: "projetoGetCtrl"
    });
    $routeProvider.when("/recurso.get", {
       templateUrl: "view/recurso.get.html",
       controller: "recursoGetCtrl"
    });
    $routeProvider.when("/usuario.get", {
       templateUrl: "view/usuario.get.html",
       controller: "usuarioGetCtrl"
    });
    $routeProvider.when("/usuarioperfil.get", {
       templateUrl: "view/usuarioperfil.get.html",
       controller: "usuarioPerfilGetCtrl"
    });
    $routeProvider.when("/status.get", {
       templateUrl: "view/status.get.html",
       controller: "statusGetCtrl"
    });
    $routeProvider.when("/demanda.get", {
       templateUrl: "view/demanda.get.html",
       controller: "demandaGetCtrl"
    });
    $routeProvider.when("/recursofuncao.get", {
       templateUrl: "view/recursofuncao.get.html",
       controller: "recursofuncaoGetCtrl"
    });
    $routeProvider.when("/fileupload.get", {
       templateUrl: "view/fileupload.get.html",
       controller: "fileUploadGetCtrl"
    });
    $routeProvider.when("/riscotipo.get", {
       templateUrl: "view/riscotipo.get.html",
       controller: "riscoTipoGetCtrl"
    });
    $routeProvider.when("/risco.get", {
       templateUrl: "view/risco.get.html",
       controller: "riscoGetCtrl"
    });
    $routeProvider.when("/riscoanalise.get", {
       templateUrl: "view/riscoanalise.get.html",
       controller: "riscoAnaliseGetCtrl"
    });
    $routeProvider.when("/menu.get", {
       templateUrl: "view/menu.get.html",
       controller: "menuGetCtrl"
    });
    
    // edt
    $routeProvider.when("/earcat.edt/:id", {
       templateUrl: "view/earcat.edt.html",
       controller: "earCatEdtCtrl"
    });
    $routeProvider.when("/projeto.edt/:id", {
       templateUrl: "view/projeto.edt.html",
       controller: "projetoEdtCtrl"
    });
    $routeProvider.when("/recurso.edt/:id", {
       templateUrl: "view/recurso.edt.html",
       controller: "recursoEdtCtrl"
    });
    $routeProvider.when("/usuario.edt/:id", {
       templateUrl: "view/usuario.edt.html",
       controller: "usuarioEdtCtrl"
    });
    $routeProvider.when("/usuarioperfil.edt/:id", {
       templateUrl: "view/usuarioperfil.edt.html",
       controller: "usuarioPerfilEdtCtrl"
    });
    $routeProvider.when("/status.edt/:id", {
       templateUrl: "view/status.edt.html",
       controller: "statusEdtCtrl"
    });
    $routeProvider.when("/demanda.edt/:id", {
       templateUrl: "view/demanda.edt.html",
       controller: "demandaEdtCtrl"
    });
    $routeProvider.when("/recursofuncao.edt/:id", {
       templateUrl: "view/recursofuncao.edt.html",
       controller: "recursofuncaoEdtCtrl"
    });
    $routeProvider.when("/riscotipo.edt/:id", {
       templateUrl: "view/riscotipo.edt.html",
       controller: "riscoTipoEdtCtrl"
    });
    $routeProvider.when("/risco.edt/:id", {
       templateUrl: "view/risco.edt.html",
       controller: "riscoEdtCtrl"
    });
    $routeProvider.when("/menu.edt/:id", {
       templateUrl: "view/menu.edt.html",
       controller: "menuEdtCtrl"
    });
    
    // add
    $routeProvider.when("/earcat.add", {
       templateUrl: "view/earcat.add.html",
       controller: "earCatAddCtrl"
    });
    $routeProvider.when("/projeto.add", {
       templateUrl: "view/projeto.add.html",
       controller: "projetoAddCtrl"
    });
    $routeProvider.when("/recurso.add", {
       templateUrl: "view/recurso.add.html",
       controller: "recursoAddCtrl"
    });
    $routeProvider.when("/usuario.add", {
       templateUrl: "view/usuario.add.html",
       controller: "usuarioAddCtrl"
    });
    $routeProvider.when("/usuarioperfil.add", {
       templateUrl: "view/usuarioperfil.add.html",
       controller: "usuarioPerfilAddCtrl"
    });
    $routeProvider.when("/status.add", {
       templateUrl: "view/status.add.html",
       controller: "statusAddCtrl"
    });
    $routeProvider.when("/demanda.add", {
       templateUrl: "view/demanda.add.html",
       controller: "demandaAddCtrl"
    });
    $routeProvider.when("/recursofuncao.add", {
       templateUrl: "view/recursofuncao.add.html",
       controller: "recursofuncaoAddCtrl"
    });
    $routeProvider.when("/fileupload.add", {
       templateUrl: "view/fileupload.add.html",
       controller: "fileUploadAddCtrl"
    });
    $routeProvider.when("/riscotipo.add", {
       templateUrl: "view/riscotipo.add.html",
       controller: "riscoTipoAddCtrl"
    });
    $routeProvider.when("/risco.add", {
       templateUrl: "view/risco.add.html",
       controller: "riscoAddCtrl"
    });
    $routeProvider.when("/riscoanalise.add/:id_risco/:id_projeto", {
       templateUrl: "view/riscoanalise.add.html",
       controller: "riscoAnaliseAddCtrl"
    });
    $routeProvider.when("/menu.add", {
       templateUrl: "view/menu.add.html",
       controller: "menuAddCtrl"
    });
    $routeProvider.when("/problema.add", {
       templateUrl: "view/problema.add.html",
       controller: "problemaAddCtrl"
    });
    
    // info
    $routeProvider.when("/risco.info/:id", {
       templateUrl: "view/risco.info.html",
       controller: "riscoInfoCtrl"
    });
    $routeProvider.when("/projeto.info/:id", {
       templateUrl: "view/projeto.info.html",
       controller: "projetoInfoCtrl"
    });
    $routeProvider.when("/riscoanalise.info", {
       templateUrl: "view/riscoanalise.info.html",
       controller: "riscoAnaliseInfoCtrl"
    });
    
    // logs
    $routeProvider.when("/log.get", {
       templateUrl: "view/log.get.html",
       controller: "logGetCtrl"
    });
    
    $routeProvider.when("/error", {
       templateUrl: "view/error.html"
    });
    $routeProvider.otherwise({redirectTo: "/error"});
});