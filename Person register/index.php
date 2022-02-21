<?php
session_start();

require_once 'vendor/autoload.php';

use Doctrine\DBAL\DriverManager;

$connectionParams = array(
    'dbname' => 'PersonRegister',
    'user' => 'root',
    'password' => 'maikls123',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
);
$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);

if (isset($_POST["submit"])) {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $code = $_POST['code'];

    $user = [
        "name" => $name,
        "surname" => $surname,
        "code" => $code
    ];

    $conn->insert('users', $user);
}
$userDatabase = $conn->fetchAllAssociative('SELECT * FROM users');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Person register</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
</head>

<body>
    <div class="Header">
        <h1>PERSON REGISTER</h1>
    </div>

    <form method="post">
        <input type="text" name="name" placeholder="Name">
        <input type="text" name="surname" placeholder="Surname">
        <input type="text" name="code" placeholder="Code">
        <br>
        <button type="submit" name="submit">Register a person</button>
    </form>

    <div class="table">
        <fieldset>
            <legend>Registered persons</legend>
            <table>
                <thead>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Code</th>
                </thead>

                <tbody>

                    <?php foreach ($userDatabase as $data): ?>

                    <tr>
                        <td><?php echo $data["name"];?></td>
                        <td><?php echo $data["surname"];?></td>
                        <td><?php echo $data["code"];?></td>
                    </tr>

                    <?php endforeach ?>
                </tbody>

            </table>
        </fieldset>
    </div>


</body>

</html>