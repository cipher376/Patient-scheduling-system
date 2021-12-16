
<!--PROFILE-->
<div class = "span9">

    <div class = "row-fluid">
        <div class = "span4">
            <div class = "widget-box">
                <div class = "widget-content">
                    <img style="
                         width: 50%;
                         margin-left:  25%;
                         " ng-src = "{{profileImageUrl.toLowerCase()}}" alt = "Profile Image">
                </div>
            </div>
        </div>

        <div class = "span8">
            <div class = "widget-box span12">
                <div class = "widget-title span12">
                    <span class = "icon">
                        <i class = "icon-th-list"></i>
                    </span>
                    <h5>Personal Information</h5>
                </div>

                <div class = "widget-content span11">
                    <div class = "span10">
                        <label>Name:</label>
                        <strong class = "">{{user.fullname}}</strong>
                    </div>
                </div><br>

                <div class = "widget-content span11">
                    <div class = "span6">
                        <label>Date of birth</label>
                        <strong class = "">{{user.date_of_birth}}</strong>
                    </div>

                    <div class = "span6">
                        <label>Gender</label>
                        <strong class = "">{{user.gender}}</strong>
                    </div>
                </div>

                <div class = "widget-content span11">
                    <div class = "span6">
                        <label>Email</label>
                        <strong class = "">{{user.email}}</strong>
                    </div>

                    <div class = "span6">
                        <label>Username</label>
                        <strong class = "">{{user.username}}</strong>
                    </div>
                </div>


                <div class = "widget-content span11">
                    <div class = "span6">
                        <label>Address</label>
                        <strong class = "">{{user.address}}</strong>
                    </div>

                    <div class = "span6">
                        <label>Contact</label>
                        <strong class = "">{{user.phone}}</strong>
                    </div>
                </div>

                <div class = "widget-content span11">

                    <div class = "span6">
                        <label>Company Information</label>
                        <strong class = "">{{user.company}}</strong>
                    </div>
                </div>
                <div class="form-actions" ng-if="user_is_in('Admin') || user_is_in('Doctor')">
                    <button type="button" class="btn btn-info right"
                            style="float:right" ng-click="updateAdminProfile()">Update</button>
                </div>
                <div class="form-actions" ng-if="user_is_in('Default')">
                    <button type="button" class="btn btn-success right"
                            style="float:right" ng-click="updateProfile()">Update</button>
                </div>
            </div>
        </div>

    </div>
</div>