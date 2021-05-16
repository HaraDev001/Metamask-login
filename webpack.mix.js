const mix = require('laravel-mix');
// import mix from 'laravel-mix';
// const { mix } = require('laravel-mix');

// mix.js('resources/assets/js/app.js', 'public/js')
//    .sass('resources/assets/sass/app.scss', 'public/css');

// if (mix.inProduction()) {

//     mix.version();

//     mix.webpackConfig({
//         module: {
//             rules: [{
//                 test: /\.js?$/,
//                 exclude: /(bower_components)/,
//                 use: [{
//                     loader: 'babel-loader',
//                     options: mix.config.babel()
//                 }]
//             }]
//         }
//     });
// }
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

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css');
