const mix = require('laravel-mix')

const config = require('./webpack.config')

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

mix.webpackConfig(config)

mix.copyDirectory('resources/assets/img', 'public/assets/img').
    copy('resources/assets/css/vendor/quill.core.css', 'public/css/quill.core.css').
    copyDirectory('resources/assets/fonts', 'public/fonts').
    sass('resources/assets/scss/main.scss', 'public/css').
    scripts(['resources/assets/js/vendor/jquery-2.2.4.min.js'], 'public/js/vendor/jquery-2.2.4.min.js').
    scripts(['resources/assets/js/vendor/bootstrap.min.js'], 'public/js/vendor/bootstrap.min.js').
    scripts(['resources/assets/js/vendor/fullcalendar.min.js'], 'public/js/vendor/fullcalendar.min.js').
    scripts(['resources/assets/js/vendor/swiper-bundle.min.js'], 'public/js/vendor/swiper-bundle.min.js').
    scripts(['resources/assets/js/main.js'], 'public/js/main.js').
    scripts(['resources/assets/js/script.js'], 'public/js/script.js')

