$(document).ready(function () {
    $("#submit").click(checkLogin);
})

function checkLogin() {
    var email = $("#email").val();
    this.disabled=true;
    this.value='Sending, please wait...';
    $.ajax({
        type: 'POST',
        url: 'api/forgotemail.php',
        data: {
            "email": email,
        },
        success: function (data) {
            console.log(data);
            window.location.replace("login.html");
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