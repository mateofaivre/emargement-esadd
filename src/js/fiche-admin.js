let btnValider = document.querySelector('.btn-valider')
let selectOption = document.querySelector('.select-prof')

selectOption.addEventListener('change', () => {
    if (btnValider.classList.contains("-disabled")){
        btnValider.classList.remove('-disabled')
    }
});

btnValider.addEventListener('click', () => {
    btnValider.href="fiche.php?uid=0d&idProfAdmin="+selectOption.value
})