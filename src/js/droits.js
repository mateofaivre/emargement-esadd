var options = {
    valueNames: [ 'nomUsers', 'prenomUsers' ]
  };
  
var userList = new List('containerList', options);




var form = document.querySelector('form');
var popup = document.querySelector('#modalWindow')
var popupLink = document.querySelectorAll('.linkModal')
var popupClose = document.querySelector('.modal-close')
var body = document.querySelector('body')
var nomUserModal = document.querySelector('#nomUserModal')
var prenomUserModal = document.querySelector('#prenomUserModal')
// var nomUser = document.querySelectorAll('.nom')
var nomUser = document.querySelectorAll('.nomUsers')
var prenomUser = document.querySelectorAll('.prenomUsers')
var idUser = document.querySelectorAll('.ids')
var nbRetards = document.querySelector('#nbRetards')
var validerModal = document.querySelector('#validerModal')
var btnAnnuler = document.querySelector('#annulerModal')
  
  function stopScroll(){
  
      var linkAllClass = Array.prototype.slice.call( popupLink, 0 );
      var nbLinkAllClass = (linkAllClass.indexOf(event.currentTarget));   

  
      if (body.style.overflow != 'hidden'){
          body.style.overflow = 'hidden';
           
          nomUserModal.innerHTML = nomUser[nbLinkAllClass].innerHTML
          prenomUserModal.innerHTML = prenomUser[nbLinkAllClass].innerHTML
          validerModal.href+= idUser[nbLinkAllClass].innerHTML

          
      
      }
      else{   
          body.style.overflow = 'auto';
          nomUserModal.innerHTML = "" 
          prenomUserModal.innerHTML = ""
        
  
      }

  
  }   
  
  popupLink.forEach( link => {
     link.addEventListener('click', stopScroll)
  });
  btnAnnuler.addEventListener('click', stopScroll)
  popupClose.addEventListener('click', stopScroll)