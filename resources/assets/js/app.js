
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

require( 'jquery-ui');
require( 'jquery-ui-bundle/jquery-ui.min.css');
require( 'jquery-ui/ui/widgets/autocomplete');
require( 'jquery-ui/ui/widgets/slider');
require( 'jquery-ui/ui/widgets/datepicker');
require( 'jquery-ui/ui/i18n/datepicker-fr-CH.js');
//window.dt = require( 'datatables.net');
//require( 'datatables.net-bs');
//require( 'datatables.net-dt/css/jquery.datatables.css');
require( 'multiselect');
require( 'multiselect/css/multi-select.css');
require( 'select2');
require( 'select2/dist/css/select2.min.css');

var jsReadyEvent;
if (document.createEvent) {
    jsReadyEvent = document.createEvent("HTMLEvents");
    jsReadyEvent.initEvent("js-ready", true, true);
} else {
    jsReadyEvent = document.createEventObject();
}
jsReadyEvent.eventName = "js-ready";

if (document.createEvent) {
    document.dispatchEvent(jsReadyEvent);
} else {
    document.fireEvent("on" + jsReadyEvent.eventType, jsReadyEvent);
}