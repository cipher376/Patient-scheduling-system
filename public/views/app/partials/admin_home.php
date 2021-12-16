<div class="span8" ng-cloak="">  
    <div class="widget-box">
        <div class="widget-title">
            <span class="icon"><i class="icon-th"></i></span> 
            <h5>Data table</h5>
        </div>
        <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Service</th>
                        <th>Preferred Doctor</th>
                        <th>Time</th>
                        <th>Assigned  </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="gradeX" ng-repeat="app in filteredSchedules" ng-if="app.status !== 'ready'">
                        <td>{{isNullOrEmpty(getPatient(app.user_id).fullname) ? getPatient(app.user_id).email : getPatient(app.user_id).fullname}}</td>
                        <td>{{getService(app.service_id).title}}</td>
                        <td>{{getDoctorByUserId(app.doctor_id).fullname}}</td>
                        <td>{{getDoctorByUserId(app.doctor_id).working_hours}}</td>
                        <td>
                            <div class="controls span10">
                                <select  ng-model="app.doctor">
                                    <option  ng-repeat="doc in doctors" value="{{doc}}" ng-if="!isNullOrEmpty(doc.fullname)">{{doc.fullname}} ({{doc.specialty}})</option>
                                </select>
                            </div>
                            <div class="span2">
                                <button ng-if="app.status == 'pending'"  class="btn btn-success btn-mini" ng-click="postToDoctor(app)">Send</button>
                                <button ng-if="app.status == 'assigned'"  class="btn btn-danger btn-mini" ng-click="cancelPostToDoctorAction(app)">Cancel</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div> 
</div>
