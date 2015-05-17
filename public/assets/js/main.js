var app = angular.module('app', [
  'ui.router',
  'ngSanitize'
])

.config([
  '$stateProvider',
  '$urlRouterProvider',
  '$locationProvider',
  function($stateProvider, $urlRouterProvider, $locationProvider) {

  /* ROUTES */
  $locationProvider.html5Mode(true);
  $urlRouterProvider.otherwise('/');
  $stateProvider
    .state('home', {
      url: '/',
      templateUrl: 'assets/views/home.html',
      controller: 'HomeController'
    })
    .state('badges', {
      url: '/badges/',
      templateUrl: 'assets/views/badges.html',
      controller: 'BadgesController'
    })
    .state('category', {
      url: '/category/',
      templateUrl: 'assets/views/category.html',
      controller: 'CategoryController'
    });

}])

.controller('HomeController', [
  '$scope',
  '$rootScope',
  '$http',
  '$stateParams',
  function($scope, $rootScope, $http, $stateParams) {

}])

.controller('BadgesController', [
  '$scope',
  '$rootScope',
  '$http',
  '$stateParams',
  function($scope, $rootScope, $http, $stateParams) {

    $http.get('/api/data')
    .then(function(response) {
      $scope.category = response.data[0];
      $scope.badges = $scope.category.badges;
      console.log($scope.badges);
    });

    $http.get('/api/user/badges')
    .then(function(response) {
      $scope.badgesDone = response.data;
      console.log($scope.badgesDone);
      $scope.checkBadge = function(id) {
        return $scope.badgesDone.length == 0 || !$scope.badgesDone.reduce(
          function(memo, v) {
            return memo || v.id == id
          }, $scope.badgesDone[0].id == id);
      };
    });
}])

.controller('CategoryController', [
  '$scope',
  '$rootScope',
  '$http',
  '$stateParams',
function($scope, $rootScope, $http, $stateParams) {

  $http.get('api/data')
  .then(function(response) {
    $scope.category = response.data[0];
    $scope.badges = $scope.category.badges;
    console.log($scope.badges);
  });

  $http.get('api/user/badges')
  .then(function(response) {
    $scope.badgesDone = response.data;
    console.log($scope.badgesDone);
    $scope.checkBadge = function(id) {
      return $scope.badgesDone.length == 0 || !$scope.badgesDone.reduce(
        function(memo, v) {
          return memo || v.id == id
        }, $scope.badgesDone[0].id == id);
    };
  });

  $http.get('api/user/achievements')
  .then(function(response) {
    $scope.achievs = response.data;
    console.log($scope.achievs);
    $scope.checkAchiev = function(id) {
      return $scope.achievs.length == 0 || !$scope.achievs.reduce(
        function(memo, v) {
          return memo || v.id == id
        }, $scope.achievs[0].id == id);
    };
    $scope.checkDate = function(id) {
      console.log($scope.achievs);
      var c = (($scope.achievs.filter(function(v) { return v.id !== id })));
      console.log(c[0].achieved_at);
      return c[0].achieved_at;
    };
  });

  $scope.collapse = function($event) {
    $($event.currentTarget.children[2]).slideToggle()
  }
}]);
