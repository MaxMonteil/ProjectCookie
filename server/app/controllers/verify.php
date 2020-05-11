<!DOCTYPE html>

<html>
<head>
    <title>ProjectCookie > Sign up</title>
    <link href="../css/style.css" type="text/css" rel="stylesheet" />
</head>
<body>
    <!-- start header div -->
    <div id="header">
        <h3>ProjectCoookie > Sign up</h3>
    </div>
    <!-- end header div -->

    <!-- start wrap div -->
    <div id="wrap">
        <!-- start PHP code -->
        <?php
            include_once './config/database.php';
            $databaseService = new DatabaseService();
            $conn = $databaseService->getConnection();
            $table_name = 'Users';

            if (isset($_GET['email']) && !empty($_GET['email']) && isset($_GET['hash']) && !empty($_GET['hash'])) {
                $email = $_GET['email'];
                $hash = $_GET['hash'];
                // Verify data
                $query = "SELECT email, hash, verified FROM " . $table_name . " WHERE email='".$email."' AND hash='".$hash."' AND verified='0'";

                $stmt = $conn->prepare($query);
                $stmt->execute();
                $num = $stmt->rowCount();

                if ($num > 0) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $emailSQL = $row['email'];
                    $hashSQL = $row['hash'];
                    $verified = $row['verified'];
                    if ($hash == $hashSQL && $email == $emailSQL && $verified == "0") {
                        $query2 = "UPDATE " . $table_name . "
                        SET `verified`=1 WHERE email = :email";
                        $stmt = $conn->prepare($query2);
                        $stmt->bindParam(':email', $email);
                        if ($stmt->execute()) {
                            echo '<div class="statusmsg">Your account has been activated, you can now login</div>';
                        } else {
                            echo '<div class="statusmsg">The url is either invalid or you already have activated your account.</div>';
                        }
                    } else {
                        echo '<div class="statusmsg">The url is either invalid or you already have activated your account.</div>';
                    }
                } else {
                    echo '<div class="statusmsg">The url is either invalid or you already have activated your account.</div>';
                }
            } else {
                // Invalid approach
                echo '<div class="statusmsg">Invalid approach, please use the link that has been send to your email.</div>';
            }// Invalid approach
        ?>
        <!-- stop PHP Code -->


    </div>
    <!-- end wrap div -->
</body>
</html>
