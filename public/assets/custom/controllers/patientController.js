//import {account} from "../entities";

"use strict";

app.controller("patientController", [
    "$scope",
    "$rootScope",
    "$window",
    "$location",
    "$timeout",
    "patientService",
    "patientFactory",
    "hospitalFactory",
    "staffFactory",
    "messageService",
    "AccountService",
    "accountFactory",
    function ($scope, $rootScope, $window,
            $location, $timeout, patientService, patientFactory,
            hospitalFactory, staffFactory, messageService, accountService, accountFactory) {
        // Global scope
        var scope = $rootScope;

        function init() {
            // set page title ;
            scope.page_title = "Manage Patient";

            scope.schedules = patientService.schedules;
            scope.schedule = patientService.schedule;



            if ($window.location.href.indexOf("user_history") > -1) {
                scope.page_title = "Patient Appointment History";
            }

            if ($window.location.href.indexOf("user_message") > -1) {
                scope.page_title = "Patient Messages";
            }

            if ($window.location.href.indexOf("user_profile") > -1) {
                scope.page_title = "Patient Profile";
            }

            if ($window.location.href.indexOf("user_schedule") > -1) {
                scope.page_title = "Patient Schedule";
            }

            //Load previous appointment for user
            patientService.getSchedulesByUser(scope).then(function (status) {
                if (status) {
                    //scope.success();
                } else {
                    scope.error();
                }
            });
        }

        scope.sendAppointment = function () {

            scope.schedule.date = $("#schedule_date").val();
            scope.schedule.service_id = $("#schedule_service").val();
            scope.schedule.doctor_id = $("#schedule_doctor").val();
            scope.schedule.status = "pending";
            scope.schedule.user_id = scope.user.user_id;

            //validate schedule
            if (!scope.validateSchedule()) {
                scope.msg = "Invalid appointment, please ensure that all fills are provide";
                scope.warn();
                return;
            }
            if (scope.isNullOrEmpty(scope.schedule.id)) {
                patientService.addSchedule(scope).then(function (status) {
                    if (status) {
                        scope.schedules.push(scope.schedule);
                        scope.success();
                        $window.location.href = "/Main/#!/user_history";
                        location.reload();
                    } else {
                        scope.error();
                    }

                });
            } else {
                //update the appointment
                patientService.updateScheudle(scope).then(function (status) {
                    if (status) {
                        scope.success();
                        //reload the page
                        $window.location.href = "/Main/#!/user_history";
                        location.reload();
                    } else {
                        scope.error();
                    }

                });
            }
        }

        scope.clearScheduleFields = function (app) {
            $("#schedule_date").val(scope.currentDate);
            $("select#schedule_service").val("");
            $("select#schedule_doctor").val("");
            scope.schedule.service_id = "",
            scope.schedule.doctor_id = "";
            location.reload();

        }

        scope.cancelAppointment = function (app) {
            scope.schedule = app;
            console.log(app);
            patientService.cancelSchedule(scope).then(function (status) {
                if (status) {
                    scope.success();
                     location.reload();
                } else {
                    scope.error();
                }
            });
        }


        scope.validateSchedule = function () {
            console.log(scope.schedule);
            if (scope.isNullOrEmpty(scope.schedule.date) ||
                    scope.isNullOrEmpty(scope.schedule.doctor_id) ||
                    scope.isNullOrEmpty(scope.schedule.service_id)) {
                return false;
            }
            return true;
        }

        scope.getServiceByAppointment = function (id) {
            return hospitalFactory.getServiceById(scope, id);
        }

        scope.getDoctorByAppointment = function (id) {
            return staffFactory.getDoctorByUserId(scope, id);
        }
        
        


        scope.updatePatient = function () {
            if (scope.isNullOrEmpty(scope.user.password) || scope.isNullOrEmpty(scope.user.password)) {
                scope.msg = "Please check your password";
                scope.error();
                return;
            }
            //perform update
            if (scope.user.password.indexOf(scope.user.confirmpassword) < 0) {
                scope.msg = "Password do not match";
                scope.error();
                return;
            }

            // correct the select 2 and bootstrap datepicker
            scope.user.date_of_birth = $("#user_dob").val();
            scope.user.gender = $("#user_gender").val();
            if (scope.isNullOrEmpty(scope.user.date_of_birth)) {
                scope.msg = "Please input date of birth";
                scope.error();
                return;
            }
            if (scope.isNullOrEmpty(scope.user.gender)) {
                scope.msg = "Please select gender";
                scope.error();
                return;
            }
            accountFactory.upload(scope, function (status, file) {
                if (status) {
                    scope.msg = "Profile picture uploaded";
                    scope.success();
                    scope.user.pic = file;
                    sessionStorage.setItem("user", JSON.stringify(scope.user));
                    //console.log("Hello me");
                    console.log(sessionStorage.setItem);
                    accountService.updateAccount(scope).then(function (status) {
                        if (status) {
                            scope.success();
                            $("#user_dob").val(scope.user.date_of_birth);
                            $("#user_gender").val(scope.user.gender);
                        } else {
                            scope.error();
                        }
                    });
                }
            })
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

        }
        );
        //Conntrols UI jquery date input
        var date_now = new Date().toLocaleDateString();
        date_now = date_now.split('/');
        scope.currentDate = date_now[1] + "/" + date_now[0] + "/" + date_now[2];
        $("#schedule_date").val(scope.currentDate)
        init();
    }
]);
