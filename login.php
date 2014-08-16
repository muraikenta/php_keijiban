<?php
	session_start();
	$user_name = $_POST["user_name"];
	$user_password = $_POST["password"];

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


	// データベースからデータを取り出す
	$stmt = $dbh->prepare("SELECT name FROM user WHERE name=? AND password=?");
	$data[] = $user_name;
	$data[] = md5($user_password);
	$stmt->execute($data);
	$rec = $stmt->fetch(PDO::FETCH_ASSOC);
	// データベースとの接続を切る
	$dbh = null;

	if ($rec == false) {
		echo "ユーザー名かパスワードが間違っています。";
		echo '<a href="keijiban.php"></a>';
	}else{
		$_SESSION['login'] = 1;
		$_SESSION['name'] = $user_name;
		header('Location: keijiban.php');
	}
 ?>