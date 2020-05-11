<!DOCTYPE html>
<?php
    include_once './config/database.php';
    $databaseService = new DatabaseService();
    $conn = $databaseService->getConnection();
    $table_name = 'Users';
?>

<html>
<head>
    <title>ProjectCookie > Passowrd Recovery</title>
    <link href="../css/style.css" type="text/css" rel="stylesheet" />
</head>
<body>
    <div id="header">
        <h3>ProjectCoookie > Passowrd Recovery</h3>
    </div>
    <div id="wrap">
        <?php
            if (isset($_GET['validator']) && !empty($_GET['validator'])) {
                $validator = $_GET['validator'];
                echo $validator; ?>
                    <form method="post" action="reset_process.php">
                        <input type="hidden" name="validator" value="<?php echo $validator ?>"> <br>
                        New Password <input type="text" name="newpass"> <br>
                        Confirm Password <input type="text" name="confpass"> <br>
                        <input type="submit" name="submit" value="Change Passowrd"><br>
                    </form>
                <?php
            }
        ?>
    </div>
</body>
</html>
