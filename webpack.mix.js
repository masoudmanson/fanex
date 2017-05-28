const {mix} = require('laravel-mix');

var LiveReloadPlugin = require('webpack-livereload-plugin');
mix.webpackConfig({
    plugins: [
        new LiveReloadPlugin()
    ]
});

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

mix.copy('node_modules/nicescroll/jquery.nicescroll.js', 'public/js');

mix.js('resources/assets/js/app.js', 'public/js')
    .js('resources/assets/js/scripts.js', 'public/js')
    .sass('resources/assets/sass/all.scss', 'public/css');

mix.version().options({processCssUrls: false});
