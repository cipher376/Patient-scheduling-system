

<div class = "span9" ng-cloak="">
    <div class = "span8" >
        <div class = "span12 widget-box">
            <div class = "widget-title">
                <h5>Select Date Appointment and Date Offer</h5>
            </div>
            <div class = "widget-content">

                <form id = "" class = "form-horizontal" action = "">
                    <div class = "control-group">
                        <label class = "control-label">Date</label>
                        <div class = "controls">
                            <input type = "text" data-date = "01/02/2018" id="schedule_date" 
                                   data-date-format = "dd/mm/yyyy" value = "{{currentDate}}" 
                                   class = "datepicker span11">
                        </div>
                    </div>
                    <div class = "control-group">
                        <label class = "control-label">Service</label>
                        <div class = "controls">
                            <select  id="schedule_service">
                                <option value="">Select</option>
                                <option ng-repeat="service in services" value="{{service.id}}">{{service.title}}</option>
                            </select>
                        </div>
                    </div>

                    <div class = "control-group">
                        <label class = "control-label">Doctor</label>
                        <div class = "controls">
                            <select id="schedule_doctor">
                                <option value="">Select</option>
                                <option ng-repeat="doctor in doctors" value="{{doctor.account.user_id}}">{{doctor.fullname}}({{doctor.specialty}})</option>
                            </select>
                        </div>

                        <div class = " form-actions">
                            <button type = "button" class = "btn btn-success"
                                    ng-click="sendAppointment()">Submit | Update</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <div class = "span4">
        <div class = "widget-box collapsible" >
            <div class = "widget-title"> <a data-toggle = "collapse" href = "#collapseTwo"> <span class = "icon"><i class = "icon-arrow-right"></i></span>
                    <h5>Lab Technicians</h5>
                </a>
            </div>
            <div id = "collapseTwo" class = "collapse">
                <div class = "widget-content">
                    <div class = "widget-content nopadding fix_hgt">
                        <ul class = "recent-posts">
                             <li ng-repeat="doctor in doctors|filter : 'Lab Technician'">
                                <div class = "user-thumb"> <img width = "40" height = "40" alt = "User" src = "img/demo/av1.jpg"> </div>
                                <div class = "article-post"><span class = "user-info"><h5>{{doctor.fullname}}</h5></span>
                                    <strong>Specialty: </strong>{{doctor.specialty}}<br>
                                    <p>Available Time:  <spam>{{doctor.working_hours}}</span> </p>
                                </div>
                            </li>
                            
                        </ul>
                    </div>
                </div>
            </div>

            <div class = "widget-title"> <a data-toggle = "collapse" href = "#collapseThree"> <span class = "icon"><i class = "icon-arrow-right"></i></span>
                    <h5>General physician</h5>
                </a>
            </div>
            <div id = "collapseThree" class = "collapse">
                <div class = "widget-content">
                    <div class = "widget-content nopadding fix_hgt">
                        <ul class = "recent-posts">
                            <li ng-repeat="doctor in doctors|filter : 'Physician'">
                                <div class = "user-thumb"> <img width = "40" height = "40" alt = "User" src = "img/demo/av1.jpg"> </div>
                                <div class = "article-post"><span class = "user-info"><h5>{{doctor.fullname}}</h5></span>
                                    <strong>Specialty: </strong>{{doctor.specialty}}<br>
                                    <p>Available from: <spam>{{doctor.working_hours.split("_")[0]}}</spam> to <span>{{doctor.working_hours.split("_")[1]}}</span> </p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class = "widget-title"> <a data-toggle = "collapse" href = "#collapseFour"> <span class = "icon"><i class = "icon-arrow-right"></i></span>
                    <h5>Mid-Wife</h5>
                </a>
            </div>
            <div id = "collapseFour" class = "collapse">
                <div class = "widget-content">
                    <div class = "widget-content nopadding fix_hgt">
                        <ul class = "recent-posts">
                            <li ng-repeat="doctor in doctors|filter : 'Mid-Wife'">
                                <div class = "user-thumb"> <img width = "40" height = "40" alt = "User" src = "img/demo/av1.jpg"> </div>
                                <div class = "article-post"><span class = "user-info"><h5>{{doctor.fullname}}</h5></span>
                                    <strong>Specialty: </strong>{{doctor.specialty}}<br>
                                    <p>Available from: <spam>{{doctor.working_hours.split("_")[0]}}</spam> to <span>{{doctor.working_hours.split("_")[1]}}</span> </p>
                                </div>
                            </li>
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class = "widget-box">
        <div class = "widget-title">
            <span class = "icon">
                <i class = "icon-file"></i>
            </span>
            <h5>Most Recent Appointment</h5>
        </div>
        <div class = "widget-content nopadding" ng-if="schedules.length>0">
            <ul class = "recent-posts">
                <li>
                    <div class = "article-post">
                        <div class = "fr"><a class = "btn btn-danger btn-mini" ng-click="cancelAppointment(reverseArray(schedules)[0])">Cancel</a></div>
                        <div class = "fr"><a class = "btn btn-success btn-mini" ng-click="clearScheduleFields()">Reschedule</a></div>
                        <span class = "user-info"><h5> Meet Dr. {{getDoctorByAppointment(reverseArray(schedules)[0].doctor_id).fullname}}({{getDoctorByAppointment(reverseArray(schedules)[0].doctor_id).specialty}}) for
                                {{getServiceByAppointment(reverseArray(schedules)[0].service_id).title}} on  Date: {{reverseArray(schedules)[0].date}} / {{getDoctorByAppointment(reverseArray(schedules)[0].doctor_id).working_hours}} </h5></span>
                        
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>


  <script src="/public/assets/js/bootstrap-datepicker.js"></script> 
     <script src="/public/assets/js/maruti.form_common.js"></script>
        <script src="/public/assets/js/maruti.dashboard.js"></script> 
