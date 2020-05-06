<?php
    setcookie('jwt', null, time() - 3600, "/");
    setcookie('email', null, time() - 3600, "/");

    echo $_COOKIE["jwt"];
    echo $_COOKIE["email"];
?>