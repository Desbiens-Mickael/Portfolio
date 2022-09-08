const btn = document.getElementsByClassName("close");

for (let i = 0; i < btn.length; i++) {
    btn[i].addEventListener('click', () => {
        btn[i].parentElement.classList.add("d-none");
    });
}