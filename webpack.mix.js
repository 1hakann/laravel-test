const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

 const adminResAs = 'resources/assets/admin/';
 const adminPubAs = 'public/admin/';

 //css files
mix.copy(adminResAs + "vendor/nucleo/css/nucleo.css", adminPubAs + "css/nucleo.css");
mix.copy(adminResAs + "vendor/@fortawesome/fontawesome-free/css/all.min.css", adminPubAs + "css/fortawesome.css");
// js files
mix.copy(adminResAs + "vendor/jquery/dist/jquery.min.js", adminPubAs + "js/jquery.min.js");
mix.copy(adminResAs + "vendor/bootstrap/dist/js/bootstrap.bundle.min.js", adminPubAs + "js/bootstrap.bundle.min.js");
mix.copy(adminResAs + "vendor/js-cookie/js.cookie.js", adminPubAs + "js/cookie.js");
mix.copy(adminResAs + "vendor/jquery.scrollbar/jquery.scrollbar.min.js", adminPubAs + "js/jquery.scrollbar.min.js");
mix.copy(adminResAs + "vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js", adminPubAs + "js/jquery.scrolllLock.min.js");
mix.copy(adminResAs + "vendor/chart.js/dist/Chart.extension.js", adminPubAs + "js/Chart.extension.js");
mix.copy(adminResAs + "vendor/chart.js/dist/Chart.min.js", adminPubAs + "js/Chart.min.js");
//img files
mix.copy(adminResAs + "/img", adminPubAs + "/img");
//web fonts
mix.copy(
    adminResAs + "/vendor/@fortawesome/fontawesome-free/webfonts/*",adminPubAs + "/webfonts"
);
// maps
mix.copy(adminResAs + "vendor/bootstrap/dist/js/bootstrap.bundle.min.js.map", adminPubAs + "js/bootstrap.bundle.min.js.map");
mix.copy(adminResAs + "vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js.map", adminPubAs + "js/jquery-scrollLock.min.js.map");


mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
    ])
    .combine([adminResAs + 'js/argon.js'], adminPubAs + 'js/admin.js')
    .styles([adminResAs + 'css/argon.css'], adminPubAs + 'css/admin.css');

if (mix.inProduction()) {
    mix.version();
}
