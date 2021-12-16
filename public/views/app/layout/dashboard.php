<!DOCTYPE html>
<html lang="en" ng-app="app">
    <head>
        <style>
            [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
                display: none !important;
            }
        </style>

        <title>Online Scheduling System</title><meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="/public/assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="/public/assets/css/bootstrap-responsive.min.css" />     
        <link rel="stylesheet" href="/public/assets/vendor/sweetAlert/sweetalert.css" />

        <link rel="stylesheet" href="/public/assets/css/fullcalendar.css" />
        <link rel="stylesheet" href="/public/assets/css/colorpicker.css" />
        <link rel="stylesheet" href="/public/assets/css/datepicker.css" />
        <link rel="stylesheet" href="/public/assets/css/uniform.css" />
        <link rel="stylesheet" href="/public/assets/css/select2.css" />
        <link rel="stylesheet" href="/public/assets/css/maruti-style.css" />
        <link rel="stylesheet" href="/public/assets/css/maruti-media.css" class="skin-color" />       
        <link rel="stylesheet" href="/public/assets/css/style.css" class="skin-color" />



        <base href="/Main"/>

        <!-- *****************************vendor***********************************-->
        <script src="/public/assets/js/excanvas.min.js"></script> 
        <script src="/public/assets/js/jquery.min.js"></script> 
        <script src="/public/assets/js/jquery.ui.custom.js"></script> 
        <script src="/public/assets/js/bootstrap.min.js"></script> 
        <script src="/public/assets/js/jquery.ui.custom.js"></script> 
        <script src="/public/assets/js/bootstrap-colorpicker.js"></script>
        <script src="/public/assets/js/bootstrap-datepicker.js"></script> 
        <script src="/public/assets/js/jquery.uniform.js"></script> 
        <script src="/public/assets/js/select2.min.js"></script> 
        <script src="/public/assets/js/jquery.flot.min.js"></script> 
        <script src="/public/assets/js/jquery.flot.resize.min.js"></script> 
        <script src="/public/assets/js/jquery.peity.min.js"></script> 
        <script  srcf="/public/assets/vendor/sweetAlert/sweetalert.min.js" ></script>
        <script  src="/public/assets/vendor/notify-js/notify.min.js" ></script>

        <!--<script src="/public/assets/js/fullcalendar.min.js"></script>--> 


        <script src="/public/assets/vendor/angular/angular.min.js"></script> 
        <script src="/public/assets/vendor/angular/angular-resource.min.js"></script>     
        <script src="/public/assets/vendor/angular/angular-route.min.js"></script> 
        <script src="/public/assets/vendor/angular/angular-datepicker.min.js"></script> 
        <script src="/public/assets/vendor/angular/ng-file-upload-shim.min.js" type="text/javascript"></script>
        <script src="/public/assets/vendor/angular/ng-file-upload.min.js" type="text/javascript"></script>

        <!--*****************************Custom***********************************-->
        <script src="/public/assets/custom/config.js"></script> 
        <script src="/public/assets/custom/Factories/accountFactory.js"></script> 
        <script src="/public/assets/custom/Factories/staffFactory.js"></script> 
        <script src="/public/assets/custom/Factories/patientFactory.js"></script> 
        <script src="/public/assets/custom/Factories/hospitalFactory.js"></script>
        <script src="/public/assets/custom/Factories/messageFactory.js"></script>

        <script src="/public/assets/custom/services/accountService.js"></script>        
        <script src="/public/assets/custom/services/staffService.js"></script> 
        <script src="/public/assets/custom/services/hospitalService.js"></script> 
        <script src="/public/assets/custom/services/patientService.js"></script> 
        <script src="/public/assets/custom/services/messageService.js"></script> 

        <script src="/public/assets/custom/controllers/homeController.js"></script>    
        <script src="/public/assets/custom/controllers/patientController.js"></script> 
        <script src="/public/assets/custom/controllers/adminController.js" ></script>
        <script src="/public/assets/custom/controllers/mainController.js"></script>  


        <!--*****************************Native***********************************-->
        <script src="/public/assets/js/maruti.js"></script> 
        <!--<script src="/public/assets/js/maruti.calendar.js"></script>--> 
        <!--<script src="/public/assets/js/maruti.form_common.js"></script>-->
        <!--<script src="/public/assets/js/maruti.dashboard.js"></script>--> 

        <style>
            #header h1 {
                background: url(/public/assets/img/edited_opss_logo.png) no-repeat scroll 0 0 transparent;
                height: 31px;
                left: 15px;
                line-height: 600px;
                overflow: hidden;
                position: relative;
                top: 20px;
                width: 191px;
                border-radius: 10px;
            }

            .fileUpload {
                position: relative;
                overflow: hidden;
            }
            .fileUpload input.upload {
                position: absolute;
                top: 0;
                right: 0;
                margin: 0;
                padding: 0;
                font-size: 20px;
                cursor: pointer;
                opacity: 0;
                filter: alpha(opacity=0);
            }


        </style>

    </head>
    <body ng-controller="mainController" ng-cloak="">

        <!--Header-part-->
        <div id="header">
            <h1><a href="/Main/">Online Scheduling System</a></h1>
        </div>
        <!--close-Header-part--> 

        <!--top-Header-messaages-->
        <div class="btn-group rightzero"> <a class="top_message tip-left" title="Manage Files">
                <i class="icon-file"></i></a> <a class="top_message tip-bottom" title="Manage Users"><i class="icon-user"></i></a> 
            <a class="top_message tip-bottom" title="Manage Comments"><i class="icon-comment"></i>
                <span class="label label-important">5</span></a> <a class="top_message tip-bottom" title="Manage Orders">
                <i class="icon-shopping-cart"></i></a> </div>
        <!--close-top-Header-messaages--> 

        <!--top-Header-menu-->
        <div id="user-nav" class="navbar navbar-inverse">
            <ul class="nav">
                <!--   
                <li class="" ><a title="" href="#"><i class="icon icon-user"></i> <span class="text">Profile</span></a></li>
                  <li class=" dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="icon icon-envelope"></i> <span class="text">Messages</span> <span class="label label-important">5</span> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li><a class="sAdd" title="" href="#">new message</a></li>
                      <li><a class="sInbox" title="" href="#">inbox</a></li>
                      <li><a class="sOutbox" title="" href="#">outbox</a></li>
                      <li><a class="sTrash" title="" href="#">trash</a></li>
                    </ul>
                  </li>
                <li class=""><a title="" href="#"><i class="icon icon-cog"></i> <span class="text">Settings</span></a></li> 
                -->
                <li class=""><a title="" ng-click="logout()" style="cursor:pointer"><i class="icon icon-share-alt"></i> <span class="text">Logout</span></a></li>
            </ul>
        </div>

        <!--        <div id="search" ng-if="!user_is_in('default')">
                    <input type="text" placeholder="Search here..."/>
                    <button type="submit" class="tip-left" 
                            ng-model="search_key"   title="Search">
                        <i class="icon-search icon-white"></i></button>
                </div>
                close-top-Header-menu-->


        <div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
            <ul>
                <li class="active"><a href="/Main/#!/user_schedule"><i class="icon icon-home"></i> <span>Home</span></a> </li>
                <li> <a href="/Main/#!/services"><i class="icon icon-th-list"></i> <span>Service</span></a> </li>
                <li> <a href="/Main/#!/about"><i class="icon-info-sign"></i> <span>About</span></a> </li>
                <li><a href="/Main/#!/contact"><i class="icon icon-book"></i> <span>Contact</span></a></li>
            </ul>
        </div>

        <div id="content">
            <div id="content-header">
                <div id="breadcrumb"></div>
                <style>
                    h3#h-title{
                        margin-top: -1px;
                        background: #1799d5;
                        margin-left: 0;
                        padding-left: 7%;
                        color: white;
                        text-shadow: 0 1px 0 #914949;
                    }
                </style>
                <h3 ng-cloak="" id="h-title">{{page_title}}</h3>
            </div>


            <div class="container-fluid">
                <div class="row-fluid">
                    <!--Admin menu-->
                    <div class="span3" ng-if="user_is_in('admin')" style="margin-right:2%">
                        <div class="widget-box" >
                            <ul class="quick-actions">
                                <li> <a href="/Main/#!/admin_schedule"> <i class="icon-calendar active"></i>Schedule List</a> </li>
                                <li> <a href="/Main/#!/admin_sms"> <span class = "icon"><i class="icon-plane"></i></span>Post Result</a> </li>
                                <li> <a href="/Main/#!/message"> <i class="icon-mail"></i>In-Box</a> </li>
                                <li> <a href="/Main/#!/admin_staff"> <i class="icon-book"></i>Staff Registration</a> </li>
                                <li> <a href="/Main/#!/profile"> <i class="icon-people"></i>Profile </a> </li>
                                <li> <a href="/Main/#!/patient_history"> <i class="icon-survey"></i>Patient History </a> </li>
                            </ul>
                        </div>
                    </div>
                    <!--Doctor's menu-->
                    <div class="span3" ng-if="user_is_in('doctor')">
                        <div class="widget-box">
                            <ul class="quick-actions">
                                <li> <a href="/Main/#!/doctor_home"> <i class="icon-calendar active"></i>Schedule List</a> </li>
                                <li> <a href="/Main/#!/message"> <i class="icon-mail"></i>Messages</a> </li>
                                <li> <a href="/Main/#!/profile"> <i class="icon-people"></i>Profile </a> </li>
                            </ul>
                        </div>
                    </div>
                    <!--Patient menu-->

                    <div class="span3" ng-if="user_is_in('default')">
                        <div class="widget-content">
                            <ul class="quick-actions">
                                <li> <a href="/Main/#!/user_schedule"> <i class="icon-calendar active"></i>Service</a> </li>
                                <li> <a href="/Main/#!/message"> <i class="icon-mail"></i>Messages</a> </li>
                                <li> <a href="/Main/#!/profile"> <i class="icon-people"></i>Profile </a> </li>
                                <li> <a href="/Main/#!/user_history"> <i class="icon-survey"></i> History </a> </li>
                            </ul>
                        </div>
                    </div>


                    <ng-view> </ng-view>


                </div>
            </div>
            <hr>
        </div>
    </div>
    <div class="row-fluid">
        <div id="footer" class="span12"> 2018 &copy;  Student project, by Charles Amadi </div>
    </div>




</body>

</html>
