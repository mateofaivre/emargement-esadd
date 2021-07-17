var nameEtape = document.querySelector('.title').innerHTML;
var btPrev = document.querySelector('.footer');

if (nameEtape.includes('diplôme') == false){

    btPrev.style.display="block"

}
else {
    btPrev.style.display="none"
}

function prev(){
    history.back()
  }
  btPrev.addEventListener('click', prev)