$(document).ready(function () {
    $("#submit").click(checkLogin);
})

function checkLogin() {
    var fname = $("#fname").val();
    var lname = $("#lname").val();
    var email = $("#email").val();
    var pass = $("#pass").val();
    var cpass = $("#cpass").val();
    this.disabled=true;
    this.value='Registering, please wait...';
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
            console.log(data);
            window.location.replace("login.html");
        }
    });
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