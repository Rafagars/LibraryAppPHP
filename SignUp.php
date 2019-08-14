<?php
require_once "pdo.php";
require_once "check.php";

session_start();

unset($_SESSION['username']);

if (isset($_POST['cancel'])){
    //Redirect the browser to index.php
    header("Location: index.php");
    return;
}

if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['copassword'])){
    if (strlen($_POST['username']) < 1 || strlen($_POST['email']) < 1 || strlen($_POST['password']) < 1 || strlen($_POST['copassword']) < 1){
        $_SESSION['error'] = "Don't leave any fields blank";
        header("Location: SignUp.php");
        return;
    }
    elseif (strpos($_POST['email'], '@') === false){
        $_SESSION['error'] = "Email must have an at-sign (@)";
        header("Location: SignUp.php");
        return;
    }
    //This one practically does nothing but anyway I keep it
    elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Email is not valid!';
        header("Location: SignUp.php");
        return;
    }
    elseif (strlen($_POST['password']) < 6 || strlen($_POST['password']) > 20){
        $_SESSION['error'] = "Password must be between 5 and 20 characters long!";
        header("Location: SignUp.php");
        return;
    }
    elseif ($_POST['password'] !== $_POST['copassword']){
        $_SESSION['error'] = "Both Passwords must be equals";
        header("Location: SignUp.php");
        return;
    }
    else {

        /*Functions to check is the username or the email have been already used */

        $emailCheck = check_email($_POST['email'], $pdo);
        //$userCheck = check_username($_POST['name'], $pdo);

        /* If the email or the username are already in the database
           Redirect to SignUp.php and show the error message
           Else, insert all the values in the database. */

        if ($emailCheck === true) {
            header("Location: SignUp.php");
            return;
        }


        else {
            $stmt = $pdo->prepare('INSERT INTO users (username, email, pass) VALUES (:name, :email, :pass)');
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt->execute(array(
                ':name' => $_POST['username'],
                ':email' => $_POST['email'],
                ':pass' => $password
            ));

            $_SESSION['success'] = "Signing up successful";

            $stmt = $pdo->prepare('SELECT user_id FROM users WHERE username = :name');
            $stmt->execute(array(
                ':name' => $_POST['username']
            ));

            $id = $stmt->fetch(PDO::FETCH_ASSOC);

            $_SESSION['user_id'] = $id['user_id'];
            $_SESSION['username'] = $_POST['username'];
            header("Location: myLibrary.php");
            return;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Sign Up </title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>

<body>
<header>
    <nav id="header-nav" class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a href="index.php" class="pull-left visible-md visible-lg">
                    <img id="logo-img" src="img/Logo.png" alt="Logo">
                </a>
            </div>

            <div class="navbar-brand">
                <a href="index.php"><h1>LibraryApp</h1></a>
            </div>

        </div>
    </nav>
</header>


<div class="register body-content">
    <h1> Sign Up </h1>

    <?php
    if ( isset($_SESSION['error']) ){
        echo('<p style="color: red;" class="text-center">' . htmlentities($_SESSION['error']) . "</p>\n");
        unset($_SESSION['error']);
    }

    if (isset($_SESSION['success'])){
        //Useless message but I decided to keep it, just in case.
        echo ('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
        unset($_SESSION['success']);
    }
    ?>

    <form method="post">

        <label for="email">
            <i class="fas fa-envelope"></i>
        </label>
        <input type="text" name="email" placeholder="Email">

        <label for="username">
            <i class="fas fa-user"></i>
        </label>
        <input type="text" name="username" placeholder="Username">

        <label for="password">
            <i class="fas fa-lock"></i>
        </label>
        <input type="password" name="password" placeholder="Password">

        <label for="copassword">
            <i class="fas fa-lock"></i>
        </label>
        <input type="password" name="copassword" placeholder="Confirm Password">

        <input type="submit" value="Sign Up" class="btn-success">
        <input type="submit" value="Cancel" name="cancel" class="btn-danger">
    </form>
</div>

<footer class="panel-footer navbar navbar-default navbar-fixed-bottom">
    <div class="container">
        <div class="row">
            <p> Rafael Garcia &copy; 2019 </p>
        </div>
    </div>
</footer>

</body>
</html>