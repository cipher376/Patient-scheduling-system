

"use strict";

var app = angular.module("app", [
	"ngRoute",
	"ngResource",
	"720kb.datepicker",
        'ngFileUpload',
]);

var version = "11.1.3";
function cfg($routeProvider, $locationProvider) {
	$routeProvider
		.when("/", { templateUrl: "/Main/home", controller: "homeController" })
		.when("/home", { templateUrl: "/Main/home", controller: "homeController" })
		
		.when("/reg_info", {
			templateUrl: "/Main/reg_info",
			controller: "patientController"
		})
                .when("/user_schedule", {
			templateUrl: "/Main/user_schedule",
			controller: "patientController"
		})
                .when("/patient_home", {
			templateUrl: "/Main/user_schedule",
			controller: "patientController"
		})
                .when("/patient_history", {
			templateUrl: "/Main/admin_history",
			controller: "adminController"
		})
                .when("/profile", {
			templateUrl: "/Main/profile",
			controller: "patientController"
		})
                .when("/message", {
			templateUrl: "/Main/message",
			controller: "patientController"
		})
                .when("/user_history", {
			templateUrl: "/Main/user_history",
			controller: "patientController"
		})
                .when("/events", {
			templateUrl: "/Main/events",
			controller: "patientController"
		})
                .when("/patient_list", {
			templateUrl: "/Main/patient_list",
			controller: "patientController"
		})
                .when("/doctor_home", {
			templateUrl: "/Main/doctor_home",
			controller: "adminController"
		})
                
                .when("/admin_home", {
			templateUrl: "/Main/admin_home",
			controller: "adminController"
		})
                .when("/admin_schedule", {
			templateUrl: "/Main/admin_home",
			controller: "adminController"
		})
                .when("/admin_staff", {
			templateUrl: "/Main/admin_staff",
			controller: "adminController"
		})
                .when("/admin_sms", {
			templateUrl: "/Main/admin_sms",
			controller: "adminController"
		})
            }

cfg.$inject = ["$routeProvider", "$locationProvider"];
app.config(cfg);

