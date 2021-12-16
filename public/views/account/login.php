<!DOCTYPE html>
<html lang="en" ng-app="app">

    <head>
        <title>Online Patient Scheduling System</title><meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="/public/assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="/public/assets/css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="/public/assets/css/maruti-login.css" />

        <style>
            #loginbox {
                padding-top: 12.7em;
                overflow: hidden !important;
                text-align: left;
                position: relative;
                padding-bottom: 35em;
                overflow: hidden;
            }
            @media (max-width: 767px) {
                body {
                    padding: 0 !important;
                }
                .container-fluid {
                    padding-left: 0px;
                    padding-right: 0px;
                }
                #search { display: none; }
                #user-nav > ul > li > a > span.text {
                    display: none;
                }
            }
        </style>
    </head>
    <body  ng-controller="mainController" style="overflow:hidden">
        <div data-vide-bg="/public/assets/video/keyboard">
            <div class="main-container">
                <div id="loginbox"  ng-controller="accountController">            
                    <form id="loginform" class="form-vertical">
                        <div class="control-group normal_text"> <h3>Sign In</h3></div>
                        <div class="control-group">
                            <div class="controls">
                                <div class="main_input_box">
                                    <span class="add-on"><i class="icon-user"></i></span>
                                    <input type="email" placeholder="Email" ng-model='user.email'/>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <div class="main_input_box">
                                    <span class="add-on"><i class="icon-lock"></i></span>
                                    <input type="password" placeholder="Password" ng-model='user.password'/>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions"> 
                            <span class="" style="margin-left:20%"><a class="flip-link btn btn-success" ng-click="login()" value="Login">&nbsp;&nbsp;Login &nbsp;&nbsp;&nbsp;</a></span>
                            <span class="" style="margin-left: 22%;">
                                <a href="/Account/register" class=" flip-link btn  btn-info" id="to-recover">Register</a>
                            </span>
                        </div>
                    </form>


                </div>

            </div>
        </div>

        <style type="text/css">
            .image:hover{
                opacity: 0.5;
                background-color:#000000;
            }
        </style>
        <!--===============================================================================================-->
        <script src="/public/assets/vendor/jquery/jquery.min.js"></script>
        <!--===============================================================================================-->
        <script src="/public/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
        <!--===============================================================================================-->
        <script  srcf="/public/assets/vendor/sweetAlert/sweetalert.min.js" ></script>
        <script  src="/public/assets/vendor/notify-js/notify.min.js" ></script>

        <script src="/public/assets/vendor/angular/angular.min.js"></script> 
        <script src="/public/assets/vendor/angular/angular-resource.min.js"></script>     
        <script src="/public/assets/vendor/angular/angular-route.min.js"></script> 
        <script src="/public/assets/vendor/angular/angular-datepicker.min.js"></script> 
        <script src="/public/assets/vendor/angular/ng-file-upload-shim.min.js" type="text/javascript"></script>
        <script src="/public/assets/vendor/angular/ng-file-upload.min.js" type="text/javascript"></script>

        <script src="/public/assets/custom/config.js"></script>
        <script src="/public/assets/custom/controllers/mainController.js"></script>
        <script src="/public/assets/custom/Factories/accountFactory.js"></script> 
        <script src="/public/assets/custom/services/accountService.js"></script>   
        <script src="/public/assets/custom/services/staffService.js"></script>    
        <script src="/public/assets/custom/services/hospitalService.js"></script> 
        <script src="/public/assets/custom/services/messageService.js"></script> 
         <script src="/public/assets/custom/Factories/messageFactory.js"></script>

        <script src="/public/assets/custom/controllers/accountController.js"></script> 
        <script src="/public/assets/custom/Factories/staffFactory.js"></script> 

        <script src="/public/assets/vendor/jquery-vid/jquery.vide.min.js"></script>

    </body>

</html>
