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
        if (document.documentElement.clientWidth < 900) {
            $("#loginform").css("visibility","hidden");
            $("#loginform").animate({opacity:"0"},500);
            $("#signup_infos").css("visibility","hidden");
            $("#signup_infos").animate({opacity:"0"},500);
    
            $("#signupform").animate({opacity:"1"},500);
            $("#signupform").css("visibility","visible");
            $("#login_infos").animate({opacity:"1"},500);
            $("#login_infos").css("visibility","visible");
        }
        else{
            $("#main").animate({left:"35%"},500); 
            $("#loginform").css("visibility","hidden");
            $("#loginform").animate({opacity:"0", left:"30%"},500);
    
            $("#signupform").animate({opacity:"1", left:"50%"},500);
            $("#signupform").css("visibility","visible");
        }
    }); 
    
    $(".login_btn").click(function(){ 
        if (document.documentElement.clientWidth < 900) {
            $("#signupform").css("visibility","hidden");
            $("#signupform").animate({opacity:"0"},500);
            $("#login_infos").css("visibility","hidden");
            $("#login_infos").animate({opacity:"0"},500);
            
            $("#loginform").animate({opacity:"1"},500);
            $("#loginform").css("visibility","visible");
            $("#signup_infos").animate({opacity:"1"},500);
            $("#signup_infos").css("visibility","visible");
        }
        else{
            $("#main").animate({left:"65%"},500);
            $("#signupform").css("visibility","hidden");
            $("#signupform").animate({opacity:"0", left:"70%"},500);
            
            $("#loginform").animate({opacity:"1", left:"50%"},500);
            $("#loginform").css("visibility","visible");
        }
    });
});