//import {account} from "../entities";

"use strict";

app.controller("mainController", [
    "$scope",
    "$rootScope",
    "$window",
    "$location",
    "$timeout",
    "AccountService",
    'accountFactory',
    'staffService',
    'staffFactory',
    'hospitalService',
    'messageService',
    'messageFactory',
    "Upload",
    function ($scope, $rootScope, $window, $location, $timeout,
            accountService, account_factory, staffService,
            staffFactory, hospitalService, messageService, messageFactory, Upload) {
        // Global scope
        var scope = $rootScope;
        $scope.search_key = "";

        function init() {
            scope.msg = "";
            // Routes;
            scope.login_url = "/Account/login";
            scope.register_url = "/Account/register";
            scope.home_url = "/Main/#!/home";
            scope.root_url = "/Main/#!/"
            scope.profile_url = "/#!/profile";
            scope.create_staff_url = "admin_staff"
            scope.update_user_info_url = "reg_info"
            scope.page_title = "Dashboard";
            scope.profileImageUrl = "";
            scope.profilePicUrl = '/Auth/UploadImage';

            scope.staffs = staffService.staffs;
            scope.staff = staffService.staff;

            scope.services = hospitalService.services;
            scope.service = hospitalService.service;

            scope.messages = messageService.messages;
            scope.message = messageService.message;

            scope.schedules_for_doctor = []

            hospitalService.getServices(scope).then(function (status) {
                if (status) {
                    //scope.success();
                    //console.log(scope.services);
                } else {
                    scope.error();
                }
            });

            staffService.get(scope).then(function (status) {
                if (status) {
                    //scope.success();

                    //prepare doctors
                    scope.doctors = staffFactory.getDoctors(scope);

                    scope.doctor = staffFactory.getDoctorByUserId(scope, scope.user.user_id);

                } else {
                    scope.error();
                }
            });

            scope.last_login = (new Date(Date.now())).toDateString();


            scope.search_key = "";

            try {
                var t_user = sessionStorage.getItem("user");
                if (!scope.isNullOrEmpty(t_user)) {
                    scope.user = JSON.parse(t_user);
                    console.log(scope.user);

                    //get profile picture
                    scope.profileImageUrl = "/Public/assets/uploads/" + scope.user.pic;

                    //if user has not provided personal information details, 
                    // take the person to personal information details;
                    if (scope.isNullOrEmpty(scope.user.fullname)) {
                        //scope.updateProfile();

                    }
                    account_factory.set_home_url();



                } else {

                    // take the person back to login page
                    if ($window.location.href.toLowerCase().indexOf("login") < 0 &&
                            $window.location.href.toLowerCase().indexOf("register") < 0) {
                        $window.location.href = scope.login_url;
                    }
                }
            } catch (e) {

            }

            messageService.getMessages(scope).then(function (status) {
                if (status) {
                    //scope.success();
                } else {
                    scope.error();
                }
            });

            scope.isDirty = false;
        }


        scope.calMonthsFromDates = function (end_date) {
            //console.log(end_date);
            var new_date = Date.parse(end_date) - Date.now();
            //console.log(new_date);
            //convert from mili to seconds
            var secs = new_date / 1000;
            var mins = secs / 60;
            var hours = mins / 60;
            var days = hours / 24;
            var months = days / 30;
            //console.log(days);
            return months
        }

        scope.error = function () {
            try {
                $.notify(
                        scope.msg,
                        "error",
                        {position: "top center"}
                );
                scope.msg = "";
            } catch (e) {

            }
            scope.msg = "";

        }

        scope.info = function () {
            try {
                $.notify(
                        scope.msg,
                        "info",
                        {position: "top center"}

                );
                scope.msg = "";
            } catch (e) {

            }
            scope.msg = "";
        }

        scope.success = function () {
            try {
                $.notify(
                        scope.msg,
                        "success",
                        {position: "top center"}

                )
                scope.msg = "";
            } catch (e) {

            }
            scope.msg = "";
        }
        scope.warn = function () {
            try {
                $.notify(
                        scope.msg,
                        "warn",
                        {position: "top center"}


                );
                scope.msg = "";
            } catch (e) {

            }

            scope.msg = "";
        }

        scope.logout = function () {
            accountService.logout(scope).then(function (status) {
                if (status) {
                    scope.msg = " You are logging out! "
                    scope.warn();
                    setTimeout(function () {
                        $window.location.href = scope.login_url;
                    }, 100)
                } else {
                    scope.error();
                }
            })
        }
        scope.isNullOrEmpty = function (str) {
            if (str === "" || str === null || str === undefined) {
                return true;
            } else {
                return false;
            }
        }


        scope.search = function (key) {
            var key = scope.search_key.toLowerCase();
            for (var j = 0; j < scope.owners.length; j++) {

            }
            console.log(scope.owner);
        }

        scope.convertDateToUnix = function (date) {

            var dateAr = date.split("/");
            var newdate = dateAr[2] + "-" + dateAr[1] + "-" + dateAr[0];
            if (newdate.length !== 10)
            {
                // alert(newdate);
                return "";
            } else {
                return newdate;
            }
        };
        scope.convertDateFromUTC = function (utc) {
            var date1 = (new Date());
            date1.setUTCMilliseconds(utc * "1");
            return date1.toLocaleDateString();
        }
        scope.convertTimeFromUTC = function (utc) {
            var date2 = (new Date());
            date2.setUTCMilliseconds(utc * "1");
            return date2.toLocaleTimeString();
        }

        scope.reverseArray = function (array) {
            var ar = [];
            for (var i = (array.length - 1); i >= 0; i--) {
                ar.push(array[i]);
            }
            return ar;
        }

        scope.getCurrentTime = function () {
            return new Date().toLocaleTimeString()
        }


        scope.is_login = function () {
            if (account_factory.is_login(scope)) {
                return true;
            }
            return false;
        }

        //Pass in the allowed groups
        scope.has_permission = function (groups) {
            try {
                if (account_factory.has_permission(scope, groups)) {
                    return true;
                }
            } catch (e) {

            }
            return false;
        }
        scope.user_is_in = function (group) {
            try {
                if (account_factory.is_in_group(scope, group)) {
                    //console.log("is in "+group);
                    return true;
                }
            } catch (e) {

            }
            return false;

        }

        $scope.$watch("search_key", function (newVal, oldVal) {
            scope.search_key = newVal;
        });

        scope.deleteFromArr = function (pos, arr) {
            var tem = [];
            for (var i = 0; i < arr.length; i++) {
                if (i == pos) {
                    continue;
                }
                tem.push(arr[i]);
            }

            return tem;
        }
        scope.inArray = function (arr, key_str) {
            var found = false;
            for (var i = 0; i < arr.length; i++) {
                if (arr[i].toLowerCase().indexOf(key_str.toLowerCase()) > -1) {
                    found = true;
                }
            }
            console.log(found);
            console.log("helo")
            return found;
        }

        scope.updateAdminProfile = function () {
            //set the current user as the current staff;
            staffFactory.copyUserToStaff(scope);
            $location.path(scope.create_staff_url);
        }

        scope.updateProfile = function () {
            //set the current user as the current personal information page;
            $location.path(scope.update_user_info_url);
        }
        scope.addStaff = function () {

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

                staffService.add(scope).then(function (status) {
                    if (status === true) {
                        scope.success();
                        //add to staff
                        scope.staffs.push(scope.staff);
                    } else {
                        scope.error();
                    }
                });
            } else {

                staffService.update(scope).then(function (status) {
                    if (status === true) {
                        scope.success();
                        //add to staff
                        scope.staffs.push(scope.staff);
                        //reload user;
                        scope.logout();
                    } else {
                        scope.error();
                    }
                });
            }
        }

        scope.readMessage = function (msg) {
            messageFactory.readMessage(scope, msg);
        }

        scope.downloadReport = function () {
            messageService.getAttachementUrl(scope).then(function (path) {
                window.open("/" + path);

            })
        }




//                *********************FILE UPLOAD*********************
        scope.invalidFiles = [];
// make invalidFiles array for not multiple to be able to be used in ng-repeat in the ui

        scope.uploadPic = function (files, url, callback) {
            $scope.formUpload = true;
            if (!scope.isNullOrEmpty(files)) {
                if (files[0].size > 8000000) {
                    alert(files[0].size);
                    scope.msg("Your picture is too large to upload<br> size should be less than 10mb");
                    scope.error();
                    return;
                }
                // alert();
                uploadUsing$http(files, url, callback);
            }
        };

        function uploadUsing$http(files, url, callback) {
            console.log($scope.getReqParams());
            var form_data = new FormData();
            angular.forEach(files, function (file) {
                form_data.append('file', file);
            });
            var upload = Upload.http({
                url: url + $scope.getReqParams(),
                method: 'POST',
                transformRequest: angular.identity,
                headers: {
                    //'Content-Type': file.type,
                    'Content-Type': undefined,
                    'Process-Data': false
                },
                data: form_data
            });

            upload.then(function (response) {
                console.log(response.data);
                callback(response.data.Succeeded, response.data.file);
                files.result = response.data;
            }, function (response) {
                console.log(response);

                if (response.Succeded !== true) {
                    scope.msg = "Uploading image failed";
                    scope.error();
                } else {
                    //scope.msg = "Network error";
                    // scope.error();
                }
            });

            upload.progress(function (evt) {
                files.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
            });
        }


        $scope.confirm = function () {
            return confirm('Are you sure? Your local changes will be lost.');
        };

        $scope.getReqParams = function () {
            return $scope.generateErrorOnServer ? '?errorCode=' + $scope.serverErrorCode +
                    '&errorMessage=' + $scope.serverErrorMsg : '';
        };

        angular.element(window).bind('dragover', function (e) {
            e.preventDefault();
        });
        angular.element(window).bind('drop', function (e) {
            e.preventDefault();
        });

        $scope.modelOptionsObj = {};
        $scope.$watch('validate+dragOverClass+modelOptions+resize+resizeIf', function (v) {
            $scope.validateObj = eval('(function(){return ' + $scope.validate + ';})()');
            $scope.dragOverClassObj = eval('(function(){return ' + $scope.dragOverClass + ';})()');
            $scope.modelOptionsObj = eval('(function(){return ' + $scope.modelOptions + ';})()');
            $scope.resizeObj = eval('(function($file){return ' + $scope.resize + ';})()');
            $scope.resizeIfFn = eval('(function(){var fn = function($file, $width, $height){return ' + $scope.resizeIf + ';};return fn;})()');
        });

        $timeout(function () {
            $scope.capture = localStorage.getItem('capture' + version) || 'camera';
            $scope.pattern = localStorage.getItem('pattern' + version) || 'image/*,audio/*,video/*';
            $scope.acceptSelect = localStorage.getItem('acceptSelect' + version) || 'image/*,audio/*,video/*';
            $scope.modelOptions = localStorage.getItem('modelOptions' + version) || '{debounce:100}';
            $scope.dragOverClass = localStorage.getItem('dragOverClass' + version) || '{accept:\'dragover\', reject:\'dragover-err\', pattern:\'image/*,audio/*,video/*,text/*\'}';
            $scope.disabled = localStorage.getItem('disabled' + version) == 'true' || false;
            $scope.multiple = localStorage.getItem('multiple' + version) == 'true' || false;
            $scope.allowDir = localStorage.getItem('allowDir' + version) == 'true' || true;
            $scope.validate = localStorage.getItem('validate' + version) || '{size: {max: \'20MB\', min: \'10B\'}, height: {max: 12000}, width: {max: 12000}, duration: {max: \'5m\'}}';
            $scope.keep = localStorage.getItem('keep' + version) == 'true' || false;
            $scope.keepDistinct = localStorage.getItem('keepDistinct' + version) == 'true' || false;
            $scope.orientation = localStorage.getItem('orientation' + version) == 'true' || false;
            $scope.runAllValidations = localStorage.getItem('runAllValidations' + version) == 'true' || false;
            $scope.resize = localStorage.getItem('resize' + version) || "{width: 1000, height: 1000, centerCrop: true}";
            $scope.resizeIf = localStorage.getItem('resizeIf' + version) || "$width > 5000 || $height > 5000";
            $scope.dimensions = localStorage.getItem('dimensions' + version) || "$width < 12000 || $height < 12000";
            $scope.duration = localStorage.getItem('duration' + version) || "$duration < 10000";
            $scope.maxFiles = localStorage.getItem('maxFiles' + version) || "500";
            $scope.ignoreInvalid = localStorage.getItem('ignoreInvalid' + version) || "";
            $scope.$watch('validate+capture+pattern+acceptSelect+disabled+capture+multiple+allowDir+keep+orientation+' +
                    'keepDistinct+modelOptions+dragOverClass+resize+resizeIf+maxFiles+duration+dimensions+ignoreInvalid+runAllValidations', function () {
                        localStorage.setItem('capture' + version, $scope.capture);
                        localStorage.setItem('pattern' + version, $scope.pattern);
                        localStorage.setItem('acceptSelect' + version, $scope.acceptSelect);
                        localStorage.setItem('disabled' + version, $scope.disabled);
                        localStorage.setItem('multiple' + version, $scope.multiple);
                        localStorage.setItem('allowDir' + version, $scope.allowDir);
                        localStorage.setItem('validate' + version, $scope.validate);
                        localStorage.setItem('keep' + version, $scope.keep);
                        localStorage.setItem('orientation' + version, $scope.orientation);
                        localStorage.setItem('keepDistinct' + version, $scope.keepDistinct);
                        localStorage.setItem('dragOverClass' + version, $scope.dragOverClass);
                        localStorage.setItem('modelOptions' + version, $scope.modelOptions);
                        localStorage.setItem('resize' + version, $scope.resize);
                        localStorage.setItem('resizeIf' + version, $scope.resizeIf);
                        localStorage.setItem('dimensions' + version, $scope.dimensions);
                        localStorage.setItem('duration' + version, $scope.duration);
                        localStorage.setItem('maxFiles' + version, $scope.maxFiles);
                        localStorage.setItem('ignoreInvalid' + version, $scope.ignoreInvalid);
                        localStorage.setItem('runAllValidations' + version, $scope.runAllValidations);
                    });
        });


        scope.afterUpload = function () {

        }

        /*****************************UPLOADS ENDS HERE*******************************/


        init();

    }
]);
