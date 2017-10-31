<?php
if(session('status')){
    $statusType = "success";
    $message = session('status');
    if(is_array(session('status'))){
        $message = '';
        if(isset(session('status')['title'])){
            $message .= "<strong>".session('status')['title']."</strong> : ";
        }
        if(isset(session('status')['message'])){
            $message .= session('status')['message'];
        }
        if(isset(session('status')['type'])){
            $statusType = session('status')['type'];
        }
    }
    $icon = "glyphicon-ok-sign";
    switch($statusType){
        case 'info':
            $icon = 'glyphicon-info-sign';
            break;
        case 'warning':
            $icon = 'glyphicon-warning-sign';
            break;
        case 'danger':
            $icon = 'glyphicon-minus-sign';
            break;
    }
    ?>
    <div id="feedback-{!! $statusType !!}" class="alert alert-{!! $statusType !!} alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <span class="glyphicon {!! $icon !!}" aria-hidden="true"></span>
        <span class="alert-message">{!! $message !!}</span>
    </div>
<?php
}
if (session('error')){
    ?>
    <div id="feedback-error" class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
        <span class="alert-message">{!! session('error') !!}</span>
    </div>
   <?php
}
?>
        