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

  // themes
  .sass('resources/assets/sass/themes/blur.scss', 'tmp/blur.css')
  .sass('resources/assets/sass/themes/dark.scss', 'tmp/dark.css')

  .styles([
    'public/tmp/blur.css',
    'resources/assets/js/wysibb/theme/blur/wbbtheme.css'
  ], 'public/css/themes/blur.css')

  .styles([
    'public/tmp/dark.css',
    'resources/assets/js/wysibb/theme/dark/wbbtheme.css'
  ], 'public/css/themes/dark.css')

  .sass('resources/assets/sass/themes/galactic.scss', 'public/css/themes/galactic.css')

  // unit3d custom scripts
  .scripts([
  'resources/assets/js/unit3d/hoe.js',
  'resources/assets/js/unit3d/vendor/livicons.js',
  'resources/assets/js/unit3d/emoji.js',
  'resources/assets/js/unit3d/shout.js',
  'resources/assets/js/unit3d/twostep.js',
  'resources/assets/js/unit3d/blutopia.js'
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