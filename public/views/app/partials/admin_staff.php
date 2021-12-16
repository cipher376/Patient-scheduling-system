

<div class="span8" ng-cloak="">
    <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
            <h5>Personal-info</h5>
        </div>
        <div class="widget-content nopadding">
            <form action="#" method="get" class="form-horizontal">

                <h5 class="text-center">Account Details</h5>

                <div class="control-group">
                    <label class="control-label">Email</label>
                    <div class="controls">
                        <input type="email" class="span11"  
                               placeholder="Email" ng-model='staff.account.email'/>

                    </div>
                </div>       

                <div class="control-group">
                    <label class="control-label">Password</label>
                    <div class="controls">
                        <input type="password" class="span11"  
                               placeholder="Password" ng-model='staff.account.password'/>

                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Confirm</label>
                    <div class="controls">
                        <input type="password" class="span11"  placeholder="Password" ng-model='staff.account.confirmpassword'/>
                    </div>
                </div>

                <hr>

                <h5 class="text-center">Personal Details</h5>

                <div class="control-group">
                    <label class="control-label">Full Name</label>
                    <div class="controls">
                        <input type="text" class="span11" 
                               placeholder="fullname" ng-model="staff.fullname">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Gender</label>
                    <div class="controls">
                        <select id="staff_gender">
                            <option value=""></option>  
                            <option >Male</option>
                            <option>Female</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Date of Birth</label>
                    <div class="controls">
                        <input type = "text" data-date = "01-02-2018"  id="staff_dob"
                               data-date-format = "dd-mm-yyyy" value = "01-02-2018" 
                               class = "datepicker span11" >
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Address :</label>
                    <div class="controls">
                        <input type="text" class="span11" placeholder="Address"
                               ng-model="staff.address">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Contact No:</label>
                    <div class="controls">
                        <input type="text" class="span11" placeholder="+233xxxxxxxxx"
                               ng-model="staff.phone">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Company info :</label>
                    <div class="controls">
                        <input type="text" class="span11" placeholder="Company name"
                               ng-model="staff.company">
                    </div>
                </div>
                <hr>

                <h5 class="text-center"">Work Details</h5>

                <div class="control-group" >
                    <label class="control-label">Specialty</label>
                    <div class="controls">
                        <select id="staff_specialty">
                            <option>Admin</option>
                            <option>Physician</option>
                            <option>Lab Technician</option>
                            <option>Mid-Wife</option>
                            <option>Surgeon</option>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Working Hours</label>
                    <div class="controls">
                        <input type="text" class="span11" placeholder="From - To"
                             ng-model="staff.working_hours">
                    </div>
                </div>

                <!--Uploading image-->
               
                <div ngf-select ngf-drop ng-model="files" ngf-model-invalid="invalidFiles"
                     ngf-model-options="modelOptionsObj"
                     ngf-multiple="multiple" ngf-pattern="pattern" ngf-accept="acceptSelect"
                     ng-disabled="disabled" ngf-capture="capture"
                     ngf-drag-over-class="dragOverClassObj"
                     ngf-validate="validateObj"
                     ngf-resize="resizeObj"
                     ngf-resize-if="resizeIfFn($file, $width, $height)"
                     ngf-dimensions="dimensionsFn($file, $width, $height)"
                     ngf-duration="durationFn($file, $duration)"
                     ngf-keep="keepDistinct ? 'distinct' : keep"
                     ngf-fix-orientation="orientation"
                     ngf-max-files="maxFiles"
                     ngf-ignore-invalid="ignoreInvalid"
                     ngf-run-all-validations="runAllValidations"
                     ngf-allow-dir="allowDir" class="drop-box" ngf-drop-available="dropAvailable">Click 
                    <span ng-show="dropAvailable">or Drop</span> to upload passport picture
                </div>
                <div class="preview form-group">
                    <div>Preview</div>
                    <img class='' ngf-src="!files[0].$error && files[0]">
                </div>
               
                <!--End of uploads-->

                <div class="form-actions">
                    <button type="button" class="btn btn-danger right"
                            style="float:right" ng-click="resetStaff()">Reset</button>
                    <button type="button" class="btn btn-success right"
                            style="float:right" ng-click="addStaff()">Add Staff</button>
                </div>
            </form>
        </div>
    </div>
</div>




<script src="/public/assets/js/bootstrap-datepicker.js"></script> 
<script src="/public/assets/js/maruti.form_common.js"></script>
<script src="/public/assets/js/maruti.dashboard.js"></script> 
