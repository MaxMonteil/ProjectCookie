$(document).ready(function () {
    setCookie("jwt", "", 1);
    $("#submit").click(checkLogin);
})

function checkLogin() {
    var fname = $("#fname").val();
    var lname = $("#lname").val();
    var email = $("#email").val();
    var pass = $("#pass").val();
    var cpass = $("#cpass").val();
    $.ajax({
        type: 'POST',
        url: 'api/register.php',
        data: {
                "first_name": fname,
                "last_name": lname,
                "email": email,
                "password": pass,
                "confirmpassword": cpass,
            },
        success: function (data) {
            //setCookie("jwt", data.jwt, 1);
            console.log(data);
            //$("#limiter").html("message: "+data['message']);
        }
    });
}

// function to set cookie
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

// show home page
function showHomePage(){
 
    // validate jwt to verify access
    var jwt = getCookie('jwt');
    $.post("api/validate_token.php", JSON.stringify({ jwt:jwt })).done(function(result) {
 
        // home page html will be here
    })
 
    // show login page on error will be here
}

// get or read cookie
function getCookie(cname){
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' '){
            c = c.substring(1);
        }
 
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}