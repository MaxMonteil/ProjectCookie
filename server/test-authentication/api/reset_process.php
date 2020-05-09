<?php
if ('POST' === $_SERVER['REQUEST_METHOD']) {
    include_once './config/database.php';
    $databaseService = new DatabaseService();
    $conn = $databaseService->getConnection();
    $table_name = 'Users';

    $email = $_POST['email'];
    $validator = $_POST['validator'];
    $password = $_POST['newpass'];
    $confirmpassword = $_POST['confpass'];

    if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[!@#$%^&*])[0-9A-Za-z!@#$%^&*]{8,}$/", $password)) {
        print "Invalid password submitted (Should contain at least one small letter, one capital letter, one number, and one of the following (!@#$%^&*) symbols).";
        return;
    }
    if ($confirmpassword != $password) {
        print "Password do not match.";
        exit();
    }

    $query = "SELECT email, passhash, passhashexpire FROM " . $table_name . " WHERE email='" . $email . "' AND passhashexpire >= :time";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':time', time());
    $stmt->execute();
    $num = $stmt->rowCount();
    if ($num > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $hashSQL = $row['passhash'];
        $expire = $row['passhashexpire'];
        $calc = hash('sha256', hex2bin($validator));
        if (hash_equals($calc, $hashSQL)) {
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            $query = "UPDATE " . $table_name . "
                            SET `password`=:hashpassword, `passhash`=null, `passhashexpire`=null WHERE email = :email";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':hashpassword', $password_hash);

            if ($stmt->execute()) {
                echo '<div class="statusmsg">Your password has been changed!</div>';
        ?>
                <script>
                    window.location.replace("../login.html");
                </script>
<?php
            } else {
                echo '<div class="statusmsg">The url is either invalid.</div>';
            }
        } else {
            echo '<div class="statusmsg">1Invalid approach, please use the link that has been send to your email.</div>';
        }
    } else {
        echo '<div class="statusmsg">2Invalid approach, please use the link that has been send to your email.</div>';
    }
}
?>