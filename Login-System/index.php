<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200&family=Quicksand:wght@300&display=swap"
        rel="stylesheet">
    <title>Login</title>
    <style>
    * {
        font-family: 'Quicksand', sans-serif;
    }

    body {
        background: rgb(242, 92, 92);
        background: linear-gradient(180deg, rgba(242, 92, 92, 1) 0%, rgba(242, 178, 141, 1) 100%);
        background-repeat: no-repeat;
        background-attachment: fixed;
    }

    h4 {
        font-weight: bolder;
        color: #fffdf5;
    }

    ul {
        list-style-type: none;
    }

    li {
        float: left;
        padding-left: 15px;

    }

    a {
        font-weight: bolder;
    }

    a:link,
    a:visited {
        text-decoration: none;
        color: aliceblue;
    }

    a:hover {
        color: blueviolet;
        transition: .2s;
    }

    button {
        border: none;
        border-radius: 4px;
        background-color: #F2786D;
        width: 80px;
        margin: auto;
    }

    button:hover {
        background-color: #F25C5C;
        transition: .2s;
    }

    .index-login-signup,
    .index-login-login {
        padding: 20px;
        border: 1px;
        border-radius: 5%;
        margin: auto;
        width: 200px;
        background-color: #F2B28D;
        box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px;
        margin-top: 5px;

    }
    .welcome-text{
        margin: auto;
        width: auto;
        text-align: center;
        padding-top: 350px;
        color: #F25C5C;
        font-size: 40px;
    }


    input {
        padding: 5px;
        margin: 1px 0;
        display: inline-block;
        border: 2px solid #F2786D;
        border-radius: 8px;
        box-sizing: border-box;
    }
    </style>
</head>

<body>
    <div class="main-ui">
        <div class="ui-login-signup">
            <ul>
                <?php
                if (isset($_SESSION["userid"])) {
                    ?>
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
        </div>

        <?php
        if (isset($_SESSION["userid"])) {
            ?>
        <div class="welcome-text">
            <h1>You are logged in as <?php echo $_SESSION["useruid"]; ?>!</h1>
        </div>
        <?php
        } else {
            ?>

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
        <?php
        }
            ?>
    </div>
</body>

</html>