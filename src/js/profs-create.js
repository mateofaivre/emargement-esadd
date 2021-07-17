// (function() {
//     window.requestAnimFrame = (function(callback) {
//       return window.requestAnimationFrame ||
//         window.webkitRequestAnimationFrame ||
//         window.mozRequestAnimationFrame ||
//         window.oRequestAnimationFrame ||
//         window.msRequestAnimaitonFrame ||
//         function(callback) {
//           window.setTimeout(callback, 1000 / 60);
//         };
//     })();
  
//     var canvas = document.getElementById("sig-canvas");
//     var ctx = canvas.getContext("2d");
//     ctx.strokeStyle = "#222222";
//     ctx.lineWidth = 4;
  
//     function fillTextCanvas(){
//       ctx.font = "1rem 'Futura PT Light'";
//       ctx.fillStyle = "#878787";
//       ctx.fillText("Nouvelle signature", 20, 35);
//     }
  
//     // fillTextCanvas();

//     var drawing = false;
//     var mousePos = {
//       x: 0,
//       y: 0
//     };
//     var lastPos = mousePos;
  
//     canvas.addEventListener("mousedown", function(e) {
      
//       drawing = true;
//       lastPos = getMousePos(canvas, e);
//     }, false);
  
//     canvas.addEventListener("mouseup", function(e) {
//       drawing = false;
//     }, false);
  
//     canvas.addEventListener("mousemove", function(e) {
//       mousePos = getMousePos(canvas, e);
//     }, false);
  
//     // Add touch event support for mobile
//     canvas.addEventListener("touchstart", function(e) {
  
//     }, false);
  
//     canvas.addEventListener("touchmove", function(e) {
//       var touch = e.touches[0];
//       var me = new MouseEvent("mousemove", {
//         clientX: touch.clientX,
//         clientY: touch.clientY
//       });
//       canvas.dispatchEvent(me);
//     }, false);
  
//     canvas.addEventListener("touchstart", function(e) {
//       mousePos = getTouchPos(canvas, e);
//       var touch = e.touches[0];
//       var me = new MouseEvent("mousedown", {
//         clientX: touch.clientX,
//         clientY: touch.clientY
//       });
//       canvas.dispatchEvent(me);
//     }, false);
  
//     canvas.addEventListener("touchend", function(e) {
//       var me = new MouseEvent("mouseup", {});
//       canvas.dispatchEvent(me);
//     }, false);
  
//     function getMousePos(canvasDom, mouseEvent) {
//       var rect = canvasDom.getBoundingClientRect();
//       return {
//         x: mouseEvent.clientX - rect.left,
//         y: mouseEvent.clientY - rect.top
//       }
//     }
  
//     function getTouchPos(canvasDom, touchEvent) {
//       var rect = canvasDom.getBoundingClientRect();
//       return {
//         x: touchEvent.touches[0].clientX - rect.left,
//         y: touchEvent.touches[0].clientY - rect.top
//       }
//     }
  
//     function renderCanvas() {
//       if (drawing) {
//         ctx.moveTo(lastPos.x, lastPos.y);
//         ctx.lineTo(mousePos.x, mousePos.y);
//         ctx.stroke();
//         lastPos = mousePos;
//       }
//     }
  
//     // Prevent scrolling when touching the canvas
//     document.body.addEventListener("touchstart", function(e) {
//       if (e.target == canvas) {
//         e.preventDefault();
//       }
//     }, false);
//     document.body.addEventListener("touchend", function(e) {
//       if (e.target == canvas) {
//         e.preventDefault();
//       }
//     }, false);
//     document.body.addEventListener("touchmove", function(e) {
//       if (e.target == canvas) {
//         e.preventDefault();
//       }
//     }, false);
  
//     (function drawLoop() {
//       requestAnimFrame(drawLoop);
//       renderCanvas();
//     })();
  
//     function clearCanvas() {
//       canvas.width = canvas.width;
//     }
  
//     // Set up the UI
//     var sigText = document.getElementById("sig-dataUrl");
//     var sigImage = document.getElementById("sig-image");
//     var clearBtn = document.getElementById("sig-clearBtn");
//     var submitBtn = document.getElementById("submitBtn");
//     var containerDatas = document.querySelector("#containerDatas");
//     var newSign = document.querySelector('#newSign')
//     clearBtn.addEventListener("click", function(e) {
//       clearCanvas();
//     //   sigText.innerHTML = "";
//     sigText.innerHTML = "Data URL for your signature will go here!";
//       sigImage.setAttribute("src", "");
//       if (containerDatas.style.display != "none"){
//         // fillTextCanvas();
//         canvas.style.marginTop="-1.25rem"
//         newSign.style.top="35%"
//         containerDatas.style.display="none"
//       }
    
//     }, false);
//     submitBtn.addEventListener("click", function(e) {
//         var blank = document.createElement('canvas')
//         if(canvas.toDataURL() != blank.toDataURL() ){
//             // alert('but')
//             if (sigImage.src != "" || sigImage.src != "Url signature"){
//                 // alert('2buts')
//                 var dataUrl = canvas.toDataURL();
//                 sigText.innerHTML = dataUrl;
//                 sigImage.setAttribute("src", dataUrl);
//             }
//             else {
//                 // alert('loose1')
//                 sigText.innerHTML=""
//                 sigImage.setAttribute("src", sigText.innerHTML);
//             }
           
//         }
//         else {
//             // alert('loose2')
//             if (containerDatas.style.display == "none"){
//                 // alert('chc')
//                 sigText.innerHTML=""
//                 sigImage.setAttribute("src", sigText.innerHTML);
//             }
//             else {
//                 sigText.innerHTML=sigImage.src
//                 sigImage.setAttribute("src", sigText.innerHTML);
//             }
//         }
        

//         // var dataUrl = canvas.toDataURL();
//         // sigText.innerHTML = dataUrl;
//         // sigImage.setAttribute("src", dataUrl);
   
//     }, false);
  
//   })();

var btnClear = document.querySelector('.clearSign')
var imgSign = document.querySelector('#sig-image')
var sigDataUrl = document.querySelector('#sig-dataUrl')
var prevMessage = document.querySelector('.containerSignature p')

function clearSign() {

  if (sigDataUrl.innerHTML != 'NULL'){
    imgSign.src=''
    sigDataUrl.innerHTML = "NULL"
    imgSign.style.display="none"
    btnClear.style.display="none"
    prevMessage.style.display="block"
  }
  
}

btnClear.addEventListener('click', clearSign)