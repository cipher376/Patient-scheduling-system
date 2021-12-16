
function accountFactory($resource, $location, $window) {
    $factory = {};
    $factory.account_types = ["Admin", "Default", "Patient", "Doctor"];

    $factory.is_login = function (scope) {
        return scope.user.isAuthenticated;
    }
    
    $factory.is_in_one_of_the_groups = function (scope, $groups) {
        for (var i = 0; i < $groups.length; i++) {
            if ($factory.is_in_group(scope, $groups[i])) {
                return true;
            }
        }
        return false;
    }

    
    $factory.is_in_group = function (scope, $group_name) {
        $groups = scope.user.groups;
        
        for (var i = 0; i < $groups.length; i++) {
            if ($groups[i].toLowerCase() === $group_name.toLowerCase()) {
                return true;
            }
        }
        return false;
    }

    $factory.set_home_url = function (scope) {
        console.log(scope.user);
        if (scope.inArray(scope.user.groups, "admin")) {
            scope.home_url = scope.root_url + "admin_home";
        } else if ( scope.inArray(scope.user.groups, "doctor")) {
            scope.home_url = scope.root_url + "doctor_home";
        } else {
            // Default user, or patient
            scope.home_url = scope.root_url + "patient_home";
        }
    }

$factory.has_permission = function (scope, $groups) {
         console.log("no permision");
        if (!$factory.is_in_one_of_the_groups(scope, $groups)) {
            scope.msg = "You do not have permission to perform this action";
            console.log("no permision");
            return false;
        }
        console.log("have permission");
        return true;
    }
    
    $factory.upload = function(scope, callback){
         //change the name to applicant id and mark as profile
                        var url = scope.profilePicUrl + '?id=' + scope.user.uid;
                        //upload image and if successful, send form data 
                        if(scope.isNullOrEmpty(scope.files)){
                            scope.msg = "Select file to upload";
                            scope.warn();
                        }
                        console.log(scope.files);
                        scope.uploadPic(scope.files, url, callback);
                        
    }

    return $factory;
}
app.service("accountFactory", ['$resource', '$location', '$window', accountFactory]);