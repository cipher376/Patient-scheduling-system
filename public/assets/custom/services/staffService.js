
'use strict';

function staffService($resource, $location, $window) {
    var _resource = $resource(
            "/Account/Login/:id",
            {id: "@id"},
            {
                 get: {
                    method: "POST",
                    url: "/Staff/All",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"}
                },
                delete: {
                    method: "POST",
                    url: "/Staff/Delete",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"}
                },
                add: {
                    method: "POST",
                    url: "/Staff/Add",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"}
                },
                update: {
                    method: "POST",
                    url: "/Staff/update",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"}
                }
            }
    );

    var factory = {};
    
    //properties
    //hold single user, or currently selected user
    factory.staffs=[];
    factory.staff = {
        id:"",
        working_hours:"",
        specialty:"",
        fullname:"",
        date_of_birth:"",
        gender:"",
        address:"",
        company:"",
        phone:"",
        pic:"",
        account:{
            user_id:"",
            email:"",
            password:"",
            username:"",
            groups:[],
        }
    };
   
    //Operations
    factory.add = function (scope) {
        try {
            console.log(scope.staff);
            return _resource.add($.param(scope.staff)).$promise.then(
                    function (res) {
                        if (res.Succeeded) {
                            //console.log(res);
                            scope.staff = res.data;
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
    
     factory.update = function (scope) {
        try {
            return _resource.update($.param(scope.staff)).$promise.then(
                    function (res) {
                        scope.msg = res.msg;
                        if (res.Succeeded) {
                            scope.staff = res.data;

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
    
    

    factory.delete = function (scope) {
        return _resource.delete($.param( scope.staff)).$promise.then(
                function (res) {
                    //console.log(res);
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
    };
    
factory.get = function (scope) {
        return _resource.get().$promise.then(
                function (res) {
                    if (res.Succeeded === true) {
                       scope.staffs= res.data;
                       //console.log(res);
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
    return factory;
}




//
app.factory("staffService", [
    "$resource",
    "$location",
    "$window",
    staffService
]);
