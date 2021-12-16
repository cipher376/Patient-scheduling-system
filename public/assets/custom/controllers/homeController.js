//import {account} from "../entities";

"use strict";

app.controller("homeController", [
    "$scope",
    "$rootScope",
    "$window",
    "$location",
    "$timeout",
    function ($scope, $rootScope, $window, $location, $timeout) {
        // Global scope
        var scope = $rootScope;

        function init() {
            // set page title ;
            scope.page_title = "Dashboard";
        }   
    

        init();
    }
]);
