'use strict';

function hospitalService($resource, $location, $window) {
    var _resource = $resource(
            "/Account/Login/:id",
            {id: "@id"},
            {
                getServices: {
                    method: "POST",
                    url: "/Hospital/GetServices",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"}
                },
                deleteService: {
                    method: "POST",
                    url: "/Hospital/DeleteService",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"}
                },
                addService: {
                    method: "POST",
                    url: "/Hospital/AddService",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"}
                },
                updateService: {
                    method: "POST",
                    url: "/Hospital/UpdateService",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"}
                },
                getPatients: {
                    method: "POST",
                    url: "/Hospital/GetServices",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"}
                },
                postScheduleToDoctor: {
                    method: "POST",
                    url: "/Hospital/PostScheduleToDoctor",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"}
                },
            }
    );
    var factory = {};
    //properties
    //hold single user, or currently selected user
    factory.services = [];
    factory.service = {
        id: "",
        title: "",
        about: ""
    }


    //Operations
    factory.addService = function (scope) {
        try {
            return _resource.addService($.param(scope.service)).$promise.then(
                    function (res) {
                        if (res.Succeeded) {
                            scope.msg = res.msg;
                        } else {

                        }
                        return res.Succeeded;
                    },
                    function () {
                        scope.msg = "No connection to server";
                        return false;
                    }
            );
        } catch (e) {
            scope.msg = "Unknown error occured";
            return false;
        }
    };

    factory.updateService = function (scope) {
        try {
            return _resource.updateService($.param(scope.service)).$promise.then(
                    function (res) {
                        scope.msg = res.msg;
                        if (res.Succeeded) {
                            //console.log(res);
                            scope.service = res.data;

                        } else {

                        }
                        return res.Succeeded;
                    },
                    function () {
                        scope.msg = "No connection to server";
                        return false;
                    }
            );
        } catch (e) {
            scope.msg = "Unknown error occured";
            return false;
        }
    };



    factory.deleteService = function (scope) {
        return _resource.deleteService($.param(scope.service)).$promise.then(
                function (res) {
                    console.log(res);
                    if (res.Succeeded === true) {
                        //Remove all items stored in session
                        sessionStorage.clear();

                        //Clear user object from scope
                        scope.user = {};
                    } else {
                        res.msg;
                    }
                    return res.Succeeded;
                },
                function () {
                    scope.msg = "No connection to server";
                    return false;
                }
        );
    };

    factory.getServices = function (scope) {
        return _resource.getServices().$promise.then(
                function (res) {
                    if (res.Succeeded === true) {
                        scope.services = res.data;
                    } else {
                        res.msg;
                    }
                    return res.Succeeded;
                },
                function () {
                    scope.msg = "No connection to server";
                    return false;
                }
        );
    };

    factory.postScheduleToDoctor = function () {
        return _resource.postScheduleToDoctor($.param(scope.schedule)).$promise.then(
                function (res) {
                    if (res.Succeeded === true) {
                    } else {
                        res.msg;
                    }
                    return res.Succeeded;
                },
                function () {
                    scope.msg = "No connection to server";
                    return false;
                }
        );
    }


    return factory;
}




//
app.factory("hospitalService", [
    "$resource",
    "$location",
    "$window",
    hospitalService
]);
