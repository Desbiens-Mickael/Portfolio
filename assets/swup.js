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

function verifyCallback() {
    const contactBtn = document.getElementById("contact-btn");
    contactBtn.removeAttribute("disabled")
}

const onloadCallback = function() {
    if(document.getElementById("g-recaptcha")) {
        grecaptcha.render(document.getElementById("g-recaptcha"), {
            'sitekey' : '6LeffMshAAAAAPVpPNAAFk8ARd4MlupOcDvK-gPN',
            "theme": "dark",
            "callback": verifyCallback
        });
    }
};

function renderWait() {
    setTimeout(() => {
        if (typeof grecaptcha !== "undefined" && typeof grecaptcha.render !== "undefined")  onloadCallback();
        else renderWait();
    }, 200);
}
renderWait();

swup.on('contentReplaced', function () {
    if (document.getElementById("g-recaptcha")) {
        onloadCallback();
    }
});

if(document.getElementById('flash')) {
    swup.options.containers.push('#flash');
}

