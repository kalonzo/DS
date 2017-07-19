
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

import 'jquery-ui';
import 'jquery-ui-bundle/jquery-ui.min.css';
import 'jquery-ui/ui/widgets/autocomplete';
import 'jquery-ui/ui/widgets/slider';
import dt from 'datatables.net';
import 'datatables.net-bs';
import 'datatables.net-dt/css/jquery.datatables.css';

var jsReadyEvent; // The custom event that will be created
if (document.createEvent) {
    jsReadyEvent = document.createEvent("HTMLEvents");
    jsReadyEvent.initEvent("js-ready", true, true);
} else {
    jsReadyEvent = document.createEventObject();
//    jsReadyEvent.eventType = "js-ready";
}
jsReadyEvent.eventName = "js-ready";

if (document.createEvent) {
    document.dispatchEvent(jsReadyEvent);
} else {
    document.fireEvent("on" + jsReadyEvent.eventType, jsReadyEvent);
}
//$(document).trigger('js-ready');