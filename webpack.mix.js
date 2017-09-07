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
//    .copyDirectory('node_modules/ckeditor/', 'public/libraries/ckeditor')
//    .copyDirectory('node_modules/baguettebox.js/dist/', 'public/libraries/baguettebox/')
//    .copyDirectory('resources/assets/dashboard-innovate', 'public/dashboard-innovate')
//    .copyDirectory('vendor/kartik-v/bootstrap-fileinput', 'public/libraries/bootstrap-fileinput')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('resources/assets/sass/front.scss', 'public/css')
    .sass('resources/assets/sass/admin.scss', 'public/css')
    .sass('resources/assets/sass/establishment.scss', 'public/css')
    .sass('resources/assets/sass/sidebar.scss', 'public/css')
//    .browserSync('dinerscope')
    ;
