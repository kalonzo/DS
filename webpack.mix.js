const { mix } = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js([
    'resources/assets/js/app.js'], 'public/js')
    .copyDirectory('resources/assets/css/', 'public/css')
    .copyDirectory('resources/assets/js/', 'public/js')
    .copyDirectory('resources/assets/img', 'public/img')
    
    .copyDirectory('resources/assets/libraries/wow', 'public/libraries/wow')
    .copyDirectory('node_modules/ckeditor/', 'public/libraries/ckeditor')
    .copyDirectory('node_modules/baguettebox.js/dist/', 'public/libraries/baguettebox/')
    .copyDirectory('resources/assets/dashboard-innovate', 'public/dashboard-innovate')
    .copyDirectory('node_modules/fullcalendar/dist/', 'public/libraries/fullcalendar/')
    .copyDirectory('vendor/kartik-v/bootstrap-fileinput', 'public/libraries/bootstrap-fileinput')
    .copyDirectory('node_modules/bootstrap-colorpicker/dist/', 'public/libraries/bootstrap-colorpicker/')
    
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('resources/assets/sass/front.scss', 'public/css')
    .sass('resources/assets/sass/admin.scss', 'public/css')
    .sass('resources/assets/sass/establishment.scss', 'public/css')
    .sass('resources/assets/sass/sidebar.scss', 'public/css')
    .sass('resources/assets/sass/datatables.scss', 'public/css')
//    .browserSync('dinerscope')
    ;
