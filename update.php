<?php
	require_once 'pdo.php';

	$error = "";

	if(isset($_POST['title']) && isset($_POST['author']) && isset($_POST['pages']) && isset($_POST['beenRead'])){ 
		if (strlen($_POST['title']) < 1 || strlen($_POST['author']) < 1 || strlen($_POST['pages']) < 1) {
			$error = "Don't leave any field blank";
			header("Location: index.php");
			return;
		} else {
			$update = $pdo->prepare("UPDATE Books SET title = :title, author = :author, pages = :pages, beenRead = :beenRead WHERE id = :id");

			$update->execute(array(
				':title' => $_POST['title'],
				':author' => $_POST['author'],
				':pages' => $_POST['pages'],
				':beenRead' => $_POST['beenRead'],
				':id' => $_GET['id']
			));

			header("Location: index.php");
			return;
		}
	}	

		if (isset($_POST['cancel'])) {
					header("Location: index.php");
					return;
				}		

 ?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Library Edit</title>
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
                <a href="#"><h1> LibraryApp </h1></a>
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

<div id="edit-message" class="container-fluid text-center body-content">
    <div class="inside_content">
 		<?php echo '<h4 style="color: red;">' . $error . "</h4>"; ?>

		<form method="post">
			Title: <input type="text" name="title">
			Author: <input type="text" name="author">
			Pages: <input type="number" name="pages">
            Have you read it? <input type="radio" name="beenRead" value="Yes"> Yes
            <input type="radio" name="beenRead" value="No"> No
			<input type="submit" name="edit" value="Edit">
			<input type="submit" name="cancel" value="cancel">
		</form>
    </div>
</div>

<footer class="panel-footer">
    <div class="container">
        <div class="row">
            <p> Rafael Garcia &copy; 2019 </p>
        </div>
    </div>
</footer>
 </body>
 </html>