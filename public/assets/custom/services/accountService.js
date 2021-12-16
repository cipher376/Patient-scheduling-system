
function AccountService($resource, $location, $window) {
    var _resource = $resource(
            "/Account/Login/:id",
            {id: "@id"},
            {
                register: {
                    method: "POST",
                    url: "/Auth/Register",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"}
                },
                updateAccount: {
                    method: "POST",
                    url: "/Auth/UpdateAccount",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"}
                },
                delete: {
                    method: "POST",
                    url: "/Auth/Delete",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"}
                },
                get: {
                    method: "GET",
                    url: "/Auth/GetUser",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"}
                },
                query: {
                    method: "GET",
                    url: "/Auth/GetAll",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"}
                },
                forgotpassword: {
                    method: "POST",
                    url: "/Auth/ForgotPassword",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"}
                },
                resetpassword: {
                    method: "POST",
                    url: "/Auth/ResetPassword",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"}
                },
                login: {
                    method: "POST",
                    url: "/Auth/Login",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"}
                },
                logout: {
                    method: "POST",
                    url: "/Auth/Logout",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"}
                },
                all: {
                    method: "POST",
                    url: "/Auth/All",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"}
                },
                getProfilePic: {
                    method: "POST",
                    url: "/Auth/downloadImage",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"}
                }
            }
    );

    var factory = {};
    //properties
    //hold single user, or currently selected user
    factory.user = {
        accounttype: "",
        fullname: "",
        email: "",
        phone: "",
        password: "",
        confirmpassword: "",
        remember: false,
        code: "", //for password reset"
        user_id: "",
        uid: "",
        isAuthenticated: false,
        groups: [],
        gender: "",
        address: "",
        date_of_birth: "",
        working_hours: "",
        specialty: "",
        company: "",
        pic: ""
    };

    factory.users = [];

    //Check if username is email
    function emailValidation(username) {
        var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
        return filter.test(username);
    }
    //Holds list of all users
    factory.list = [];

    //Operations
    factory.create = function (scope) {
        //console.log(factory.user);
        //console.log($.param(factory.user));
        try {
            return _resource.register($.param(factory.user)).$promise.then(
                    function (res) {
                        if (res.Succeeded) {
                            console.log(res);
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

    factory.updateAccount = function (scope) {
        try {
            return _resource.updateAccount($.param(scope.user)).$promise.then(
                    function (res) {
                        scope.msg = res.msg;
                        if (res.Succeeded) {
                            //console.log(res);
                            scope.user = {};
                            scope.user.isAuthenticated = true;
                            scope.user.user_id = res.uid;
                            scope.user.uid = res.uid;
                            scope.user.email = res.email;
                            scope.user.fullname = res.fullname;
                            scope.user.phone = res.phone;
                            scope.user.groups = res.accounttype
                            scope.user.address = res.address
                            scope.user.date_of_birth = res.date_of_birth
                            scope.user.company = res.company
                            scope.user.gender = res.gender
                            scope.user.specialty = res.specialty
                            scope.user.working_hours = res.working_hours
                            scope.user.pic = res.pic;


                            sessionStorage.setItem("user", JSON.stringify(scope.user));

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

    factory.login = function (scope) {
        return _resource.login($.param(factory.user)).$promise.then(
                function (res) {
                    console.log(res);
                    if (res.Succeeded === true) {
                        //alert(res.msg);
                        //Saving user data on sessionStorage
                        scope.user = {};
                        scope.user.isAuthenticated = true;
                        scope.user.uid = res.uid;
                        scope.user.user_id = res.uid;
                        scope.user.email = res.email;
                        scope.user.username = res.username;
                        scope.user.fullname = res.fullname;
                        scope.user.phone = res.phone;
                        scope.user.groups = res.accounttype
                        scope.user.address = res.address
                        scope.user.date_of_birth = res.date_of_birth
                        scope.user.company = res.company
                        scope.user.specialty = res.specialty
                        scope.user.gender = res.gender
                        scope.user.working_hours = res.working_hours
                        scope.user.pic = res.pic
                        $("#user_dob").val(scope.user.date_of_birth);
                        $("#user_gender").val(scope.user.gender);
                        sessionStorage.setItem("user", JSON.stringify(scope.user));
                        scope.msg = res.msg;

                    } else {
                        scope.msg = res.msg;
                    }
                    return res.Succeeded;
                },
                function () {
                    scope.msg = "Connection failed";
                    return false;
                }
        );
    };

    factory.logout = function (scope) {
        return _resource.logout($.param({id: scope.uid})).$promise.then(
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

    factory.forgotpassword = function (scope) {
        return _resource.forgotpassword({data: $.param(factory.user)}).$promise.then(
                function (res) {
                    console.log(res);
                    if (res.Succeeded === true) {
                        scope.msg = res.msg;

                    } else {
                        scope.msg = res.msg;
                    }
                    return res.Succeeded;
                },
                function () {
                    scope.msg = "No connection to server";
                    return false;
                }
        );
    };

    factory.resetpassword = function (scope) {
        return _resource.update({data: $.param(factory.user)}).$promise.then(
                function (res) {
                    console.log(res);
                    if (res.Succeeded === true) {
                        scope.msg = res.msg;
                        return true;
                    } else {
                        scope.msg = res.msg;
                    }
                },
                function () {
                    scope.msg = "No connection to server";
                    return false;
                }
        );
    };

    factory.all = function (scope) {
        return _resource.all().$promise.then(
                function (res) {
                    if (res.Succeeded == true) {
                     
                        scope.users = res.data;   
                        
                        //console.log("All Users");
                        //console.log(scope.users);
                        return true;
                    } else {
                        res.msg;
                        return false
                    }

                },
                function () {
                    scope.msg = "No connection to server";
                    return false;
                }
        );
    };

    factory.getProfilePic = function (scope) {
        return _resource.getProfilePic({id: scope.user.uid}).$promise.then(
                function (res) {
                    return scope.profileImageUrl = res.data;
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
app.factory("AccountService", [
    "$resource",
    "$location",
    "$window",
    AccountService
]);
