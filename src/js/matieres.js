var options = {
    valueNames: [ 'nomProfs', 'prenomProfs', 'nomMatieres' ]
  };
  
  var userList = new List('containerList', options);

  var form = document.querySelector('#containerAll');
  var popup = document.querySelector('#modalWindow')
  var popupLink = document.querySelectorAll('.linkModal')
  var popupClose = document.querySelector('.modal-close')
  var body = document.querySelector('body')
  var nomUser = document.querySelectorAll('.nom')
  var nomMatiereModal = document.querySelector('#nomMatiereModal')
  var nomMatiere = document.querySelectorAll('.nomMatieres')
  var idMatiere = document.querySelectorAll('.ids')
  var nbRetards = document.querySelector('#nbRetards')
  var validerModal = document.querySelector('#validerModal')
  var btnAnnuler = document.querySelector('#annulerModal')
  
  function stopScroll(){
  
      var linkAllClass = Array.prototype.slice.call( popupLink, 0 );
      var nbLinkAllClass = (linkAllClass.indexOf(event.currentTarget));   

  
      if (body.style.overflow != 'hidden'){
          body.style.overflow = 'hidden';
           
          nomMatiereModal.innerHTML = nomMatiere[nbLinkAllClass].innerHTML
          validerModal.href+= idMatiere[nbLinkAllClass].innerHTML
      
      }
      else{   
          body.style.overflow = 'auto';
          nomMatiereModal.innerHTML = "" 
      }
  
  
  }   
  
  popupLink.forEach( link => {
     link.addEventListener('click', stopScroll)
  });
  btnAnnuler.addEventListener('click', stopScroll)
  popupClose.addEventListener('click', stopScroll)