var coll = document.getElementsByClassName("collapsible_btn");
var i;

for (i = 0; i < coll.length; i++) {
  
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    content.style.borderRadius = "0 0 5px 5px";
    if (content.style.maxHeight){
      content.style.maxHeight = null;
    } else {
      content.style.maxHeight = content.scrollHeight + "px";
    }
    if(this.classList.contains("active")){
      this.style.borderRadius = "5px 5px 0 0";
    }
    else{
      this.style.borderRadius = "5px 5px 5px 5px";
    }
  });
}