import Swup from 'swup';
import SwupBodyClassPlugin from '@swup/body-class-plugin';

const swup = new Swup({
    containers: ["#swup", "#header"],
    linkSelector:
        'a[href^="' +
        window.location.origin +
        '"]:not([data-no-swup]):not([target="_blank"]),' +
        ' a[href^="/"]:not([data-no-swup]):not([target="_blank"]),' +
        ' a[href^="#"]:not([data-no-swup]):not([target="_blank"])',
    plugins: [
        new SwupBodyClassPlugin({
            prefix: '',
        }),
    ],
});