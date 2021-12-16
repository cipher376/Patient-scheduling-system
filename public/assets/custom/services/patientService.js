
function patientService($resource, $location, $window) {
    var _resource = $resource(
            "/Account/Login/:id",
            {id: "@id"},
            {
                addSchedule: {
                    method: "POST",
                    url: "/Patient/AddSchedule",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"}
                },
                cancelSchedule: {
                    method: "POST",
                    url: "/Patient/CancelSchedule",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"}
                },
                updateScheudle: {
                    method: "POST",
                    url: "/Patient/UpdateSchedule",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"}
                },
                getSchedulesByUser: {
                    url: "/Patient/GetSchedulesByUser",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"}
                },
                getAllSchedules: {
                    url: "/Patient/GetAllSchedules",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"}
                },
            }
    );
    var factory = {};
    //properties
    //hold single user, or currently selected user
    factory.schedules = [];
    factory.schedule = {
        id: "",
        user_id: "",
        service_id: "",
        date: "",
        doctor_id: "",
        status: ""
    }


    //Operations
    factory.addSchedule = function (scope) {
        try {
            return _resource.addSchedule($.param(scope.schedule)).$promise.then(
                    function (res) {
                        //console.log(res);
                        if (res.Succeeded) {
                            scope.msg = res.msg;
                            return true;
                            ;
                        } else {
                            return false;
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

    factory.updateScheudle = function (scope) {
        try {
            return _resource.updateScheudle($.param(scope.schedule)).$promise.then(
                    function (res) {
                        scope.msg = res.msg;
                       // console.log(res);
                        if (res.Succeeded) {
                            scope.schedule = res.data;
                            return true;
                        } else {
                            return false;
                        }
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

    factory.cancelSchedule = function (scope) {
        return _resource.cancelSchedule($.param(scope.schedule)).$promise.then(
                function (res) {
                    scope.msg = res.msg;
                    if (res.Succeeded === true) {
                        return true;
                    } else {
                        //res.msg;
                        return false;
                    }
                  
                },
                function () {
                    scope.msg = "No connection to server";
                    return false;
                }
        );
    };

    factory.getSchedulesByUser = function (scope) {
        return _resource.getSchedulesByUser().$promise.then(
                function (res) {
                    scope.msg = res.msg;
                    if (res.Succeeded === true) {
                        scope.schedules = res.data;
                       // console.log(scope.schedules);
                        return true;
                    } else {
                        res.msg;
                        return false;
                    }

                },
                function () {
                    scope.msg = "No connection to server";
                    return false;
                }
        );
    };

    factory.getAllSchedules = function (scope) {
        return _resource.getAllSchedules().$promise.then(
                function (res) {
                    scope.msg = res.msg;
                    if (res.Succeeded === true) {
                        scope.schedules = res.data;
                        return true;
                    } else {

                        return false;
                    }

                },
                function () {
                    scope.msg = "No connection to server";
                    return false;
                }
        );
    };



    return factory;
}




//
app.factory("patientService", [
    "$resource",
    "$location",
    "$window",
    patientService
]);
