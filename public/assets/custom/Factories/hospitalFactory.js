
function hospitalFactory() {
    $factory = {};
    $factory.account_types = ["Doctor","Admin","Default"];
    
    $factory.getServiceById = function(scope, id){
        for(var i=0;i<scope.services.length;i++){
            if(scope.services[i].id === id){
                return scope.services[i];
            }
        }
         return undefined;
    }
    

    return $factory;
}
app.service("hospitalFactory", [hospitalFactory]);