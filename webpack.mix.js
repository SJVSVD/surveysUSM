const mix = require('laravel-mix');


mix.js('resources/js/app.js', 'public/js')
   .vue();

mix.webpackConfig({
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
        },
    },
});
    