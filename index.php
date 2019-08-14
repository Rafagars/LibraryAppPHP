<?php
    require_once "pdo.php";

    session_start();

    if (isset($_SESSION['username'])){
    //If the user has already login then will be redirect to his Library
        header("Location: myLibrary.php");
        return;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LibraryApp</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
    <nav id="header-nav" class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a href="#" class="visible-md visible-lg">
                    <!--<img id="logo-img" src="img/Logo.png">-->
                </a>
            </div> <!-- end of navbar-header -->

            <div class="navbar-brand">
                <a href="#"><h1> LibraryApp</h1></a>
            </div>

            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapsable-nav" aria-expanded="false">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>


            <div id="collapsable-nav" class="collapse navbar-collapse">
                <ul id="nav-list" class="nav navbar-nav navbar-right">
                    <li><a id="login" class="glyphicon glyphicon-log-in" href="login.php"> Login </a></li>
                    <li><a id="signup" class="glyphicon glyphicon-user" href="SignUp.php"> Sign Up </a></li>
                </ul>
            </div> <!-- end of collapsable nav -->
        </div> <!-- end of container -->
    </nav>
</header>

<div  class="container body-content">
    <img id="welcome-img" class="center-block" src="https://www.firstmesquiteumc.org/wp-content/uploads/2016/10/welcome.png" width="100%">
</div>


<footer class="panel-footer navbar navbar-default navbar-fixed-bottom">
    <div class="container">
        <div class="row">
            <p> Rafael Garcia &copy; 2019 </p>
        </div>
    </div>
</footer>

<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>