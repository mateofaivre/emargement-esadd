var dots = document.querySelectorAll('.fa-ellipsis-v');
var check = document.querySelectorAll('.fa-check');
var cross = document.querySelectorAll('.fa-times')

function changeColorState(){
    var dotClass = Array.prototype.slice.call( dots, 0 );
    nbDotClass = dotClass.indexOf(event.currentTarget);

    // dots[nbDotClass].style.display="none"
    if (check[nbDotClass].style.display!= "inline" && cross[nbDotClass].style.display!= "inline"){
        check[nbDotClass].style.display="inline"
        cross[nbDotClass].style.display="inline"
    }
    else {
        check[nbDotClass].style.display="none"
        cross[nbDotClass].style.display="none"
    }
    
}
dots.forEach(dot => {
    dot.addEventListener('click',changeColorState)
})

form = document.querySelector('form');

var popup = document.querySelector('#modalWindow')
var popupRetard = document.querySelectorAll('.linkRetard')
var popupEnRetard = document.querySelectorAll('.linkAlreadyRetard')
var popupAbsent = document.querySelectorAll('.linkAbsent')
var popupPresent = document.querySelectorAll('.linkPresent')
var popupLink = document.querySelectorAll('.linkModal')
var popupClose = document.querySelector('.modal-close')
var body = document.querySelector('body')
var nomEleveModal = document.querySelector('#nomEleveModal')
var prenomEleveModal = document.querySelector('#prenomEleveModal')
// var hModal = document.querySelector('#hModal')
var motifModal = document.querySelector('#motifModal');
var nomUser = document.querySelectorAll('.nom')
var nomEleve = document.querySelectorAll('.nomEleve')
var prenomEleve = document.querySelectorAll('.prenomEleve')
var inputRetard =  document.querySelectorAll('.inputRetard')
var inputHeureRetard =  document.querySelector('#inputHeureRetard')
var inputMinRetard =  document.querySelector('#inputMinRetard')
var heuresRetard = document.querySelectorAll('.heuresRetard')
var minsRetard = document.querySelectorAll('.minsRetard')
var spanRetard = document.querySelector('#spanRetard')
var spanAbsent = document.querySelector('#spanAbsent')
var spanPresent = document.querySelector('#spanPresent')
var spanNoms =  document.querySelectorAll('p .spanNoms')
var spanPrenoms =  document.querySelectorAll('p .spanPrenoms')
var nbRetards = document.querySelector('#nbRetards')
var btnAlheure = document.querySelector('#alheure')
btnAlheure.style.display="none"
var btnAnnuler = document.querySelector('#annulerModal')
var valueRetard= [];
var valueInputMin = inputMinRetard.value

var valueInputHeure = inputHeureRetard.value

var linkToModal = document.querySelectorAll('.linkToModal')
var btnTab = document.querySelectorAll('.hTab')

var tab = document.querySelectorAll('.tabModal')
var nomsOrange = document.querySelectorAll('.nomOrange .nomEleve')


nbRetards.innerHTML = nomsOrange.length

function displayModal() {
    var linkAllClass = Array.prototype.slice.call( linkToModal, 0 );
    var nbLinkAllClass = (linkAllClass.indexOf(event.currentTarget));
    // var btnTabDisplayed = document.querySelectorAll(".hTab[style*='display:block']")
    // var tabDisplayed = document.querySelectorAll(".tabModal[style*='display:block']")

    if (body.style.overflow != 'hidden'){
        body.style.overflow = 'hidden';

        if (nomUser[nbLinkAllClass].classList.contains('nomRed')){
          nbTabSelected = 0;
        }
        else if (nomUser[nbLinkAllClass].classList.contains('nomGreen')){
           nbTabSelected = 1;
        }
        else if (nomUser[nbLinkAllClass].classList.contains('nomOrange')){
            nbTabSelected = 2;
        }

        if (btnTab[nbTabSelected].classList.contains('hTabSelected') != true){
            for (let index = 0; index < btnTab.length; index++) {
                btnTab[index].classList.remove('hTabSelected')
                tab[index].classList.remove('tabSelected')
            }
            btnTab[nbTabSelected].classList.add('hTabSelected')
            tab[nbTabSelected].classList.add('tabSelected')
        }

        spanNoms.forEach(span => {
            span.innerHTML= nomEleve[nbLinkAllClass].innerHTML
        })
        spanPrenoms.forEach(span => {
            span.innerHTML= prenomEleve[nbLinkAllClass].innerHTML
        })
        if (linkToModal[nbLinkAllClass].classList.contains('linkRetard') == true){
            inputMinRetard.value= nomUser[nbLinkAllClass].children[3].innerHTML
            inputHeureRetard.value= nomUser[nbLinkAllClass].children[2].innerHTML
        }
       

    }
    else {
        body.style.overflow = 'auto';

        // btnTab.forEach(btn => {
        //     btn.style.display="block"
        // })
        // tab.forEach( tab => {
        //     tab.style.display="block"
        // })
        inputMinRetard.value = valueInputMin
        inputHeureRetard.value = valueInputHeure
        btnAlheure.style.display="none"
    }
    
}

linkToModal.forEach( link => {
    link.addEventListener('click', displayModal)
})

// function stopScroll(){

//     var linkAllClass = Array.prototype.slice.call( popupRetard, 0 );
//     var nbLinkAllClass = (linkAllClass.indexOf(event.currentTarget));   

//     if (nbLinkAllClass == -1){
//         linkAllClass = Array.prototype.slice.call( popupPresent, 0 );
//         nbLinkAllClass = (linkAllClass.indexOf(event.currentTarget));
//         popupLink= popupPresent
//         if (nbLinkAllClass == -1) {
//             linkAllClass = Array.prototype.slice.call( popupAbsent, 0 );
//             nbLinkAllClass = (linkAllClass.indexOf(event.currentTarget));   
//             nbLinkAllClass = nbLinkAllClass + popupPresent.length
//             popupLink= popupAbsent
//         }
//     }
//     else {
//         popupLink= popupRetard
//     }
    
//     var titre = '';

//     if (body.style.overflow != 'hidden'){
//         body.style.overflow = 'hidden';
      

//         if (popupLink == popupRetard){
//             // alert('retard')
//             titre = 'Retard de '
//             pPresent.style.display='none'
//             pAbsent.style.display='none'
//             pRetard.style.display='block'
           
//             if (popupLink[nbLinkAllClass].innerHTML.indexOf('de') != -1){
//                 // alert('but')
//                 // if (typeof inputHeureRetard != 'undefined'){
//                 //     alert('input heure existe')
//                 btnAlheure.style.display="block"
//                 if (mediaQueryPhone.matches){
//                     validerModal.style.marginLeft="0.5rem"
//                 }
//                 var linkEnRetardAllClass = Array.prototype.slice.call( popupEnRetard, 0 );
//                 var nbLinkEnRetardAllClass = (linkEnRetardAllClass.indexOf(event.currentTarget));
    
//                 if (popupLink[nbLinkAllClass].innerHTML.indexOf('h') != -1){
//                     // alert('heure exist')
//                     inputHeureRetard.value=  popupRetard[nbLinkAllClass].firstElementChild.innerHTML
//                 }
//                 else {
//                     inputHeureRetard.value = 0
//                 }
               
//                 inputMinRetard.value=  minRetard[nbLinkEnRetardAllClass].innerHTML
               
//             }
//         }
//         if (popupLink == popupAbsent) {
//             titre= 'Absence de '
//             pRetard.style.display='none'
//             pPresent.style.display='none'
//             pAbsent.style.display='block'
//         }
//         if (popupLink == popupPresent) {
//             titre= 'Présence de '
//             pRetard.style.display='none'
//             pAbsent.style.display='none'
//             pPresent.style.display='block'
//         }
          
//         motifModal.innerHTML = titre
//         nomEleveModal.innerHTML = nomEleve[nbLinkAllClass].innerHTML
//         prenomEleveModal.innerHTML = prenomEleve[nbLinkAllClass].innerHTML
        
    
//         // alert(paramNomEleve)
//         // for (let index = 0; index < inputRetard.length; index++) {
//         //     inputRetard[index].value=""          
//         // }
//     }
//     else{   
//         body.style.overflow = 'auto';
//         nomEleveModal.innerHTML = "" 
//         prenomEleveModal.innerHTML = ""
//         btnAlheure.style.display="none"
//         if (mediaQueryPhone.matches){
//             validerModal.style.marginLeft="0"
//         }
//         if (typeof heureRetard[nbLinkEnRetardAllClass] == 'undefined' ){
//             inputHeureRetard.value = valueInputHeure
//         }
        
//         inputMinRetard.value = valueInputMin
//     //   for (let index = 0; index < inputRetard.length; index++) {
//     //     inputRetard[index].value=""          
//     //   }
      

//     }

    


// }   

// popupLink.forEach( link => {
//    link.addEventListener('click', stopScroll)
// });
btnAnnuler.addEventListener('click', displayModal)
popupClose.addEventListener('click', displayModal)

// btPrev = document.querySelector('.lienBack')

// function prev(){
//     window.history.back()
//   }
// btPrev.addEventListener('click', prev)

var validerModal = document.querySelector('#validerModal')
var form = document.querySelector('#containerAll')

function getEleve(){
    var btnTabSelected = document.querySelector('.hTabSelected')
    form.action +=  '&nom='+spanNoms[0].innerHTML+'&prenom='+spanPrenoms[0].innerHTML

   
    validerModal.name+=btnTabSelected.innerHTML

    // if (hModal.innerHTML.indexOf('Retard') != -1){
    //     validerModal.name+="Retard"
    //     for (let index = 0; index < nomUser.length; index++) {
    //         if (hModal.innerHTML.indexOf(nomEleve[index].innerHTML) != -1 && hModal.innerHTML.indexOf(prenomEleve[index].innerHTML) != -1){
    //             if (nomUser[index].classList.contains('nomGreen') == true){
    //             validerModal.name+="Present"
    //             }
    //         }
            
    //     }
       
        if(btnAlheure.style.display != 'none'){
            inputMinRetard.name+="Already"
        }
    // } //////////////////////////////////

    // if (hModal.innerHTML.indexOf('Présence') != -1){
    //     validerModal.name+="Present"
    // }
    // if (hModal.innerHTML.indexOf('Absence') != -1){
    //     validerModal.name+="Absent"
    // }
    
}
btnAlheure.addEventListener('click', getEleve)
validerModal.addEventListener('click', getEleve)



function changeTab() {
 
    var btnAllClass = Array.prototype.slice.call( btnTab, 0 );
    var nbBtn = (btnAllClass.indexOf(event.currentTarget));

    for (let index = 0; index < btnTab.length; index++) {
       if (index == nbBtn){
           if (btnTab[index].classList.contains('hTabSelected') != true){
            btnTab[index].classList.add('hTabSelected')
            tab[index].classList.add('tabSelected')
           }
       }
       else {
        btnTab[index].classList='hTab'
        tab[index].classList='tabModal'
       }        
    }

     for (let z = 0; z < nomsOrange.length; z++) {
        if (nomsOrange[z].innerHTML == spanNoms[0].innerHTML){
            if (btnTab[nbBtn].innerHTML == "Retard"){
                btnAlheure.style.display = "block"
            }
            else {
                btnAlheure.style.display = "none"
            }
        }
        else {
            btnAlheure.style.display = "none"
        }
         
     }
        
    
}

btnTab.forEach( btn => {
    btn.addEventListener('click', () => {
        changeTab()
    })
})


//css media queries
const mediaQueryPhone = window.matchMedia('(max-width: 600px)')





