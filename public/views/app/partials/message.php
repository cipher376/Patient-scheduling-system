<!--MESSAGE-->
<div class = "span9" ng-cloak="">
    <div class = "widget-box widget-chat">
        <div class = "widget-title"> <span class = "icon"> <i class = "icon-comment"></i> </span>
            <h5></h5>
        </div>
        <div class = "widget-content nopadding">
            <div class = "chat-users panel-right2">
                <div class = "panel-title">
                    <h5>Messages</h5>
                </div>

                <div class = "panel-content nopadding">
                    <ul class = "contact-list">
                        <style>
                            h5#mail{
                                font-size: 11px;
                                padding: 0px;
                                margin: 0;
                                margin-top: 0px;
                                text-align: center;
                                margin-top: -19px;
                            }
                        </style>
                        <li id = "user-Sunil" class = "online"
                            ng-repeat="msg in reverseArray(messages)" ng-click="readMessage(msg)" ng-click="">
                            <a>
                                <span class = "icon" style="font-size: 13px"><i class="icon-envelope"></i></span>
                                <h5 id="mail"> {{msg.title}} </h5>
                                <p><small style="float: right;">{{msg.date}}</small></p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class = "chat-content panel-left2">
                <div class = "chat-messages" id = "chat-messages" ng-if="!isNullOrEmpty(message.id)" style="padding-left: 0;
                     padding-top: 3%;">
                    <div id = "chat-messages-inner" >
                        <style>
                            .m-header {
                                background: #bbecf9;
                                padding: 3%;
                            }
                        </style>
                        <div class="m-header">
                            <b>From:   </b><span class = "docname">{{message.sender_name}} ({{message.sender_email}})</span><br>
                            <p><b>Date:</b>  <span class = "msgtitle">{{message.date}}</span></p>
                            <p><b>Title:</b>  <span class = "msgtitle">{{message.title}}</span></p>
                        </div>
                        <p style="background: #bbecf9; padding: 5%;
                           }">
                            {{message.content}}
                        </p>
                        <div style="margin-left: 25%" ng-if="!isNullOrEmpty(message.attachment)">
                            <h5>Attachment <small>(Report)<small></h5> 
                        <button class="btn btn-success  " ng-click="downloadReport()">
                            Download
                        </button>
                        </div>
                    </div>
                </div>
                <div class = "chat-messages" ng-if="isNullOrEmpty(message.id)">
                    <h4 style="margin-top: 30%; text-align: center; color: #86ceefb3;">Select Message</h4>
                </div>
            </div>
        </div>
    </div>
</div>