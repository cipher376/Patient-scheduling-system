
function messageFactory() {
    $factory = {};

    $factory.sortByName = function (scope, id) {
        for (var i = 0; i < scope.services.length; i++) {
            if (scope.services[i].id === id) {
                return scope.services[i];
            }
        }
        return undefined;
    }

    $factory.upload = function (scope, callback) {
        //change the name to applicant id and mark as profile
        var url = scope.profilePicUrl + '?id=' + scope.message.receiver_id+Math.floor((Math.random() * 10000000) + 1);
        //upload image and if successful, send form data 
        if (scope.isNullOrEmpty(scope.files)) {
            scope.msg = "Select file to upload";
            scope.warn();
        }
        //console.log(scope.files);
        scope.uploadPic(scope.files, url, callback);
    }
    
    $factory.readMessage = function(scope, msg){
        scope.message = msg;
    }

    return $factory;
}

app.service("messageFactory", [messageFactory]);