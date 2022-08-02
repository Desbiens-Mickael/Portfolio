import Swup from 'swup';
import SwupBodyClassPlugin from '@swup/body-class-plugin';
import SwupScrollPlugin from '@swup/scroll-plugin';

const swup = new Swup({
    containers: ["#swup", "#header"],
    plugins: [
        new SwupBodyClassPlugin({
            prefix: '',
        }),
        // new SwupScrollPlugin(),
    ],
});