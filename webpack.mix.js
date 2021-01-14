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
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps();

mix.scripts(
    [
        'public/js/input-image.js',
        'public/js/borrows.js',
        'public/js/like-follow-button.js',
    ],
    'public/js/all.js'
);
mix.styles('public/css/general.css', 'public/css/all.css');

if (mix.inProduction()) {
    mix.version();
}
