<div class="col-lg-12 col-md-12">
    <div class="card">
        <div class="header">
            <h5 class="title">Notifications</h5>
        </div>
        <div class="content">
            <div class="row">
                <div class="content table-responsive table-full-width" style="height: 500px; overflow-y: scroll;">
                    <table class="table table-striped">
                        <thead>
                        <th>SN</th>                        
                        <th>Date/Time</th>
                        <th>Action</th>
                        <th>Performed by</th>
                        </thead>
                        <tbody>
                            <tr ng-repeat="note in notifications" style="cursor:pointer"
                                ng-click="showNotification('left', 'right')">
                                <td>{{$index + 1}}</td>
                                <td>{{note.note_time}}</td>
                                <td>{{note.message}}</td>   
                                <td>{{note.user_name}}</td>
                                <td><span style="color:green" >
                                        <button ng-click="markNotificationAsViewed(note)">
                                            <i class="ti-check-box"></i>
                                        </button>
                                    </span>
                                    <span ng-if="note.viewed_users.indexOf(user.uid) < 0">
                                        <span style="color:green">new</span>
                                    </span>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>
</div>

<!--<div class="col-lg-6 col-md-6">
    <div class="card">
        <div class="header">
            <h5 class="title">Notification Details</h5>
        </div>
        <div class="content" >
            <div class="alert alert-info">
                <span>This is a plain notification</span>
            </div>
        </div>
    </div>
    =
</div>-->