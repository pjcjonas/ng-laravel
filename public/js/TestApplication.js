var app = angular.module('testApp', []);

// User registration controller
app.controller('UserRegistration', function($scope) {

    $scope.emailFormat = /^[a-z]+[a-z0-9._]+@[a-z]+\.[a-z.]{2,5}$/;

    $scope.logger = function(){
    };

});
