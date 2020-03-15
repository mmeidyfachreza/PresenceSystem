const mix = require('laravel-mix');

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
    .sass('resources/sass/app.scss', 'public/css');

mix.styles([
    'public/template/css/Linearicons-Free-v1.0.0/icon-font.min.css',
    'public/template/css/animate/animate.css',
    'public/template/css/css-hamburgers/hamburgers.min.css',
    'public/template/css/animsition/css/animsition.min.css',
    'public/template/css/animsition/css/select2/select2.min.css',
    'public/template/css/util.css',
    'public/template/css/main.css',
],
'public/css/hasil_combine.css').version();

mix.scripts([
	'public/template/css/animsition/js/animsition.min.js',
	'public/template/css/select2/select2.min.js',
	'public/template/js/main.js',
],
'public/js/hasil_combine.js').version();

// mix.styles([
//     'public/css/vendor/main.css',
// ], 'public/css/all.css');
