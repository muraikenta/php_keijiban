<?php
	session_start();
	$user_name = $_POST['user_name'];
	$user_password = $_POST['password'];
	if (!empty($user_name) && !empty($user_password))
	{
		// データベース接続
		$dsn = "mysql:dbname=keijiban;host=localhost";
		$user = "root";
		$password = "root";
		try {
			$dbh = new PDO($dsn,$user,$password);
			$dbh->query("SET NAMES UTF-8");
		} catch (PDOException $e) {
			var_dump($e->getMessage());
			exit;
		}

	// データベースへの挿入
	$stmt = $dbh->prepare('INSERT INTO user(name,password) VALUES(\''.$user_name.'\',\''.md5($user_password).'\')');
	$stmt->execute();

	$dbh = null;
	$_SESSION['login'] = 1;
	$_SESSION['name'] = $user_name;
	header('Location: keijiban.php');
	}

 ?>

<!DOCTYPE html>
 <html>
 <head>
 	<title>ユーザー新規登録</title>
 	<meta charset="UTF-8">
 </head>
 <body>
 	<h1>新規ユーザー登録</h1>
 	<form action="" method="post">
 		ユーザー名：<input type="text" name="user_name"><br>
 		パスワード：<input type="password" name="password"><br>
 		<input type="submit" value="送信">
 	</form>
 </body>
 </html>