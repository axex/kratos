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

var cssPath = 'public/assets/css';
var jsPath  = 'public/assets/js';

elixir(function(mix) {
  mix.sass('app.scss', cssPath);
  mix.sass('pages/login.scss', cssPath);
});
