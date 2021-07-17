var options = {
    valueNames: [ 'nomProfs', 'prenomProfs' ]
  };
  
  var userList = new List('containerList', options);




  form = document.querySelector('form');

  var popup = document.querySelector('#modalWindow')
  // var popupRetard = document.querySelectorAll('.linkRetard')
  // var popupEnRetard = document.querySelectorAll('.linkAlreadyRetard')
  // var popupAbsent = document.querySelectorAll('.linkAbsent')
  // var popupPresent = document.querySelectorAll('.linkPresent')
  var popupLink = document.querySelectorAll('.linkModal')
  var popupClose = document.querySelector('.modal-close')
  var body = document.querySelector('body')
//   var nomModal = document.querySelector('#nomModal')
  var nomProfModal = document.querySelector('#nomProfModal')
  var prenomProfModal = document.querySelector('#prenomProfModal')
  // // var hModal = document.querySelector('#hModal')
  // var motifModal = document.querySelector('#motifModal');
  var nomUser = document.querySelectorAll('.nom')
  var nomProf = document.querySelectorAll('.nomProfs')
  var prenomProf = document.querySelectorAll('.prenomProfs')
  var idProf = document.querySelectorAll('.ids')
  // var inputRetard =  document.querySelectorAll('.inputRetard')
  // var inputHeureRetard =  document.querySelector('#inputHeureRetard')
  // var inputMinRetard =  document.querySelector('#inputMinRetard')
  // var heureRetard = document.querySelectorAll('.heureRetard')
  // var minRetard = document.querySelectorAll('.minRetard')
  // var pRetard = document.querySelector('#pRetard')
  // var pAbsent = document.querySelector('#pAbsent')
  // var pPresent = document.querySelector('#pPresent')
  var nbRetards = document.querySelector('#nbRetards')
  var validerModal = document.querySelector('#validerModal')
  var btnAnnuler = document.querySelector('#annulerModal')
  // var valueRetard= [];
  // var valueInputMin = inputMinRetard.value
  
  // var valueInputHeure = inputHeureRetard.value
  
  
  // nbRetards.innerHTML = document.querySelectorAll('.nomOrange').length
  
  // var nomEleve = '';
  
  // for (let z = 0; z < inputRetard.length; z++) {
  //     console.log(inputRetard[z].value)
  //    valueRetard[z]=inputRetard[z].value
      
  // }
  
  function stopScroll(){
  
      var linkAllClass = Array.prototype.slice.call( popupLink, 0 );
      var nbLinkAllClass = (linkAllClass.indexOf(event.currentTarget));   

  
      if (body.style.overflow != 'hidden'){
          body.style.overflow = 'hidden';
           
          nomProfModal.innerHTML = nomProf[nbLinkAllClass].innerHTML
          prenomProfModal.innerHTML = prenomProf[nbLinkAllClass].innerHTML
          validerModal.href+= idProf[nbLinkAllClass].innerHTML

          
      
      }
      else{   
          body.style.overflow = 'auto';
          nomProfModal.innerHTML = "" 
          prenomProfModal.innerHTML = ""
        
  
      }
  
      
  
  
  }   
  
  popupLink.forEach( link => {
     link.addEventListener('click', stopScroll)
  });
  btnAnnuler.addEventListener('click', stopScroll)
  popupClose.addEventListener('click', stopScroll)







var form = document.querySelector('#containerAll')

// function getEleve(){
//     form.action +=  '&nom='+nomEleveModal.innerHTML+'&prenom='+prenomEleveModal.innerHTML

//     if (hModal.innerHTML.indexOf('Retard') != -1){
//         validerModal.name+="Retard"
//         for (let index = 0; index < nomUser.length; index++) {
//             if (hModal.innerHTML.indexOf(nomEleve[index].innerHTML) != -1 && hModal.innerHTML.indexOf(prenomEleve[index].innerHTML) != -1){
//                 if (nomUser[index].classList.contains('nomGreen') == true){
//                 validerModal.name+="Present"
//                 }
//             }
            
//         }
       
//         if(btnAlheure.style.display != 'none'){
//             inputMinRetard.name+="Already"
//         }
//     }
//     if (hModal.innerHTML.indexOf('Présence') != -1){
//         validerModal.name+="Present"
//     }
//     if (hModal.innerHTML.indexOf('Absence') != -1){
//         validerModal.name+="Absent"
//     }


    
// }
// validerModal.addEventListener('click', getEleve)