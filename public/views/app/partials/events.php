
<div class="span3">
           <div class="widget-box">
              <ul class="quick-actions">
              <li> <a href="#!/patient_list"> <i class="icon-calendar active"></i>Schedule List</a> </li>
              <li> <a href="#!/user_message"> <i class="icon-mail"></i>Messsages</a> </li>
            </ul>
        </div>
        </div>
<div class="span9">
            <div class="widget-box widget-calendar">
              
                            <div class="widget-title">
                <span class="icon"><i class="icon-calendar"></i></span>
                <h5>Calendar</h5>
                
                                <div class="buttons">
                  <a id="add-event" data-toggle="modal" href="#modal-add-event" class="btn btn-inverse btn-mini"><i class="icon-plus icon-white"></i> Add new event</a>
                  <div class="modal hide" id="modal-add-event">
                     <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">×</button>
                      <h3>Add a new event</h3>
                    </div>
                    <div class="modal-body">
                      <p>Enter event name:</p>
                      <p><input id="event-name" type="text" /></p>
                    </div>
                    <div class="modal-footer">
                      <a href="#" class="btn" data-dismiss="modal">Cancel</a>
                      <a href="#" id="add-event-submit" class="btn btn-primary">Add event</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="widget-content">
                <div class="panel-left">
                  <div id="fullcalendar"></div>
                </div>
                <div id="external-events" class="panel-right">
                  <div class="panel-title"><h5>Drag Events to the calander</h5></div>
                  <div class="panel-content">
                    <div class="external-event ui-draggable label label-inverse">My Event 1</div>
                                        <div class="external-event ui-draggable label label-inverse">My Event 2</div>
                                        <div class="external-event ui-draggable label label-inverse">My Event 3</div>
                                        <div class="external-event ui-draggable label label-inverse">My Event 4</div>
                                        <div class="external-event ui-draggable label label-inverse">My Event 5</div>
                  </div>
                </div>
              </div>
            </div>
          </div>

