const {mix} = require('laravel-mix');

// var LiveReloadPlugin = require('webpack-livereload-plugin');
// mix.webpackConfig({
//     plugins: [
//         new LiveReloadPlugin()
//     ]
// });

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
mix.scripts(['resources/assets/js/accounting.min.js'], 'public/js/scripts.js');

mix.js('resources/assets/js/app.js', 'public/js')
    .js('public/js/scripts.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('resources/assets/sass/fanex.scss', 'public/css')
    .version()
    .options({ processCssUrls: false });
