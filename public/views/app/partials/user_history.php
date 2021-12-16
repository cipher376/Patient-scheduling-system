

<div class = "span9">


<!--HISTORY-->
<div class = "widget-box">
    <div class = "widget-title">
        <span class = "icon"><i class = "icon-repeat"></i></span>
        <h5>Previous Schedules</h5>
    </div>
    <div class = "widget-content nopadding">
        <ul class = "activity-list">
            <li ><a class = "" ng-repeat="app in reverseArray(schedules)">
                    <span>{{$index+1}}</span>
                    You booked a/an <strong>{{getServiceByAppointment(app.service_id).title}} appointment
                    </strong> with doctor <strong> {{getDoctorByAppointment(app.doctor_id).fullname}}({{getDoctorByAppointment(app.doctor_id).specialty}})</strong> 
                    <strong> Date:</strong> <span>{{app.date}}</span>
                </a>
            </li>
            
        </ul>
    </div>
</div> 

</div>