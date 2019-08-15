<?php
	require_once 'pdo.php';

	if (isset($_POST['yes'])) {
		$delete = $pdo->prepare("DELETE FROM Books where id = :id");
		$delete->execute(array(
			':id' => $_GET['id']
		));
		header("Location: index.php");
		return;
	} else if (isset($_POST['no'])) {
		header("Location: index.php");
		return;
	}


 ?>

<!DOCTYPE html>
<html>
<head>
    <title>My Library delete</title>
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
                    <li><a id="login" class="glyphicon glyphicon-log-out" href="logout.php"> Logout </a></li>
                </ul>
            </div> <!-- end of collapsable nav -->
        </div> <!-- end of container -->
    </nav>
</header>

<div class="container text-center">
<p id="delete-message">
	<form method="post">
		<h3>Are you sure that you what to delete this entry? </h3>
		<input type="submit" name="yes" value="Yes">
		<input type="submit" name="no" value="No">
	</form>
</p>
</div>
</body>
</html>