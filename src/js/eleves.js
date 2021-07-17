var options = {
    valueNames: [ 'nomEleves', 'prenomEleves' ]
  };
  
  var userList = new List('containerList', options);

  var form = document.querySelector('#containerAll');

  var popup = document.querySelector('#modalWindow')
  var popupLink = document.querySelectorAll('.linkModal')
  var popupClose = document.querySelector('.modal-close')
  var body = document.querySelector('body');
  var nomProfModal = document.querySelector('#nomProfModal')
  var prenomProfModal = document.querySelector('#prenomProfModal')
  var nomUser = document.querySelectorAll('.nom')
  var nomEleve = document.querySelectorAll('.nomEleves')
  var prenomEleve = document.querySelectorAll('.prenomEleves')
  var idEleve = document.querySelectorAll('.ids')
  var nbRetards = document.querySelector('#nbRetards')
  var validerModal = document.querySelector('#validerModal')
  var btnAnnuler = document.querySelector('#annulerModal')
  
  function stopScroll(){
  
      var linkAllClass = Array.prototype.slice.call( popupLink, 0 );
      var nbLinkAllClass = (linkAllClass.indexOf(event.currentTarget));   

  
      if (body.style.overflow != 'hidden'){
          body.style.overflow = 'hidden';
           
          nomEleveModal.innerHTML = nomEleve[nbLinkAllClass].innerHTML
          prenomEleveModal.innerHTML = prenomEleve[nbLinkAllClass].innerHTML
          validerModal.href+= idEleve[nbLinkAllClass].innerHTML
      
      }
      else{   
          body.style.overflow = 'auto';
          nomEleveModal.innerHTML = "" 
          prenomEleveModal.innerHTML = ""
      }
  
  
  }   
  
  popupLink.forEach( link => {
     link.addEventListener('click', stopScroll)
  });
  btnAnnuler.addEventListener('click', stopScroll)
  popupClose.addEventListener('click', stopScroll)
