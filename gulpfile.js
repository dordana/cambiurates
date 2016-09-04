var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass( [ 'site/site.scss' ], 'public/styles/site/app.css' )
        .styles('site/plugins/*.css', 'public/styles/site/')
        .scripts('site/*.js', 'public/scripts/site/vendor.js')
        .scripts('site/global/*.js', 'public/scripts/site/app.js')
        .copy('resources/assets/js/site/**/*.js', 'public/scripts/site')
        .copy('resources/assets/img/site', 'public/images/')
        .copy('resources/assets/img/email', 'public/images/email')
        .copy('resources/assets/fonts/bootstrap/*.{ttf,woff,woff2,eot,svg}', 'public/fonts')
        .copy('resources/assets/fonts/font-awesome/*.{ttf,woff,woff2,eot,svg}', 'public/fonts')
        .copy('resources/assets/fonts/footable/*.{ttf,woff,woff2,eot,svg}', 'public/fonts')
        .copy('resources/assets/fonts/icomoon/*.{ttf,woff,woff2,eot,svg}', 'public/fonts')
        .copy('resources/assets/fonts/summernote/*.{ttf,woff,woff2,eot,svg}', 'public/fonts')

        // --- ADMIN ---
        .styles( [ 'admin/*.css', 'admin/**/*.css' ], 'public/styles/admin' )
        .sass( [ 'admin/admin.scss' ], 'public/styles/admin/app.css' )
        .scripts(['admin/jquery.js', 'admin/jquery.js', 'admin/*.js'], 'public/scripts/admin/vendor.js')
        .copy('resources/assets/js/admin/plugins/**/*.js', 'public/scripts/admin/plugins')
        .copy('resources/assets/img/admin', 'public/images/admin')
        .version('styles/site/app.css');

    elixir.Task.find('sass').watch('assets/sass/**/**');
})
