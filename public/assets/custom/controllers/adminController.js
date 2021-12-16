
"use strict";

app.controller("adminController", [
    "$scope",
    "$rootScope",
    "$window",
    "$location",
    "$timeout",
    "staffService",
    "staffFactory",
    "patientService",
    "patientFactory",
    "AccountService",
    "accountFactory",
    "hospitalService",
    "hospitalFactory",
    "messageService",
    "messageFactory",
    function ($scope, $rootScope, $window, $location, $timeout, staffService, staffFactory,
            patientService, patientFactory, accountService, accountFactory, hospitalService,
            hospitalFactory, messageService, messageFactory) {
        // Global scope
        var scope = $rootScope;

        function init() {

            // set page title ;
            scope.page_title = "Home";
            if ($window.location.href.indexOf("admin_history") > -1) {
                scope.page_title = "Patient Appointments History";
            }

            if ($window.location.href.indexOf("message") > -1) {
                scope.page_title = "Messages";
            }

            if ($window.location.href.indexOf("user_profile") > -1) {
                scope.page_title = "User Profile";
            }

            if ($window.location.href.indexOf("admin_schedule") > -1) {
                scope.page_title = "Patient Appointment List";
            }
            if ($window.location.href.indexOf("admin_sms") > -1) {
                scope.page_title = "SMS Alerts";
            }

            scope.users = accountService.users;

            scope.patients = [];

            scope.doctors_to_patient = [];
            scope.doctor_id = "";

            accountService.all(scope).then(function (status) {
                if (status) {
                    
                    patientFactory.getPatients(scope);
                    //scope.success();
                    //Load patients
                    //console.log("Patients");
                    //console.log(scope.patients);
                } else {
                    scope.error();
                }
            })

            scope.schedules = patientService.schedules;
            scope.schedule = patientService.schedule;

            scope.filteredSchedules = [];
            scope.doctors_schedules = [];

            //load Schedules
            patientService.getAllSchedules(scope).then(function (status) {
                if (status) {
                    scope.filteredSchedules = scope.filterSchedules();
                    scope.schedules_for_doctor = scope.filter_schedule_for_doctor();
                    //console.log(scope.schedules_for_doctor);
                    //console.log("-----------------------------------");
                } else {

                }
            });

        }

        scope.addStaff = function () {
            
            if (scope.isNullOrEmpty(scope.staff.account.password)||scope.isNullOrEmpty(scope.staff.account.confirmpassword)){
                scope.msg = "Please input password"
                scope.error();
            }
            //perform update
            if (scope.staff.account.password.indexOf(scope.staff.account.confirmpassword) < 0) {
                scope.message = "Password do not match";
                scope.error();
                return;
            }
            // correct the select 2 and bootstrap datepicker
            scope.staff.date_of_birth = $("#staff_dob").val();
            scope.staff.gender = $("#staff_gender").val();
            scope.staff.specialty = $("#staff_specialty").val();
            
            if (scope.isNullOrEmpty(scope.staff.account.user_id)) {
                console.log("adding")
                staffService.add(scope).then(function (status) {
                    if (status === true) {
                        scope.success();
                        //add to staff
                        scope.staffs.push(scope.staff);

                        scope.staff = scope.resetStaff();
                    } else {
                        scope.error();
                    }
                });
            } else {
                accountFactory.upload(scope, function (status, file) {
                    if (status) {
                        scope.msg = "Profile picture uploaded";
                        scope.success();
                        scope.staff.pic = file
                        //console.log(scope.staff.pic);
                        sessionStorage.setItem("user", JSON.stringify(scope.user));
                        // Update staff profile
                        staffService.update(scope).then(function (status) {
                            if (status === true) {
                                scope.success();
                                //add to staff
                                scope.resetStaff();
                                //reload user;
                                scope.logout();
                            } else {
                                scope.error();
                            }
                        });
                    } else {
                        scope.msg = "Uploading picture failed";
                        scope.error();
                    }
                });

            }
        }

        scope.resetStaff = function () {
            scope.staff = {
                id: "",
                working_hours: "",
                specialty: "",
                fullname: "",
                date_of_birth: "",
                gender: "",
                address: "",
                company: "",
                phone: "",
                account: {
                    user_id: "",
                    email: "",
                    password: "",
                    username: "",
                    groups: [],
                }
            };

            $("#staff_dob").val("dd/mm/yyyy");
            $("#staff_gender").val("");
            $("#staff_specialty").val("");
        }

        scope.getDoctor = function (id) {
            return staffFactory.getDoctor(scope, id);
        }
        scope.getDoctorByUserId = function (doc_id) {
           // alert("patientCon");
            return staffFactory.getDoctorByUserId(scope, doc_id);
        }
        
        scope.getPatient = function (id) {
            return (patientFactory.getPatient(scope, id));
        }
        scope.getService = function (id) {
            return hospitalFactory.getServiceById(scope, id);
        }

        scope.filterSchedules = function () {
            return patientFactory.filter_schedules(scope);
        }

        scope.postToDoctor = function (schedule) {
            //console.log(schedule);
            //return;
            var doctor = {};
            try {
                doctor = JSON.parse(schedule.doctor);
            } catch (e) {
                doctor = schedule.doctor;
            }
            console.log(doctor);
            if(!scope.isNullOrEmpty(doctor)){
                schedule.doctor_id = doctor.account.user_id;
            }else{
                scope.msg = "Using prefered doctor";
                scope.info();
            }
        

            scope.schedule = schedule;
            scope.schedule.status = "assigned";
            patientService.updateScheudle(scope).then(function (status) {
                if (status) {
                    scope.success();
                    //remove from the schedule list
                    for (var i = 0; i < scope.schedules.lenght; i++) {
                        if (scope.schedules[i].id === scope.schedule.id) {
                            scope.schedules[i] = scope.schedule;
                        }
                    }
                    scope.filteredSchedules = scope.filterSchedules();
                    scope.doctor = {};
                    scope.schedule = {};
                } else {
                    scope.error();
                }
            });
        }

        scope.cancelPostToDoctorAction = function (schedule) {


            scope.msg = "Appointment Cancelled";
            scope.warn();

            // if decision is set return else go on 
            // if(!scope.decision){
            //     return;
            // }

            scope.schedule = schedule;
            scope.schedule.status = "pending";
            patientService.updateScheudle(scope).then(function (status) {
                if (status) {
                    scope.success();
                    //remove from the schedule list
                    for (var i = 0; i < scope.schedules.lenght; i++) {
                        if (scope.schedules[i].id === scope.schedule.id) {
                            scope.schedules[i] = scope.schedule;
                        }
                    }
                    scope.filteredSchedules = scope.filterSchedules();
                    scope.doctor = {};
                    scope.schedule = {};
                } else {
                    scope.error();
                }
            });
        }

        scope.filter_schedule_to_reply = function () {
            return patientFactory.filter_schedule_to_reply(scope);
        }
        scope.filter_schedule_for_doctor = function () {
            try{
            return patientFactory.filter_schedule_for_doctor(scope, scope.doctor.account.user_id);
            }catch(e){
                return {};
            }
        }

        //Doctors post results to the admin 
        scope.post_result = function (schedule) {
            scope.schedule = schedule;
            scope.schedule.status = "ready";
            console.log("posting");
            patientService.updateScheudle(scope).then(function (status) {
                if (status) {
                    scope.success();
                    //remove from the schedule list
                    for (var i = 0; i < scope.schedules.lenght; i++) {
                        if (scope.schedules[i].id === scope.schedule.id) {
                            scope.schedules[i] = scope.schedule;
                        }
                    }
                    scope.filteredSchedules = scope.filterSchedules();
                    scope.doctor = {};
                    scope.schedule = {};
                    scope.files =[];
                } else {
                    scope.error();
                }
            });
        }

        scope.cancel_post_result = function (schedule) {
            scope.msg = "Do you really want to cancel appointment?";
            scope.warn();

            scope.schedule = schedule;
            scope.schedule.status = "pending";
            patientService.updateScheudle(scope).then(function (status) {
                if (status) {
                    scope.success();
                    //remove from the schedule list
                    for (var i = 0; i < scope.schedules.lenght; i++) {
                        if (scope.schedules[i].id === scope.schedule.id) {
                            scope.schedules[i] = scope.schedule;
                        }
                    }
                    scope.filteredSchedules = scope.filterSchedules();
                    scope.doctor = {};
                    scope.schedule = {};
                } else {
                    scope.error();
                }
            });
        }

        scope.setCurrentSchedule = function (sched) {
            scope.schedule = sched;
            console.log(scope.schedule);
        }


        //Send result to the patient 
        scope.sendResult = function () {
            scope.message = messageService.message;

            if (scope.isNullOrEmpty(scope.files)) {
                scope.msg = "Please attach results";
                scope.error();
                return;
            }
            if (scope.isNullOrEmpty($(".message_content").val())) {
                scope.msg = "Please provide message content";
                scope.error();
                console.log($(".message_content").val());
                console.log(scope.message_content);
                return;
            }

            scope.message.title = "Doctor's Report";
            scope.message.date = new Date().toLocaleDateString();
            scope.message.sender_id = scope.user.uid;
            scope.message.receiver_id = scope.schedule.user_id;
            scope.message.content = $(".message_content").val();
            scope.message.schedule_id = scope.schedule.id;

            //console.log(scope.message.content);
            //return;
            //upload the attachment before sending the mail
            messageFactory.upload(scope, function (status, file) {
                if (status) {
                    scope.message.attachment = file;
                    messageService.sendMessage(scope).then(function (status) {
                        console.log(status);
                        if (status) {
                            scope.msg = "Message sent"
                            scope.success();
                            scope.message = {};
                            scope.message.content = $(".message_content").val("");

                            //Mark schedule as honored
                            scope.schedule.status = 'honored';
                            //replace current schedule in the patient history
                            patientFactory.replaceSchedule(scope, scope.schedule);

                        } else {
                            scope.msg = "Sending result failed";
                            scope.error();
                        }
                    });
                } else {
                    scope.msg = "Sending result failed";
                    scope.error();
                }
            });

            return;
        }
        
          scope.cancelAppointment = function (schedule) {
              scope.schedule = schedule;
            patientService.cancelSchedule(scope).then(function (status) {
                if (status) {
                    scope.success();
                    //delete from current schedules
                    patientFactory.deleteSchedule(scope, scope.schedule);
                } else {
                    scope.error();
                }
            });
        }



        scope.clearMsg = function () {
            scope.message = {};
            scope.schedule = {};
        }



        scope.setCurrentSchedule=function(sched){
            scope.schedule = sched;
            console.log(scope.schedule);
        }


        $scope.$watch('files', function (files) {
            if (files != null) {
                // make files array for not multiple to be able to be used in ng-repeat in the ui
                if (!angular.isArray(files)) {
                    $timeout(function () {
                        files = [files];
                        scope.files = files;
                        $scope.files = files;
                        //console.log(scope.files);
                        //console.log(files);
                    });
                    return;
                }
            }

        });

        init();
    }
]);
