
function messageService($resource, $location, $window) {
    var _resource = $resource(
            "/Account/Login/:id",
            {id: "@id"},
            {
                getMessages: {
                    method: "POST",
                    url: "/Message/GetMessagesByUserId",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"}
                },
                sendMessage: {
                    method: "POST",
                    url: "/Message/sendMessage",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"}
                },
                deleteMessage: {
                    method: "POST",
                    url: "/Message/deleteMessage",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"}
                },
                downloadAttachment: {
                    method: "POST",
                    url: "/Message/downloadAttachment",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"}
                },
                getAttachementUrl: {
                    method: "POST",
                    url: "/Message/getAttachementUrl",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"}
                }
            }
    );

    var factory = {};
    //properties
    //hold single user, or currently selected user
    factory.messages = [];
    factory.message = {
        id: "",
        sender_id: "",
        date: "",
        receiver_id: "",
        title: "",
        content: "",
        attachment: ""
    }


    //Operations
    factory.getMessages = function (scope) {
        try {
            return _resource.getMessages().$promise.then(
                    function (res) {
                        if (res.Succeeded) {
                            scope.messages = res.data
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

    factory.sendMessage = function (scope) {
        try {
            return _resource.sendMessage($.param(scope.message)).$promise.then(
                    function (res) {
                        scope.msg = res.msg;
                        if (res.Succeeded) {
                            scope.message = res.data
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

    factory.deleteMessage = function (scope) {
        return _resource.deleteMessage($.param(scope.message)).$promise.then(
                function (res) {
                    scope.msg = res.msg;
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

    factory.downloadAttachment = function (scope) {
        return _resource.downloadAttachment($.param({id: scope.message.id})).$promise.then(
                function (res) {
                    
                    return res;
                },
                function () {
                    scope.msg = "No connection to server";
                    return false;

                }
        );
    };

factory.getAttachementUrl = function (scope) {
        return _resource.getAttachementUrl($.param({id: scope.message.id})).$promise.then(
               
            function (res) {
                    return res.data;
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
app.factory("messageService", [
    "$resource",
    "$location",
    "$window",
    messageService
]);
