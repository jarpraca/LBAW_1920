window.addEventListener('load', function (event) {
    let header = document.getElementsByTagName("nav")[0];
    let footer = document.getElementsByTagName("footer")[0];
    let signup_bg = document.getElementById("signup_bg");

    let height = header.offsetHeight + footer.offsetHeight;

    signup_bg.style.height = 'calc(100vh - ' + height + 'px)';
})