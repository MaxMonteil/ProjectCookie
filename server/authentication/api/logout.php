<?php
    setcookie('jwt', null, time() - 3600, "/");
    setcookie('email', null, time() - 3600, "/");

    session_destroy();
?>