let mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
	.js('resources/assets/js/script.js', 'public/js')
	.js('resources/assets/js/jquery.custom-file-input.js', 'public/js')
	.js('resources/assets/js/scriptIngresos.js', 'public/js')
	.js('resources/assets/js/scriptGastos.js', 'public/js')
	.js('resources/assets/js/scriptAhorros.js', 'public/js')
	.sass('resources/assets/sass/app.scss','public/css')
	.sass('resources/assets/sass/style.scss','public/css');