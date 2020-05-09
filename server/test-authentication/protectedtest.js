$(document).ready(function () {
    $("#logout").click(logoutTest);
    checkLogin();
})

function logoutTest() {
    $.ajax({
        type: 'POST',
        url: 'api/logout.php',
        data: {
            },
        success: function (data) {
            console.log(data);
            checkLogin();
        },
    });
}

function checkLogin() {
    var jwt = getCookie("jwt");
    $.ajax({
        type: 'POST',
        url: 'api/protected.php',
        "headers": {
            "Authorization": "JWT " + jwt,
            "Content-Type": "application/json"
        },
        data: {
            },
        success: function (data, statusText, xhr) {
            if(xhr.status == 200) {
                $("#mess").html(data);
                console.log(statusText);
            } else {
                window.location.replace("login.html");
            }
            //$("#limiter").html("message: "+data['message']);
        },
        error: function(httpObj, textStatus) {       
            if(httpObj.status==200) {
                console.log(textStatus);
            }
            else {
                window.location.replace("login.html");
            }
        }
    });
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
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