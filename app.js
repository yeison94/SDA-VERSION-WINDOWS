var app = angular.module('app', ['ngRoute']);
    app.config(['$routeProvider',function($routeProvider) {
    	$routeProvider
    	.when('/home',{
    		templateUrl: 'FrontEnd/View/Principal.html',
    		controller: 'Ctrl'
    	})
    	.when('/loginAdministrador',{
    		templateUrl: 'FrontEnd/View/LoginAdmnistrador.html',
			controller: 'ControllerAdmin'
    	})
      .when('/interfaceAdministrador',{
        templateUrl: 'FrontEnd/View/InterfaceAdministrador.html',
        controller: 'ControllerInterfaceAdmin'
      })
      .when('/loginProfesor',{
        templateUrl: 'FrontEnd/View/loginProfesor.html',
        controller: 'ControllerProfe'
      })
      .when('/interfaceProfesor',{
        templateUrl : 'FrontEnd/View/interfaceProfesor.php',
        controller:'controllerInterfaceProf'
      })
      .when('/interfaceEstudiante',{
        templateUrl : 'FrontEnd/View/InterfaceEstudiante.php',
        controller:'controllerInterfaceEst'
      })
    	.otherwise({
    		redirectTo: '/home'
    	});
    }]);


    app.directive('fileModel', ['$parse', function ($parse) {
    return {
    restrict: 'A',
    link: function(scope, element, attrs) {
        var model = $parse(attrs.fileModel);
        var modelSetter = model.assign;

        element.bind('change', function(){
            scope.$apply(function(){
                modelSetter(scope, element[0].files[0]);
            });
        });
    }
   };
}]);
    app.service('fileUpload', ['$http', function ($http) {
        this.uploadFileToUrl = function(file, uploadUrl, name, curs,opera){
             var fd = new FormData();
             fd.append('file', file);
             fd.append('name', name);
             fd.append('curse', curs);
             fd.append('operacion', opera);
             $http.post(uploadUrl, fd, {
                 transformRequest: angular.identity,
                 headers: {'Content-Type': undefined,'Process-Data': false}
             })
             .then(function(res){
                console.log("res.data.Mover_Archivo", res.data);
                if (res.data.Mover_Archivo == true && res.data.BD_modificada == true) {
                  window.alert("ARCHIVO SUBIDO CON EXITO");
                }else{
                    window.alert("PROBLEMAS AL SUBIR EL ARCHIVO" + res.data[1]);
                }
             });
         }
     }]);


  //Servicio utilizado para compartir datos entre algunos controladores
  app.factory("ServicioDatos" ,function(){
    var ret = function(){}
    ret.datosCompatidos = "Valor";
    ret.logAdmin = false;
    ret.logProf = false;
    ret.logProf_curso = "curso";
    ret.estud = "false";
    return ret;
  });

	app.controller('ControllerAdmin', function($scope, $http, $location, ServicioDatos){

    //Usado para los avisos de datos ingresados correcto o incorrectos
    $scope.comprobar = "";
    $scope.comprobar2 = true;

		$scope.verificarAdmi = function(){

      $http.post('BackEnd/LoginAdmin/validarAdmin.php', {username: $scope.Adm.user , pass: $scope.Adm.password })
            .then(function(res){
              console.log('Success', res.data);
                $scope.comprobar = res.data.Respuesta;
                $scope.comprobar2 = false;

                if ($scope.comprobar == true) {


                  ServicioDatos.logAdmin = true;


                  $location.path('/interfaceAdministrador');

                }else{
                    ServicioDatos.logAdmin = false;
                }

            });
		};
	});

  app.controller('ControllerProfe', function($scope, $http, $location, ServicioDatos){

    //Usado para los avisos de datos ingresados correcto o incorrectos
    $scope.comprobar = "";
    $scope.comprobar2 = true;
    $scope.vara = "";
    $scope.servicio = ServicioDatos;

		$scope.verificarProf = function(){

      ServicioDatos.datosCompatidos = $scope.Profe.nomb;

      $http.post('BackEnd/LoginProf/validarProf.php', {name : $scope.Profe.nomb , password : $scope.Profe.pass })
            .then(function(res){
              console.log('Success', res.data);
                $scope.comprobar = res.data.Respuesta;
                $scope.comprobar2 = false;

                if ($scope.comprobar == true) {

                  ServicioDatos.logProf = true;

                $location.path('/interfaceProfesor');

                }else{
                    ServicioDatos.logProf = false;
                }

            });
		};

  });

  app.controller('ControllerInterfaceAdmin', function($scope, $http, $location, $route, ServicioDatos){

    //esto ocurrira si se quiere acceder a la interfaz de admin sin logearse
    if (ServicioDatos.logAdmin == false){

      $location.path('/home');

    }

      $scope.nombreProfesor = "";
      $scope.asignatura = "";
      $scope.contras = "";
      $scope.oferta = [];

      //Peticion para obtener datos y llenar la tabla con la oferta academica

      $http.get('BackEnd/LoginAdmin/loginAdmin.php')
          .then(function(res){

            console.log('Success', res.data);
            $scope.oferta = res.data;

          });

      $scope.agregarProfesor = function(){

        $http.post('BackEnd/LoginAdmin/loginAdmin.php', {operacion : "agregar",nam : $scope.nombreProfesor , Asignatura : $scope.asignatura, Contrasena : $scope.contras })
              .then(function(res){
                console.log('Success', res.data);
                  $scope.comprobar = res.data.Respuesta;
                  $scope.comprobar2 = false;

                  if ($scope.comprobar == true) {

                      ServicioDatos.logAdmin = true;

                      $location.path('/interfaceAdministrador');
                       $route.reload();

                  }else{
                      ServicioDatos.logAdmin = false;
                  }

              });


      }

      $scope.eliminarProfesor = function(){

        $http.post('BackEnd/LoginAdmin/loginAdmin.php', {operacion : "borrar",nam : $scope.nombreProfesor , Asignatura : $scope.asignatura })
              .then(function(res){
                console.log('Resultado de eliminar', res.data);
                  $scope.comprobar = res.data.Respuesta;
                  $scope.comprobar2 = false;

                  if ($scope.comprobar == true) {

                      ServicioDatos.logAdmin = true;

                      $location.path('/interfaceAdministrador');
                       $route.reload();

                  }else{
                      ServicioDatos.logAdmin = false;
                  }

              });

      }

      $scope.cerrarSesion = function(){

          $location.path('/loginAdministrador');

      }



  });

  app.controller('controllerInterfaceProf', function($scope,ServicioDatos, $location, $route, $http, fileUpload){

    //esto ocurrira si se quiere acceder a la interfaz de admin sin logearse
    if (ServicioDatos.logProf == false){

      $location.path('/home');

    }

    $scope.data2 = {
      model: null
    };

    $scope.archi_sub = [];
    $scope.archi_sub_alumnos = [];
    $scope.profesor_logeado = ServicioDatos.datosCompatidos;

    $scope.servicio = ServicioDatos;
    // console.log('Servicio compartido',ServicioDatos.datosCompatidos);

    //POST para obtener todos los archivos montados por el profesor
    var fd2 = new FormData();
    fd2.append('operacion', "obtener_archivos");
    fd2.append('curse', ServicioDatos.datosCompatidos);
    $http.post("BackEnd/LoginProf/loginProf.php", fd2, {
        transformRequest: angular.identity,
        headers: {'Content-Type': undefined,'Process-Data': false}
    })
    .then(function(res){

       $scope.archi_sub = res.data;
       //console.log("Success", res.data);
    });

    //POST para obtener todos los archivos montados por los alumnos
    var fd3 = new FormData();
    fd3.append('operacion', "obtener_archivos_alumnos");
    fd3.append('curse', ServicioDatos.datosCompatidos);
    $http.post("BackEnd/LoginProf/loginProf.php", fd3, {
        transformRequest: angular.identity,
        headers: {'Content-Type': undefined,'Process-Data': false}
    })
    .then(function(res){
        $scope.archi_sub_alumnos = res.data;
        console.log(res.data);
    });

    //window.alert(ServicioDatos.datosCompatidos);

    $scope.uploadFile = function(){
       var file = $scope.myFile;
      //  console.log('file is ' );
      //  console.dir(file);
       var uploadUrl = "BackEnd/LoginProf/loginProf.php";
       var text = $scope.name;
       var curso = ServicioDatos.datosCompatidos;
       var opera = "subirArchivo";
       fileUpload.uploadFileToUrl(file, uploadUrl, text,curso,opera );

       $location.path('/interfaceProfesor');
       $route.reload();
  };

  $scope.cerrarSesion = function(){

      $location.path('/loginProfesor');

  }

  });

 app.controller('controllerInterfaceEst', function($scope,ServicioDatos, $location, $route, $http, fileUpload){

  $scope.oferta = [];
  $scope.archi_sub = [];
  $scope.enlace_descargar = "";
  //Peticion para todos los cursos ofrecidos
  $http.get('BackEnd/LoginEst/loginEst.php')
      .then(function(res){
        console.log('Success', res.data);
        $scope.oferta = res.data;
        console.log($scope.oferta);
      });

  $scope.data = {
    model: null
  };

  $scope.data2 = {
    model: null
  };

  $scope.archivos_montados = function(){

    if($scope.data.model != null){
      //console.log("CURSO  ELEGIDO");
      $http.post('BackEnd/LoginEst/loginEst.php', {operacion : "mostrar", asignatura : $scope.data.model })
            .then(function(res){
              console.log('material subido por docente',res.data);
              $scope.archi_sub = res.data;
            });
    }
  }

  $scope.descargar_archivo = function(){

    if($scope.data2.model != null){
      //console.log("CURSO  ELEGIDO");
      $http.post('BackEnd/LoginEst/loginEst.php', {operacion : "descargar", archivo: $scope.data2.model,asignatura : $scope.data.model })
            .then(function(res){
              // console.log('Suces');
              // var blob = new Blob([res.data], {type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"});
              // var objectUrl = URL.createObjectURL(blob);
              // window.open(objectUrl);
        });
    }
  }

  $scope.uploadFile = function(){
     var file = $scope.myFile;
    //  console.log('file is ' );
    //  console.dir(file);
     var uploadUrl = "BackEnd/LoginEst/loginEst.php";
     var text = $scope.name;
     var curso = $scope.data.model;
     var opera = "subirArchivo";
     fileUpload.uploadFileToUrl(file, uploadUrl, text,curso,opera );

    //  $location.path('/interfaceProfesor');
    //  $route.reload();
};
 });
