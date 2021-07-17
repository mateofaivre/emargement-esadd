const $ = document.querySelector.bind(document);
const h = tag => document.createElement(tag);

const text_labels = {
    fr: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
    // en: ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'],
    es: ['DOM', 'LUN', 'MAR', 'MIE', 'JUV', 'VIE', 'SAB']
};

// -- setup

const labels = $('#calendar .labels');
const dates = $('#calendar .dates');

const lspan = Array.from({ length: 7 }, () => {
  return labels.appendChild(h('span'));
});

const dspan = Array.from({ length: 42 }, () => {
  return dates.appendChild(h('span'));

});

// -- state mgmt    
var currentDate = new Date();
currentYear = currentDate.getFullYear();
currentMonth = currentDate.getMonth();
$('#year').value = currentYear;

var option = document.querySelectorAll('#month option')
option[currentMonth].selected=true

var caseDay = document.querySelectorAll('.dates span')
var caseDayHover = document.querySelectorAll('.dates span:hover')
var btSearch = document.querySelector('.btSearch')
var caseDayTab = [
  [],[],[],[],[],[],[],[],[],[],[],[],  
];
var allTab= [];

for (let index = 1900; index < currentYear+1; index++) {
  allTab.push([]);
  for (let iMois = 0; iMois < 12; iMois++) {
    allTab[index-1900].push([])    
  }
}

// console.log(allTab);


const view = sublet({
  lang: 'fr',
  offset: 1,
  year: currentYear,
  month: currentMonth,
}, update);
    
function update(state) {
  const offset = state.offset;
  
  // apply day labels
  const txts = text_labels[state.lang];
  lspan.forEach((el, idx) => {
    el.textContent = txts[(idx + offset) % 7];
  });

  // apply date labels (very naiive way, pt 1)
  let i=0, j=0, date = new Date(state.year, state.month);
  calendarize(date, offset).forEach(week => {
    for (j=0; j < 7; j++) {
      dspan[i++].textContent = week[j] > 0 ? week[j] : '';
    }
  
  }); 

  for (let z = 0; z < dspan.length; z++) {
    if (dspan[z].textContent == ""){
      dspan[z].style.pointerEvents="none"
    }
    // else {
    //   // caseDay[z].classList.add('days')
    // }
    
  }

  // dspan.forEach( caseSpan => {
   
    
  // })  

   

  // caseDay.forEach(caseSelected => {
  //   if (caseDayTab[$('#month').value].includes(caseSelected.innerHTML)){
  //     caseSelected.style.borderColor='rgb(135, 135, 135)'
  //   }
  //   else {
  //     caseSelected.style.borderColor='transparent'
  //   }
  // })x

  caseDay.forEach(caseSelected => {
    if (allTab[$('#year').value-1900][$('#month').value].includes(caseSelected.innerHTML)){
      caseSelected.style.borderColor='rgb(135, 135, 135)'
    }
    else {
      caseSelected.style.borderColor='transparent'
    }
  })
  
  // clear remaining (very naiive way, pt 2)
  while (i < dspan.length) dspan[i++].textContent = '';

}

// -- inputs

$('#lang').onchange = ev => {
  view.lang = ev.target.value;
};

$('#offset').onchange = ev => {
  view.offset = +ev.target.value;
};

$('#month').onchange = ev => {
  view.month = ev.target.value;
  // alert($('#month').value)
};

$('#year').onchange = ev => {

  // caseDay.forEach(caseSelected => {
  //   if (caseDayTab[$('#month').value].includes(caseSelected.innerHTML)){
  //     // alert($('#month').value)
  //     // alert( caseSelected.innerHTML)
  //     caseSelected.style.borderColor='rgb(135, 135, 135)'
  //   }
  //   else {
  //     // alert('transparent')
  //     caseSelected.style.borderColor='transparent'
  //   }
  // })

  view.year = ev.target.value;
};


function borderDate(){
    
    var caseAllClass = Array.prototype.slice.call( caseDay, 0 );
    var caseClass = (caseAllClass.indexOf(event.currentTarget));
    var yearSelected = document.querySelector('#year').value
    var monthSelected = document.querySelector('#month').value   
    var monthToSend = parseInt(monthSelected)+1;

    let state;

    // if (caseDay[caseClass].style.borderColor != "rgb(135, 135, 135)"){
    //     caseDay[caseClass].style.borderColor="rgb(135, 135, 135)"
    //     caseDay[caseClass].classList.add('selected')
    //     caseDayTab[monthSelected].push(caseDay[caseClass].innerHTML);
    // }
    if (caseDay[caseClass].style.borderColor != "rgb(135, 135, 135)"){
      state="select";
      caseDay[caseClass].style.borderColor="rgb(135, 135, 135)"
      allTab[yearSelected-1900][monthSelected].push(caseDay[caseClass].innerHTML);
    }
    // else {
    //     caseDay[caseClass].style.borderColor="transparent"
    //     caseDay[caseClass].classList.remove('selected') 
    //     index = caseDayTab[monthSelected].indexOf(caseDay[caseClass].innerHTML)
    //     caseDayTab[monthSelected].splice(index, 1);
    // }
    else {
      state="unselect";
      caseDay[caseClass].style.borderColor="transparent"
      index = allTab[yearSelected-1900][monthSelected].indexOf(caseDay[caseClass].innerHTML)
      allTab[yearSelected-1900][monthSelected].splice(index, 1);
    }

    // for (let i = 0; i < caseDayTab[monthSelected].length; i++) {
    //   if (i == caseDayTab[monthSelected].length-1){
    //     btSearch.href= btSearch.getAttribute('href') + `jour[]=${caseDayTab[monthSelected][i]}&mois[]=${monthToSend}&annee[]=${yearSelected}&`
    //   }
      
    // }
    for (let i = 0; i < allTab[yearSelected-1900][monthSelected].length; i++) {
      if (i == allTab[yearSelected-1900][monthSelected].length-1 && state=="select"){
        // alert(state)
        btSearch.href= btSearch.getAttribute('href') + `jour[]=${allTab[yearSelected-1900][monthSelected][i]}&mois[]=${monthToSend}&annee[]=${yearSelected}&`
      }
      if (state=="unselect"){
        if (btSearch.href.includes(`jour[]=${allTab[yearSelected-1900][monthSelected][i]}&mois[]=${monthToSend}&annee[]=${yearSelected}&`) == true) {
          // alert('fk')
          console.log(`jour[]=${caseDay[caseClass].innerHTML}&mois[]=${monthToSend}&annee[]=${yearSelected}&`)
          btSearch.href=btSearch.href.replace( `jour[]=${caseDay[caseClass].innerHTML}&mois[]=${monthToSend}&annee[]=${yearSelected}&`,'')
          console.log(btSearch.href)
        }
      }
          // for (let z= 0; z < allTab[yearSelected-1900][monthSelected].length ; z++){ //jour
          //   // jour[] =  
          // }
          // // btSearch.href=
       
    }
    if (allTab[yearSelected-1900][monthSelected].length == 0) {
      if (state=="unselect") {  
        // alert ('fuck')
        if (btSearch.href.includes(`jour[]=${caseDay[caseClass].innerHTML}&mois[]=${monthToSend}&annee[]=${yearSelected}&`) == true) {
          // alert('fk')
          // console.log(`jour[]=${caseDay[caseClass].innerHTML}&mois[]=${monthToSend}&annee[]=${yearSelected}&`)
          btSearch.href=btSearch.href.replace( `jour[]=${caseDay[caseClass].innerHTML}&mois[]=${monthToSend}&annee[]=${yearSelected}&`,'')
          // console.log(btSearch.href)
      }
    }
    }
   
  
    // alert(statee)
    
 
}

caseDay.forEach(caseSelected => {
    caseSelected.addEventListener('click',() => {
      borderDate()
    })
})

var checkboxs =  document.querySelectorAll('.checkboxRow input')
var nbCheckboxChecked = 0;

function checkCheckboxsSelected(){
  var checkedOne = Array.prototype.slice.call(checkboxs).some(x => x.checked);

  if (checkedOne == true) {
    if (btSearch.classList.contains('disabled') == true){
      btSearch.classList.remove("disabled")
    }
   
  }
  else {
    if (btSearch.classList.contains('disabled') == false){
      btSearch.classList.add("disabled")
    }
  }
}
checkboxs.forEach( checkbox => {
  checkbox.addEventListener('click', checkCheckboxsSelected)  
})

function getCheckboxSelected(){

  // if (btSearch.classList.contains('disabled') == true){
  //   alert('Il faut sélectionner au moins une promo')
  // }

  checkboxs.forEach(checkbox => {
    if (checkbox.checked == true){
      btSearch.href= btSearch.getAttribute('href') + `promo[]=${checkbox.labels[0].textContent}&`
    }
    
  })

}
btSearch.addEventListener('click', getCheckboxSelected) 
// checkboxs.forEach(checkbox => {
//   checkbox.addEventListener('click', getCheckboxSelected)
// })


var containerCalendar = document.querySelector('.containerCalendar')
var searchBy = document.querySelector('.searchBy')
var btFiltrerPhone = document.querySelector('.btFiltrerPhone')
var btFiltrerPC = document.querySelector('.btFiltrerPC')
var containerForm = document.querySelector('.containerForm')
var containerFiltrerPhone = document.querySelector('.containerFiltrerPhone')
var containerCalendarPromo = document.querySelector('.containerCalendarPromo')
var btCross = document.querySelector('.fa-times')

function showCalendar(){

  if (containerCalendarPromo.style.display != "grid"){
    containerCalendarPromo.style.display="grid"
    // containerCalendar.style.display = "block"
    // btSearch.style.display = "block"
    // searchBy.style.display = "block"
    containerForm.style.display="none"
    containerFiltrerPhone.style.display="none"
  }
  else {
    containerCalendarPromo.style.display="none"
    // containerCalendar.style.display = "none"
    // btSearch.style.display = "none"
    // searchBy.style.display = "none"
    containerForm.style.display="block"
    containerFiltrerPhone.style.display="block"
  }

}

btFiltrerPhone.addEventListener('click', showCalendar)
btFiltrerPC.addEventListener('click', showCalendar)
btCross.addEventListener('click', showCalendar)

// document.addEventListener('DOMContentLoaded', function () {
//   const inputs = Array.from(document.querySelectorAll('input'));
//   const inputListener = e => inputs.filter(i => i !== e.target).forEach(i => i.required = !e.target.value.length);
//   alert('pd')

//   inputs.forEach(i => i.addEventListener('input', inputListener));
// });







