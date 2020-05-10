$(document).ready(function () {
    $("#submit").click(checkLogin);
})

function checkLogin() {
    var email = $("#email").val();
    var pass = $("#pass").val();
    $.ajax({
        type: 'POST',
        url: 'api/login.php',
        data: {
            "email": email,
            "password": pass
        },
        success: function (data) {
            console.log(data);
            var verified = getCookie("verification");
            if (verified == "0") {
                $("#verified").html('Your account has been made, <br /> please verify it by clicking the activation link that has been send to your email.');
            } else {
                window.location = "protectedtest.html";
            }
        }
    });
}

// get or read cookie
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }

        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}