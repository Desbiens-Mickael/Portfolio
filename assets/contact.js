const firstname = document.getElementById('contact_firstname');
const lastname = document.getElementById('contact_lastname');
const objet = document.getElementById('contact_objet');
const mail = document.getElementById('contact_email');
const message = document.getElementById('contact_message');

if (document.getElementById('contact-form')) {
    firstname.setAttribute('value', '');
    lastname.setAttribute('value', '');
    objet.setAttribute('value', '');
    mail.setAttribute('value', '');
    message.value = '';
}



