
function staffFactory() {
    $factory = {};
    $factory.account_types = ["Doctor","Admin","Default"];
    var specialties =["physician","lab technician", "mid-wife", "surgeon"];
    
    $factory.getDoctors = function(scope){
        if(scope.isNullOrEmpty(scope.staffs))return {};
        var doctors = [];
         for(var i=0;i<scope.staffs.length;i++){
             if(inSpecialty(scope.staffs[i].specialty.toLowerCase())){
                 doctors.push(scope.staffs[i]);
             }
         }
         
         return doctors;
    }
      $factory.getDoctorByUserId = function(scope, user_id){
          //console.log("staffs");
          //console.log(scope.staffs);
          //alert("Im called");
          //console.log(user_id);
          if(scope.isNullOrEmpty(scope.staffs))return {};
         for(var i=0;i<scope.staffs.length;i++){
                 if(scope.staffs[i].account.user_id == user_id){
                     //console.log("Doctor found");
                     return scope.staffs[i];
                 }
         }
         return {};
    }
    var inSpecialty = function(specialty){
        for(var i=0;i<specialties.length;i++){
            if(specialties.indexOf(specialty) >-1){
                return true;
            }
        }
        return false;
    }
    
     $factory.getDoctor = function(scope, id){
         if(scope.isNullOrEmpty(scope.staffs))return {};
         for(var i=0;i<scope.staffs.length;i++){
              console.log(scope.staffs[i]);
                 if(scope.staffs[i].id == id){
                    
                     return scope.staffs[i];
                 }
         }
         return {};
    }
  
    $factory.getAdmin = function(scope){
        
    }
    
    $factory.copyUserToStaff=function(scope){         
        scope.staff.working_hours = scope.user.working_hours;
        scope.staff.specialty = scope.user.specialty;
        scope.staff.fullname = scope.user.fullname;
        scope.staff.date_of_birth = scope.user.date_of_birth;
        scope.staff.gender = scope.user.gender;
        scope.staff.address = scope.user.address;
        scope.staff.company = scope.user.company;
        scope.staff.phone = scope.user.phone;
        scope.staff.account.user_id = scope.user.user_id;
        scope.staff.account.email = scope.user.email;
        scope.staff.account.password = scope.user.password;
        scope.staff.account.username = scope.user.username;
        scope.staff.account.groups = scope.user.groups;        
   }
   
   $factory.copyStaffToUser=function(scope){
       // update the global user credentials;
       scope.user.fullname = scope.staff.fullname;
       scope.user.email = scope.staff.account.email;
       scope.user.phone = scope.staff.phone;
       scope.user.groups = scope.staff.account.groups;
       scope.user.gender = scope.staff.gender;
       scope.user.address = scope.staff.address;
       scope.user.date_of_birth = scope.staff.date_of_birth;
       scope.user.working_hours = scope.staff.working_hours;
       scope.user.specialty = scope.staff.specialty;
       scope.user.company = scope.staff.company;
      
   }
    

    return $factory;
}
app.service("staffFactory", [staffFactory]);