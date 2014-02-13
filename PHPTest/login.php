<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login PHP</title>
</head>
<body>
	<?php
		$username = $_POST['username'];
		$password = $_POST['password'];

		echo "username: " . $username . "<br /> pasword: " . $password;
	?>
</body>
</html>