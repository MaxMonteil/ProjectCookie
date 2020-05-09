$(document).ready(function () {
    $("#submit").click(checkLogin);
    checkLogin2();
})
function checkLogin2() {
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
                console.log(statusText);
            } else {
                window.location.replace("login.html");
            }
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

function checkLogin() {
    var jwt = getCookie("jwt");
    var oldpass = $("#oldpass").val();
    var newpass = $("#pass").val();
    var confnewpass = $("#confirmpass").val();
    $.ajax({
        type: 'POST',
        url: 'api/changepass.php',
        data: {
                "oldpass": oldpass,
                "newpass": newpass,
                "confnewpass": confnewpass
            },
        success: function (data, statusText, xhr) {
            if(xhr.status == 200) {
                console.log(statusText);
                console.log(data);
                window.location.replace("protectedtest.html");
            } else {
                window.location.replace("login.html");
            }
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