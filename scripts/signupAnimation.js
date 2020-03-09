$(document).ready(function(){  
    
    // var buttons = document.getElementsByClassName("signup");

    // function setActive(el) {
    // for (var i = 0; i < buttons.length; i++) {
    //     if (buttons[i] == el) {
    //         el.classList.toggle("active");
    //     } else {
    //         buttons[i].classList.remove('active');
    //     }
    //     }
    // }

    // for (var i = 0; i < buttons.length; i++) {
    // buttons[i].addEventListener("click", function() {
    //     setActive(this);
    // });
    // }

    $(".signup_btn").click(function(){
        $("#main").animate({left:"30%"},500); 
        $("#loginform").css("visibility","hidden");
        $("#loginform").animate({opacity:"0", left:"25%"},500);

        $("#signupform").animate({opacity:"1", left:"30%"},500);
        $("#signupform").css("visibility","visible");
    }); 
    
    $(".login_btn").click(function(){ 
        $("#main").animate({left:"70%"},500);
        $("#signupform").css("visibility","hidden");
        $("#signupform").animate({opacity:"0", left:"75%"},500);
        
        $("#loginform").animate({opacity:"1", left:"70%"},500);
        $("#loginform").css("visibility","visible");
    });
});