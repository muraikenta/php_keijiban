<?php
	session_start();
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time() - 42000);
	}

 ?>



<!DOCTYPE html>
 <html>
 <head>
 	<title>ログアウト</title>
 	<meta charset="UTF-8">
 </head>
 <body>
 		<h2>ログアウトしました</h2>
 		<a href="keijiban.php">掲示板に戻る</a>
 </body>
 </html>