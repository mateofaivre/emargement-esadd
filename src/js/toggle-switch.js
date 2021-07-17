var switchToogle = document.querySelector('.control')
// var cercleSwitch = document.querySelector('.control span')
var form = document.querySelector('form')
var submitBtn = document.querySelector("input[type='submit']")
var index=0;
var cours=0;

switchToogle.addEventListener('click', () => {
    // if (switchToogle.classList.contains('notchecked')) {
    //     switchToogle.classList.remove('notchecked')
    //     switchToogle.classList.add('checked')

    //     var styleElem = document.head.appendChild(document.createElement("style"));

    //     styleElem.innerHTML = ".control::after {display:block !important}";
    //     // cercleSwitch.style.display="block"
    // }
    index++;
    console.log(index)

    if (index % 2 == 0){ //paire
      cours=0
    }
    else {
        cours=1
    }
})  

submitBtn.addEventListener('click', () => {
    form.action+= "?typeCours="+cours
})
