<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <div>
        <ul>
            <?php
                if (isset($_SESSION["userid"])) {
                    ?>
            <li><a href="#"><?php echo $_SESSION["useruid"]; ?></a></li>
            <li><a href="includes/logout.inc.php" class="header-login-a">LOGOUT</a></li>
            <?php
                } else {
                    ?>
            <li><a href="#">SIGN UP</a></li>
            <li><a href="#" class="header-login-a">LOGIN</a></li>
            <?php
                }
            ?>

        </ul>

        <div class="index-login-signup">
            <h4>SIGN UP</h4>
            <form action="includes/signup.inc.php" method="post">
                <input type="text" name="uid" placeholder="Username">
                <input type="password" name="pwd" placeholder="Password">
                <input type="password" name="pwd-repeat" placeholder="Repeat Password">
                <input type="text" name="email" placeholder="E-mail">
                <br>
                <button type="submit" name="submit">SIGN UP</button>
            </form>
        </div>
        <div class="index-login-login">
            <h4>LOGIN</h4>
            <form action="includes/login.inc.php" method="post">
                <input type="text" name="uid" placeholder="Username">
                <input type="password" name="pwd" placeholder="Password">
                <br>
                <button type="submit" name="submit">LOGIN</button>
            </form>
        </div>
    </div>
</body>

</html>