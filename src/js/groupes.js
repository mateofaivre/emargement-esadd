var options = {
    valueNames: [ 'nomGroupes' ]
  };
  
  var userList = new List('containerList', options);


  var form = document.querySelector('#containerAll');
  var popup = document.querySelector('#modalWindow')
  var popupLink = document.querySelectorAll('.linkModal')
  var popupClose = document.querySelector('.modal-close')
  var body = document.querySelector('body')
  var nomUser = document.querySelectorAll('.nom')
  var nomGroupeModal = document.querySelector('#nomGroupeModal')
  var nomGroupe = document.querySelectorAll('.nomGroupes')
  var idGroupe = document.querySelectorAll('.ids')
  var nbRetards = document.querySelector('#nbRetards')
  var validerModal = document.querySelector('#validerModal')
  var btnAnnuler = document.querySelector('#annulerModal')
  
  function stopScroll(){
  
      var linkAllClass = Array.prototype.slice.call( popupLink, 0 );
      var nbLinkAllClass = (linkAllClass.indexOf(event.currentTarget));   

  
      if (body.style.overflow != 'hidden'){
          body.style.overflow = 'hidden';
           
          nomGroupeModal.innerHTML = nomGroupe[nbLinkAllClass].innerHTML
          validerModal.href+= idGroupe[nbLinkAllClass].innerHTML
      
      }
      else{   
          body.style.overflow = 'auto';
          nomGroupeModal.innerHTML = "" 
      }
  
  
  }   
  
  popupLink.forEach( link => {
     link.addEventListener('click', stopScroll)
  });
  btnAnnuler.addEventListener('click', stopScroll)
  popupClose.addEventListener('click', stopScroll)