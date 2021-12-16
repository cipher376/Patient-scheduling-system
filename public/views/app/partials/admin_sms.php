<div class="span8" ng-cloak="">
    <div class="widget-box">
        <div class="widget-title">
            <span class="icon"><i class="icon-th"></i></span> 
            <h5>Patient Reports</h5>
        </div>
        <div class="widget-content nopadding">
            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Service</th>
                        <th>Phone</th>  
                        
                    </tr>
                </thead>
                <tbody>
                    <tr class="gradeX link" data-toggle="modal"
                        data-target="#mailModal" style="cursor: pointer"
                        ng-repeat="sched in filter_schedule_to_reply()" >
                        <td >{{isNullOrEmpty(getPatient(sched.user_id).fullname) ? getPatient(sched.user_id).email : getPatient(sched.user_id).fullname}}</td>
                        <td >{{getService(sched.service_id).title}}</td>
                        <td >{{getPatient(sched.user_id).phone}}<button class="btn btn-info btn-xs" style="float:right" ng-click="setCurrentSchedule(sched)">Post</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="mailModal" tabindex="-1" role="dialog" aria-labelledby="mailModalLabel" aria-hidden="true" height="auto" style="z-index">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Compose Result</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><strong>Patient Name | Email</strong></label>
                        <input disabled="disabled" type="text" 
                               class="form-control span12" value="{{isNullOrEmpty(getPatient(schedule.user_id).fullname) ? getPatient(schedule.user_id).email : getPatient(schedule.user_id).fullname}}"
                               id="" aria-describedby="" placeholder="Patient Name"><br>
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <label for="exampleInputEmail1"><strong>Attach Result</strong></label>
                    <style>
                        .drop-box {
                            background: #F8F8F8;
                            border: 5px dashed #DDD;
                            width: 20%;
                            height: 100px;
                            text-align: center;
                            padding: 0px; 
                            margin-left: 2%; 
                            font-size: small; 
                        }   
                        .preview {
                            margin-left: 31%;
                            clear: both;
                            text-align: center;
                            margin-top: -87px;
                            width: 50%;
                        }
                        .preview img, .preview audio, .preview video {
                            max-width: 293px;
                            max-height: 94px;
                            margin-top: -17%;
                        }
                    </style>
                    <div class="form-group">
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
                            <span ng-show="dropAvailable">or Drop</span> to upload result if any
                        </div>
                        <div class="preview form-group">
                            <div>Preview</div>
                            <img class=''ngf-src="!files[0].$error && files[0]">
                        </div>
                    </div>
                    <div class="form-group" style="
                         margin-top: 80px;
                         ">
                        <label for="content"><strong>Message: </strong></label>
                        <textarea  placeholder="Message" 
                                  class="form-control message_content" rows="0" 
                                   style="margin: 0px;width: 400px; min-height: 88px;"
                                   ></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"  ng-click="clearMsg()">Close</button>
                <button type="button" class="btn btn-primary"  ng-click="sendResult()">Send Result</button>
            </div>
        </div>
    </div>
</div>

<script src="/public/assets/js/jquery.uniform.js"></script> 
<script src="/public/assets/js/select2.min.js"></script> 
<script src="/public/assets/js/jquery.dataTables.min.js"></script> 
<script src="/public/assets/js/maruti.js"></script> 
<script src="/public/assets/js/maruti.form_common.js"></script>
<script src="/public/assets/js/maruti.tables.js"></script>

