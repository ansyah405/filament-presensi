let mix = require('laravel-mix');

// Kompilasi file Sass dan JavaScript
mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');

// Menambahkan versi file untuk caching browser
mix.version();