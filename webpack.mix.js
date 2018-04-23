let mix = require('laravel-mix')

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
  .sass('resources/assets/sass/app.scss', 'public/css')
  .sass('resources/assets/sass/themes/blur.scss', 'public/css/themes/blur.css')
  .sass('resources/assets/sass/themes/dark.scss', 'public/css/themes/dark.css')
  .sass('resources/assets/sass/themes/galactic.scss', 'public/css/themes/galactic.css')
  .scripts([
    'resources/assets/unit3d/hoe.js',
    'resources/assets/unit3d/emoji.js',
    'resources/assets/unit3d/shout.js',
    'resources/assets/unit3d/twostep.js',
    'resources/assets/unit3d/blutopia.js'
  ], 'public/js/unit3d.js')

// Full API
// mix.js(src, output);
// mix.extract(vendorLibs);
// mix.sass(src, output);
// mix.less(src, output);
// mix.combine(files, destination);
// mix.copy(from, to);
// mix.minify(file);
// mix.sourceMaps(); // Enable sourcemaps
// mix.version(); // Enable versioning.
// mix.disableNotifications();
// mix.setPublicPath('path/to/public');
// mix.autoload({}); <-- Will be passed to Webpack's ProvidePlugin.
// mix.webpackConfig({}); <-- Override webpack.config.js, without editing the file directly.
// mix.then(function () {}) <-- Will be triggered each time Webpack finishes building.