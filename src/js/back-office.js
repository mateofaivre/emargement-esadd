var ligneAbsenteisme = document.querySelectorAll('.containerAbsenteisme:not(:first-of-type)')
var idsUser = document.querySelectorAll('.idUser')

var alertes = document.querySelector('.alertes')
var firstLigne = document.querySelector('.containerAbsenteisme:first-of-type')
var aucuneAlerte = document.querySelector('.alertes p')

// ligneAbsenteisme.forEach( ligne =>  {
//     for (let index = 0; index < ligneAbsenteisme.length; index++) {
//         // if ( index != ligneAbsenteisme.length -1){
//         //     if (ligne.innerHTML == ligneAbsenteisme[index+1].innerHTML ){
//         //         ligneAbsenteisme[index+1].remove();
//         //     }
//         // }
       
//         if (index != 0){
//             if (ligne.firstElementChild.innerHTML == ligneAbsenteisme[index].firstElementChild.innerHTML && ligneAbsenteisme[index].firstElementChild.innerHTML != ligneAbsenteisme[index-1].firstElementChild.innerHTML && ligne.lastElementChild.innerHTML.includes(ligneAbsenteisme[index+1].lastElementChild.innerHTML) != true){
//                 ligneAbsenteisme[index].lastElementChild.innerHTML += ", "+ligneAbsenteisme[index+1].lastElementChild.innerHTML
//                 ligneAbsenteisme[index+1].remove();
//             }
//             if (ligne.firstElementChild.innerHTML == ligneAbsenteisme[index].firstElementChild.innerHTML && ligneAbsenteisme[index].firstElementChild.innerHTML != ligneAbsenteisme[index-1].firstElementChild.innerHTML && ligne.lastElementChild.innerHTML.includes(ligneAbsenteisme[index+1].lastElementChild.innerHTML) == true){
//                 ligneAbsenteisme[index+1].remove();
//             }
//         }
//         else {
//             if (ligne.firstElementChild.innerHTML == ligneAbsenteisme[index].firstElementChild.innerHTML && ligne.lastElementChild.innerHTML.includes(ligneAbsenteisme[index+1].lastElementChild.innerHTML) != true){
//                 ligneAbsenteisme[index].lastElementChild.innerHTML += ", "+ligneAbsenteisme[index+1].lastElementChild.innerHTML
//                 ligneAbsenteisme[index+1].remove();
//             }
//         }


      
        
//     }
// })

for (let index = 0; index < ligneAbsenteisme.length; index++) {
    // console.log(index)
    if (document.querySelectorAll(`.idUserAbsenteisme${idsUser[index].innerHTML}`).length <= 1){
        // document.querySelectorAll(`.idUserAbsenteisme${index}`).forEach(ligne => {
        //     ligne.style.display="none"
        // });
        ligneAbsenteisme[index].style.display="none"
    }

     if ( index != ligneAbsenteisme.length - 1){
            // if (ligneAbsenteisme[index].innerHTML == ligneAbsenteisme[index+1].innerHTML ){
            //     ligneAbsenteisme[index+1].style.display="none";
            // }
            if (index != 0){
                if (ligneAbsenteisme[index].firstElementChild.innerHTML == ligneAbsenteisme[index+1].firstElementChild.innerHTML && ligneAbsenteisme[index].firstElementChild.innerHTML != ligneAbsenteisme[index-1].firstElementChild.innerHTML){
                    ligneAbsenteisme[index].lastElementChild.innerHTML +=  ", "+ligneAbsenteisme[index+1].lastElementChild.innerHTML
                    ligneAbsenteisme[index+1].style.display="none";
                }
                if (ligneAbsenteisme[index].firstElementChild.innerHTML == ligneAbsenteisme[index+1].firstElementChild.innerHTML && ligneAbsenteisme[index].firstElementChild.innerHTML == ligneAbsenteisme[index-1].firstElementChild.innerHTML){
                    ligneAbsenteisme[index-1].lastElementChild.innerHTML +=  ", "+ligneAbsenteisme[index+1].lastElementChild.innerHTML
                    ligneAbsenteisme[index].style.display="none";
                    ligneAbsenteisme[index+1].style.display="none";
                }
            }
            if (index == 0){
                if (ligneAbsenteisme[index].firstElementChild.innerHTML == ligneAbsenteisme[index+1].firstElementChild.innerHTML){
                    ligneAbsenteisme[index].lastElementChild.innerHTML +=  ", "+ligneAbsenteisme[index+1].lastElementChild.innerHTML
                    ligneAbsenteisme[index+1].style.display="none";
                }
            }
    }

   


    
}


if ( document.querySelectorAll('.containerAbsenteisme:not(:first-of-type)[style*="display: block;"]').length == 0 ) { 
   firstLigne.style.display="none"
   ligneAbsenteisme.forEach( ligne => {
       ligne.style.display="none"
   })
   aucuneAlerte.style.display="block"

}

