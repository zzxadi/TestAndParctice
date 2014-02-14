<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>MySQL Connection</title>
</head>
<body>
	<div class="container">
		<h2>Connect MySQL</h2>
		<?php
		  //Connect to the database
		  $dbc = mysqli_connect('localhost:8088', 'root', 'zzx@654', 'test');

		  $query = "selct * form user";

		  $result = mysqli_query($dbc, $query);

		  echo '<table><tr><th>username</th><th>age</th></tr>';
		  while( $row = mysql_fetch_array($result) ){
		  	echo '<tr><td>' . $row['username'] . '</td><td>' . $row['age'] . '</td><tr>';
		  }
		  echo '</table>';
		  
		  mysqli_close($dbc);
		?>
	</div>
</body>
</html>