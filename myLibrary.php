<?php
    require_once 'pdo.php';

    session_start();

    $error = "";

    if (!isset($_SESSION['username'])){
        //If the user has already login then will be redirect to his Library
        header("Location: index.php");
        return;
    }

    if (isset($_POST['search-bar'])){
        if (strlen($_POST['search-bar']) < 1){
            header("Location: myLibrary.php");
            return;
        } else {
            header("Location: search.php?search=".htmlentities($_POST['search-bar'])."&user_id=".htmlentities($_SESSION['user_id']));
            return;
        }
    }

    if(isset($_POST['title']) && isset($_POST['author']) && isset($_POST['pages']) && isset($_POST['beenRead'])){

        if (strlen($_POST['title']) < 1 || strlen($_POST['author']) < 1 || strlen($_POST['pages']) < 1) {
            $error = "Don't leave any field blank";
            header("Location: index.php");
            return;
        } else {
            $insert = $pdo->prepare('INSERT INTO Books(title, author, pages, beenRead, user_id) VALUES (:title, :author, :pages, :beenRead, :user_id)');
            $insert->execute(array(
                ':title' => $_POST['title'],
                ':author' => $_POST['author'],
                ':pages' => $_POST['pages'],
                ':beenRead' => $_POST['beenRead'],
                ':user_id' => $_SESSION['user_id']
            ));
            header("Location: index.php");
            return;
        }
    }

    $stmt = $pdo->prepare('SELECT * FROM Books WHERE user_id = :user_id');

    $stmt->execute(array(
        'user_id' => $_SESSION['user_id']
    ));

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare('SELECT user_id, username FROM users');

    $stmt->execute();

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Library</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

<header>
    <nav id="header-nav" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="#" class="visible-md visible-lg">
                    <img id="logo-img" src="https://image.flaticon.com/icons/png/512/562/562132.png">
                </a>
            </div> <!-- end of navbar-header -->

            <div class="navbar-brand">
                <a href="#"><h1> LibraryApp </h1></a>
            </div>

            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapsable-nav" aria-expanded="false">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <div id="collapsable-nav" class="collapse navbar-collapse">
                <ul id="nav-list" class="nav navbar-nav navbar-right">
                    <li>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="otherLibraries" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Other Libraries
                            </button>
                            <div id="otherLibraries" class="dropdown-menu">
                                <?php
                                foreach($users as $user){
                                    echo ('<a class="libaries dropdown-item" href="library.php?user_id='.$user['user_id']. '">
                                     <span>'. $user['username']. " Library</span></a>");
                                }
                                ?>
                            </div>
                    </li>
                    <li id="search" class="pull-right"><form method="post"><input type="text" name="search-bar"> <input type="submit" name="search" value="Search"></form></li>
                    <li class="pull-right"><a id="logout" class="glyphicon glyphicon-log-out" href="logout.php"> Logout </a></li>
                </ul>
            </div> <!-- end of collapsable nav -->
        </div> <!-- end of container -->
    </nav>
</header>

<div class="container-fluid text-center body-content">
    <div class="inside_content">

    <?php
    echo '<h1 class="userLibrary">'. htmlentities($_SESSION['username']) . " Library</h1>";
    echo '<h4 style="color: red;">' . $error . "</h4>";
    ?>

    <button id="addBook"> Add new book </button>

    <br>

    <form id="bookForm" method="post">
        Title: <input type="text" name="title">
        Author: <input type="text" name="author">
        <span id="pages">Pages: </span><input type="text" name="pages">
        Have you read it? <input type="radio" name="beenRead" value="Yes"> Yes
        				  <input type="radio" name="beenRead" value="No"> No
        <input type="submit" name="add" value="Add">
    </form>

    <br>

    <div id="booksDiv">
        <table id="booksTable" class="table">
            <tr class="categories">
                <th>Title</th>
                <th>Author</th>
                <th>Pages</th>
                <th> Read it </th>
                <th> Edit </th>
                <th> Delete </th>
            </tr>
            <?php
            foreach($rows as $row){
                echo('<tr class="categories">');
                echo('<th>' . htmlentities($row['title']) . "</th>" );
                echo('<th>' . htmlentities($row['author']) . '</th>');
                echo('<th>' . htmlentities($row['pages']) . '</th>');
                echo('<th>' . htmlentities($row['beenRead']) . '</th>');
                echo('<th><button class="btn-success"><a href="update.php?id='. $row['id'] .'"> Edit </a></button></th>');
                echo('<th><button class="btn-danger"><a href="delete.php?id='. $row['id'] .'"> Delete </a></button></th>');
                echo("</tr>");
            }
            ?>
        </table>
    </div>
</div>

</div>

<footer class="panel-footer">
    <div class="container">
        <div class="row">
            <p> Rafael Garcia &copy; 2019 </p>
        </div>
    </div>
</footer>

<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>

</body>
</html>
