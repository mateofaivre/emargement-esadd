var formAll = document.querySelectorAll(".form-popup")
var btAll = document.querySelectorAll('.bt')

function openForm() {
    var els = Array.prototype.slice.call( btAll, 0 );
    nbIndexClass = (els.indexOf(event.currentTarget));

    if (formAll[nbIndexClass].style.display != 'block'){
        formAll[nbIndexClass].style.display = "block";
    }
    else {
        formAll[nbIndexClass].style.display = "none";
    }
}


var input = document.querySelector('input[type=file]');
var textarea = document.querySelector('.textareaFile');
var userPhoto = document.querySelector('.containerPhoto img')

function readFile(event) {
  textarea.textContent = event.target.result;
  // console.log(event.target.result);
}

function changeFile() {
  var file = input.files[0];
  var reader = new FileReader();
  reader.addEventListener('load', readFile);
 
  userPhoto.title = file.name;

  reader.onload = function(event) {
    console.log(event.target.result)
    userPhoto.src = event.target.result;
  };

  reader.readAsDataURL(file);

  

  // reader.readAsText(file);
  // reader.onload= function() {
  //   userPhoto.src= reader.result;
   
  // }
  // reader.readAsDataURL(files[0]);
  // userPhoto.src="../../../../images-users/"+input.files[0].name
}

input.addEventListener('change', changeFile);


