<?php
require_once "pdo.php";

session_start();

if ( isset($_POST['cancel']) ){
    //Redirect the browser to index.php
    header("Location: index.php");
    return;
}

if (isset($_POST['email']) && isset($_POST['password'])){

    unset($_SESSION['name']);

    if (strlen($_POST['email']) < 1 || strlen($_POST['password']) < 1){
        $_SESSION['error'] = "Email and password are required";
        header("Location: login.php");
        return;
    }
    elseif (strpos($_POST['email'], '@') === false){
        $_SESSION['error'] = "Email must have an at-sign (@)";
        header("Location: login.php");
        return;
    }
    else{
        $sql = "SELECT user_id, username, pass FROM users WHERE email = :em";

        echo "<p>$sql</p>\n";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':em' => $_POST['email']
        ));

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //If the password the user introduce is the same that the one
        //on the database the browser redirect the user to chat.php
        //if not an error message will show up saying that the password
        //was incorrect

        if(password_verify($_POST['password'], $row['pass'])){
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['name'] = $row['username'];


            header("Location: myLibrary.php");
            return;
        }
        else{
            $_SESSION['error'] = "Incorrect password";
            header("Location: login.php");
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
    <title> Login </title>
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
                <a href="index.php"><h1> LibraryAPP</h1></a>
            </div>

        </div> <!-- end of container -->
    </nav>
</header>

<div class="container body-content">
    <div class="login">
        <h1> Login </h1>
        <?php
        if (isset($_SESSION['error'])){
            //Error message if the user makes a mistake
            echo('<p style="color: red;" class="text-center">' . htmlentities($_SESSION['error']) . "</p>\n");
            unset($_SESSION['error']);
        }
        ?>
        <form  method="post">
            <label for="email">
                <i class="fas fa-user"></i>
            </label>
            <input type="text" name="email" placeholder="Email">

            <label for="password">
                <i class="fas fa-lock"></i>
            </label>
            <input type="password" name="password" placeholder="Password">

            <input type="submit" value="Login" class="btn-success">
            <input type="submit" name="cancel" value="Cancel" class="btn-danger">
        </form>
    </div>
</div>

<footer class="panel-footer navbar navbar-fixed-bottom">
    <div class="container">
        <div class="row">
            <p> Rafael Garcia &copy; 2019 </p>
        </div>
    </div>
</footer>

</body>
</html>