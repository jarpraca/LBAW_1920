
function showPopUp() {
  var popup = document.getElementById("myPopup");
  
  popup.style.visibility = "visible";
  
  console.log("OPEN = " + popup.style.visibility);


}


function hidePopUp() {
  var popup = document.getElementById("myPopup");

  
  popup.style.visiblity = null;
  popup.style.visiblity = "hidden";

  console.log("CLOSE = " + popup.style.visibility);


}