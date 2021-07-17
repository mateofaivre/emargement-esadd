// var select2 = document.querySelectorAll('#testSelect2_itemList li')

// var selectOptions = document.querySelectorAll('#testSelect2 option ')

// function onlyOne() {
//     var optionSelected = document.querySelectorAll('#testSelect2_itemList .active')
//     var optionAllClass = Array.prototype.slice.call( select2, 0 );
//     var nbOptionAllClass = (optionAllClass.indexOf(event.currentTarget));
//     // console.log(optionSelected)
//     // console.log(optionSelected.length)
//     if (optionSelected.length == 1){
//         select2
//         // select2[nbOptionAllClass].classList.remove('active')
//         // alert(select2[nbOptionAllClass].classList)
//         alert('Une seule promo est sélectionnable')
//     }
// }

// select2.forEach(
//     select => {
//         select.addEventListener('click', onlyOne)
//     }
// )

// let mySelect = new vanillaSelectBox("#testSelect2",{
//     maxWidth: 500,
//     maxHeight: 400,
//     minWidth: -1
// });


// $("#choice").change(function () {
//     if($(this).val() == "0") $(this).addClass("empty");
//     else $(this).removeClass("empty")
//   });
  
//   $("#choice").change();

var select2 = document.querySelector('#select2')

function firstColor() {
    if (select2.value == "0"){
        select2.classList.add('firstOption')
    }
    else {
        select2.classList.remove('firstOption')
    }
}

select2.addEventListener('change', firstColor)


