const {mix} = require('laravel-mix');

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

mix.copy([
    'resources/assets/js/t-rex.js',
    'resources/assets/js/ammap.js',
    'resources/assets/js/worldLow.js',
    'resources/assets/js/black.js',
    'resources/assets/js/export.min.js',
    'resources/assets/js/classie.js'
], 'public/js');

mix.sass('resources/assets/sass/all.scss', 'public/css')
    .js('resources/assets/js/app.js', 'public/js');

mix.scripts([
    'node_modules/sweetalert2/dist/sweetalert2.all.js',
    'node_modules/sticky-kit/dist/sticky-kit.js',
    'node_modules/jquery.nicescroll/jquery.nicescroll.js',
    'node_modules/accounting-js/dist/accounting.umd.js',
    'node_modules/jquery-countdown/dist/jquery.countdown.js',
    'node_modules/inputmask/dist/jquery.inputmask.bundle.js',
    'node_modules/jquery-price-format/jquery.priceformat.js',
    'resources/assets/js/index.js'
],'public/js/scripts.js');

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

mix.options({processCssUrls: false});
