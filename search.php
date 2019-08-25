<?php
    require_once "pdo.php";

    session_start();

    $stmt = $pdo->prepare("SELECT * FROM Books WHERE (title LIKE '%".htmlentities($_GET['search'])."%' OR author LIKE '%".htmlentities($_GET['search'])."%') AND user_id = :user_id");

    $stmt->execute(array(
        ':user_id' => $_GET['user_id']
    ));

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Search</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

<header>
    <nav id="header-nav" class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a href="#" class="visible-md visible-lg">
                    <img id="logo-img" src="https://image.flaticon.com/icons/png/512/562/562132.png">
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
                    <li id="search" class="pull-right"><form method="post"><input type="text" name="search-bar"> <input type="submit" name="search" value="Search"></form></li>
                    <li class="pull-right"><a id="logout" class="glyphicon glyphicon-log-out" href="logout.php"> Logout </a></li>
                </ul>
            </div> <!-- end of collapsable nav -->
        </div> <!-- end of container -->
    </nav>
</header>

<div class="container-fluid text-center body-content">
    <div class="inside_content">

        <h1 class="userLibrary"> <?php echo('Search:'." ". htmlentities($_GET['search'])); ?></h1>

        <div id="booksDiv">
            <table id="booksTable" class="table">
                <tr class="categories">
                    <th>Title</th>
                    <th>Author</th>
                    <th>Pages</th>
                    <th> Been read </th>
                </tr>
                <?php foreach($rows as $row): ?>
                    <tr class="categories">
                        <th> <?php echo htmlentities($row['title']) ; ?></th>
                        <th> <?php echo htmlentities($row['author']); ?></th>
                        <th> <?php echo htmlentities($row['pages']) ; ?></th>
                        <th> <?php echo htmlentities($row['beenRead']); ?></th>
                    </tr>
                <?php endforeach; ?>
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

</body>
</html>
