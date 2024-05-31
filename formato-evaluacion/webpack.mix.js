const mix = require('laravel-mix');

mix.react('resources/js/', 'public/js');

mix.js('resources/js/app.js', 'public/js')
   .sourceMaps(); // Enable source maps




