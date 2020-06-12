const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

mix.postCss('./src/style.css', './css/style.css',
    tailwindcss('./tailwind.config.js')
);

var LiveReloadPlugin = require('webpack-livereload-plugin');

mix.webpackConfig({
    plugins: [
        new LiveReloadPlugin()
    ]
});
