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
 	<title>Edit book</title>
 </head>
 <body>
 
 		<?php echo '<h4 style="color: red;">' . $error . "</h4>"; ?>

		<form method="post">
			Title: <input type="text" name="title">
			Author: <input type="text" name="author">
			Pages: <input type="text" name="pages">
			Have you read it? <input type="text" name="beenRead">
			<input type="submit" name="edit" value="Edit">
			<input type="submit" name="cancel" value="cancel">
		</form>

 </body>
 </html>