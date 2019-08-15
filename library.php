<?php
    require_once 'pdo.php';

    session_start();

    $stmt = $pdo->prepare('SELECT * FROM Books WHERE user_id = :user_id');

    $stmt->execute(array(
        'user_id' => $_GET['user_id']
    ));

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT username FROM users WHERE user_id = :user_id");

    $stmt->execute(array(
        'user_id' => $_GET['user_id']
    ));

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>LibraryApp</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

    <header>
    <nav id="header-nav" class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a href="#" class="visible-md visible-lg">
                    <!--<img id="logo-img" src="img/Logo.png" alt="Logo">-->
                </a>
            </div> <!-- end of navbar-header -->

            <div class="navbar-brand">
                <a href="index.php"><h1> LibraryApp </h1></a>
            </div>

            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapsable-nav" aria-expanded="false">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>


            <div id="collapsable-nav" class="collapse navbar-collapse">
                <ul id="nav-list" class="nav navbar-nav navbar-right">
                    <li><a id="logout" class="glyphicon glyphicon-log-out" href="logout.php"> Logout </a></li>
                </ul>
            </div> <!-- end of collapsable nav -->
        </div> <!-- end of container -->
    </nav>
</header>

<div class="container text-center">

    <?php
        echo '<h1 class="userLibrary">'. htmlentities($user['username']) . " Library</h1>";
    ?>

    <div id="booksDiv">
        <table id="booksTable" class="table">
            <tr class="categories">
                <th>Title</th>
                <th>Author</th>
                <th>Pages</th>
                <th> Been read </th>
            </tr>
            <?php
            foreach($rows as $row){
                echo('<tr class="categories">');
                echo('<th>' . htmlentities($row['title']) . "</th>" );
                echo('<th>' . htmlentities($row['author']) . '</th>');
                echo('<th>' . htmlentities($row['pages']) . '</th>');
                echo('<th>' . htmlentities($row['beenRead']) . '</th>');
                echo("</tr>");
            }
            ?>
        </table>
    </div>
</div>
</body>
</html>