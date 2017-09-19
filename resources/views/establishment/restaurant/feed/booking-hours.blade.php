<div class="col-xs-12 form-group timeslots-list">
    @foreach($form_data['time_slots'] as $timeSlot)
        @foreach($timeSlot as $dayOrder => $timeInfo)
            <?php
            $label = null;
            if($timeInfo['no_break']){
                $label = 'Non-stop';
            }elseif($dayOrder == 1){
                $label = 'Déjeuner';
            }elseif($dayOrder == 2){
                $label = 'Dîner';
            }

            $start = str_replace(':', '', $timeInfo['start']) / 100;
            $end = str_replace(':', '', $timeInfo['end']) / 100;
            if($end%100 === 0){
                $end -= 70;
            } else {
                $end -= 30;
            }

            echo Form::label('time_reservation', $label, ['class' => 'col-xs-12 control-label no-gutter']);
            ?>
            <div class="timeslots-sublist">
                <?php
                for($i = $start; $i <= $end; ($i%100 === 0) ? $i+=30 : $i+=70){
                    ?>
                    <div class="timeslot-item">
                        <?php
                        $time = substr($i, 0, 2).':'.substr($i, 2, 2);
                        echo $time;
                        ?>
                        {!! Form::radio('time_reservation', $time, old('timeAM')) !!}
                    </div>
                    <?php
                }
                ?>
            </div>
        @endforeach
    @endforeach
</div>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) { 
        $('body').on('click', '.timeslot-item', function(){
            var $timeslotList = $(this).parentsInclude('.timeslots-list');
            $timeslotList.find('.timeslot-item.selected').find('input[name=time_reservation]').removeAttr('checked');
            $timeslotList.find('.timeslot-item.selected').removeClass('selected');

            $(this).find('input[name=time_reservation]').attr('checked', 'checked');
            $(this).addClass('selected');
        });
    });
</script>