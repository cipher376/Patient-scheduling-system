
function patientFactory() {
    $factory = {};
    $factory.account_types = ["Doctor", "Admin", "Default"];

    $factory.createSchedule = function (scope) {
        scope.schedule.user_id = scope.user.user_id;
        scope.schedule.status = "pending";
        return scope.schedule;
    }

    $factory.deleteSchedule = function (scope, schedule) {
        var index = -1;
        for (var i = 0; i < scope.schedules.length; i++) {
            if (schedule.id === scope.schedules[i].id) {
                index = i;
                break;
            }
        }
        if (index > -1) {
            scope.schedules = scope.deleteFromArr(index, scope.schedules);
        }
         index = -1;
        for (var i = 0; i < scope.filteredSchedules.length; i++) {
            if (schedule.id === scope.filteredSchedules[i].id) {
                index = i;
                break;
            }
        }
        if (index > -1) {
            scope.filteredSchedules = scope.deleteFromArr(index, scope.filteredSchedules);
        }
        if (index !== -1) {
            return true;
        }
        return false;
    }

    $factory.addSchedule = function (scope, schedule) {
        scope.schedules.push(schedule);
    }

    $factory.replaceSchedule = function (scope, schedule) {
        var index = -1;
        for (var i = 0; i < scope.schedules.length; i++) {
            if (schedule.id === scope.schedules[i].id) {
                scope.schedules[i] = schedule
                index = i;
                break;
            }
        }
         for (var i = 0; i < scope.filteredSchedules.length; i++) {
            if (schedule.id === scope.filteredSchedules[i].id) {
                scope.filteredSchedules[i] = schedule
                index = i;
                break;
            }
        }
        if (index !== -1) {
            return true;
        }
        return false;
    }

    $factory.getPatients = function (scope) {
        scope.patients = [];
        for (var i = 0; i < scope.users.length; i++) {
            if (is_a_patient(scope.users[i])) {
                //console.log("Patient found");
                scope.patients.push(scope.users[i]);
            }
        }
        
    }

    $factory.filter_schedules = function (scope) {
        console.log(scope.schedules);
        var schedules = [];
        for (var i = 0; i < scope.schedules.length; i++) {
            var index = -1;
            for (var j = 0; j < schedules.length; j++) {
                if (schedules[j].user_id == scope.schedules[i].user_id) {
                    index = j;
                    
                }
            }
            if (index > -1) {
                schedules[index] = scope.schedules[i];
            } else {
                schedules.push(scope.schedules[i]);
            }
        }
        return scope.reverseArray(schedules);
    }

    $factory.filter_schedule_to_reply = function (scope) {
        var sched_to_reply = [];
        for (var i = 0; i < scope.schedules.length; i++) {
            if (scope.schedules[i].status.toLowerCase().indexOf("ready") > -1) {
                sched_to_reply.push(scope.schedules[i]);
            }
        }
        //console.log(sched_to_reply);
        return sched_to_reply;
    }

    $factory.filter_schedule_for_doctor = function (scope, id) {
        var sched = [];
        for (var i = 0; i < scope.schedules.length; i++) {
            if (scope.schedules[i].status.toLowerCase().indexOf("assigned") > -1 &&
                    scope.schedules[i].doctor_id == id) {
                sched.push(scope.schedules[i]);
            }
           
        }
        
        return sched;
    }

    $factory.getPatient = function (scope, id) {
        var patient  = {};
        for(var i=0;i<scope.patients.length;i++){
             if (scope.patients[i].user_id === id) {
                //console.log("patient found");
                //console.log(scope.patients[i]);
                patient = scope.patients[i];
            }
         
        }
        return patient;
    }

    var is_a_patient = function (patient) {
        if ((patient.groups.length === 1) && patient.groups.indexOf("Default") > -1) {
            return true;
        }
        return false;
    }


    return $factory;
}
app.service("patientFactory", [patientFactory]);