/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any SCSS you import will output into a single scss file (app.scss in this case)
import './styles/app.scss';

import './swup'
import './contact'

// start the Stimulus application
import './bootstrap';

//sur la branche Bootstrap
require('bootstrap');

window.addEventListener('load', () => {
    document.body.classList.remove('clean-transition');
})