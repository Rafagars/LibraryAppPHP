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
	<title>Delete Entry</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>

<p class="text-center">
	<form method="post">
		<h3>Are you sure that you what to delete this entry? </h3>
		<input type="submit" name="yes" value="Yes">
		<input type="submit" name="no" value="No">
	</form>
</p>

</body>
</html>