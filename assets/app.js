/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// import jquery from 'jquery';
global.jQuery = require('jquery');
// import '../../node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.js';

// require("bootstrap");
require('bootstrap-sass');
// import 'bootstrap';
// import bsCustomFileInput from 'bs-custom-file-input';

// start the Stimulus application
// import './bootstrap';

// bsCustomFileInput.init();