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
mix.copy('node_modules/sweetalert2/dist/sweetalert2.js', 'public/js');
mix.copy('node_modules/formvalidation/dist/css/formValidation.min.css', 'public/css');

mix.sass('resources/assets/sass/all.scss', 'public/css')
    .js('resources/assets/js/app.js', 'public/js')
    .js('resources/assets/js/scripts.js', 'public/js');

/*
 / Compiling RTL Css Class
 */
const exec = require('child_process').exec

mix.then(() => {
    exec('rtlcss ./public/css/all.css ./public/css/fa.css', (error, stdout, stderr) => {
        if (error) {
            console.error(`exec error: ${error}`);
            return;
        }
        console.log(`stdout(RTLCSS): ${stdout}`);
        console.log(`stderr(RTLCSS): ${stderr}`);
    });
});

// mix.version().options({processCssUrls: false});
mix.options({processCssUrls: false});
