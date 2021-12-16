//import {account} from "../entities";

"use strict";

app.controller("accountController",
        ["$scope", "$rootScope", "$window", "$location", '$timeout', 'AccountService', 'accountFactory',
            function ($scope, $rootScope, $window, $location, $timeout, accountService, account_factory) {
                // Global scope
                var scope = $rootScope;

                function init() {
                    scope.user = accountService.user;
                }
                scope.login = function () {
                    accountService.login(scope).then(function (status) {
                        if (status === true) {
                           account_factory.set_home_url(scope);
                            $window.location.href = scope.home_url;
                        } else {
                            scope.error();
                        }
                    });
                }

                scope.register = function () {
                    console.log(scope.user);
                    accountService.create(scope).then(function (status) {

                        if (status === true) {
                            $window.location.href = scope.login_url;
                        } else {
                            //scope.error();
                        }
                    });
                }

                scope.is_login = function () {
                    if (account_factory.is_login(scope)) {
                        return true;
                    }
                    return false;
                }
                
                //Pass in the allowed groups
                scope.has_permission = function (groups) {
                   // alert("Hello");
                    if (account_factory.has_permission(scope,groups)) {
                        return true;
                    }
                    return false;
                }

                init();

            }]);