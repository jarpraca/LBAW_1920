let coll = document.getElementsByClassName("collapsible_btn");
let i;

for (i = 0; i < coll.length; i++) {

    coll[i].addEventListener("click", function () {
        this.classList.toggle("active");
        let content = this.nextElementSibling;
        if (content.style.maxHeight) {
            content.style.maxHeight = null;
        } else {
            content.style.maxHeight = content.scrollHeight + "px";
        }
        if (this.classList.contains("active")) {
            this.children[0].children[1].classList.remove('fa-chevron-down');
            this.children[0].children[1].classList.toggle('fa-chevron-up');
        }
        else {
            this.children[0].children[1].classList.remove('fa-chevron-up');
            this.children[0].children[1].classList.toggle('fa-chevron-down');
        }
    });
}