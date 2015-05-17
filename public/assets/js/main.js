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
  function($scope, $rootScope, $http, $stateParams, $state) {

}])

.controller('BadgesController', [
  '$scope',
  '$rootScope',
  '$http',
  '$stateParams',
  function($scope, $rootScope, $http, $stateParams, $state) {

}])

.controller('CategoryController', [
  '$scope',
  '$rootScope',
  '$http',
  '$stateParams',
function($scope, $rootScope, $http, $stateParams, $state) {

  $('.badge-custom-achieves').children('li').click(function(e) {
    $(this).children('.achieve-description').slideToggle();
  });

}]);

