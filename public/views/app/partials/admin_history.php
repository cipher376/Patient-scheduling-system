<div class="span8" ng-cloak="">  
    <div class="widget-box">
        <div class="widget-title">
            <span class="icon"><i class="icon-th"></i></span> 
            <h5>Patient Schedule History</h5>
        </div>
        <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Service</th>
                        <th>Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="gradeX" ng-repeat="app in filteredSchedules" ng-if="app.status == 'honored'">
                        <td>{{isNullOrEmpty(getPatient(app.user_id).fullname) ? getPatient(app.user_id).email : getPatient(app.user_id).fullname}}</td>
                        <td>{{getService(app.service_id).title}}</td>
                        <td>{{getDoctor(app.doctor_id).working_hours}}</td>
                        <td>
                            <div class="span2">
                                <button ng-if="app.status == 'honored'"  class="btn btn-danger btn-mini" ng-click="cancelAppointment(app)">Delete</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div> 
</div>
