var app = angular.module('evaluationApp', [
  'ui.router', 'evaluationApp.controllers'
])

.config([
    '$stateProvider', function ($stateProvider) {
      $stateProvider
        .state(
            'index', {
              'url' : '/',
              views : {
                'main' : {
                  templateUrl : 'javascripts/views/index.html',
                  controller : 'indexCtrl'
                },
                'searchbar' : {
                  templateUrl : 'javascripts/views/searchbar.html',
                  controller : 'searchCtrl'
                }
              }
            }
          )

        .state(
            'search', {
              'url' : '/search',
              views : {
                'main' : {
                  templateUrl : 'javascripts/views/result.html',
                  controller : 'resultCtrl'
                }              
              }
            }
          )

        .state(
            'course', {
              'url' : '/course/:id',
              views : {
                'main' : {
                  templateUrl : 'javascripts/views/evaluations.html',
                  controller : 'evaluationsCtrl'
                }
              }
            }
          )

        .state(
            'evaluation', {
              'url' : '/course/:id/evaluate',
              views : {
                'main' : {
                  templateUrl : 'javascripts/views/evaluate.html',
                  controller : 'evaluateCtrl'
                }
              }
            }
          )
    }
  ])

.run(function ($rootScope, $state, $http, CSRF_TOKEN) {
  $rootScope.query = '';
  $rootScope.course = [];
  $rootScope.title = "TJU匿名课程评价"
  $state.go('index');

  $http({
    'url' : '/api/stat',
    'method' : 'POST',
    'params' : {
      csrf_token : CSRF_TOKEN
    }
  })
  .success(function (data, status) {
    
  })
  .error(function (data, status) {

  })
})

var controller = angular.module('evaluationApp.controllers', []);

controller
  .controller('indexCtrl', ['$scope', '$http', '$location', '$rootScope', function ($scope, $http, $location, $rootScope) {
    $scope.isLoading = true
    $scope.courses = []

    $scope.init = function () {
      $rootScope.title = "TJU匿名课程评价"

      $http.get('/api/hot')
        .success (function (data, status) {
          $scope.courses = data
          $scope.isLoading = false
        })
        .error (function (data, status) {
          $scope.isLoading = false
        })
    }

    $scope.viewEvaluations = function (type, index) {
      var tmp = type === 0 ? $scope.courses.score : $scope.courses.hot
      $location.path('/course/' + tmp[index].cid)
    }
  }])

  .controller('searchCtrl', ['$scope', '$state', '$rootScope', function ($scope, $state, $rootScope) {
    $scope.query = ''

    $scope.search = function () {
      $rootScope.query = $scope.query;
      $state.go('search')
    }
  }])

  .controller('resultCtrl', ['$scope', '$rootScope', '$state', '$http', '$location', function ($scope, $rootScope, $state, $http, $location) {
    $scope.isError = false;
    $scope.isLoading = false;
    $scope.list = [];
    $scope.query = $rootScope.query;

    if ($scope.query === '') {
      $state.go('index')
    }

    $scope.search = function () {
      $scope.isLoading = true
      $http.get('/api/search/' + $scope.query)
        .success (function (data, status) {
          $scope.list = data;
          $scope.isLoading = false
          $rootScope.title = "TJU匿名课程评价"
        })
        .error (function (data, status) {
          $scope.isError = true
          $scope.isLoading = false
        }) 
    }

    $scope.viewEvaluations = function (index) {
      $rootScope.course = $scope.list[index]
      $rootScope.query = ''
      $location.path('/course/' + $scope.list[index].id)
    }

    $scope.back = function () {
      $rootScope.query = ''
      $state.go('index')
    }
  }])

  .controller('evaluationsCtrl', ['$scope', '$state', '$rootScope', '$http', '$location', function ($scope, $state, $rootScope, $http, $location) {
    $scope.course = $rootScope.course
    $scope.id = $state.params.id
    $scope.isError = false
    $scope.isLoading = true
    $scope.evaluations = []
    $scope.rate

    $scope.initData = function () {
      $http.get('/api/course/' + $scope.id)
        .success(function (data, status) {
          console.log(data);
          $scope.course.teacher = data.info.teacher
          $scope.course.coursename = data.info.coursename
          $scope.rate = data.info.rate
          $scope.evaluations = data.comments
          $scope.isLoading = false
          $rootScope.title = "TJU匿名课程评价 - " + data.info.coursename + " - " + data.info.teacher
        })
        .error(function (data, status) {
          $scope.isError = true
          $scope.isLoading = false
        })
    }

    $scope.evaluate = function () {
      $location.path('/course/' + $scope.id + '/evaluate')
    }

    $scope.back = function () {
      $rootScope.course = []
      $rootScope.query = ''
      $state.go('index')
    }
  }])

  .controller('evaluateCtrl', ['$scope', '$rootScope', '$state', '$http', 'CSRF_TOKEN', '$location', function ($scope, $rootScope, $state, $http, CSRF_TOKEN, $location) {
    $scope.course = $rootScope.course
    $scope.content = ''
    $scope.rate = 0
    $scope.info = []
    $scope.id = $state.params.id
    $scope.isError = false
    $scope.isLoading = false

    $scope.init = function () {
      $http.get('/api/course/' + $scope.id + '/basic')
        .success(function (data, status) {
          $scope.course.teacher = data.teacher
          $scope.course.coursename = data.coursename
          $rootScope.title = "TJU匿名课程评价 - " + data.coursename + " - " + data.teacher
        })
        .error(function (data, status) {
          $state.go('index')
        })
    }

    $scope.submit = function() {
      if ($scope.rate === 0 || $scope.content === '') {
        $(".ui-dialog").dialog("show")
        return;
      }

      $scope.isLoading = true

      $http({
        url : '/api/course/' + $scope.id + '/evaluation',
        method : 'POST',
        params : {
          courseid : $scope.course.id,
          content : $scope.content,
          rate : $scope.rate,
          csrf_token : CSRF_TOKEN
        }
      })
      .success (function (data, status) {
        console.log(data);
        $scope.isError = false
        $scope.isLoading = false
        $location.path('/course/' + $scope.id)
      })
      .error (function (data, status) {
        $scope.isError = true
        $scope.isLoading = false
      })
    }

    $scope.back = function() {
      $location.path('/course/' + $scope.id)
    }
  }])