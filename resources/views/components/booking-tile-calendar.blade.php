<section class="tile booking-tile-calendar">
    <div class="tile-header dvd dvd-btm">
        <h1 class="custom-font">{{ $title }}</h1>
        <ul class="controls">
            <li class="hidden">
                <a role="button" tabindex="0" class="pickDate">
                    <span></span>&nbsp;&nbsp;<i class="fa fa-angle-down"></i>
                </a>
            </li>
            <li class="dropdown">

                <a role="button" tabindex="0" class="dropdown-toggle settings" data-toggle="dropdown">
                    <i class="fa fa-cog"></i>
                    <i class="fa fa-spinner fa-spin"></i>
                </a>

                <ul class="dropdown-menu pull-right with-arrow animated littleFadeInUp">
                    <li>
                        <a role="button" tabindex="0" class="tile-toggle">
                            <span class="minimize"><i class="fa fa-angle-down"></i>&nbsp;&nbsp;&nbsp;Minimize</span>
                            <span class="expand"><i class="fa fa-angle-up"></i>&nbsp;&nbsp;&nbsp;Expand</span>
                        </a>
                    </li>
                    <!--
                    <li>
                        <a role="button" tabindex="0" class="tile-refresh">
                            <i class="fa fa-refresh"></i> Refresh
                        </a>
                    </li>
                    -->
                    <li>
                        <a role="button" tabindex="0" class="tile-fullscreen">
                            <i class="fa fa-expand"></i> Fullscreen
                        </a>
                    </li>
                </ul>

            </li>
            @if(!empty($add_href))
            <li class="add"><a role="button" tabindex="0" class="tile-add" href='{{ $add_href }}'><i class="fa fa-plus"></i></a></li>
            @endif
        </ul>
    </div>
    <!--
    <td>
        <div class="progress-xxs not-rounded mb-0 inline-block progress" style="width: 150px; margin-right: 5px">
            <div class="progress-bar progress-bar-greensea" role="progressbar" aria-valuenow="42" aria-valuemin="0" aria-valuemax="100" style="width: 42%;"></div>
        </div>
        <small>42%</small>
    </td>
    -->
    <div class="tile-body">
        <div class='booking-calendar col-xs-12 col-md-4'></div>
        <div class="booking-datatable col-xs-12 col-md-8">
            @component('components.datatable', ['tabledata' => $tabledata])

            @endcomponent
        </div>
        <div class="cleaner"></div>
    </div>
</section>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) { 
        var init = true;
        $('.booking-calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaDay'
            },
            defaultView: 'agendaDay',
            height: 500,
            locale: 'fr',
            columnFormat: 'dddd D/MM/YYYY',
            allDaySlot: false,
            displayEventTime: false,
            slotLabelFormat: 'HH:mm',
            minTime: '9:00',
            businessHours: [
                {
                    dow: [ 1, 2, 3, 4, 5], 
                    start: '09:00', 
                    end: '22:00' 
                },
                {
                    dow: [ 6, 7 ], 
                    start: '10:00', 
                    end: '16:00' 
                }
            ],
            events: {
                url: '/admin/booking/calendarFeed',
                type: 'POST',
                data: {
                },
                error: function() {
                    alert('there was an error while fetching events!');
                },
            },
            eventRender: function(event, element) {
                element.find('.fc-title').append("<span class='glyphicon glyphicon-user' aria-hidden='true'></span>");
            },
            eventClick: function(calEvent, jsEvent, view) {
                var params = {id_booking: calEvent.id};
                $('#<?php echo $tabledata['id'];?>').trigger('reload', params);
            },
            viewRender: function(view, element){
//                console.log(view);
                if(init){
                    init = false;
                } else {
                    var start = $.fullCalendar.moment(view.currentUnzonedRange.startMs).format();
                    var end = $.fullCalendar.moment(view.currentUnzonedRange.endMs).format();
                    var params = {start: start, end: end};
                    $('#<?php echo $tabledata['id'];?>').trigger('reload', params);
                }
            },
            resourceRender: function(resourceObj, labelTds, bodyTds) {
                console.log(resourceObj);
                console.log(labelTds);
                console.log(bodyTds);
            }
        });
    });
</script>