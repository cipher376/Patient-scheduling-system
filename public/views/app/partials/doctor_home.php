
<div class="span8" ng-cloak="">
    <div class="widget-box">
        <div class="widget-title">
            <span class="icon"><i class="icon-th"></i></span> 
            <h5>Appointment List</h5>
        </div>
        <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Gender</th>                        
                        <th>Date of Birth</th>
                        <th>Service</th>
                        <th>Appointment Status</th>
                        <th>Action&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="gradeX" ng-repeat="sched in schedules_for_doctor ">
                        <td>{{isNullOrEmpty(getPatient(sched.user_id).fullname) ? getPatient(sched.user_id).email : getPatient(sched.user_id).fullname}}</td>
                        <td>{{getPatient(sched.user_id).gender}}</td>                 
                        <td>{{getPatient(sched.user_id).date_of_birth}}</td>
                        <td>{{getService(sched.service_id).title}}</td>
                        <td>{{sched.status}}</td>
                        <td>
                             <div class="span2">
                                <button ng-if="sched.status == 'asigned'" ng-click="post_result(sched)" class="btn btn-success btn-mini"
                                   style="width: 138px;" >Create Result</button>
                                <button style="width: 138px;"  ng-if="sched.status == 'ready'" 
                         class="btn btn-danger btn-mini" 
                        ng-click="scope.cancel_post_results(sched)">Cancel</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>



<script src="/public/assets/js/jquery.uniform.js"></script> 
<script src="/public/assets/js/select2.min.js"></script> 
<script src="/public/assets/js/jquery.dataTables.min.js"></script> 
<script src="/public/assets/js/maruti.js"></script> 
<script src="/public/assets/js/maruti.form_common.js"></script>
<script src="/public/assets/js/maruti.tables.js"></script>


