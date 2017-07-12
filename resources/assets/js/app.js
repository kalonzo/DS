
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

import 'jquery-ui';
import 'jquery-ui-bundle/jquery-ui.min.css';
import 'jquery-ui/ui/widgets/autocomplete';
import dt from 'datatables.net';
import 'datatables.net-bs';
import 'datatables.net-dt/css/jquery.datatables.css';

Math.radians = function (degrees) {
    return degrees * Math.PI / 180;
};

// Converts from radians to degrees.
Math.degrees = function (radians) {
    return radians * 180 / Math.PI;
};
