<?php
if ('POST' === $_SERVER['REQUEST_METHOD']) {
    include_once './config/database.php';
    $databaseService = new DatabaseService();
    $conn = $databaseService->getConnection();
    $table_name = 'Users';

    $token = $_POST['validator'];
    $password = $_POST['newpass'];

    if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[!@#$%^&*])[0-9A-Za-z!@#$%^&*]{8,}$/", $password)) {
        print "Invalid password submitted (Should contain at least one small letter, one capital letter, one number, and one of the following (!@#$%^&*) symbols).";
        return;
    }

    // Store the cipher method
    $ciphering = "AES-128-CTR";
  
    // Use OpenSSl Encryption method
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;

    // Non-NULL Initialization Vector for encryption
    $decryption_iv = '1234567891011121';
    
    // Store the encryption key
    $decryption_key = "000102030405060708090a0b0c0d0e0f";

    $decryption = openssl_decrypt(
        $token,
        $ciphering,
        $decryption_key,
        $options,
        $decryption_iv
    );

    $ar = explode("%;;;%", $decryption);

    $email = $ar[0];
    $expiry = $ar[1];

    if (intval($expiry) < time()) {
        echo "expired token";
        exit();
    }

    $query = "SELECT email FROM " . $table_name . " WHERE email='" . $email . "'";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $num = $stmt->rowCount();
    if ($num > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $query = "UPDATE " . $table_name . "
                        SET `password`=:hashpassword WHERE email = :email";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':hashpassword', $password_hash);

        if ($stmt->execute()) {
            echo '<div class="statusmsg">Your password has been changed!</div>';
        } else {
            echo '<div class="statusmsg">The url is either invalid.</div>';
        }
    } else {
        echo '<div class="statusmsg">2Invalid approach, please use the link that has been send to your email.</div>';
    }
}
